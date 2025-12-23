#!/bin/bash
# Railway Initial Setup Script - Run this ONCE

echo "=== Railway Database Setup ==="
echo "Dropping all tables..."
php artisan db:wipe --force

echo "Running migrations..."
php artisan migrate --force

echo "Seeding database..."
php artisan db:seed --force

echo "✅ Database setup complete!"
