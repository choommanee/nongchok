#!/bin/bash

# Script to upload modified files to production server
# Uses VS Code SFTP extension

PROJECT_DIR="/Users/sakdachoommanee/Documents/httpdocs/nongchok"
UPLOAD_LIST="$PROJECT_DIR/scripts/files-to-upload.txt"

echo "=== Generating list of modified files ==="

cd "$PROJECT_DIR"

# Get list of modified files from git
git status --short | grep "^ M" | awk '{print $2}' > "$UPLOAD_LIST"

echo ""
echo "=== Files to upload ==="
cat "$UPLOAD_LIST"

echo ""
echo "Total files: $(wc -l < "$UPLOAD_LIST")"

echo ""
echo "=== Upload Instructions ==="
echo "1. Open VS Code"
echo "2. Press Cmd+Shift+P"
echo "3. Type 'SFTP: Upload File' for each file below:"
echo ""

# Display files with full path
while IFS= read -r file; do
    echo "   📁 $file"
done < "$UPLOAD_LIST"

echo ""
echo "Or use 'SFTP: Sync Local -> Remote' to upload all at once"
echo ""

# Create a detailed upload checklist
CHECKLIST="$PROJECT_DIR/scripts/upload-checklist.md"

cat > "$CHECKLIST" << 'EOF'
# Upload Checklist - Nong Chok Ayam Bangkok

## Modified Files to Upload

### CSS Files
EOF

# Add CSS files
grep "\.css$" "$UPLOAD_LIST" | while read -r file; do
    echo "- [ ] \`$file\`" >> "$CHECKLIST"
done

cat >> "$CHECKLIST" << 'EOF'

### PHP Files
EOF

# Add PHP files
grep "\.php$" "$UPLOAD_LIST" | while read -r file; do
    echo "- [ ] \`$file\`" >> "$CHECKLIST"
done

cat >> "$CHECKLIST" << 'EOF'

### Other Files
EOF

# Add other files
grep -v "\.css$\|\.php$" "$UPLOAD_LIST" | while read -r file; do
    echo "- [ ] \`$file\`" >> "$CHECKLIST"
done

cat >> "$CHECKLIST" << 'EOF'

## Upload Methods

### Method 1: Individual Files (Recommended)
1. Open VS Code
2. Navigate to each file in the list
3. Right-click → **SFTP: Upload File**
4. Check the checkbox when done

### Method 2: Bulk Upload
1. Press `Cmd+Shift+P`
2. Type **SFTP: Sync Local -> Remote**
3. Select the theme folder
4. Confirm upload

## Verification
After upload, check these URLs:
- [ ] https://nongchokayambangkok.com/ (Homepage)
- [ ] https://nongchokayambangkok.com/about (About page)
- [ ] https://nongchokayambangkok.com/service (Service page)
- [ ] https://nongchokayambangkok.com/news-1 (News page)
- [ ] https://nongchokayambangkok.com/gallery (Gallery page)

## Notes
- FTP Host: nongchokayambangkok.com
- Port: 2121
- Remote Path: /domains/nongchokayambangkok.com/public_html
EOF

echo "✅ Checklist created: $CHECKLIST"
echo ""

# Open checklist in default editor
if command -v code &> /dev/null; then
    code "$CHECKLIST"
    echo "📝 Opened checklist in VS Code"
else
    echo "📝 Checklist saved to: $CHECKLIST"
fi
