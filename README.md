# 📚 Sistem Informasi Perpustakaan

Sistem Informasi Perpustakaan adalah aplikasi web yang dibangun menggunakan framework **PHP CodeIgniter**, dirancang untuk memudahkan pengelolaan perpustakaan secara digital.

---

## 🚀 Fitur Utama

- 🔐 **Login Multi Role**  
  Mendukung login dengan 2 jenis akun:
  - **Admin**: Akses penuh (CRUD semua data).
  - **Petugas**: Hanya dapat melayani peminjaman dan pengembalian buku.

- 📚 **Manajemen Data Perpustakaan**
  - Buku
  - Anggota
  - Kategori
  - Peminjaman
  - Pengembalian

- 🔔 **Notifikasi**
  - Admin dapat mengirim notifikasi ke seluruh petugas.

- 📊 **Dashboard Ringkas**
  - Menampilkan statistik jumlah buku, anggota, peminjaman aktif, dll.

---

## 💻 Teknologi yang Digunakan

- [PHP](https://www.php.net/)
- [CodeIgniter 3](https://codeigniter.com/)
- [MySQL](https://www.mysql.com/)
- HTML5, CSS3, Bootstrap
- jQuery, DataTables

---

## 📂 Struktur Folder Penting
- application/
- ├── controllers/
- ├── models/
- ├── views/
- ├── config/
- assets/
- ├── css/
- ├── js/
- ├── images/


---

## ⚙️ Cara Instalasi

1. **Clone repository ini:**

    ```bash
    git clone https://github.com/tohasyafingi/perpustakaan.git
    ```

2. **Import file database** (`.sql`) ke dalam MySQL (via phpMyAdmin atau CLI).

3. **Konfigurasikan file** `application/config/database.php`:

    ```php
    $db['default'] = array(
        'hostname' => 'localhost',
        'username' => 'root',
        'password' => '',
        'database' => 'perpustakaan',
        'dbdriver' => 'mysqli',
        ...
    );
    ```

4. **Akses aplikasi via browser:**

    ```
    http://localhost/perpustakaan
    ```

---

## 🔐 Akun Login

| Role    | Username | Password |
|---------|----------|----------|
| Admin   | admin    | admin    |
| Petugas | petugas  | 123      |

---

## ☕ Dukung Proyek Ini

Jika kamu merasa aplikasi ini bermanfaat, kamu bisa memberi dukungan melalui Saweria:

[![Saweria](https://img.shields.io/badge/Donasi%20di-Saweria-orange?logo=buymeacoffee&style=flat-square)](https://saweria.co/tohasyafingi)

📌 Link: [https://saweria.co/tohasyafingi](https://saweria.co/tohasyafingi)

---

## 📄 Lisensi

Proyek ini dirilis dengan lisensi **MIT**.  
Silakan digunakan, dimodifikasi, dan dikembangkan sesuai kebutuhan.

---

## 🙋‍♂️ Kontribusi

Pull request sangat terbuka untuk fitur, perbaikan bug, atau peningkatan performa.  
Pastikan kode yang diajukan bersih dan terdokumentasi dengan baik.

---