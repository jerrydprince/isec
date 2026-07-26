-- ISEC Database Seeder (SQL Script)

-- 1. Seed Roles
INSERT INTO `roles` (`id`, `name`, `description`) VALUES
(1, 'Admin', 'Full system administrator with access to all controls'),
(2, 'Editor', 'Can edit and manage content but cannot manage users or settings'),
(3, 'Content Manager', 'Can manage services, projects, and blogs'),
(4, 'HR', 'Can manage careers and job applications'),
(5, 'Marketing', 'Can manage testimonials, newsletter subscribers, and messages'),
(6, 'Project Manager', 'Can view and update projects and services');

-- 2. Seed Permissions
INSERT INTO `permissions` (`id`, `name`, `description`) VALUES
(1, 'manage_users', 'Can create, edit and delete administrative users'),
(2, 'manage_roles', 'Can edit roles and permissions mappings'),
(3, 'manage_settings', 'Can edit site-wide dynamic settings'),
(4, 'manage_services', 'Can perform CRUD on consulting services'),
(5, 'manage_projects', 'Can perform CRUD on project portfolio'),
(6, 'manage_blogs', 'Can perform CRUD on insights, case studies, and blog posts'),
(7, 'manage_careers', 'Can post job vacancies and view candidate applications'),
(8, 'manage_messages', 'Can view and delete contact form inquiries'),
(9, 'manage_newsletter', 'Can manage newsletter subscribers list'),
(10, 'view_audit_logs', 'Can view administrative system logs'),
(11, 'manage_testimonials', 'Can manage testimonials and clients logo');

-- 3. Map Permissions to Admin Role (Role ID = 1)
INSERT INTO `role_permissions` (`role_id`, `permission_id`)
SELECT 1, id FROM `permissions`;

-- 4. Map Permissions to Content Manager (Role ID = 3)
INSERT INTO `role_permissions` (`role_id`, `permission_id`) VALUES
(3, 4), -- manage_services
(3, 5), -- manage_projects
(3, 6); -- manage_blogs

-- 5. Map Permissions to HR (Role ID = 4)
INSERT INTO `role_permissions` (`role_id`, `permission_id`) VALUES
(4, 7); -- manage_careers

-- 6. Map Permissions to Marketing (Role ID = 5)
INSERT INTO `role_permissions` (`role_id`, `permission_id`) VALUES
(5, 6),  -- manage_blogs
(5, 8),  -- manage_messages
(5, 9),  -- manage_newsletter
(5, 11); -- manage_testimonials

-- 7. Seed Default Admin User (Password: admin123)
INSERT INTO `users` (`id`, `name`, `email`, `password`, `role_id`, `status`) VALUES
(1, 'Chief Admin', 'admin@isecltd.ng', '$2y$10$K6cMs2A/LnQH2vPPC/rNpulKJM1hKzfMUTHAkxWmPtOM4TGn/nSjq', 1, 'active');

-- 8. Seed Site Settings
INSERT INTO `settings` (`key`, `value`) VALUES
('site_name', 'Integrated Systems Efficiency Consults Limited'),
('site_short_name', 'ISEC'),
('site_description', 'Premium management, technology, engineering, public sector, and business consulting in Nigeria.'),
('contact_email', 'info@isecltd.ng'),
('contact_phone', '+234 803 123 4567, +234 805 987 6543'),
('contact_address', 'Plot 12, Corporate Boulevard, Phase 1, Wuse II, Abuja, Nigeria'),
('office_hours', 'Mon - Fri: 8:00 AM - 5:00 PM'),
('linkedin_url', 'https://linkedin.com/company/isec-consulting'),
('twitter_url', 'https://twitter.com/isec_consults'),
('facebook_url', 'https://facebook.com/isec.consults'),
('instagram_url', 'https://instagram.com/isec_consults'),
('whatsapp_number', '+2348031234567'),
('primary_color', '#0f172a'), -- Deep Slate Blue
('secondary_color', '#1e3a8a'), -- Royal Navy Blue
('accent_color', '#0d9488'), -- Teal
('google_map_embed', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3939.81665676342!2d7.472093514787189!3d9.075677893488219!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x104e0baf74681647%3A0xed41cc6cfb2f7a4e!2sWuse%202%2C%20Abuja!5e0!3m2!1sen!2sng!4v1680000000000!5m2!1sen!2sng'),
('meta_keywords', 'consulting, enterprise solutions, digital transformation, government automation, public sector, nigeria, engineering consulting, systems efficiency'),
('cac_number', 'RC - 1234567'),
('firs_tin', 'TIN - 987654321-0001'),
('nsitf_status', 'Compliant - Certificate No. NSITF/2026/0998'),
('itf_status', 'Compliant - Registration No. ITF/RC/8876'),
('bpp_status', 'Registered - BPP IRR No. IRR-998877'),
('cpn_status', 'Member - CPN Corporate No. CPN/2026/5543'),
('nitda_status', 'Licensed - NITDA IT-ServiceProvider License #NITDA/2026/102'),
('company_profile_pdf', 'assets/uploads/documents/company_profile.pdf');

-- 9. Seed Service Categories & Services
INSERT INTO `services` (`id`, `title`, `slug`, `description`, `benefits`, `features`, `methodology`, `deliverables`, `technologies`, `industries_served`, `icon`, `status`) VALUES
(1, 'Digital Transformation', 'digital-transformation', 
'Comprehensive overhaul of corporate and public workflows using modern IT frameworks to achieve operational excellence.',
'• Up to 40% improvement in process execution speeds\n• Significant overhead cost reductions\n• Seamless data sharing and collaboration\n• Real-time analytics and decision support tools',
'• Enterprise Architecture Review\n• Legacy System Integration\n• Cloud Migration Strategies\n• Digital Workflow Engineering',
'We adopt the TOGAF standard combined with Agile execution methodology to transition legacy operations smoothly.',
'• Current State Audit Report\n• Digital Strategy Roadmap\n• Architecture Blueprints\n• Employee Training Material',
'Cloud Platforms (AWS, Azure), Low-code environments, Microservices architecture',
'Government, Banking, Telecommunications, Manufacturing',
'fa-laptop-code', 'published'),

(2, 'Government Automation', 'government-automation',
'Specialized e-governance systems and revenue automation platforms for Federal, State, and Local government tiers.',
'• Enhanced revenue collection and leakage prevention\n• Transparent civic services delivery\n• Structured public financial management\n• Improved regulatory compliance monitoring',
'• Centralized Revenue Automations\n• Civic Registration Portals\n• Digital Land Registries\n• Integrated Payroll & HR Systems (IPPIS-compatible)',
'A structured participatory approach, aligning policy directives with software capabilities and conducting extensive user acceptance tests.',
'• Requirement Specification Document\n• Custom Core Application\n• Database Deployment & Migration\n• SLA Operations Guide',
'PHP, MySQL, Secure REST APIs, Custom Identity Infrastructure',
'Public Sector, Federal Ministries, Municipalities',
'fa-landmark', 'published'),

(3, 'Enterprise Resource Planning (ERP)', 'erp-consulting',
'End-to-end design, implementation, customization, and advisory services for global ERP platforms like SAP, Oracle, and Odoo.',
'• Standardized business units across territories\n• Streamlined inventory and procurement\n• Dynamic automated accounting pipelines\n• Unified personnel management logs',
'• General Ledger & Asset Management modules\n• Supply Chain & Warehousing controllers\n• HRMS and payroll calculation engines\n• Executive Dashboard reporting',
'We utilize the Accelerated ERP implementation methodology, running configuration, piloting, and testing in tight iterations.',
'• Process Mapping & Gap Analysis\n• Customized ERP Core Sandbox\n• Data Migration Pipelines\n• Post-deployment support agreement',
'Odoo ERP, SAP S/4HANA, Oracle NetSuite',
'Oil & Gas, Manufacturing, Supply Chain, Finance',
'fa-network-wired', 'published');

INSERT INTO `services` (`id`, `title`, `slug`, `description`, `benefits`, `features`, `methodology`, `deliverables`, `technologies`, `industries_served`, `icon`, `status`) VALUES
(4, 'Capacity Building', 'capacity-building', 
'Professional training, corporate workshops, leadership programmes, and operational skills enhancement for public servants and corporate teams.',
'• Enhanced employee operational efficiency\n• Alignment with modern digital frameworks\n• Accelerated adaptation to new enterprise software\n• Standardized leadership and performance metrics',
'• Custom Curriculum Engineering\n• Interactive Corporate Workshops\n• E-Governance Best Practices Coaching\n• Executive Technical Training',
'Interactive peer learning combined with practical case studies and post-training assessment metrics.',
'• Custom Training Materials & Manuals\n• Course Completion Certifications\n• Post-Training Performance Reports\n• Standard Operating Procedure guides',
'LMS platforms, Video conferencing systems, Interactive workshop simulators',
'Government Agencies, Corporate Entities, HR Managers, NGOs',
'fa-graduation-cap', 'published');

INSERT INTO `services` (`id`, `title`, `slug`, `description`, `benefits`, `features`, `methodology`, `deliverables`, `technologies`, `industries_served`, `icon`, `status`) VALUES
(5, 'GIS & Land Registries', 'gis-solutions', 
'Advanced Geographic Information Systems (GIS) plotting, cadastre mapping, and digital land registries configuration to secure land titles and property tax indexes.',
'• 100% security against property boundary disputes\n• Digitized cadastre archives accessible in seconds\n• Integrated property tax collection pipelines\n• Streamlined land allocation approvals',
'• Boundary Survey Digitalization\n• Interactive GIS Mapping Portals\n• Land Registration Archiving\n• Automated C of O Generation pipelines',
'Satellite imagery integration combined with physical ground-truthing, land survey digitizing, and secure database indexing.',
'• Digitized Parcel Layout Database\n• Web-based GIS Map Viewer\n• Secure Registry Database Configuration\n• Land Officer Administration Manuals',
'ArcGIS, QGIS, PostgreSQL/PostGIS, Custom GIS Map layers',
'Ministry of Lands, Urban Planning Agencies, Municipalities, Property Developers',
'fa-map-location-dot', 'published');

-- 10. Seed Project Categories
INSERT INTO `project_categories` (`id`, `name`, `slug`) VALUES
(1, 'Government', 'government'),
(2, 'Education', 'education'),
(3, 'Healthcare', 'healthcare'),
(4, 'Finance', 'finance'),
(5, 'Infrastructure', 'infrastructure'),
(6, 'Private Sector', 'private-sector');

-- 11. Seed Projects
INSERT INTO `projects` (`id`, `category_id`, `title`, `slug`, `client`, `location`, `duration`, `budget`, `technologies`, `challenge`, `solution`, `outcome`, `banner_image`, `status`) VALUES
(1, 1, 'State Land Registry Digitalization System', 'state-land-registry-digitalization',
'Kwara State Ministry of Lands', 'Kwara State, Nigeria', '12 Months', 'Confidential', 'PHP, MySQL, Leaflet.js, OpenStreetMap API, RESTful APIs',
'The Kwara State Ministry faced massive delays, loss of files, and land title duplications due to a manual paper-based record archiving system.',
'We developed a secure, digital Geographic Information System (GIS) integrated land registry portal with document barcode validation, digital signature approvals, and visual plot mapping.',
'Over 150,000 files were successfully indexed. Average land title search times were reduced from 14 business days to 5 minutes, boosting state revenue generation by 35%.',
'project_land_registry.jpg', 'published'),

(2, 4, 'Integrated Revenue Automation System (IRAS)', 'integrated-revenue-automation',
'Abuja Municipal Area Council (AMAC)', 'Abuja, Nigeria', '8 Months', 'Confidential', 'Laravel, PostgreSQL, REST API, POS Devices integration, USSD channels',
'AMAC suffered massive leakages in local taxes, market stall fees, and tenement rates due to cash collection vulnerability and parallel receipts.',
'We designed and deployed the Integrated Revenue Automation System (IRAS), linking collection POS machines, bank notification APIs, and civic portals under a unified ledger.',
'Eliminated cash handling completely. Revenue grew by 55% in the first quarter of deployment. Citizens can verify their tax payment receipts in real-time online or via USSD.',
'project_revenue_amac.jpg', 'published');

-- 12. Seed Blog Categories
INSERT INTO `blog_categories` (`id`, `name`, `slug`) VALUES
(1, 'Corporate Insights', 'corporate-insights'),
(2, 'Public Sector Reform', 'public-sector-reform'),
(3, 'Digital Infrastructure', 'digital-infrastructure'),
(4, 'Case Studies', 'case-studies');

-- 13. Seed Blogs / Case Studies / Whitepapers
INSERT INTO `blogs` (`id`, `category_id`, `author_id`, `title`, `slug`, `content`, `summary`, `banner_image`, `type`, `status`, `published_at`) VALUES
(1, 2, 1, 'The Path to Digitalizing Public Sector Operations in Nigeria', 'path-to-digitalizing-public-sector',
'<p>Public service operations in developing countries like Nigeria face structural delays and transparency deficits. Transitioning to e-governance requires more than just buying computers—it requires systematic Business Process Reengineering (BPR).</p><h4>Key Pillars of Public Sector Automation</h4><p>1. <b>Policy Alignment:</b> Every automated workflow must align with existing statutory rules and procedures.</p><p>2. <b>Capacity Development:</b> Public civil servants must be re-skilled to adopt digital interfaces.</p><p>3. <b>Security and Auditing:</b> Protecting state data requires top-tier access control mechanisms.</p>',
'An in-depth analysis of e-governance bottlenecks in Nigeria and the framework required to achieve public sector efficiency through technology.',
'insight_public_sector.jpg', 'whitepaper', 'published', CURRENT_TIMESTAMP),

(2, 1, 1, 'Maximizing ROI in ERP Deployments for Mid-Sized Enterprises', 'maximizing-roi-in-erp-deployments',
'<p>Implementing an Enterprise Resource Planning (ERP) platform is a major milestone for any growing business. However, failure to plan carefully often leads to blown budgets and user rejection.</p><h4>Three rules to remember:</h4><ul><li>Define measurable goals before procurement.</li><li>Cleanse data before importing to the new system.</li><li>Invest heavily in change management and staff training.</li></ul>',
'Important checklist items to guarantee your business processes realize optimal efficiency after deploying an ERP.',
'insight_erp_roi.jpg', 'blog', 'published', CURRENT_TIMESTAMP);

-- 14. Seed FAQs
INSERT INTO `faqs` (`id`, `question`, `answer`, `display_order`) VALUES
(1, 'What sectors does ISEC specialize in?', 'ISEC specializes in Government/Public Sector Automation, Financial Management, GIS Solutions, Oil & Gas, Healthcare, Education, and Large Private Sector enterprises.', 1),
(2, 'How do you ensure data security in your solutions?', 'All our solutions conform to international security guidelines including prepared SQL statements to prevent injections, secure HTTPS, JWT/Session tokens, and end-to-end data encryption.', 2),
(3, 'Does ISEC offer change management training?', 'Yes, we believe technology is only as good as the people operating it. Every digital deployment includes structured capacity building and change management programs.', 3);

-- 15. Seed Team Members
INSERT INTO `team` (`id`, `name`, `position`, `bio`, `image`, `social_links`, `display_order`) VALUES
(1, 'Prince Jerry Oyakhire', 'Managing Director & CEO', 'Over 20 years of experience in enterprise systems consulting, e-governance, and large-scale public sector reforms across West Africa.', 'team_ceo.jpg', '{"linkedin":"https://linkedin.com","twitter":"https://twitter.com"}', 1),
(2, 'Engr. Sarah Ndukwe', 'Chief Operating Officer', 'Expert in systems architecture, engineering consultancy, and digital workspace deployment with a focus on process automation.', 'team_coo.jpg', '{"linkedin":"https://linkedin.com"}', 2);

-- 16. Seed Page Contents (Initial values for CMS)
INSERT INTO `page_contents` (`page_key`, `section_key`, `content_value`) VALUES
('home', 'hero_title', 'Integrated Systems Efficiency Consults Limited'),
('home', 'hero_subtitle', 'We design, automate, and optimize enterprise systems to drive compliance and efficiency across public and private sectors in Nigeria.'),
('about', 'mission_title', 'Our Mission'),
('about', 'mission_text', 'To empower institutions through advanced digital workflows, capacity development, and regulatory compliance solutions.'),
('about', 'vision_title', 'Our Vision'),
('about', 'vision_text', 'To be the leading consultant for e-governance and systems engineering in West Africa.');

-- 17. Seed Certificates (For verification lookups)
INSERT INTO `certificates` (`certificate_number`, `recipient_name`, `course_name`, `issue_date`, `expiry_date`, `grade_status`) VALUES
('ISEC-CERT-2026-0001', 'Amina Yusuf Babangida', 'Enterprise Systems & E-Governance Automation', '2026-05-15', NULL, 'Certified with Distinction'),
('ISEC-CERT-2026-0002', 'Okon Lawrence Akpan', 'Geographic Information Systems (GIS) & Land Registries', '2026-06-10', NULL, 'Certified'),
('ISEC-CERT-2026-0003', 'Chinedu Emeka Nwosu', 'Enterprise Resource Planning (ERP) Implementation & Change Management', '2026-06-25', '2029-06-25', 'Certified');
