# SILABORY — System Manajemen Lab Inventory

SILABORY adalah aplikasi manajemen inventaris laboratorium berbasis Laravel yang dibuat untuk menangani katalog barang, peminjaman, persetujuan pengembalian, dan fitur blog sederhana.

**Tujuan**: Memudahkan admin/asisten dan pengguna mahasiswa untuk mengelola barang lab, melacak peminjaman, dan mengelola data pengguna.

**Fitur Utama**
- Manajemen item (CRUD) dengan foto
- Kategori item
- Alur peminjaman: submit → review (approve/reject) → respond → return
- Role-based access: `admin`, `asisten`, dan pengguna biasa
- Halaman publik sederhana (berita/blog)
- Responsif: tabel dibungkus dengan overflow-x pada layar kecil; form auth sudah disesuaikan

**Teknologi**
- Backend: PHP 8+ & Laravel
- Frontend: Blade + Tailwind CSS + Flowbite
- Build tools: Vite (via Laravel Breeze / Jetstream scaffolding)

**Struktur Penting**
- Views: [resources/views](resources/views)
- CSS: [resources/css/app.css](resources/css/app.css)
- Controller: [app/Http/Controllers](app/Http/Controllers)

**Prasyarat**
- PHP 8+
- Composer
- Node.js & npm
- Database (MySQL / Postgresql / SQLite)
- Laragon (opsional, direkomendasikan pada Windows)

## Instalasi (lokal)
Jalankan perintah ini dari root project (Windows PowerShell):

```powershell
# 1. Pasang dependensi PHP
composer install

# 2. Pasang dependensi frontend
npm install

# 3. Salin file .env dan atur konfigurasi database
copy .env.example .env
# lalu edit .env sesuai lingkungan Anda (DB_*, APP_URL, dsb.)

# 4. Generate app key
php artisan key:generate

# 5. Buat symbolic link ke storage (agar asset bisa diakses)
php artisan storage:link

# 6. Jalankan migrasi (dan seeder jika ada)
php artisan migrate

# 7. Jalankan dev server untuk assets
npm run dev

# 8. Jalankan server aplikasi
php artisan serve
```

Akses di: http://127.0.0.1:8000

Catatan: Jika menggunakan Laragon, Anda bisa meletakkan proyek di folder `www` dan gunakan VirtualHost Laragon.

## Build produksi

```powershell
npm run build
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## Perubahan responsif yang sudah dilakukan
- Tabel-tabel utama dibungkus `overflow-x-auto` dan menggunakan `min-w-full table-auto` agar dapat di-scroll horizontal pada layar kecil.
- Halaman login dan register telah di-refactor agar tampil rapi di mobile (stacked layout), dan menggunakan grid/kolom pada layar lebih lebar.
- Sidebar kini menampilkan area akun dan tombol `Log out` khusus pada tampilan mobile, dan navbar atas disembunyikan untuk `admin|asisten` pada layar kecil untuk menghindari dua hamburger.

## Hal yang bisa ditingkatkan (cek dan kontribusi)
- Konsistenkan ukuran thumbnail dan foto profil (`max-w-full h-auto`) di seluruh view.
- Perbaiki breakpoint dan ukuran heading untuk keterbacaan di mobile.
- Tambah test end-to-end (Pest / Dusk) untuk alur peminjaman.

## Cara kontribusi
1. Fork repo
2. Buat branch fitur: `git checkout -b feat/nama-fitur`
3. Commit perubahan dan push
4. Buat pull request dan sertakan deskripsi perubahan

## Troubleshooting cepat
- Error permission storage: jalankan `php artisan storage:link` dan periksa permission folder `storage`/`bootstrap/cache`.
- Asset tidak berubah: jalankan `npm run dev` ulang dan clear cache `php artisan view:clear`.

---
Terima kasih sudah menggunakan SILABORY — jika mau saya bantu buatkan bagian README tambahan (contoh screenshot, diagram alur, atau deploy guide), beri tahu saya.
