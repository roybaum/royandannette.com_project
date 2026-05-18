<?php
// Detect the environment based on the HTTP_HOST
$host = $_SERVER['HTTP_HOST'];

if ($host === 'royandannette.com.test') {
    // Local development environment
    define('ENVIRONMENT', 'development');
    define('BASE_URL', 'http://royandannette.com.test');
    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASS', 'password');
    define('DB_NAME', 'local_db');
    define('DEBUG_MODE', true);
} elseif ($host === 'royandannette.dreamhosters.com') {
    // Production environment
    define('ENVIRONMENT', 'production');
    define('BASE_URL', 'https://royandannette.dreamhosters.com');
    define('DB_HOST', 'prod-db-host');
    define('DB_USER', 'prod-user');
    define('DB_PASS', 'prod-password');
    define('DB_NAME', 'prod_db');
    define('DEBUG_MODE', false);
} else {
    // Default to production settings as a fallback
    define('ENVIRONMENT', 'production');
    define('BASE_URL', 'https://royandannette.dreamhosters.com');
    define('DB_HOST', 'prod-db-host');
    define('DB_USER', 'prod-user');
    define('DB_PASS', 'prod-password');
    define('DB_NAME', 'prod_db');
    define('DEBUG_MODE', false);
}

// Example usage
if (DEBUG_MODE) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}