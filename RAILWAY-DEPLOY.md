# Railway Deployment Instructions

## Prerequisites

คุณต้องมี Railway account และ Railway CLI ติดตั้งแล้ว

## ขั้นตอนการ Deploy

### 1. เพิ่ม MySQL Database ใน Railway

1. เข้า Railway Dashboard (https://railway.app/dashboard)
2. เลือก Project ของคุณ
3. คลิก "New Service" → "Database" → "MySQL"
4. รอให้ MySQL service สร้างเสร็จ

### 2. ตั้งค่า Environment Variables

ใน Railway Dashboard, เข้าไปที่ WordPress service และเพิ่ม variables ต่อไปนี้:

```
RAILWAY_ENVIRONMENT=production
```

**หมายเหตุ**: MySQL credentials (MYSQL_DATABASE, MYSQL_USER, MYSQL_PASSWORD, MYSQL_HOST) จะถูกสร้างอัตโนมัติเมื่อคุณเพิ่ม MySQL service

### 3. Export และ Import Database

#### Export จาก Local:

```bash
# Export ฐานข้อมูล local
mysqldump -u root nongchok > nongchok-backup.sql
```

#### Import ไป Railway:

```bash
# ใช้ Railway CLI connect ไปยัง MySQL
railway run mysql -u root -p$MYSQL_PASSWORD -h $MYSQL_HOST $MYSQL_DATABASE < nongchok-backup.sql
```

หรือใช้ phpMyAdmin / MySQL Workbench connect ไปยัง Railway MySQL และ import file SQL

### 4. Push Code ไป Railway

```bash
git add .
git commit -m "Update for Railway deployment"
git push railway main
```

### 5. ตรวจสอบ Build Logs

เข้า Railway Dashboard และดู Build Logs ว่า:
- ✅ railway-build.sh ทำงานสำเร็จ
- ✅ wp-config.php ถูก copy จาก wp-config-production.php
- ✅ PHP server เริ่มทำงาน

### 6. อัพเดท Site URL ในฐานข้อมูล (ถ้าจำเป็น)

หลังจาก deploy แล้ว, คุณอาจต้องอัพเดท WordPress site URLs:

```bash
# Connect ไปยัง Railway MySQL
railway run mysql -u root -p$MYSQL_PASSWORD -h $MYSQL_HOST $MYSQL_DATABASE

# Run SQL commands:
UPDATE wp_options SET option_value = 'https://your-app.railway.app' WHERE option_name = 'siteurl';
UPDATE wp_options SET option_value = 'https://your-app.railway.app' WHERE option_name = 'home';
```

## วิธีการตรวจสอบ

### ตรวจสอบว่า wp-config.php ถูกสร้างถูกต้อง:

```bash
railway run cat wp-config.php | head -20
```

### ตรวจสอบ Environment Variables:

```bash
railway run env | grep MYSQL
```

### ตรวจสอบ Database Connection:

```bash
railway run php -r "echo defined('DB_HOST') ? 'DB_HOST: ' . DB_HOST : 'wp-config not loaded';"
```

## การแก้ไขปัญหา

### ปัญหา: WordPress ขอให้ติดตั้งใหม่

**สาเหตุ**: ฐานข้อมูลยังว่างเปล่า

**วิธีแก้**: Import database จาก local ตามขั้นตอนที่ 3

### ปัญหา: Error establishing database connection

**สาเหตุ**: Environment variables ไม่ถูกต้อง

**วิธีแก้**:
1. ตรวจสอบว่ามี MySQL service ใน Railway
2. ตรวจสอบว่า RAILWAY_ENVIRONMENT ถูกตั้งค่าเป็น "production"
3. ตรวจสอบ MySQL credentials ด้วย `railway run env | grep MYSQL`

### ปัญหา: Build failed

**สาเหตุ**: railway-build.sh หรือ wp-config-production.php ไม่อยู่ใน repository

**วิธีแก้**: ตรวจสอบว่าไฟล์ทั้งสองถูก commit และ push แล้ว

## ไฟล์สำคัญ

- `wp-config-production.php` - Production config template
- `railway-build.sh` - Build script สำหรับ copy config
- `nixpacks.toml` - Railway build configuration
- `.gitignore` - ต้องมี wp-config.php (แต่ไม่มี wp-config-production.php)

## หมายเหตุ

- wp-config.php จะถูกสร้างใหม่ทุกครั้งที่ deploy (จาก wp-config-production.php)
- ห้ามแก้ wp-config.php โดยตรงใน Railway
- ถ้าต้องการเปลี่ยนแปลง config ให้แก้ที่ wp-config-production.php และ push ใหม่
