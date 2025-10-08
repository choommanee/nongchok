# News System - คู่มือการใช้งาน

## ภาพรวม
News System เป็นระบบจัดการข่าวสารแบบครบวงจร พร้อมระบบ category, social sharing, newsletter และ related news

## ไฟล์ที่สร้าง

### 1. Template Files
- **wp-content/themes/ayam-bangkok/archive-ayam_news.php**
  - หน้ารายการข่าวทั้งหมด
  - Featured news (ข่าวแรก)
  - News grid layout
  - Category filter
  - Newsletter subscription

- **wp-content/themes/ayam-bangkok/single-ayam_news.php**
  - หน้ารายละเอียดข่าว
  - Social sharing buttons
  - News gallery และ video
  - Sidebar (recent news, categories)
  - Related news section

### 2. CSS File
- **wp-content/themes/ayam-bangkok/assets/css/news.css**
  - Modern news card design
  - Featured news layout
  - Single news article styles
  - Responsive design
  - Social sharing styles

### 3. JavaScript File
- **wp-content/themes/ayam-bangkok/assets/js/news.js**
  - Copy link functionality
  - Newsletter subscription
  - Category filtering
  - Notification system

### 4. Functions
- **ayam_reading_time()** - คำนวณเวลาอ่าน
- **ayam_subscribe_newsletter()** - AJAX handler สำหรับ newsletter

### 5. Database
- **wp_ayam_newsletter** - ตารางเก็บอีเมลผู้สมัครรับข่าวสาร

## วิธีการใช้งาน

### 1. เพิ่มข่าวสาร
1. ไปที่ WordPress Admin → ข่าวสาร → Add New
2. กรอกข้อมูล:
   - **ชื่อข่าว**: หัวข้อข่าว
   - **เนื้อหา**: เนื้อหาข่าวแบบเต็ม
   - **Featured Image**: รูปภาพหลัก
   - **Excerpt**: สรุปข่าว (แสดงในหน้ารายการ)
   - **Categories**: หมวดหมู่ข่าว
   - **Tags**: แท็กข่าว

3. ACF Fields (ถ้ามี):
   - **ข่าวเด่น**: เลือกถ้าต้องการให้เป็นข่าวเด่น
   - **แกลเลอรี่ข่าว**: เพิ่มรูปภาพเพิ่มเติม
   - **วิดีโอประกอบ**: URL วิดีโอ YouTube
   - **วันที่จัดกิจกรรม**: ถ้าเป็นข่าวกิจกรรม

4. Publish

### 2. สร้าง News Categories
1. ไปที่ WordPress Admin → ข่าวสาร → หมวดข่าว
2. เพิ่มหมวดหมู่:
   - ข่าวส่งออก
   - ความสำเร็จ
   - สื่อมวลชน
   - กิจกรรม
   - ประกาศ

### 3. ฟีเจอร์หลัก

#### Featured News (ข่าวเด่น)
- ข่าวแรกในหน้ารายการจะแสดงแบบ featured
- Layout แบบ 2 คอลัมน์ (รูป + เนื้อหา)
- แสดงเนื้อหามากกว่าข่าวทั่วไป

#### Social Sharing
- Facebook
- Twitter
- LINE
- Copy Link (คัดลอกลิงก์)

#### News Gallery
- แสดงรูปภาพเพิ่มเติมในหน้ารายละเอียด
- รองรับ lightbox effect

#### News Video
- ฝัง YouTube video
- Responsive video player

#### Newsletter Subscription
- ฟอร์มสมัครรับข่าวสาร
- บันทึกอีเมลใน database
- ส่งอีเมลยืนยัน

#### Related News
- แสดงข่าวที่เกี่ยวข้อง (same category)
- 3 ข่าวแบบสุ่ม

#### Reading Time
- คำนวณเวลาอ่านอัตโนมัติ
- แสดงในหน้ารายละเอียด

## การปรับแต่ง

### เปลี่ยนจำนวนข่าวต่อหน้า
ไปที่ WordPress Admin → Settings → Reading → "Blog pages show at most"

### เปลี่ยนสี
แก้ไขใน `news.css`:
```css
/* สีหลัก */
#1E2950 - สีน้ำเงินเข้ม
#CA4249 - สีแดง
```

### เปลี่ยน Reading Speed
แก้ไขใน `functions.php` function `ayam_reading_time()`:
```php
$reading_time = ceil($word_count / 200); // เปลี่ยน 200 เป็นจำนวนคำต่อนาที
```

### เพิ่ม Social Network
แก้ไขใน `single-ayam_news.php` ส่วน social-share:
```php
<a href="URL" class="share-btn network-name">
    <i class="fab fa-icon"></i>
</a>
```

## Layout Options

### Archive Page
- Featured news (ข่าวแรก) - Full width, 2 columns
- Regular news - Grid 3 columns
- Category filter - Sticky top
- Newsletter - Bottom section

### Single Page
- Breadcrumb navigation
- Article header (title, meta, social)
- Featured image
- Content (2 columns: main + sidebar)
- Gallery และ video
- Tags
- Related news

## Responsive Design

### Desktop (> 1024px)
- Featured news: 2 columns
- News grid: 3 columns
- Single: 2 columns (content + sidebar)

### Tablet (768px - 1024px)
- Featured news: 2 columns
- News grid: 2 columns
- Single: 1 column (sidebar below)

### Mobile (< 768px)
- Featured news: 1 column
- News grid: 1 column
- Single: 1 column

## Database Schema

### wp_ayam_newsletter
```sql
CREATE TABLE wp_ayam_newsletter (
    id int(11) NOT NULL AUTO_INCREMENT,
    email varchar(255) NOT NULL,
    status varchar(20) DEFAULT 'active',
    subscribed_at timestamp DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY email (email)
);
```

## AJAX Endpoints

### subscribe_newsletter
- **Action**: `subscribe_newsletter`
- **Method**: POST
- **Parameters**:
  - email: อีเมลผู้สมัคร
  - nonce: Security nonce
- **Response**:
  - Success: `{success: true, data: {message: '...'}}`
  - Error: `{success: false, data: {message: '...'}}`

## ปัญหาที่อาจพบ

### ไม่แสดงรูปภาพ
- ตรวจสอบว่าได้ตั้ง Featured Image แล้ว
- ตรวจสอบ image size 'news-card' ใน functions.php

### Social Sharing ไม่ทำงาน
- ตรวจสอบ URL encoding
- ตรวจสอบ popup blocker

### Newsletter ไม่ส่ง
- ตรวจสอบ AJAX URL ใน console
- ตรวจสอบ email configuration ของ WordPress
- ตรวจสอบ database table

### Copy Link ไม่ทำงาน
- ตรวจสอบ browser support สำหรับ Clipboard API
- ใช้ fallback method สำหรับ browser เก่า

## การพัฒนาต่อ

### เพิ่ม Comment System
- เปิด comments สำหรับ ayam_news post type
- เพิ่ม comment template ใน single-ayam_news.php

### เพิ่ม Author Box
- แสดงข้อมูลผู้เขียน
- รูปภาพและ bio

### เพิ่ม View Counter
- นับจำนวนการเข้าชม
- แสดงข่าวยอดนิยม

### เพิ่ม Search
- ค้นหาข่าวสาร
- Filter ขั้นสูง

### เพิ่ม RSS Feed
- Custom RSS feed สำหรับข่าวสาร
- Subscribe ผ่าน RSS reader

## สรุป
News System พร้อมใช้งานแล้ว! เพียงเพิ่มข่าวสารเข้าไปในระบบและสร้าง categories ตามต้องการ

## ตัวอย่างการใช้งาน

### เพิ่มข่าวแรก
```
ชื่อข่าว: ส่งออกไก่พื้นเมืองไทย Ayam Bangkok ไปอินโดนีเซีย มูลค่า 4 ล้านบาท
Category: ข่าวส่งออก, ความสำเร็จ
ข่าวเด่น: ✓
Featured Image: รูปไก่ชนหรือการส่งออก
```

### เพิ่มข่าวจากสื่อมวลชน
```
ชื่อข่าว: ปศุสัตว์ปลื้ม! ดันส่งออก Ayam Bangkok ไทยแลนด์สู่อินโดนีเซีย
Category: สื่อมวลชน
เนื้อหา: สรุปข่าว + ลิงก์ไปยังแหล่งข่าวต้นฉบับ
```
