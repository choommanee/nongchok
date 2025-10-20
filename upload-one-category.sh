#!/bin/bash
CATEGORY=$1
if [ -z "$CATEGORY" ]; then
    echo "Usage: $0 <category_number>"
    exit 1
fi

SOURCE="/Users/sakdachoommanee/Downloads/Shipment 6 Photo/$CATEGORY"
if [ ! -d "$SOURCE" ]; then
    echo "Error: Category $CATEGORY not found"
    exit 1
fi

echo "📦 Creating archive for category $CATEGORY..."
cd "$SOURCE/.."
tar -czf "/tmp/cat-$CATEGORY.tar.gz" "$CATEGORY"

echo "📤 Uploading to Railway..."
cat "/tmp/cat-$CATEGORY.tar.gz" | railway ssh \
    --project=c764cc06-4c4c-44c0-8d90-277afaff4dd6 \
    --environment=9ec7076b-9d24-480a-9418-1ab8153ab7b6 \
    --service=4702c8ff-f0a3-40f4-8bbe-71899b075d48 \
    "cat > /tmp/cat.tar.gz && cd wp-content/uploads/gallery && tar -xzf /tmp/cat.tar.gz && rm /tmp/cat.tar.gz && echo '✅ Uploaded $CATEGORY'"

rm "/tmp/cat-$CATEGORY.tar.gz"
echo "✅ Done: $CATEGORY"
