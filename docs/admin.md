# Admin Undangan

Halaman admin tersedia di `/admin`. Halaman **Konten undangan** ada di `/admin/settings`, sedangkan pengelolaan foto ada di `/admin/photos`. Login menggunakan user Laravel yang tersimpan di tabel `users`. Tidak ada pendaftaran admin publik.

## Membuat akun admin pertama

Di server, dari direktori aplikasi, jalankan:

```bash
php artisan admin:create-user
```

Masukkan nama, email, lalu password minimal 12 karakter. Password diminta secara tersembunyi dan disimpan dengan hash Laravel.

## Fitur

- Membuat undangan dengan nama, nomor WhatsApp, dan batas jumlah tamu.
- Menampilkan tautan personal dengan format `/?inv=...`.
- Mencari undangan berdasarkan nama atau nomor telepon.
- Melihat status RSVP serta menghapus undangan. RSVP terkait ikut terhapus.
- Melihat RSVP, memfilter status kehadiran, serta menyimpan atau memperbarui balasan pemilik.
- Melihat ringkasan total undangan, RSVP, jumlah yang hadir, dan undangan yang belum merespons.
- Mengubah judul, nama dan detail mempelai, jadwal akad/resepsi, lokasi, alamat, link peta, serta daftar acara melalui tombol **Ubah konten undangan**.
- Mengunggah, mengganti, menghapus, memberi keterangan, dan mengatur urutan foto galeri; mengelola foto mempelai wanita, mempelai pria, cerita pasangan, halaman pembuka, dan penutup. Foto apa pun dapat di-crop sebelum disimpan.

Pengaturan konten disimpan pada tabel `invitation_settings`. Jalankan migrasi database saat deploy:

```bash
php artisan migrate --force
```

Foto awal halaman disalin ke tabel `invitation_photos` oleh migrasi, lalu dikelola dari `/admin/photos`. Upload baru menggunakan public storage; siapkan URL storage satu kali pada setiap environment:

```bash
php artisan storage:link
```

Semua perubahan data memakai session login Laravel dan proteksi CSRF. Pastikan `APP_URL` di production mengarah ke domain undangan yang benar agar link yang dibuat admin memakai host yang benar.
