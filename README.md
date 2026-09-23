# HIDROPONIK BAGUS

**HIDROPONIK BAGUS (Biointelligent AI-driven Growth & Urban Farming System)** adalah sistem berbasis web yang mengintegrasikan monitoring hidroponik dengan Computer Vision berbasis YOLOv8 untuk membantu mengidentifikasi penyakit pada tanaman lettuce (selada).

Sistem terdiri dari dua komponen utama:

1. **Web Application** (`hidroponik_project-main/`) — dibangun dengan Laravel, menangani antarmuka pengguna, autentikasi, pengelolaan data hidroponik, dan penyajian hasil prediksi.
2. **AI Backend** (`backend_ai/`) — layanan FastAPI berbasis Python yang menjalankan pipeline deteksi + klasifikasi penyakit lettuce.

---

## Arsitektur Sistem

```
USER
  │
  ▼
Laravel Web App (port 8001)
  │  HTTP request (gambar)
  ▼
AI Backend — FastAPI (port 8000)
  │
  ▼
YOLOv8 (deteksi daun, crop area relevan)
  │
  ▼
EfficientNet-B0 classifier (klasifikasi penyakit dari hasil crop)
  │
  ▼
Prediction JSON
  │
  ▼
Laravel Web App → ditampilkan ke user
```

Laravel tidak menjalankan model AI secara langsung; proses inference dipisahkan ke backend Python agar kedua komponen bisa dikembangkan secara independen.

---

## AI Pipeline

Pipeline deteksi penyakit lettuce (`backend_ai/main.py`) bekerja dua tahap:

1. **Deteksi (YOLOv8, `best_final.pt`)** — mendeteksi bounding box daun pada gambar yang diunggah, lalu mengambil box dengan confidence tertinggi. Jika tidak ada daun terdeteksi, seluruh gambar tetap diklasifikasi.
2. **Klasifikasi (EfficientNet-B0, `best_lettuce_disease_model_final.pth`)** — hasil crop dari tahap 1 diklasifikasikan ke salah satu dari 7 kelas:
   - Bacterial
   - Downy mildew
   - Powdery mildew
   - Septoria blight
   - Viral
   - Wilt and leaf blight
   - Healthy

Endpoint utama: `POST /predict` (menerima file gambar, mengembalikan kelas penyakit, confidence, dan probabilitas semua kelas).

Pendekatan crop-before-classify ini digunakan untuk mengurangi noise dari bagian gambar yang tidak relevan, sehingga classifier lebih fokus pada karakteristik visual daun.

---

## Struktur Proyek

```
hidroponik_bagus/
├── backend_ai/
│   ├── best_final.pt                        # YOLOv8 detector weights
│   ├── best_lettuce_disease_model_final.pth # EfficientNet-B0 classifier weights
│   ├── main.py                              # FastAPI service
│   └── requirements.txt
│
├── hidroponik_project-main/                 # Laravel web app
│   ├── app/
│   ├── config/
│   ├── database/
│   ├── resources/
│   ├── routes/
│   └── ...
│
├── start-dev.bat                            # Starts MySQL, AI backend, Laravel, scheduler
└── stop-dev.bat                             # Stops all of the above
```

---

## Menjalankan Secara Lokal (Windows)

Prasyarat:
- XAMPP (untuk MySQL/MariaDB) — database `hidroponik`, user `hidroponik`
- PHP 8.3 (path di skrip: `C:\php83\php.exe` — sesuaikan jika berbeda)
- Python 3.x dengan virtualenv terisi di `backend_ai/venv/` (`pip install -r backend_ai/requirements.txt`)
- Konfigurasi Firebase untuk logging data sensor (dipakai oleh Laravel scheduler)

Langkah:

1. Salin `hidroponik_project-main/.env.example` ke `.env` dan isi kredensial database Anda.
2. Isi `FIREBASE_SENSOR_URL` di `.env` dengan URL Firebase Realtime Database Anda (dipakai oleh scheduler untuk mengambil data sensor). `AI_SERVICE_URL` bisa dibiarkan default (`http://127.0.0.1:8000`) jika AI backend dijalankan secara lokal.
3. Jalankan `start-dev.bat` dari root proyek. Ini akan:
   - Menyalakan MySQL (XAMPP) jika belum berjalan
   - Menyalakan AI backend di `http://127.0.0.1:8000` (FastAPI + YOLOv8, butuh ~20 detik untuk memuat model)
   - Menyalakan Laravel di `http://127.0.0.1:8001`
   - Menyalakan Laravel scheduler (mencatat data sensor dari Firebase setiap 1 menit — interval bisa diubah di `app/Console/Kernel.php`)
4. Untuk menghentikan semua service, jalankan `stop-dev.bat`.

phpMyAdmin (jika Apache XAMPP aktif): `http://localhost/phpmyadmin`

---

## Teknologi

**Web Application:** Laravel, PHP, HTML, CSS, JavaScript, Vite

**Artificial Intelligence:** Python, FastAPI, YOLOv8 (Ultralytics), PyTorch/torchvision (EfficientNet-B0)

**Tools:** Git, GitHub, Visual Studio Code, XAMPP

---

## Status Pengembangan

Sudah berjalan:
- Deteksi + klasifikasi penyakit lettuce end-to-end (upload gambar → hasil prediksi)
- Logging data sensor hidroponik (Firebase) ke database via scheduler

Belum dikerjakan / rencana ke depan:
- Real-time disease detection
- Perluasan dataset dan data augmentation
- Evaluasi performa model (precision, recall, mAP, confusion matrix)
- Perbandingan performa dengan vs. tanpa cropped image
- Sistem notifikasi penyakit tanaman
- Penyimpanan riwayat hasil prediksi
- Deployment AI backend dan web application

---

## Kontributor

- Carrren Jolina
- Dimas Aulia
- Elora Nikita
- Michael Vincent

---

## Lisensi

Proyek ini dibuat untuk keperluan pembelajaran dan pengembangan aplikasi.
