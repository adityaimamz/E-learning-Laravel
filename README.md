# 📚 E-Learning Laravel

Sistem Manajemen Pembelajaran (Learning Management System) berbasis web yang dibangun menggunakan Laravel 10. Platform ini dirancang untuk memfasilitasi proses belajar mengajar secara online dengan fitur-fitur lengkap untuk admin, pengajar, dan siswa.

## 🚀 Fitur Utama

### 👨‍💼 Admin
- **Manajemen Pengguna**: Kelola data admin, pengajar, dan siswa
- **Manajemen Kelas**: Buat dan kelola kelas serta mata pelajaran
- **Import/Export Data**: Import dan export data siswa, pengajar, kelas, dan mata pelajaran via Excel
- **Activity Monitoring**: Pantau aktivitas semua pengguna dalam sistem
- **Survey Management**: Buat dan kelola survey untuk feedback

### 👨‍🏫 Pengajar (Teacher)
- **Manajemen Materi**: Upload dan kelola materi pembelajaran dengan file pendukung (PDF, dokumen, video)
- **Tugas (Assignments)**: 
  - Buat dan kelola tugas untuk siswa
  - Upload file pendukung tugas
  - Review dan beri nilai submission siswa
  - Export nilai tugas ke Excel
- **Ujian (Exams)**:
  - Buat ujian dengan tipe Essay atau Multiple Choice
  - Import soal ujian dari Excel
  - Set waktu mulai, durasi, dan passing grade
  - Koreksi dan nilai jawaban siswa
  - Export nilai ujian ke Excel
- **Diskusi Forum**: Buat topik diskusi untuk interaksi dengan siswa
- **Pengumuman**: Posting pengumuman untuk kelas
- **Rekomendasi**: Share rekomendasi materi tambahan dengan file pendukung
- **Chat**: Komunikasi real-time dengan siswa

### 👨‍🎓 Siswa (Student)
- **Dashboard**: Lihat semua aktivitas dan tugas yang harus dikerjakan
- **Akses Materi**: Baca dan download materi pembelajaran
- **Kerjakan Tugas**: 
  - Submit tugas dengan upload file
  - Lihat nilai dan feedback dari pengajar
- **Ikuti Ujian**:
  - Ujian dengan timer otomatis
  - Support Essay dan Multiple Choice
  - Lihat hasil dan nilai ujian
- **Diskusi Forum**: Baca dan comment di forum diskusi
- **Chat**: Komunikasi dengan pengajar dan siswa lain
- **Survey**: Isi survey yang dibuat oleh admin
- **Rekomendasi**: Akses materi rekomendasi dari pengajar

## 🛠️ Teknologi yang Digunakan

### Backend
- **Laravel 10** - PHP Framework
- **PHP 8.1+** - Programming Language
- **MySQL** - Database
- **Laravel Sanctum** - API Authentication
- **Livewire 3.5** - Real-time Components (Chat, Diskusi)

### Frontend
- **Blade Templates** - Templating Engine
- **Vite** - Asset Bundling
- **Bootstrap/CSS** - Styling
- **JavaScript/Alpine.js** - Interactivity

### Libraries & Packages
- **Maatwebsite Excel** - Import/Export Excel files
- **Laravel Tinker** - Command-line tool
- **Guzzle HTTP** - HTTP Client
- **Laravel Pint** - Code Style Fixer

## 📋 Persyaratan Sistem

- PHP >= 8.1
- Composer
- Node.js & NPM
- MySQL >= 5.7 atau MariaDB >= 10.3
- Web Server (Apache/Nginx)

## 🔧 Instalasi

### 1. Clone Repository
```bash
git clone https://github.com/yourusername/E-learning-Laravel.git
cd E-learning-Laravel
```

### 2. Install Dependencies
```bash
# Install PHP dependencies
composer install

# Install NPM dependencies
npm install
```

### 3. Konfigurasi Environment
```bash
# Copy file .env
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Konfigurasi Database
Edit file `.env` dan sesuaikan konfigurasi database:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=e_learning
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Migrasi Database
```bash
# Jalankan migrasi
php artisan migrate

# (Optional) Seed database dengan data dummy
php artisan db:seed
```

### 6. Link Storage
```bash
php artisan storage:link
```

### 7. Build Assets
```bash
# Development
npm run dev

# Production
npm run build
```

### 8. Jalankan Aplikasi
```bash
# Jalankan development server
php artisan serve
```

Akses aplikasi di `http://localhost:8000`

## 📱 Role & Akses

Sistem memiliki 3 role utama:

1. **Admin** - Full access ke semua fitur sistem
2. **Pengajar** - Akses untuk mengelola pembelajaran di kelas yang diajar
3. **Siswa** - Akses untuk mengikuti pembelajaran di kelas yang diikuti

## 📂 Struktur Database

### Tabel Utama
- `users` - Data pengguna (admin, pengajar, siswa)
- `roles` - Role/peran pengguna
- `kelas` - Data kelas
- `mapels` - Data mata pelajaran
- `kelas_mapels` - Relasi kelas dan mata pelajaran
- `data_siswas` - Data detail siswa
- `materis` - Materi pembelajaran
- `materi_files` - File attachment materi
- `tugas` - Data tugas
- `tugas_files` - File attachment tugas
- `user_tugas` - Submission tugas siswa
- `user_tugas_files` - File submission tugas siswa
- `ujians` - Data ujian
- `soal_ujian_essays` - Soal ujian essay
- `soal_ujian_multiples` - Soal ujian pilihan ganda
- `user_ujians` - Data ujian siswa
- `user_jawabans` - Jawaban ujian siswa
- `diskusis` - Topik diskusi
- `komentars` - Komentar diskusi
- `pengumuman` - Pengumuman
- `rekomendasis` - Rekomendasi materi
- `rekomendasi_files` - File attachment rekomendasi
- `messages` - Pesan chat
- `surveys` - Survey
- `survey_questions` - Pertanyaan survey
- `survey_responses` - Jawaban survey
- `user_commits` - Activity log
- `notifications` - Notifikasi sistem

## 📥 Import/Export

Sistem mendukung import/export data melalui Excel untuk:
- Data Siswa
- Data Pengajar
- Data Kelas
- Data Mata Pelajaran
- Soal Ujian (Essay & Multiple Choice)
- Nilai Tugas
- Nilai Ujian

Template Excel untuk import dapat diunduh dari menu export di masing-masing halaman.

## 🔐 Keamanan

- Authentication menggunakan Laravel built-in authentication
- Authorization dengan middleware custom (admin, pengajar)
- Policy untuk akses control (UserTugasPolicy)
- CSRF Protection
- Password Hashing
- Sanctum untuk API authentication

## 🎨 Fitur Real-time

Menggunakan Livewire untuk fitur real-time:
- **Chat Component** - Real-time messaging
- **Diskusi Component** - Dynamic discussion updates

## 📝 Testing

```bash
# Jalankan test
php artisan test

# Test dengan coverage
php artisan test --coverage
```

## 🤝 Kontribusi

1. Fork repository
2. Buat branch fitur baru (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add some AmazingFeature'`)
4. Push ke branch (`git push origin feature/AmazingFeature`)
5. Buat Pull Request

## 📄 Lisensi

Project ini menggunakan lisensi MIT. Lihat file `LICENSE` untuk detail lebih lanjut.

## 👥 Tim Pengembang

Jika Anda ingin berkontribusi atau memiliki pertanyaan, silakan hubungi tim pengembang.

## 🐛 Bug Report

Jika menemukan bug atau masalah, silakan buat issue di repository ini dengan detail:
- Deskripsi masalah
- Steps to reproduce
- Expected behavior
- Screenshots (jika ada)
- Environment (PHP version, Laravel version, dll)



**Dibuat dengan ❤️ menggunakan Laravel**
