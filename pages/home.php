<?php
session_start();
include '../config.php'; 

// 1. QUERY DATA STATISTIK
$query_todo_belum = "SELECT COUNT(*) as sisa_tugas FROM todos WHERE status = 'Belum'";
$res_todo         = mysqli_query($conn, $query_todo_belum);
$sisa_tugas       = $res_todo ? mysqli_fetch_assoc($res_todo)['sisa_tugas'] : 0;

$query_todo_total = "SELECT COUNT(*) as total_tugas FROM todos";
$res_todo_total   = mysqli_query($conn, $query_todo_total);
$total_tugas      = $res_todo_total ? mysqli_fetch_assoc($res_todo_total)['total_tugas'] : 0;

$query_habit_total = "SELECT COUNT(*) as total FROM habits";
$res_habit_total   = mysqli_query($conn, $query_habit_total);
$total_habit       = $res_habit_total ? mysqli_fetch_assoc($res_habit_total)['total'] : 0;

$query_habit_selesai = "SELECT COUNT(*) as selesai FROM habits WHERE status = 'Selesai'";
$res_habit_selesai   = mysqli_query($conn, $query_habit_selesai);
$selesai_habit       = $res_habit_selesai ? mysqli_fetch_assoc($res_habit_selesai)['selesai'] : 0;

$query_schedule = "SELECT * FROM schedules ORDER BY start_time ASC LIMIT 1";
$res_schedule   = mysqli_query($conn, $query_schedule);
$jadwal_terdekat = $res_schedule ? mysqli_fetch_assoc($res_schedule) : null;

$kolom_judul_schedule = 'schedule_title';
if ($jadwal_terdekat && isset($jadwal_terdekat['title'])) {
    $kolom_judul_schedule = 'title';
}

// 2. HITUNG PERSENTASE PRODUKTIVITAS HARI INI
$total_aksi_sukses = ($total_tugas - $sisa_tugas) + $selesai_habit;
$total_target_hari_ini = $total_tugas + $total_habit;
$persentase_hari_ini = 0;

if ($total_target_hari_ini > 0) {
    $persentase_hari_ini = round(($total_aksi_sukses / $total_target_hari_ini) * 100);
}
?>

<?php include '../components/header.php'; ?>
<?php include '../components/navbar.php'; ?>

<script>
    const navHome = document.getElementById('nav-home') || document.getElementById('nav-dashboard');
    if(navHome) navHome.classList.add('active');
</script>

<div class="container mb-5">
    <!-- WELCOME BANNER CAKEP -->
    <div class="p-4 rounded-4 mb-4 text-white shadow-sm" style="background: linear-gradient(135deg, var(--uneeds-text-green), #006F39);">
        <h4 class="fw-bold mb-1">Selamat Datang di Uneeds, Klarissa! ✨</h4>
        <p class="mb-0 small opacity-75">Mari pantau dan kelola seluruh produktivitas kuliahmu hari ini dalam satu dashboard terintegrasi.</p>
    </div>

    <!-- SEKSI 1: RANGKUMAN AKTIVITAS -->
    <h5 class="fw-bold mb-3" style="color: var(--uneeds-text-green);">Rangkuman Aktivitas</h5>
    <div class="row g-3 mb-4">
        <!-- TO DO CARD -->
        <div class="col-12 col-md-4">
            <div class="card p-3 content-card shadow-sm h-100 d-flex flex-column justify-content-between">
                <div>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="badge bg-danger-subtle text-danger px-2 py-1" style="font-size: 0.75rem;">To Do List</span>
                        <i class="fa-solid fa-list-check text-muted"></i>
                    </div>
                    <h6 class="fw-bold text-dark mb-1">Tugas Belum Selesai</h6>
                    <p class="text-muted small mb-3">Ada beberapa target tugas kuliah yang menanti tindakanmu.</p>
                </div>
                <div class="d-flex align-items-baseline">
                    <h2 class="fw-bold m-0 me-2"><?= $sisa_tugas; ?></h2>
                    <small class="text-muted">tugas sisa</small>
                </div>
            </div>
        </div>

        <!-- HABIT CARD -->
        <div class="col-12 col-md-4">
            <div class="card p-3 content-card shadow-sm h-100 d-flex flex-column justify-content-between">
                <div>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="badge bg-success-subtle text-success px-2 py-1" style="font-size: 0.75rem;">Habit Tracker</span>
                        <i class="fa-solid fa-arrows-spin text-muted"></i>
                    </div>
                    <h6 class="fw-bold text-dark mb-1">Progress Kebiasaan</h6>
                    <p class="text-muted small mb-3">Konsistensi adalah kunci keberhasilan seorang software engineer.</p>
                </div>
                <div class="d-flex align-items-baseline">
                    <h2 class="fw-bold m-0 me-2"><?= $selesai_habit; ?><span class="text-secondary" style="font-size: 1.2rem;">/<?= $total_habit; ?></span></h2>
                    <small class="text-muted">habit beres</small>
                </div>
            </div>
        </div>

        <!-- SCHEDULE CARD -->
        <div class="col-12 col-md-4">
            <div class="card p-3 content-card shadow-sm h-100 d-flex flex-column justify-content-between">
                <div>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="badge bg-primary-subtle text-primary px-2 py-1" style="font-size: 0.75rem;">Next Schedule</span>
                        <i class="fa-regular fa-calendar-days text-muted"></i>
                    </div>
                    <h6 class="fw-bold text-dark mb-1">Agenda Terdekat</h6>
                    <p class="text-muted small mb-3">Pastikan kamu bersiap tepat waktu agar agenda berjalan lancar.</p>
                </div>
                <div>
                    <?php if ($jadwal_terdekat): ?>
                        <div class="p-2 rounded" style="background-color: #fafafa; border-left: 4px solid var(--uneeds-check-pink);">
                            <strong class="text-dark d-block small text-truncate"><?= htmlspecialchars($jadwal_terdekat[$kolom_judul_schedule]); ?></strong>
                            <small class="text-muted" style="font-size: 0.75rem;">
                                <i class="fa-regular fa-clock me-1"></i> <?= date('H.i', strtotime($jadwal_terdekat['start_time'])); ?> WIB
                            </small>
                        </div>
                    <?php else: ?>
                        <p class="text-muted italic small mb-0">💡 Tidak ada agenda tersisa untuk hari ini.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- SEKSI 2: PROGRESS BAR PRODUKTIVITAS HARI INI (BAWAH KIRI) -->
        <div class="col-12 col-md-6">
            <div class="card p-4 content-card shadow-sm h-100">
                <h5 class="fw-bold mb-2" style="color: var(--uneeds-text-green);">Capaian Hari Ini</h5>
                <p class="text-muted small mb-4">Akumulasi penyelesaian tugas harian dan pembentukan habit positifmu.</p>
                
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="fw-bold text-dark small">Level Produktivitas</span>
                    <span class="fw-bold p-1 rounded bg-success-subtle text-success small"><?= $persentase_hari_ini; ?>%</span>
                </div>
                
                <div class="progress mb-3" style="height: 20px; border-radius: 10px; background-color: #f0f0f0;">
                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" 
                         style="width: <?= $persentase_hari_ini; ?>%; background-color: var(--uneeds-check-pink); border-radius: 10px; transition: width 0.6s ease;" 
                         aria-valuenow="<?= $persentase_hari_ini; ?>" aria-valuemin="0" aria-valuemax="100">
                    </div>
                </div>
                
                <small class="text-muted italic d-block mt-2">
                    <?php 
                    if($persentase_hari_ini == 100) echo "🔥 Sempurna! Semua target berhasil kamu babat habis hari ini!";
                    elseif($persentase_hari_ini >= 50) echo "⚡ Bagus sekali, kamu sudah menyelesaikan lebih dari separuh misi!";
                    else echo "🌱 Langkah kecil setiap hari bermakna besar. Yuk mulai cicil targetmu!";
                    ?>
                </small>
            </div>
        </div>

        <!-- SEKSI 3: QUICK ACTIONS NAVIGASI (BAWAH KANAN) -->
        <div class="col-12 col-md-6">
            <div class="card p-4 content-card shadow-sm h-100">
                <h5 class="fw-bold mb-2" style="color: var(--uneeds-text-green);">Akses Cepat</h5>
                <p class="text-muted small mb-3">Pindah antar modul halaman dengan sekali klik.</p>
                
                <div class="row g-2">
                    <div class="col-6">
                        <a href="todo.php" class="btn btn-light w-100 text-start p-3 border d-flex align-items-center justify-content-between rounded-3 hover-shadow" style="background-color: #fafafa;">
                            <div>
                                <strong class="text-dark small">To-do-List</strong>
                            </div>
                            <i class="fa-solid fa-chevron-right text-muted small"></i>
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="habit.php" class="btn btn-light w-100 text-start p-3 border d-flex align-items-center justify-content-between rounded-3 hover-shadow" style="background-color: #fafafa;">
                            <div>
                                <strong class="text-dark small">Habit Tracker</strong>
                            </div>
                            <i class="fa-solid fa-chevron-right text-muted small"></i>
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="schedule.php" class="btn btn-light w-100 text-start p-3 border d-flex align-items-center justify-content-between rounded-3 hover-shadow" style="background-color: #fafafa;">
                            <div>
                                <strong class="text-dark small">Your Schedule</strong>
                            </div>
                            <i class="fa-solid fa-chevron-right text-muted small"></i>
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="evaluation.php" class="btn btn-light w-100 text-start p-3 border d-flex align-items-center justify-content-between rounded-3 hover-shadow" style="background-color: #fafafa;">
                            <div>
                                <strong class="text-dark small">Evaluation</strong>
                            </div>
                            <i class="fa-solid fa-chevron-right text-muted small"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../components/footer.php'; ?>