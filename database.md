## 🧩 2. Desain Konseptual Database

### Daftar Entitas
| No | Nama Tabel | Deskripsi Singkat |
|----|-------------|------------------|
| 1 | **users** | Menyimpan data pengguna aplikasi Laravel seperti admin, kasir, dan owner |
| 2 | **customers** | Menyimpan data pelanggan salon |
| 3 | **treatments** | Menyimpan data layanan salon (potong rambut, creambath, dll) |
| 4 | **transactions** | Menyimpan data transaksi pelanggan yang dilakukan oleh kasir |
| 5 | **transaction_details** | Menyimpan rincian layanan yang dipesan dalam satu transaksi |
| 6 | **log_pembatalan** | Menyimpan log otomatis ketika transaksi dihapus (melalui trigger) |

---

## 🧠 3. Penjelasan Setiap Tabel

### 3.1 **users**
Digunakan untuk autentikasi pengguna di Laravel dan pengelolaan role.

| Kolom | Tipe Data | Keterangan |
|--------|------------|-------------|
| id | INT (PK) | Primary key pengguna |
| name | VARCHAR(100) | Nama pengguna |
| email | VARCHAR(100) | Email unik untuk login |
| password | VARCHAR(255) | Password terenkripsi |
| role | ENUM('admin', 'kasir', 'owner') | Hak akses pengguna |
| created_at | TIMESTAMP | Waktu dibuat |
| updated_at | TIMESTAMP | Waktu terakhir diperbarui |

**Keterkaitan:**  
`users` berelasi *one-to-many* dengan `transactions` (seorang kasir bisa menangani banyak transaksi).

---

### 3.2 **customers**
Berisi data pelanggan salon.

| Kolom | Tipe Data | Keterangan |
|--------|------------|-------------|
| id | INT (PK) | Primary key pelanggan |
| name | VARCHAR(100) | Nama pelanggan |
| phone | VARCHAR(20) | Nomor telepon pelanggan (opsional) |
| created_at | TIMESTAMP | Waktu dibuat |

**Keterkaitan:**  
`customers` berelasi *one-to-many* dengan `transactions`.

---

### 3.3 **treatments**
Menyimpan daftar layanan yang ditawarkan oleh salon.

| Kolom | Tipe Data | Keterangan |
|--------|------------|-------------|
| id | INT (PK) | Primary key layanan |
| name | VARCHAR(100) | Nama layanan |
| price | DECIMAL(10,2) | Harga layanan |
| duration | INT | Durasi pengerjaan (menit) |
| status | ENUM('active', 'inactive') | Status layanan |
| created_at | TIMESTAMP | Waktu dibuat |
| updated_at | TIMESTAMP | Waktu diperbarui |

**Keterkaitan:**  
`treatments` berelasi *one-to-many* dengan `transaction_details`.

---

### 3.4 **transactions**
Menyimpan data transaksi yang dilakukan oleh pelanggan.

| Kolom | Tipe Data | Keterangan |
|--------|------------|-------------|
| id | INT (PK) | Primary key transaksi |
| customer_id | INT (FK) | Relasi ke `customers` |
| user_id | INT (FK) | Relasi ke `users` (kasir yang memproses) |
| tanggal | DATETIME | Waktu transaksi |
| total_harga | DECIMAL(10,2) | Total harga transaksi |

**Keterkaitan:**  
- *One-to-many* dari `customers` ke `transactions`  
- *One-to-many* dari `users` ke `transactions`  
- *One-to-many* dari `transactions` ke `transaction_details`

---

### 3.5 **transaction_details**
Menampung daftar layanan yang dipesan dalam satu transaksi.

| Kolom | Tipe Data | Keterangan |
|--------|------------|-------------|
| id | INT (PK) | Primary key detail transaksi |
| transaction_id | INT (FK) | Relasi ke `transactions` |
| treatment_id | INT (FK) | Relasi ke `treatments` |
| harga | DECIMAL(10,2) | Harga layanan |
| qty | INT | Jumlah layanan (biasanya 1) |
| subtotal | DECIMAL(10,2) | Total harga per item (harga × qty) |

**Keterkaitan:**  
`transaction_details` menjadi jembatan antara `transactions` dan `treatments`.

---

### 3.6 **log_pembatalan**
Digunakan untuk mencatat transaksi yang dihapus secara otomatis oleh trigger.

| Kolom | Tipe Data | Keterangan |
|--------|------------|-------------|
| id | INT (PK) | Primary key log |
| transaksi_id | INT | ID transaksi yang dihapus |
| alasan | VARCHAR(255) | Keterangan alasan pembatalan |
| deleted_at | TIMESTAMP | Waktu penghapusan (otomatis oleh trigger) |

**Keterkaitan:**  
Berelasi dengan `transactions` secara *indirect* melalui trigger.
