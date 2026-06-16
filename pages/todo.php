<?php
// 1. Panggil file jembatan koneksi database
include '../config.php';

// 2. Cek apakah tombol "Simpan Tugas" dari modal sudah diklik (Fungsi CREATE)
if (isset($_POST['submit_tugas'])) {
    $title    = mysqli_real_escape_string($conn, $_POST['title']);
    $priority = mysqli_real_escape_string($conn, $_POST['priority']);
    $due_date = mysqli_real_escape_string($conn, $_POST['due_date']);
    
    $query = "INSERT INTO todos (title, priority, due_date, status) VALUES ('$title', '$priority', '$due_date', 'Belum')";
    
    if (mysqli_query($conn, $query)) {
        echo "<script>
            alert('Yess! Tugas barumu berhasil disimpan ke database Uneeds ✨');
            window.location.href = 'todo.php';
        </script>";
        exit();
    } else {
        echo "<script>alert('Aduh, gagal menyimpan tugas baru!');</script>";
    }
}

// 3. Cek apakah ada pengiriman data dari form mini checkbox (Fungsi UPDATE)
if (isset($_POST['check_selesai']) && isset($_POST['todo_id'])) {
    $todo_id = mysqli_real_escape_string($conn, $_POST['todo_id']);
    
    $query_update = "UPDATE todos SET status = 'Selesai' WHERE id = '$todo_id'";
    
    if (mysqli_query($conn, $query_update)) {
        echo "<script>
            alert('Hebat! Tugas telah diselesaikan ✨');
            window.location.href = 'todo.php';
        </script>";
        exit();
    }
}

// 4. HITUNG STATISTIK TUGAS SECARA OTOMATIS (Fungsi SQL Aggregation)
$query_total = "SELECT COUNT(*) as total FROM todos";
$res_total   = mysqli_query($conn, $query_total);
$data_total  = mysqli_fetch_assoc($res_total);
$total_tugas = $data_total['total'];

$query_selesai = "SELECT COUNT(*) as total FROM todos WHERE status = 'Selesai'";
$res_selesai   = mysqli_query($conn, $query_selesai);
$data_selesai  = mysqli_fetch_assoc($res_selesai);
$total_selesai = $data_selesai['total'];

$query_sisa = "SELECT COUNT(*) as total FROM todos WHERE status = 'Belum'";
$res_sisa   = mysqli_query($conn, $query_sisa);
$data_sisa  = mysqli_fetch_assoc($res_sisa);
$total_sisa = $data_sisa['total'];

// 5. Ambil semua data tugas yang berstatus 'Belum' dari database (Fungsi READ)
$query_tampil = "SELECT * FROM todos WHERE status = 'Belum' ORDER BY id DESC";
$tampil_tugas = mysqli_query($conn, $query_tampil);
?>

<?php include '../components/header.php'; ?>
<?php include '../components/navbar.php'; ?>

<script>document.getElementById('nav-todo').classList.add('active');</script>

<div class="container mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1" style="color: var(--uneeds-text-green);">To Do List</h2>
            <small class="uneeds-date">Senin, 15 Juni 2026</small>
        </div>
        <button class="btn btn-uneeds shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambah">
            <i class="fa-solid fa-plus me-1"></i> Tugas baru
        </button>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-4">
            <div class="card p-3 stat-card text-center shadow-sm">
                <h3 class="fw-bold mb-1"><?= $total_tugas; ?></h3>
                <small class="text-muted">Total</small>
            </div>
        </div>
        <div class="col-4">
            <div class="card p-3 stat-card success-variant text-center shadow-sm">
                <h3 class="fw-bold mb-1"><?= $total_selesai; ?></h3>
                <small class="text-muted">Selesai</small>
            </div>
        </div>
        <div class="col-4">
            <div class="card p-3 stat-card pink-variant text-center shadow-sm">
                <h3 class="fw-bold mb-1"><?= $total_sisa; ?></h3>
                <small class="text-muted">Sisa</small>
            </div>
        </div>
    </div>

    <div class="card p-4 content-card shadow-sm mb-4">
        <h6 class="fw-bold mb-3" style="color: var(--uneeds-text-green);">Daftar Tugas Aktif</h6>
        <div class="d-flex flex-column gap-2">
            
            <?php 
            if (mysqli_num_rows($tampil_tugas) > 0) {
                while ($row = mysqli_fetch_assoc($tampil_tugas)) { 
                    $badge_color = 'bg-success-subtle text-success'; 
                    if ($row['priority'] == 'Tinggi') {
                        $badge_color = 'bg-danger-subtle text-danger';
                    } elseif ($row['priority'] == 'Sedang') {
                        $badge_color = 'bg-warning-subtle text-warning';
                    }
            ?>
                    <form action="" method="POST" id="form_check_<?= $row['id']; ?>">
                        <input type="hidden" name="todo_id" value="<?= $row['id']; ?>">
                        
                        <div class="p-2 rounded d-flex justify-content-between align-items-center" style="background-color: #fafafa;">
                            <div class="form-check m-0">
                                <input class="form-check-input me-2" type="checkbox" name="check_selesai" id="todo_<?= $row['id']; ?>" onchange="this.form.submit()">
                                <label class="form-check-label" for="todo_<?= $row['id']; ?>">
                                    <?= htmlspecialchars($row['title']); ?>
                                </label>
                            </div>
                            <span class="badge rounded-pill <?= $badge_color; ?> px-2 py-1" style="font-size: 0.75rem;">
                                <?= $row['priority']; ?>
                            </span>
                        </div>
                    </form>
            <?php 
                } 
            } else { 
                echo "<p class='text-muted text-center my-3 small'>Belum ada tugas aktif. Klik '+ Tugas baru' untuk menambahkan!</p>";
            } 
            ?>

        </div>
    </div>
</div>

<div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header border-0 pt-4 px-4">
                <h5 class="modal-title fw-bold" id="modalTambahLabel" style="color: var(--uneeds-text-green);">
                    <i class="fa-solid fa-circle-plus me-2"></i>Tambah Tugas Baru
                </h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form action="" method="POST" id="formTambahTugas">
                <div class="modal-body px-4 pb-4">
                    <div class="mb-3">
                        <label for="title" class="form-label fw-semibold small">Nama / Judul Tugas</label>
                        <input type="text" class="form-control form-control-lg border-2 shadow-none" id="title" name="title" placeholder="Misal: Revisi ERD Bab 2" required style="border-radius: 10px; font-size: 0.95rem;">
                    </div>
                    
                    <div class="row g-3 mb-3">
                        <div class="col-6">
                            <label for="priority" class="form-label fw-semibold small">Tingkat Prioritas</label>
                            <select class="form-select border-2 shadow-none" id="priority" name="priority" required style="border-radius: 10px; height: 45px;">
                                <option value="Rendah">🟢 Rendah</option>
                                <option value="Sedang">🟡 Sedang</option>
                                <option value="Tinggi">🔴 Tinggi</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label for="due_date" class="form-label fw-semibold small">Tenggat Waktu</label>
                            <input type="date" class="form-control border-2 shadow-none" id="due_date" name="due_date" required style="border-radius: 10px; height: 45px;">
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer border-0 px-4 pb-4 pt-0 d-flex gap-2">
                    <button type="button" class="btn btn-light w-50 fw-semibold py-2" data-bs-dismiss="modal" style="border-radius: 10px;">Batal</button>
                    <button type="submit" name="submit_tugas" class="btn btn-uneeds w-50 fw-semibold py-2" style="border-radius: 10px; background-color: var(--uneeds-text-green); color: white;">Simpan Tugas</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include '../components/footer.php'; ?>