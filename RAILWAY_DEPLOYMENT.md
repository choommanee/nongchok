# Railway Deployment Guide - Ayam Bangkok WordPress

## 🚀 Quick Deploy Steps

### 1. เชื่อมต่อ GitHub กับ Railway
1. ไปที่ [Railway.app](https://railway.app)
2. คลิก "New Project" → "Deploy from GitHub repo"
3. เลือก repository: `choommanee/nongchok`

### 2. ตั้งค่า Environment Variables
ใน Railway Dashboard → Variables → เพิ่ม:

```
MYSQL_HOST=nozomi.proxy.rlwy.net:42710
MYSQL_USER=root
MYSQL_PASSWORD=jNgCrBkMdKXzXMKukfrZNDcZsjjJPXiw
MYSQL_DATABASE=railway
PORT=8080
```

### 3. เปลี่ยน wp-config.php
```bash
# ใน Railway Dashboard → Settings → Start Command
cp wp-config-railway.php wp-config.php && php -S 0.0.0.0:$PORT -t .
```

### 4. Deploy!
Railway จะ auto-deploy ทุกครั้งที่ push ไป GitHub

## 📝 หมายเหตุ

### Database
- ✅ Database ถูก import แล้วที่ Railway MySQL
- ✅ ข้อมูล About page พร้อมใช้งาน

### Theme Files
- Theme: `wp-content/themes/ayam-bangkok`
- CSS: Wix-style homepage และ about page
- Features: Slider, Gallery, News, Services, Contact

### ไฟล์สำคัญ
- `nixpacks.toml` - PHP configuration
- `railway.json` - Railway deployment config
- `wp-config-railway.php` - Database config สำหรับ Railway

## 🔧 Alternative: ใช้ Dockerfile

ถ้า Nixpacks ไม่ work สามารถใช้ Dockerfile:

```dockerfile
FROM php:8.2-apache

# Install extensions
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Enable Apache modules
RUN a2enmod rewrite

# Copy WordPress files
COPY . /var/www/html/

# Set permissions
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
```

## 🌐 หลังจาก Deploy

1. ไปที่ URL ที่ Railway สร้างให้ (เช่น `https://nongchok-production.up.railway.app`)
2. Login: `/wp-admin`
3. ตั้งค่า Permalinks: Settings → Permalinks → Post name
4. เช็คหน้า About Us: เลือก Template "About Us - Wix Style"

## 🐛 Troubleshooting

### ถ้า Database connection error:
```bash
# เช็ค environment variables ใน Railway
echo $MYSQL_HOST
echo $MYSQL_USER
```

### ถ้า CSS/JS ไม่โหลด:
- เช็ค Site URL ใน wp-config.php
- Clear browser cache
- เช็ค file permissions

### ถ้า 500 Error:
- เช็ค PHP error logs ใน Railway Dashboard
- เพิ่ม WP_DEBUG = true ใน wp-config.php ชั่วคราว
