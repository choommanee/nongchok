# 🎯 Priority Tasks 2025 - Ayam Bangkok Website

## สรุปงานที่ต้องทำตาม Priority

---

## ✅ Priority 1: อัพเดทข่าวตามลิงก์ใหม่

### 📋 รายละเอียด
อัพเดทข่าวสารล่าสุดเกี่ยวกับการส่งออกไก่พื้นเมืองไทย "Ayam Bangkok" ไปยังอินโดนีเซีย

### 📰 ข่าวที่ต้องเพิ่ม

#### ชุดที่ 1: ส่งออกไก่พื้นเมืองไทย "Ayam Bangkok" ไปอินโด โตต่อเนื่อง มูลค่า 4 ล้านบาท
- ข่าวสด
- ประชาชาติธุรกิจ
- บ้านเมือง
- กรุงเทพธุรกิจ
- เกษตรข่าวไทย
- เกษตรเก่าใหม่
- เกษตรตำกิน
- Thailand Plus
- Twitter
- Facebook (5 ลิงก์)

**รวม: 14 ลิงก์**

#### ชุดที่ 2: ปศุสัตว์ปลื้ม! ดันส่งออก "Ayam Bangkok" ไทยแลนด์สู่อินโดนีเซีย เพิ่มจำนวนต่อเนื่อง
- เดลินิวส์
- แนวหน้า
- บ้านเมือง
- เกษตรข่าวไทย
- แต๊กประเดนนิวส์
- Lens News
- The Thai Press
- Livestock E-Magazine
- Thailand Plus TV
- Sootin Claimon
- X (Twitter)
- Facebook (3 ลิงก์)

**รวม: 14 ลิงก์**

### 🚀 วิธีการอัพเดท

#### วิธีที่ 1: ใช้ Script อัตโนมัติ (แนะนำ)
```bash
php update-news-content-2025.php
```

Script นี้จะ:
1. ลบข่าวเก่าทั้งหมด
2. เพิ่มข่าวใหม่ 28 รายการ
3. สร้างหมวดหมู่ข่าว 3 หมวด:
   - ความสำเร็จการส่งออก
   - ข่าวสื่อมวลชน
   - การสนับสนุนจากภาครัฐ
4. ตั้งค่า metadata และ external links

#### วิธีที่ 2: เพิ่มทีละข่าว (Manual)
1. ไปที่ WordPress Admin → News → Add New
2. ใส่ชื่อข่าว
3. เพิ่ม external link ใน custom field
4. เลือกหมวดหมู่
5. Publish

### ✅ Checklist
- [ ] รัน script `update-news-content-2025.php`
- [ ] ตรวจสอบข่าวใน Admin Panel
- [ ] ทดสอบ external links ทั้งหมด
- [ ] ตรวจสอบหน้า News Archive
- [ ] ตรวจสอบ Single News Pages

---

## ✅ Priority 2: อัพเดทรูปตาม pic home

### 📁 โครงสร้างโฟลเดอร์

```
pic home/
├── 1/          # Hero Slider (3-5 รูป)
├── 2/          # About Section (2-4 รูป)
├── 3/          # Gallery & News (ไม่จำกัด)
│   └── 4593265_Plane_Airplane_4096x2304.mov
└── gallery/    # Rooster Gallery (ไม่จำกัด)
```

### 🎯 การใช้งานรูปภาพ

| โฟลเดอร์ | ใช้สำหรับ | ขนาดแนะนำ | จำนวน |
|----------|-----------|-----------|-------|
| `pic home/1/` | Hero Slider | 1920x1080px | 3-5 รูป |
| `pic home/2/` | About Section | 800x600px | 2-4 รูป |
| `pic home/3/` | Gallery & News | 1200x800px | ไม่จำกัด |
| `pic home/gallery/` | Rooster Gallery | 800x800px | ไม่จำกัด |

### 🚀 วิธีการอัพโหลด

#### วิธีที่ 1: ใช้ Script อัตโนมัติ (แนะนำ)
```bash
php upload-all-pic-home-images.php
```

Script นี้จะ:
1. อัปโหลดรูปจาก `pic home/1/` → Hero Slider
2. อัปโหลดรูปจาก `pic home/2/` → About Images
3. อัปโหลดรูปจาก `pic home/3/` → Gallery & News
4. อัปโหลดรูปจาก `pic home/gallery/` → Rooster Posts
5. สร้าง Rooster Posts พร้อม Featured Images
6. ตั้งค่า Alt Text และ Metadata

#### วิธีที่ 2: อัพโหลดทีละส่วน
```bash
# อัพโหลดเฉพาะ Slider
php upload-slider-images.php

# อัพโหลดเฉพาะ Rooster Gallery
php upload-rooster-gallery.php
```

#### วิธีที่ 3: อัพโหลด Manual
1. ไปที่ WordPress Admin → Media → Add New
2. เลือกรูปจากโฟลเดอร์ที่ต้องการ
3. อัปโหลด
4. ตั้งค่า Title, Alt Text, Description
5. ใช้รูปในหน้าที่ต้องการ

### ✅ Checklist
- [ ] ตรวจสอบโฟลเดอร์ `pic home` มีอยู่จริง
- [ ] รัน script `upload-all-pic-home-images.php`
- [ ] ตรวจสอบ Media Library
- [ ] ตรวจสอบ Hero Slider บนหน้าแรก
- [ ] ตรวจสอบหน้า About
- [ ] ตรวจสอบ Gallery Page
- [ ] ตรวจสอบ Rooster Posts
- [ ] ทดสอบ Responsive Design

### 📝 หมายเหตุ
- มีไฟล์วิดีโอ `4593265_Plane_Airplane_4096x2304.mov` ในโฟลเดอร์ `pic home/3/`
- สามารถใช้เป็น background video ได้
- ต้องแปลงเป็น web-friendly format (MP4, WebM) ก่อนใช้งาน

---

## ✅ Priority 3: ทำ Responsive ให้ดีขึ้น

### 🎯 เป้าหมาย
ปรับปรุง Responsive Design ให้แสดงผลได้ดีบนทุกอุปกรณ์

### 📱 Breakpoints ที่ต้องทดสอบ

| Device | Width | Priority |
|--------|-------|----------|
| Mobile (Portrait) | 320px - 480px | ⭐⭐⭐ |
| Mobile (Landscape) | 481px - 767px | ⭐⭐⭐ |
| Tablet (Portrait) | 768px - 1024px | ⭐⭐ |
| Tablet (Landscape) | 1025px - 1280px | ⭐⭐ |
| Desktop | 1281px+ | ⭐ |

### 🔧 ส่วนที่ต้องปรับปรุง

#### 1. Navigation Menu
**ปัญหา:**
- เมนูบน Mobile ไม่แสดงผลดี
- Hamburger menu ไม่ทำงาน
- Sub-menu ทับกัน

**แก้ไข:**
- [ ] ปรับ Mobile Menu ให้เป็น Slide-in/Slide-out
- [ ] เพิ่ม Overlay เมื่อเปิดเมนู
- [ ] ปรับ Sub-menu ให้แสดงผลแบบ Accordion
- [ ] เพิ่ม Close button

#### 2. Hero Slider
**ปัญหา:**
- รูปภาพไม่ Scale ดีบน Mobile
- Text overlay อ่านยาก
- Button เล็กเกินไป

**แก้ไข:**
- [ ] ใช้ `object-fit: cover` สำหรับรูปภาพ
- [ ] ปรับขนาด Font บน Mobile
- [ ] เพิ่มขนาด Button บน Touch Device
- [ ] เพิ่ม Background overlay สำหรับ Text

#### 3. Grid Layouts
**ปัญหา:**
- Grid ไม่ปรับเป็น 1 Column บน Mobile
- Spacing ไม่เหมาะสม
- รูปภาพล้นออกจาก Container

**แก้ไข:**
- [ ] ใช้ CSS Grid/Flexbox ที่ Responsive
- [ ] ปรับ Column จาก 3 → 2 → 1 ตาม Breakpoint
- [ ] ปรับ Padding/Margin บน Mobile
- [ ] ใช้ `max-width: 100%` สำหรับรูปภาพ

#### 4. Forms
**ปัญหา:**
- Input fields เล็กเกินไปบน Mobile
- Button ไม่ชัดเจน
- Validation message ทับกัน

**แก้ไข:**
- [ ] เพิ่มขนาด Input fields (min-height: 44px)
- [ ] ใช้ `font-size: 16px` เพื่อป้องกัน Auto-zoom
- [ ] ปรับ Button ให้เป็น Full-width บน Mobile
- [ ] ปรับ Validation message ให้ชัดเจน

#### 5. Tables
**ปัญหา:**
- ตารางล้นออกจากหน้าจอ
- ไม่สามารถ Scroll ได้
- Text เล็กเกินไป

**แก้ไข:**
- [ ] ใช้ Responsive Table Pattern
- [ ] เพิ่ม Horizontal Scroll
- [ ] แปลงเป็น Card Layout บน Mobile
- [ ] ซ่อน Column ที่ไม่สำคัญ

#### 6. Typography
**ปัญหา:**
- Font size ไม่เหมาะสมบน Mobile
- Line height แน่นเกินไป
- Heading ใหญ่เกินไป

**แก้ไข:**
- [ ] ใช้ `clamp()` สำหรับ Fluid Typography
- [ ] ปรับ Line height: 1.5-1.8
- [ ] ปรับ Heading scale บน Mobile
- [ ] เพิ่ม Letter spacing ที่เหมาะสม

### 🚀 วิธีการปรับปรุง

#### Step 1: ตรวจสอบปัญหา
```bash
# ใช้ Browser DevTools
# 1. เปิด Chrome DevTools (F12)
# 2. Toggle Device Toolbar (Ctrl+Shift+M)
# 3. ทดสอบทุก Breakpoint
# 4. บันทึกปัญหาที่พบ
```

#### Step 2: สร้าง Responsive CSS
```bash
# สร้างไฟล์ CSS ใหม่
wp-content/themes/ayam-bangkok/assets/css/responsive.css
```

#### Step 3: เพิ่ม Media Queries
```css
/* Mobile First Approach */
/* Base styles for Mobile */

/* Tablet */
@media (min-width: 768px) { }

/* Desktop */
@media (min-width: 1024px) { }

/* Large Desktop */
@media (min-width: 1280px) { }
```

#### Step 4: ทดสอบ
- [ ] ทดสอบบน Real Devices
- [ ] ทดสอบบน Browser DevTools
- [ ] ทดสอบ Touch Interactions
- [ ] ทดสอบ Performance

### 📊 Performance Optimization

#### Images
- [ ] ใช้ Responsive Images (`srcset`, `sizes`)
- [ ] Lazy Loading
- [ ] WebP Format
- [ ] Image Compression

#### CSS
- [ ] Minify CSS
- [ ] Remove Unused CSS
- [ ] Critical CSS Inline
- [ ] Defer Non-Critical CSS

#### JavaScript
- [ ] Minify JavaScript
- [ ] Defer/Async Loading
- [ ] Remove Unused Scripts
- [ ] Code Splitting

### ✅ Checklist
- [ ] ตรวจสอบปัญหา Responsive ทั้งหมด
- [ ] สร้างไฟล์ `responsive.css`
- [ ] เพิ่ม Media Queries
- [ ] ปรับ Navigation Menu
- [ ] ปรับ Hero Slider
- [ ] ปรับ Grid Layouts
- [ ] ปรับ Forms
- [ ] ปรับ Tables
- [ ] ปรับ Typography
- [ ] ทดสอบบน Real Devices
- [ ] ทดสอบ Performance
- [ ] ทดสอบ Touch Interactions
- [ ] Validate HTML/CSS
- [ ] Cross-browser Testing

---

## 📝 หมายเหตุทั่วไป

### เครื่องมือที่แนะนำ
- **Chrome DevTools** - ทดสอบ Responsive
- **Lighthouse** - ตรวจสอบ Performance
- **BrowserStack** - Cross-browser Testing
- **GTmetrix** - Page Speed Analysis
- **Wave** - Accessibility Testing

### Best Practices
1. **Mobile First** - เริ่มออกแบบจาก Mobile ก่อน
2. **Progressive Enhancement** - เพิ่มฟีเจอร์สำหรับ Desktop
3. **Touch-Friendly** - ขนาด Target ขั้นต่ำ 44x44px
4. **Performance** - โหลดเร็ว < 3 วินาที
5. **Accessibility** - รองรับ Screen Reader

### การทดสอบ
- ทดสอบบน Real Devices อย่างน้อย 3 เครื่อง
- ทดสอบบน Browser หลัก (Chrome, Safari, Firefox, Edge)
- ทดสอบ Orientation (Portrait/Landscape)
- ทดสอบ Touch Gestures (Tap, Swipe, Pinch)

---

## 🎯 Timeline แนะนำ

| Priority | งาน | เวลาโดยประมาณ |
|----------|-----|----------------|
| 1 | อัพเดทข่าว | 30 นาที |
| 2 | อัพเดทรูปภาพ | 1-2 ชั่วโมง |
| 3 | ทำ Responsive | 4-8 ชั่วโมง |

**รวมทั้งหมด:** 6-11 ชั่วโมง

---

## 📞 ติดต่อสอบถาม

หากมีปัญหาหรือข้อสงสัย กรุณาติดต่อ:
- Email: support@ayambangkok.com
- Line: @ayambangkok
- Tel: 02-XXX-XXXX

---

**อัพเดทล่าสุด:** 8 ตุลาคม 2025  
**เวอร์ชัน:** 1.0
