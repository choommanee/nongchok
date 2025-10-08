# Member Dashboard System - ระบบ Dashboard สมาชิก

## ภาพรวม

ระบบ Dashboard สำหรับสมาชิกที่แสดงสถิติการใช้งาน รายการโปรด ประวัติการสอบถาม และการจอง พร้อมฟีเจอร์จัดการข้อมูลส่วนตัว

## ไฟล์ที่สร้าง

### 1. Template File
- **wp-content/themes/ayam-bangkok/page-member-dashboard.php**
  - Dashboard template สำหรับสมาชิก
  - แสดงสถิติการใช้งาน
  - รายการไก่ชนที่ชื่นชอบ
  - ประวัติการสอบถามและการจอง
  - ข้อมูลโปรไฟล์และเมนูด่วน

### 2. CSS File
- **wp-content/themes/ayam-bangkok/assets/css/member-dashboard.css**
  - Responsive dashboard layout
  - Modern card designs
  - Stats visualization
  - Sidebar widgets
  - Mobile-optimized

### 3. JavaScript File
- **wp-content/themes/ayam-bangkok/assets/js/member-dashboard.js**
  - Favorite management (add/remove)
  - Real-time stat updates
  - Notification system
  - AJAX interactions

### 4. Backend Functions
- **wp-content/themes/ayam-bangkok/functions.php** (เพิ่มเติม)
  - Favorite management functions
  - Member pricing system
  - User statistics
  - Login redirect
  - Admin bar integration

## ฟีเจอร์หลัก

### 1. Dashboard Header
- ข้อความต้อนรับพร้อมชื่อสมาชิก
- แสดงวันที่สมัครสมาชิก
- ปุ่มออกจากระบบ

### 2. Statistics Cards (4 การ์ด)
- **การสอบถาม** - จำนวนครั้งที่สอบถามไก่ชน
- **การจอง** - จำนวนครั้งที่จองบริการ
- **รายการโปรด** - จำนวนไก่ชนที่บันทึกไว้
- **การแจ้งเตือน** - จำนวนการแจ้งเตือนใหม่

### 3. Favorite Roosters Section
- แสดงไก่ชนที่ชื่นชอบ (สูงสุด 6 รายการ)
- รูปภาพ ชื่อ และราคา
- ปุ่มลบออกจากรายการโปรด
- สถานะไก่ชน (Available/Sold)
- ลิงก์ดูรายละเอียด

### 4. Recent Inquiries
- แสดงประวัติการสอบถาม 5 รายการล่าสุด
- หัวข้อและข้อความ
- วันที่สอบถาม
- สถานะ (New/Pending/Completed)

### 5. Recent Bookings
- แสดงประวัติการจอง 5 รายการล่าสุด
- ชื่อบริการ
- วันที่และเวลาจอง
- สถานะ (Confirmed/Pending/Cancelled)

### 6. Profile Widget
- รูปโปรไฟล์ (Avatar)
- ชื่อ-นามสกุล
- อีเมล
- เบอร์โทรศัพท์
- ประเทศ
- ปุ่มแก้ไขโปรไฟล์

### 7. Member Benefits Widget
- แสดงสิทธิประโยชน์สมาชิก
- ราคาพิเศษ
- ข่าวสารก่อนใคร
- บันทึกรายการโปรด
- บริการส่งออกพิเศษ

### 8. Quick Actions Widget
- ลิงก์ด่วนไปยังหน้าต่างๆ
- ดูไก่ชนทั้งหมด
- บริการของเรา
- ข่าวสาร
- ติดต่อเรา

### 9. Notifications Widget
- แสดงการแจ้งเตือนใหม่
- (พร้อมสำหรับการพัฒนาต่อ)

## Favorite Management System

### การเพิ่มรายการโปรด
```javascript
// AJAX call to add favorite
$.ajax({
    url: ayamDashboard.ajaxurl,
    type: 'POST',
    data: {
        action: 'ayam_add_favorite',
        nonce: ayamDashboard.nonce,
        rooster_id: roosterId
    }
});
```

### การลบรายการโปรด
```javascript
// AJAX call to remove favorite
$.ajax({
    url: ayamDashboard.ajaxurl,
    type: 'POST',
    data: {
        action: 'ayam_remove_favorite',
        nonce: ayamDashboard.nonce,
        rooster_id: roosterId
    }
});
```

### PHP Functions
```php
// Check if rooster is favorite
ayam_is_favorite($rooster_id, $user_id);

// Display favorite button
ayam_favorite_button($rooster_id);

// Get user stats
ayam_get_user_stats($user_id);
```

## Member Pricing System

### การคำนวณราคาสมาชิก
- สมาชิกได้รับส่วนลด 10% จากราคาปกติ
- แสดงราคาปกติและราคาสมาชิกเปรียบเทียบ

### PHP Functions
```php
// Get member price
$member_price = ayam_get_member_price($regular_price, $user_id);

// Display member pricing
echo ayam_display_member_pricing($rooster_id);
```

### HTML Output
```html
<div class="pricing-display member-pricing">
    <span class="regular-price">10,000 บาท</span>
    <span class="member-price">9,000 บาท</span>
    <span class="member-badge">ราคาสมาชิก</span>
</div>
```

## Security Features

### 1. Login Required
- ตรวจสอบการเข้าสู่ระบบก่อนเข้าถึง dashboard
- Redirect ไปหน้า login หากยังไม่ได้เข้าสู่ระบบ

### 2. Nonce Verification
- ตรวจสอบ nonce ทุก AJAX request
- ป้องกัน CSRF attacks

### 3. User Validation
- ตรวจสอบ user ID ทุกครั้ง
- ตรวจสอบสิทธิ์การเข้าถึงข้อมูล

### 4. Data Sanitization
- Sanitize ข้อมูลทั้งหมดก่อนแสดงผล
- Escape output เพื่อป้องกัน XSS

## การติดตั้งและใช้งาน

### 1. สร้างหน้า Dashboard

```
1. ไปที่ WordPress Admin > Pages > Add New
2. ตั้งชื่อหน้า: "Member Dashboard" หรือ "แดชบอร์ดสมาชิก"
3. เลือก Template: "Member Dashboard"
4. Publish
```

### 2. ตั้งค่า Login Redirect

ระบบจะ redirect อัตโนมัติไปหน้า dashboard หลังจาก login สำเร็จ

### 3. เพิ่มลิงก์ในเมนู

```
1. ไปที่ Appearance > Menus
2. เพิ่มหน้า "Member Dashboard" เข้าไปในเมนู
3. ตั้งค่าให้แสดงเฉพาะสมาชิกที่ login แล้ว (ถ้าต้องการ)
4. Save Menu
```

### 4. ทดสอบการทำงาน

```
1. Login เข้าสู่ระบบด้วยบัญชีสมาชิก
2. เข้าหน้า Dashboard
3. ทดสอบเพิ่ม/ลบรายการโปรด
4. ตรวจสอบสถิติและประวัติ
5. ทดสอบแก้ไขโปรไฟล์
```

## การใช้งาน Favorite Button

### เพิ่มปุ่มในหน้ารายละเอียดไก่ชน

แก้ไข `single-ayam_rooster.php`:

```php
<div class="rooster-actions">
    <?php echo ayam_favorite_button(); ?>
    <button class="btn-share">
        <i class="fas fa-share-alt"></i>
        แชร์
    </button>
</div>
```

### เพิ่ม JavaScript Handler

```javascript
$('.btn-favorite').on('click', function() {
    const $btn = $(this);
    const roosterId = $btn.data('rooster-id');
    const isActive = $btn.hasClass('active');
    const action = isActive ? 'ayam_remove_favorite' : 'ayam_add_favorite';
    
    $.ajax({
        url: ayamDashboard.ajaxurl,
        type: 'POST',
        data: {
            action: action,
            nonce: ayamDashboard.nonce,
            rooster_id: roosterId
        },
        success: function(response) {
            if (response.success) {
                $btn.toggleClass('active');
                $btn.find('i').toggleClass('far fas');
            }
        }
    });
});
```

## การปรับแต่ง

### 1. เปลี่ยนจำนวนรายการที่แสดง

แก้ไขใน `page-member-dashboard.php`:

```php
// Favorites
'posts_per_page' => 6, // เปลี่ยนเป็นจำนวนที่ต้องการ

// Inquiries
LIMIT 5 // เปลี่ยนเป็นจำนวนที่ต้องการ

// Bookings
LIMIT 5 // เปลี่ยนเป็นจำนวนที่ต้องการ
```

### 2. เปลี่ยนเปอร์เซ็นต์ส่วนลดสมาชิก

แก้ไขใน `functions.php`:

```php
function ayam_get_member_price($regular_price, $user_id = null) {
    // เปลี่ยนจาก 10% เป็นเปอร์เซ็นต์ที่ต้องการ
    $discount_percentage = 15; // 15% discount
    $member_price = $regular_price * (1 - ($discount_percentage / 100));
    return $member_price;
}
```

### 3. เพิ่ม Widget ใหม่

แก้ไขใน `page-member-dashboard.php`:

```php
<div class="dashboard-widget custom-widget">
    <div class="widget-header">
        <h3>Widget Title</h3>
    </div>
    <div class="widget-content">
        <!-- Widget content here -->
    </div>
</div>
```

### 4. Custom Stat Cards

เพิ่ม stat card ใหม่:

```php
<div class="stat-card" data-aos="fade-up" data-aos-delay="500">
    <div class="stat-icon">
        <i class="fas fa-star"></i>
    </div>
    <div class="stat-content">
        <h3 class="stat-number"><?php echo $custom_stat; ?></h3>
        <p class="stat-label">Custom Stat</p>
    </div>
</div>
```

## Database Queries

### Get User Inquiries
```php
$inquiries = $wpdb->get_results($wpdb->prepare(
    "SELECT * FROM {$wpdb->prefix}ayam_inquiries 
    WHERE customer_email = %s 
    ORDER BY created_at DESC 
    LIMIT 10",
    $user_email
));
```

### Get User Bookings
```php
$bookings = $wpdb->get_results($wpdb->prepare(
    "SELECT * FROM {$wpdb->prefix}ayam_bookings 
    WHERE customer_email = %s 
    ORDER BY created_at DESC 
    LIMIT 10",
    $user_email
));
```

### Get Favorite Roosters
```php
$favorites = get_user_meta($user_id, 'favorite_roosters', true);
$favorites = $favorites ? $favorites : array();

$args = array(
    'post_type' => 'ayam_rooster',
    'post__in' => $favorites,
    'posts_per_page' => -1
);
$query = new WP_Query($args);
```

## Responsive Design

### Breakpoints
- Desktop: > 1024px - 2 columns (main + sidebar)
- Tablet: 768px - 1024px - 1 column (sidebar first)
- Mobile: < 768px - 1 column (optimized layout)

### Mobile Optimizations
- Stack stat cards vertically
- Simplify favorite grid
- Collapse sidebar widgets
- Touch-friendly buttons
- Optimized spacing

## Integration Points

### 1. Rooster Archive/Single Pages
- เพิ่มปุ่ม favorite
- แสดงราคาสมาชิก
- Link ไป dashboard

### 2. Header/Navigation
- แสดงลิงก์ dashboard เมื่อ login
- แสดงชื่อสมาชิก
- Dropdown menu

### 3. Admin Bar
- เพิ่มลิงก์ dashboard
- Quick access สำหรับสมาชิก

## Future Enhancements

### Phase 2 Features
- Notification system (real-time)
- Message center
- Order history
- Download invoices
- Member tier system

### Phase 3 Features
- Activity timeline
- Social features
- Referral tracking
- Reward points
- Advanced analytics

## Troubleshooting

### ปัญหา: Dashboard ไม่แสดงข้อมูล
**แก้ไข:**
1. ตรวจสอบว่า user login แล้ว
2. ตรวจสอบ database tables มีอยู่
3. ตรวจสอบ user meta data
4. Clear cache

### ปัญหา: Favorite ไม่ทำงาน
**แก้ไข:**
1. ตรวจสอบ JavaScript console
2. ตรวจสอบ AJAX URL
3. ตรวจสอบ nonce verification
4. ตรวจสอบ user permissions

### ปัญหา: Stats ไม่ถูกต้อง
**แก้ไข:**
1. ตรวจสอบ database queries
2. ตรวจสอบ email matching
3. ตรวจสอบ data format
4. Refresh หน้า

### ปัญหา: CSS ไม่แสดงผล
**แก้ไข:**
1. Clear browser cache
2. ตรวจสอบ file path
3. ตรวจสอบ enqueue ใน functions.php
4. Hard refresh (Ctrl+F5)

## Testing Checklist

- [ ] Dashboard แสดงผลถูกต้องทุก breakpoint
- [ ] Stats แสดงตัวเลขถูกต้อง
- [ ] Favorite add/remove ทำงานถูกต้อง
- [ ] Inquiries แสดงข้อมูลถูกต้อง
- [ ] Bookings แสดงข้อมูลถูกต้อง
- [ ] Profile widget แสดงข้อมูลถูกต้อง
- [ ] Quick actions links ทำงานถูกต้อง
- [ ] Login redirect ทำงานถูกต้อง
- [ ] Logout ทำงานถูกต้อง
- [ ] Member pricing แสดงถูกต้อง
- [ ] Responsive design ทำงานถูกต้อง
- [ ] Security (nonce, sanitization) ทำงานถูกต้อง

## Support

หากมีปัญหาหรือต้องการความช่วยเหลือ:
1. ตรวจสอบ documentation นี้
2. ตรวจสอบ WordPress error logs
3. ตรวจสอบ browser console
4. ติดต่อทีมพัฒนา

## Changelog

### Version 1.0.0 (2025-10-08)
- ✅ Dashboard template with stats
- ✅ Favorite roosters management
- ✅ Recent inquiries display
- ✅ Recent bookings display
- ✅ Profile widget
- ✅ Member benefits widget
- ✅ Quick actions menu
- ✅ Notifications widget
- ✅ Member pricing system
- ✅ Login redirect
- ✅ Admin bar integration
- ✅ Responsive design
- ✅ AJAX interactions
- ✅ Security features

---

**Task 15 - Member Dashboard System: COMPLETED ✅**
