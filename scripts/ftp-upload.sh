#!/bin/bash

# FTP Configuration
FTP_HOST="nongchokayambangkok.com"
FTP_PORT="2121"
FTP_USER="nongcho1"
FTP_PASS="M3Ix6A+4mGr:c2"
REMOTE_PATH="/domains/nongchokayambangkok.com/public_html/wp-content/themes/ayam-bangkok"
LOCAL_PATH="/Users/sakdachoommanee/Documents/httpdocs/nongchok/wp-content/themes/ayam-bangkok"

echo "Starting FTP upload..."

# Upload modified files using lftp
lftp -u "$FTP_USER,$FTP_PASS" -p $FTP_PORT $FTP_HOST << EOF
set ftp:ssl-allow no
set net:timeout 10
set net:max-retries 2

# Upload CSS files
cd $REMOTE_PATH/assets/css
lcd $LOCAL_PATH/assets/css
put wix-all-pages.css
put wix-homepage-complete.css
put wix-about-page.css
put wix-service-page.css

# Upload PHP files
cd $REMOTE_PATH
lcd $LOCAL_PATH
put header.php
put functions.php
put page-news-wix.php
put page-service.php
put page-ayam-list.php
put page-gallery-wix.php
put page-contact-wix.php
put front-page.php
put style.css

bye
EOF

echo "FTP upload completed!"
