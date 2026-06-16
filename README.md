# Laravel Inventory Services

Aplikasi inventory berbasis Laravel dengan 3 service di Docker Compose:

- `pencatatan`: pencatatan master barang dan mutasi stok.
- `laporan`: cetak laporan stok dan mutasi.
- `notif`: notifikasi dan komunikasi internal.

Stack:

- Laravel
- PostgreSQL Neon.tech
- Docker Compose
- Traefik

## Menjalankan

1. Salin file environment:

```bash
cp .env.example .env
```

2. Isi koneksi Neon.tech di `.env`.

Format paling mudah:

```env
DATABASE_URL=postgresql://USER:PASSWORD@HOST.neon.tech/DBNAME?sslmode=require
```

3. Build dan jalankan:

```bash
docker compose up --build
```

4. Generate `APP_KEY`, masukkan nilainya ke file `.env`, lalu migrasi:

```bash
docker compose run --rm pencatatan php artisan key:generate --show
docker compose exec pencatatan php artisan migrate
```

5. Buka service:

- Pencatatan: `http://pencatatan.localhost`
- Cetak laporan: `http://laporan.localhost`
- Notif dan komunikasi: `http://notif.localhost`

## Catatan Neon.tech

Pastikan project Neon mengizinkan koneksi dari container dan gunakan `sslmode=require`.
Jika memakai connection pooling Neon, pakai host pooler yang diberikan Neon.
