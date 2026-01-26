# 📦 E-POIN Laravel 11 - Package & Dependencies

Dokumentasi lengkap package yang diperlukan untuk development dan production.

## ✅ Core Dependencies

### Laravel Framework & Base
```json
{
  "laravel/framework": "^11.0",
  "laravel/sanctum": "^4.0",
  "laravel/tinker": "^2.8"
}
```

### Database & ORM
```json
{
  "doctrine/dbal": "^3.6",
  "illuminate/database": "^11.0"
}
```

## 🔐 Authentication & Authorization

### Laravel Breeze (Recommended)
```bash
composer require laravel/breeze --dev
php artisan breeze:install blade
```
- Lightweight auth scaffolding
- Blade templates & Tailwind CSS
- Perfect untuk multi-role system

### Spatie Permission (untuk advanced RBAC)
```bash
composer require spatie/laravel-permission
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
```
- Powerful role & permission management
- Caching support
- Middleware untuk route protection

## 📊 Spreadsheet & PDF

### Excel/CSV Export
```bash
composer require maatwebsite/excel
php artisan vendor:publish --provider="Maatwebsite\Excel\ExcelServiceProvider"
```
- Export ke Excel (.xlsx, .csv)
- Import dari Excel
- Style & formatting support

### PDF Generation
```bash
composer require barryvdh/laravel-dompdf
php artisan vendor:publish --provider="Barryvdh\DomPDF\ServiceProvider"
```
- Generate PDF dari Blade templates
- Perfect untuk rapor & surat peringatan
- Support images & styling

## 🔔 Real-time Features (Optional)

### Pusher (Real-time notifications)
```bash
composer require pusher/pusher-php-server
npm install pusher-js
```
- Real-time notifications
- Broadcasting events
- Requires Pusher account (paid)

### Laravel Echo
```bash
composer require laravel/echo
npm install laravel-echo
```
- WebSocket client library
- Works dengan Pusher or native WebSocket

## 📈 Analytics & Logging

### Query Debugbar (Development only)
```bash
composer require --dev barryvdh/laravel-debugbar
php artisan vendor:publish --provider="Barryvdh\Debugbar\ServiceProvider"
```
- Debug SQL queries
- Performance monitoring
- Request/response inspection

### Sentry (Error tracking - Production)
```bash
composer require sentry/sentry-laravel
php artisan vendor:publish --provider="Sentry\Laravel\ServiceProvider"
```
- Error & exception tracking
- Performance monitoring
- Requires Sentry account

## 🎨 Frontend & Styling

### Tailwind CSS
```bash
npm install -D tailwindcss postcss autoprefixer
npx tailwindcss init -p
```
- Utility-first CSS framework
- Mobile-responsive
- Already included di Breeze

### Laravel Vite Plugin
```bash
npm install --save-dev @vitejs/plugin-vue
```
- Fast build tool
- HMR (Hot Module Replacement)
- Production optimization

## 🧪 Testing

### PHPUnit (Pre-installed)
```bash
php artisan test
```
- Unit tests
- Feature tests
- Browser testing

### Factory & Seeding
```bash
php artisan make:seeder
php artisan make:factory
php artisan db:seed
```
- Dummy data untuk testing
- Database seeding

## 📋 Development Tools

### Laravel Pint (Code formatting)
```bash
composer require --dev laravel/pint
./vendor/bin/pint
```
- Automatic code style fixes
- PSR-12 compliance
- Pre-commit hook

### PHPStan (Static analysis)
```bash
composer require --dev phpstan/phpstan
./vendor/bin/phpstan analyse app/
```
- Find bugs before runtime
- Type checking
- Best practices

## 🔧 Recommended Additional Packages

### Image Handling
```bash
composer require intervention/image
```
- Upload & resize gambar
- Validation image
- Generate thumbnails

### Slug Generation
```bash
composer require spatie/laravel-sluggable
```
- Auto-generate URL slugs
- SEO-friendly URLs

### CSV Export
```bash
composer require league/csv
```
- Advanced CSV handling
- Custom formatting

## 📦 composer.json Lengkap

```json
{
    "name": "epoin/epoin-laravel",
    "description": "E-POIN - Platform Manajemen Poin Siswa",
    "require": {
        "php": "^8.2",
        "laravel/framework": "^11.0",
        "laravel/sanctum": "^4.0",
        "laravel/tinker": "^2.8",
        "spatie/laravel-permission": "^6.0",
        "maatwebsite/excel": "^3.1",
        "barryvdh/laravel-dompdf": "^2.1",
        "intervention/image": "^3.0",
        "spatie/laravel-sluggable": "^3.0"
    },
    "require-dev": {
        "laravel/breeze": "^2.0",
        "laravel/pint": "^1.13",
        "phpunit/phpunit": "^11.0",
        "fakerphp/faker": "^1.23",
        "barryvdh/laravel-debugbar": "^3.8",
        "phpstan/phpstan": "^1.10"
    },
    "scripts": {
        "post-autoload-dump": [
            "@php artisan package:discover --ansi"
        ],
        "post-update-cmd": [
            "@php artisan vendor:publish --tag=laravel-assets --ansi --force"
        ]
    }
}
```

## 📦 package.json (NPM)

```json
{
    "private": true,
    "scripts": {
        "dev": "vite",
        "build": "vite build",
        "preview": "vite preview"
    },
    "devDependencies": {
        "@tailwindcss/forms": "^0.5.7",
        "@vitejs/plugin-vue": "^5.0.0",
        "autoprefixer": "^10.4.17",
        "postcss": "^8.4.33",
        "tailwindcss": "^3.4.1",
        "vite": "^5.0.0",
        "vue": "^3.3.0"
    },
    "dependencies": {
        "axios": "^1.6.0",
        "laravel-echo": "^1.17.1",
        "pusher-js": "^8.1.0"
    }
}
```

## 🚀 Installation Commands

```bash
# Setup project baru
composer create-project laravel/laravel studentpoint "11.*"
cd studentpoint

# Install auth
composer require laravel/breeze --dev
php artisan breeze:install blade

# Install required packages
composer require spatie/laravel-permission
composer require maatwebsite/excel
composer require barryvdh/laravel-dompdf

# Install optional packages
composer require intervention/image
composer require spatie/laravel-sluggable

# Install dev packages
composer require --dev barryvdh/laravel-debugbar
composer require --dev phpstan/phpstan

# Install frontend dependencies
npm install

# Generate key & migrate
php artisan key:generate
php artisan migrate

# Seed dummy data
php artisan db:seed

# Build frontend
npm run build
npm run dev (untuk development)
```

## ✨ Feature Support by Package

| Feature | Package | Status |
|---------|---------|--------|
| Authentication | Breeze | ✅ |
| Role-based Access | Spatie Permission | ✅ |
| Export Excel | Maatwebsite Excel | ✅ |
| Export PDF | DomPDF | ✅ |
| Real-time Updates | Pusher + Echo | ⚠️ Optional |
| Image Upload | Intervention Image | ✅ |
| Code Quality | PHPStan/Pint | ✅ Dev |
| Debugging | Debugbar | ✅ Dev |
| Error Tracking | Sentry | ⚠️ Optional |

## 🔄 Update Commands

```bash
# Update all packages
composer update
npm update

# Update specific package
composer update laravel/framework
npm update tailwindcss

# Check outdated packages
composer outdated
npm outdated
```

## 🐛 Troubleshooting Package Issues

### "Class not found" setelah install package
```bash
composer dump-autoload
php artisan cache:clear
```

### Package config tidak ter-publish
```bash
php artisan vendor:publish --provider="VendorName\ServiceProvider"
```

### NPM module conflict
```bash
rm package-lock.json
npm install
```

### Permission denied di storage
```bash
chmod -R 775 storage bootstrap/cache
```

## 📚 Documentation Links

- [Laravel 11 Docs](https://laravel.com/docs/11.x)
- [Larvel Breeze](https://laravel.com/docs/11.x/starter-kits#breeze)
- [Spatie Permission](https://spatie.be/docs/laravel-permission/v6/introduction)
- [Maatwebsite Excel](https://docs.laravel-excel.com/3.1/getting-started/)
- [DomPDF](https://github.com/barryvdh/laravel-dompdf)
- [Tailwind CSS](https://tailwindcss.com/docs)
- [Vite](https://vitejs.dev/)

## 💡 Best Practices

1. **Development Tools Only**: Debugbar, PHPStan hanya di `require-dev`
2. **Production Ready**: Test sebelum production deployment
3. **Keep Updated**: Regular `composer update` & security patches
4. **Lock File**: Commit `composer.lock` ke version control
5. **Performance**: Monitor package size & dependencies

---

**Last Updated:** January 2026  
**Laravel Version:** 11.x  
**PHP Version:** 8.2+
