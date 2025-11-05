# 🗄️ Database Documentation - SmartSalon Application

## 🧩 1. Desain Konseptual Database

### Daftar Entitas
| No | Nama Tabel | Deskripsi Singkat |
|----|-------------|------------------|
| 1 | **users** | Menyimpan data pengguna aplikasi Laravel seperti admin, kasir, dan owner |
| 2 | **customers** | Menyimpan data pelanggan salon |
| 3 | **treatments** | Menyimpan data layanan salon (potong rambut, creambath, dll) |
| 4 | **transactions** | Menyimpan data transaksi pelanggan yang dilakukan oleh kasir |
| 5 | **transaction_details** | Menyimpan rincian layanan yang dipesan dalam satu transaksi |
| 6 | **log_pembatalan** | Menyimpan log pembatalan transaksi (melalui stored procedure) |

---

## 🚀 2. Fitur Database Advanced

### 2.1 **Stored Procedures**
- **`log_pembatalan_procedure`** - Menyimpan log pembatalan transaksi dengan parameter user yang melakukan pembatalan

### 2.2 **MySQL Functions**
- **Revenue Functions:** `calculate_today_revenue()`, `calculate_month_revenue()`, `calculate_year_revenue()`, `calculate_total_revenue()`
- **Transaction Count Functions:** `count_today_transactions()`, `count_month_transactions()`, `count_year_transactions()`, `count_total_transactions()`
- **User-specific Functions:** `calculate_user_revenue()`, `count_user_transactions()`
- **Transaction Detail Function:** `calculate_transaction_total()`

### 2.3 **Transaction Implementations**
- **Tipe 1:** MySQL Raw SQL Transaction (Active)
- **Tipe 2:** Laravel DB Builder Transaction (Commented)
- **Tipe 3:** Laravel Eloquent Transaction (Commented)

---

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
| status | ENUM('selesai', 'dibatalkan') | Status transaksi (default: 'selesai') |
| created_at | TIMESTAMP | Waktu dibuat |
| updated_at | TIMESTAMP | Waktu diperbarui |
| deleted_at | TIMESTAMP | Soft delete timestamp |

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
| transaksi_id | INT | ID transaksi yang dibatalkan |
| alasan | VARCHAR(255) | Keterangan alasan pembatalan |
| dibatalkan_oleh | VARCHAR(255) | Nama user yang membatalkan transaksi |
| created_at | TIMESTAMP | Waktu pembuatan log |
| updated_at | TIMESTAMP | Waktu terakhir diperbarui |
| deleted_at | TIMESTAMP | Soft delete timestamp |

**Keterkaitan:**
Berelasi dengan `transactions` secara *indirect* melalui stored procedure.

---

## 🔧 4. Stored Procedures & Functions

### 4.1 **log_pembatalan_procedure**
Stored procedure untuk mencatat pembatalan transaksi dengan tracking user yang melakukan pembatalan.

```sql
CREATE PROCEDURE log_pembatalan_procedure(
    IN p_transaksi_id INT,
    IN p_alasan VARCHAR(255),
    IN p_user_name VARCHAR(255)
)
BEGIN
    DECLARE v_existing_count INT DEFAULT 0;
    SELECT COUNT(*) INTO v_existing_count
    FROM log_pembatalan
    WHERE transaksi_id = p_transaksi_id;

    IF v_existing_count = 0 THEN
        INSERT INTO log_pembatalan (
            transaksi_id, alasan, dibatalkan_oleh, deleted_at, created_at, updated_at
        ) VALUES (p_transaksi_id, p_alasan, p_user_name, NOW(), NOW(), NOW());
    END IF;
END
```

**Parameter:**
- `p_transaksi_id` - ID transaksi yang dibatalkan
- `p_alasan` - Alasan pembatalan
- `p_user_name` - Nama user yang membatalkan

### 4.2 **MySQL Functions**

#### **Revenue Calculation Functions**
```sql
-- Total pendapatan hari ini (transaksi aktif saja)
CREATE FUNCTION calculate_today_revenue() RETURNS DECIMAL(15,2)

-- Total pendapatan bulan ini (transaksi aktif saja)
CREATE FUNCTION calculate_month_revenue() RETURNS DECIMAL(15,2)

-- Total pendapatan tahun ini (transaksi aktif saja)
CREATE FUNCTION calculate_year_revenue() RETURNS DECIMAL(15,2)

-- Total pendapatan semua waktu (transaksi aktif saja)
CREATE FUNCTION calculate_total_revenue() RETURNS DECIMAL(15,2)
```

#### **Transaction Count Functions**
```sql
-- Jumlah transaksi hari ini (transaksi aktif saja)
CREATE FUNCTION count_today_transactions() RETURNS INT

-- Jumlah transaksi bulan ini (transaksi aktif saja)
CREATE FUNCTION count_month_transactions() RETURNS INT

-- Jumlah transaksi tahun ini (transaksi aktif saja)
CREATE FUNCTION count_year_transactions() RETURNS INT

-- Jumlah transaksi semua waktu (transaksi aktif saja)
CREATE FUNCTION count_total_transactions() RETURNS INT
```

#### **User-specific Functions**
```sql
-- Total pendapatan per user (transaksi aktif saja)
CREATE FUNCTION calculate_user_revenue(p_user_id INT) RETURNS DECIMAL(15,2)

-- Jumlah transaksi per user (transaksi aktif saja)
CREATE FUNCTION count_user_transactions(p_user_id INT) RETURNS INT
```

#### **Transaction Detail Function**
```sql
-- Total harga per transaksi dari transaction_details
CREATE FUNCTION calculate_transaction_total(p_transaction_id INT) RETURNS DECIMAL(10,2)
```

---

## 💾 5. Transaction Implementation Examples

### 5.1 **Tipe 1: MySQL Raw SQL Transaction (Active)**
```php
try {
    DB::beginTransaction();

    // Insert transaction
    DB::insert("
        INSERT INTO transactions (customer_id, user_id, tanggal, total_harga, status, created_at, updated_at)
        VALUES (?, ?, ?, ?, 'selesai', NOW(), NOW())
    ", [$customer_id, $user_id, $tanggal, $total_harga]);

    // Get inserted ID
    $transactionId = DB::getPdo()->lastInsertId();

    // Insert transaction details
    foreach ($details as $detail) {
        DB::insert("
            INSERT INTO transaction_details (transaction_id, treatment_id, harga, qty, subtotal, created_at, updated_at)
            VALUES (?, ?, ?, ?, ?, NOW(), NOW())
        ", [$transactionId, $detail['treatment_id'], $detail['harga'], $detail['qty'], $detail['subtotal']]);
    }

    DB::commit();
} catch (\Exception $e) {
    DB::rollBack();
}
```

### 5.2 **Tipe 2: Laravel DB Builder Transaction**
```php
try {
    DB::beginTransaction();

    $transactionId = DB::table('transactions')->insertGetId([
        'customer_id' => $request->customer_id,
        'user_id' => auth()->id(),
        'tanggal' => now(),
        'total_harga' => $totalHarga,
        'status' => 'selesai',
        'created_at' => now(),
        'updated_at' => now()
    ]);

    foreach ($transactionDetails as $detail) {
        DB::table('transaction_details')->insert([
            'transaction_id' => $transactionId,
            'treatment_id' => $detail['treatment_id'],
            'harga' => $detail['harga'],
            'qty' => $detail['qty'],
            'subtotal' => $detail['subtotal'],
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }

    DB::commit();
} catch (\Exception $e) {
    DB::rollBack();
}
```

### 5.3 **Tipe 3: Laravel Eloquent Transaction**
```php
try {
    DB::beginTransaction();

    $transaction = Transaction::create([
        'customer_id' => $request->customer_id,
        'user_id' => auth()->id(),
        'tanggal' => now(),
        'total_harga' => $totalHarga,
        'status' => 'selesai'
    ]);

    foreach ($transactionDetails as $detail) {
        $detail['transaction_id'] = $transaction->id;
        TransactionDetail::create($detail);
    }

    DB::commit();
} catch (\Exception $e) {
    DB::rollBack();
}
```

---

