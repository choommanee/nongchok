#!/bin/bash
# Railway Build Script for WordPress

echo "🚀 Starting Railway WordPress build..."

# Copy railway config to wp-config.php
if [ -f "wp-config-railway.php" ]; then
    echo "📝 Copying wp-config-railway.php to wp-config.php..."
    cp wp-config-railway.php wp-config.php
    echo "✅ Configuration file ready"
else
    echo "❌ Error: wp-config-railway.php not found"
    exit 1
fi

# Set proper permissions
echo "🔒 Setting file permissions..."
chmod 644 wp-config.php

echo "✅ Railway WordPress build completed successfully!"
