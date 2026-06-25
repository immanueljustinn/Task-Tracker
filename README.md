# Task Tracker Sederhana 📝

Aplikasi manajemen tugas (To-Do List) yang simpel dan cepat. Dibangun menggunakan Laravel untuk backend, SQLite sebagai database ringan tanpa setup server, dan Tailwind CSS v4 untuk tampilan UI yang modern. Project ini juga menerapkan Vanilla JavaScript (Fetch API) agar pengguna bisa mencentang status tugas secara dinamis tanpa perlu me-reload halaman.

## ✨ Fitur

* **Tambah Tugas:** Menulis dan menyimpan daftar pekerjaan baru.
* **Hapus Tugas:** Menghapus tugas yang sudah tidak relevan.
* **Toggle Status (AJAX):** Menandai tugas sebagai "Selesai" atau "Belum Selesai" secara *real-time* tanpa *refresh* halaman.

## 🛠️ Teknologi yang Digunakan

* **Framework:** Laravel 11
* **Database:** SQLite
* **Styling:** Tailwind CSS v4 (Bawaan Laravel)
* **Scripting:** Vanilla JavaScript (Fetch API)

## 🚀 Cara Menjalankan Project di Lokal

Jika kamu ingin menjalankan project ini di komputermu sendiri, pastikan kamu sudah menginstal **PHP**, **Composer**, dan **Node.js**. Lalu, ikuti langkah-langkah berikut:

### 1. Clone Repository
Buka terminal dan jalankan perintah berikut untuk mengunduh kode:
```bash
git clone [https://github.com/immanueljustinn/Task-Tracker.git](https://github.com/immanueljustinn/Task-Tracker.git)
cd task-tracker-laravel
```

### 2. Install Dependensi
Install semua package bawaan Laravel dan Node.js:
```bash
composer install
npm install
```

### 3. Konfigurasi Environment (Database)
Salin file `.env.example` menjadi `.env`:
```bash
cp .env.example .env
```
Buka file `.env` tersebut dan pastikan koneksi database diatur menggunakan SQLite (hapus konfigurasi DB_HOST dan lainnya jika ada):
```env
DB_CONNECTION=sqlite
```

### 4. Generate Key & Migrasi Database
Buat kunci aplikasi dan jalankan migrasi tabel ke database:
```bash
php artisan key:generate
php artisan migrate
```
*(Catatan: Jika muncul pertanyaan untuk membuat file database.sqlite yang baru, ketik yes atau tekan Enter).*

### 5. Jalankan Aplikasi
Buka dua tab terminal, lalu jalankan masing-masing perintah ini:

**Terminal 1 (Untuk kompilasi CSS/JS):**
```bash
npm run dev
```

**Terminal 2 (Untuk menjalankan server PHP):**
```bash
php artisan serve
```

Aplikasi sekarang sudah berjalan! Buka browser dan kunjungi: **http://localhost:8000**