# Petunjuk untuk agen

## Alur kerja task

- Untuk setiap task yang diminta, selesaikan perubahan yang diminta, tinjau diff, lalu buat **commit Git dan push ke remote** sebelum melaporkan task selesai.
- Buat commit yang fokus pada task saat ini dengan pesan singkat dan jelas.
- Push branch yang sedang dikerjakan ke remote yang sesuai. Jika push gagal karena masalah autentikasi, jaringan, branch, atau kebijakan remote, jangan mengklaim task sudah dipush; laporkan hambatan dan commit yang sudah dibuat.
- Jangan memasukkan perubahan pengguna yang tidak terkait ke dalam commit. Periksa `git status` dan diff sebelum staging; stage hanya file yang menjadi bagian task.
- Jangan melakukan force push atau menulis ulang riwayat remote kecuali diminta secara eksplisit.
- Jika tidak ada perubahan file yang perlu disimpan, jangan membuat commit kosong; jelaskan alasannya.

## Sebelum mengubah kode

- Baca petunjuk `AGENTS.md` yang berlaku di direktori terkait.
- Ikuti pola dan versi yang sudah digunakan project.
- Jangan menambahkan atau menjalankan tes kecuali task meminta verifikasi/tes; bila diminta, laporkan perintah dan hasilnya.
- Jangan pernah menampilkan isi rahasia dari `.env`, kredensial, atau file konfigurasi sensitif.
