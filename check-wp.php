<?php
/**
 * WordPress Installation Check Script
 * Check if WordPress is properly installed and database is accessible
 */

echo "<h1>WordPress Installation Check</h1>\n";
echo "<pre>\n";

// Check if wp-config.php exists
if (!file_exists('wp-config.php')) {
    echo "❌ wp-config.php not found!\n";
    echo "Please make sure you're running this from the WordPress root directory.\n";
    exit;
}

echo "✓ wp-config.php found\n";

// Load WordPress configuration
require_once('wp-config.php');

// Test database connection
echo "\nTesting database connection...\n";
echo "Database: " . DB_NAME . "\n";
echo "Host: " . DB_HOST . "\n";
echo "User: " . DB_USER . "\n";

try {
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    
    if ($mysqli->connect_error) {
        throw new Exception("Connection failed: " . $mysqli->connect_error);
    }
    
    echo "✓ Database connection successful\n";
    
    // Check if database exists and has tables
    $result = $mysqli->query("SHOW TABLES");
    $table_count = $result->num_rows;
    
    echo "✓ Database '$DB_NAME' has $table_count tables\n";
    
    if ($table_count == 0) {
        echo "\n⚠ Database is empty. WordPress needs to be installed.\n";
        echo "Please visit: http://nongchok.local/wp-admin/install.php\n";
    } else {
        // Check for WordPress core tables
        $wp_tables = array('posts', 'users', 'options', 'postmeta', 'usermeta');
        $wp_tables_found = 0;
        
        echo "\nChecking WordPress core tables:\n";
        foreach ($wp_tables as $table) {
            $full_table = $table_prefix . $table;
            $check = $mysqli->query("SHOW TABLES LIKE '$full_table'");
            if ($check->num_rows > 0) {
                echo "✓ $full_table\n";
                $wp_tables_found++;
            } else {
                echo "❌ $full_table (missing)\n";
            }
        }
        
        if ($wp_tables_found == count($wp_tables)) {
            echo "\n✅ WordPress is properly installed!\n";
            
            // Check if we can load WordPress
            if (file_exists('wp-settings.php')) {
                echo "\nTrying to load WordPress...\n";
                
                // Suppress output during WordPress load
                ob_start();
                try {
                    require_once('wp-settings.php');
                    ob_end_clean();
                    echo "✓ WordPress loaded successfully\n";
                    echo "✓ WordPress Version: " . get_bloginfo('version') . "\n";
                    echo "✓ Site URL: " . get_site_url() . "\n";
                    echo "✓ Admin URL: " . admin_url() . "\n";
                } catch (Exception $e) {
                    ob_end_clean();
                    echo "❌ Error loading WordPress: " . $e->getMessage() . "\n";
                }
            }
            
        } else {
            echo "\n⚠ WordPress installation incomplete. Missing core tables.\n";
            echo "Please run WordPress installation: http://nongchok.local/wp-admin/install.php\n";
        }
    }
    
    $mysqli->close();
    
} catch (Exception $e) {
    echo "❌ Database Error: " . $e->getMessage() . "\n";
    echo "\nTroubleshooting:\n";
    echo "1. Make sure MySQL/MariaDB is running\n";
    echo "2. Check if database 'nongchok' exists\n";
    echo "3. Verify database credentials in wp-config.php\n";
    echo "4. Try connecting manually: mysql -u root -p nongchok\n";
}

echo "\n" . str_repeat("=", 50) . "\n";
echo "Next Steps:\n";
echo "1. If WordPress is not installed, visit: http://nongchok.local/wp-admin/install.php\n";
echo "2. After WordPress installation, run: http://nongchok.local/wp-content/plugins/ayam-bangkok-core/migration.php\n";
echo "3. Then activate the Ayam Bangkok Core plugin\n";

echo "</pre>\n";
?>

<style>
body { font-family: Arial, sans-serif; margin: 20px; }
h1 { color: #0073aa; }
pre { background: #f5f5f5; padding: 20px; border-radius: 5px; line-height: 1.5; }
</style>