<?php
/**
 * WordPress Admin URL Auto-Fix
 *
 * This script automatically fixes WordPress URL settings
 * Upload to WordPress root and access via browser
 * DELETE THIS FILE AFTER USE!
 */

// Load WordPress
require_once('wp-load.php');

// Check if user is admin
if (!current_user_can('manage_options')) {
    wp_die('You need to be logged in as admin to use this tool.');
}

// Get the correct domain
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$domain = $_SERVER['HTTP_HOST'];
$correct_url = $protocol . $domain;

// Get current settings
$current_siteurl = get_option('siteurl');
$current_home = get_option('home');

// Check if URLs are correct
$needs_fix = false;
if ($current_siteurl !== $correct_url || $current_home !== $correct_url) {
    $needs_fix = true;
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>WordPress Admin URL Fix</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            padding: 40px;
            max-width: 600px;
            width: 100%;
        }
        h1 {
            color: #333;
            margin-bottom: 10px;
            font-size: 28px;
        }
        .subtitle {
            color: #666;
            margin-bottom: 30px;
            font-size: 14px;
        }
        .status-box {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
        }
        .status-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid #e0e0e0;
        }
        .status-item:last-child {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none;
        }
        .status-label {
            font-weight: 600;
            color: #555;
        }
        .status-value {
            color: #333;
            word-break: break-all;
        }
        .status-correct {
            color: #28a745;
            font-weight: 600;
        }
        .status-incorrect {
            color: #dc3545;
            font-weight: 600;
        }
        .alert {
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        .alert-success {
            background: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
        }
        .alert-warning {
            background: #fff3cd;
            border: 1px solid #ffeeba;
            color: #856404;
        }
        .alert-danger {
            background: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
        }
        .btn {
            display: inline-block;
            padding: 12px 30px;
            background: #667eea;
            color: white;
            text-decoration: none;
            border-radius: 25px;
            font-weight: 600;
            transition: all 0.3s;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }
        .btn:hover {
            background: #5a67d8;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.4);
        }
        .btn-danger {
            background: #dc3545;
        }
        .btn-danger:hover {
            background: #c82333;
            box-shadow: 0 10px 20px rgba(220, 53, 69, 0.4);
        }
        .btn-success {
            background: #28a745;
        }
        .btn-success:hover {
            background: #218838;
            box-shadow: 0 10px 20px rgba(40, 167, 69, 0.4);
        }
        .actions {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }
        .icon {
            font-size: 20px;
            margin-right: 5px;
        }
        .code {
            background: #f4f4f4;
            padding: 15px;
            border-radius: 8px;
            font-family: 'Courier New', monospace;
            font-size: 14px;
            margin: 10px 0;
            border-left: 4px solid #667eea;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔧 WordPress Admin URL Fix</h1>
        <p class="subtitle">Automatic detection and repair of WordPress URL settings</p>

        <div class="status-box">
            <div class="status-item">
                <span class="status-label">Detected URL:</span>
                <span class="status-value"><?php echo $correct_url; ?></span>
            </div>
            <div class="status-item">
                <span class="status-label">Current Site URL:</span>
                <span class="status-value <?php echo $current_siteurl === $correct_url ? 'status-correct' : 'status-incorrect'; ?>">
                    <?php echo $current_siteurl; ?>
                    <?php if ($current_siteurl === $correct_url): ?>
                        ✓
                    <?php else: ?>
                        ✗
                    <?php endif; ?>
                </span>
            </div>
            <div class="status-item">
                <span class="status-label">Current Home URL:</span>
                <span class="status-value <?php echo $current_home === $correct_url ? 'status-correct' : 'status-incorrect'; ?>">
                    <?php echo $current_home; ?>
                    <?php if ($current_home === $correct_url): ?>
                        ✓
                    <?php else: ?>
                        ✗
                    <?php endif; ?>
                </span>
            </div>
        </div>

        <?php if (isset($_POST['fix_urls'])): ?>
            <?php
            // Update the URLs
            update_option('siteurl', $correct_url);
            update_option('home', $correct_url);

            // Also update in database directly
            global $wpdb;
            $wpdb->query($wpdb->prepare(
                "UPDATE {$wpdb->options} SET option_value = %s WHERE option_name = 'siteurl'",
                $correct_url
            ));
            $wpdb->query($wpdb->prepare(
                "UPDATE {$wpdb->options} SET option_value = %s WHERE option_name = 'home'",
                $correct_url
            ));

            // Clear cache
            wp_cache_flush();
            ?>
            <div class="alert alert-success">
                <strong>✅ Success!</strong> WordPress URLs have been updated to <strong><?php echo $correct_url; ?></strong>
                <br><br>
                Redirecting to admin panel in 3 seconds...
            </div>
            <script>
                setTimeout(function() {
                    window.location.href = '<?php echo $correct_url; ?>/wp-admin/';
                }, 3000);
            </script>
        <?php elseif ($needs_fix): ?>
            <div class="alert alert-warning">
                <strong>⚠️ URLs need to be fixed!</strong><br>
                Your WordPress URLs don't match the current domain. This can cause admin panel links to break.
            </div>

            <form method="post">
                <?php wp_nonce_field('fix_wordpress_urls', 'fix_urls_nonce'); ?>
                <button type="submit" name="fix_urls" class="btn">
                    <span class="icon">🔧</span> Fix URLs Automatically
                </button>
            </form>
        <?php else: ?>
            <div class="alert alert-success">
                <strong>✅ All good!</strong><br>
                Your WordPress URLs are correctly configured.
            </div>

            <a href="<?php echo admin_url(); ?>" class="btn btn-success">
                <span class="icon">🚀</span> Go to Admin Panel
            </a>
        <?php endif; ?>

        <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #e0e0e0;">
            <h3 style="margin-bottom: 15px;">📝 Alternative: Manual Fix in wp-config.php</h3>
            <p style="color: #666; margin-bottom: 10px;">Add these lines to your wp-config.php file:</p>
            <div class="code">
define('WP_HOME', '<?php echo $correct_url; ?>');<br>
define('WP_SITEURL', '<?php echo $correct_url; ?>');
            </div>
        </div>

        <div class="alert alert-danger" style="margin-top: 20px;">
            <strong>🗑️ Important Security Note:</strong><br>
            Delete this file (wp-admin-fix.php) immediately after fixing the URLs!
        </div>
    </div>
</body>
</html>