-- Run these SQL commands on Railway MySQL database
-- to setup Gallery system without shell access

-- 1. Fix WordPress URLs
UPDATE wp_options
SET option_value = 'https://nongchok-production.up.railway.app'
WHERE option_name IN ('home', 'siteurl');

-- 2. Create Gallery Categories Table
CREATE TABLE IF NOT EXISTS wp_gallery_categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_code VARCHAR(50) NOT NULL,
    category_name VARCHAR(255) NOT NULL,
    description TEXT,
    thumbnail VARCHAR(500),
    image_count INT DEFAULT 0,
    display_order INT DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY (category_code)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3. Create Gallery Images Table
CREATE TABLE IF NOT EXISTS wp_gallery_images (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT NOT NULL,
    image_path VARCHAR(500) NOT NULL,
    image_url VARCHAR(500) NOT NULL,
    image_name VARCHAR(255),
    file_size INT,
    display_order INT DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    KEY category_id (category_id),
    FOREIGN KEY (category_id) REFERENCES wp_gallery_categories(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 4. Verify URLs are fixed
SELECT option_name, option_value
FROM wp_options
WHERE option_name IN ('home', 'siteurl');

-- Done! Now you can access:
-- https://nongchok-production.up.railway.app/wp-admin/
