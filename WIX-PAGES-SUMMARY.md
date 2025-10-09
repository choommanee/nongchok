# สรุปการ Copy หน้าจาก Wix

## ✅ หน้าที่ทำเสร็จแล้ว

### 1. **About Us Page** (`page-about.php`)
- **URL Wix:** https://saeliwid.wixsite.com/my-site-3/about-us
- **Template:** `page-about.php`
- **CSS:** `assets/css/about.css`
- **จัดการในหลังบ้าน:** จัดการ About → รูปภาพแกลเลอรี่ About

**ฟีเจอร์:**
- Hero Section พร้อมข้อความและกริด 3 รูป
- Our Story Section พร้อมแกลเลอรี่ 8 รูป
- Contact Form ส่งอีเมล
- Google Map
- ดึงข้อมูลจาก database (`wp_ayam_company_info`)

---

### 2. **Service Page** (`page-service.php`)
- **URL Wix:** https://saeliwid.wixsite.com/my-site-3/service
- **Template:** `page-service.php`
- **CSS:** `assets/css/service.css`
- **จัดการในหลังบ้าน:** จัดการ About → รูปภาพ Service

**ฟีเจอร์:**
- Hero Section พร้อมหัวข้อและคำอธิบาย
- Service Grid แสดง 6 บริการ (3 คอลัมน์)
- ดึงรูปภาพจาก `/wp-content/uploads/service-gallery/`
- ดึงข้อมูลจาก database

---

### 3. **Gallery Page** (`page-gallery-wix.php`)
- **URL Wix:** https://saeliwid.wixsite.com/my-site-3/gallery
- **Template:** `page-gallery-wix.php`
- **CSS:** `assets/css/gallery-wix.css`
- **จัดการในหลังบ้าน:** จัดการ About → รูปภาพ Gallery

**ฟีเจอร์:**
- Hero Section
- Masonry Grid Gallery (4 คอลัมน์)
- Lightbox เมื่อคลิกรูป
- ดึงรูปภาพจาก `/wp-content/uploads/gallery-wix/`

---

### 4. **News Page** (`page-news-wix.php`)
- **URL Wix:** https://saeliwid.wixsite.com/my-site-3/news-1
- **Template:** `page-news-wix.php`
- **CSS:** `assets/css/news-wix.css`
- **ใช้ข้อมูลจาก:** Post Type `ayam_news`

**ฟีเจอร์:**
- Hero Section
- News Grid (3 คอลัมน์)
- แสดง Featured Image, Date, Category
- Read More Link
- Pagination

---

## 📁 โครงสร้างไฟล์

```
wp-content/
├── themes/ayam-bangkok/
│   ├── page-about.php          ✅ NEW
│   ├── page-service.php        ✅ NEW
│   ├── page-gallery-wix.php    ✅ NEW
│   ├── page-news-wix.php       ✅ NEW
│   ├── assets/
│   │   ├── css/
│   │   │   ├── about.css       ✅ NEW
│   │   │   ├── service.css     ✅ NEW
│   │   │   ├── gallery-wix.css ✅ NEW
│   │   │   └── news-wix.css    ✅ NEW
│   │   └── images/
│   │       ├── about/          ✅ NEW (8 รูป)
│   │       └── service/        ✅ NEW (6 รูป)
│   └── functions.php           ✅ UPDATED
│
├── uploads/
│   ├── about-gallery/          ✅ จัดการจากหลังบ้าน
│   ├── service-gallery/        ✅ จัดการจากหลังบ้าน
│   └── gallery-wix/            ✅ จัดการจากหลังบ้าน
│
└── plugins/ayam-bangkok-core/
    └── includes/
        └── class-ayam-about-admin.php  ✅ UPDATED
```

---

## 🎛️ การจัดการในหลังบ้าน

### เมนู: **จัดการ About**

1. **ข้อมูลบริษัท** - แก้ไขข้อความทั้งหมด
2. **ประวัติความเป็นมา** - จัดการ Timeline
3. **รางวัลและใบรับรอง** - (รอพัฒนา UI)
4. **ทีมงาน** - (รอพัฒนา UI)
5. **ค่านิยมองค์กร** - (รอพัฒนา UI)
6. **รูปภาพแกลเลอรี่ About** - อัปโหลด/ลบรูป About page
7. **รูปภาพ Service** - อัปโหลด/ลบรูป Service page
8. **รูปภาพ Gallery** - อัปโหลด/ลบรูป Gallery page

---

## 🔧 ฟิลด์ที่ใช้ใน Database

### ตาราง: `wp_ayam_company_info`

| Field Key | ใช้ในหน้า | คำอธิบาย |
|-----------|-----------|----------|
| `company_description` | About | ข้อความ Hero ย่อหน้า 1 |
| `about_description` | About | ข้อความ Hero ย่อหน้า 2 |
| `story_text_1` | About | Our Story ย่อหน้า 1 |
| `story_text_2` | About | Our Story ย่อหน้า 2 |
| `address` | About | ที่อยู่ |
| `phone` | About | เบอร์โทร |
| `email` | About | อีเมล |
| `google_map_url` | About | Google Map URL |
| `service_title` | Service | หัวข้อหน้า Service |
| `service_description` | Service | คำอธิบายหน้า Service |
| `service_1_name` | Service | ชื่อบริการที่ 1 |
| `service_1_description` | Service | คำอธิบายบริการที่ 1 |
| ... | Service | (เหมือนกัน สำหรับ service 2-6) |

---

## 📝 วิธีใช้งาน

### 1. สร้างหน้าใหม่ใน WordPress

1. ไปที่ **Pages → Add New**
2. ตั้งชื่อหน้า เช่น "About Us", "Service", "Gallery", "News"
3. เลือก **Template:**
   - About Us → `About Us Page`
   - Service → `Service Page`
   - Gallery → `Gallery Page (Wix Style)`
   - News → `News Page (Wix Style)`
4. คลิก **Publish**

### 2. แก้ไขเนื้อหา

**สำหรับ About & Service:**
1. ไปที่ **จัดการ About → ข้อมูลบริษัท**
2. กรอกข้อความในฟิลด์ที่ต้องการ
3. คลิก **บันทึกข้อมูล**

**สำหรับรูปภาพ:**
1. ไปที่ **จัดการ About** → เลือกหน้าที่ต้องการ
2. คลิก **เลือกรูปภาพ** → เลือกหลายไฟล์ได้
3. คลิก **อัปโหลดรูปภาพ**

**สำหรับ News:**
1. ไปที่ **News** (หรือ Custom Post Type ที่ตั้งค่าไว้)
2. คลิก **Add New**
3. เขียนเนื้อหา + เพิ่ม Featured Image
4. คลิก **Publish**

### 3. ตั้งค่า Navigation Menu

1. ไปที่ **Appearance → Menus**
2. เพิ่มหน้าทั้ง 4 เข้าไปใน Menu
3. เรียงลำดับ: Home → Service → Gallery → News → About Us
4. คลิก **Save Menu**

---

## 🎨 การปรับแต่ง CSS

แก้ไขไฟล์ CSS ตามต้องการ:

| หน้า | ไฟล์ CSS |
|------|----------|
| About | `/wp-content/themes/ayam-bangkok/assets/css/about.css` |
| Service | `/wp-content/themes/ayam-bangkok/assets/css/service.css` |
| Gallery | `/wp-content/themes/ayam-bangkok/assets/css/gallery-wix.css` |
| News | `/wp-content/themes/ayam-bangkok/assets/css/news-wix.css` |

---

## 📊 Responsive Breakpoints

ทุกหน้าใช้ breakpoints เดียวกัน:

- **Desktop:** > 968px
- **Tablet:** 640px - 968px
- **Mobile:** < 640px

---

## 🚀 Next Steps (ถ้าต้องการพัฒนาต่อ)

### หน้า Service
- [ ] เพิ่มฟิลด์ `service_7_name`, `service_8_name` ฯลฯ ในฐานข้อมูล
- [ ] เพิ่มปุ่ม "Read More" ที่ลิงก์ไปหน้ารายละเอียด

### หน้า Gallery
- [ ] เพิ่มระบบ Lightbox ที่ดีกว่า (เช่น Fancybox, GLightbox)
- [ ] เพิ่มหมวดหมู่สำหรับแยกประเภทรูป

### หน้า News
- [ ] เพิ่ม Category Filter
- [ ] เพิ่ม Search Box
- [ ] เพิ่ม Related Posts

### ทั่วไป
- [ ] เพิ่ม Loading Animation
- [ ] ปรับปรุง SEO Meta Tags
- [ ] เพิ่ม Social Share Buttons
- [ ] เพิ่มระบบ Multi-language

---

## 📞 การสนับสนุน

หากมีปัญหาหรือต้องการความช่วยเหลือ:

1. ตรวจสอบไฟล์ [ABOUT-PAGE-GUIDE.md](./ABOUT-PAGE-GUIDE.md)
2. ตรวจสอบ Console ของ Browser สำหรับ JavaScript errors
3. ตรวจสอบ PHP error logs

---

## 🎉 สรุป

**ทำเสร็จแล้ว:**
- ✅ 4 หน้าหลัก (About, Service, Gallery, News)
- ✅ 4 ไฟล์ CSS
- ✅ ระบบจัดการรูปภาพในหลังบ้าน
- ✅ ดึงข้อมูลจาก Database
- ✅ Responsive Design
- ✅ Animation Effects (AOS)

**คุณสามารถ:**
- แก้ไขเนื้อหาได้จากหลังบ้าน
- อัปโหลด/ลบรูปภาพได้
- เพิ่ม Service ใหม่
- เพิ่ม News/Gallery ได้ไม่จำกัด
