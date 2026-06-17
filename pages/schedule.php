<?php
// Mulai session di bagian paling atas untuk mengamankan notifikasi
session_start();

// KUNCI HALAMAN: Jika tidak ada session login, usir pengunjung ke halaman login
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit();
} 

// Panggil file jembatan koneksi database
include '../config.php';

// SETTING TANGGAL OTOMATIS INDONESIA
date_default_timezone_set('Asia/Jakarta');

$hari_id = ['Sunday' => 'Minggu', 'Monday' => 'Senin', 'Tuesday' => 'Selasa', 'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu'];
$bulan_id = [1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

$hari_eng  = date('l');
$hari_ini  = $hari_id[$hari_eng];
$tanggal   = date('j');
$bulan_num = date('n');
$bulan_ini = $bulan_id[$bulan_num];
$tahun     = date('Y');

// FUNGSI CREATE: Proses Tambah Jadwal Baru dari Modal
if (isset($_POST['submit_schedule'])) {
    $title      = mysqli_real_escape_string($conn, $_POST['title']);
    $start_time = mysqli_real_escape_string($conn, $_POST['start_time']);
    $end_time   = mysqli_real_escape_string($conn, $_POST['end_time']);
    $category   = mysqli_real_escape_string($conn, $_POST['category']);
    
    $query = "INSERT INTO schedules (title, start_time, end_time, category) VALUES ('$title', '$start_time', '$end_time', '$category')";
    
    if (mysqli_query($conn, $query)) {
        $_SESSION['sukses_tambah_jadwal'] = true;
        header("Location: schedule.php");
        exit();
    } else {
        echo "<script>alert('Gagal menyimpan jadwal baru!');</script>";
    }
}

// FUNGSI UPDATE: Proses Edit/Perbarui Jadwal Kuliah yang Sudah Ada
if (isset($_POST['update_schedule'])) {
    $id             = mysqli_real_escape_string($conn, $_POST['id']);
    $schedule_title = mysqli_real_escape_string($conn, $_POST['schedule_title']);
    $start_time     = mysqli_real_escape_string($conn, $_POST['start_time']);
    $end_time       = mysqli_real_escape_string($conn, $_POST['end_time']);
    $category       = mysqli_real_escape_string($conn, $_POST['category']);
    
    $query_update = "UPDATE schedules SET 
                        title = '$schedule_title', 
                        start_time = '$start_time', 
                        end_time = '$end_time', 
                        category = '$category' 
                     WHERE id = '$id'";
    
    if (mysqli_query($conn, $query_update)) {
        $_SESSION['sukses_edit_jadwal'] = true;
        header("Location: schedule.php");
        exit();
    } else {
        echo "<script>alert('Gagal memperbarui jadwal.');</script>";
    }
}

// FUNGSI READ: Ambil semua data jadwal kuliah untuk ditampilkan
$query_tampil = "SELECT * FROM schedules ORDER BY start_time ASC";
$tampil_schedule = mysqli_query($conn, $query_tampil);
?>

<?php include '../components/header.php'; ?>
<?php include '../components/navbar.php'; ?>

<script>document.getElementById('nav-schedule').classList.add('active');</script>

<div class="container pt-4 mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1" style="color: var(--uneeds-text-green);">Today's Schedule</h2>
            <small class="uneeds-date fw-semibold" style="color: #006F39;"><?= $hari_ini . ', ' . $tanggal . ' ' . $bulan_ini . ' ' . $tahun; ?></small>
        </div>
        <button class="btn btn-uneeds shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambahJadwal">
            <i class="fa-solid fa-plus me-1"></i> Jadwal baru
        </button>
    </div>

    <div class="card p-4 content-card shadow-sm mb-4">
        <h6 class="fw-bold mb-3" style="color: var(--uneeds-text-green);">Agenda Hari Ini</h6>
        <div class="d-flex flex-column gap-3">
            
            <?php 
            if (mysqli_num_rows($tampil_schedule) > 0) {
                while ($row = mysqli_fetch_assoc($tampil_schedule)) { 
                    
                    // 💡 KUNCI WARNA BALOK DINAMIS KITA KEMBALIKAN DI SINI
                    $bg_color = 'var(--uneeds-navbar-pink)';       // Default warna pink pastel
                    $border_color = 'var(--uneeds-check-pink)';    // Default border pink
                    $badge_class = 'text-danger border-danger-subtle'; 

                    if ($row['category'] == 'Kampus') {
                        $bg_color = '#f0f7f4';                     // Hijau pastel lembut
                        $border_color = '#2e7d32';                 // Hijau pekat
                        $badge_class = 'text-primary border-primary-subtle';
                    } elseif ($row['category'] == 'Istirahat') {
                        $bg_color = '#fffde7';                     // Kuning pastel
                        $border_color = '#fbc02d';                 // Kuning tua
                        $badge_class = 'text-warning border-warning-subtle';
                    } elseif ($row['category'] == 'Tugas') {
                        $bg_color = 'var(--uneeds-bg-success)';    // Sukses hijau muda
                        $border_color = 'var(--uneeds-text-green)';// Hijau Uneeds
                        $badge_class = 'text-success border-success-subtle';
                    } elseif ($row['category'] == 'Lainnya') {
                        $bg_color = '#f3f4f6';                     // Abu-abu terang
                        $border_color = '#6b7280';                 // Abu-abu gelap
                        $badge_class = 'text-secondary border-secondary-subtle';
                    }
            ?>
                    <div class="p-3 rounded d-flex justify-content-between align-items-center shadow-sm border-start border-4" style="background-color: <?= $bg_color; ?>; border-left-color: <?= $border_color; ?> !important;">
                        <div>
                            <span class="text-muted small fw-semibold">
                                <i class="fa-regular fa-clock me-1"></i>
                                <?= date('H:i', strtotime($row['start_time'])); ?> - <?= date('H:i', strtotime($row['end_time'])); ?> WIB
                            </span>
                            <h5 class="fw-bold m-0 mt-1" style="color: #333; font-size: 1.05rem;"><?= htmlspecialchars($row['title']); ?></h5>
                        </div>
                        
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge rounded-pill bg-white <?= $badge_class; ?> shadow-sm border px-2 py-1" style="font-size: 0.75rem;"><?= $row['category']; ?></span>
                            
                            <button class="btn btn-sm btn-light border-0 text-secondary shadow-none p-1" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#modalEditJadwal" 
                                    data-id="<?= $row['id']; ?>"
                                    data-title="<?= htmlspecialchars($row['title']); ?>"
                                    data-start="<?= $row['start_time']; ?>"
                                    data-end="<?= $row['end_time']; ?>"
                                    data-category="<?= $row['category']; ?>"
                                    onclick="isiDataModalEdit(this)">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                        </div>
                    </div>
            <?php 
                } 
            } else { 
                echo "<p class='text-muted text-center my-4 small'>Belum ada agenda terdaftar hari ini. Klik '+ Jadwal baru' untuk menyusun rencana!</p>";
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
                    <i class="fa-solid fa-circle-plus me-2"></i>Tambah Jadwal Baru
                </h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form action="" method="POST">
                <div class="modal-body px-4 pb-4">
                    <div class="mb-3">
                        <label for="title" class="form-label fw-semibold small">Nama Kegiatan / Mata Kuliah</label>
                        <input type="text" class="form-control form-control-lg border-2 shadow-none" id="title" name="title" placeholder="Misal: Kuliah Platform Web" required style="border-radius: 10px; font-size: 0.95rem;">
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
                        <label for="category" class="form-label fw-semibold small">Kategori Kegiatan</label>
                        <select class="form-select border-2 shadow-none" id="category" name="category" required style="border-radius: 10px; height: 45px;">
                            <option value="Kampus">🏫 Kampus / Kuliah</option>
                            <option value="Tugas">📝 Tugas / Praktikum</option>
                            <option value="Istirahat">🍿 Istirahat / Santai</option>
                            <option value="Lainnya">✨ Lainnya</option>
                        </select>
                    </div>
                </div>
                
                <div class="modal-footer border-0 px-4 pb-4 pt-0 d-flex gap-2">
                    <button type="button" class="btn btn-light w-50 fw-semibold py-2" data-bs-dismiss="modal" style="border-radius: 10px;">Batal</button>
                    <button type="submit" name="submit_schedule" class="btn btn-uneeds w-50 fw-semibold py-2" style="border-radius: 10px; background-color: var(--uneeds-text-green); color: white;">Simpan Agenda</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEditJadwal" tabindex="-1" aria-labelledby="modalEditJadwalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header border-0 pt-4 px-4">
                <h5 class="modal-title fw-bold" id="modalEditJadwalLabel" style="color: var(--uneeds-text-green);">
                    <i class="fa-solid fa-pen-to-square me-2"></i>Edit Jadwal Kuliah
                </h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form action="" method="POST">
                <input type="hidden" id="edit_id" name="id">

                <div class="modal-body px-4 pb-4">
                    <div class="mb-3">
                        <label for="edit_title" class="form-label fw-semibold small">Nama Kegiatan / Mata Kuliah</label>
                        <input type="text" class="form-control form-control-lg border-2 shadow-none" id="edit_title" name="schedule_title" required style="border-radius: 10px; font-size: 0.95rem;">
                    </div>
                    
                    <div class="row g-3 mb-3">
                        <div class="col-6">
                            <label for="edit_start_time" class="form-label fw-semibold small">Jam Mulai</label>
                            <input type="time" class="form-control border-2 shadow-none" id="edit_start_time" name="start_time" required style="border-radius: 10px; height: 45px;">
                        </div>
                        <div class="col-6">
                            <label for="edit_end_time" class="form-label fw-semibold small">Jam Selesai</label>
                            <input type="time" class="form-control border-2 shadow-none" id="edit_end_time" name="end_time" required style="border-radius: 10px; height: 45px;">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="edit_category" class="form-label fw-semibold small">Kategori Kegiatan</label>
                        <select class="form-select border-2 shadow-none" id="edit_category" name="category" required style="border-radius: 10px; height: 45px;">
                            <option value="Kampus">Kampus</option>
                            <option value="Tugas">Tugas</option>
                            <option value="Istirahat">Istirahat</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>
                </div>
                
                <div class="modal-footer border-0 px-4 pb-4 pt-0 d-flex gap-2">
                    <button type="button" class="btn btn-light w-50 fw-semibold py-2" data-bs-dismiss="modal" style="border-radius: 10px;">Batal</button>
                    <button type="submit" name="update_schedule" class="btn btn-uneeds w-50 fw-semibold py-2" style="border-radius: 10px; background-color: var(--uneeds-text-green); color: white;">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include '../components/footer.php'; ?>

<script>
function isiDataModalEdit(tombol) {
    document.getElementById('edit_id').value = tombol.getAttribute('data-id');
    document.getElementById('edit_title').value = tombol.getAttribute('data-title');
    document.getElementById('edit_start_time').value = tombol.getAttribute('data-start');
    document.getElementById('edit_end_time').value = tombol.getAttribute('data-end');
    document.getElementById('edit_category').value = tombol.getAttribute('data-category');
}
</script>

<?php if (isset($_SESSION['sukses_tambah_jadwal'])): ?>
    <script>
        Swal.fire({ title: 'Berhasil Disimpan! 📅', text: 'Agenda barumu berhasil ditambahkan ke jadwal hari ini', icon: 'success', confirmButtonColor: '#2e7d32' });
    </script>
    <?php unset($_SESSION['sukses_tambah_jadwal']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['sukses_edit_jadwal'])): ?>
    <script>
        Swal.fire({ title: 'Jadwal Diperbarui! ✏️', text: 'Perubahan agenda kuliahmu berhasil disimpan ke database Uneeds', icon: 'success', confirmButtonColor: '#2e7d32' });
    </script>
    <?php unset($_SESSION['sukses_edit_jadwal']); ?>
<?php endif; ?>