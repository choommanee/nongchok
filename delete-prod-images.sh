#!/bin/bash
# Delete all gallery images on Production

echo "Connecting to Railway Production..."
railway ssh --service nongchok-production --project nongchok --environment production << 'EOF'
cd /app/wp-content/uploads/gallery || exit 1
echo "Current gallery folder:"
ls -la
echo ""
echo "Deleting all category folders..."
rm -rf */
echo "Done! Current status:"
ls -la
EOF
