<?php
/**
 * Update gallery database to use Google Drive links
 * 
 * Google Drive direct image link format:
 * https://drive.google.com/uc?export=view&id=FILE_ID
 */

$db_host = 'nozomi.proxy.rlwy.net';
$db_port = '42710';
$db_name = 'railway';
$db_user = 'root';
$db_pass = 'jNgCrBkMdKXzXMKukfrZNDcZsjjJPXiw';

// Google Drive folder mapping (you'll need to fill these in)
// Format: 'category_number' => 'folder_id'
$gdrive_folders = [
    '001' => 'YOUR_FOLDER_ID_HERE',
    '002' => 'YOUR_FOLDER_ID_HERE',
    // ... etc
];

echo "📊 Google Drive Gallery Setup\n\n";
echo "คุณมี Google Drive folder อยู่แล้วใช่ไหม?\n";
echo "ถ้ามี ให้:\n";
echo "1. Share folder แต่ละ category เป็น 'Anyone with the link can view'\n";
echo "2. คัดลอก folder ID จาก URL (ส่วนหลัง /folders/)\n";
echo "3. เพิ่มใน \$gdrive_folders array\n\n";

echo "หรือต้องการให้สร้าง script อัพโหลดไป Google Drive ใหม่?\n";
