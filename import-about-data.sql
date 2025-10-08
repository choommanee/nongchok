-- SQL queries to import complete About page data into WordPress options
-- Run these queries in your WordPress database

-- Company Data (Complete with all details from website)
INSERT INTO wp_options (option_name, option_value, autoload) 
VALUES ('ayam_company_data', 'a:6:{s:12:"company_name";s:12:"Ayam Bangkok";s:19:"company_description";s:297:"เราเป็นบริษัทชั้นนำในการส่งออกไก่ชนคุณภาพสูงจากประเทศไทยไปยังประเทศอินโดนีเซีย ด้วยประสบการณ์กว่า 10 ปีในธุรกิจนี้ เราได้สร้างความเชื่อมั่นและความไว้วางใจจากลูกค้าทั้งในประเทศและต่างประเทศ";s:18:"company_main_image";s:0:"";s:14:"company_vision";s:175:"เป็นผู้นำในการส่งออกไก่ชนคุณภาพสูงจากประเทศไทยไปยังตลาดโลก โดยยึดมั่นในคุณภาพ ความปลอดภัย และการบริการที่เป็นเลิศ";s:15:"company_mission";s:297:"ส่งมอบไก่ชนคุณภาพสูงที่ผ่านการคัดเลือกอย่างเข้มงวด พร้อมบริการครบวงจรตั้งแต่การเลือกสรร การดูแลรักษา ไปจนถึงการส่งมอบที่ปลอดภัย เพื่อสร้างความพึงพอใจสูงสุดให้กับลูกค้า";s:16:"company_subtitle";s:165:"หนองจอก เอฟซีไอ เป็นตัวแทนส่งออกไก่ชนไปยังประเทศอินโดนีเซียอย่างเป็นทางการรายเดียวของประเทศไทย";}', 'yes')
ON DUPLICATE KEY UPDATE option_value = VALUES(option_value);

-- Timeline Data
INSERT INTO wp_options (option_name, option_value, autoload) 
VALUES ('ayam_company_timeline', 'a:5:{i:0;a:4:{s:4:"year";s:4:"2014";s:5:"title";s:27:"ก่อตั้งบริษัท";s:11:"description";s:87:"เริ่มต้นธุรกิจการส่งออกไก่ชนด้วยความมุ่งมั่นในคุณภาพ";s:5:"image";s:0:"";}i:1;a:4:{s:4:"year";s:4:"2016";s:5:"title";s:21:"ขยายตลาด";s:11:"description";s:93:"เริ่มส่งออกไปยังประเทศอินโดนีเซียอย่างเป็นทางการ";s:5:"image";s:0:"";}i:2;a:4:{s:4:"year";s:4:"2018";s:5:"title";s:33:"ได้รับใบรับรอง";s:11:"description";s:99:"ได้รับใบรับรองมาตรฐานการส่งออกจากกรมปศุสัตว์";s:5:"image";s:0:"";}i:3;a:4:{s:4:"year";s:4:"2020";s:5:"title";s:30:"เทคโนโลยีใหม่";s:11:"description";s:105:"นำเทคโนโลยีสมัยใหม่มาใช้ในการดูแลและขนส่งไก่ชน";s:5:"image";s:0:"";}i:4;a:4:{s:4:"year";s:4:"2024";s:5:"title";s:27:"ผู้นำในตลาด";s:11:"description";s:105:"กิจการเติบโตเป็นผู้นำในการส่งออกไก่ชนไปอินโดนีเซีย";s:5:"image";s:0:"";}}', 'yes')
ON DUPLICATE KEY UPDATE option_value = VALUES(option_value);

-- Awards Data
INSERT INTO wp_options (option_name, option_value, autoload) 
VALUES ('ayam_company_awards', 'a:3:{i:0;a:4:{s:5:"title";s:42:"รางวัลผู้ส่งออกดีเด่น";s:4:"year";s:4:"2023";s:11:"description";s:66:"จากกรมการค้าต่างประเทศ กระทรวงพาณิชย์";s:5:"image";s:0:"";}i:1;a:4:{s:5:"title";s:42:"ใบรับรองมาตรฐาน ISO";s:4:"year";s:4:"2022";s:11:"description";s:63:"มาตรฐานการจัดการคุณภาพระดับสากล";s:5:"image";s:0:"";}i:2;a:4:{s:5:"title";s:60:"รางวัลพันธมิตรทางการค้าดีเด่น";s:4:"year";s:4:"2021";s:11:"description";s:60:"จากสถานเอกอัครราชทูตอินโดนีเซีย";s:5:"image";s:0:"";}}', 'yes')
ON DUPLICATE KEY UPDATE option_value = VALUES(option_value);

-- Team Members Data
INSERT INTO wp_options (option_name, option_value, autoload) 
VALUES ('ayam_team_members', 'a:3:{i:0;a:4:{s:4:"name";s:24:"คุณสมชาย ใจดี";s:8:"position";s:24:"ผู้อำนวยการ";s:11:"description";s:75:"ประสบการณ์กว่า 15 ปีในธุรกิจการส่งออกไก่ชน";s:5:"image";s:0:"";}i:1;a:4:{s:4:"name";s:27:"คุณสมหญิง รักษ์ดี";s:8:"position";s:33:"ผู้จัดการฝ่ายขาย";s:11:"description";s:84:"เชี่ยวชาญด้านการตลาดและการขายระหว่างประเทศ";s:5:"image";s:0:"";}i:2;a:4:{s:4:"name";s:30:"คุณสมศักดิ์ เก่งมาก";s:8:"position";s:39:"ผู้เชี่ยวชาญด้านไก่ชน";s:11:"description";s:81:"ความรู้เชิงลึกเกี่ยวกับการเลี้ยงและดูแลไก่ชน";s:5:"image";s:0:"";}}', 'yes')
ON DUPLICATE KEY UPDATE option_value = VALUES(option_value);

-- Company Values/Core Values Data (ค่านิยมองค์กร)
INSERT INTO wp_options (option_name, option_value, autoload) 
VALUES ('ayam_company_values', 'a:4:{i:0;a:3:{s:5:"title";s:21:"ความใส่ใจ";s:11:"description";s:96:"ใส่ใจในทุกรายละเอียดของการดูแลไก่ชนและบริการลูกค้า";s:4:"icon";s:0:"";}i:1;a:3:{s:5:"title";s:30:"ความน่าเชื่อถือ";s:11:"description";s:90:"สร้างความเชื่อมั่นด้วยคุณภาพและการบริการที่สม่ำเสมอ";s:4:"icon";s:0:"";}i:2;a:3:{s:5:"title";s:18:"นวัตกรรม";s:11:"description";s:75:"พัฒนาและปรับปรุงวิธีการทำงานอย่างต่อเนื่อง";s:4:"icon";s:0:"";}i:3;a:3:{s:5:"title";s:24:"ความซื่อสัตย์";s:11:"description";s:72:"ดำเนินธุรกิจด้วยความโปร่งใสและเป็นธรรม";s:4:"icon";s:0:"";}}', 'yes')
ON DUPLICATE KEY UPDATE option_value = VALUES(option_value);

-- Company Features/Highlights (จุดเด่นของบริษัท)
INSERT INTO wp_options (option_name, option_value, autoload) 
VALUES ('ayam_company_features', 'a:3:{i:0;a:3:{s:5:"title";s:36:"ประสบการณ์กว่า 10 ปี";s:11:"description";s:75:"ความเชี่ยวชาญในการส่งออกไก่ชนคุณภาพสูง";s:4:"icon";s:0:"";}i:1;a:3:{s:5:"title";s:33:"ใบรับรองมาตรฐาน";s:11:"description";s:84:"ได้รับการรับรองจากหน่วยงานราชการที่เกี่ยวข้อง";s:4:"icon";s:0:"";}i:2;a:3:{s:5:"title";s:42:"เครือข่ายระหว่างประเทศ";s:11:"description";s:75:"ความสัมพันธ์ที่แน่นแฟ้นกับพันธมิตรในอินโดนีเซีย";s:4:"icon";s:0:"";}}', 'yes')
ON DUPLICATE KEY UPDATE option_value = VALUES(option_value);

-- Verify the data was inserted correctly
SELECT option_name, LEFT(option_value, 100) as preview FROM wp_options 
WHERE option_name IN ('ayam_company_data', 'ayam_company_timeline', 'ayam_company_awards', 'ayam_team_members', 'ayam_company_values', 'ayam_company_features');
