# AssetHub — Greenfields

Sistem manajemen aset berbasis web untuk memantau, mengelola, dan menjadwalkan perawatan aset perusahaan.

---

## Fitur Utama

- **Manajemen Aset** — tambah, edit, hapus, dan pantau status aset (Normal, Maintenance, Broken)
- **Kategori Aset** — kelompokkan aset berdasarkan kategori yang dapat dikustomisasi
- **Jadwal Maintenance** — buat dan pantau jadwal perawatan aset secara berkala
- **Log Maintenance** — catat riwayat perbaikan dan perawatan setiap aset
- **Dashboard** — ringkasan statistik, kalender maintenance, dan priority alerts
- **Notifikasi** — notifikasi jadwal overdue, hari ini, dan segera jatuh tempo
- **Manajemen User** — kelola akun dengan role Admin, Manager, dan Teknisi

---

## Tech Stack

- **Backend** — Laravel (PHP)
- **Frontend** — Blade + Tailwind CSS
- **Database** — PostgreSQL
- **Konfirmasi Hapus** — SweetAlert2

---

## Instalasi

```bash
# 1. Clone repo
git clone https://github.com/Najwaalya/asset-management-greenfields.git
cd asset-management-greenfields

# 2. Install dependencies
composer install
npm install

# 3. Setup environment
cp .env.example .env
php artisan key:generate

# 4. Konfigurasi database di .env
DB_DATABASE=aasset-management-greenfields
DB_USERNAME=root
DB_PASSWORD=

# 5. Migrate & seed
php artisan migrate --seed

# 6. Build assets
npm run dev

# 7. Jalankan server
php artisan serve
```

---

## Role & Akses

| Fitur            | Admin | Manager | Teknisi |
|------------------|:-----:|:-------:|:-------:|
| Dashboard        | ✅    | ✅      | ✅      |
| Lihat Aset       | ✅    | ✅      | ❌      |
| Kelola Aset      | ✅    | ✅      | ❌      |
| Kategori         | ✅    | ❌      | ❌      |
| Jadwal Maintenance | ✅  | ✅      | ✅      |
| Log Maintenance  | ✅    | ✅      | ✅      |
| Kelola User      | ✅    | ❌      | ❌      |

---

## Status Aset

| Status        | Keterangan                        |
|---------------|-----------------------------------|
| `normal`      | Aset berfungsi dengan baik        |
| `maintenance` | Aset sedang dalam perawatan       |
| `broken`      | Aset rusak dan perlu penanganan   |

---

## Status Maintenance

| Status        | Keterangan                  |
|---------------|-----------------------------|
| `pending`     | Menunggu ditangani          |
| `in_progress` | Sedang dalam proses         |
| `resolved`    | Selesai ditangani           |

---

## Lisensi

Proyek ini dibuat untuk keperluan internal Greenfields.