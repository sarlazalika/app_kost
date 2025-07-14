# Casa De Sasa

Aplikasi web pengelolaan kost berbasis PHP Native & MySQL dengan tampilan modern, tema feminim soft, dan fitur lengkap.

---

## ✨ Fitur Utama
- Dashboard ringkasan penghuni, kamar, barang, kamar kosong, tagihan, dsb
- CRUD Penghuni, Kamar, Barang
- Validasi form (client & server)
- Login admin & proteksi session
- Logout di semua halaman
- Tampilan responsif, tema feminim modern
- Data dummy siap pakai

---

## 🚀 Cara Instalasi & Menjalankan
1. **Install XAMPP** (https://www.apachefriends.org/)
2. **Copy folder** `app_kost` ke `htdocs` (misal: `D:/xampp/htdocs/app_kost`)
3. **Import database**
   - Buka `phpMyAdmin` (`http://localhost/phpmyadmin`)
   - Buat database baru, misal: `db_kost`
   - Import file SQL yang sudah disediakan (`db_kost.sql` atau sesuai instruksi)
4. **Edit koneksi database** jika perlu (file: `backend/db.php`)
   - Pastikan username, password, dan nama database sesuai XAMPP kamu
5. **Jalankan XAMPP** (start Apache & MySQL)
6. **Akses aplikasi di browser:**
   - `http://localhost/app_kost/backend/login.php` (login admin)
   - Username: `sasa`  |  Password: `12345`
   - Setelah login, akses dashboard dan semua fitur

---

## 📁 Struktur Folder
```
app_kost/
├── backend/
│   ├── dashboard.php
│   ├── db.php
│   ├── login.php
│   ├── logout.php
│   ├── penghuni/
│   ├── kamar/
│   └── barang/
├── assets/
│   ├── theme.css
│   └── house-bg.svg
└── README.md
```

---

## 📝 Catatan
- Semua halaman admin diproteksi login.
- Logout tersedia di semua halaman.
- Data dummy bisa dihapus/diganti sesuai kebutuhan.
- Jika ingin menambah fitur, ikuti struktur folder yang ada.

---

## 👩‍💻 Pengembang
Aplikasi ini dikembangkan untuk tugas kuliah/skripsi, dapat dikembangkan lebih lanjut sesuai kebutuhan.

---

Selamat menggunakan Casa De Sasa! 💖
