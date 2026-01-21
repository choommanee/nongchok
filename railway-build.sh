#!/bin/bash
# Railway Build Script for WordPress

echo "Starting WordPress build process..."

# Install Composer dependencies if composer.json exists
if [ -f "composer.json" ]; then
    echo "Installing Composer dependencies..."
    composer install --no-dev --optimize-autoloader
fi

# Create necessary directories
echo "Creating necessary directories..."
mkdir -p wp-content/uploads
mkdir -p wp-content/cache
mkdir -p wp-content/upgrade

# Set permissions
echo "Setting permissions..."
chmod -R 755 wp-content/uploads
chmod -R 755 wp-content/cache

echo "Build completed successfully!"
