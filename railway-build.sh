#!/bin/bash
# Railway Build Script for WordPress

echo "🚀 Starting Railway WordPress build..."

# Copy production config to wp-config.php
if [ -f "wp-config-production.php" ]; then
    echo "📝 Copying wp-config-production.php to wp-config.php..."
    cp wp-config-production.php wp-config.php
    echo "✅ Configuration file ready"
else
    echo "❌ Error: wp-config-production.php not found"
    exit 1
fi

# Set proper permissions
echo "🔒 Setting file permissions..."
chmod 644 wp-config.php

echo "✅ Railway WordPress build completed successfully!"
