# 🌱 HIDROPONIK BAGUS

**HIDROPONIK BAGUS (Biointelligent AI-driven Growth & Urban Farming System)** adalah sistem berbasis web yang mengintegrasikan **aplikasi monitoring hidroponik dengan teknologi Computer Vision berbasis YOLOv8** untuk membantu mengidentifikasi penyakit pada tanaman **lettuce (selada)**.

Sistem ini terdiri dari dua komponen utama:

1. **Web Application** — dibangun menggunakan Laravel untuk menyediakan antarmuka pengguna dan pengelolaan sistem hidroponik.
2. **AI Backend** — dibangun menggunakan Python dan YOLOv8 untuk melakukan analisis gambar dan klasifikasi penyakit pada lettuce.

Selain menggunakan model YOLOv8, sistem menerapkan pendekatan tambahan berupa **cropped image** sebagai bagian dari preprocessing gambar sebelum dilakukan klasifikasi.

---

# 📌 Project Overview

HIDROPONIK BAGUS dikembangkan sebagai sistem yang menggabungkan **hydroponic management** dan **AI-based plant disease classification** dalam satu platform.

Secara umum, alur sistem adalah:

```text
                    USER
                      │
                      ▼
              Laravel Web App
                      │
                      │ Image / Request
                      ▼
                AI Backend
                  Python
                      │
                      ▼
                 YOLOv8
                      │
              Image Processing
                      │
                Cropped Image
                      │
                      ▼
             Disease Classification
                      │
                      ▼
                AI Prediction
                      │
                      ▼
                Laravel Web App
                      │
                      ▼
               Result Display
```

Sistem memungkinkan pengguna berinteraksi dengan aplikasi melalui web, sementara proses analisis penyakit tanaman dilakukan oleh backend AI.

---

# 🤖 Artificial Intelligence

## YOLOv8

Bagian AI pada project ini menggunakan **YOLOv8** sebagai model Computer Vision.

YOLOv8 digunakan untuk melakukan analisis terhadap gambar tanaman lettuce dan mengklasifikasikan kondisi penyakit berdasarkan model yang telah dilatih.

Model dikembangkan menggunakan dataset gambar lettuce yang memiliki beberapa kategori kondisi/penyakit.

### Model

Model AI disimpan pada folder:

```text
backend_ai/
├── best_final.pt
├── best_lettuce_disease_model_final.pth
└── main.py
```

File model utama yang digunakan dalam proses inference berada di dalam folder `backend_ai`.

---

# 🔬 Cropped Image Method

Selain menggunakan model YOLOv8 secara langsung, project ini menggunakan pendekatan tambahan berupa **cropped image**.

Tujuan pendekatan ini adalah untuk memfokuskan model terhadap **bagian tanaman yang relevan**, terutama area daun lettuce yang menjadi objek analisis.

Secara sederhana, prosesnya:

```text
Original Image
      │
      ▼
Image Preprocessing
      │
      ▼
Crop Relevant Area
      │
      ▼
Cropped Image
      │
      ▼
YOLOv8
      │
      ▼
Disease Classification
      │
      ▼
Prediction Result
```

Pendekatan cropping digunakan untuk mengurangi bagian gambar yang tidak relevan sehingga model dapat lebih fokus terhadap karakteristik visual yang berkaitan dengan penyakit tanaman.

---

# 🧠 AI Pipeline

Pipeline AI pada sistem secara umum terdiri dari beberapa tahap:

### 1. Image Input

Pengguna memberikan gambar lettuce melalui aplikasi.

```text
User → Image Upload
```

### 2. Image Preprocessing

Gambar diproses sebelum diberikan kepada model.

Salah satu metode yang digunakan adalah **cropped image**, yaitu mengambil area gambar yang relevan untuk analisis.

### 3. YOLOv8 Inference

Cropped image kemudian diberikan kepada model YOLOv8 yang telah dilatih.

```text
Cropped Image
      ↓
YOLOv8 Model
      ↓
Prediction
```

### 4. Disease Classification

Model menghasilkan prediksi mengenai kondisi atau penyakit lettuce berdasarkan kelas yang tersedia pada dataset training.

### 5. Result

Hasil prediksi kemudian dikembalikan ke aplikasi untuk ditampilkan kepada pengguna.

---

# 🖥️ Web Application

Komponen web application berada pada:

```text
hidroponik_project-main/
```

Aplikasi web dibangun menggunakan **Laravel**.

Laravel bertanggung jawab terhadap:

* User interface
* Routing
* Request handling
* Pengelolaan data
* Integrasi dengan backend AI
* Penyajian hasil prediksi
* Pengelolaan fitur hidroponik

---

# 🏗️ System Architecture

Secara keseluruhan, sistem terdiri dari:

```text
┌──────────────────────────┐
│          USER            │
└────────────┬─────────────┘
             │
             ▼
┌──────────────────────────┐
│     Laravel Web App      │
│                          │
│  hidroponik_project-main │
└────────────┬─────────────┘
             │
             │ Image / API Request
             ▼
┌──────────────────────────┐
│       AI Backend         │
│                          │
│       Python             │
│        main.py           │
└────────────┬─────────────┘
             │
             ▼
┌──────────────────────────┐
│        YOLOv8            │
│                          │
│ Lettuce Disease Model    │
└────────────┬─────────────┘
             │
             ▼
┌──────────────────────────┐
│    Disease Prediction    │
└────────────┬─────────────┘
             │
             ▼
┌──────────────────────────┐
│     Laravel Web App      │
│                          │
│     Display Result       │
└──────────────────────────┘
```

Dengan arsitektur tersebut, **Laravel tidak menjalankan model AI secara langsung sebagai bagian dari frontend**. Proses AI dipisahkan ke dalam backend Python sehingga komponen AI dan web dapat dikembangkan secara lebih modular.

---

# 📂 Project Structure

```text
bagus_v2/
│
├── backend_ai/
│   ├── __pycache__/
│   ├── best_final.pt
│   ├── best_lettuce_disease_model_final.pth
│   └── main.py
│
└── hidroponik_project-main/
    ├── app/
    ├── bootstrap/
    ├── config/
    ├── database/
    ├── lang/
    ├── public/
    ├── resources/
    ├── routes/
    ├── storage/
    ├── tests/
    ├── vendor/
    │
    ├── .env
    ├── .env.example
    ├── .gitignore
    ├── artisan
    ├── composer.json
    ├── composer.lock
    ├── package.json
    ├── phpunit.xml
    ├── README.md
    └── vite.config.js
```

---

# 🛠️ Technologies

## Web Application

* **Laravel**
* **PHP**
* **HTML**
* **CSS**
* **JavaScript**
* **Vite**

## Artificial Intelligence

* **Python**
* **YOLOv8**
* **Computer Vision**
* **Image Cropping / Preprocessing**
* **Deep Learning**

## Development Tools

* **Git**
* **GitHub**
* **Visual Studio Code**

---


# 🔗 Integration Between Laravel and AI

Laravel berfungsi sebagai aplikasi utama yang menangani interaksi pengguna, sedangkan Python menangani proses inference AI.

Secara konsep:

```text
Laravel
   │
   │ HTTP Request
   │
   ▼
Python AI Backend
   │
   ▼
YOLOv8
   │
   ▼
Prediction
   │
   ▼
Python AI Backend
   │
   │ Response
   ▼
Laravel
   │
   ▼
User
```

Pemisahan ini memungkinkan model AI dikembangkan atau diperbarui tanpa harus mengubah keseluruhan aplikasi Laravel.

---

# 📊 AI Model

Model dilatih untuk mengenali penyakit pada tanaman lettuce berdasarkan karakteristik visual pada gambar.

Model yang tersedia pada project:

```text
backend_ai/
├── best_final.pt
└── best_lettuce_disease_model_final.pth
```

Model tersebut digunakan sebagai bagian dari pipeline AI untuk menghasilkan prediksi kondisi tanaman.

---

# 🎯 Objectives

Project ini memiliki beberapa tujuan utama:

* Mengembangkan sistem digital untuk pengelolaan hidroponik.
* Mengimplementasikan Computer Vision pada bidang pertanian.
* Menggunakan YOLOv8 untuk klasifikasi penyakit lettuce.
* Menguji penggunaan **cropped image** sebagai metode preprocessing tambahan.
* Mengintegrasikan AI dengan aplikasi web Laravel.
* Membuat sistem yang dapat membantu pengguna dalam mengidentifikasi kondisi tanaman berdasarkan gambar.

---

# 🔮 Future Development

Pengembangan selanjutnya dapat mencakup:

* [ ] Real-time disease detection
* [ ] Peningkatan dataset
* [ ] Data augmentation
* [ ] Evaluasi performa model menggunakan precision, recall, mAP, dan confusion matrix
* [ ] Perbandingan performa dengan dan tanpa cropped image
* [ ] Peningkatan akurasi model
* [ ] Monitoring kondisi hidroponik secara real-time
* [ ] Integrasi sensor IoT
* [ ] Monitoring pH
* [ ] Monitoring TDS
* [ ] Monitoring suhu dan kelembapan
* [ ] Sistem notifikasi penyakit tanaman
* [ ] Penyimpanan riwayat hasil prediksi
* [ ] Deployment AI backend
* [ ] Deployment web application

---

# 📈 Research / AI Development

Salah satu fokus pengembangan project adalah mengevaluasi bagaimana **cropped image** dapat digunakan sebagai preprocessing tambahan dalam klasifikasi penyakit lettuce.

Konsep evaluasinya:

```text
                 Dataset
                    │
          ┌─────────┴─────────┐
          │                   │
          ▼                   ▼
     Original Image      Cropped Image
          │                   │
          ▼                   ▼
       YOLOv8              YOLOv8
          │                   │
          ▼                   ▼
     Prediction            Prediction
          │                   │
          └─────────┬─────────┘
                    ▼
             Performance
              Comparison
```



## 👥 Contributors

Project **HIDROPONIK BAGUS** dikembangkan sebagai project pengembangan aplikasi dan teknologi hidroponik.

### Development Team
* **Carrren Jolina**
* **Dimas Aulia**
* **Elora Nikita**
* **Michael Vincent**

---

## 📄 License

Project ini dibuat untuk keperluan pembelajaran dan pengembangan aplikasi.

---

<p align="center">
  🌱 <strong>HIDROPONIK BAGUS</strong> 🌱
  <br>
  <i>Technology for Better Hydroponic Management</i>
</p>


</p>
