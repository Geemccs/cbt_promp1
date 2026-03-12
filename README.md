# CBT MTsN 1 Mesuji

Aplikasi **Computer-Based Test (CBT)** berbasis web untuk MTsN 1 Mesuji. Dibangun dengan Laravel 12, Tailwind CSS, dan dilengkapi fitur Rich Text Editor, import Excel/Word, Safe Exam Browser (SEB), dan monitoring ujian real-time.

---

## Fitur Utama

| Modul | Deskripsi |
|---|---|
| **Multi-role** | Administrator, Guru, Siswa |
| **Master Data** | Kelas, Mata Pelajaran, Guru, Siswa |
| **Bank Soal** | PG, Essay, Benar/Salah, Menjodohkan |
| **Editor Soal** | Rich Text Editor (contenteditable + toolbar) |
| **Import** | Excel (`.xlsx`) dan Word (`.docx`) |
| **Ruang Ujian** | Token akses, acak soal/jawaban, batas keluar |
| **Monitoring** | Live status peserta ujian (auto-refresh 30 detik) |
| **Exambrowser** | Toggle Safe Exam Browser |
| **Pengumuman** | Pengumuman per kelas atau semua kelas |

---

## Persyaratan Sistem

- PHP >= 8.2
- Composer >= 2.x
- MySQL >= 5.7 atau MariaDB >= 10.3
- Node.js >= 18 (untuk build aset)
- Git

---

## Instalasi

### 1. Clone Repository

```bash
git clone https://github.com/Geemccs/cbt_promp1.git
cd cbt_promp1
```

### 2. Install Dependensi PHP

```bash
composer install
```

### 3. Salin File Konfigurasi

```bash
cp .env.example .env
php artisan key:generate
```

### 4. Konfigurasi Database

Edit file `.env` sesuai konfigurasi MySQL Anda:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=eujian
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Import Database

Buat database bernama `eujian` terlebih dahulu, kemudian import:

```bash
mysql -u root -p eujian < database/eujian.sql
```

Atau jalankan migrasi Laravel:

```bash
php artisan migrate
```

### 6. Install Dependensi Node.js & Build Aset

```bash
npm install
npm run build
```

### 7. Jalankan Aplikasi

```bash
php artisan serve
```

Buka browser: **http://localhost:8000**

---

## Akun Default

Setelah import `database/eujian.sql`:

| Role | Kredensial | Password |
|---|---|---|
| **Admin** | `asminpratama@mtsn1mesuji.sch.id` | `admin123` |
| **Guru** | NIK: `1234567890123456` | `admin123` |
| **Siswa** | NISN: `0123456789` | `admin123` |

> **Penting:** Ganti password default segera setelah login pertama.

---

## Struktur Peran

### Administrator
- Manajemen Kelas, Mapel, Guru, Siswa
- Bank Soal & Editor Soal (Rich Text Editor)
- Ruang Ujian & Monitoring real-time
- Exambrowser, Administrator, Pengumuman

### Guru
- Bank Soal pribadi & Editor Soal (Rich Text Editor)
- Ruang Ujian pribadi & Monitoring real-time
- Import soal dari Excel/Word

### Siswa
- Dashboard & riwayat ujian
- Masuk ujian dengan token
- Tampilan ujian full-screen

---

## Import Soal

### Format Excel (`.xlsx`)

| Kolom | Keterangan |
|---|---|
| `jenis_soal` | `pg`, `essay`, `benar_salah`, atau `menjodohkan` |
| `pertanyaan` | Teks pertanyaan |
| `opsi_a` hingga `opsi_e` | Pilihan jawaban (khusus PG) |
| `jawaban_benar` | Kunci jawaban |

### Format Word (`.docx`)

```
1. Teks pertanyaan
A. Pilihan A
B. Pilihan B
C. Pilihan C
D. Pilihan D
Jawaban: A
```

---

## Paket yang Digunakan

- `laravel/framework` ^12.0
- `maatwebsite/excel` ^3.1 – Import/export Excel
- `phpoffice/phpword` ^1.4 – Import/export Word

---

## Pengembang

Dikembangkan oleh **Asmin Pratama**  
Email: asminpratama@mtsn1mesuji.sch.id  
MTsN 1 Mesuji, Lampung
