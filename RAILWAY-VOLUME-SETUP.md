# Railway Volume Setup for Gallery Images

## ปัญหา
Railway ใช้ ephemeral filesystem - ทุกครั้งที่ deploy ไฟล์ใน wp-content/uploads/ จะหาย

## วิธีแก้
ใช้ Railway Volume (persistent storage)

## ขั้นตอน

1. ไปที่ Railway Dashboard: https://railway.app/dashboard
2. เลือก project: nongchok
3. เลือก service: wordpress
4. ไปที่แท็บ "Variables"
5. คลิก "+ New Volume"
6. กรอก:
   - Mount Path: `/app/wp-content/uploads`
   - Size: 5GB (หรือมากกว่า สำหรับ 287 รูป)
7. คลิก "Add"
8. Redeploy service

## หลังจาก setup volume แล้ว

รันคำสั่ง:
```bash
php upload-images-via-http.php
```

รูปจะถูกเก็บถาวรใน Volume และไม่หายแม้ deploy ใหม่
