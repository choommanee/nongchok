#!/bin/bash

echo "🔄 Downloading ALL missing gallery images from production..."
echo ""

cd "$(dirname "$0")/.."

# Gallery 1
echo "📥 Downloading gallery 1 images..."
curl -o "wp-content/uploads/gallery/gallery 1/1768286540_2_IMG_4185.jpg" "https://nongchokayambangkok.com/wp-content/uploads/gallery/gallery%201/1768286540_2_IMG_4185.jpg"
curl -o "wp-content/uploads/gallery/gallery 1/1768286540_3_IMG_4206.jpg" "https://nongchokayambangkok.com/wp-content/uploads/gallery/gallery%201/1768286540_3_IMG_4206.jpg"

# Gallery 2
echo "📥 Downloading gallery 2 images..."
curl -o "wp-content/uploads/gallery/gallery 2/1768286665_1_IMG_4216.jpg" "https://nongchokayambangkok.com/wp-content/uploads/gallery/gallery%202/1768286665_1_IMG_4216.jpg"

# Gallery 3
echo "📥 Downloading gallery 3 images..."
curl -o "wp-content/uploads/gallery/gallery 3/1769225236_1_IMG_4033.jpg" "https://nongchokayambangkok.com/wp-content/uploads/gallery/gallery%203/1769225236_1_IMG_4033.jpg"
curl -o "wp-content/uploads/gallery/gallery 3/1769225236_2_IMG_3881.jpg" "https://nongchokayambangkok.com/wp-content/uploads/gallery/gallery%203/1769225236_2_IMG_3881.jpg"
curl -o "wp-content/uploads/gallery/gallery 3/1769225236_3_IMG_3831.jpg" "https://nongchokayambangkok.com/wp-content/uploads/gallery/gallery%203/1769225236_3_IMG_3831.jpg"
curl -o "wp-content/uploads/gallery/gallery 3/1769225236_4_IMG_3799.jpg" "https://nongchokayambangkok.com/wp-content/uploads/gallery/gallery%203/1769225236_4_IMG_3799.jpg"
curl -o "wp-content/uploads/gallery/gallery 3/1769225236_5_IMG_3792.jpg" "https://nongchokayambangkok.com/wp-content/uploads/gallery/gallery%203/1769225236_5_IMG_3792.jpg"

# Gallery 4
echo "📥 Downloading gallery 4 images..."
curl -o "wp-content/uploads/gallery/gallery 4/1769225596_1_IMG_2505.jpg" "https://nongchokayambangkok.com/wp-content/uploads/gallery/gallery%204/1769225596_1_IMG_2505.jpg"
curl -o "wp-content/uploads/gallery/gallery 4/1769225596_2_IMG_3058.jpg" "https://nongchokayambangkok.com/wp-content/uploads/gallery/gallery%204/1769225596_2_IMG_3058.jpg"
curl -o "wp-content/uploads/gallery/gallery 4/1769225596_3_IMG_3041.jpg" "https://nongchokayambangkok.com/wp-content/uploads/gallery/gallery%204/1769225596_3_IMG_3041.jpg"
curl -o "wp-content/uploads/gallery/gallery 4/1769225596_4_IMG_2997.jpg" "https://nongchokayambangkok.com/wp-content/uploads/gallery/gallery%204/1769225596_4_IMG_2997.jpg"
curl -o "wp-content/uploads/gallery/gallery 4/1769225596_5_IMG_2966.jpg" "https://nongchokayambangkok.com/wp-content/uploads/gallery/gallery%204/1769225596_5_IMG_2966.jpg"
curl -o "wp-content/uploads/gallery/gallery 4/1769225596_6_IMG_2962.jpg" "https://nongchokayambangkok.com/wp-content/uploads/gallery/gallery%204/1769225596_6_IMG_2962.jpg"

echo ""
echo "✅ All missing images downloaded!"
echo ""
echo "📊 Summary:"
find "wp-content/uploads/gallery/gallery 1" -type f | wc -l | xargs echo "  Gallery 1:"
find "wp-content/uploads/gallery/gallery 2" -type f | wc -l | xargs echo "  Gallery 2:"
find "wp-content/uploads/gallery/gallery 3" -type f | wc -l | xargs echo "  Gallery 3:"
find "wp-content/uploads/gallery/gallery 4" -type f | wc -l | xargs echo "  Gallery 4:"
