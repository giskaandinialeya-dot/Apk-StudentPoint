# 🚀 E-POIN Production Deployment Guide

Panduan lengkap untuk deploy aplikasi E-POIN ke production server (Shared Hosting, VPS, atau Cloud).

---

## 📋 Pre-Deployment Checklist

- [ ] All tests passed locally
- [ ] `.env` configured for production
- [ ] Database backed up
- [ ] Frontend assets built
- [ ] SSL certificate ready
- [ ] Domain configured
- [ ] Hosting/VPS ready (PHP 8.3+, MySQL, Node.js optional)
- [ ] Email service configured (SMTP)
- [ ] Storage directory writable
- [ ] Cron job setup ready

---

## 🖥️ Server Requirements

### Minimum Requirements
- **PHP:** 8.3 or higher
- **MySQL:** 5.7+ or MariaDB 10.3+
- **Node.js:** 16+ (for build process, optional)
- **Disk Space:** 2GB minimum (for app + database)
- **Memory:** 512MB minimum (1GB recommended)
- **Bandwidth:** 1GB/month minimum

### Recommended Specifications
- **PHP:** 8.3+ with extensions: pdo, mysql, curl, json, xml, mbstring, zip, gd, bcmath
- **MySQL:** 8.0+
- **Server:** Ubuntu 22.04 LTS or CentOS 7+
- **Web Server:** Nginx (recommended) or Apache
- **Memory:** 2GB+ RAM
- **CPU:** 2 vCores+

---

## 🔧 Deployment Steps

### Step 1: Upload Project Files

#### Using FTP/SFTP
```bash
# Windows: Use FileZilla, WinSCP
# Mac/Linux: Use Cyberduck, FileZilla, or command line

sftp user@server.com
> cd /home/username/public_html
> put -r ~/laravel-project/* .
```

#### Using Git (Recommended)
```bash
# SSH to server
ssh user@server.com

# Navigate to web directory
cd /home/username/public_html

# Clone repository (if using private repo)
git clone --depth 1 https://github.com/your-repo/epoin.git .

# Or pull from existing repo
git pull origin main
```

#### Using Archive
```bash
# Create archive locally
zip -r epoin.zip . -x "node_modules/*" "vendor/*" ".git/*"

# Upload via FTP/SCP
scp epoin.zip user@server.com:/home/username/
ssh user@server.com
cd /home/username
unzip -q epoin.zip
rm epoin.zip
```

---

### Step 2: Server Configuration

#### SSH to Server
```bash
ssh user@server.com
cd /home/username/public_html
```

#### Install PHP Dependencies
```bash
composer install --no-dev --optimize-autoloader

# If timeout issues:
composer install --no-dev -o --prefer-dist

# For large projects:
composer install --no-dev -o -n --working-dir=/tmp/composer-tmp && mv /tmp/composer-tmp/* .
```

#### Install Frontend Dependencies (if using Vite)
```bash
npm install --production

# Build frontend assets
npm run build

# Cleanup
rm -rf node_modules
```

---

### Step 3: Environment Configuration

#### Setup .env File
```bash
# Copy environment template
cp .env.example .env

# Edit configuration
nano .env
```

#### .env Configuration
```env
APP_NAME="E-POIN"
APP_ENV=production
APP_KEY=                          # Will be generated
APP_DEBUG=false
APP_URL=https://epoin.school.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=epoin_db
DB_USERNAME=epoin_user
DB_PASSWORD=secure_password_here

CACHE_DRIVER=redis               # or file/database
SESSION_DRIVER=database
QUEUE_CONNECTION=database        # or redis

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com         # or your SMTP provider
MAIL_PORT=587
MAIL_USERNAME=noreply@school.com
MAIL_PASSWORD=your_app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@school.com
MAIL_FROM_NAME="E-POIN Sekolah"

LOG_CHANNEL=single
LOG_LEVEL=notice                 # or error/warning
```

#### Generate Application Key
```bash
php artisan key:generate
```

---

### Step 4: Database Setup

#### Create Database
```bash
# SSH to MySQL
mysql -u root -p

# Create database
CREATE DATABASE epoin_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

# Create dedicated user
CREATE USER 'epoin_user'@'localhost' IDENTIFIED BY 'secure_password_123';

# Grant privileges
GRANT ALL PRIVILEGES ON epoin_db.* TO 'epoin_user'@'localhost';
FLUSH PRIVILEGES;

# Exit
EXIT;
```

#### Run Migrations
```bash
php artisan migrate --force

# With seed data (caution: overwrites existing)
php artisan migrate --seed --force
```

#### Verify Database
```bash
php artisan tinker
> User::count()
> Siswa::count()
```

---

### Step 5: Directory Permissions

```bash
# Set correct ownership
sudo chown -R www-data:www-data /home/username/public_html

# Set directory permissions
chmod -R 755 /home/username/public_html
chmod -R 775 /home/username/public_html/storage
chmod -R 775 /home/username/public_html/bootstrap/cache

# Set file permissions
find /home/username/public_html -type f -exec chmod 644 {} \;
find /home/username/public_html/storage -type f -exec chmod 664 {} \;
```

---

### Step 6: Web Server Configuration

#### Nginx Configuration
```nginx
# /etc/nginx/sites-available/epoin

server {
    listen 80;
    listen [::]:80;
    server_name epoin.school.com;
    
    # Redirect HTTP to HTTPS
    return 301 https://$server_name$request_uri;
}

server {
    listen 443 ssl http2;
    listen [::]:443 ssl http2;
    server_name epoin.school.com;
    
    # SSL Certificates
    ssl_certificate /etc/ssl/certs/your_certificate.crt;
    ssl_certificate_key /etc/ssl/private/your_private.key;
    ssl_protocols TLSv1.2 TLSv1.3;
    ssl_ciphers HIGH:!aNULL:!MD5;
    ssl_prefer_server_ciphers on;
    
    root /home/username/public_html/public;
    index index.php;
    
    # Security Headers
    add_header X-Frame-Options "SAMEORIGIN" always;
    add_header X-Content-Type-Options "nosniff" always;
    add_header X-XSS-Protection "1; mode=block" always;
    add_header Referrer-Policy "no-referrer-when-downgrade" always;
    
    # Gzip Compression
    gzip on;
    gzip_vary on;
    gzip_types text/plain text/css text/xml text/javascript 
               application/x-javascript application/xml+rss 
               application/javascript application/json;
    
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    
    location ~ \.php$ {
        try_files $uri =404;
        fastcgi_pass unix:/var/run/php/php8.3-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }
    
    # Static files caching
    location ~* \.(jpg|jpeg|png|gif|ico|css|js|svg|woff|woff2|ttf)$ {
        expires 1y;
        add_header Cache-Control "public, immutable";
    }
    
    # Deny access to sensitive files
    location ~ /\. {
        deny all;
    }
    
    location ~ /storage/ {
        deny all;
    }
}
```

**Enable Site:**
```bash
sudo ln -s /etc/nginx/sites-available/epoin /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl restart nginx
```

#### Apache Configuration
```apache
<VirtualHost *:80>
    ServerName epoin.school.com
    DocumentRoot /home/username/public_html/public
    
    # Redirect to HTTPS
    RewriteEngine On
    RewriteCond %{HTTPS} off
    RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
    
    <Directory /home/username/public_html/public>
        Options -MultiViews -Indexes +FollowSymLinks
        AllowOverride All
        Require all granted
        
        <IfModule mod_rewrite.c>
            RewriteEngine On
            RewriteCond %{REQUEST_FILENAME} !-d
            RewriteCond %{REQUEST_FILENAME} !-f
            RewriteRule ^ index.php [QSA,L]
        </IfModule>
    </Directory>
</VirtualHost>

<VirtualHost *:443>
    ServerName epoin.school.com
    DocumentRoot /home/username/public_html/public
    
    SSLEngine on
    SSLCertificateFile /etc/ssl/certs/your_certificate.crt
    SSLCertificateKeyFile /etc/ssl/private/your_private.key
    SSLCertificateChainFile /etc/ssl/certs/chain.crt
    
    # Same rewrite rules as HTTP...
</VirtualHost>
```

---

### Step 7: SSL Certificate (HTTPS)

#### Using Let's Encrypt (Free)
```bash
# Install Certbot
sudo apt-get install certbot python3-certbot-nginx

# Generate certificate
sudo certbot certonly --nginx -d epoin.school.com

# Auto-renew certificates
sudo certbot renew --dry-run
```

#### Manual Certificate
```bash
# Copy your certificate files
sudo cp your_certificate.crt /etc/ssl/certs/
sudo cp your_private.key /etc/ssl/private/
sudo chmod 644 /etc/ssl/certs/your_certificate.crt
sudo chmod 600 /etc/ssl/private/your_private.key
```

---

### Step 8: Optimize for Production

#### Cache Configuration
```bash
# Cache config
php artisan config:cache

# Cache routes
php artisan route:cache

# Cache views
php artisan view:cache

# Optimize autoloader
composer dump-autoload --optimize
```

#### Clear Development Caches
```bash
php artisan cache:clear
php artisan view:clear
php artisan config:clear
```

#### Set Correct Permissions
```bash
chmod 600 /home/username/public_html/.env
chmod 644 /home/username/public_html/app.php
```

---

### Step 9: Setup Cron Job

#### Laravel Scheduler Cron
```bash
# Edit crontab
crontab -e

# Add this line:
* * * * * cd /home/username/public_html && php artisan schedule:run >> /dev/null 2>&1

# Verify
crontab -l
```

#### Queue Worker (if using queue)
```bash
# If using database queue, setup supervisor:
sudo apt-get install supervisor

# Create config
sudo nano /etc/supervisor/conf.d/epoin-worker.conf
```

```ini
[program:epoin-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /home/username/public_html/artisan queue:work database --tries=3 --timeout=90
autostart=true
autorestart=true
numprocs=4
redirect_stderr=true
stdout_logfile=/var/log/epoin-worker.log
```

```bash
# Start supervisor
sudo systemctl restart supervisor
```

---

### Step 10: Monitoring & Logging

#### View Logs
```bash
# Real-time logs
tail -f /home/username/public_html/storage/logs/laravel.log

# Last 100 lines
tail -n 100 /home/username/public_html/storage/logs/laravel.log

# Search logs
grep "error" /home/username/public_html/storage/logs/laravel.log
```

#### Setup Log Rotation
```bash
sudo nano /etc/logrotate.d/epoin

# Add:
/home/username/public_html/storage/logs/*.log {
    daily
    missingok
    rotate 14
    compress
    delaycompress
    notifempty
    create 0664 www-data www-data
}

sudo logrotate -f /etc/logrotate.d/epoin
```

---

## 🔐 Security Best Practices

### 1. File Permissions
```bash
# Correct permissions
find /home/username/public_html -type d -exec chmod 755 {} \;
find /home/username/public_html -type f -exec chmod 644 {} \;
find /home/username/public_html/storage -type d -exec chmod 775 {} \;
```

### 2. Firewall Configuration
```bash
sudo ufw allow 22/tcp
sudo ufw allow 80/tcp
sudo ufw allow 443/tcp
sudo ufw enable
```

### 3. Disable Directory Listing
```bash
# Already in web server config above
# Verify:
Options -Indexes
```

### 4. Hide Server Information
```nginx
# In Nginx config
server_tokens off;

# In PHP (php.ini)
expose_php = Off
```

### 5. Database Backup
```bash
# Daily backup cron
0 2 * * * mysqldump -u epoin_user -p'password' epoin_db > /home/username/backups/epoin_$(date +\%Y\%m\%d).sql

# Backup script
#!/bin/bash
BACKUP_DIR="/home/username/backups"
DATE=$(date +%Y%m%d_%H%M%S)
mysqldump -u epoin_user -p'password' epoin_db | gzip > "$BACKUP_DIR/epoin_$DATE.sql.gz"
find $BACKUP_DIR -name "epoin_*.sql.gz" -mtime +7 -delete
```

---

## 🚨 Post-Deployment Verification

### 1. Check Application
```bash
# Visit https://epoin.school.com
# Verify login page loads
# Test login with test credentials
```

### 2. Verify Database
```bash
php artisan tinker
> User::count()
> Siswa::count()
```

### 3. Test Email
```bash
php artisan mail:send
# or test via artisan tinker
```

### 4. Check Permissions
```bash
ls -la /home/username/public_html/storage/
ls -la /home/username/public_html/bootstrap/cache/
```

### 5. Monitor Logs
```bash
tail -f /home/username/public_html/storage/logs/laravel.log
```

---

## 🔄 Maintenance & Updates

### Regular Maintenance
```bash
# Clear caches weekly
php artisan cache:clear

# Check for updates monthly
composer update --dry-run

# Backup database daily
# (see backup script above)
```

### Deploy Updates
```bash
# Pull latest code
git pull origin main

# Install dependencies
composer install --no-dev --optimize-autoloader

# Run migrations
php artisan migrate --force

# Clear caches
php artisan cache:clear
php artisan config:cache
php artisan route:cache
```

### Rollback on Error
```bash
# Revert to previous commit
git revert HEAD

# Or rollback migrations
php artisan migrate:rollback
```

---

## 📊 Performance Optimization

### Enable Query Caching (MySQL)
```bash
# /etc/mysql/mysql.conf.d/mysqld.cnf
query_cache_size = 16M
query_cache_type = 1
```

### Redis Caching
```bash
# Install Redis
sudo apt-get install redis-server

# Configure in .env
CACHE_DRIVER=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis

# Verify
redis-cli ping
```

### Enable Gzip Compression
```nginx
# Already in Nginx config above
gzip on;
gzip_types text/css text/javascript application/json;
```

---

## 🐛 Troubleshooting

### 502 Bad Gateway
```bash
# Check PHP-FPM status
sudo systemctl status php8.3-fpm

# Restart if needed
sudo systemctl restart php8.3-fpm
```

### 500 Internal Server Error
```bash
# Check logs
tail -f /home/username/public_html/storage/logs/laravel.log

# Check permissions
ls -la /home/username/public_html/storage/
chmod -R 775 /home/username/public_html/storage
```

### Database Connection Error
```bash
# Test connection
mysql -u epoin_user -p -h 127.0.0.1 epoin_db

# Check .env values
grep "DB_" /home/username/public_html/.env
```

### Memory Limit Exceeded
```bash
# Increase in php.ini
memory_limit = 256M

# Or in .htaccess
php_value memory_limit 256M
```

---

## 📞 Support Contacts

- **Laravel Docs:** https://laravel.com/docs
- **MySQL Support:** https://dev.mysql.com
- **Nginx Docs:** https://nginx.org/en/docs/
- **PHP Manual:** https://www.php.net/manual/

---

**Deployment Completed!** 🎉

Your E-POIN application is now live on production. Monitor logs regularly and maintain security best practices.
