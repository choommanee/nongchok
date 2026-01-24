#!/bin/bash

echo "🚀 Preparing for DirectAdmin deployment..."
echo ""

# 1. Create production database backup
echo "📦 Creating fresh database backup..."
mysqldump -u root nongchok > backups/nongchok_production_ready_$(date +%Y%m%d_%H%M%S).sql

if [ $? -eq 0 ]; then
    echo "✅ Database backup created"
else
    echo "❌ Database backup failed"
    exit 1
fi

# 2. Create uploads archive
echo ""
echo "📦 Creating uploads archive..."
cd ../wp-content
tar -czf ../scripts/backups/uploads_production_ready_$(date +%Y%m%d).tar.gz uploads/
cd ..

if [ $? -eq 0 ]; then
    echo "✅ Uploads archive created"
else
    echo "❌ Uploads archive failed"
    exit 1
fi

# 3. Create wp-config template for production
echo ""
echo "📝 Creating wp-config template for DirectAdmin..."
cat > scripts/wp-config-directadmin.php << 'EOF'
<?php
/**
 * WordPress Configuration for DirectAdmin
 * 
 * INSTRUCTIONS:
 * 1. Copy this file to wp-config.php on DirectAdmin
 * 2. Update the database credentials below
 * 3. Update the domain URL
 * 4. Generate new security keys from: https://api.wordpress.org/secret-key/1.1/salt/
 */

// ** Database Settings - UPDATE THESE ** //
define('DB_NAME', 'your_database_name');
define('DB_USER', 'your_database_user');
define('DB_PASSWORD', 'your_database_password');
define('DB_HOST', 'localhost');
define('DB_CHARSET', 'utf8mb4');
define('DB_COLLATE', '');

// ** Site URL - UPDATE THIS ** //
define('WP_HOME', 'https://yourdomain.com');
define('WP_SITEURL', 'https://yourdomain.com');

// ** Security Keys - GENERATE NEW ONES ** //
// Get from: https://api.wordpress.org/secret-key/1.1/salt/
define('AUTH_KEY',         'put your unique phrase here');
define('SECURE_AUTH_KEY',  'put your unique phrase here');
define('LOGGED_IN_KEY',    'put your unique phrase here');
define('NONCE_KEY',        'put your unique phrase here');
define('AUTH_SALT',        'put your unique phrase here');
define('SECURE_AUTH_SALT', 'put your unique phrase here');
define('LOGGED_IN_SALT',   'put your unique phrase here');
define('NONCE_SALT',       'put your unique phrase here');

// ** WordPress Database Table prefix ** //
$table_prefix = 'wp_';

// ** Production Settings ** //
define('WP_DEBUG', false);
define('WP_DEBUG_LOG', false);
define('WP_DEBUG_DISPLAY', false);
@ini_set('display_errors', 0);

// ** Memory Limits ** //
define('WP_MEMORY_LIMIT', '256M');
define('WP_MAX_MEMORY_LIMIT', '512M');

// ** File Permissions ** //
define('FS_METHOD', 'direct');

if (!defined('ABSPATH')) {
    define('ABSPATH', __DIR__ . '/');
}

require_once ABSPATH . 'wp-settings.php';
EOF

echo "✅ wp-config template created"

# 4. Create deployment checklist
echo ""
echo "📋 Creating deployment checklist..."
cat > scripts/DEPLOYMENT-CHECKLIST.md << 'EOF'
# DirectAdmin Deployment Checklist

## Pre-Deployment (On Localhost)

- [x] Database backup created
- [x] Uploads folder archived
- [x] wp-config template created
- [ ] Test all pages work correctly
- [ ] Test gallery images display
- [ ] Test news posts display
- [ ] Test contact forms

## DirectAdmin Setup

### 1. Create Database
1. Login to DirectAdmin
2. Go to **MySQL Management**
3. Click **Create new database**
4. Database name: `your_db_name`
5. Username: `your_db_user`
6. Password: (generate strong password)
7. **Save credentials!**

### 2. Import Database
1. Go to **phpMyAdmin**
2. Select your database
3. Click **Import** tab
4. Choose file: `nongchok_production_ready_YYYYMMDD_HHMMSS.sql`
5. Click **Go**
6. Wait for import to complete

### 3. Update URLs in Database
Run these SQL commands in phpMyAdmin:

```sql
-- Update site URL (CHANGE yourdomain.com to your actual domain)
UPDATE wp_options 
SET option_value = 'https://yourdomain.com' 
WHERE option_name IN ('siteurl', 'home');

-- Update post content URLs
UPDATE wp_posts 
SET post_content = REPLACE(post_content, 
    'https://nongchok.local', 
    'https://yourdomain.com');

-- Update GUIDs
UPDATE wp_posts 
SET guid = REPLACE(guid, 
    'https://nongchok.local', 
    'https://yourdomain.com');

-- Update meta data
UPDATE wp_postmeta 
SET meta_value = REPLACE(meta_value, 
    'https://nongchok.local', 
    'https://yourdomain.com');
```

### 4. Upload Files

#### Option A: Via FTP (FileZilla)
1. Connect to FTP
2. Go to `/public_html/`
3. Upload all WordPress files EXCEPT:
   - `wp-config.php` (will create new)
   - `.git/` folder
   - `scripts/` folder
   - `.env` file
4. Upload `uploads_production_ready_YYYYMMDD.tar.gz`
5. Extract via DirectAdmin File Manager

#### Option B: Via DirectAdmin File Manager
1. Zip WordPress files locally (exclude wp-config.php, .git, scripts)
2. Upload zip via File Manager
3. Extract on server
4. Upload uploads archive
5. Extract to `wp-content/uploads/`

### 5. Create wp-config.php
1. Copy `scripts/wp-config-directadmin.php` content
2. Create new file `wp-config.php` in DirectAdmin File Manager
3. Update:
   - Database credentials
   - Domain URL
   - Generate new security keys from: https://api.wordpress.org/secret-key/1.1/salt/
4. Save file

### 6. Set File Permissions
Via DirectAdmin File Manager or FTP:
- Folders: `755`
- Files: `644`
- `wp-config.php`: `600` (if possible)

### 7. Setup SSL Certificate
1. Go to DirectAdmin → **SSL Certificates**
2. Enable **Let's Encrypt**
3. Wait for certificate to be issued
4. Test HTTPS access

## Post-Deployment Testing

- [ ] Visit homepage: `https://yourdomain.com`
- [ ] Test admin login: `https://yourdomain.com/wp-admin`
- [ ] Check all pages load correctly
- [ ] Verify images display (check uploads folder)
- [ ] Test gallery page
- [ ] Test news posts
- [ ] Test contact forms
- [ ] Check mobile responsiveness
- [ ] Test all internal links

## Troubleshooting

### Issue: "Error establishing a database connection"
**Fix:** Check wp-config.php database credentials

### Issue: Images not displaying
**Fix:** 
1. Check uploads folder exists: `wp-content/uploads/`
2. Check file permissions: folders 755, files 644
3. Verify URLs in database are correct

### Issue: 404 errors on pages
**Fix:**
1. Check .htaccess file exists
2. Go to Settings → Permalinks
3. Click "Save Changes" (regenerates .htaccess)

### Issue: CSS/JS not loading
**Fix:**
1. Clear browser cache
2. Check file permissions
3. Verify URLs in wp_options table

## Important Files Locations

```
/public_html/
├── wp-config.php (create new on server)
├── wp-content/
│   ├── uploads/ (extract from archive)
│   ├── themes/ayam-bangkok/
│   └── plugins/
├── .htaccess (WordPress will create)
└── index.php
```

## Database Backup Schedule

Set up automatic backups in DirectAdmin:
1. Go to **MySQL Management**
2. Enable **Automatic Backups**
3. Set frequency: Daily
4. Keep: 7 days

## Support

If you encounter issues:
1. Check DirectAdmin error logs
2. Enable WP_DEBUG temporarily
3. Check PHP error logs
4. Contact hosting support if needed
EOF

echo "✅ Deployment checklist created"

# 5. Summary
echo ""
echo "========================================="
echo "✅ Production deployment package ready!"
echo "========================================="
echo ""
echo "📁 Files created:"
echo "  - backups/nongchok_production_ready_*.sql"
echo "  - backups/uploads_production_ready_*.tar.gz"
echo "  - wp-config-directadmin.php"
echo "  - DEPLOYMENT-CHECKLIST.md"
echo ""
echo "📖 Next steps:"
echo "  1. Read: scripts/DEPLOYMENT-CHECKLIST.md"
echo "  2. Setup database in DirectAdmin"
echo "  3. Upload files via FTP or File Manager"
echo "  4. Import database"
echo "  5. Create wp-config.php with correct credentials"
echo "  6. Update URLs in database"
echo "  7. Test website"
echo ""
echo "🚀 Ready to deploy to DirectAdmin!"
echo "========================================="
