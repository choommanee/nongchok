<?php
/**
 * Quick Setup Script for Ayam Bangkok
 * This script will guide you through the complete setup process
 */

echo "<h1>🐓 Ayam Bangkok Quick Setup</h1>\n";
echo "<div class='container'>\n";

$step = isset($_GET['step']) ? (int)$_GET['step'] : 1;

switch ($step) {
    case 1:
        echo "<h2>Step 1: Database Connection Test</h2>\n";
        echo "<p>First, let's test if we can connect to your database.</p>\n";
        
        // Test database connection
        $db_host = '127.0.0.1';
        $db_user = 'root';
        $db_password = '';
        $db_name = 'nongchok';
        
        echo "<div class='info-box'>\n";
        echo "<strong>Database Configuration:</strong><br>\n";
        echo "Host: $db_host<br>\n";
        echo "User: $db_user<br>\n";
        echo "Database: $db_name<br>\n";
        echo "Password: " . (empty($db_password) ? "No password" : "Password set") . "<br>\n";
        echo "</div>\n";
        
        try {
            $mysqli = new mysqli($db_host, $db_user, $db_password);
            
            if ($mysqli->connect_error) {
                throw new Exception($mysqli->connect_error);
            }
            
            echo "<div class='success-box'>✅ Database connection successful!</div>\n";
            
            // Check/create database
            $db_exists = $mysqli->query("SHOW DATABASES LIKE '$db_name'")->num_rows > 0;
            
            if (!$db_exists) {
                if ($mysqli->query("CREATE DATABASE `$db_name` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci")) {
                    echo "<div class='success-box'>✅ Database '$db_name' created successfully!</div>\n";
                } else {
                    throw new Exception("Could not create database: " . $mysqli->error);
                }
            } else {
                echo "<div class='success-box'>✅ Database '$db_name' already exists!</div>\n";
            }
            
            $mysqli->close();
            
            echo "<div class='next-step'>\n";
            echo "<a href='?step=2' class='btn btn-primary'>Continue to Step 2: WordPress Installation</a>\n";
            echo "</div>\n";
            
        } catch (Exception $e) {
            echo "<div class='error-box'>❌ Database connection failed: " . $e->getMessage() . "</div>\n";
            echo "<div class='troubleshoot'>\n";
            echo "<h3>Troubleshooting:</h3>\n";
            echo "<ul>\n";
            echo "<li>Make sure MySQL/MariaDB is running</li>\n";
            echo "<li>Check if you're using the correct port (3306 is default)</li>\n";
            echo "<li>Verify database credentials</li>\n";
            echo "<li>If using MAMP/XAMPP, ensure services are started</li>\n";
            echo "</ul>\n";
            echo "</div>\n";
        }
        break;
        
    case 2:
        echo "<h2>Step 2: WordPress Installation Check</h2>\n";
        echo "<p>Now let's check if WordPress is properly installed.</p>\n";
        
        if (!file_exists('wp-config.php')) {
            echo "<div class='error-box'>❌ wp-config.php not found!</div>\n";
            echo "<p>Please make sure you're running this from the WordPress root directory.</p>\n";
            break;
        }
        
        require_once('wp-config.php');
        
        try {
            $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
            
            if ($mysqli->connect_error) {
                throw new Exception($mysqli->connect_error);
            }
            
            // Check WordPress tables
            $wp_tables = array('posts', 'users', 'options');
            $tables_exist = 0;
            
            foreach ($wp_tables as $table) {
                $full_table = $table_prefix . $table;
                if ($mysqli->query("SHOW TABLES LIKE '$full_table'")->num_rows > 0) {
                    $tables_exist++;
                }
            }
            
            if ($tables_exist == count($wp_tables)) {
                echo "<div class='success-box'>✅ WordPress is installed and ready!</div>\n";
                
                // Try to load WordPress
                ob_start();
                require_once('wp-settings.php');
                ob_end_clean();
                
                echo "<div class='info-box'>\n";
                echo "<strong>WordPress Information:</strong><br>\n";
                echo "Version: " . get_bloginfo('version') . "<br>\n";
                echo "Site URL: " . get_site_url() . "<br>\n";
                echo "Admin URL: " . admin_url() . "<br>\n";
                echo "</div>\n";
                
                echo "<div class='next-step'>\n";
                echo "<a href='?step=3' class='btn btn-primary'>Continue to Step 3: Plugin Setup</a>\n";
                echo "</div>\n";
                
            } else {
                echo "<div class='warning-box'>⚠️ WordPress is not fully installed</div>\n";
                echo "<div class='action-box'>\n";
                echo "<p>Please complete WordPress installation first:</p>\n";
                echo "<a href='wp-admin/install.php' class='btn btn-warning' target='_blank'>Run WordPress Installation</a>\n";
                echo "<p><small>After installation, come back and refresh this page.</small></p>\n";
                echo "</div>\n";
            }
            
            $mysqli->close();
            
        } catch (Exception $e) {
            echo "<div class='error-box'>❌ Error: " . $e->getMessage() . "</div>\n";
        }
        break;
        
    case 3:
        echo "<h2>Step 3: Ayam Bangkok Plugin Setup</h2>\n";
        echo "<p>Let's set up the Ayam Bangkok Core plugin and create the necessary database tables.</p>\n";
        
        if (!file_exists('wp-config.php')) {
            echo "<div class='error-box'>❌ WordPress not found!</div>\n";
            break;
        }
        
        require_once('wp-config.php');
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        
        // Load plugin files
        $plugin_path = 'wp-content/plugins/ayam-bangkok-core/';
        
        if (!file_exists($plugin_path . 'ayam-bangkok-core.php')) {
            echo "<div class='error-box'>❌ Ayam Bangkok Core plugin not found!</div>\n";
            echo "<p>Please make sure the plugin files are in the correct location: $plugin_path</p>\n";
            break;
        }
        
        require_once($plugin_path . 'includes/class-ayam-database.php');
        require_once($plugin_path . 'includes/class-ayam-user-roles.php');
        
        try {
            echo "<div class='progress'>\n";
            
            // Create custom tables
            echo "<p>📊 Creating custom database tables...</p>\n";
            AyamDatabase::create_tables();
            echo "<div class='success-box'>✅ Custom tables created successfully!</div>\n";
            
            // Add user roles
            echo "<p>👥 Setting up user roles...</p>\n";
            AyamUserRoles::add_roles();
            echo "<div class='success-box'>✅ User roles configured!</div>\n";
            
            // Verify tables
            echo "<p>🔍 Verifying table creation...</p>\n";
            global $wpdb;
            
            $custom_tables = array(
                'ayam_bookings' => 'Service Bookings',
                'ayam_inquiries' => 'Customer Inquiries',
                'ayam_export_records' => 'Export Records',
                'ayam_rooster_gallery' => 'Rooster Galleries',
                'ayam_user_preferences' => 'User Preferences',
                'ayam_activity_log' => 'Activity Log'
            );
            
            echo "<div class='table-list'>\n";
            foreach ($custom_tables as $table => $description) {
                $full_table = $wpdb->prefix . $table;
                $exists = $wpdb->get_var("SHOW TABLES LIKE '$full_table'");
                if ($exists) {
                    echo "<div class='table-item success'>✅ $description ($full_table)</div>\n";
                } else {
                    echo "<div class='table-item error'>❌ $description ($full_table) - NOT CREATED</div>\n";
                }
            }
            echo "</div>\n";
            
            echo "</div>\n";
            
            echo "<div class='success-box'>\n";
            echo "<h3>🎉 Setup Complete!</h3>\n";
            echo "<p>Ayam Bangkok Core plugin is now ready to use.</p>\n";
            echo "</div>\n";
            
            echo "<div class='next-steps'>\n";
            echo "<h3>Next Steps:</h3>\n";
            echo "<ol>\n";
            echo "<li><a href='wp-admin/plugins.php' target='_blank'>Activate the Ayam Bangkok Core plugin</a></li>\n";
            echo "<li><a href='wp-admin/' target='_blank'>Go to WordPress Admin</a></li>\n";
            echo "<li>Install Advanced Custom Fields Pro plugin (recommended)</li>\n";
            echo "<li>Start adding roosters and services</li>\n";
            echo "</ol>\n";
            echo "</div>\n";
            
        } catch (Exception $e) {
            echo "<div class='error-box'>❌ Setup failed: " . $e->getMessage() . "</div>\n";
        }
        break;
        
    default:
        echo "<div class='error-box'>Invalid step</div>\n";
}

echo "</div>\n";
?>

<style>
body {
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    margin: 0;
    padding: 20px;
    background: #f0f0f1;
    color: #1d2327;
}

.container {
    max-width: 800px;
    margin: 0 auto;
    background: white;
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

h1 {
    color: #ff6b35;
    text-align: center;
    margin-bottom: 30px;
    font-size: 2.5em;
}

h2 {
    color: #333;
    border-bottom: 2px solid #ff6b35;
    padding-bottom: 10px;
}

.success-box {
    background: #d4edda;
    border: 1px solid #c3e6cb;
    color: #155724;
    padding: 15px;
    border-radius: 5px;
    margin: 15px 0;
}

.error-box {
    background: #f8d7da;
    border: 1px solid #f5c6cb;
    color: #721c24;
    padding: 15px;
    border-radius: 5px;
    margin: 15px 0;
}

.warning-box {
    background: #fff3cd;
    border: 1px solid #ffeaa7;
    color: #856404;
    padding: 15px;
    border-radius: 5px;
    margin: 15px 0;
}

.info-box {
    background: #d1ecf1;
    border: 1px solid #bee5eb;
    color: #0c5460;
    padding: 15px;
    border-radius: 5px;
    margin: 15px 0;
}

.btn {
    display: inline-block;
    padding: 12px 24px;
    text-decoration: none;
    border-radius: 5px;
    font-weight: bold;
    text-align: center;
    margin: 10px 5px;
    border: none;
    cursor: pointer;
}

.btn-primary {
    background: #ff6b35;
    color: white;
}

.btn-primary:hover {
    background: #e55a2b;
}

.btn-warning {
    background: #ffc107;
    color: #212529;
}

.next-step, .action-box {
    text-align: center;
    margin: 30px 0;
}

.troubleshoot {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 5px;
    margin: 20px 0;
}

.table-list {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 5px;
    margin: 15px 0;
}

.table-item {
    padding: 8px;
    margin: 5px 0;
    border-radius: 3px;
}

.table-item.success {
    background: #d4edda;
    color: #155724;
}

.table-item.error {
    background: #f8d7da;
    color: #721c24;
}

.progress {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 5px;
    margin: 20px 0;
}

.next-steps {
    background: #e7f3ff;
    padding: 20px;
    border-radius: 5px;
    margin: 20px 0;
}

.next-steps ol {
    margin: 10px 0;
    padding-left: 20px;
}

.next-steps li {
    margin: 10px 0;
}
</style>