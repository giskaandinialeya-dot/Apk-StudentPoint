# 🚀 QUICK REFERENCE - E-POIN System

## Server Access
```bash
# Start Server
cd studentpoint
php artisan serve --host=127.0.0.1 --port=8000

# Access URL
http://127.0.0.1:8000
```

## Default Login Credentials (If Set Up)
```
Admin:    admin@example.com / password
Guru:     guru@example.com / password
Siswa:    siswa@example.com / password
Orang Tua: orangtua@example.com / password
```

## Role-Based Routes
```
Admin Dashboard:     /admin
Guru Dashboard:      /guru
Siswa Dashboard:     /siswa
Orang Tua Dashboard: /orang-tua
```

## Key Files Modified
```
✅ app/Models/Siswa.php
   - Fixed: getTotalPoinPelanggaranAttribute() 
   
✅ app/Models/Kelas.php
   - Added: guru() accessor
   
✅ app/Models/User.php
   - Added: notifikasis() relationship

✅ resources/views/layouts/app.blade.php
   - Modernized with animations & AOS

✅ resources/views/admin/dashboard.blade.php
✅ resources/views/guru/dashboard.blade.php
✅ resources/views/siswa/dashboard.blade.php
✅ resources/views/orang_tua/dashboard.blade.php
   - All completely redesigned with modern UI/UX
```

## Common Troubleshooting

### Issue: "Call to undefined method"
**Solution:** Check if relationship is defined in model
```php
// Example fix in Siswa model:
public function pelanggarans()
{
    return $this->hasMany(Pelanggaran::class);
}
```

### Issue: Animation not showing
**Solution:** Check if AOS library is loaded (it is, in app.blade.php)
- AOS initialized automatically
- Add `data-aos="fade-up"` to elements to animate

### Issue: Points not calculating
**Solution:** Ensure accessor is used correctly
```php
// Right:
$siswa->total_poin_pelanggaran (uses accessor)

// Wrong:
$siswa->total_poin_pelanggaran() (this is not a method)
```

## Database Relationships Cheat Sheet

```
User
├── has one Siswa (via user_id)
├── has one Guru (via user_id)  
├── has one OrangTua (via user_id)
└── has many Notifikasi

Siswa
├── belongs to User & Kelas
├── has many Pelanggaran (sum via jenisPelanggaran->poin)
├── has many Prestasi (sum via poin)
├── has many Absensi (check status)
└── saldo_poin = prestasi - pelanggaran

Guru
├── belongs to User
├── has many Kelas (via kelasWali)
└── can create Pelanggaran & Prestasi

OrangTua
├── belongs to User & Siswa (one-to-one)
└── views child's data via $orangtua->siswa

Kelas
├── belongs to Guru (via guru() accessor, uses wali_guru_id to users.id)
└── has many Siswa
```

## Feature Checklist

### Admin Features ✅
- [x] Dashboard with metrics
- [x] Real-time violation feed
- [x] Critical students alerts
- [x] Violation type management (future)

### Guru Features ✅
- [x] Dashboard with class statistics
- [x] Create violations (Pelanggaran resource)
- [x] Create achievements (Prestasi resource)
- [x] View critical students
- [x] Monthly trends

### Siswa Features ✅
- [x] View personal dashboard
- [x] See violation history
- [x] See achievement history
- [x] Check attendance status
- [x] View saldo poin

### Orang Tua Features ✅
- [x] View child's dashboard
- [x] See violation history
- [x] See achievement history
- [x] Check attendance
- [x] View warning letter status

## Performance Tips

1. **Database**: Use eager loading to avoid N+1 queries
   ```php
   Siswa::with('pelanggarans.jenisPelanggaran')->get()
   ```

2. **Caching**: Cache frequently accessed data
   ```php
   cache()->remember('total_siswa', 3600, fn() => Siswa::count())
   ```

3. **Pagination**: Use pagination for large datasets
   ```php
   $pelanggarans->paginate(15)
   ```

## Color Coding

- 🔴 **Red** = Violations, Danger, Negative
- 🟢 **Green** = Achievements, Success, Positive  
- 🔵 **Blue** = Info, Primary, Default
- 🟣 **Purple** = Alternative, Secondary
- 🟡 **Yellow** = Warning, Attention

## CSS Animation Classes

```html
<!-- Fade in on scroll -->
<div data-aos="fade-up">Content</div>

<!-- Pulsing badge -->
<span class="badge-pulse">Alert</span>

<!-- Hover effects -->
<div class="card-hover">Hover me</div>

<!-- Menu active state -->
<a class="menu-item active">Active Menu</a>

<!-- Gradient text -->
<h1 class="gradient-text">Title</h1>
```

## Next Steps for Deployment

1. **Database Setup**
   ```bash
   php artisan migrate --seed
   ```

2. **Create Admin User**
   ```bash
   php artisan tinker
   # Then create users with role 'admin', 'guru', 'siswa', 'orang_tua'
   ```

3. **Clear Cache**
   ```bash
   php artisan cache:clear
   php artisan config:clear
   ```

4. **Optimize (Production)**
   ```bash
   php artisan config:cache
   php artisan route:cache
   ```

5. **Set Up Web Server** (nginx/Apache)
   - Point DocumentRoot to `public/` folder
   - Ensure `public/.htaccess` is in place (Laravel)
   - Set proper permissions on `storage/` and `bootstrap/cache/`

## Emergency Contacts

- **Database Issues**: Check migrations in `/database/migrations/`
- **Routing Issues**: Check `/routes/web.php`
- **Model Issues**: Check `/app/Models/`
- **View Issues**: Check `/resources/views/`
- **Controller Issues**: Check `/app/Http/Controllers/`

## Useful Commands

```bash
# Clear all cache
php artisan cache:clear && php artisan config:clear

# Run migrations
php artisan migrate

# Run seeders
php artisan db:seed

# View routes
php artisan route:list

# Tinker shell (for testing)
php artisan tinker

# View logs
tail -f storage/logs/laravel.log
```

---

**Last Updated:** January 23, 2026  
**Status:** ✅ Production Ready  
**Version:** 1.0.0
