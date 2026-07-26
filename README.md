# Integrated Systems Efficiency Consults Limited (ISEC) Website & CMS

This is the enterprise-grade corporate platform and custom CMS for **Integrated Systems Efficiency Consults Limited (ISEC)** built on a clean PHP MVC architecture.

---

## 🛠️ Technology Stack
* **Frontend**: HTML5, CSS3, Tailwind CSS (dynamic colors via database settings), Alpine.js, GSAP entrance animations, AOS scroll reveals, FontAwesome 6, Chart.js.
* **Backend**: PHP 8.3+ MVC Architecture, RESTful Routing, Object-Oriented SQL parameters, Secure Session manager, Role-Based Access Control (RBAC).
* **Database**: MySQL 8.2+ with complete Foreign Key constraints and index optimization.
* **Security**: Parameterized prepared statements, XSS escaping, Session cookie hardening, CSRF token validation filters.

---

## 📂 Project Directory Map
```
isec/
├── app/
│   ├── config/          # Configurations & settings
│   ├── controllers/     # MVC Controller classes
│   ├── core/            # Lightweight MVC core classes (Router, App, PDO, Session etc)
│   ├── helpers/         # URL, escape, RBAC helper functions
│   ├── middleware/      # Auth, Admin and CSRF validation interceptors
│   ├── models/          # Entity models mapping to database tables
│   └── views/           # Views (public layouts and admin dashboard)
├── database/
│   ├── schema.sql       # MySQL Database Tables schemas
│   └── seeder.sql       # Default Admin accounts and mockup services
├── public/
│   ├── .htaccess        # Clean URL rewrite rules
│   └── assets/          # CSS, JS, graphics and dynamic uploads directory
├── composer.json        # Autoloader mapping settings
└── README.md            # Installation instructions
```

---

## 💻 XAMPP Local Installation Guide

### Step 1: Copy Code Files to XAMPP htdocs
Copy the entire `isec` folder to your XAMPP installation's root directory:
```
C:\xampp\htdocs\isec
```

### Step 2: Set Up the Database in phpMyAdmin
1. Start XAMPP Control Panel, then enable **Apache** and **MySQL**.
2. Open your browser and navigate to `http://localhost/phpmyadmin/`.
3. Create a new database named **`isec_db`** (using collation `utf8mb4_unicode_ci` or standard default).
4. Select the newly created `isec_db` database, click on the **Import** tab.
5. Choose and import the database schema file:
   `C:\xampp\htdocs\isec\database\schema.sql`
6. Once the schema imports successfully, import the seed data file:
   `C:\xampp\htdocs\isec\database\seeder.sql`

### Step 3: Configure Database Credentials (Optional)
If your XAMPP MySQL has a password configured, edit the credentials in:
`C:\xampp\htdocs\isec\app\config\config.php`
```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', 'YOUR_MYSQL_PASSWORD'); // Default is empty '' in XAMPP
define('DB_NAME', 'isec_db');
```

### Step 4: Run the Application
Access the website public landing page directly in your browser:
```
http://localhost/isec/public/
```
The router will dynamically detect the XAMPP path subfolder structure and rewrite URL assets correctly!

---

## 🔑 Administrative CMS Panel Login
* **Login URL**: `http://localhost/isec/public/admin/login`
* **Default Admin Email**: `admin@isec.com.ng`
* **Default Admin Password**: `admin123`

---

## 🔒 Security Operations Checklist
1. **CSRF Validation**: All forms (Contact page, newsletter join, job apply, settings updates) require `<?= csrf_field() ?>` inside the HTML form block.
2. **XSS Protection**: Use `<?= e($value) ?>` instead of printing raw strings to safely sanitize outputs.
3. **Database Security**: All dynamic queries must execute via parameterized placeholders in models (e.g. `:id`, `:slug`) to prevent SQL Injection.
