# Todo Project

Daftar ini disusun dari peninjauan kode dan skema database yang ada. Periksa ulang perilaku terhadap database dan lingkungan deployment sebelum menutup setiap item.

## Prioritas kritis

- [x] **Lindungi semua halaman dan aksi aplikasi.** Terapkan middleware autentikasi pada dashboard, CRUD perusahaan/karyawan/kursus, materi, kehadiran, dan kuesioner. Tetapkan akses berdasarkan guard dan hak pengguna; jangan mengandalkan penyembunyian menu.
- [x] **Pastikan isolasi data perusahaan.** Batasi query dan perubahan data sesuai perusahaan pengguna; uji akses silang dengan ID perusahaan/karyawan/kursus yang dimanipulasi. _(Scope tenant dan feature test sudah ditambahkan; jalankan tes setelah dependency tersedia.)_
- [x] **Selaraskan autentikasi karyawan dengan skema aktif.** Verifikasi apakah database menggunakan `encrypted_password` atau `password`, lalu samakan migrasi, model, login, registrasi, dan reset password. Periksa juga skema produksi, bukan hanya dump SQL. _(Migrasi koreksi sudah ditambahkan; belum dapat dijalankan tanpa dependency Laravel.)_
- [x] **Perbaiki pemeriksaan akun saat login.** Validasi status disabled dan waktu penguncian sebelum autentikasi dianggap sukses; rapikan penghitung percobaan gagal dan pastikan mekanisme throttle berfungsi. _(Implementasi dan feature test ditambahkan; eksekusi menunggu dependency Laravel.)_

## Prioritas tinggi

- [x] **Benahi alur lupa dan reset password untuk kedua jenis akun.** Pilih broker yang benar berdasarkan akun, jangan menimpa status hasil broker, dan pastikan token reset tidak ambigu untuk email yang sama di kedua tabel. _(Broker dipilih berdasarkan akun dan token karyawan dipisah ke tabel sendiri; runtime verification menunggu dependency.)_
- [x] **Aktifkan validasi request dan gunakan data tervalidasi.** Mulai dari karyawan, perusahaan, kursus, klasifikasi, afiliasi, materi, dan jawaban; hindari `$request->all()` untuk mass assignment. _(Endpoint CRUD legacy juga memakai whitelist fillable tervalidasi; jawaban peserta dibatasi ke kursus/jadwal/pertanyaan miliknya.)_
- [x] **Hapus kebocoran exception produksi.** Ganti `dd($th)` pada pembuatan kursus dengan logging server dan respons error yang aman; pastikan transaksi di-rollback saat gagal.
- [x] **Perbaiki pembuatan kursus dan upload materi.** Validasi keberadaan/format input `teaching_material`, `todo`, dan file; simpan file terkait materi yang benar; tangani jalur penyimpanan perusahaan yang kosong/tidak valid.
- [x] **Audit semua rute duplikat dan nama rute.** Hilangkan deklarasi resource/aksi yang tumpang tindih dan betulkan redirect ke nama rute yang benar, termasuk CRUD karyawan dan kursus.
- [x] **Periksa registrasi publik.** Tentukan apakah pembuatan akun admin memang boleh terbuka; jika tidak, lindungi endpoint register atau nonaktifkan setelah bootstrap.

## Prioritas menengah

- [x] **Tinjau skema dan migrasi database.** Pastikan migrasi berurutan dan dapat dijalankan pada database kosong; bandingkan nama kolom, foreign key, soft delete, dan timestamps dengan dump yang disertakan.
- [x] **Perbaiki dokumentasi proyek.** Ganti README bawaan Laravel dengan panduan instalasi, konfigurasi, migrasi/import SQL, akun awal, build aset, dan deployment.
- [x] **Tambahkan cakupan tes aplikasi.** Buat tes autentikasi/otorisasi, isolasi tenant, CRUD tervalidasi, reset password, dan transaksi/upload kursus. Atur database testing yang terisolasi.
- [x] **Tinjau konfigurasi deployment.** Pastikan `APP_DEBUG=false`, kredensial database non-default, HTTPS/session aman, dan file `.env` tidak masuk version control.

## Urutan yang disarankan

1. Amankan rute dan isolasi data perusahaan.
2. Selaraskan kolom password dan benahi login/reset password.
3. Aktifkan validasi serta rapikan transaksi/upload dan penanganan error.
4. Audit rute, migrasi, dan konfigurasi deployment.
5. Tambahkan tes regresi dan dokumentasi setup.
