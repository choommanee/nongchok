#!/bin/bash

# Script to add sample categories to production database
# Run this on production server via Railway SSH

echo "Adding sample categories to wp_gallery_categories..."

# Add sample Ayam List categories (Shipment 6-8)
wp db query "
INSERT INTO wp_gallery_categories (category_number, category_name, category_type, shipment_date, image_count, created_at) VALUES
('S6-001', 'Rooster Sample 1 - Shipment 6', 'ayam_list', 'Shipment 6', 0, NOW()),
('S6-002', 'Rooster Sample 2 - Shipment 6', 'ayam_list', 'Shipment 6', 0, NOW()),
('S7-001', 'Rooster Sample 1 - Shipment 7', 'ayam_list', 'Shipment 7', 0, NOW()),
('S7-002', 'Rooster Sample 2 - Shipment 7', 'ayam_list', 'Shipment 7', 0, NOW()),
('S8-001', 'Rooster Sample 1 - Shipment 8', 'ayam_list', 'Shipment 8', 0, NOW()),
('S8-002', 'Rooster Sample 2 - Shipment 8', 'ayam_list', 'Shipment 8', 0, NOW())
ON DUPLICATE KEY UPDATE category_name = VALUES(category_name);
"

echo "✓ Added Ayam List categories (Shipment 6-8)"

# Add sample Gallery categories
wp db query "
INSERT INTO wp_gallery_categories (category_number, category_name, category_type, image_count, created_at) VALUES
('G001', 'Farm Gallery Collection 1', 'gallery', 0, NOW()),
('G002', 'Farm Gallery Collection 2', 'gallery', 0, NOW()),
('G003', 'Farm Gallery Collection 3', 'gallery', 0, NOW())
ON DUPLICATE KEY UPDATE category_name = VALUES(category_name);
"

echo "✓ Added Gallery categories"

# Add Behind the Scene categories
wp db query "
INSERT INTO wp_gallery_categories (category_number, category_name, category_type, image_count, created_at) VALUES
('BTS-001', 'Behind the Scene - Training', 'behind_scene', 0, NOW()),
('BTS-002', 'Behind the Scene - Daily Care', 'behind_scene', 0, NOW())
ON DUPLICATE KEY UPDATE category_type = 'behind_scene', category_name = VALUES(category_name);
"

echo "✓ Added Behind the Scene categories"

# Show results
echo ""
echo "=== Current Categories ==="
wp db query "
SELECT
    category_number,
    category_name,
    category_type,
    shipment_date,
    image_count
FROM wp_gallery_categories
ORDER BY
    FIELD(category_type, 'gallery', 'ayam_list', 'behind_scene'),
    category_number
"

echo ""
echo "=== Summary by Type ==="
wp db query "
SELECT
    category_type,
    COUNT(*) as count
FROM wp_gallery_categories
GROUP BY category_type
ORDER BY FIELD(category_type, 'gallery', 'ayam_list', 'behind_scene')
"
