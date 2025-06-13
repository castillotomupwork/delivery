#!/bin/bash
set -e

echo "Creating database..."
mysql --user=root --password=mysql -e "CREATE DATABASE IF NOT EXISTS delivery;"
echo "✅ Database created (or already exists)."
