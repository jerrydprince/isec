# cPanel Production Deployment Guide (ISEC Platform)

This guide outlines the step-by-step procedures for deploying the **ISEC systems website** from your local XAMPP environment to your live cPanel hosting server at **`isecltd.ng`**.

---

## Step 1: Export the Database
1. Open your local XAMPP Control Panel.
2. Click **Admin** next to MySQL (or go to `http://localhost/phpmyadmin` in your browser).
3. Select the database **`isec_db`** from the left sidebar.
4. Click on the **Export** tab in the top menu.
5. Keep the export method as **Quick** and format as **SQL**, then click **Export**.
6. Save this `.sql` file to your computer (e.g., `isec_backup.sql`).

---

## Step 2: Push Your Code to GitHub
Instead of manually creating `.zip` files, we have configured a fully automated deployment pipeline using **GitHub** and **cPanel Git Version Control**.

1. Commit your local changes:
   ```bash
   git add .
   git commit -m "Deploying updates"
   ```
2. Push your changes to your GitHub repository:
   ```bash
   git push origin main
   ```
*(Make sure your GitHub repository is up to date before proceeding to cPanel).*

---

## Step 3: Configure the Database on cPanel
1. Log into your **cPanel Account** (usually `isecltd.ng/cpanel`).
2. Search for the **MySQL® Database Wizard** in the Databases section.
3. **Step 1: Create a Database**: Enter a name (e.g., `isecltd_db`) and click *Next Step*.
4. **Step 2: Create a Database User**: Enter a username (e.g., `isecltd_user`) and a secure password. Click *Create User*.
5. **Step 3: Add User to Database**: Check the box for **ALL PRIVILEGES** to grant the user permissions, then click *Make Changes*.
6. Save the **Database Name**, **User**, and **Password** safely for the next step.

---

## Step 4: Import SQL Schema in cPanel phpMyAdmin
1. Go back to the cPanel Home.
2. Open **phpMyAdmin**.
3. Click on the newly created database on the left sidebar.
4. Click the **Import** tab on the top menu.
5. Click **Choose File** and select your local exported `.sql` file.
6. Scroll down and click **Import**.

---

## Step 5: Automated Git Deployment via cPanel
We have included a `.cpanel.yml` and `.cpanel-deploy.sh` script in the codebase. When cPanel pulls the code, it will automatically route the core files to `/home/username/isec_app/` and public assets to `public_html/` for maximum security.

### 5.1 Link GitHub to cPanel
1. Log into your **cPanel Account**.
2. Scroll to the **Files** section and click **Git™ Version Control**.
3. Click **Create** to add a new repository.
4. Fill in the details:
   - **Clone URL**: Enter your GitHub repository URL (e.g., `https://github.com/yourusername/isec.git`).
   - **Repository Path**: Enter `repositories/isec_app`.
   - **Repository Name**: Enter `ISEC App`.
5. Click **Create**. cPanel will now clone your repository.

### 5.2 Trigger the Deployment
1. Still in **Git™ Version Control**, locate your `ISEC App` repository and click **Manage**.
2. Go to the **Pull or Deploy** tab.
3. Click **Update from Remote** (this pulls the latest changes from GitHub).
4. Click **Deploy HEAD Commit**. 
   *(This triggers the `.cpanel.yml` script, which automatically splits and copies your files to `isec_app/` and `public_html/`)*.

### 5.3 Edit index.php Paths
Since the files are automatically synced, you only need to ensure your live `index.php` points to the correct core directory.
1. Open the cPanel **File Manager**.
2. Navigate to `public_html/index.php`.
3. Right-click and **Edit**.
4. Update the autoload paths to point to `isec_app`:
   ```php
   require_once __DIR__ . '/../isec_app/vendor/autoload.php';
   require_once __DIR__ . '/../isec_app/app/config/config.php';
   require_once __DIR__ . '/../isec_app/app/Helpers/helpers.php';
   
   $app = new App(dirname(__DIR__) . '/isec_app');
   ```

*(Note: In the future, to fully automate deployments so you don't even need to click "Deploy" in cPanel, you can set up a GitHub Webhook pointing to cPanel. cPanel will provide the Webhook URL in the repository management page.)*

---

## Step 6: Update Environment Credentials
Open and edit the configuration file inside cPanel File Manager:
* If using **Option A**: Edit `/home/username/isec_app/app/config/config.php`
* If using **Option B**: Edit `/home/username/public_html/app/config/config.php`

Update the credentials matching the database you created in cPanel:
```php
// Database Configuration
define('DB_HOST', 'localhost'); // Usually localhost on cPanel
define('DB_USER', 'isecltd_user'); // Your cPanel database user
define('DB_PASS', 'YourSecurePasswordHere'); // Your database password
define('DB_NAME', 'isecltd_db'); // Your cPanel database name
```

> [!NOTE]
> The `BASE_URL` logic is dynamically calculated at runtime based on `$_SERVER['HTTP_HOST']`. You do not need to update or hardcode `isecltd.ng` inside the configuration file.

---

## Step 7: Production Speed Optimization (High Performance)
To maximize loading speed on your live hosting server, ensure you have enabled compression and browser caching inside your `public_html/.htaccess` file. This compresses page data by up to 70% and enables browser caching for static assets.

### Recommended `.htaccess` Configurations
Ensure your `/home/username/public_html/.htaccess` contains:
```apache
# 1. Enable Gzip Compression (mod_deflate)
<IfModule mod_deflate.c>
    AddOutputFilterByType DEFLATE text/html
    AddOutputFilterByType DEFLATE text/css
    AddOutputFilterByType DEFLATE text/javascript
    AddOutputFilterByType DEFLATE text/xml
    AddOutputFilterByType DEFLATE text/plain
    AddOutputFilterByType DEFLATE image/x-icon
    AddOutputFilterByType DEFLATE image/svg+xml
    AddOutputFilterByType DEFLATE application/javascript
    AddOutputFilterByType DEFLATE application/x-javascript
    AddOutputFilterByType DEFLATE application/xml
    AddOutputFilterByType DEFLATE application/xhtml+xml
    AddOutputFilterByType DEFLATE application/rss+xml
    AddOutputFilterByType DEFLATE application/json
    AddOutputFilterByType DEFLATE application/vnd.ms-fontobject
    AddOutputFilterByType DEFLATE application/x-font-ttf
    AddOutputFilterByType DEFLATE font/opentype
    AddOutputFilterByType DEFLATE font/otf
    AddOutputFilterByType DEFLATE font/ttf
</IfModule>

# 2. Leverage Browser Caching (mod_expires)
<IfModule mod_expires.c>
    ExpiresActive On
    ExpiresDefault "access plus 1 month"
    
    ExpiresByType text/html "access plus 0 seconds"
    ExpiresByType text/css "access plus 1 year"
    ExpiresByType text/javascript "access plus 1 year"
    ExpiresByType application/javascript "access plus 1 year"
    ExpiresByType application/x-javascript "access plus 1 year"
    ExpiresByType image/gif "access plus 1 year"
    ExpiresByType image/jpg "access plus 1 year"
    ExpiresByType image/jpeg "access plus 1 year"
    ExpiresByType image/png "access plus 1 year"
    ExpiresByType image/svg+xml "access plus 1 year"
    ExpiresByType image/x-icon "access plus 1 year"
    ExpiresByType font/ttf "access plus 1 year"
    ExpiresByType font/woff "access plus 1 year"
    ExpiresByType font/woff2 "access plus 1 year"
</IfModule>
```

---

## Step 8: Post-Deployment Verification Checklist
- [ ] **SSL (HTTPS)**: Ensure an SSL certificate is active on your domain via cPanel's **AutoSSL** tool.
- [ ] **Mailbox Delivery**: Go to `/admin/mail` in the backend, enter credentials, and send a test message to verify the secure SMTP connections are working.
- [ ] **Upload Folder Permissions**: Check that the folder `public/assets/uploads/` has write permissions (`0755` or `0777` if required by host) to allow users to upload CVs on vacancy forms.
