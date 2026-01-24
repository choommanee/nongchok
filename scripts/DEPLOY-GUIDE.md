# คู่มือ Deploy สำหรับ Shared Hosting (ไม่มี SSH)

## วิธีที่ 1: FTP Auto-Sync ด้วย VS Code (แนะนำ)

### ขั้นตอน:

1. **ติดตั้ง Extension ใน VS Code:**
   - เปิด VS Code
   - ไปที่ Extensions (Cmd+Shift+X)
   - ค้นหา "SFTP" by Natizyskunk
   - คลิก Install

2. **สร้างไฟล์ Config:**
   - Copy `sftp.json.example` เป็น `.vscode/sftp.json`
   - แก้ไขข้อมูล FTP ของคุณ:
   ```json
   {
       "host": "ftp.yourdomain.com",
       "username": "your-ftp-username",
       "password": "your-ftp-password",
       "remotePath": "/public_html"
   }
   ```

3. **Upload ไฟล์:**
   - คลิกขวาที่โฟลเดอร์หรือไฟล์
   - เลือก "SFTP: Upload"
   - หรือ Cmd+Shift+P → พิมพ์ "SFTP: Sync Local -> Remote"

---

## วิธีที่ 2: FileZilla (Manual Upload)

### ขั้นตอน:

1. **ดาวน์โหลด FileZilla:** https://filezilla-project.org/

2. **เชื่อมต่อ:**
   - Host: `ftp.yourdomain.com`
   - Username: `your-ftp-username`
   - Password: `your-ftp-password`
   - Port: `21`

3. **Upload ไฟล์:**
   - ลากไฟล์จากฝั่งซ้าย (Local) ไปฝั่งขวา (Remote)
   - **ไม่ต้อง upload:**
     - `.git/`
     - `.vscode/`
     - `node_modules/`
     - `wp-config.php` (ต้องสร้างใหม่บนเซิร์ฟเวอร์)

---

## วิธีที่ 3: DirectAdmin File Manager

### ขั้นตอน:

1. **Zip ไฟล์:**
   ```bash
   # บน Mac/Linux
   zip -r nongchok.zip . -x "*.git*" "*.vscode*" "node_modules/*" "wp-config.php"
   ```

2. **Upload ผ่าน DirectAdmin:**
   - เข้า DirectAdmin → File Manager
   - ไปที่ `/public_html`
   - คลิก Upload
   - เลือกไฟล์ `nongchok.zip`
   - คลิกขวาที่ไฟล์ → Extract

3. **ลบไฟล์ zip:**
   - เลือกไฟล์ `nongchok.zip` → Delete

---

## วิธีที่ 4: GitHub Actions + FTP Deploy (Auto Deploy)

### ขั้นตอน:

1. **สร้างไฟล์** `.github/workflows/deploy-ftp.yml`:
   ```yaml
   name: Deploy to Shared Hosting via FTP
   
   on:
     push:
       branches: [ main ]
   
   jobs:
     deploy:
       runs-on: ubuntu-latest
       steps:
       - uses: actions/checkout@v3
       
       - name: FTP Deploy
         uses: SamKirkland/FTP-Deploy-Action@4.3.0
         with:
           server: ${{ secrets.FTP_SERVER }}
           username: ${{ secrets.FTP_USERNAME }}
           password: ${{ secrets.FTP_PASSWORD }}
           server-dir: /public_html/
           exclude: |
             **/.git*
             **/.git*/**
             **/node_modules/**
             **/wp-config.php
   ```

2. **ตั้งค่า Secrets ใน GitHub:**
   - ไปที่ Repository → Settings → Secrets and variables → Actions
   - เพิ่ม Secrets:
     - `FTP_SERVER`: `ftp.yourdomain.com`
     - `FTP_USERNAME`: `your-ftp-username`
     - `FTP_PASSWORD`: `your-ftp-password`

3. **Deploy อัตโนมัติ:**
   - ทุกครั้งที่ push ไป GitHub
   - GitHub Actions จะ upload ไฟล์ไปยัง FTP อัตโนมัติ

---

## ไฟล์ที่ต้องสร้างใหม่บนเซิร์ฟเวอร์

### 1. `wp-config.php`

สร้างไฟล์ใหม่บน DirectAdmin File Manager:

```php
<?php
define('DB_NAME', 'your_database_name');
define('DB_USER', 'your_database_user');
define('DB_PASSWORD', 'your_database_password');
define('DB_HOST', 'localhost');
define('DB_CHARSET', 'utf8mb4');
define('DB_COLLATE', '');

// Site URL
define('WP_HOME', 'https://yourdomain.com');
define('WP_SITEURL', 'https://yourdomain.com');

// Security Keys (สร้างใหม่ที่ https://api.wordpress.org/secret-key/1.1/salt/)
define('AUTH_KEY',         'put your unique phrase here');
define('SECURE_AUTH_KEY',  'put your unique phrase here');
define('LOGGED_IN_KEY',    'put your unique phrase here');
define('NONCE_KEY',        'put your unique phrase here');
define('AUTH_SALT',        'put your unique phrase here');
define('SECURE_AUTH_SALT', 'put your unique phrase here');
define('LOGGED_IN_SALT',   'put your unique phrase here');
define('NONCE_SALT',       'put your unique phrase here');

$table_prefix = 'wp_';

define('WP_DEBUG', false);

if (!defined('ABSPATH')) {
    define('ABSPATH', __DIR__ . '/');
}

require_once ABSPATH . 'wp-settings.php';
```

### 2. `.htaccess`

สร้างไฟล์ใหม่:

```apache
# BEGIN WordPress
<IfModule mod_rewrite.c>
RewriteEngine On
RewriteBase /
RewriteRule ^index\.php$ - [L]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule . /index.php [L]
</IfModule>
# END WordPress
```

---

## Checklist การ Deploy

```
☐ 1. Export ฐานข้อมูลจาก Railway
☐ 2. สร้างฐานข้อมูลใหม่ใน DirectAdmin
☐ 3. Import ฐานข้อมูล
☐ 4. Upload ไฟล์ WordPress (ยกเว้น wp-config.php)
☐ 5. สร้าง wp-config.php ใหม่บนเซิร์ฟเวอร์
☐ 6. สร้าง .htaccess
☐ 7. ตั้งค่า File Permissions (755 folders, 644 files)
☐ 8. Update URL ในฐานข้อมูล
☐ 9. ทดสอบเว็บไซต์
☐ 10. ตั้งค่า SSL Certificate
```

---

## SQL สำหรับ Update URL

เข้า phpMyAdmin ใน DirectAdmin แล้วรันคำสั่ง:

```sql
-- Update site URL
UPDATE wp_options 
SET option_value = 'https://your-new-domain.com' 
WHERE option_name IN ('siteurl', 'home');

-- Update post content
UPDATE wp_posts 
SET post_content = REPLACE(post_content, 
    'https://nongchok-production.up.railway.app', 
    'https://your-new-domain.com');

-- Update GUIDs
UPDATE wp_posts 
SET guid = REPLACE(guid, 
    'https://nongchok-production.up.railway.app', 
    'https://your-new-domain.com');

-- Update meta data
UPDATE wp_postmeta 
SET meta_value = REPLACE(meta_value, 
    'https://nongchok-production.up.railway.app', 
    'https://your-new-domain.com');
```

---

## File Permissions

ตั้งค่าผ่าน DirectAdmin File Manager:

- **Folders:** 755
- **Files:** 644
- **wp-config.php:** 600 (ถ้าตั้งได้)

---

## Tips

1. **Backup ก่อนเสมอ** - ทั้งไฟล์และฐานข้อมูล
2. **ทดสอบบน Staging** - ถ้ามี subdomain ให้ทดสอบก่อน
3. **Clear Cache** - หลัง deploy ให้ clear cache ทั้งเบราว์เซอร์และ WordPress
4. **Monitor Errors** - เปิด WP_DEBUG ชั่วคราวเพื่อดู errors

---

## ปัญหาที่พบบ่อย

### ปัญหา: หน้าเว็บแสดง 404 Not Found
**แก้ไข:** ตรวจสอบ `.htaccess` และ Permalink Settings

### ปัญหา: รูปภาพไม่แสดง
**แก้ไข:** 
1. ตรวจสอบ File Permissions ของโฟลเดอร์ `wp-content/uploads`
2. Update URL ในฐานข้อมูล

### ปัญหา: CSS/JS ไม่โหลด
**แก้ไข:** 
1. Clear cache
2. ตรวจสอบ URL ใน wp_options

---

## สรุป: วิธีที่แนะนำ

**สำหรับ Shared Hosting ไม่มี SSH:**

1. **ใช้ VS Code + SFTP Extension** สำหรับ manual deploy
2. **หรือ GitHub Actions + FTP Deploy** สำหรับ auto deploy

ทั้งสองวิธีใช้งานง่าย ไม่ต้องใช้ SSH!
