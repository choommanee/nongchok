# 🖼️ คู่มือจัดการรูปภาพจาก Pic Home

## 📁 โครงสร้างโฟลเดอร์ Pic Home

ตามที่คุณระบุ รูปภาพอยู่ในโฟลเดอร์ `pic home` ดังนี้:

```
pic home/
├── 1/          # รูปสำหรับ Hero Slider (หน้าแรก)
├── 2/          # รูปสำหรับ About Section  
├── 3/          # รูปสำหรับ Gallery และ News
│   └── 4593265_Plane_Airplane_4096x2304.mov  # วิดีโอ
└── gallery/    # รูปไก่ชนสำหรับ Gallery
```

---

## 🎯 การใช้งานรูปภาพในเว็บไซต์

### 1. 🏠 Homepage Slider (จากโฟลเดอร์ `pic home/1/`)

**ใช้สำหรับ:** Hero Slider บนหน้าแรก  
**ขนาดแนะนำ:** 1920x1080px หรือ 16:9  
**จำนวน:** 3-5 รูป  
**วิธีอัปโหลด:**

1. ไปที่ WordPress Admin → Media → Add New
2. อัปโหลดรูปจากโฟลเดอร์ `pic home/1/`
3. ไปที่ Appearance → Slider Settings
4. เลือกรูปที่อัปโหลดและเพิ่มข้อความ
5. บันทึก

**หรือใช้ script อัตโนมัติ:**
```bash
php upload-slider-images.php
```

---

### 2. 📖 About Section (จากโฟลเดอร์ `pic home/2/`)

**ใช้สำหรับ:** หน้า About Us  
**ขนาดแนะนำ:** 800x600px  
**จำนวน:** 2-4 รูป  
**วิธีอัปโหลด:**

1. ไปที่ Pages → About
2. อัปโหลดรูปจากโฟลเดอร์ `pic home/2/`
3. เพิ่มรูปในเนื้อหาหน้า About
4. Update

---

### 3. 🖼️ Gallery & News (จากโฟลเดอร์ `pic home/3/`)

**ใช้สำหรับ:** Gallery และข่าวสาร  
**ขนาดแนะนำ:** 1200x800px  
**จำนวน:** ไม่จำกัด  
**วิธีอัปโหลด:**

**สำหรับ Gallery:**
1. ไปที่ Pages → Gallery
2. อัปโหลดรูปจากโฟลเดอร์ `pic home/3/`
3. เพิ่มรูปในแกลเลอรี่
4. Update

**สำหรับ News:**
1. ไปที่ News → Add New
2. อัปโหลดรูปเป็น Featured Image
3. Publish

**หมายเหตุ:** มีไฟล์วิดีโอ `4593265_Plane_Airplane_4096x2304.mov` ในโฟลเดอร์นี้ สามารถใช้เป็น background video ได้

---

### 4. 🐓 Rooster Gallery (จากโฟลเดอร์ `pic home/gallery/`)

**ใช้สำหรับ:** แกลเลอรี่ไก่ชน  
**ขนาดแนะนำ:** 800x800px (สี่เหลี่ยมจัตุรัส)  
**จำนวน:** ไม่จำกัด  
**วิธีอัปโหลด:**

1. ไปที่ Roosters → Add New
2. อัปโหลดรูปจากโฟลเดอร์ `pic home/gallery/`
3. ตั้งเป็น Featured Image
4. เพิ่มข้อมูลไก่ชน
5. Publish

**หรือใช้ script อัตโนมัติ:**
```bash
php upload-rooster-gallery.php
```

---

## 🚀 Scripts อัตโนมัติที่พร้อมใช้งาน

### 1. อัปโหลด Slider Images
```bash
php upload-slider-images.php
```
- อัปโหลดรูปจาก `pic home/1/` ไปยัง Media Library
- สร้าง Slider Slides อัตโนมัติ
- ตั้งค่า Slider Settings

### 2. อัปโหลด Rooster Gallery
```bash
php upload-rooster-gallery.php
```
- อัปโหลดรูปจาก `pic home/gallery/` ไปยัง Media Library
- สร้าง Rooster Posts อัตโนมัติ
- ตั้งค่า Featured Images

### 3. อัปโหลดรูปทั้งหมด
```bash
php upload-all-pic-home-images.php
```
- อัปโหลดรูปจากทุกโฟลเดอร์ใน `pic home/`
- จัดหมวดหมู่อัตโนมัติ
- พร้อมใช้งานทันที

---

## 📋 Checklist การอัปโหลดรูปภาพ

### Priority 1: Homepage Slider ⭐⭐⭐
- [ ] อัปโหลดรูปจาก `pic home/1/` (3-5 รูป)
- [ ] ตั้งค่า Slider Settings
- [ ] ทดสอบ Slider บนหน้าแรก

### Priority 2: Rooster Gallery ⭐⭐
- [ ] อัปโหลดรูปจาก `pic home/gallery/`
- [ ] สร้าง Rooster Posts
- [ ] ตั้งค่า Featured Images

### Priority 3: About Section ⭐
- [ ] อัปโหลดรูปจาก `pic home/2/`
- [ ] เพิ่มรูปในหน้า About
- [ ] ตรวจสอบ Layout

### Priority 4: Gallery & News
- [ ] อัปโหลดรูปจาก `pic home/3/`
- [ ] เพิ่มรูปใน Gallery
- [ ] เพิ่มรูปใน News Posts

---

## ⚙️ ขนาดรูปภาพที่แนะนำ

| ตำแหน่ง | ขนาด | Aspect Ratio |
|---------|------|--------------|
| Hero Slider | 1920x1080px | 16:9 |
| About Images | 800x600px | 4:3 |
| Gallery Images | 1200x800px | 3:2 |
| Rooster Images | 800x800px | 1:1 |
| News Featured | 1200x630px | 1.91:1 |

---

## 🔧 การปรับแต่งรูปภาพ

### ใช้ WordPress Image Editor:
1. ไปที่ Media Library
2. คลิกที่รูปที่ต้องการแก้ไข
3. คลิก "Edit Image"
4. ปรับขนาด, ครอป, หมุน
5. บันทึก

### ใช้ Plugin (แนะนำ):
- **Smush** - ลดขนาดไฟล์อัตโนมัติ
- **Regenerate Thumbnails** - สร้างขนาดรูปใหม่
- **Enable Media Replace** - แทนที่รูปเดิม

---

## 📝 หมายเหตุสำคัญ

1. **ขนาดไฟล์:** ควรไม่เกิน 500KB ต่อรูป เพื่อความเร็วในการโหลด
2. **รูปแบบไฟล์:** แนะนำ JPG สำหรับรูปถ่าย, PNG สำหรับกราฟิก
3. **ชื่อไฟล์:** ใช้ชื่อที่มีความหมาย เช่น `ayam-bangkok-rooster-01.jpg`
4. **Alt Text:** เพิ่ม Alt Text ทุกรูปเพื่อ SEO
5. **Backup:** สำรองรูปต้นฉบับไว้ก่อนอัปโหลด

---

## 🆘 แก้ปัญหาที่พบบ่อย

### รูปไม่แสดง
- ตรวจสอบ File Permissions (755 สำหรับโฟลเดอร์, 644 สำหรับไฟล์)
- ตรวจสอบ URL ของรูป
- Clear Cache

### รูปเบลอ
- อัปโหลดรูปขนาดใหญ่กว่า
- ใช้ Plugin Regenerate Thumbnails

### อัปโหลดไม่ได้
- ตรวจสอบ PHP upload_max_filesize
- ตรวจสอบ PHP post_max_size
- ตรวจสอบ PHP memory_limit

---

## 📞 ติดต่อสอบถาม

หากมีปัญหาหรือข้อสงสัย กรุณาติดต่อ:
- Email: support@ayambangkok.com
- Line: @ayambangkok
- Tel: 02-XXX-XXXX

---

**อัพเดทล่าสุด:** 8 ตุลาคม 2025  
**เวอร์ชัน:** 1.0
