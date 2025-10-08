# Design Document - เว็บไซต์ Ayam Bangkok

## Overview

เว็บไซต์ Ayam Bangkok จะถูกพัฒนาบน WordPress CMS โดยใช้สถาปัตยกรรมแบบ Custom Theme พร้อมกับ Custom Post Types และ Advanced Custom Fields เพื่อรองรับการจัดการข้อมูลไก่ชนที่ซับซ้อน 

**Design Reference:** เว็บไซต์จะออกแบบตาม Wix template ที่ https://saeliwid.wixsite.com/my-site-3 เพื่อให้ได้ลุคที่ทันสมัยและใช้งานง่าย

**Color Scheme:**
- Primary Color: #1E2950 (น้ำเงินเข้ม)
- Secondary Color: #CA4249 (แดงอิฐ)
- Supporting colors จะใช้โทนสีที่เข้ากันกับสีหลัก

**Multi-language Support:**
- ภาษาไทย (หลัก) 
- ภาษาอินโดนีเซีย (รอง)
- ใช้ WPML plugin สำหรับจัดการหลายภาษา

**Image Assets:**
- ใช้รูปภาพจากโฟลเดอร์ "pic home" ที่มีอยู่แล้ว
- รองรับทั้งรูปภาพและวิดีโอ

เว็บไซต์จะมีการออกแบบแบบ Responsive Design และรองรับการใช้งานบนมือถือ

## Architecture

### System Architecture

```
┌─────────────────────────────────────────────────────────────┐
│                    Frontend Layer                           │
├─────────────────────────────────────────────────────────────┤
│  • Custom WordPress Theme (Ayam Bangkok Theme)             │
│  • Responsive Design (Bootstrap 5)                         │
│  • JavaScript/jQuery for Interactive Features              │
│  • AJAX for Dynamic Content Loading                        │
└─────────────────────────────────────────────────────────────┘
                              │
┌─────────────────────────────────────────────────────────────┐
│                 WordPress Core Layer                        │
├─────────────────────────────────────────────────────────────┤
│  • WordPress 6.x Core                                      │
│  • Custom Post Types (Roosters, Services, News)           │
│  • Custom Taxonomies (Breeds, Categories)                  │
│  • WordPress REST API                                      │
│  • User Management & Roles                                 │
└─────────────────────────────────────────────────────────────┘
                              │
┌─────────────────────────────────────────────────────────────┐
│                   Plugin Layer                              │
├─────────────────────────────────────────────────────────────┤
│  • Advanced Custom Fields Pro                              │
│  • WooCommerce (for Services & Products)                   │
│  • Contact Form 7                                          │
│  • Yoast SEO                                              │
│  • WPML (Multi-language Support)                          │
│  • Custom Ayam Bangkok Plugin                             │
└─────────────────────────────────────────────────────────────┘
                              │
┌─────────────────────────────────────────────────────────────┐
│                   Database Layer                            │
├─────────────────────────────────────────────────────────────┤
│  • MySQL Database (nongchok)                              │
│  • WordPress Tables                                        │
│  • Custom Tables for Rooster Data                         │
│  • Media Library for Images/Videos                        │
└─────────────────────────────────────────────────────────────┘
```

### Technology Stack

- **CMS**: WordPress 6.x
- **Frontend**: HTML5, CSS3, JavaScript (ES6+), jQuery
- **CSS Framework**: Bootstrap 5
- **Slider Library**: Swiper.js 8.x (Modern touch slider)
- **Animation Library**: AOS (Animate On Scroll)
- **PHP Version**: 8.0+
- **Database**: MySQL 8.0
- **Server**: Apache/Nginx
- **Development Tools**: Sass, Webpack, Git

## Components and Interfaces

### 1. Custom Post Types

#### Rooster Post Type
```php
// Custom Post Type: ayam_rooster
Fields:
- Title (ชื่อไก่)
- Content (รายละเอียด)
- Featured Image (รูปหลัก)
- Gallery (แกลเลอรี่)
- Price (ราคา)
- Age (อายุ)
- Weight (น้ำหนัก)
- Color (สี)
- Breed (สายพันธุ์)
- Fighting History (ประวัติการแข่งขัน)
- Pedigree Info (ข้อมูลพ่อแม่พันธุ์)
- Status (สถานะ: Available, Sold, Reserved)
```

#### Service Post Type
```php
// Custom Post Type: ayam_service
Fields:
- Title (ชื่อบริการ)
- Content (รายละเอียด)
- Price (ราคา)
- Duration (ระยะเวลา)
- Service Type (ประเภทบริการ)
- Booking Available (เปิดจอง)
```

#### News Post Type
```php
// Custom Post Type: ayam_news
Fields:
- Title (หัวข้อข่าว)
- Content (เนื้อหา)
- Featured Image (รูปประกอบ)
- News Category (หมวดข่าว)
- Publication Date (วันที่เผยแพร่)
```

### 2. Custom Taxonomies

```php
// Taxonomy: rooster_breed (สายพันธุ์ไก่)
- ไก่ชนไทยพื้นเมือง
- ไก่ชนอีสาน
- ไก่ชนเหนือ
- ไก่ชนกลาง
- ไก่ชนใต้
- American Gamefowl
- Asil
- Shamo
- Malay
- ลูกผสมพิเศษ

// Taxonomy: rooster_category (หมวดหมู่)
- พร้อมส่งออก
- กำลังฝึก
- พ่อแม่พันธุ์
- ไก่หนุ่ม

// Taxonomy: service_category (หมวดบริการ)
- บริการฝึกไก่
- บริการดูแลรักษา
- คอนซัลติ้ง
- ผสมพันธุ์
```

### 3. User Roles และ Capabilities

```php
// Custom User Roles
1. Administrator (ผู้ดูแลระบบ)
   - จัดการทุกอย่าง
   
2. Manager (ผู้จัดการ)
   - จัดการไก่ชน, บริการ, ข่าวสาร
   - ดูรายงานสถิติ
   
3. Staff (เจ้าหน้าที่)
   - เพิ่ม/แก้ไขข้อมูลไก่ชน
   - ตอบกลับลูกค้า
   
4. Premium Member (สมาชิกพิเศษ)
   - ดูราคาพิเศษ
   - จองบริการล่วงหน้า
   
5. Regular Member (สมาชิกทั่วไป)
   - ดูข้อมูลไก่ชน
   - ติดต่อสอบถาม
```

### 4. Page Templates

```php
// Custom Page Templates
1. front-page.php (หน้าแรก - ตาม Wix Design Reference)
2. page-about.php (เกี่ยวกับเรา/ประวัติ/ที่อยู่/ติดต่อ)
3. page-gallery.php (แกลเลอรี่ไก่ - สำคัญที่สุด)
4. page-news.php (ข่าวประชาสัมพันธ์และบทความ)
5. page-member-registration.php (สมัครสมาชิก)
6. page-member-dashboard.php (หน้าสมาชิก)
7. page-pricing.php (ราคาและแพ็กเกจ)
8. page-achievements.php (ผลงานและรางวัล)
9. page-services.php (บริการและสินค้า)
10. page-contact.php (ติดต่อเรา)

// Single Templates
1. single-ayam_rooster.php (รายละเอียดไก่ชน - สำหรับ Gallery)
2. single-ayam_service.php (รายละเอียดบริการ)
3. single-ayam_news.php (รายละเอียดข่าว)

// Archive Templates
1. archive-ayam_rooster.php (Gallery - รายการไก่ชน)
2. archive-ayam_service.php (รายการบริการ)
3. archive-ayam_news.php (รายการข่าว)
4. taxonomy-rooster_breed.php (รายการตามสายพันธุ์)

// Multi-language Templates
- ทุก template จะรองรับ WPML
- Language switcher ในทุกหน้า
- RTL support สำหรับอนาคต
```

### 5. Gallery System Design (สำคัญที่สุด)

```html
<!-- Gallery Page Layout -->
<main class="gallery-page">
    <!-- Gallery Header -->
    <section class="gallery-header">
        <div class="container">
            <h1>แกลเลอรี่ไก่ Ayam Bangkok</h1>
            <p>เลือกดูไก่แต่ละตัวที่กำลังจะส่งออก</p>
        </div>
    </section>

    <!-- Gallery Filters -->
    <section class="gallery-filters">
        <div class="container">
            <div class="filter-controls">
                <select id="breed-filter">
                    <option value="">ทุกสายพันธุ์</option>
                    <option value="thai">ไก่ชนไทย</option>
                    <option value="asil">อาซิล</option>
                </select>
                <select id="price-filter">
                    <option value="">ทุกราคา</option>
                    <option value="0-5000">0-5,000 บาท</option>
                    <option value="5000-10000">5,000-10,000 บาท</option>
                </select>
                <input type="text" id="search-input" placeholder="ค้นหาหมายเลขไก่...">
            </div>
        </div>
    </section>

    <!-- Gallery Grid -->
    <section class="gallery-grid">
        <div class="container">
            <div class="rooster-grid">
                <!-- Rooster Card with Number -->
                <div class="rooster-card" data-rooster-id="001">
                    <div class="rooster-number">#001</div>
                    <div class="rooster-image">
                        <img src="rooster-001.jpg" alt="ไก่หมายเลข 001">
                        <div class="image-overlay">
                            <button class="view-details-btn">ดูรายละเอียด</button>
                        </div>
                    </div>
                    <div class="rooster-info">
                        <h3>ไก่ชนไทยพื้นเมือง</h3>
                        <p class="rooster-price">฿8,500</p>
                        <p class="rooster-status">พร้อมส่งออก</p>
                    </div>
                </div>
                <!-- More rooster cards... -->
            </div>
        </div>
    </section>
</main>

<!-- Rooster Detail Modal/Page -->
<div class="rooster-detail-modal">
    <div class="modal-content">
        <div class="rooster-gallery">
            <!-- Image/Video Gallery -->
            <div class="media-gallery">
                <div class="main-media">
                    <img id="main-image" src="" alt="">
                    <video id="main-video" controls style="display:none;">
                        <source src="" type="video/mp4">
                    </video>
                </div>
                <div class="media-thumbnails">
                    <!-- Thumbnail images and video previews -->
                </div>
            </div>
        </div>
        <div class="rooster-details">
            <h2>ไก่หมายเลข #001</h2>
            <div class="detail-grid">
                <div class="detail-item">
                    <label>สายพันธุ์:</label>
                    <span>ไก่ชนไทยพื้นเมือง</span>
                </div>
                <div class="detail-item">
                    <label>อายุ:</label>
                    <span>1 ปี 2 เดือน</span>
                </div>
                <div class="detail-item">
                    <label>น้ำหนัก:</label>
                    <span>2.5 กิโลกรัม</span>
                </div>
                <div class="detail-item">
                    <label>ราคา:</label>
                    <span>฿8,500</span>
                </div>
            </div>
            <div class="action-buttons">
                <button class="inquire-btn">สอบถามไก่ตัวนี้</button>
                <button class="reserve-btn">จองไก่ตัวนี้</button>
            </div>
        </div>
    </div>
</div>
```

### 6. Member Registration System Design

```html
<!-- Member Registration Page -->
<main class="member-registration">
    <section class="registration-header">
        <div class="container">
            <h1>สมัครสมาชิก Ayam Bangkok</h1>
            <p>เข้าถึงข้อมูลพิเศษและบริการเพิ่มเติม</p>
        </div>
    </section>

    <section class="registration-form">
        <div class="container">
            <form id="member-registration-form" class="modern-form">
                <div class="form-step active" data-step="1">
                    <h3>ข้อมูลส่วนตัว</h3>
                    <div class="form-group">
                        <input type="text" name="first_name" required>
                        <label>ชื่อ</label>
                    </div>
                    <div class="form-group">
                        <input type="text" name="last_name" required>
                        <label>นามสกุล</label>
                    </div>
                    <div class="form-group">
                        <input type="email" name="email" required>
                        <label>อีเมล</label>
                    </div>
                    <div class="form-group">
                        <input type="tel" name="phone" required>
                        <label>เบอร์โทรศัพท์</label>
                    </div>
                </div>

                <div class="form-step" data-step="2">
                    <h3>ข้อมูลธุรกิจ</h3>
                    <div class="form-group">
                        <select name="country" required>
                            <option value="">เลือกประเทศ</option>
                            <option value="thailand">ไทย</option>
                            <option value="indonesia">อินโดนีเซีย</option>
                        </select>
                        <label>ประเทศ</label>
                    </div>
                    <div class="form-group">
                        <select name="business_type" required>
                            <option value="">ประเภทธุรกิจ</option>
                            <option value="farm">ฟาร์มเลี้ยงไก่</option>
                            <option value="trader">ผู้ค้าไก่ชน</option>
                            <option value="hobbyist">ผู้เลี้ยงเพื่อความสนุก</option>
                        </select>
                        <label>ประเภทธุรกิจ</label>
                    </div>
                </div>

                <div class="form-navigation">
                    <button type="button" class="prev-btn">ย้อนกลับ</button>
                    <button type="button" class="next-btn">ถัดไป</button>
                    <button type="submit" class="submit-btn" style="display:none;">สมัครสมาชิก</button>
                </div>
            </form>
        </div>
    </section>
</main>

<!-- Member Dashboard -->
<main class="member-dashboard">
    <section class="dashboard-header">
        <div class="container">
            <h1>ยินดีต้อนรับ, [ชื่อสมาชิก]</h1>
            <div class="member-stats">
                <div class="stat-card">
                    <h3>การสอบถาม</h3>
                    <span class="stat-number">5</span>
                </div>
                <div class="stat-card">
                    <h3>การจอง</h3>
                    <span class="stat-number">2</span>
                </div>
            </div>
        </div>
    </section>

    <section class="dashboard-content">
        <div class="container">
            <div class="dashboard-grid">
                <div class="dashboard-card">
                    <h3>ไก่ที่สนใจ</h3>
                    <div class="favorite-roosters">
                        <!-- List of favorited roosters -->
                    </div>
                </div>
                <div class="dashboard-card">
                    <h3>ประวัติการสอบถาม</h3>
                    <div class="inquiry-history">
                        <!-- List of inquiries -->
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
```

### 7. Multi-language System Design

```php
// Language Switcher Component
function ayam_language_switcher() {
    if (function_exists('icl_get_languages')) {
        $languages = icl_get_languages('skip_missing=0&orderby=code');
        if (!empty($languages)) {
            echo '<div class="language-switcher">';
            foreach ($languages as $lang) {
                $class = $lang['active'] ? 'active' : '';
                echo '<a href="' . $lang['url'] . '" class="lang-link ' . $class . '">';
                echo '<img src="' . $lang['country_flag_url'] . '" alt="' . $lang['native_name'] . '">';
                echo '<span>' . $lang['native_name'] . '</span>';
                echo '</a>';
            }
            echo '</div>';
        }
    }
}

// Multi-language Content Structure
$content_structure = [
    'thai' => [
        'site_title' => 'Ayam Bangkok - ส่งออกไก่ชนไทย',
        'navigation' => [
            'home' => 'หน้าแรก',
            'about' => 'เกี่ยวกับเรา',
            'gallery' => 'แกลเลอรี่',
            'news' => 'ข่าวสาร',
            'contact' => 'ติดต่อเรา'
        ]
    ],
    'indonesian' => [
        'site_title' => 'Ayam Bangkok - Ekspor Ayam Thailand',
        'navigation' => [
            'home' => 'Beranda',
            'about' => 'Tentang Kami',
            'gallery' => 'Galeri',
            'news' => 'Berita',
            'contact' => 'Kontak'
        ]
    ]
];
```

### 8. News System Design

```html
<!-- News Page Layout -->
<main class="news-page">
    <section class="news-header">
        <div class="container">
            <h1>ข่าวสาร Ayam Bangkok</h1>
            <p>ติดตามข่าวสารการส่งออกไก่ชนไทยล่าสุด</p>
        </div>
    </section>

    <!-- Featured News -->
    <section class="featured-news">
        <div class="container">
            <div class="featured-article">
                <h2>ส่งออกไก่พื้นเมืองไทย "Ayam Bangkok" ไปอินโดนีเซีย เพิ่มจำนวนต่อเนื่อง มูลค่า 4 ล้านบาท</h2>
                <div class="article-meta">
                    <span class="date">24 กันยายน 2567</span>
                    <span class="category">ข่าวส่งออก</span>
                </div>
                <div class="article-excerpt">
                    <p>กรมปศุสัตว์เผยความสำเร็จในการส่งออกไก่พื้นเมืองไทย "Ayam Bangkok" ไปยังประเทศอินโดนีเซีย...</p>
                </div>
            </div>
        </div>
    </section>

    <!-- News Categories -->
    <section class="news-categories">
        <div class="container">
            <div class="category-tabs">
                <button class="tab-btn active" data-category="export">ข่าวส่งออก</button>
                <button class="tab-btn" data-category="success">ความสำเร็จ</button>
                <button class="tab-btn" data-category="media">สื่อมวลชน</button>
            </div>
        </div>
    </section>

    <!-- News Grid -->
    <section class="news-grid">
        <div class="container">
            <div class="news-articles">
                <!-- Export News Category -->
                <div class="news-category active" data-category="export">
                    <div class="article-card">
                        <div class="article-image">
                            <img src="pic-home/1/IMG_3038.jpg" alt="ข่าวส่งออก">
                        </div>
                        <div class="article-content">
                            <h3>ส่งออกไก่พื้นเมืองไทย "Ayam Bangkok" ไปอินโด</h3>
                            <p class="article-source">ข่าวสด</p>
                            <a href="https://www.khaosod.co.th/update-news/news_9931581" target="_blank" class="read-more">อ่านต่อ</a>
                        </div>
                    </div>
                    
                    <div class="article-card">
                        <div class="article-image">
                            <img src="pic-home/2/IMG_1660.jpg" alt="ข่าวเศรษฐกิจ">
                        </div>
                        <div class="article-content">
                            <h3>ปศุสัตว์ปลื้ม! ดันส่งออก "Ayam Bangkok"</h3>
                            <p class="article-source">ประชาชาติธุรกิจ</p>
                            <a href="https://www.prachachat.net/economy/news-1881670" target="_blank" class="read-more">อ่านต่อ</a>
                        </div>
                    </div>
                </div>

                <!-- Success Stories Category -->
                <div class="news-category" data-category="success">
                    <div class="article-card">
                        <div class="article-image">
                            <img src="pic-home/3/IMG_3062.jpg" alt="ความสำเร็จ">
                        </div>
                        <div class="article-content">
                            <h3>เพิ่มจำนวนต่อเนื่อง มูลค่า 4 ล้านบาท</h3>
                            <p class="article-source">บ้านเมือง</p>
                            <a href="https://www.banmuang.co.th/news/politic/445881" target="_blank" class="read-more">อ่านต่อ</a>
                        </div>
                    </div>
                </div>

                <!-- Media Coverage Category -->
                <div class="news-category" data-category="media">
                    <div class="article-card social-media">
                        <div class="article-content">
                            <h3>Thailand Plus TV Coverage</h3>
                            <p class="article-source">Thailand Plus</p>
                            <a href="https://www.thailandplus.tv/archives/955823" target="_blank" class="read-more">ดูข่าว</a>
                        </div>
                    </div>
                    
                    <div class="article-card social-media">
                        <div class="article-content">
                            <h3>Facebook Coverage</h3>
                            <p class="article-source">Facebook</p>
                            <a href="https://m.facebook.com/story.php?story_fbid=pfbid0hbSB4KLPr9V5UXK7CxwGfirUrpyyeUndoHtfDJVJfDWAtHF1DCaTaTVgwf7sp5gPl&id=100063700894306" target="_blank" class="read-more">ดูโพสต์</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
```

```php
// News Data Structure
$news_articles = [
    'export_news' => [
        [
            'title' => 'ส่งออกไก่พื้นเมืองไทย "Ayam Bangkok" ไปอินโดนีเซีย เพิ่มจำนวนต่อเนื่อง มูลค่า 4 ล้านบาท',
            'source' => 'ข่าวสด',
            'url' => 'https://www.khaosod.co.th/update-news/news_9931581',
            'image' => 'pic-home/1/IMG_3038.jpg',
            'category' => 'export'
        ],
        [
            'title' => 'ปศุสัตว์ปลื้ม! ดันส่งออก "Ayam Bangkok" ไทยแลนด์สู่อินโดนีเซีย',
            'source' => 'ประชาชาติธุรกิจ',
            'url' => 'https://www.prachachat.net/economy/news-1881670',
            'image' => 'pic-home/2/IMG_1660.jpg',
            'category' => 'export'
        ],
        // More articles...
    ],
    'success_stories' => [
        [
            'title' => 'เพิ่มจำนวนต่อเนื่อง มูลค่า 4 ล้านบาท',
            'source' => 'บ้านเมือง',
            'url' => 'https://www.banmuang.co.th/news/politic/445881',
            'image' => 'pic-home/3/IMG_3062.jpg',
            'category' => 'success'
        ]
    ],
    'media_coverage' => [
        [
            'title' => 'Thailand Plus TV Coverage',
            'source' => 'Thailand Plus',
            'url' => 'https://www.thailandplus.tv/archives/955823',
            'type' => 'video',
            'category' => 'media'
        ],
        [
            'title' => 'Twitter Coverage',
            'source' => 'Twitter',
            'url' => 'https://twitter.com/Thailandplus1/status/1965725993441890639',
            'type' => 'social',
            'category' => 'media'
        ]
    ]
];
```

### 9. About Page Design

```html
<!-- About Page Layout -->
<main class="about-page">
    <!-- Company History Section -->
    <section class="company-history">
        <div class="container">
            <div class="content-grid">
                <div class="text-content">
                    <h2>ประวัติบริษัท หนองจอก เอฟซีไอ</h2>
                    <p>ตัวแทนส่งออกไก่ชนไปยังประเทศอินโดนีเซียอย่างเป็นทางการรายเดียวของประเทศไทย</p>
                    <div class="history-timeline">
                        <div class="timeline-item">
                            <div class="year">2020</div>
                            <div class="event">ก่อตั้งบริษัท</div>
                        </div>
                        <div class="timeline-item">
                            <div class="year">2021</div>
                            <div class="event">ได้รับใบอนุญาตส่งออกอย่างเป็นทางการ</div>
                        </div>
                        <div class="timeline-item">
                            <div class="year">2024</div>
                            <div class="event">ส่งออกสำเร็จมูลค่า 4 ล้านบาท</div>
                        </div>
                    </div>
                </div>
                <div class="image-content">
                    <img src="pic-home/gallery/IMG_1415.jpg" alt="บริษัท FCI">
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Information Section -->
    <section class="contact-info">
        <div class="container">
            <h2>ข้อมูลติดต่อ</h2>
            <div class="contact-grid">
                <div class="contact-card">
                    <div class="contact-icon">📍</div>
                    <h3>ที่อยู่</h3>
                    <p>123 หมู่ 5 ตำบลหนองจอก<br>อำเภอหนองจอก กรุงเทพฯ 10530</p>
                </div>
                <div class="contact-card">
                    <div class="contact-icon">📞</div>
                    <h3>เบอร์โทรศัพท์</h3>
                    <p>02-123-4567<br>081-234-5678</p>
                </div>
                <div class="contact-card">
                    <div class="contact-icon">✉️</div>
                    <h3>อีเมล</h3>
                    <p>info@ayambangkok.com<br>export@ayambangkok.com</p>
                </div>
            </div>
            
            <!-- Google Maps Integration -->
            <div class="map-container">
                <div id="google-map" style="height: 400px; width: 100%;"></div>
            </div>
        </div>
    </section>

    <!-- Vision & Mission Section -->
    <section class="vision-mission">
        <div class="container">
            <div class="vm-grid">
                <div class="vision-card">
                    <h3>วิสัยทัศน์</h3>
                    <p>เป็นผู้นำในการส่งออกไก่ชนไทยคุณภาพสูงสู่ตลาดอินโดนีเซีย</p>
                </div>
                <div class="mission-card">
                    <h3>พันธกิจ</h3>
                    <p>ส่งมอบไก่ชนไทยคุณภาพดีที่ผ่านมาตรฐานการส่งออกอย่างครบถ้วน</p>
                </div>
            </div>
        </div>
    </section>
</main>
```

### 10. Modern Homepage Design Structure

```html
<!-- Modern Homepage Layout -->
<main class="homepage-modern">
    <!-- 1. Hero Image Slider Section -->
    <section class="hero-slider-section">
        <div class="swiper hero-swiper">
            <div class="swiper-wrapper">
                <!-- Multiple slides with background images -->
                <div class="swiper-slide">
                    <div class="slide-content">
                        <h1>Slide Title</h1>
                        <p>Slide Description</p>
                        <div class="slide-buttons">
                            <a href="#" class="btn-modern primary">CTA Button</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Navigation -->
            <div class="swiper-pagination"></div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
    </section>

    <!-- 2. Welcome Section (After Slider) -->
    <section class="welcome-section">
        <div class="container">
            <div class="welcome-content">
                <h2>ยินดีต้อนรับสู่ Ayam Bangkok</h2>
                <p>ตัวแทนส่งออกไก่ชนไปยังประเทศอินโดนีเซียอย่างเป็นทางการรายเดียวของประเทศไทย</p>
            </div>
        </div>
    </section>

    <!-- 3. Export Process Flow -->
    <section class="export-process-section">
        <!-- Step-by-step export process visualization -->
        <div class="process-steps">
            <div class="step">รับไก่เข้า</div>
            <div class="step">ชั่งน้ำหนัก</div>
            <div class="step">ถ่ายรูป</div>
            <div class="step">ตรวจสุขภาพ</div>
            <div class="step">ทำเอกสาร</div>
            <div class="step">กักกัน</div>
            <div class="step">ส่งขึ้นเครื่อง</div>
        </div>
    </section>

    <!-- 4. Export Statistics & Success Stories -->
    <section class="export-stats-section">
        <!-- Statistics and testimonials -->
    </section>

    <!-- 5. Sample Export Cases -->
    <section class="export-cases-section">
        <!-- Examples of successfully exported roosters with tracking -->
    </section>

    <!-- 5. Latest News with Modern Layout -->
    <section class="news-modern-section">
        <!-- Modern news cards -->
    </section>

    <!-- 6. Contact Section with Modern Design -->
    <section class="contact-modern-section">
        <!-- Modern contact form and info -->
    </section>
</main>
```

### 6. Modern Design Elements

```css
/* Ayam Bangkok Design System - Based on Wix Reference */
:root {
    /* Brand Color Palette */
    --primary-color: #1E2950;     /* Navy Blue - Main brand color */
    --primary-light: #2a3a6b;     /* Lighter navy */
    --primary-dark: #151f3d;      /* Darker navy */
    --secondary-color: #CA4249;   /* Brick Red - Secondary brand color */
    --secondary-light: #d65a60;   /* Lighter red */
    --secondary-dark: #b73238;    /* Darker red */
    --accent-color: #f4f4f4;      /* Light gray for accents */
    --text-primary: #1E2950;      /* Navy for primary text */
    --text-secondary: #6b7280;    /* Gray for secondary text */
    --background-light: #ffffff;  /* Pure white background */
    --background-section: #f8fafc; /* Very light gray for sections */
    --white: #ffffff;
    
    /* Typography - Lighter Font Weights */
    --font-weight-light: 300;
    --font-weight-normal: 400;
    --font-weight-medium: 500;
    --font-weight-semibold: 600;
    --font-weight-bold: 700;
    
    /* Gradients */
    --gradient-primary: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    --gradient-secondary: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    --gradient-overlay: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.6));
    
    /* Shadows */
    --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
    --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
    
    /* Border Radius */
    --radius-sm: 0.375rem;
    --radius-md: 0.5rem;
    --radius-lg: 0.75rem;
    --radius-xl: 1rem;
    
    /* Spacing */
    --spacing-xs: 0.5rem;
    --spacing-sm: 1rem;
    --spacing-md: 1.5rem;
    --spacing-lg: 2rem;
    --spacing-xl: 3rem;
    --spacing-2xl: 4rem;
}

/* Modern Button Styles */
.btn-modern {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    border-radius: var(--radius-lg);
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
}

.btn-modern.primary {
    background: var(--gradient-primary);
    color: white;
    box-shadow: var(--shadow-md);
}

.btn-modern.primary:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-lg);
}

/* Modern Card Styles - Improved Rooster Section */
.card-modern {
    background: white;
    border-radius: var(--radius-xl);
    box-shadow: var(--shadow-md);
    overflow: hidden;
    transition: all 0.3s ease;
    border: 1px solid #f1f5f9; /* Subtle border */
}

.card-modern:hover {
    transform: translateY(-8px);
    box-shadow: var(--shadow-xl);
    border-color: var(--primary-light);
}

/* Export-Ready Roosters Section Improvements */
.export-roosters-section {
    padding: 4rem 0;
    background: var(--background-section);
}

.export-roosters-section .section-title {
    text-align: center;
    margin-bottom: 1rem;
    font-weight: var(--font-weight-medium); /* Lighter font */
    color: var(--text-primary);
    font-size: 2.5rem;
}

.export-roosters-section .section-subtitle {
    text-align: center;
    margin-bottom: 3rem;
    font-weight: var(--font-weight-normal);
    color: var(--text-secondary);
    font-size: 1.1rem;
}

.rooster-card {
    background: white;
    border-radius: 1.5rem;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08); /* Softer shadow */
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    border: 1px solid #f1f5f9;
}

.rooster-card:hover {
    transform: translateY(-12px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
    border-color: var(--primary-light);
}

.rooster-card .card-image {
    position: relative;
    height: 250px;
    overflow: hidden;
}

.rooster-card .card-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.4s ease;
}

.rooster-card:hover .card-image img {
    transform: scale(1.08);
}

.rooster-card .card-content {
    padding: 1.5rem;
}

.rooster-card .card-title {
    font-size: 1.25rem;
    font-weight: var(--font-weight-medium); /* Lighter font */
    color: var(--text-primary);
    margin-bottom: 0.5rem;
    line-height: 1.4;
}

.rooster-card .card-description {
    color: var(--text-secondary);
    font-size: 0.95rem;
    line-height: 1.6;
    margin-bottom: 1rem;
    font-weight: var(--font-weight-normal);
}

.rooster-card .card-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
}

.rooster-card .export-status {
    font-size: 1rem;
    font-weight: var(--font-weight-medium);
    color: var(--accent-color);
    background: rgba(16, 185, 129, 0.1);
    padding: 0.25rem 0.75rem;
    border-radius: 1rem;
    display: inline-block;
}

.rooster-card .breed-badge {
    background: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 100%);
    color: #0369a1;
    padding: 0.25rem 0.75rem;
    border-radius: 1rem;
    font-size: 0.8rem;
    font-weight: var(--font-weight-medium);
}

/* Hero Slider Styles */
.hero-slider-section {
    height: 100vh;
    position: relative;
    overflow: hidden;
}

.hero-swiper .swiper-slide {
    background-size: cover;
    background-position: center;
    position: relative;
}

.hero-swiper .swiper-slide::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: var(--gradient-overlay);
}

.slide-content {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    text-align: center;
    color: white;
    z-index: 2;
}

/* Animation Classes */
.fade-in-up {
    opacity: 0;
    transform: translateY(30px);
    animation: fadeInUp 0.8s ease forwards;
}

@keyframes fadeInUp {
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.scale-on-hover {
    transition: transform 0.3s ease;
}

.scale-on-hover:hover {
    transform: scale(1.05);
}
```

## Data Models

### Rooster Data Model
```sql
-- wp_posts (WordPress Core)
ID, post_title, post_content, post_status, post_date

-- wp_postmeta (Custom Fields via ACF)
rooster_price          DECIMAL(10,2)
rooster_age            INT
rooster_weight         DECIMAL(5,2)
rooster_color          VARCHAR(100)
rooster_fighting_record TEXT
rooster_pedigree_father VARCHAR(200)
rooster_pedigree_mother VARCHAR(200)
rooster_health_status   VARCHAR(50)
rooster_export_ready    BOOLEAN
rooster_gallery        TEXT (JSON array of image IDs)
rooster_video_url      VARCHAR(500)

-- wp_term_relationships (Taxonomies)
breed_id, category_id
```

### Homepage Slider Data Model
```sql
-- wp_postmeta (Homepage Slider Settings via ACF)
homepage_slider_images    TEXT (JSON array of slide data)
slide_title              VARCHAR(200)
slide_description        TEXT
slide_button_text        VARCHAR(100)
slide_button_url         VARCHAR(500)
slide_background_image   INT (attachment ID)
slider_autoplay_speed    INT (milliseconds)
slider_show_navigation   BOOLEAN
slider_show_pagination   BOOLEAN
```

### User Profile Extensions
```sql
-- wp_usermeta (Extended User Fields)
member_type            VARCHAR(50)
company_name           VARCHAR(200)
phone_number           VARCHAR(20)
line_id               VARCHAR(100)
address               TEXT
export_history        TEXT (JSON array)
preferred_breeds      TEXT (JSON array)
notification_settings TEXT (JSON object)
```

### Custom Tables
```sql
-- wp_ayam_bookings (การจองบริการ)
CREATE TABLE wp_ayam_bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    service_id INT,
    booking_date DATETIME,
    status VARCHAR(50),
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- wp_ayam_inquiries (การสอบถาม)
CREATE TABLE wp_ayam_inquiries (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    rooster_id INT,
    message TEXT,
    status VARCHAR(50),
    response TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- wp_ayam_export_records (บันทึกการส่งออก)
CREATE TABLE wp_ayam_export_records (
    id INT AUTO_INCREMENT PRIMARY KEY,
    rooster_id INT,
    customer_id INT,
    export_date DATE,
    destination_country VARCHAR(100),
    status VARCHAR(50),
    tracking_number VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

## Error Handling

### 1. Frontend Error Handling
```javascript
// AJAX Error Handling
$.ajaxSetup({
    error: function(xhr, status, error) {
        if (xhr.status === 404) {
            showNotification('ไม่พบข้อมูลที่ต้องการ', 'error');
        } else if (xhr.status === 500) {
            showNotification('เกิดข้อผิดพลาดของระบบ กรุณาลองใหม่อีกครั้ง', 'error');
        }
    }
});

// Form Validation
function validateContactForm() {
    const errors = [];
    
    if (!$('#name').val().trim()) {
        errors.push('กรุณากรอกชื่อ');
    }
    
    if (!isValidEmail($('#email').val())) {
        errors.push('กรุณากรอกอีเมลที่ถูกต้อง');
    }
    
    if (errors.length > 0) {
        showErrors(errors);
        return false;
    }
    
    return true;
}
```

### 2. Backend Error Handling
```php
// WordPress Error Handling
function ayam_handle_errors() {
    if (WP_DEBUG) {
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
    } else {
        error_reporting(0);
        ini_set('display_errors', 0);
        ini_set('log_errors', 1);
        ini_set('error_log', WP_CONTENT_DIR . '/debug.log');
    }
}

// Custom Error Logging
function ayam_log_error($message, $context = []) {
    if (function_exists('error_log')) {
        $log_message = '[AYAM] ' . $message;
        if (!empty($context)) {
            $log_message .= ' Context: ' . json_encode($context);
        }
        error_log($log_message);
    }
}

// Database Error Handling
function ayam_safe_query($query, $params = []) {
    global $wpdb;
    
    $prepared_query = $wpdb->prepare($query, $params);
    $result = $wpdb->query($prepared_query);
    
    if ($wpdb->last_error) {
        ayam_log_error('Database Error: ' . $wpdb->last_error, [
            'query' => $prepared_query
        ]);
        return false;
    }
    
    return $result;
}
```

### 3. Security Measures
```php
// Input Sanitization
function ayam_sanitize_input($input, $type = 'text') {
    switch ($type) {
        case 'email':
            return sanitize_email($input);
        case 'url':
            return esc_url_raw($input);
        case 'int':
            return intval($input);
        case 'float':
            return floatval($input);
        default:
            return sanitize_text_field($input);
    }
}

// Nonce Verification
function ayam_verify_nonce($action) {
    if (!wp_verify_nonce($_POST['_wpnonce'], $action)) {
        wp_die('Security check failed');
    }
}

// User Capability Check
function ayam_check_user_capability($capability) {
    if (!current_user_can($capability)) {
        wp_die('You do not have permission to perform this action');
    }
}
```

## Testing Strategy

### 1. Unit Testing
```php
// PHPUnit Tests for Custom Functions
class AyamRoosterTest extends WP_UnitTestCase {
    
    public function test_create_rooster() {
        $rooster_data = [
            'post_title' => 'Test Rooster',
            'post_type' => 'ayam_rooster',
            'post_status' => 'publish'
        ];
        
        $rooster_id = wp_insert_post($rooster_data);
        $this->assertGreaterThan(0, $rooster_id);
    }
    
    public function test_rooster_price_calculation() {
        $base_price = 5000;
        $calculated_price = ayam_calculate_rooster_price($base_price, 'premium');
        $this->assertEquals(6000, $calculated_price);
    }
}
```

### 2. Integration Testing
```javascript
// JavaScript Testing with Jest
describe('Rooster Catalog', () => {
    test('should filter roosters by breed', async () => {
        const response = await fetch('/wp-json/ayam/v1/roosters?breed=thai');
        const data = await response.json();
        
        expect(data.length).toBeGreaterThan(0);
        expect(data[0].breed).toBe('thai');
    });
    
    test('should handle empty search results', async () => {
        const response = await fetch('/wp-json/ayam/v1/roosters?search=nonexistent');
        const data = await response.json();
        
        expect(data.length).toBe(0);
    });
});
```

### 3. User Acceptance Testing
```gherkin
# Gherkin Scenarios for UAT
Feature: Rooster Catalog Search
  
  Scenario: User searches for roosters by breed
    Given I am on the rooster catalog page
    When I select "ไก่ชนไทยพื้นเมือง" from the breed filter
    And I click the search button
    Then I should see only roosters of Thai native breed
    And the results should be displayed in a grid layout
    
  Scenario: User views rooster details
    Given I am viewing the rooster catalog
    When I click on a rooster card
    Then I should be taken to the rooster detail page
    And I should see high-quality images
    And I should see complete rooster information
```

### 4. Performance Testing
```php
// Performance Monitoring
function ayam_monitor_query_performance() {
    if (defined('SAVEQUERIES') && SAVEQUERIES) {
        global $wpdb;
        
        $slow_queries = [];
        foreach ($wpdb->queries as $query) {
            if ($query[1] > 0.1) { // Queries taking more than 100ms
                $slow_queries[] = $query;
            }
        }
        
        if (!empty($slow_queries)) {
            ayam_log_error('Slow queries detected', $slow_queries);
        }
    }
}

// Caching Strategy
function ayam_cache_rooster_data($rooster_id) {
    $cache_key = 'ayam_rooster_' . $rooster_id;
    $cached_data = wp_cache_get($cache_key);
    
    if (false === $cached_data) {
        $cached_data = ayam_get_rooster_data($rooster_id);
        wp_cache_set($cache_key, $cached_data, '', 3600); // Cache for 1 hour
    }
    
    return $cached_data;
}
```

### 5. Mobile Testing
- **Responsive Design Testing**: ทดสอบบนอุปกรณ์ต่างๆ (iPhone, Android, iPad)
- **Touch Interface Testing**: ทดสอบการใช้งานแบบสัมผัส
- **Performance Testing**: ทดสอบความเร็วบนเครือข่าย 3G/4G
- **Cross-browser Testing**: ทดสอบบน Safari, Chrome Mobile, Firefox Mobile

### 6. Security Testing
- **SQL Injection Testing**: ทดสอบการป้องกัน SQL Injection
- **XSS Testing**: ทดสอบการป้องกัน Cross-Site Scripting
- **CSRF Testing**: ทดสอบการป้องกัน Cross-Site Request Forgery
- **File Upload Testing**: ทดสอบการอัพโหลดไฟล์ที่ปลอดภัย
- **Authentication Testing**: ทดสอบระบบการเข้าสู่ระบบ
### 
7. JavaScript Components Architecture

```javascript
// Modern Homepage JavaScript Structure
class AyamHomepage {
    constructor() {
        this.initSlider();
        this.initAnimations();
        this.initLazyLoading();
        this.initContactForm();
    }

    // Hero Slider Implementation
    initSlider() {
        this.heroSwiper = new Swiper('.hero-swiper', {
            loop: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            effect: 'fade',
            fadeEffect: {
                crossFade: true
            },
            on: {
                slideChange: () => {
                    this.animateSlideContent();
                }
            }
        });
    }

    // Scroll Animations
    initAnimations() {
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true,
            offset: 100
        });
    }

    // Lazy Loading for Images
    initLazyLoading() {
        const images = document.querySelectorAll('img[data-src]');
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src;
                    img.classList.remove('lazy');
                    observer.unobserve(img);
                }
            });
        });

        images.forEach(img => imageObserver.observe(img));
    }

    // Contact Form Handler
    initContactForm() {
        const form = document.querySelector('.quick-contact-form');
        if (form) {
            form.addEventListener('submit', this.handleContactSubmit.bind(this));
        }
    }

    async handleContactSubmit(e) {
        e.preventDefault();
        const formData = new FormData(e.target);
        
        try {
            const response = await fetch(ayam_ajax.ajax_url, {
                method: 'POST',
                body: formData
            });
            
            const result = await response.json();
            this.showNotification(result.message, result.success ? 'success' : 'error');
            
            if (result.success) {
                e.target.reset();
            }
        } catch (error) {
            this.showNotification('เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง', 'error');
        }
    }

    showNotification(message, type) {
        // Modern notification system
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        notification.textContent = message;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.classList.add('show');
        }, 100);
        
        setTimeout(() => {
            notification.classList.remove('show');
            setTimeout(() => {
                document.body.removeChild(notification);
            }, 300);
        }, 3000);
    }
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    new AyamHomepage();
});
```

### 8. Advanced CSS Architecture

```scss
// SCSS Structure for Modern Design
// _variables.scss
$primary-colors: (
    50: #eff6ff,
    100: #dbeafe,
    200: #bfdbfe,
    300: #93c5fd,
    400: #60a5fa,
    500: #3b82f6,
    600: #2563eb,
    700: #1d4ed8,
    800: #1e40af,
    900: #1e3a8a
);

$gradients: (
    primary: linear-gradient(135deg, #667eea 0%, #764ba2 100%),
    secondary: linear-gradient(135deg, #f093fb 0%, #f5576c 100%),
    success: linear-gradient(135deg, #84fab0 0%, #8fd3f4 100%),
    overlay: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.6))
);

// _mixins.scss
@mixin card-hover {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    
    &:hover {
        transform: translateY(-8px);
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    }
}

@mixin button-modern($bg-color, $text-color: white) {
    background: $bg-color;
    color: $text-color;
    border: none;
    border-radius: 0.75rem;
    padding: 0.75rem 1.5rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    
    &:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    }
}

// _components.scss
.hero-slider-section {
    height: 100vh;
    position: relative;
    overflow: hidden;
    
    .swiper-slide {
        background-size: cover;
        background-position: center;
        position: relative;
        
        &::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(rgba(0,0,0,0.2), rgba(0,0,0,0.4)); /* Lighter overlay */
            z-index: 1;
        }
    }
    
    .slide-content {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
        color: white;
        z-index: 2;
        max-width: 800px;
        padding: 0 2rem;
        
        h1 {
            font-size: clamp(2rem, 5vw, 4rem);
            font-weight: 600; /* Lighter font weight */
            margin-bottom: 1rem;
            text-shadow: 0 2px 8px rgba(0, 0, 0, 0.2); /* Softer shadow */
            letter-spacing: -0.02em;
        }
        
        p {
            font-size: clamp(1rem, 2vw, 1.25rem);
            margin-bottom: 2rem;
            opacity: 0.95; /* More visible */
            font-weight: 400; /* Lighter font weight */
            line-height: 1.6;
        }
    }
    
    .swiper-pagination {
        bottom: 2rem;
        
        .swiper-pagination-bullet {
            width: 12px;
            height: 12px;
            background: rgba(255, 255, 255, 0.5);
            opacity: 1;
            
            &.swiper-pagination-bullet-active {
                background: white;
            }
        }
    }
    
    .swiper-button-next,
    .swiper-button-prev {
        color: white;
        
        &::after {
            font-size: 1.5rem;
        }
    }
}

.welcome-section {
    padding: 5rem 0;
    background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); /* Brighter background */
    
    .welcome-content {
        text-align: center;
        max-width: 800px;
        margin: 0 auto;
        
        h2 {
            font-size: clamp(2rem, 4vw, 3rem);
            font-weight: 500; /* Much lighter font weight */
            color: #374151; /* Lighter text color */
            margin-bottom: 1.5rem;
            letter-spacing: -0.01em;
        }
        
        p {
            font-size: 1.125rem;
            color: #6b7280; /* Lighter gray */
            line-height: 1.7;
            font-weight: 400; /* Lighter font weight */
        }
    }
}

.card-modern {
    background: white;
    border-radius: 1rem;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    @include card-hover;
    
    .card-image {
        position: relative;
        overflow: hidden;
        
        img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            transition: transform 0.3s ease;
        }
        
        &:hover img {
            transform: scale(1.05);
        }
    }
    
    .card-content {
        padding: 1.5rem;
        
        h3 {
            font-size: 1.25rem;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 0.5rem;
        }
        
        p {
            color: #64748b;
            line-height: 1.6;
        }
    }
}

// Animation keyframes
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes slideInLeft {
    from {
        opacity: 0;
        transform: translateX(-30px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes slideInRight {
    from {
        opacity: 0;
        transform: translateX(30px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

// Utility classes
.fade-in-up {
    animation: fadeInUp 0.8s ease forwards;
}

.slide-in-left {
    animation: slideInLeft 0.8s ease forwards;
}

.slide-in-right {
    animation: slideInRight 0.8s ease forwards;
}

// Responsive design
@media (max-width: 768px) {
    .hero-slider-section {
        height: 70vh;
        
        .slide-content {
            padding: 0 1rem;
            
            h1 {
                font-size: 2rem;
            }
            
            p {
                font-size: 1rem;
            }
        }
    }
    
    .welcome-section {
        padding: 3rem 0;
        
        .welcome-content {
            h2 {
                font-size: 1.75rem;
            }
            
            p {
                font-size: 1rem;
            }
        }
    }
}
```
### 9.
 Typography System - Light & Readable

```css
/* Typography Improvements for Better Readability */
body {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    font-weight: 400; /* Base light weight */
    line-height: 1.6;
    color: var(--text-primary);
    background-color: var(--background-light);
}

/* Heading Styles - Lighter Weights */
h1, h2, h3, h4, h5, h6 {
    font-weight: var(--font-weight-medium); /* Much lighter than before */
    line-height: 1.3;
    letter-spacing: -0.01em;
    color: var(--text-primary);
}

h1 { font-size: 2.5rem; font-weight: var(--font-weight-semibold); }
h2 { font-size: 2rem; font-weight: var(--font-weight-medium); }
h3 { font-size: 1.5rem; font-weight: var(--font-weight-medium); }
h4 { font-size: 1.25rem; font-weight: var(--font-weight-medium); }
h5 { font-size: 1.125rem; font-weight: var(--font-weight-normal); }
h6 { font-size: 1rem; font-weight: var(--font-weight-normal); }

/* Paragraph Styles */
p {
    font-weight: var(--font-weight-normal);
    line-height: 1.7;
    color: var(--text-secondary);
    margin-bottom: 1rem;
}

/* Link Styles */
a {
    color: var(--primary-color);
    text-decoration: none;
    font-weight: var(--font-weight-normal);
    transition: color 0.2s ease;
}

a:hover {
    color: var(--primary-dark);
}

/* Button Text */
.btn-modern {
    font-weight: var(--font-weight-medium); /* Lighter button text */
    letter-spacing: 0.01em;
}
```

### 10. Improved Rooster Section Layout

```css
/* Better Rooster Section Design */
.roosters-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
    gap: 2rem;
    padding: 0 1rem;
    max-width: 1200px;
    margin: 0 auto;
}

.rooster-card-wrapper {
    position: relative;
}

.rooster-card .status-badge {
    position: absolute;
    top: 1rem;
    right: 1rem;
    background: rgba(16, 185, 129, 0.9);
    color: white;
    padding: 0.25rem 0.75rem;
    border-radius: 1rem;
    font-size: 0.8rem;
    font-weight: var(--font-weight-medium);
    z-index: 2;
}

.rooster-card .status-badge.sold {
    background: rgba(239, 68, 68, 0.9);
}

.rooster-card .status-badge.reserved {
    background: rgba(245, 158, 11, 0.9);
}

/* Card Content Improvements */
.rooster-card .card-stats {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 0.5rem;
    margin: 1rem 0;
    padding: 1rem;
    background: #f8fafc;
    border-radius: 0.75rem;
}

.rooster-card .stat-item {
    text-align: center;
}

.rooster-card .stat-label {
    font-size: 0.8rem;
    color: var(--text-secondary);
    font-weight: var(--font-weight-normal);
    margin-bottom: 0.25rem;
}

.rooster-card .stat-value {
    font-size: 1rem;
    font-weight: var(--font-weight-medium);
    color: var(--text-primary);
}

/* Action Buttons */
.rooster-card .card-actions {
    display: flex;
    gap: 0.75rem;
    margin-top: 1rem;
}

.rooster-card .btn-export-inquiry {
    flex: 1;
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
    padding: 0.75rem 1rem;
    border-radius: 0.75rem;
    text-align: center;
    font-weight: var(--font-weight-medium);
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
}

.rooster-card .btn-export-inquiry:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(16, 185, 129, 0.3);
}

.rooster-card .btn-find-similar {
    background: white;
    color: var(--primary-color);
    border: 2px solid var(--primary-color);
    padding: 0.75rem 1rem;
    border-radius: 0.75rem;
    font-weight: var(--font-weight-medium);
    transition: all 0.3s ease;
    cursor: pointer;
}

.rooster-card .btn-find-similar:hover {
    background: var(--primary-color);
    color: white;
    transform: translateY(-2px);
}
```

### 11. Mobile Responsiveness Improvements

```css
/* Mobile-First Responsive Design */
@media (max-width: 768px) {
    .roosters-grid {
        grid-template-columns: 1fr;
        gap: 1.5rem;
        padding: 0 1rem;
    }
    
    .rooster-card {
        margin: 0 auto;
        max-width: 400px;
    }
    
    .rooster-card .card-title {
        font-size: 1.1rem;
    }
    
    .rooster-card .card-stats {
        grid-template-columns: 1fr 1fr 1fr;
    }
    
    .rooster-card .card-actions {
        flex-direction: column;
        gap: 0.5rem;
    }
    
    /* Typography adjustments for mobile */
    h1 { font-size: 2rem; }
    h2 { font-size: 1.75rem; }
    h3 { font-size: 1.25rem; }
    
    body {
        font-size: 0.95rem;
    }
}

@media (max-width: 480px) {
    .roosters-grid {
        padding: 0 0.75rem;
    }
    
    .rooster-card .card-content {
        padding: 1.25rem;
    }
    
    .rooster-card .card-stats {
        grid-template-columns: 1fr 1fr;
        gap: 0.75rem;
    }
}
```

### 12. Color Accessibility Improvements

```css
/* Enhanced Color Contrast for Better Readability */
:root {
    /* Improved contrast ratios */
    --text-primary: #1f2937;      /* WCAG AA compliant */
    --text-secondary: #4b5563;    /* Better contrast than before */
    --text-muted: #6b7280;        /* For less important text */
    
    /* Background variations */
    --bg-primary: #ffffff;
    --bg-secondary: #f9fafb;
    --bg-tertiary: #f3f4f6;
    
    /* Interactive states */
    --hover-bg: #f3f4f6;
    --active-bg: #e5e7eb;
    
    /* Border colors */
    --border-light: #f3f4f6;
    --border-medium: #e5e7eb;
    --border-dark: #d1d5db;
}

/* Focus states for accessibility */
.btn-modern:focus,
.rooster-card:focus,
a:focus {
    outline: 2px solid var(--primary-color);
    outline-offset: 2px;
}

/* High contrast mode support */
@media (prefers-contrast: high) {
    :root {
        --text-primary: #000000;
        --text-secondary: #333333;
        --border-light: #666666;
        --border-medium: #333333;
    }
}

/* Reduced motion support */
@media (prefers-reduced-motion: reduce) {
    *,
    *::before,
    *::after {
        animation-duration: 0.01ms !important;
        animation-iteration-count: 1 !important;
        transition-duration: 0.01ms !important;
    }
}
```
###
 13. Export Process Flow Design

```css
/* Export Process Flow Section */
.export-process-section {
    padding: 5rem 0;
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
}

.export-process-section .section-title {
    text-align: center;
    font-size: 2.5rem;
    font-weight: var(--font-weight-medium);
    color: var(--text-primary);
    margin-bottom: 3rem;
}

.process-steps {
    display: flex;
    justify-content: space-between;
    align-items: center;
    max-width: 1200px;
    margin: 0 auto;
    position: relative;
}

.process-steps::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 0;
    right: 0;
    height: 2px;
    background: linear-gradient(90deg, var(--primary-color) 0%, var(--accent-color) 100%);
    z-index: 1;
}

.process-step {
    background: white;
    border-radius: 50%;
    width: 120px;
    height: 120px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    box-shadow: var(--shadow-lg);
    position: relative;
    z-index: 2;
    transition: all 0.3s ease;
}

.process-step:hover {
    transform: translateY(-10px);
    box-shadow: var(--shadow-xl);
}

.process-step .step-number {
    font-size: 1.5rem;
    font-weight: var(--font-weight-semibold);
    color: var(--primary-color);
    margin-bottom: 0.5rem;
}

.process-step .step-title {
    font-size: 0.9rem;
    font-weight: var(--font-weight-medium);
    color: var(--text-primary);
    text-align: center;
    line-height: 1.2;
}

.process-step .step-icon {
    font-size: 2rem;
    color: var(--primary-color);
    margin-bottom: 0.5rem;
}

/* Export Statistics Section */
.export-stats-section {
    padding: 5rem 0;
    background: white;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 2rem;
    max-width: 1000px;
    margin: 0 auto;
}

.stat-card {
    text-align: center;
    padding: 2rem;
    background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);
    border-radius: 1rem;
    box-shadow: var(--shadow-md);
    transition: all 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-lg);
}

.stat-number {
    font-size: 3rem;
    font-weight: var(--font-weight-semibold);
    color: var(--primary-color);
    margin-bottom: 0.5rem;
}

.stat-label {
    font-size: 1.1rem;
    font-weight: var(--font-weight-medium);
    color: var(--text-primary);
    margin-bottom: 0.5rem;
}

.stat-description {
    font-size: 0.9rem;
    color: var(--text-secondary);
    line-height: 1.5;
}

/* Export Cases Section */
.export-cases-section {
    padding: 5rem 0;
    background: var(--background-section);
}

.export-case-card {
    background: white;
    border-radius: 1rem;
    overflow: hidden;
    box-shadow: var(--shadow-md);
    transition: all 0.3s ease;
}

.export-case-card:hover {
    transform: translateY(-8px);
    box-shadow: var(--shadow-xl);
}

.case-header {
    padding: 1.5rem;
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--accent-color) 100%);
    color: white;
}

.case-id {
    font-size: 1.1rem;
    font-weight: var(--font-weight-semibold);
    margin-bottom: 0.5rem;
}

.case-status {
    font-size: 0.9rem;
    opacity: 0.9;
}

.case-content {
    padding: 1.5rem;
}

.case-timeline {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.timeline-item {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.timeline-icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: var(--accent-color);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.2rem;
}

.timeline-content {
    flex: 1;
}

.timeline-title {
    font-weight: var(--font-weight-medium);
    color: var(--text-primary);
    margin-bottom: 0.25rem;
}

.timeline-date {
    font-size: 0.8rem;
    color: var(--text-secondary);
}

/* Responsive Design for Process Flow */
@media (max-width: 768px) {
    .process-steps {
        flex-direction: column;
        gap: 2rem;
    }
    
    .process-steps::before {
        display: none;
    }
    
    .process-step {
        width: 200px;
        height: 100px;
        border-radius: 1rem;
    }
    
    .stats-grid {
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }
    
    .stat-number {
        font-size: 2.5rem;
    }
}
```

### 14. Data Models for Export Business

```sql
-- Export Shipment Tracking
CREATE TABLE wp_ayam_shipments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tracking_code VARCHAR(50) UNIQUE,
    farm_id INT,
    customer_id INT,
    total_roosters INT,
    total_weight DECIMAL(8,2),
    status ENUM('received', 'processing', 'health_check', 'quarantine', 'documentation', 'shipped', 'delivered'),
    received_date DATETIME,
    shipped_date DATETIME,
    destination_country VARCHAR(100),
    destination_city VARCHAR(100),
    partner_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Individual Rooster Tracking
CREATE TABLE wp_ayam_rooster_tracking (
    id INT AUTO_INCREMENT PRIMARY KEY,
    shipment_id INT,
    rooster_code VARCHAR(50),
    breed VARCHAR(100),
    weight DECIMAL(5,2),
    age_months INT,
    health_status ENUM('healthy', 'quarantine', 'treatment', 'cleared'),
    photos TEXT, -- JSON array of photo URLs
    health_certificate VARCHAR(255),
    export_document VARCHAR(255),
    status ENUM('received', 'weighed', 'photographed', 'health_checked', 'quarantined', 'documented', 'shipped'),
    received_at DATETIME,
    processed_at DATETIME,
    shipped_at DATETIME,
    FOREIGN KEY (shipment_id) REFERENCES wp_ayam_shipments(id)
);

-- Farm Partners
CREATE TABLE wp_ayam_farms (
    id INT AUTO_INCREMENT PRIMARY KEY,
    farm_name VARCHAR(200),
    owner_name VARCHAR(200),
    phone VARCHAR(20),
    email VARCHAR(100),
    address TEXT,
    registration_number VARCHAR(100),
    status ENUM('active', 'inactive', 'suspended'),
    total_shipments INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Indonesia Partners
CREATE TABLE wp_ayam_indonesia_partners (
    id INT AUTO_INCREMENT PRIMARY KEY,
    partner_name VARCHAR(200),
    contact_person VARCHAR(200),
    phone VARCHAR(20),
    email VARCHAR(100),
    city VARCHAR(100),
    address TEXT,
    license_number VARCHAR(100),
    status ENUM('active', 'inactive'),
    total_handled INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Export Statistics
CREATE TABLE wp_ayam_export_stats (
    id INT AUTO_INCREMENT PRIMARY KEY,
    year INT,
    month INT,
    total_shipments INT,
    total_roosters INT,
    total_weight DECIMAL(10,2),
    success_rate DECIMAL(5,2),
    average_processing_days INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

### 15. User Roles for Export Business

```php
// Custom User Roles for Export Business
function ayam_create_export_user_roles() {
    
    // Farm Owner Role
    add_role('farm_owner', 'Farm Owner', array(
        'read' => true,
        'view_shipments' => true,
        'create_shipment_request' => true,
        'upload_rooster_info' => true,
        'track_shipments' => true
    ));
    
    // Indonesia Customer Role  
    add_role('indonesia_customer', 'Indonesia Customer', array(
        'read' => true,
        'track_shipments' => true,
        'view_delivery_status' => true,
        'contact_partner' => true
    ));
    
    // Export Staff Role
    add_role('export_staff', 'Export Staff', array(
        'read' => true,
        'edit_posts' => true,
        'manage_shipments' => true,
        'update_rooster_status' => true,
        'upload_documents' => true,
        'manage_health_records' => true
    ));
    
    // Export Manager Role
    add_role('export_manager', 'Export Manager', array(
        'read' => true,
        'edit_posts' => true,
        'manage_shipments' => true,
        'view_all_statistics' => true,
        'manage_farms' => true,
        'manage_partners' => true,
        'export_reports' => true
    ));
}
```