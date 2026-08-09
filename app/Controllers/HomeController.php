<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Response;
use App\Core\Session;
use App\Models\Service;
use App\Models\Project;
use App\Models\Blog;
use App\Models\Team;
use App\Models\FAQ;
use App\Models\Message;
use App\Models\Newsletter;
use App\Models\Job;
use App\Models\Application;
use App\Models\Settings;
use App\Models\AuditLog;
use App\Models\Certificate;

/**
 * Handles General Public Pages
 */
class HomeController extends Controller {
    
    /**
     * Homepage
     */
    public function index(Request $request, Response $response): string {
        $services = Service::query("SELECT * FROM services WHERE status = 'published' LIMIT 6");
        $projects = Project::getAllPublished();
        // limit projects to 3
        $projects = array_slice($projects, 0, 3);
        $insights = Blog::getAllPublished();
        $insights = array_slice($insights, 0, 3);
        $team = Team::where('status', 'active', 'display_order ASC');
        $faqs = FAQ::where('status', 'active', 'display_order ASC');
        
        return $this->render('home/index', [
            'title' => 'Integrated Systems Efficiency Consults Limited',
            'services' => $services,
            'projects' => $projects,
            'insights' => $insights,
            'team' => $team,
            'faqs' => $faqs
        ]);
    }

    /**
     * About Us Page
     */
    public function about(Request $request, Response $response): string {
        $team = Team::where('status', 'active', 'display_order ASC');
        return $this->render('about/index', [
            'title' => 'About Us - Core Leadership, Mission & Values',
            'team' => $team
        ]);
    }

    /**
     * Insights & Blog Listing
     */
    public function insights(Request $request, Response $response): string {
        $type = $request->get('type'); // blog, case-study, whitepaper
        $category = $request->get('category'); // slug
        
        $insights = Blog::getAllPublished($type, $category);
        $categories = Blog::query("SELECT * FROM blog_categories ORDER BY name ASC");
        
        return $this->render('insights/index', [
            'title' => 'Insights, Case Studies & Research Publications',
            'insights' => $insights,
            'categories' => $categories,
            'selected_type' => $type,
            'selected_category' => $category
        ]);
    }

    /**
     * Insight Detail Page
     */
    public function insightDetail(Request $request, Response $response, array $params): string {
        $slug = $params['slug'] ?? '';
        $insight = Blog::getBySlugWithDetails($slug);
        
        if (!$insight) {
            $response->setStatusCode(404);
            return $this->render('errors/404', ['title' => 'Insight Not Found']);
        }
        
        $related = Blog::query("SELECT * FROM blogs WHERE status = 'published' AND id != :id ORDER BY published_at DESC LIMIT 3", ['id' => $insight['id']]);
        
        return $this->render('insights/detail', [
            'title' => $insight['title'] . ' - Insights',
            'insight' => $insight,
            'related' => $related,
            'metaDescription' => $insight['summary'] ?? '',
            'metaImage' => $insight['banner_image'] ?? ''
        ]);
    }

    /**
     * Careers Page
     */
    public function careers(Request $request, Response $response): string {
        $jobs = Job::where('status', 'open', 'id DESC');
        return $this->render('careers/index', [
            'title' => 'Careers & Graduate Internships',
            'jobs' => $jobs
        ]);
    }

    /**
     * Job Position Detail
     */
    public function jobDetail(Request $request, Response $response, array $params): string {
        $id = (int)($params['id'] ?? 0);
        $job = Job::find($id);
        
        if (!$job || $job['status'] !== 'open') {
            $response->setStatusCode(404);
            return $this->render('errors/404', ['title' => 'Position Not Found']);
        }
        
        return $this->render('careers/detail', [
            'title' => $job['title'] . ' - Vacancies',
            'job' => $job
        ]);
    }

    /**
     * Submit Job Application
     */
    public function apply(Request $request, Response $response, array $params): void {
        $jobId = (int)($params['id'] ?? 0);
        $job = Job::find($jobId);
        $session = new Session();
        
        if (!$job || $job['status'] !== 'open') {
            $session->setFlash('error', 'Job vacancy is no longer accepting applications.');
            $response->redirect('/careers');
        }

        $name = $request->get('name');
        $email = $request->get('email');
        $phone = $request->get('phone');
        $coverLetter = $request->get('cover_letter');
        
        // Handle CV Upload
        $file = $request->getFile('cv');
        $cvPath = '';
        
        if ($file && $file['error'] === UPLOAD_ERR_OK) {
            $allowed = ['pdf', 'doc', 'docx'];
            $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            
            if (in_array($ext, $allowed)) {
                $dir = PUBLIC_DIR . '/assets/uploads/cvs/';
                if (!is_dir($dir)) {
                    mkdir($dir, 0777, true);
                }
                $filename = uniqid('cv_', true) . '.' . $ext;
                if (move_uploaded_file($file['tmp_name'], $dir . $filename)) {
                    $cvPath = 'assets/uploads/cvs/' . $filename;
                }
            }
        }
        
        if (empty($name) || empty($email) || empty($phone) || empty($cvPath)) {
            $session->setFlash('error', 'Please fill all required fields and upload your resume in PDF/Doc format.');
            $response->redirect('/careers/' . $jobId);
        }
        
        Application::create([
            'job_id' => $jobId,
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'cv_path' => $cvPath,
            'cover_letter' => $coverLetter
        ]);
        
        $session->setFlash('success', 'Application submitted successfully! Our HR team will review your profile.');
        $response->redirect('/careers/' . $jobId);
    }

    /**
     * Gallery Page
     */
    public function gallery(Request $request, Response $response): string {
        $media = Blog::query("SELECT * FROM gallery ORDER BY id DESC");
        return $this->render('gallery/index', [
            'title' => 'Media & Corporate Gallery',
            'media' => $media
        ]);
    }

    /**
     * Downloads Section
     */
    public function downloads(Request $request, Response $response): string {
        $downloads = Blog::query("SELECT * FROM downloads ORDER BY title ASC");
        return $this->render('downloads/index', [
            'title' => 'Downloadable Capability Statement & Brochures',
            'downloads' => $downloads
        ]);
    }

    /**
     * Increments Download tracker counter
     */
    public function downloadTrack(Request $request, Response $response, array $params): void {
        $id = (int)($params['id'] ?? 0);
        $db = Blog::getDb();
        
        // Find download record
        $stmt = $db->prepare("SELECT * FROM downloads WHERE id = :id LIMIT 1");
        $stmt->execute(['id' => $id]);
        $download = $stmt->fetch();
        
        if ($download) {
            // Update counter
            $stmt = $db->prepare("UPDATE downloads SET download_count = download_count + 1 WHERE id = :id");
            $stmt->execute(['id' => $id]);
            
            // Redirect to file
            $response->redirect('/' . ltrim($download['file_path'], '/'));
        }
        
        $response->redirect('/downloads');
    }

    /**
     * Contact Us Page
     */
    public function contact(Request $request, Response $response): string {
        $faqs = FAQ::where('status', 'active', 'display_order ASC');
        return $this->render('contact/index', [
            'title' => 'Contact Us - Office Locations & Inquiries',
            'faqs' => $faqs
        ]);
    }

    /**
     * Handle contact message submission
     */
    public function contactSubmit(Request $request, Response $response): void {
        $name = $request->get('name');
        $email = $request->get('email');
        $phone = $request->get('phone');
        $company = $request->get('company');
        $country = $request->get('country');
        $service = $request->get('service_interested');
        $message = $request->get('message');
        
        $session = new Session();
        
        if (empty($name) || empty($email) || empty($message)) {
            $session->setFlash('error', 'Please fill in all required fields (Name, Email, and Message).');
            $response->redirect('/contact');
        }
        
        // Handle optional document attachments
        $file = $request->getFile('attachment');
        $attachmentPath = null;
        
        if ($file && $file['error'] === UPLOAD_ERR_OK) {
            $allowed = ['pdf', 'doc', 'docx', 'jpg', 'png', 'zip'];
            $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            
            if (in_array($ext, $allowed)) {
                $dir = PUBLIC_DIR . '/assets/uploads/attachments/';
                if (!is_dir($dir)) {
                    mkdir($dir, 0777, true);
                }
                $filename = uniqid('attachment_', true) . '.' . $ext;
                if (move_uploaded_file($file['tmp_name'], $dir . $filename)) {
                    $attachmentPath = 'assets/uploads/attachments/' . $filename;
                }
            }
        }
        
        Message::create([
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'company' => $company,
            'country' => $country,
            'service_interested' => $service,
            'message' => $message,
            'attachment_path' => $attachmentPath
        ]);
        
        // Send email notification to contact@isecltd.ng
        $mailService = htmlspecialchars_decode($service, ENT_QUOTES);
        $mailName = htmlspecialchars_decode($name, ENT_QUOTES);
        $mailCompany = htmlspecialchars_decode($company, ENT_QUOTES);
        $mailMessage = htmlspecialchars_decode($message, ENT_QUOTES);
        
        $emailSubject = "[Contact Inquiry] " . ($mailService ?: 'Custom Advisory') . " - " . $mailName;
        $emailBody = "<h3>New Technical Advisory Inquiry</h3>
                      <p><strong>Name:</strong> " . e($mailName) . "</p>
                      <p><strong>Email:</strong> " . e($email) . "</p>
                      <p><strong>Phone:</strong> " . e($phone) . "</p>
                      <p><strong>Company:</strong> " . e($mailCompany) . "</p>
                      <p><strong>Country:</strong> " . e($country) . "</p>
                      <p><strong>Service of Interest:</strong> " . e($mailService ?: 'General Inquiry') . "</p>
                      <p><strong>Message:</strong></p>
                      <p>" . nl2br(e($mailMessage)) . "</p>";
        
        if ($attachmentPath) {
            $emailBody .= "<p><strong>Attachment Document:</strong> <a href='" . BASE_URL . "/" . $attachmentPath . "' target='_blank' style='color: #4f46e5; font-weight: bold; text-decoration: underline;'>Download Attached Document</a></p>";
        }
        
        try {
            \App\Helpers\Mailer::send('info@isecltd.ng', 'contact@isecltd.ng', $emailSubject, $emailBody, $name);
        } catch (\Exception $e) {
            AuditLog::log(0, 'Inquiry Mail Notify Fail', 'Mail notify failed: ' . $e->getMessage());
        }
        
        $session->setFlash('success', 'Your inquiry has been successfully submitted! A consultant will contact you shortly.');
        $response->redirect('/contact');
    }

    /**
     * Newsletter Form
     */
    public function newsletterSubmit(Request $request, Response $response): void {
        $email = $request->get('email');
        $session = new Session();
        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $session->setFlash('error', 'Please provide a valid email address.');
            $response->redirect('/');
        }
        
        try {
            Newsletter::create([
                'email' => $email,
                'status' => 'active'
            ]);
            
            // Send email notification to info@isecltd.ng
            $emailSubject = "[Newsletter Subscription] " . $email;
            $emailBody = "<h3>New Newsletter Registration</h3>
                          <p>The email address <strong>" . e($email) . "</strong> has registered for systems bulletins and newsletter updates.</p>
                          <p><strong>Registration Date:</strong> " . date('Y-m-d H:i:s') . "</p>";
            
            try {
                \App\Helpers\Mailer::send('info@isecltd.ng', 'info@isecltd.ng', $emailSubject, $emailBody, 'ISEC Systems Center');
            } catch (\Exception $ex) {
                AuditLog::log(0, 'Newsletter Mail Notify Fail', 'Mail notify failed: ' . $ex->getMessage());
            }
            
            $session->setFlash('success', 'Thank you for subscribing to the ISEC newsletter!');
        } catch (\PDOException $e) {
            // Email might already exist
            $session->setFlash('success', 'You are already subscribed to our newsletter updates.');
        }
        
        $response->redirect('/');
    }

    /**
     * Privacy Policy Page
     */
    public function privacy(Request $request, Response $response): string {
        return $this->render('privacy', [
            'title' => 'Privacy Policy & Data Protection - ISEC'
        ]);
    }

    /**
     * Terms of Service Page
     */
    public function terms(Request $request, Response $response): string {
        return $this->render('terms', [
            'title' => 'Terms of Service & Engagement Framework - ISEC'
        ]);
    }

    /**
     * Trainee Certificate Verification Page
     */
    public function verifyCertificate(Request $request, Response $response): string {
        $certificateNumber = $request->get('cert_number');
        $certificate = null;
        $searched = false;

        if ($certificateNumber !== null) {
            $searched = true;
            $certificate = Certificate::findByNumber($certificateNumber);
        }

        return $this->render('home/verify', [
            'title' => 'Verify Trainee Certificate - ISEC Compliance & Auditing',
            'certificate' => $certificate,
            'cert_number' => $certificateNumber,
            'searched' => $searched
        ]);
    }

    /**
     * Dynamic Pages Route
     */
    public function dynamicPage(Request $request, Response $response, array $params): string {
        $slug = $params['slug'] ?? '';
        $page = \App\Models\SitePage::findBySlugPublished($slug);

        if (!$page) {
            $response->setStatusCode(404);
            return \App\Core\View::render('errors/404', ['title' => 'Page Not Found']);
        }

        return $this->render('page/show', [
            'title' => $page['title'] . ' - ISEC',
            'page' => $page
        ]);
    }
}
