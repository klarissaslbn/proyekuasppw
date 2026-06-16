<?php
// Mulai session untuk mengamankan pop-up agar tidak muncul terus-menerus
session_start();

// 1. Hubungkan ke database lewat file jembatan
include '../config.php';

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

<div class="container mb-5">
    <!-- BARIS KEPALA -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1" style="color: var(--uneeds-text-green);">Habit Tracker</h2>
            <small class="uneeds-date">Juni 2026</small>
        </div>
        <button class="btn btn-uneeds shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambahHabit">
            <i class="fa-solid fa-plus me-1"></i> Habit baru
        </button>
    </div>

    <!-- TIGA KOTAK STATISTIK DINAMIS -->
    <div class="row g-3 mb-4">
        <div class="col-4">
            <div class="card p-3 stat-card text-center shadow-sm">
                <h3 class="fw-bold mb-1"><?= $total_habit; ?></h3>
                <small class="text-muted">Habit aktif</small>
            </div>
        </div>
        <div class="col-4">
            <div class="card p-3 stat-card success-variant text-center shadow-sm">
                <h3 class="fw-bold mb-1"><?= $selesai_hari_ini; ?></h3>
                <small class="text-muted">Selesai hari ini</small>
            </div>
        </div>
        <div class="col-4">
            <div class="card p-3 stat-card pink-variant text-center shadow-sm">
                <h3 class="fw-bold mb-1"><?= $streak_terbaik; ?></h3>
                <small class="text-muted">Streak terbaik</small>
            </div>
        </div>
    </div>

    <!-- LIST CHECK-IN HARI INI DARI DATABASE -->
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
                    <form action="" method="POST">
                        <input type="hidden" name="habit_id" value="<?= $row['id']; ?>">
                        <div class="p-2 rounded d-flex justify-content-between align-items-center" style="background-color: #fafafa;">
                            <div class="form-check m-0 d-flex align-items-center">
                                <input class="form-check-input me-3" type="checkbox" name="check_habit_selesai" id="habit_<?= $row['id']; ?>" style="width: 24px; height: 24px;" onchange="this.form.submit()" <?= $is_checked; ?>>
                                <label class="form-check-label fw-semibold <?= $text_class; ?>" for="habit_<?= $row['id']; ?>">
                                    <?= htmlspecialchars($row['habit_name']); ?>
                                </label>
                            </div>
                            <span class="badge rounded-pill px-3 py-2" style="<?= $badge_style; ?> font-size: 0.8rem;">
                                <?= $row['streak_count']; ?> hari berturut
                            </span>
                        </div>
                    </form>
            <?php 
                } 
            } else { 
                echo "<p class='text-muted text-center my-3 small'>Belum ada habit kebiasaan. Klik '+ Habit baru' untuk memulai!</p>";
            } 
            ?>

        </div>
    </div>

    <!-- KOMPONEN GRAFIK SEMI-DINAMIS -->
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

<!-- MODAL FORM POP-UP -->
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

<!-- LOGIKA PEMICU SWEETALERT2 BERBASIS SESSION -->
<?php if (isset($_SESSION['sukses_tambah'])): ?>
    <script>
        Swal.fire({
            title: 'Semangat Baru! ✨',
            text: 'Habit barumu berhasil ditambahkan',
            icon: 'success',
            confirmButtonColor: '#2e7d32',
            confirmButtonText: 'Oke'
        });
    </script>
    <?php unset($_SESSION['sukses_tambah']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['sukses_checklist'])): ?>
    <script>
        Swal.fire({
            title: 'Luar Biasa! 🌸',
            text: 'Satu investasi kebaikan untuk dirimu hari ini',
            icon: 'success',
            confirmButtonColor: '#2e7d32',
            confirmButtonText: 'Lanjutkan'
        });
    </script>
    <?php unset($_SESSION['sukses_checklist']); ?>
<?php endif; ?>