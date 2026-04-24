# J-Store Digital Asset E-Commerce

J-Store adalah platform e-commerce berbasis web untuk penjualan aset digital (Top-up game, PPOB, Akun Premium, dan E-book) dengan fitur unggulan **Guest Checkout**.

## 🚀 Panduan Setup Project (Non-Docker / Local)

Panduan ini ditujukan bagi anggota tim yang menggunakan environment lokal (seperti XAMPP, Laragon, atau PHP & MySQL terinstall langsung).

### 1. Prasyarat Sistem
* **PHP**: ^8.3
* **Composer**: Latest
* **MySQL**: 8.0 atau MariaDB terbaru
* **Node.js & NPM**: Untuk manajemen aset frontend

### 2. Langkah Instalasi
1. **Clone Repository**
   ```bash
   git clone https://github.com/fznnfitrah/e-commers-for-digital-product-RPL.git
   cd e-commers-for-digital-product-RPL
   ```

2. **Install Dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Konfigurasi Environment**
   Salin file `.env.example` menjadi `.env`:
   ```bash
   cp .env.example .env
   ```
   Buka file `.env` dan sesuaikan bagian database:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=j_store
   DB_USERNAME=root
   DB_PASSWORD=
   ```

4. **Generate Key & Migration**
   ```bash
   php artisan key:generate
   php artisan migrate
   ```

5. **Jalankan Aplikasi**
   ```bash
   php artisan serve
   # Di terminal terpisah, jalankan untuk frontend:
   npm run dev
   ```

---

## 🏗️ Struktur Logika Pengembangan

Agar pengembangan fitur berjalan paralel tanpa konflik kode, kita akan mengikuti pola **Service Pattern**. Artinya, Controller hanya bertugas menerima input, sementara logika berat ada di folder `Services`.

### 1. Alur Checkout (Guest vs Member)
Logika ini akan berada di `app/Services/OrderService.php`.
* **Member**: Sistem mengambil data Nama, Email, dan No HP dari database `users`.
* **Guest**: User wajib mengisi form identitas. Data ini disimpan langsung ke tabel `transactions` meskipun `user_id` bernilai `null`.

### 2. Integrasi Payment Gateway (Midtrans)
Logika ini berada di `app/Services/PaymentService.php`.
* Mengirim data transaksi ke Midtrans.
* Mendapatkan `snap_token` untuk menampilkan pop-up pembayaran.
* Menangani **Webhook/Callback** untuk mengubah status pembayaran dari `pending` ke `success`.

### 3. Otomatisasi Pengiriman Produk
Sistem akan menggunakan **Event & Listener** untuk menjaga kode tetap bersih:
* **Event**: `PaymentReceived` dipicu saat status transaksi menjadi `success`.
* **Listener**: `DeliverDigitalAsset` akan:
    1. Mengambil kredensial dari tabel `digital_assets` yang `is_sold = false`.
    2. Menandai aset sebagai `is_sold = true`.
    3. Mengirimkan data kredensial tersebut ke email pembeli via `Mail`.



### 4. Fitur Lacak Pesanan (Track Order)
Fitur publik yang memungkinkan pembeli (terutama Guest) melihat status pesanan tanpa login.
* **Input**: `Transaction ID` + `Customer Email`.
* **Logic**: Mencocokkan kedua data tersebut di tabel `transactions` untuk keamanan data.

---

## 🛠️ Aturan Kolaborasi (Git & DB)

1. **Jangan Edit Database Manual**: Selalu gunakan migrasi (`php artisan make:migration`).
2. **Commit yang Jelas**: Gunakan prefix seperti `feat:` untuk fitur baru, `fix:` untuk perbaikan bug, atau `refactor:` untuk merapikan kode.
3. **Pull Before Push**: Selalu lakukan `git pull origin main` sebelum melakukan push untuk menghindari konflik migrasi.
4. **Environment**: File `.env` dilarang di-push ke GitHub. Gunakan `.env.example` untuk berbagi variabel baru.

---
