# Contact System - ระบบติดต่อเรา

## ภาพรวม

ระบบติดต่อที่สมบูรณ์พร้อมฟอร์มติดต่อ แผนที่ Google Maps FAQ และข้อมูลบริษัทครบถ้วน

## ไฟล์ที่สร้าง

### 1. Template File
- **wp-content/themes/ayam-bangkok/page-contact.php**
  - หน้าติดต่อเราแบบครบวงจร
  - Contact info cards (4 การ์ด)
  - Contact form พร้อม validation
  - Google Maps integration
  - FAQ accordion
  - CTA section

### 2. CSS File
- **wp-content/themes/ayam-bangkok/assets/css/contact.css**
  - Modern contact page design
  - Responsive grid layouts
  - Form styling
  - FAQ accordion styles
  - Map integration
  - Mobile-optimized

### 3. JavaScript File
- **wp-content/themes/ayam-bangkok/assets/js/contact.js**
  - Form validation
  - AJAX submission
  - FAQ accordion
  - Conditional fields
  - Error handling

### 4. Backend Functions
- **wp-content/themes/ayam-bangkok/functions.php** (เพิ่มเติม)
  - Contact form AJAX handler
  - Email notifications
  - Database integration
  - ACF fields for contact info

## ฟีเจอร์หลัก

### 1. Contact Info Cards (4 การ์ด)

#### ที่อยู่
- แสดงที่อยู่บริษัท
- ลิงก์ไป Google Maps
- Icon และ hover effects

#### โทรศัพท์
- เบอร์โทรศัพท์ (clickable)
- LINE ID
- Direct call link

#### อีเมล
- อีเมลติดต่อ (clickable)
- Social media links (Facebook, YouTube)
- Mailto link

#### เวลาทำการ
- แสดงเวลาทำการแต่ละวัน
- รองรับหลายช่วงเวลา
- Customizable ผ่าน ACF

### 2. Contact Form

#### Form Fields
- **ชื่อ-นามสกุล** (required)
- **อีเมล** (required, validated)
- **เบอร์โทรศัพท์** (optional, validated)
- **หัวข้อ** (required, dropdown)
  - สอบถามทั่วไป
  - สอบถามเกี่ยวกับไก่ชน
  - สอบถามบริการ
  - สอบถามการส่งออก
  - นัดหมายเยี่ยมชม
  - อื่นๆ
- **ข้อความ** (required, textarea)

#### Conditional Fields (เมื่อเลือก "นัดหมายเยี่ยมชม")
- **วันที่ต้องการเยี่ยมชม** (date picker)
- **เวลาที่ต้องการ** (dropdown)

#### Form Features
- Real-time validation
- AJAX submission (no page reload)
- Loading states
- Success/Error messages
- Auto-reset after success
- Spam protection (nonce)

### 3. Google Maps Integration

#### Map Display
- Embedded Google Maps
- Responsive iframe
- Custom styling
- Fallback placeholder

#### Map Info Card
- Company name
- Address
- "Open in Google Maps" button
- Directions link

### 4. FAQ Section

#### FAQ Accordion
- 6 คำถามที่พบบ่อย (customizable)
- Smooth accordion animation
- One-at-a-time opening
- Icon rotation
- Hover effects

#### Default FAQs
1. ไก่ชนของท่านมีการรับประกันหรือไม่?
2. มีบริการจัดส่งไก่ชนหรือไม่?
3. สามารถเยี่ยมชมฟาร์มได้หรือไม่?
4. มีบริการฝึกไก่ชนหรือไม่?
5. ราคาไก่ชนเริ่มต้นที่เท่าไหร่?
6. มีบริการหลังการขายหรือไม่?

### 5. CTA Section

#### Call-to-Action
- Prominent heading
- Description text
- Action buttons:
  - โทรหาเรา (phone link)
  - แชทผ่าน LINE (LINE link)

## Form Validation

### Client-side Validation

#### Name
- Required field
- Minimum length check

#### Email
- Required field
- Format validation (regex)
- Real-time feedback

#### Phone
- Optional field
- Format validation (digits, spaces, dashes)
- Minimum 9 digits

#### Subject
- Required field
- Dropdown selection

#### Message
- Required field
- Minimum length check

### Server-side Validation
- Nonce verification
- Required fields check
- Email format validation
- Data sanitization
- SQL injection prevention

## Email Notifications

### Admin Notification
```
Subject: [Site Name] ข้อความใหม่: [Subject]

Content:
- หัวข้อ
- ชื่อผู้ส่ง
- อีเมล
- เบอร์โทร
- ข้อความ
- วันที่/เวลาเยี่ยมชม (ถ้ามี)
- เวลาที่ส่ง
```

### Customer Confirmation
```
Subject: [Site Name] ขอบคุณที่ติดต่อเรา

Content:
- ข้อความต้อนรับ
- สรุปข้อความที่ส่ง
- ข้อมูลติดต่อบริษัท
- ข้อความปิดท้าย
```

## Database Integration

### Table: wp_ayam_inquiries

#### Saved Data
- inquiry_type: 'contact_form'
- customer_name
- customer_email
- customer_phone
- subject
- message
- additional_info (JSON for visit date/time)
- status: 'new'
- created_at

## ACF Fields Configuration

### Options Page: ayam-company-settings

#### Contact Information Group
```php
- company_address (textarea)
- google_maps_url (url)
- google_maps_embed (textarea)
- business_hours (repeater)
  - day (text)
  - hours (text)
```

### Theme Customizer
```php
- ayam_phone
- ayam_email
- ayam_line_id
- ayam_facebook
- ayam_youtube
```

## การติดตั้งและใช้งาน

### 1. สร้างหน้าติดต่อ

```
1. ไปที่ WordPress Admin > Pages > Add New
2. ตั้งชื่อหน้า: "ติดต่อเรา" หรือ "Contact Us"
3. เลือก Template: "Contact Us"
4. Publish
```

### 2. ตั้งค่าข้อมูลบริษัท

```
1. ไปที่ Appearance > Customize
2. กรอกข้อมูล:
   - เบอร์โทรศัพท์
   - อีเมล
   - LINE ID
   - Facebook URL
   - YouTube URL
3. Save Changes
```

### 3. ตั้งค่า ACF Fields

```
1. ไปที่ Ayam Bangkok > Company Settings
2. กรอกข้อมูล:
   - ที่อยู่บริษัท
   - Google Maps URL
   - Google Maps Embed Code
   - เวลาทำการ
3. Update
```

### 4. ตั้งค่า Google Maps

#### วิธีการได้ Embed Code:
```
1. ไปที่ Google Maps (maps.google.com)
2. ค้นหาที่อยู่บริษัท
3. คลิก "Share" > "Embed a map"
4. คัดลอก iframe code
5. วางใน ACF field "Google Maps Embed Code"
```

#### วิธีการได้ Maps URL:
```
1. ไปที่ Google Maps
2. ค้นหาที่อยู่บริษัท
3. คลิก "Share" > "Copy link"
4. วางใน ACF field "Google Maps URL"
```

### 5. ทดสอบการทำงาน

```
1. เปิดหน้าติดต่อ
2. กรอกฟอร์มทดสอบ
3. ตรวจสอบ validation
4. Submit form
5. ตรวจสอบ email ที่ได้รับ
6. ตรวจสอบ database record
7. ทดสอบ FAQ accordion
8. ทดสอบ Google Maps
```

## การปรับแต่ง

### 1. เพิ่ม/แก้ไข FAQ

แก้ไขใน `page-contact.php`:

```php
$faqs = array(
    array(
        'question' => 'คำถามของคุณ?',
        'answer' => 'คำตอบของคุณ'
    ),
    // เพิ่มเติม...
);
```

### 2. เปลี่ยนหัวข้อฟอร์ม

แก้ไขใน `page-contact.php`:

```php
<option value="custom"><?php _e('หัวข้อใหม่', 'ayam-bangkok'); ?></option>
```

และอัพเดทใน `functions.php`:

```php
$subject_map = array(
    'custom' => 'หัวข้อใหม่',
    // ...
);
```

### 3. เปลี่ยนเวลาเยี่ยมชม

แก้ไขใน `page-contact.php`:

```php
<option value="17:00">17:00</option>
<option value="18:00">18:00</option>
```

### 4. Custom Email Template

แก้ไขใน `functions.php` > `ayam_contact_form()`:

```php
$email_message = sprintf(
    "Your custom email template...",
    $variables
);
```

### 5. เพิ่ม Form Fields

1. เพิ่ม HTML field ใน `page-contact.php`
2. เพิ่ม validation ใน `contact.js`
3. เพิ่ม processing ใน `functions.php`
4. อัพเดท database schema (ถ้าจำเป็น)

## Spam Protection

### Current Protection
- WordPress nonce verification
- AJAX-only submission
- Server-side validation
- Rate limiting (ผ่าน WordPress)

### Additional Protection (Optional)
- Google reCAPTCHA
- Honeypot field
- Time-based validation
- IP blocking

### เพิ่ม reCAPTCHA:

```php
// 1. Register at Google reCAPTCHA
// 2. Add site key and secret key
// 3. Add reCAPTCHA script to form
// 4. Verify in AJAX handler
```

## Responsive Design

### Breakpoints
- Desktop: > 1024px - 2 columns (form + map)
- Tablet: 768px - 1024px - 1 column
- Mobile: < 768px - optimized layout

### Mobile Optimizations
- Stack info cards vertically
- Full-width form
- Touch-friendly inputs
- Larger buttons
- Simplified map
- Accordion FAQ

## Integration Points

### 1. Header/Navigation
- Add contact link to menu
- Sticky contact button (optional)

### 2. Footer
- Display contact info
- Quick contact form (optional)

### 3. Other Pages
- Contact CTA sections
- Quick inquiry forms
- Phone/email links

## Troubleshooting

### ปัญหา: Form ไม่ส่งข้อมูล
**แก้ไข:**
1. ตรวจสอบ JavaScript console
2. ตรวจสอบ AJAX URL
3. ตรวจสอบ nonce verification
4. ตรวจสอบ PHP errors

### ปัญหา: Email ไม่ส่ง
**แก้ไข:**
1. ตรวจสอบ WordPress email settings
2. ติดตั้ง SMTP plugin
3. ตรวจสอบ spam folder
4. ตรวจสอบ server email configuration

### ปัญหา: Google Maps ไม่แสดง
**แก้ไข:**
1. ตรวจสอบ embed code ถูกต้อง
2. ตรวจสอบ iframe allowed
3. ตรวจสอบ Google Maps API key (ถ้าใช้)
4. ตรวจสอบ browser console

### ปัญหา: Validation ไม่ทำงาน
**แก้ไข:**
1. ตรวจสอบ JavaScript loaded
2. ตรวจสอบ jQuery dependency
3. ตรวจสอบ console errors
4. Clear cache

### ปัญหา: FAQ ไม่เปิด/ปิด
**แก้ไข:**
1. ตรวจสอบ JavaScript loaded
2. ตรวจสอบ CSS transitions
3. ตรวจสอบ console errors
4. ตรวจสอบ jQuery version

## Testing Checklist

- [ ] หน้าติดต่อแสดงผลถูกต้องทุก breakpoint
- [ ] Info cards แสดงข้อมูลครบถ้วน
- [ ] Form validation ทำงานถูกต้อง
- [ ] AJAX submission ทำงานถูกต้อง
- [ ] Email ส่งถูกต้องทั้ง admin และ customer
- [ ] Database record บันทึกถูกต้อง
- [ ] Google Maps แสดงผลถูกต้อง
- [ ] FAQ accordion ทำงานถูกต้อง
- [ ] CTA buttons ทำงานถูกต้อง
- [ ] Phone/email links ทำงานถูกต้อง
- [ ] LINE link ทำงานถูกต้อง
- [ ] Responsive design ทำงานถูกต้อง
- [ ] Security (nonce, sanitization) ทำงานถูกต้อง

## Future Enhancements

### Phase 2 Features
- Live chat integration
- Chatbot support
- File upload (for inquiries)
- Multi-step form
- Appointment booking system

### Phase 3 Features
- CRM integration
- Auto-response system
- Ticket tracking
- Customer portal
- Analytics dashboard

## Support

หากมีปัญหาหรือต้องการความช่วยเหลือ:
1. ตรวจสอบ documentation นี้
2. ตรวจสอบ WordPress error logs
3. ตรวจสอบ browser console
4. ติดต่อทีมพัฒนา

## Changelog

### Version 1.0.0 (2025-10-08)
- ✅ Contact page template
- ✅ Contact info cards (4 cards)
- ✅ Contact form with validation
- ✅ AJAX submission
- ✅ Email notifications
- ✅ Database integration
- ✅ Google Maps integration
- ✅ FAQ accordion
- ✅ CTA section
- ✅ Responsive design
- ✅ Security features
- ✅ ACF fields integration

---

**Task 18 - Contact System: COMPLETED ✅**
