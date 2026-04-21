<?php
/**
 * Configuration File
 * Modify these settings for your environment
 */

// Database Configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'webdev_project');

// Site Configuration
define('SITE_NAME', 'SDK Palsa');
define('SITE_URL', 'http://localhost/assignment2_DiscGolf');

// Session Configuration
define('SESSION_TIMEOUT', 3600); // 1 hour in seconds

// Cookie Configuration
define('COOKIE_EXPIRY', 365 * 24 * 60 * 60); // 1 year in seconds

// Password Requirements
define('MIN_PASSWORD_LENGTH', 6);

// File Upload Settings
define('MAX_UPLOAD_SIZE', 5242880); // 5MB in bytes
define('ALLOWED_EXTENSIONS', ['jpg', 'jpeg', 'png', 'gif', 'webp']);

// Error Reporting (disable in production)
define('SHOW_ERRORS', true);
if (SHOW_ERRORS) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(E_ALL);
    ini_set('display_errors', 0);
}
?>
