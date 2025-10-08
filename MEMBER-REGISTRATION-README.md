# Member Registration System - ระบบสมัครสมาชิก

## ภาพรวม

ระบบสมัครสมาชิกแบบ Multi-step สำหรับเว็บไซต์ Ayam Bangkok พร้อมฟีเจอร์ครบครัน

## ไฟล์ที่สร้าง

### 1. Template File
- **wp-content/themes/ayam-bangkok/page-member-registration.php**
  - Template หน้าสมัครสมาชิก
  - Multi-step form (3 ขั้นตอน)
  - แสดงสิทธิประโยชน์สมาชิก
  - Success modal

### 2. CSS File
- **wp-content/themes/ayam-bangkok/assets/css/member-registration.css**
  - Responsive design
  - Modern UI/UX
  - Animations และ transitions
  - Form validation styles
  - Loading states

### 3. JavaScript File
- **wp-content/themes/ayam-bangkok/assets/js/member-registration.js**
  - Multi-step navigation
  - Real-time validation
  - AJAX form submission
  - Password strength checker
  - Error handling

### 4. Backend Functions
- **wp-content/themes/ayam-bangkok/functions.php** (เพิ่มเติม)
  - AJAX handler สำหรับการสมัครสมาชิก
  - User creation และ meta data
  - Email notifications
  - Custom user profile fields

## ฟีเจอร์หลัก

### 1. Multi-Step Form (3 ขั้นตอน)

#### Step 1: ข้อมูลส่วนตัว
- ชื่อ-นามสกุล
- ชื่อผู้ใช้ (Username)
- อีเมล
- รหัสผ่าน + ยืนยันรหัสผ่าน
- Toggle แสดง/ซ่อนรหัสผ่าน

#### Step 2: ข้อมูลติดต่อ
- เบอร์โทรศัพท์
- LINE ID (ไม่บังคับ)
- ประเทศ
- ประเภทธุรกิจ
- ที่อยู่
- ความสนใจ (Multiple checkboxes)

#### Step 3: ยืนยันข้อมูล
- แสดงสรุปข้อมูลทั้งหมด
- ยอมรับข้อกำหนดและเงื่อนไข
- รับข่าวสารทางอีเมล (Optional)

### 2. Form Validation

#### Client-side Validation
- Real-time validation ขณะพิมพ์
- Username: ภาษาอังกฤษและตัวเลขเท่านั้น, อย่างน้อย 4 ตัวอักษร
- Email: รูปแบบอีเมลที่ถูกต้อง
- Password: อย่างน้อย 8 ตัวอักษร, มีตัวพิมพ์ใหญ่ พิมพ์เล็ก และตัวเลข
- Confirm Password: ตรงกับรหัสผ่าน
- Phone: รูปแบบเบอร์โทรศัพท์ที่ถูกต้อง, อย่างน้อย 9 หลัก

#### Server-side Validation
- ตรวจสอบ nonce security
- ตรวจสอบข้อมูลที่จำเป็น
- ตรวจสอบ username ซ้ำ
- ตรวจสอบ email ซ้ำ
- ตรวจสอบความแข็งแรงของรหัสผ่าน

### 3. User Experience

#### Progress Indicator
- แสดงขั้นตอนปัจจุบัน
- Visual feedback สำหรับขั้นตอนที่เสร็จแล้ว
- Smooth transitions ระหว่างขั้นตอน

#### Error Handling
- แสดง error message ที่ชัดเจน
- Highlight ช่องที่มีข้อผิดพลาด
- Clear error เมื่อแก้ไข

#### Loading States
- แสดง loading animation ขณะส่งข้อมูล
- Disable ปุ่มเพื่อป้องกันการ submit ซ้ำ

#### Success Modal
- แสดง modal เมื่อสมัครสำเร็จ
- ปุ่มเข้าสู่ระบบ
- ปุ่มกลับหน้าแรก

### 4. สิทธิประโยชน์สมาชิก

แสดงก่อนฟอร์มสมัคร:
- ราคาพิเศษสำหรับสมาชิก
- รับข้อมูลข่าวสารก่อนใคร
- บันทึกรายการโปรด
- บริการส่งออกพิเศษ

### 5. Database Integration

#### WordPress Users Table
- สร้าง user account ใหม่
- บันทึก first_name, last_name, display_name
- กำหนด role เป็น 'subscriber'

#### User Meta
- phone
- line_id
- country
- business_type
- address
- interests (array)
- agree_newsletter (boolean)
- registration_date

#### Custom Table (wp_ayam_customer_profiles)
- เก็บข้อมูลลูกค้าเพิ่มเติม
- Link กับ user_id
- เก็บ preferences เป็น JSON

### 6. Email Notifications

#### Welcome Email (ส่งให้สมาชิกใหม่)
- ข้อความต้อนรับ
- ข้อมูลการเข้าสู่ระบบ
- สิทธิประโยชน์สมาชิก
- ลิงก์เข้าสู่ระบบ

#### Admin Notification (ส่งให้ผู้ดูแลระบบ)
- แจ้งเตือนสมาชิกใหม่
- ข้อมูลสมาชิกทั้งหมด
- เวลาที่สมัคร

## การติดตั้งและใช้งาน

### 1. สร้างหน้าสมัครสมาชิก

```
1. ไปที่ WordPress Admin > Pages > Add New
2. ตั้งชื่อหน้า: "สมัครสมาชิก" หรือ "Member Registration"
3. เลือก Template: "Member Registration"
4. Publish
```

### 2. เพิ่มลิงก์ในเมนู

```
1. ไปที่ Appearance > Menus
2. เพิ่มหน้า "สมัครสมาชิก" เข้าไปในเมนู
3. Save Menu
```

### 3. ตรวจสอบการทำงาน

```
1. เปิดหน้าสมัครสมาชิก
2. กรอกข้อมูลในแต่ละขั้นตอน
3. ตรวจสอบ validation
4. Submit form
5. ตรวจสอบ email ที่ได้รับ
6. ลองเข้าสู่ระบบด้วย username และ password ที่สร้าง
```

## การปรับแต่ง

### 1. เปลี่ยนสี Theme

แก้ไขใน `member-registration.css`:

```css
/* Primary Color */
background: linear-gradient(135deg, #CA4249 0%, #e85d64 100%);

/* Secondary Color */
background: linear-gradient(135deg, #1E2950 0%, #2a3a6b 100%);
```

### 2. เพิ่ม/ลดฟิลด์

แก้ไขใน `page-member-registration.php`:
- เพิ่มฟิลด์ใน HTML form
- อัพเดท validation ใน `member-registration.js`
- อัพเดท AJAX handler ใน `functions.php`

### 3. เปลี่ยนข้อความ

ใช้ WordPress translation functions:
```php
__('ข้อความ', 'ayam-bangkok')
```

### 4. Custom Email Template

แก้ไขใน `functions.php` > `ayam_register_member()`:
```php
$email_message = sprintf(
    "Your custom email template here...",
    $variables
);
```

## Security Features

### 1. Nonce Verification
- ตรวจสอบ nonce ทุกครั้งที่ submit form
- ป้องกัน CSRF attacks

### 2. Data Sanitization
- Sanitize ข้อมูลทั้งหมดก่อนบันทึก
- ใช้ WordPress sanitization functions

### 3. Validation
- Client-side และ server-side validation
- ตรวจสอบข้อมูลซ้ำ (username, email)

### 4. Password Security
- ตรวจสอบความแข็งแรงของรหัสผ่าน
- WordPress จัดการ password hashing อัตโนมัติ

## Responsive Design

### Breakpoints
- Desktop: > 768px
- Tablet: 768px - 480px
- Mobile: < 480px

### Mobile Optimizations
- Stack form fields vertically
- Larger touch targets
- Simplified step indicator
- Full-width buttons

## Browser Support

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Mobile browsers (iOS Safari, Chrome Mobile)

## Testing Checklist

- [ ] Form แสดงผลถูกต้องทุก breakpoint
- [ ] Validation ทำงานถูกต้องทุกฟิลด์
- [ ] Multi-step navigation ทำงานถูกต้อง
- [ ] AJAX submission ทำงานถูกต้อง
- [ ] Email ส่งถูกต้องทั้ง user และ admin
- [ ] User account สร้างสำเร็จ
- [ ] User meta บันทึกถูกต้อง
- [ ] Database record สร้างถูกต้อง
- [ ] Success modal แสดงผลถูกต้อง
- [ ] Error handling ทำงานถูกต้อง
- [ ] Security (nonce, sanitization) ทำงานถูกต้อง

## Troubleshooting

### ปัญหา: Form ไม่ส่งข้อมูล
**แก้ไข:**
1. ตรวจสอบ JavaScript console สำหรับ errors
2. ตรวจสอบ AJAX URL ถูกต้อง
3. ตรวจสอบ nonce verification

### ปัญหา: Email ไม่ส่ง
**แก้ไข:**
1. ตรวจสอบ WordPress email settings
2. ติดตั้ง SMTP plugin (เช่น WP Mail SMTP)
3. ตรวจสอบ spam folder

### ปัญหา: Validation ไม่ทำงาน
**แก้ไข:**
1. ตรวจสอบ JavaScript loaded ถูกต้อง
2. ตรวจสอบ jQuery dependency
3. ตรวจสอบ console สำหรับ errors

### ปัญหา: CSS ไม่แสดงผล
**แก้ไข:**
1. Clear browser cache
2. ตรวจสอบ file path ถูกต้อง
3. ตรวจสอบ enqueue ใน functions.php

## Future Enhancements

### Phase 2 Features
- Email verification system
- Social login (Facebook, Google)
- Two-factor authentication
- Member dashboard
- Profile picture upload
- Password reset functionality

### Phase 3 Features
- Member tiers (Bronze, Silver, Gold)
- Points/rewards system
- Referral program
- Member-only content
- Advanced analytics

## Support

หากมีปัญหาหรือต้องการความช่วยเหลือ:
1. ตรวจสอบ documentation นี้
2. ตรวจสอบ WordPress error logs
3. ตรวจสอบ browser console
4. ติดต่อทีมพัฒนา

## Changelog

### Version 1.0.0 (2025-10-08)
- ✅ Multi-step registration form
- ✅ Real-time validation
- ✅ AJAX submission
- ✅ Email notifications
- ✅ Database integration
- ✅ Responsive design
- ✅ Security features
- ✅ Success modal
- ✅ Custom user profile fields

---

**Task 14 - Member Registration System: COMPLETED ✅**
