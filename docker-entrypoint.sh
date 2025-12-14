#!/bin/bash
set -e

echo "=== Starting Maisie Messenger ==="
echo "PORT environment variable: ${PORT}"

# Fix MPM conflict at runtime - ensure only prefork is enabled
echo "Fixing MPM configuration..."
a2dismod -f mpm_event 2>/dev/null || true
a2dismod -f mpm_worker 2>/dev/null || true
rm -f /etc/apache2/mods-enabled/mpm_*.load 2>/dev/null || true
rm -f /etc/apache2/mods-enabled/mpm_*.conf 2>/dev/null || true
a2enmod -f mpm_prefork 2>/dev/null || true

# Verify only one MPM is enabled
echo "Enabled MPMs:"
ls -la /etc/apache2/mods-enabled/ | grep mpm || echo "No MPM modules found"

# Configure Apache to listen on Railway's PORT (defaults to 80 if not set)
PORT=${PORT:-80}
echo "Configuring Apache to listen on port $PORT"

# Update Apache port configuration
sed -i "s/Listen 80/Listen $PORT/" /etc/apache2/ports.conf
sed -i "s/<VirtualHost \*:80>/<VirtualHost *:$PORT>/" /etc/apache2/sites-available/000-default.conf

# Test Apache configuration
echo "Testing Apache configuration..."
apache2ctl configtest

# Start Apache
echo "Starting Apache..."
exec apache2-foreground

