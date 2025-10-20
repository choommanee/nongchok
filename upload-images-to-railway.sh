#!/bin/bash
# Upload all gallery images to Railway production

PROJECT_ID="c764cc06-4c4c-44c0-8d90-277afaff4dd6"
ENV_ID="9ec7076b-9d24-480a-9418-1ab8153ab7b6"
SERVICE_ID="4702c8ff-f0a3-40f4-8bbe-71899b075d48"

SOURCE_DIR="/Users/sakdachoommanee/Downloads/Shipment 6 Photo"
DEST_DIR="wp-content/uploads/gallery"

echo "📸 Starting image upload to production..."
echo "Source: $SOURCE_DIR"
echo "Destination: $DEST_DIR"
echo ""

# Get list of all category folders
cd "$SOURCE_DIR"
for folder in */; do
    folder_name="${folder%/}"
    echo "📁 Processing category: $folder_name"
    
    # Create tar of this category
    tar -czf "/tmp/gallery-${folder_name}.tar.gz" "$folder_name"
    
    # Upload via Railway SSH
    cat "/tmp/gallery-${folder_name}.tar.gz" | railway ssh \
        --project="$PROJECT_ID" \
        --environment="$ENV_ID" \
        --service="$SERVICE_ID" \
        "cat > /tmp/gallery-${folder_name}.tar.gz && cd $DEST_DIR && tar -xzf /tmp/gallery-${folder_name}.tar.gz && rm /tmp/gallery-${folder_name}.tar.gz && echo '  ✅ Uploaded ${folder_name}'"
    
    # Clean up local temp file
    rm "/tmp/gallery-${folder_name}.tar.gz"
done

echo ""
echo "✅ All images uploaded successfully!"
