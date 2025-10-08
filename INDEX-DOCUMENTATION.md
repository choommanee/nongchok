# 📚 Index - Ayam Bangkok Website Documentation

## ภาพรวมเอกสาร

เอกสารทั้งหมดสำหรับการอัพเดทเว็บไซต์ Ayam Bangkok ตาม 3 Priority หลัก

---

## 🚀 เริ่มต้นที่นี่

### สำหรับผู้ที่ต้องการเริ่มทันที
📄 **[QUICK-START.md](QUICK-START.md)**
- วิธีการเริ่มต้นอย่างรวดเร็ว
- 3 คำสั่งเดียวจบ
- Timeline: 15-20 นาที

### สำหรับผู้ที่ต้องการรายละเอียดครบถ้วน
📄 **[READY-TO-EXECUTE-SUMMARY.md](READY-TO-EXECUTE-SUMMARY.md)**
- สรุปงานทั้งหมด
- Checklist ครบถ้วน
- วิธีแก้ปัญหา
- Timeline: 4 วันทำการ

---

## 📖 เอกสารหลัก

### 1. Priority Tasks
📄 **[PRIORITY-TASKS-2025.md](PRIORITY-TASKS-2025.md)**
- Priority 1: อัพเดทข่าว (28 รายการ)
- Priority 2: อัพเดทรูปภาพ (4 โฟลเดอร์)
- Priority 3: ทำ Responsive (CSS + Testing)
- Checklist แต่ละ Priority
- Timeline แนะนำ

### 2. Image Management
📄 **[PIC-HOME-GUIDE.md](PIC-HOME-GUIDE.md)**
- โครงสร้างโฟลเดอร์ pic home
- การใช้งานรูปภาพในเว็บไซต์
- Scripts อัตโนมัติ
- ขนาดรูปภาพที่แนะนำ
- การแก้ปัญหา

---

## 🔧 Scripts & Tools

### Scripts สำหรับอัพเดทข่าว
📄 **update-news-content-2025.php**
```bash
# รัน Script
php update-news-content-2025.php

# หรือเปิดเบราว์เซอร์
http://your-domain.com/update-news-content-2025.php
```

**ฟีเจอร์:**
- ลบข่าวเก่าทั้งหมด
- เพิ่มข่าวใหม่ 28 รายการ
- สร้างหมวดหมู่ 3 หมวด
- ตั้งค่า metadata และ external links

**ข่าวที่เพิ่ม:**
- ชุดที่ 1: ส่งออกไก่พื้นเมืองไทย "Ayam Bangkok" (14 ลิงก์)
- ชุดที่ 2: ปศุสัตว์ปลื้ม! ดันส่งออก "Ayam Bangkok" (14 ลิงก์)

---

### Scripts สำหรับอัพโหลดรูปภาพ
📄 **upload-all-pic-home-images.php**
```bash
# รัน Script
php upload-all-pic-home-images.php

# หรือเปิดเบราว์เซอร์
http://your-domain.com/upload-all-pic-home-images.php
```

**ฟีเจอร์:**
- อัพโหลดรูปจาก pic home/1/ → Hero Slider
- อัพโหลดรูปจาก pic home/2/ → About Images
- อัพโหลดรูปจาก pic home/3/ → Gallery & News
- อัพโหลดรูปจาก pic home/gallery/ → Rooster Posts
- สร้าง Rooster Posts พร้อม Featured Images
- ตั้งค่า Alt Text และ Metadata

**โครงสร้างโฟลเดอร์:**
```
pic home/
├── 1/          # Hero Slider (3-5 รูป)
├── 2/          # About Section (2-4 รูป)
├── 3/          # Gallery & News (ไม่จำกัด)
└── gallery/    # Rooster Gallery (ไม่จำกัด)
```

---

### CSS สำหรับ Responsive
📄 **wp-content/themes/ayam-bangkok/assets/css/responsive.css**

**ฟีเจอร์:**
- Mobile First Approach
- Breakpoints: 320px, 768px, 1024px, 1280px
- Navigation Menu (Mobile + Desktop)
- Hero Slider (Responsive)
- Grid Layouts (1-4 columns)
- Forms (Touch-friendly)
- Tables (Card layout on mobile)
- Typography (Fluid sizing)

**การใช้งาน:**
```bash
# CSS ถูก enqueue ใน functions.php แล้ว
# แค่ Clear Cache
wp cache flush

# หรือ Hard Refresh
# กด Ctrl+Shift+R
```

---

## 📊 Checklists

### Priority 1: อัพเดทข่าว
- [ ] ตรวจสอบไฟล์ update-news-content-2025.php
- [ ] รัน script
- [ ] ตรวจสอบข่าวใน Admin Panel (28 รายการ)
- [ ] ทดสอบ external links
- [ ] ตรวจสอบหน้า News Archive
- [ ] ตรวจสอบ Single News Pages
- [ ] ตรวจสอบหมวดหมู่ข่าว (3 หมวด)

### Priority 2: อัพเดทรูปภาพ
- [ ] ตรวจสอบโฟลเดอร์ pic home
- [ ] ตรวจสอบโครงสร้างโฟลเดอร์
- [ ] รัน script upload-all-pic-home-images.php
- [ ] ตรวจสอบ Media Library
- [ ] ตรวจสอบ Hero Slider
- [ ] ตรวจสอบหน้า About
- [ ] ตรวจสอบ Gallery Page
- [ ] ตรวจสอบ Rooster Posts

### Priority 3: ทำ Responsive
- [ ] ตรวจสอบไฟล์ responsive.css
- [ ] ตรวจสอบ enqueue ใน functions.php
- [ ] Clear Cache
- [ ] ทดสอบบน Browser DevTools
- [ ] ทดสอบ Navigation Menu
- [ ] ทดสอบ Hero Slider
- [ ] ทดสอบ Grid Layouts
- [ ] ทดสอบ Forms
- [ ] ทดสอบ Tables
- [ ] ทดสอบบน Real Devices
- [ ] ทดสอบ Performance

---

## 🎯 Timeline

### Quick Timeline (15-20 นาที)
| งาน | เวลา |
|-----|------|
| อัพเดทข่าว | 30 วินาที |
| อัพโหลดรูป | 2-5 นาที |
| ทดสอบ Responsive | 10-15 นาที |

### Full Timeline (4 วันทำการ)
| วัน | งาน | เวลา |
|-----|-----|------|
| Day 1 | Priority 1: อัพเดทข่าว | 30 นาที |
| Day 1 | Priority 2: อัพเดทรูปภาพ | 1-2 ชั่วโมง |
| Day 2-3 | Priority 3: ทำ Responsive | 4-8 ชั่วโมง |
| Day 3 | Testing & Bug Fixes | 2-4 ชั่วโมง |
| Day 4 | Final Review & Deploy | 1-2 ชั่วโมง |

---

## 🔍 การค้นหาเอกสาร

### ต้องการ...

#### เริ่มต้นอย่างรวดเร็ว
→ [QUICK-START.md](QUICK-START.md)

#### รายละเอียดทั้งหมด
→ [READY-TO-EXECUTE-SUMMARY.md](READY-TO-EXECUTE-SUMMARY.md)

#### คู่มือแต่ละ Priority
→ [PRIORITY-TASKS-2025.md](PRIORITY-TASKS-2025.md)

#### คู่มือจัดการรูปภาพ
→ [PIC-HOME-GUIDE.md](PIC-HOME-GUIDE.md)

#### แก้ปัญหา
→ [READY-TO-EXECUTE-SUMMARY.md](READY-TO-EXECUTE-SUMMARY.md) (ส่วน Troubleshooting)

#### ทดสอบ Responsive
→ [PRIORITY-TASKS-2025.md](PRIORITY-TASKS-2025.md) (Priority 3)

---

## 🛠️ เครื่องมือที่ต้องใช้

### Development Tools
- **Chrome DevTools** - ทดสอบ Responsive
- **Firefox Developer Tools** - Cross-browser Testing
- **Safari Web Inspector** - iOS Testing

### Testing Tools
- **Lighthouse** - Performance Testing
- **GTmetrix** - Page Speed Analysis
- **BrowserStack** - Cross-browser Testing (Optional)
- **Wave** - Accessibility Testing

### WordPress Plugins
- **Smush** - Image Compression
- **Autoptimize** - CSS/JS Minification
- **WP Super Cache** - Caching

---

## 📝 Best Practices

### ก่อนเริ่มงาน
1. **Backup ข้อมูล**
   ```bash
   wp db export backup-$(date +%Y%m%d).sql
   tar -czf backup-files-$(date +%Y%m%d).tar.gz wp-content/
   ```

2. **ตรวจสอบ Environment**
   ```bash
   php -v              # PHP 7.4+
   wp core version     # WordPress 6.0+
   ```

3. **ทดสอบบน Staging ก่อน** (ถ้ามี)

### ระหว่างทำงาน
1. Clear Cache หลังทุกการเปลี่ยนแปลง
2. ทดสอบบน Real Devices
3. เก็บ Screenshot ของปัญหา
4. Commit Changes เป็นระยะ

### หลังเสร็จงาน
1. ทดสอบทุกฟีเจอร์อีกครั้ง
2. ตรวจสอบ Console Errors
3. รัน Performance Test
4. อัพเดทเอกสาร

---

## 🆘 การแก้ปัญหา

### ปัญหาที่พบบ่อย

#### 1. Script ไม่ทำงาน
```bash
# ตรวจสอบ permissions
chmod 644 *.php

# ลองใช้เบราว์เซอร์แทน
```

#### 2. รูปอัพโหลดไม่ได้
```php
// เพิ่มใน wp-config.php
@ini_set('upload_max_filesize', '64M');
@ini_set('post_max_size', '64M');
@ini_set('memory_limit', '256M');
```

#### 3. CSS ไม่อัพเดท
```bash
# Clear Cache
wp cache flush

# Hard Refresh
# กด Ctrl+Shift+R

# เปลี่ยน version number
# ใน functions.php
```

#### 4. Mobile Menu ไม่ทำงาน
```javascript
// ตรวจสอบ Console (F12)
// ตรวจสอบ jQuery โหลดแล้ว
// ตรวจสอบ selector ถูกต้อง
```

---

## 📞 ติดต่อสอบถาม

หากมีปัญหาหรือข้อสงสัย:
- **Email:** support@ayambangkok.com
- **Line:** @ayambangkok
- **Tel:** 02-XXX-XXXX

---

## 📈 Version History

### Version 1.0 (8 ตุลาคม 2025)
- ✅ สร้างเอกสารทั้งหมด
- ✅ สร้าง Scripts สำหรับอัพเดทข่าว
- ✅ สร้าง Scripts สำหรับอัพโหลดรูปภาพ
- ✅ สร้าง CSS สำหรับ Responsive
- ✅ เพิ่ม Responsive CSS เข้า functions.php
- ✅ สร้างคู่มือครบถ้วน

---

## 🎉 สรุป

เอกสารทั้งหมดพร้อมใช้งาน:

### 📚 เอกสารหลัก (4 ไฟล์)
1. ✅ QUICK-START.md
2. ✅ READY-TO-EXECUTE-SUMMARY.md
3. ✅ PRIORITY-TASKS-2025.md
4. ✅ PIC-HOME-GUIDE.md

### 🔧 Scripts (2 ไฟล์)
1. ✅ update-news-content-2025.php
2. ✅ upload-all-pic-home-images.php

### 🎨 CSS (1 ไฟล์)
1. ✅ responsive.css (+ enqueued in functions.php)

### 📖 Index (1 ไฟล์)
1. ✅ INDEX-DOCUMENTATION.md (ไฟล์นี้)

**รวมทั้งหมด: 8 ไฟล์**

---

## 🚀 เริ่มต้นเลย!

1. อ่าน [QUICK-START.md](QUICK-START.md)
2. รัน Scripts
3. ทดสอบ Responsive
4. เสร็จสิ้น! 🎉

**Happy Coding!** 🚀

---

**อัพเดทล่าสุด:** 8 ตุลาคม 2025  
**เวอร์ชัน:** 1.0  
**สถานะ:** ✅ พร้อมใช้งาน
