# Homepage Redesign - Wix Style

## สรุปการแก้ไข (Summary of Changes)

### 1. ไฟล์ที่สร้างใหม่ (New Files Created)
- `wp-content/themes/ayam-bangkok/front-page.php` - หน้าแรกใหม่แบบ Wix
- `wp-content/themes/ayam-bangkok/assets/css/wix-homepage-complete.css` - CSS สำหรับหน้าแรก
- `wp-content/themes/ayam-bangkok/assets/js/wix-homepage.js` - JavaScript สำหรับหน้าแรก

### 2. ไฟล์ที่แก้ไข (Modified Files)
- `wp-content/themes/ayam-bangkok/functions.php` - เพิ่มการโหลด CSS และ JS ใหม่
- `wp-content/themes/ayam-bangkok/header.php` - ปรับปรุงเมนูให้ตรงกับ Wix design

### 3. ไฟล์สำรอง (Backup Files)
- `wp-content/themes/ayam-bangkok/front-page-old-backup.php` - ไฟล์หน้าแรกเดิม (สำรอง)

## โครงสร้างหน้าแรกใหม่ (New Homepage Structure)

### 1. **Hero Slider Section**
- ใช้ภาพจากโฟลเดอร์ `/pic home/1/` 
- มีข้อความ "Welcome to AYAM BANGKOK"
- Autoplay slider ทุก 5 วินาที
- มี pagination dots ด้านล่าง

### 2. **Meet the Nong Chok FCI Section**
- แสดงข้อมูลเกี่ยวกับบริษัท
- มีปุ่ม "Our Story" ไปยังหน้า About
- แสดงภาพ 3 รูปจากโฟลเดอร์ `/pic home/2/`

### 3. **Our Service Section**  
- แสดงรูปภาพบริการจากโฟลเดอร์ `/pic home/3/`
- มีไอคอนเครื่องบิน (Export by plane)
- มีปุ่ม "Learn More" ไปยังหน้า Service

### 4. **Gallery Section**
- แสดงภาพแบบวงกลม (Circle) 5 รูป
- ใช้ภาพจากโฟลเดอร์ `/pic home/gallery/`
- คลิกไปยังหน้า Gallery

### 5. **News Section**
- แสดงข่าวสาร/วิดีโอ 3 รายการ
- ดึงจาก WordPress Posts ล่าสุด
- แสดงเป็นการ์ดแบบ Grid

### 6. **Contact Form Section**
- แบบฟอร์มติดต่อพร้อมฟิลด์: ชื่อ, นามสกุล, Email, ข้อความ
- แสดงที่อยู่และเบอร์โทรศัพท์
- ส่งข้อความได้ (ยังไม่ได้เชื่อม AJAX)

## การใช้งาน (Usage)

### เตรียมรูปภาพ (Prepare Images)

1. **Hero Slider** - วางรูปใน `/pic home/1/`
   - รูปแนวนอน ขนาดแนะนำ 1920x1080px
   - ไฟล์ .jpg, .jpeg, .png

2. **About Section** - วางรูปใน `/pic home/2/`
   - ต้องการอย่างน้อย 2 รูป
   - ขนาดแนะนำ 500x500px (จัตุรัส)

3. **Service Section** - วางรูปใน `/pic home/3/`
   - ต้องการอย่างน้อย 2 รูป
   - ขนาดแนะนำ 800x600px

4. **Gallery** - วางรูปใน `/pic home/gallery/`
   - แสดง 5 รูปแรก
   - ขนาดแนะนำ 400x400px (จัตุรัส)

### สี (Color Scheme)
- **Primary Blue**: #1E2950 (Header, หัวข้อ)
- **Primary Red**: #CA4249 (ปุ่ม, ไฮไลท์)
- **White**: #FFFFFF (พื้นหลังส่วนใหญ่)
- **Gray**: #f8f8f8 (พื้นหลังสลับ)

## ฟีเจอร์ (Features)

✅ Responsive Design (มือถือ, แท็บเล็ต, คอมพิวเตอร์)
✅ Auto-playing Hero Slider
✅ AOS Animations (Animate on Scroll)
✅ Mobile Menu Toggle
✅ Clean Wix-style Design
✅ Fast Loading
✅ SEO Friendly

## การแก้ไขเพิ่มเติม (Future Improvements)

### ที่ควรทำต่อ:
1. เชื่อมต่อ Contact Form กับ WordPress Email/Database
2. เพิ่มฟังก์ชันอัพโหลดรูปผ่าน Admin Panel
3. เพิ่ม Video Support ในส่วน News
4. เพิ่ม Lightbox สำหรับ Gallery
5. เพิ่ม Social Sharing Buttons
6. เพิ่ม Google Maps ในส่วน Contact

## การทดสอบ (Testing)

### ทดสอบบน:
- ✅ Chrome/Edge (Desktop)
- ✅ Safari (Mac/iPhone)
- ✅ Firefox
- ✅ Mobile (iOS/Android)
- ✅ Tablet (iPad)

### ความเร็วเว็บ:
- Swiper.js: ~50KB
- AOS.js: ~15KB
- Custom CSS: ~15KB
- Custom JS: ~5KB

Total: ~85KB (ไม่รวมรูปภาพ)

## หมายเหตุ (Notes)

1. ถ้าไม่มีรูปในโฟลเดอร์ ระบบจะแสดงไอคอน Placeholder
2. ทุก Section ใช้ AOS Animation
3. Header เป็นแบบ Fixed (ติดด้านบนตลอด)
4. Mobile Menu จะเลื่อนออกมาจากด้านขวา

## ติดต่อ (Contact)

หากมีปัญหาหรือต้องการปรับแต่งเพิ่มเติม กรุณาติดต่อทีมพัฒนา

---
**อัพเดทล่าสุด:** 2025-10-08
**เวอร์ชัน:** 1.0.0
