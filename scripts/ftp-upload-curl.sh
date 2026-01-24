#!/bin/bash

# FTP Configuration
FTP_HOST="nongchokayambangkok.com"
FTP_PORT="2121"
FTP_USER="nongcho1"
FTP_PASS="M3Ix6A+4mGr:c2"
REMOTE_BASE="/domains/nongchokayambangkok.com/public_html/wp-content/themes/ayam-bangkok"
LOCAL_BASE="/Users/sakdachoommanee/Documents/httpdocs/nongchok/wp-content/themes/ayam-bangkok"

echo "Starting FTP upload using curl..."

# Function to upload file
upload_file() {
    local local_file="$1"
    local remote_path="$2"
    
    echo "Uploading: $local_file -> $remote_path"
    curl -T "$local_file" \
         --ftp-create-dirs \
         --user "$FTP_USER:$FTP_PASS" \
         "ftp://$FTP_HOST:$FTP_PORT$remote_path" \
         2>&1
    
    if [ $? -eq 0 ]; then
        echo "✓ Success: $local_file"
    else
        echo "✗ Failed: $local_file"
    fi
}

# Upload CSS files
echo ""
echo "=== Uploading CSS files ==="
upload_file "$LOCAL_BASE/assets/css/wix-all-pages.css" "$REMOTE_BASE/assets/css/wix-all-pages.css"
upload_file "$LOCAL_BASE/assets/css/wix-homepage-complete.css" "$REMOTE_BASE/assets/css/wix-homepage-complete.css"
upload_file "$LOCAL_BASE/assets/css/wix-about-page.css" "$REMOTE_BASE/assets/css/wix-about-page.css"
upload_file "$LOCAL_BASE/assets/css/wix-service-page.css" "$REMOTE_BASE/assets/css/wix-service-page.css"

# Upload PHP files
echo ""
echo "=== Uploading PHP files ==="
upload_file "$LOCAL_BASE/header.php" "$REMOTE_BASE/header.php"
upload_file "$LOCAL_BASE/functions.php" "$REMOTE_BASE/functions.php"
upload_file "$LOCAL_BASE/page-news-wix.php" "$REMOTE_BASE/page-news-wix.php"
upload_file "$LOCAL_BASE/page-service.php" "$REMOTE_BASE/page-service.php"
upload_file "$LOCAL_BASE/page-ayam-list.php" "$REMOTE_BASE/page-ayam-list.php"
upload_file "$LOCAL_BASE/page-gallery-wix.php" "$REMOTE_BASE/page-gallery-wix.php"
upload_file "$LOCAL_BASE/page-contact-wix.php" "$REMOTE_BASE/page-contact-wix.php"
upload_file "$LOCAL_BASE/front-page.php" "$REMOTE_BASE/front-page.php"
upload_file "$LOCAL_BASE/style.css" "$REMOTE_BASE/style.css"

echo ""
echo "=== FTP upload completed! ==="
