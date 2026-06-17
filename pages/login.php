<?php
// Mulai session di bagian paling atas untuk mengamankan notifikasi
session_start();
include '../config.php';

// Jika sudah login, langsung lempar ke halaman home
if (isset($_SESSION['login'])) {
    header("Location: home.php");
    exit();
}

// LOGIKA PROSES LOGIN (Mendukung Username atau Email)
if (isset($_POST['login_btn'])) {
    // Variabel identifier dapat menangkap isi teks username maupun email yang diketik
    $identifier = mysqli_real_escape_string($conn, $_POST['identifier']);
    $password   = $_POST['password'];

    // Memeriksa dua kolom sekaligus menggunakan operator OR
    $query  = "SELECT * FROM users WHERE username = '$identifier' OR email = '$identifier'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row['password'])) {
            $_SESSION['login']     = true;
            $_SESSION['user_id']   = $row['id'];
            // 💡 Dikembalikan ke nama_lengkap sesuai tabel aktif database proyekmu
            $_SESSION['nama_user'] = $row['nama_lengkap']; 

            header("Location: home.php");
            exit();
        }
    }
    $error_login = true;
}

// LOGIKA PROSES REGISTRASI (DAFTAR AKUN BARU + INPUT EMAIL)
if (isset($_POST['register_btn'])) {
    $nama_lengkap = mysqli_real_escape_string($conn, $_POST['reg_nama']);
    $email        = mysqli_real_escape_string($conn, $_POST['reg_email']);
    $username     = mysqli_real_escape_string($conn, $_POST['reg_username']);
    $password     = $_POST['reg_password'];

    // VALIDASI: Cek apakah username ATAU email sudah pernah terdaftar sebelumnya
    $cek_user = mysqli_query($conn, "SELECT username, email FROM users WHERE username = '$username' OR email = '$email'");
    
    if (mysqli_num_rows($cek_user) > 0) {
        $row_cek = mysqli_fetch_assoc($cek_user);
        if ($row_cek['username'] === $username) {
            $error_username_kembar = true;
        } else {
            $error_email_kembar = true;
        }
    } else {
        // Enkripsi password dengan password_hash aman standar dunia IT
        $password_aman = password_hash($password, PASSWORD_DEFAULT);
        
        // 💡 Nama kolom dikembalikan menjadi nama_lengkap agar sinkron dengan database-mu
        $query_reg = "INSERT INTO users (username, email, password, nama_lengkap) VALUES ('$username', '$email', '$password_aman', '$nama_lengkap')";
        if (mysqli_query($conn, $query_reg)) {
            $sukses_register = true;
        } else {
            $gagal_register = true;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk & Daftar - Uneeds</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #FFF1F1;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            border: none;
            border-radius: 20px;
            background-color: #ffffff;
            max-width: 420px;
            width: 100%;
        }
        .nav-pills .nav-link {
            color: #6c757d;
            font-weight: 600;
            border-radius: 10px;
            font-size: 0.9rem;
        }
        .nav-pills .nav-link.active {
            background-color: #004725;
            color: white;
        }
        .btn-uneeds {
            background-color: #004725;
            color: white;
            border-radius: 10px;
            font-weight: 600;
        }
        .btn-uneeds:hover {
            background-color: #006F39;
            color: white;
        }
    </style>
</head>
<body>

<div class="card login-card p-4 shadow-lg mx-3 my-5">
    <div class="text-center mb-4">
        <h2 class="fw-bold m-0" style="color: #004725;">Uneeds</h2>
        <small class="text-muted">Need a Plan? Uneeds It.</small>
    </div>

    <!-- Pilihan Menu Tab (Login / Daftar) -->
    <ul class="nav nav-pills nav-justified mb-4 p-1 bg-light rounded-3" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="pills-login-tab" data-bs-toggle="pill" data-bs-target="#pills-login" type="button" role="tab" aria-controls="pills-login" aria-selected="true">Log In</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="pills-register-tab" data-bs-toggle="pill" data-bs-target="#pills-register" type="button" role="tab" aria-controls="pills-register" aria-selected="false">Daftar Akun</button>
        </li>
    </ul>

    <div class="tab-content" id="pills-tabContent">
        <!-- FORM TAB 1: LOGIN -->
        <div class="tab-pane fade show active" id="pills-login" role="tabpanel" aria-labelledby="pills-login-tab">
            <form action="" method="POST">
                <div class="mb-3">
                    <label for="identifier" class="form-label small fw-semibold">Username atau Email</label>
                    <input type="text" class="form-control border-2 shadow-none" id="identifier" name="identifier" required placeholder="Masukkan username atau email" style="border-radius: 10px;">
                </div>
                <div class="mb-4">
                    <label for="password" class="form-label small fw-semibold">Password</label>
                    <input type="password" class="form-control border-2 shadow-none" id="password" name="password" required placeholder="Masukkan password" style="border-radius: 10px;">
                </div>
                <button type="submit" name="login_btn" class="btn btn-uneeds w-100 py-2.5">Masuk Sekarang</button>
            </form>
        </div>

        <!-- FORM TAB 2: REGISTRASI (DAFTAR AKUN) -->
        <div class="tab-pane fade" id="pills-register" role="tabpanel" aria-labelledby="pills-register-tab">
            <form action="" method="POST">
                <div class="mb-3">
                    <label for="reg_nama" class="form-label small fw-semibold">Nama Kamu</label>
                    <input type="text" class="form-control border-2 shadow-none" id="reg_nama" name="reg_nama" required placeholder="Masukkan nama panggilanmu" style="border-radius: 10px;">
                </div>
                <div class="mb-3">
                    <label for="reg_email" class="form-label small fw-semibold">Email Aktif</label>
                    <input type="email" class="form-control border-2 shadow-none" id="reg_email" name="reg_email" required placeholder="Contoh: user@gmail.com" style="border-radius: 10px;">
                </div>
                <div class="mb-3">
                    <label default="reg_username" class="form-label small fw-semibold">Username Baru</label>
                    <input type="text" class="form-control border-2 shadow-none" id="reg_username" name="reg_username" required placeholder="Gunakan huruf kecil tanpa spasi" style="border-radius: 10px;">
                </div>
                <div class="mb-4">
                    <label for="reg_password" class="form-label small fw-semibold">Password Baru</label>
                    <input type="password" class="form-control border-2 shadow-none" id="reg_password" name="reg_password" required placeholder="Masukkan password baru" style="border-radius: 10px;">
                </div>
                <button type="submit" name="register_btn" class="btn btn-success w-100 py-2.5 fw-semibold" style="border-radius: 10px;">Selesaikan Pendaftaran</button>
            </form>
        </div>
    </div>
</div>

<!-- Pastikan JS Bootstrap Terpanggil dengan Benar untuk Efek Klik Tab -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- NOTIFIKASI SWEETALERT DENGAN BERBAGAI KONDISI -->
<?php if (isset($error_login)): ?>
    <script>
        Swal.fire({ title: 'Login Gagal! 😞', text: 'Username, email, atau password salah.', icon: 'error', confirmButtonColor: '#d32f2f' });
    </script>
<?php endif; ?>

<?php if (isset($error_username_kembar)): ?>
    <script>
        Swal.fire({ title: 'Username Kembar! 😮', text: 'Username tersebut sudah terpakai, silakan cari nama unik lain.', icon: 'warning', confirmButtonColor: '#fbc02d' });
    </script>
<?php endif; ?>

<?php if (isset($error_email_kembar)): ?>
    <script>
        Swal.fire({ title: 'Email Sudah Terdaftar! ✉️', text: 'Email ini sudah digunakan akun lain. Gunakan email lain atau silakan Log In.', icon: 'warning', confirmButtonColor: '#fbc02d' });
    </script>
<?php endif; ?>

<?php if (isset($sukses_register)): ?>
    <script>
        Swal.fire({ title: 'Pendaftaran Berhasil! 🎉', text: 'Akun barumu sukses dibuat. Silakan klik tab LOG IN untuk masuk!', icon: 'success', confirmButtonColor: '#2e7d32' });
    </script>
<?php endif; ?>
</body>
</html>