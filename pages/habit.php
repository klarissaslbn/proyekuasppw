<?php
// Mulai session untuk mengamankan pop-up agar tidak muncul terus-menerus
session_start();

// 2. KUNCI HALAMAN: Jika tidak ada session login, usir pengunjung ke halaman login
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit();
}

// 1. Hubungkan ke database lewat file jembatan
include '../config.php';

// SETTING TANGGAL & BULAN OTOMATIS INDONESIA
date_default_timezone_set('Asia/Jakarta');

$hari_id = ['Sunday' => 'Minggu', 'Monday' => 'Senin', 'Tuesday' => 'Selasa', 'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu'];
$bulan_id = [1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

$hari_eng  = date('l');
$hari_ini  = $hari_id[$hari_eng];
$tanggal   = date('j');
$bulan_num = date('n');
$bulan_ini = $bulan_id[$bulan_num];
$tahun     = date('Y');


// 2. FUNGSI CREATE: Proses Tambah Kebiasaan Baru
if (isset($_POST['submit_habit'])) {
    $habit_name = mysqli_real_escape_string($conn, $_POST['habit_name']);
    
    $query = "INSERT INTO habits (habit_name, streak_count, status) VALUES ('$habit_name', 0, 'Belum')";
    
    if (mysqli_query($conn, $query)) {
        $_SESSION['sukses_tambah'] = true;
        header("Location: habit.php");
        exit();
    } else {
        echo "<script>alert('Gagal menambahkan habit baru.');</script>";
    }
}

// 3. FUNGSI UPDATE: Proses Checklist Habit (Mengubah Status & Menambah Streak)
if (isset($_POST['check_habit_selesai']) && isset($_POST['habit_id'])) {
    $habit_id = mysqli_real_escape_string($conn, $_POST['habit_id']);
    
    $query_update = "UPDATE habits SET status = 'Selesai', streak_count = streak_count + 1 WHERE id = '$habit_id'";
    
    if (mysqli_query($conn, $query_update)) {
        $_SESSION['sukses_checklist'] = true;
        header("Location: habit.php");
        exit();
    }
}

// 💡 FUNGSI DELETE: Proses Hapus Habit Berdasarkan ID
if (isset($_GET['hapus_id'])) {
    $hapus_id = mysqli_real_escape_string($conn, $_GET['hapus_id']);
    
    $query_hapus = "DELETE FROM habits WHERE id = '$hapus_id'";
    
    if (mysqli_query($conn, $query_hapus)) {
        $_SESSION['sukses_hapus'] = true;
        header("Location: habit.php");
        exit();
    } else {
        echo "<script>alert('Gagal menghapus habit.');</script>";
    }
}

// 4. FUNGSI READ: Hitung Angka di 3 Kotak Statistik secara Otomatis
$query_total = "SELECT COUNT(*) as total FROM habits";
$res_total   = mysqli_query($conn, $query_total);
$total_habit = mysqli_fetch_assoc($res_total)['total'];

$query_selesai = "SELECT COUNT(*) as total FROM habits WHERE status = 'Selesai'";
$res_selesai   = mysqli_query($conn, $query_selesai);
$selesai_hari_ini = mysqli_fetch_assoc($res_selesai)['total'];

$query_streak = "SELECT MAX(streak_count) as max_streak FROM habits";
$res_streak   = mysqli_query($conn, $query_streak);
$streak_terbaik = mysqli_fetch_assoc($res_streak)['max_streak'] ?? 0;

// 5. FUNGSI READ: Ambil semua daftar habit untuk ditampilkan di list
$query_tampil = "SELECT * FROM habits ORDER BY id DESC";
$tampil_habit = mysqli_query($conn, $query_tampil);

// LOGIKA MATEMATIKA: Hitung persentase tinggi grafik batang Selasa
$tinggi_grafik_selasa = 15;
if ($total_habit > 0) {
    $tinggi_grafik_selasa = ($selesai_hari_ini / $total_habit) * 150;
    if ($tinggi_grafik_selasa < 15) {
        $tinggi_grafik_selasa = 15;
    }
}
?>

<?php include '../components/header.php'; ?>
<?php include '../components/navbar.php'; ?>

<script>document.getElementById('nav-habit').classList.add('active');</script>

<div class="container pt-4 mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1" style="color: var(--uneeds-text-green);">Habit Tracker</h2>
            <small class="uneeds-date fw-semibold" style="color: #006F39;"><?= $bulan_ini . ' ' . $tahun; ?></small>
        </div>
        <button class="btn btn-uneeds shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambahHabit">
            <i class="fa-solid fa-plus me-1"></i> Habit baru
        </button>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-4 col-12">
            <div class="card p-3 stat-card text-center shadow-sm">
                <h3 class="fw-bold mb-1"><?= $total_habit; ?></h3>
                <small class="text-muted">Habit aktif</small>
            </div>
        </div>
        <div class="col-md-4 col-12">
            <div class="card p-3 stat-card success-variant text-center shadow-sm">
                <h3 class="fw-bold mb-1"><?= $selesai_hari_ini; ?></h3>
                <small class="text-muted">Selesai hari ini</small>
            </div>
        </div>
        <div class="col-md-4 col-12">
            <div class="card p-3 stat-card pink-variant text-center shadow-sm">
                <h3 class="fw-bold mb-1"><?= $streak_terbaik; ?></h3>
                <small class="text-muted">Streak terbaik</small>
            </div>
        </div>
    </div>

    <div class="card p-4 content-card shadow-sm mb-4">
        <h6 class="fw-bold mb-3" style="color: var(--uneeds-text-green);">Check-in hari ini</h6>
        <div class="d-flex flex-column gap-3">
            
            <?php 
            if (mysqli_num_rows($tampil_habit) > 0) {
                while ($row = mysqli_fetch_assoc($tampil_habit)) { 
                    $is_checked = ($row['status'] == 'Selesai') ? 'checked disabled' : '';
                    $text_class = ($row['status'] == 'Selesai') ? 'text-muted text-decoration-line-through' : '';
                    $badge_style = ($row['status'] == 'Selesai') ? 'background-color: #e8f5e9; color: var(--uneeds-text-green);' : 'background-color: #f5f5f5; color: #757575;';
            ?>
                    <div class="p-2 rounded d-flex justify-content-between align-items-center" style="background-color: #fafafa;">
                        <form action="" method="POST" class="m-0 flex-grow-1">
                            <input type="hidden" name="habit_id" value="<?= $row['id']; ?>">
                            <div class="form-check m-0 d-flex align-items-center">
                                <input class="form-check-input me-3" type="checkbox" name="check_habit_selesai" id="habit_<?= $row['id']; ?>" style="width: 24px; height: 24px;" onchange="this.form.submit()" <?= $is_checked; ?>>
                                <label class="form-check-label fw-semibold <?= $text_class; ?>" for="habit_<?= $row['id']; ?>">
                                    <?= htmlspecialchars($row['habit_name']); ?>
                                </label>
                            </div>
                        </form>
                        
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge rounded-pill px-3 py-2" style="<?= $badge_style; ?> font-size: 0.8rem;">
                                <?= $row['streak_count']; ?> hari berturut
                            </span>
                            
                            <button type="button" class="btn btn-sm btn-link text-danger border-0 shadow-none p-1" onclick="konfirmasiHapus(<?= $row['id']; ?>)">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </div>
                    </div>
            <?php 
                } 
            } else { 
                echo "<p class='text-muted text-center my-3 small'>Belum ada habit kebiasaan. Klik '+ Habit baru' untuk memulai!</p>";
            } 
            ?>

        </div>
    </div>

    <div class="card p-4 content-card shadow-sm">
        <h6 class="fw-bold mb-4" style="color: var(--uneeds-text-green);">Konsistensi minggu ini</h6>
        <div class="d-flex justify-content-between align-items-end px-2 pt-3" style="height: 160px; border-bottom: 2px solid #eeeeee;">
            <div class="d-flex flex-column align-items-center w-100"><div class="w-50 shadow-sm" style="height: 120px; background-color: var(--uneeds-check-pink); border-radius: 8px 8px 0 0;"></div></div>
            <div class="d-flex flex-column align-items-center w-100">
                <div class="w-50 shadow-sm" style="height: <?= $tinggi_grafik_selasa; ?>px; background-color: var(--uneeds-check-pink); border-radius: 8px 8px 0 0; transition: height 0.4s ease;"></div>
            </div>
            <div class="d-flex flex-column align-items-center w-100"><div class="w-50 shadow-sm" style="height: 110px; background-color: var(--uneeds-check-pink); border-radius: 8px 8px 0 0;"></div></div>
            <div class="d-flex flex-column align-items-center w-100"><div class="w-50 shadow-sm" style="height: 60px; background-color: var(--uneeds-check-pink); border-radius: 8px 8px 0 0;"></div></div>
            <div class="d-flex flex-column align-items-center w-100"><div class="w-50 shadow-sm" style="height: 40px; background-color: var(--uneeds-check-pink); border-radius: 8px 8px 0 0;"></div></div>
            <div class="d-flex flex-column align-items-center w-100"><div class="w-50 shadow-sm" style="height: 15px; background-color: #eeeeee; border-radius: 4px 4px 0 0;"></div></div>
            <div class="d-flex flex-column align-items-center w-100"><div class="w-50 shadow-sm" style="height: 15px; background-color: #eeeeee; border-radius: 4px 4px 0 0;"></div></div>
        </div>
        <div class="d-flex justify-content-between align-items-center mt-2 text-center text-muted fw-semibold" style="font-size: 0.75rem;">
            <div class="w-100">Sen</div><div class="w-100">Sel</div><div class="w-100">Rab</div><div class="w-100">Kam</div><div class="w-100">Jum</div><div class="w-100">Sab</div><div class="w-100">Min</div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTambahHabit" tabindex="-1" aria-labelledby="modalTambahHabitLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header border-0 pt-4 px-4">
                <h5 class="modal-title fw-bold" id="modalTambahHabitLabel" style="color: var(--uneeds-text-green);">
                    <i class="fa-solid fa-arrows-spin me-2"></i>Tambah Kebiasaan Baru
                </h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="POST">
                <div class="modal-body px-4 pb-4">
                    <div class="mb-3">
                        <label for="habit_name" class="form-label fw-semibold small">Nama Kebiasaan</label>
                        <input type="text" class="form-control form-control-lg border-2 shadow-none" id="habit_name" name="habit_name" placeholder="Misal: Minum Air Putih 2L" required style="border-radius: 10px; font-size: 0.95rem;">
                    </div>
                </div>
                <div class="modal-footer border-0 px-4 pb-4 pt-0 d-flex gap-2">
                    <button type="button" class="btn btn-light w-50 fw-semibold py-2" data-bs-dismiss="modal" style="border-radius: 10px;">Batal</button>
                    <button type="submit" name="submit_habit" class="btn btn-uneeds w-50 fw-semibold py-2" style="border-radius: 10px; background-color: var(--uneeds-text-green); color: white;">Simpan Habit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include '../components/footer.php'; ?>

<script>
function konfirmasiHapus(id) {
    Swal.fire({
        title: 'Apakah kamu yakin? 😮',
        text: "Habit yang dihapus tidak bisa dikembalikan beserta streak-nya!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d32f2f',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            // Jika dikonfirmasi, lempar variabel hapus_id ke URL halaman ini
            window.location.href = 'habit.php?hapus_id=' + id;
        }
    })
}
</script>

<?php if (isset($_SESSION['sukses_tambah'])): ?>
    <script>
        Swal.fire({ title: 'Semangat Baru! ✨', text: 'Habit barumu berhasil ditambahkan', icon: 'success', confirmButtonColor: '#2e7d32', confirmButtonText: 'Oke' });
    </script>
    <?php unset($_SESSION['sukses_tambah']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['sukses_checklist'])): ?>
    <script>
        Swal.fire({ title: 'Luar Biasa! 🌸', text: 'Satu investasi kebaikan untuk dirimu hari ini', icon: 'success', confirmButtonColor: '#2e7d32', confirmButtonText: 'Lanjutkan' });
    </script>
    <?php unset($_SESSION['sukses_checklist']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['sukses_hapus'])): ?>
    <script>
        Swal.fire({ title: 'Berhasil Dihapus! 🗑️', text: 'Satu data kebiasaan telah dibersihkan dari sistem', icon: 'success', confirmButtonColor: '#2e7d32', confirmButtonText: 'Oke' });
    </script>
    <?php unset($_SESSION['sukses_hapus']); ?>
<?php endif; ?>