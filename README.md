# Toko Online CodeIgniter 4

Proyek ini adalah platform toko online yang dibangun menggunakan [CodeIgniter 4](https://codeigniter.com/). Sistem ini menyediakan beberapa fungsionalitas untuk toko online, termasuk manajemen produk, keranjang belanja, dan sistem transaksi.

## Daftar Isi

- [Fitur](#fitur)
- [Persyaratan Sistem](#persyaratan-sistem)
- [Instalasi](#instalasi)
- [Struktur Proyek](#struktur-proyek)

## Fitur

- Katalog Produk
  - Menampilkan daftar produk lengkap dengan gambar, harga, dan diskon.
  - Harga otomatis menyesuaikan jika ada potongan dari sistem diskon.
  - Tampilan produk menggunakan template UI responsif (NiceAdmin).
- Keranjang Belanja
  - Tambah produk ke keranjang dari halaman home.
  - Update jumlah produk dalam keranjang.
  - Hapus produk dari keranjang.
  - Kosongkan seluruh isi keranjang.
  - Keranjang disimpan menggunakan session.
- Sistem Transaksi & Checkout
  - Form checkout yang menampilkan alamat pengiriman dan ongkos kirim.
  - Perhitungan ongkos kirim menggunakan API pihak ketiga (RajaOngkir Komerce).
  - Riwayat pembelian dapat dilihat oleh pengguna di halaman profil.
  - Detail pembelian ditampilkan dalam modal per transaksi.
- Diskon Produk
  - Admin dapat mengatur besar potongan harga untuk semua produk.
  - Diskon disimpan ke session dan otomatis diterapkan pada harga.
- Sistem Autentikasi
  - Halaman login pengguna (user & admin).
  - Sistem login menggunakan session.
- Panel Admin
  - Kelola produk (tambah, edit, hapus) dengan gambar.
  - Kelola diskon (CRUD).
  - Export data produk ke PDF dengan DomPDF.
- API Integrasi
  - API get-location & get-cost terhubung ke RajaOngkir.
- Responsif
  - Antarmuka frontend dan admin responsif berkat penggunaan template NiceAdmin.
- Lain-lain
  - Notifikasi flashdata untuk semua aksi (tambah ke keranjang, checkout, hapus produk, dll).

## Persyaratan Sistem

- PHP >= 8.2
- Composer
- Web server (disarankan XAMPP atau Laragon)
- Ekstensi PHP:
  - intl (untuk fungsi number_to_currency)
  - curl (untuk API HTTP client)
  - fileinfo (untuk upload gambar)

## Instalasi

1. **Clone repository ini**
   ```bash
   git clone [URL repository]
   cd belajar-ci-tugas
   ```
2. **Install dependensi**
   ```bash
   composer install
   ```
3. **Konfigurasi database**

   - Start module Apache dan MySQL pada XAMPP
   - Buat database **db_ci4** di phpmyadmin.
   - copy file .env dari tutorial https://www.notion.so/april-ns/Codeigniter4-Migration-dan-Seeding-045ffe5f44904e5c88633b2deae724d2

4. **Jalankan migrasi database**
   ```bash
   php spark migrate
   ```
5. **Seeder data**
   ```bash
   php spark db:seed ProductSeeder
   ```
   ```bash
   php spark db:seed UserSeeder
   ```
6. **Jalankan server**
   ```bash
   php spark serve
   ```
7. **Akses aplikasi**
   Buka browser dan akses `http://localhost:8080` untuk melihat aplikasi.

## Struktur Proyek
Proyek menggunakan struktur standar MVC dari CodeIgniter 4.

- app/
  - Controllers/
    - Home.php – Halaman utama, diskon, profil.
    - AuthController.php – Login & logout pengguna.
    - ProdukController.php – Manajemen produk (CRUD, PDF).
    - TransaksiController.php – Proses keranjang, checkout, ongkir, dan transaksi.
    - DiskonController.php – CRUD diskon potongan harga.
  - Models/
    - ProductModel.php – Data produk.
    - TransactionModel.php – Data transaksi utama.
    - TransactionDetailModel.php – Detail barang dalam transaksi.
    - UserModel.php – Data akun pengguna.
  - Views/
    - v_produk.php – Tampilan katalog produk.
    - v_keranjang.php – Tampilan isi keranjang belanja.
    - v_checkout.php – Formulir checkout transaksi.
    - v_profile.php – Riwayat transaksi pembelian pengguna.
    - v_login.php – Halaman login.
    - v_diskon.php – Kelola diskon untuk admin.
    - v_produkPDF.php – Template untuk export PDF.
    - layout.php – Template utama (menggunakan NiceAdmin).
  - Filters/
    - Auth.php – Filter otentikasi login.
    - Redirect.php – Filter redirect berdasarkan session.
  - Config/
    - Routes.php – Semua route halaman dan aksi API.
- public/
  - img/ – Folder upload gambar produk.
  - NiceAdmin/ – Template admin (Bootstrap-based).
  - index.php – Entry point aplikasi.
- writable/
  - logs/ – Tempat penyimpanan log error.
  - session/ – File session PHP.