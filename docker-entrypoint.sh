#!/bin/bash
set -e

# Configure Apache to listen on Railway's PORT (defaults to 80 if not set)
PORT=${PORT:-80}

# Update Apache port configuration
sed -i "s/Listen 80/Listen $PORT/" /etc/apache2/ports.conf
sed -i "s/<VirtualHost \*:80>/<VirtualHost *:$PORT>/" /etc/apache2/sites-available/000-default.conf

# Start Apache
exec apache2-foreground

