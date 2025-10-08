<?php
/**
 * Simple Database Connection Test
 * Test database connectivity without WordPress
 */

echo "<h1>Database Connection Test</h1>\n";
echo "<pre>\n";

// Database configuration (matching wp-config.php)
$db_host = '127.0.0.1';
$db_user = 'root';
$db_password = '';
$db_name = 'nongchok';

echo "Testing connection to:\n";
echo "Host: $db_host\n";
echo "User: $db_user\n";
echo "Database: $db_name\n";
echo "Password: " . (empty($db_password) ? "(empty)" : "(set)") . "\n\n";

try {
    // Test connection
    $mysqli = new mysqli($db_host, $db_user, $db_password);
    
    if ($mysqli->connect_error) {
        throw new Exception("Connection failed: " . $mysqli->connect_error);
    }
    
    echo "✓ MySQL connection successful\n";
    echo "✓ MySQL version: " . $mysqli->server_info . "\n";
    
    // Check if database exists
    $db_check = $mysqli->query("SHOW DATABASES LIKE '$db_name'");
    if ($db_check->num_rows == 0) {
        echo "❌ Database '$db_name' does not exist\n";
        echo "\nCreating database '$db_name'...\n";
        
        if ($mysqli->query("CREATE DATABASE `$db_name` CHARACTER SET utf8 COLLATE utf8_general_ci")) {
            echo "✓ Database '$db_name' created successfully\n";
        } else {
            throw new Exception("Failed to create database: " . $mysqli->error);
        }
    } else {
        echo "✓ Database '$db_name' exists\n";
    }
    
    // Select database
    if (!$mysqli->select_db($db_name)) {
        throw new Exception("Cannot select database: " . $mysqli->error);
    }
    
    echo "✓ Database '$db_name' selected\n";
    
    // Check tables
    $result = $mysqli->query("SHOW TABLES");
    $table_count = $result->num_rows;
    echo "✓ Database has $table_count tables\n";
    
    if ($table_count > 0) {
        echo "\nExisting tables:\n";
        while ($row = $result->fetch_array()) {
            echo "  - " . $row[0] . "\n";
        }
    } else {
        echo "\n⚠ Database is empty (this is normal for new installation)\n";
    }
    
    // Test write permissions
    echo "\nTesting write permissions...\n";
    $test_query = "CREATE TABLE IF NOT EXISTS test_table (id INT AUTO_INCREMENT PRIMARY KEY, test_data VARCHAR(50))";
    if ($mysqli->query($test_query)) {
        echo "✓ Can create tables\n";
        
        // Insert test data
        if ($mysqli->query("INSERT INTO test_table (test_data) VALUES ('test')")) {
            echo "✓ Can insert data\n";
            
            // Read test data
            $read_result = $mysqli->query("SELECT * FROM test_table");
            if ($read_result && $read_result->num_rows > 0) {
                echo "✓ Can read data\n";
            }
            
            // Clean up
            $mysqli->query("DROP TABLE test_table");
            echo "✓ Can drop tables\n";
        }
    } else {
        echo "❌ Cannot create tables: " . $mysqli->error . "\n";
    }
    
    $mysqli->close();
    
    echo "\n✅ Database connection test PASSED!\n";
    echo "\nYou can now proceed with WordPress installation.\n";
    
} catch (Exception $e) {
    echo "❌ Database connection FAILED: " . $e->getMessage() . "\n";
    
    echo "\nTroubleshooting steps:\n";
    echo "1. Check if MySQL/MariaDB service is running:\n";
    echo "   - macOS: brew services list | grep mysql\n";
    echo "   - Linux: sudo systemctl status mysql\n";
    echo "   - Windows: Check Services panel\n\n";
    
    echo "2. Try connecting manually:\n";
    echo "   mysql -u root -p\n\n";
    
    echo "3. If using MAMP/XAMPP, make sure:\n";
    echo "   - Apache and MySQL are started\n";
    echo "   - Port is correct (usually 3306 or 8889)\n\n";
    
    echo "4. Check MySQL configuration:\n";
    echo "   - User 'root' exists and has proper permissions\n";
    echo "   - Password is correct (empty in this case)\n";
}

echo "</pre>\n";
?>

<style>
body { font-family: Arial, sans-serif; margin: 20px; }
h1 { color: #d63384; }
pre { background: #f8f9fa; padding: 20px; border-radius: 5px; border-left: 4px solid #d63384; }
</style>