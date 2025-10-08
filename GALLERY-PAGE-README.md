# Gallery Page - คู่มือการใช้งาน

## ภาพรวม
Gallery Page เป็นหน้าแสดงไก่ชนทั้งหมดในรูปแบบ grid layout พร้อมระบบค้นหา กรอง และ quick view

## ไฟล์ที่สร้าง

### 1. Template File
- **wp-content/themes/ayam-bangkok/page-gallery.php**
  - Template หลักสำหรับหน้า Gallery
  - แสดงไก่ชนทั้งหมดในรูปแบบ grid
  - มี search, filter และ pagination

### 2. CSS File
- **wp-content/themes/ayam-bangkok/assets/css/gallery.css**
  - Styles สำหรับ Gallery Page
  - Modern card design พร้อม hover effects
  - Responsive design สำหรับทุกอุปกรณ์
  - Modal styles สำหรับ quick view

### 3. JavaScript File
- **wp-content/themes/ayam-bangkok/assets/js/gallery.js**
  - Search functionality
  - Filter และ sort functionality
  - Quick view modal
  - Favorites system (localStorage)
  - Notifications

### 4. ACF Field
- เพิ่ม **rooster_number** field ใน ACF
  - สำหรับแสดงหมายเลขไก่แต่ละตัว
  - แสดงใน badge ที่มุมบนซ้ายของรูป

### 5. AJAX Handler
- **ayam_get_rooster_quick_view()** ใน functions.php
  - โหลดข้อมูลไก่สำหรับ quick view modal
  - แสดงข้อมูลพื้นฐานและรูปภาพ

## วิธีการใช้งาน

### 1. สร้างหน้า Gallery
1. ไปที่ WordPress Admin → Pages → Add New
2. ตั้งชื่อหน้า: "แกลเลอรี่ไก่ชน" หรือ "Gallery"
3. เลือก Template: **Gallery Page**
4. Publish หน้า

### 2. เพิ่มข้อมูลไก่ชน
1. ไปที่ WordPress Admin → ไก่ชน → Add New
2. กรอกข้อมูล:
   - **หมายเลขไก่**: R001, R002, etc.
   - **ชื่อไก่**: ชื่อไก่ชน
   - **ราคา**: ราคาเป็นบาท
   - **อายุ**: อายุเป็นเดือน
   - **น้ำหนัก**: น้ำหนักเป็นกิโลกรัม
   - **สี**: สีขนไก่
   - **สถานะ**: พร้อมส่งออก / จองแล้ว / ขายแล้ว
   - **Featured Image**: รูปภาพหลัก
3. Publish

### 3. ฟีเจอร์หลัก

#### Search (ค้นหา)
- ค้นหาด้วยชื่อไก่หรือหมายเลขไก่
- Real-time search (ค้นหาทันทีขณะพิมพ์)

#### Quick Filters (ตัวกรองด่วน)
- **ทั้งหมด**: แสดงไก่ชนทั้งหมด
- **พร้อมส่งออก**: แสดงเฉพาะไก่ที่พร้อมส่งออก
- **ไก่ชนพรีเมียม**: แสดงไก่ราคามากกว่า 10,000 บาท
- **เพิ่มใหม่**: แสดง 6 ตัวล่าสุด

#### Sort (เรียงลำดับ)
- หมายเลข (น้อย-มาก / มาก-น้อย)
- วันที่เพิ่ม (ใหม่สุด)
- ราคา (ต่ำ-สูง / สูง-ต่ำ)

#### Quick View (ดูรวดเร็ว)
- คลิกปุ่มตาที่การ์ดไก่
- แสดง modal พร้อมข้อมูลพื้นฐาน
- ไม่ต้องไปหน้ารายละเอียด

#### Favorites (รายการโปรด)
- คลิกปุ่มหัวใจเพื่อเพิ่ม/ลบรายการโปรด
- บันทึกใน localStorage
- ยังคงอยู่แม้ปิดเบราว์เซอร์

## การปรับแต่ง

### เปลี่ยนจำนวนไก่ต่อหน้า
แก้ไขใน `page-gallery.php` บรรทัด 75:
```php
'posts_per_page' => 12, // เปลี่ยนเป็นจำนวนที่ต้องการ
```

### เปลี่ยนสี
แก้ไขใน `gallery.css`:
```css
/* สีหลัก */
#1E2950 - สีน้ำเงินเข้ม
#CA4249 - สีแดง
```

### เพิ่ม Filter เพิ่มเติม
แก้ไขใน `gallery.js` function `filterByStatus()`:
```javascript
else if (status === 'your-filter') {
    // เพิ่มเงื่อนไขของคุณ
}
```

## Responsive Design

### Desktop (> 768px)
- Grid 4 คอลัมน์
- แสดง quick actions เมื่อ hover

### Tablet (768px - 480px)
- Grid 3 คอลัมน์
- Quick actions แสดงตลอดเวลา

### Mobile (< 480px)
- Grid 1 คอลัมน์
- Stack layout สำหรับ filters

## Browser Support
- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Mobile browsers

## Performance
- Lazy loading สำหรับรูปภาพ
- AJAX สำหรับ quick view
- localStorage สำหรับ favorites
- Optimized CSS และ JavaScript

## ปัญหาที่อาจพบ

### ไม่แสดงรูปภาพ
- ตรวจสอบว่าได้ตั้ง Featured Image แล้ว
- ตรวจสอบ image size 'rooster-card' ใน functions.php

### Quick View ไม่ทำงาน
- ตรวจสอบ AJAX URL ใน console
- ตรวจสอบ nonce verification
- ตรวจสอบว่า jQuery โหลดแล้ว

### Search ไม่ทำงาน
- ตรวจสอบ JavaScript console สำหรับ errors
- ตรวจสอบว่า gallery.js โหลดแล้ว

## การพัฒนาต่อ

### เพิ่ม Advanced Filters
- Filter ตามสายพันธุ์
- Filter ตามช่วงราคา
- Filter ตามอายุ

### เพิ่ม Compare Feature
- เปรียบเทียบไก่หลายตัว
- แสดงตารางเปรียบเทียบ

### เพิ่ม Wishlist
- บันทึก wishlist ใน database
- แสดงหน้า wishlist แยก

## สรุป
Gallery Page พร้อมใช้งานแล้ว! เพียงสร้างหน้าใหม่และเลือก Template "Gallery Page" จากนั้นเพิ่มข้อมูลไก่ชนเข้าไปในระบบ
