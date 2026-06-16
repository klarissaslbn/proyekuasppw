<?php
// Mulai session di bagian paling atas untuk mengamankan notifikasi SweetAlert2
session_start();

// 1. Hubungkan ke database lewat file jembatan
include '../config.php';

// 2. FUNGSI CREATE: Proses Tambah Jadwal Baru
if (isset($_POST['submit_schedule'])) {
    $schedule_title = mysqli_real_escape_string($conn, $_POST['schedule_title']);
    $start_time     = mysqli_real_escape_string($conn, $_POST['start_time']);
    $end_time       = mysqli_real_escape_string($conn, $_POST['end_time']);
    $category       = mysqli_real_escape_string($conn, $_POST['category']);
    
    // Query lurus langsung menembak ke kolom title yang sudah di-reset bersih
    $query = "INSERT INTO schedules (title, start_time, end_time, category) 
              VALUES ('$schedule_title', '$start_time', '$end_time', '$category')";
    
    if (mysqli_query($conn, $query)) {
        $_SESSION['sukses_tambah_jadwal'] = true;
        header("Location: schedule.php");
        exit();
    } else {
        echo "<script>alert('Gagal menyimpan jadwal baru.'); window.location.href='schedule.php';</script>";
        exit();
    }
}

// 3. FUNGSI READ: Ambil semua jadwal, urutkan dari jam paling pagi (ASC)
$query_tampil = "SELECT * FROM schedules ORDER BY start_time ASC";
$tampil_schedule = mysqli_query($conn, $query_tampil);
?>

<?php include '../components/header.php'; ?>
<?php include '../components/navbar.php'; ?>

<script>document.getElementById('nav-schedule').classList.add('active');</script>

<div class="container mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1" style="color: var(--uneeds-text-green);">Today Schedule</h2>
            <small class="uneeds-date">Selasa, 16 Juni 2026</small>
        </div>
        <button class="btn btn-uneeds shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambahJadwal">
            <i class="fa-solid fa-plus me-1"></i> Tambah jadwal
        </button>
    </div>

    <div class="card p-4 content-card shadow-sm">
        <div class="position-relative">
            
            <div class="position-absolute d-none d-md-block" style="left: 85px; top: 10px; bottom: 10px; width: 2px; background-color: #eef2f0;"></div>

            <?php 
            if ($tampil_schedule && mysqli_num_rows($tampil_schedule) > 0) {
                while ($row = mysqli_fetch_assoc($tampil_schedule)) { 
                    // Pengondisian warna balok & teks berdasarkan kategori jadwal
                    $bg_color = 'var(--uneeds-navbar-pink)';
                    $border_color = 'var(--uneeds-check-pink)';
                    $badge_class = 'text-danger';

                    if ($row['category'] == 'Kampus') {
                        $bg_color = '#f0f7f4'; 
                        $border_color = '#2e7d32'; 
                        $badge_class = 'text-primary';
                    } elseif ($row['category'] == 'Istirahat') {
                        $bg_color = '#fffde7'; 
                        $border_color = '#fbc02d'; 
                        $badge_class = 'text-dark';
                    } elseif ($row['category'] == 'Tugas') {
                        $bg_color = 'var(--uneeds-bg-success)'; 
                        $border_color = 'var(--uneeds-text-green)'; 
                        $badge_class = 'text-success';
                    }

                    // Format tampilan jam agar rapi
                    $waktu_mulai = date('H.i', strtotime($row['start_time']));
                    $waktu_selesai = date('H.i', strtotime($row['end_time']));
            ?>
                    <div class="row align-items-center mb-4 position-relative g-2">
                        <div class="col-12 col-md-1">
                            <span class="fw-bold text-muted d-block" style="font-size: 0.95rem;"><?= $waktu_mulai; ?></span>
                        </div>
                        <div class="col-12 col-md-11 ps-md-4">
                            <div class="p-3 rounded-3 shadow-sm border-0" style="background-color: <?= $bg_color; ?>; border-left: 5px solid <?= $border_color; ?> !important;">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="fw-bold mb-1 text-dark"><?= htmlspecialchars($row['title']); ?></h6>
                                        <small class="text-secondary"><i class="fa-regular fa-clock me-1"></i> <?= $waktu_mulai . ' - ' . $waktu_selesai; ?></small>
                                    </div>
                                    <span class="badge rounded-pill bg-white <?= $badge_class; ?> shadow-sm border px-2 py-1" style="font-size: 0.75rem;"><?= $row['category']; ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
            <?php 
                } 
            } else { 
                echo "<p class='text-muted text-center my-4 small'>Belum ada agenda jadwal hari ini. Klik '+ Tambah jadwal' untuk mengisi kegiatanmu!</p>";
            } 
            ?>

        </div>
    </div>
</div>

<div class="modal fade" id="modalTambahJadwal" tabindex="-1" aria-labelledby="modalTambahJadwalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header border-0 pt-4 px-4">
                <h5 class="modal-title fw-bold" id="modalTambahJadwalLabel" style="color: var(--uneeds-text-green);">
                    <i class="fa-solid fa-calendar-plus me-2"></i>Tambah Jadwal Baru
                </h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form action="" method="POST">
                <div class="modal-body px-4 pb-4">
                    <div class="mb-3">
                        <label for="schedule_title" class="form-label fw-semibold small">Nama Kegiatan</label>
                        <input type="text" class="form-control form-control-lg border-2 shadow-none" id="schedule_title" name="schedule_title" placeholder="Misal: Kuliah Basis Data" required style="border-radius: 10px; font-size: 0.95rem;">
                    </div>
                    
                    <div class="row g-3 mb-3">
                        <div class="col-6">
                            <label for="start_time" class="form-label fw-semibold small">Jam Mulai</label>
                            <input type="time" class="form-control border-2 shadow-none" id="start_time" name="start_time" required style="border-radius: 10px; height: 45px;">
                        </div>
                        <div class="col-6">
                            <label for="end_time" class="form-label fw-semibold small">Jam Selesai</label>
                            <input type="time" class="form-control border-2 shadow-none" id="end_time" name="end_time" required style="border-radius: 10px; height: 45px;">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="category" class="form-label fw-semibold small">Kategori</label>
                        <select class="form-select border-2 shadow-none" id="category" name="category" required style="border-radius: 10px; height: 45px;">
                            <option value="Tugas">Tugas</option>
                            <option value="Kampus">Kampus</option>
                            <option value="Istirahat">Istirahat</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>
                </div>
                
                <div class="modal-footer border-0 px-4 pb-4 pt-0 d-flex gap-2">
                    <button type="button" class="btn btn-light w-50 fw-semibold py-2" data-bs-dismiss="modal" style="border-radius: 10px;">Batal</button>
                    <button type="submit" name="submit_schedule" class="btn btn-uneeds w-50 fw-semibold py-2" style="border-radius: 10px; background-color: var(--uneeds-text-green); color: white;">Simpan Jadwal</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include '../components/footer.php'; ?>

<?php if (isset($_SESSION['sukses_tambah_jadwal'])): ?>
    <script>
        Swal.fire({
            title: 'Jadwal Disimpan! 🗓️',
            text: 'Agenda barumu berhasil dimasukkan ke dalam timeline',
            icon: 'success',
            confirmButtonColor: '#2e7d32',
            confirmButtonText: 'Siap'
        });
    </script>
    <?php unset($_SESSION['sukses_tambah_jadwal']); ?>
<?php endif; ?>