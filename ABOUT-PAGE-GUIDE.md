# คู่มือการใช้งานหน้า About Us

## ภาพรวม
หน้า About Us ถูกออกแบบให้คล้ายกับ Wix โดยสามารถแก้ไขเนื้อหาและรูปภาพได้จากหลังบ้าน WordPress

## การเข้าถึงหน้าจัดการ

เข้าสู่ระบบ WordPress Admin และไปที่:
**จัดการ About** ในเมนูด้านซ้าย

## ส่วนต่างๆ ของหน้า About

### 1. ข้อมูลบริษัท (Company Info)
จัดการข้อความที่แสดงในหน้า About

**เข้าถึง:** จัดการ About → ข้อมูลบริษัท

**ฟิลด์ที่ใช้งาน:**
- `company_description` - ข้อความแนะนำบริษัท (ย่อหน้าที่ 1 ใน Hero Section)
- `about_description` - ข้อความเพิ่มเติม (ย่อหน้าที่ 2 ใน Hero Section)
- `story_text_1` - เรื่องราวของเรา (ย่อหน้าที่ 1 ใน Our Story)
- `story_text_2` - เรื่องราวของเรา (ย่อหน้าที่ 2 ใน Our Story)
- `address` - ที่อยู่บริษัท
- `phone` - เบอร์โทรศัพท์
- `email` - อีเมล
- `google_map_url` - URL สำหรับ Google Map Embed

**วิธีการ:**
1. กรอกข้อความในช่องภาษาไทยและภาษาอังกฤษ
2. คลิก "บันทึกข้อมูล"

**หมายเหตุ:** หากต้องการเพิ่มฟิลด์ใหม่ ต้องเพิ่มในฐานข้อมูล `wp_ayam_company_info`

### 2. รูปภาพแกลเลอรี่ (Gallery Images)
จัดการรูปภาพที่แสดงในหน้า About

**เข้าถึง:** จัดการ About → รูปภาพแกลเลอรี่

**การอัปโหลดรูปภาพ:**
1. คลิก "เลือกรูปภาพ"
2. เลือกรูปภาพ (สามารถเลือกหลายไฟล์พร้อมกัน)
3. คลิก "อัปโหลดรูปภาพ"

**ข้อกำหนดรูปภาพ:**
- ไฟล์ที่รองรับ: JPG, JPEG, PNG
- ขนาดแนะนำ: 1200 x 800 พิกเซลขึ้นไป
- อัตราส่วน: 16:9 หรือ 4:3

**การแสดงผล:**
- 3 รูปแรกจะแสดงใน Hero Section (กริด 3 คอลัมน์)
- รูปภาพทั้งหมดจะแสดงใน Gallery Section (กริด 4 คอลัมน์)

**การลบรูปภาพ:**
1. คลิกปุ่ม "ลบ" ที่รูปภาพที่ต้องการ
2. ยืนยันการลบ

### 3. แบบฟอร์มติดต่อ (Contact Form)
แบบฟอร์มจะส่งอีเมลไปยังอีเมลที่ตั้งค่าไว้ใน `email` หรือ admin email

**ฟิลด์ในฟอร์ม:**
- ชื่อ (First Name)
- นามสกุล (Last Name)
- Email
- ข้อความ (Message)

**การตั้งค่าอีเมล:**
ไปที่ จัดการ About → ข้อมูลบริษัท และกรอกอีเมลในฟิลด์ `email`

### 4. Google Map
แสดงแผนที่ตำแหน่งบริษัท

**การตั้งค่า:**
1. ไปที่ [Google Maps](https://www.google.com/maps)
2. ค้นหาที่อยู่บริษัท
3. คลิก "แชร์" → "ฝังแผนที่"
4. คัดลอก URL ในส่วน `src="..."`
5. นำไปวางในฟิลด์ `google_map_url` ที่หน้าข้อมูลบริษัท

**ตัวอย่าง URL:**
```
https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3874.5234!2d100.8234!3d13.8234...
```

## โครงสร้างหน้า About

```
┌─────────────────────────────────────┐
│      Hero Section                   │
│  ┌───────────┬──────────────────┐   │
│  │  Content  │  3 Image Grid    │   │
│  └───────────┴──────────────────┘   │
└─────────────────────────────────────┘

┌─────────────────────────────────────┐
│      Our Story Section              │
│  ┌─────────────────────────────┐    │
│  │  Story Text                 │    │
│  └─────────────────────────────┘    │
│  ┌─────────────────────────────┐    │
│  │  8 Image Gallery (4 cols)   │    │
│  └─────────────────────────────┘    │
└─────────────────────────────────────┘

┌─────────────────────────────────────┐
│      Contact Section                │
│  ┌──────────┬───────────────────┐   │
│  │ Contact  │  Contact Form     │   │
│  │  Info    │                   │   │
│  └──────────┴───────────────────┘   │
│  ┌─────────────────────────────┐    │
│  │      Google Map             │    │
│  └─────────────────────────────┘    │
└─────────────────────────────────────┘
```

## Tips & Best Practices

### การเขียนเนื้อหา
- ใช้ภาษาที่เป็นมิตร เข้าใจง่าย
- เน้นจุดเด่นและจุดแข็งของบริษัท
- เล่าเรื่องราวที่น่าสนใจ สร้างความเชื่อมั่น

### การเลือกรูปภาพ
- ใช้รูปภาพคุณภาพสูง ชัดเจน
- เลือกรูปที่สื่อถึงธุรกิจและค่านิยมของบริษัท
- หลีกเลี่ยงรูปที่มี watermark
- ใช้รูปภาพที่มีแสงสว่างเพียงพอ

### SEO
- เพิ่ม Page Title และ Description ที่ WordPress → Settings → About Page
- ใช้คำค้นหาที่เกี่ยวข้องกับธุรกิจ
- อัปเดตเนื้อหาเป็นประจำ

## การแก้ไขเพิ่มเติม

### เพิ่มฟิลด์ข้อมูลใหม่
1. เข้าฐานข้อมูล `wp_ayam_company_info`
2. INSERT ข้อมูลใหม่:
```sql
INSERT INTO wp_ayam_company_info
(field_key, field_value_th, field_value_en, field_type, category)
VALUES
('field_name', 'ค่าภาษาไทย', 'English Value', 'text', 'general');
```
3. แก้ไขไฟล์ `page-about.php` ให้ใช้ฟิลด์ใหม่

### แก้ไข CSS
ไฟล์ CSS อยู่ที่: `/wp-content/themes/ayam-bangkok/assets/css/about.css`

สามารถแก้ไข:
- สี, ฟอนต์
- ขนาด spacing, padding
- Responsive breakpoints
- Animation effects

## ไฟล์ที่เกี่ยวข้อง

| ไฟล์ | ตำแหน่ง | คำอธิบาย |
|------|---------|----------|
| page-about.php | /wp-content/themes/ayam-bangkok/ | Template หน้า About |
| about.css | /wp-content/themes/ayam-bangkok/assets/css/ | CSS หน้า About |
| class-ayam-about-admin.php | /wp-content/plugins/ayam-bangkok-core/includes/ | Backend admin |
| class-ayam-about-database.php | /wp-content/plugins/ayam-bangkok-core/includes/ | Database structure |

## ตารางในฐานข้อมูล

- `wp_ayam_company_info` - ข้อมูลบริษัท
- `wp_ayam_company_timeline` - ประวัติความเป็นมา (ยังไม่ได้ใช้ในหน้า About)
- `wp_ayam_company_awards` - รางวัล (ยังไม่ได้ใช้ในหน้า About)
- `wp_ayam_team_members` - ทีมงาน (ยังไม่ได้ใช้ในหน้า About)
- `wp_ayam_company_values` - ค่านิยม (ยังไม่ได้ใช้ในหน้า About)

## การแก้ปัญหา

### รูปภาพไม่แสดง
1. ตรวจสอบว่าไฟล์มีอยู่ใน `/wp-content/uploads/about-gallery/`
2. ตรวจสอบ permissions ของโฟลเดอร์ (755)
3. ตรวจสอบ URL ในโค้ด

### แบบฟอร์มไม่ส่งอีเมล
1. ตรวจสอบการตั้งค่า SMTP ของ WordPress
2. ติดตั้ง plugin เช่น WP Mail SMTP
3. ตรวจสอบ spam folder

### CSS ไม่ทำงาน
1. Clear cache (browser และ WordPress)
2. ตรวจสอบว่า CSS โหลดถูกต้องใน functions.php
3. ตรวจสอบ path ของไฟล์

## การสนับสนุน

หากมีปัญหาหรือต้องการความช่วยเหลือ กรุณาติดต่อ:
- Developer: [ช่องทางติดต่อ]
- Documentation: [Link to docs]
