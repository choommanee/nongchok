# Production Setup Instructions

## 1. Fix WordPress URLs

รันคำสั่งนี้บน Railway shell เพื่อแก้ไข URLs:

```bash
php fix-production-urls.php
```

URL ที่ถูกต้องควรเป็น:
- Home: `https://nongchok-production.up.railway.app`
- Site URL: `https://nongchok-production.up.railway.app`

หลังจากรันแล้ว admin URL จะเป็น:
```
https://nongchok-production.up.railway.app/wp-admin/admin.php?page=ayam-gallery-images
```

---

## 2. Setup Gallery System

### 2.1 Create Database Tables

รันคำสั่งนี้เพื่อสร้างตาราง:

```bash
php upload-gallery-categories.php
```

หรือรันผ่าน MySQL:

```sql
CREATE TABLE IF NOT EXISTS wp_gallery_categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_code VARCHAR(50) NOT NULL,
    category_name VARCHAR(255) NOT NULL,
    description TEXT,
    thumbnail VARCHAR(500),
    image_count INT DEFAULT 0,
    display_order INT DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY (category_code)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS wp_gallery_images (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT NOT NULL,
    image_path VARCHAR(500) NOT NULL,
    image_url VARCHAR(500) NOT NULL,
    image_name VARCHAR(255),
    file_size INT,
    display_order INT DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    KEY category_id (category_id),
    FOREIGN KEY (category_id) REFERENCES wp_gallery_categories(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

### 2.2 Upload Images to External Storage

เนื่องจาก Railway ไม่รองรับการเขียนไฟล์ถาวร ต้องใช้ External Storage:

**Option A: Google Drive**
1. อัพโหลดโฟลเดอร์ `gallery-categories/` ไป Google Drive
2. แชร์ folder เป็น Public
3. ใช้ Google Drive direct links

**Option B: Cloudinary (แนะนำ)**
```bash
# Install Cloudinary CLI
npm install -g cloudinary-cli

# Login
cloudinary config

# Upload all images
cloudinary uploader upload_large /path/to/gallery-categories/* --folder=nongchok/gallery
```

**Option C: AWS S3**
```bash
# Upload via AWS CLI
aws s3 sync wp-content/uploads/gallery-categories/ s3://your-bucket/gallery-categories/
```

### 2.3 Update Database URLs

หลังอัพโหลดไป external storage แล้ว อัพเดท URLs:

```sql
UPDATE wp_gallery_categories
SET thumbnail = REPLACE(thumbnail,
    'http://nongchok.local/wp-content/uploads/',
    'https://your-cdn-url.com/');

UPDATE wp_gallery_images
SET image_url = REPLACE(image_url,
    'http://nongchok.local/wp-content/uploads/',
    'https://your-cdn-url.com/');
```

---

## 3. Create Gallery Page

1. ไปที่ **Pages → Add New**
2. ตั้งชื่อ: "Gallery" หรือ "Rooster Gallery"
3. เลือก Template: **"Rooster Gallery (With Categories)"**
4. Publish

---

## 4. Access Admin

เข้าระบบจัดการ Gallery:
```
https://nongchok-production.up.railway.app/wp-admin/admin.php?page=ayam-gallery-images
```

---

## 5. Verify

ตรวจสอบว่าทุกอย่างทำงาน:

- [ ] Admin URL ใช้งานได้ (`/wp-admin/admin.php?page=...`)
- [ ] Database tables ถูกสร้าง
- [ ] Gallery page แสดงผล
- [ ] รูปภาพโหลดได้จาก external storage

---

## Troubleshooting

### ปัญหา: Admin URL ไม่ถูกต้อง
```bash
php fix-production-urls.php
```

### ปัญหา: รูปภาพไม่แสดง
1. เช็คว่าอัพโหลดไป external storage แล้ว
2. เช็ค URLs ใน database ถูกต้อง
3. เช็ค CORS settings (ถ้าใช้ S3/Cloudinary)

### ปัญหา: ตาราง database ไม่มี
```bash
php upload-gallery-categories.php
```

หรือรัน SQL commands ข้างบนโดยตรง
