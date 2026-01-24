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
