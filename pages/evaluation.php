<?php
// Mulai session di bagian paling atas untuk mengamankan notifikasi SweetAlert2
session_start();

// 2. KUNCI HALAMAN: Jika tidak ada session login, usir pengunjung ke halaman login
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit();
}

// 1. Hubungkan ke database lewat file jembatan
include '../config.php';

// 2. FUNGSI CREATE: Proses Simpan Evaluasi Harian
if (isset($_POST['submit_evaluation'])) {
    $evaluation_text = mysqli_real_escape_string($conn, $_POST['evaluation_text']);
    $mood_rating     = mysqli_real_escape_string($conn, $_POST['mood_rating']);
    
    $query = "INSERT INTO evaluations (evaluation_text, mood_rating) VALUES ('$evaluation_text', '$mood_rating')";
    
    if (mysqli_query($conn, $query)) {
        $_SESSION['sukses_tambah_evaluasi'] = true;
        header("Location: evaluation.php");
        exit();
    } else {
        echo "<script>alert('Gagal menyimpan evaluasi baru.'); window.location.href='evaluation.php';</script>";
        exit();
    }
}

// 3. FUNGSI READ: Ambil semua data evaluasi, urutkan dari yang paling baru (DESC)
$query_tampil = "SELECT * FROM evaluations ORDER BY id DESC";
$tampil_evaluation = mysqli_query($conn, $query_tampil);
?>

<?php include '../components/header.php'; ?>
<?php include '../components/navbar.php'; ?>

<script>document.getElementById('nav-evaluation').classList.add('active');</script>

<div class="container pt-4 mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1" style="color: var(--uneeds-text-green);">Evaluation</h2>
            <small class="text-muted">Bagaimana harimu hari ini?</small>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-12 col-md-5">
            <div class="card p-4 content-card shadow-sm">
                <h5 class="fw-bold mb-3" style="color: var(--uneeds-text-green);">Catat Evaluasi Hari Ini</h5>
                <form action="" method="POST">
                    <div class="mb-3">
                        <label for="evaluation_text" class="form-label fw-semibold small">Apa yang kamu rasakan atau pelajari hari ini?</label>
                        <textarea class="form-control border-2 shadow-none" id="evaluation_text" name="evaluation_text" rows="4" placeholder="Tulis refleksi singkat harimu di sini..." required style="border-radius: 10px; font-size: 0.95rem; resize: none;"></textarea>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label fw-semibold small d-block mb-2">Bagaimana tingkat kepuasan harimu?</label>
                        <div class="d-flex gap-2">
                            <input type="radio" class="btn-check" name="mood_rating" id="mood_puas" value="Puas" checked>
                            <label class="btn btn-outline-success w-100 fw-semibold" for="mood_puas" style="border-radius: 10px; font-size: 0.85rem;">😊 Puas</label>

                            <input type="radio" class="btn-check" name="mood_rating" id="mood_biasa" value="Biasa">
                            <label class="btn btn-outline-warning text-dark w-100 fw-semibold" for="mood_biasa" style="border-radius: 10px; font-size: 0.85rem;">😐 Biasa</label>

                            <input type="radio" class="btn-check" name="mood_rating" id="mood_kecewa" value="Kecewa">
                            <label class="btn btn-outline-danger w-100 fw-semibold" for="mood_kecewa" style="border-radius: 10px; font-size: 0.85rem;">😞 Kecewa</label>
                        </div>
                    </div>

                    <button type="submit" name="submit_evaluation" class="btn btn-uneeds w-100 py-2.5 fw-bold" style="background-color: var(--uneeds-text-green); color: white; border-radius: 10px;">
                        Simpan Evaluasi
                    </button>
                </form>
            </div>
        </div>

        <div class="col-12 col-md-7">
            <div class="card p-4 content-card shadow-sm">
                <h5 class="fw-bold mb-3" style="color: var(--uneeds-text-green);">Riwayat Jurnal Refleksi</h5>
                <div class="d-flex flex-column gap-3" style="max-height: 420px; overflow-y: auto; padding-right: 5px;">
                    
                    <?php 
                    if ($tampil_evaluation && mysqli_num_rows($tampil_evaluation) > 0) {
                        while ($row = mysqli_fetch_assoc($tampil_evaluation)) { 
                            // Penyesuaian emoji & warna border berdasarkan mood pilihan
                            $mood_emoji = '😊'; $mood_badge = 'bg-success-subtle text-success'; $border_color = '#2e7d32';
                            if ($row['mood_rating'] == 'Biasa') {
                                $mood_emoji = '😐'; $mood_badge = 'bg-warning-subtle text-warning text-dark'; $border_color = '#fbc02d';
                            } elseif ($row['mood_rating'] == 'Kecewa') {
                                $mood_emoji = '😞'; $mood_badge = 'bg-danger-subtle text-danger'; $border_color = '#d32f2f';
                            }

                            // Format tanggal lokal ringkas
                            $tanggal_jurnal = date('d M Y', strtotime($row['created_at']));
                    ?>
                            <div class="p-3 rounded border-start border-4" style="background-color: #fafafa; border-left-color: <?= $border_color; ?> !important;">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <small class="text-muted fw-semibold"><i class="fa-regular fa-calendar me-1"></i> <?= $tanggal_jurnal; ?></small>
                                    <span class="badge rounded-pill <?= $mood_badge; ?> px-2 py-1" style="font-size: 0.75rem;"><?= $mood_emoji . ' ' . $row['mood_rating']; ?></span>
                                </div>
                                <p class="mb-0 text-dark small" style="line-height: 1.5; font-style: italic;">
                                    "<?= htmlspecialchars($row['evaluation_text']); ?>"
                                </p>
                            </div>
                    <?php 
                        } 
                    } else { 
                        echo "<p class='text-muted text-center my-4 small'>Belum ada riwayat evaluasi. Yuk catat bagaimana harimu di form sebelah kiri!</p>";
                    } 
                    ?>

                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../components/footer.php'; ?>

<?php if (isset($_SESSION['sukses_tambah_evaluasi'])): ?>
    <script>
        Swal.fire({
            title: 'Jurnal Tersimpan! 📝',
            text: 'Refleksi harimu berhasil direkam dengan aman.',
            icon: 'success',
            confirmButtonColor: '#2e7d32',
            confirmButtonText: 'Bagus'
        });
    </script>
    <?php unset($_SESSION['sukses_tambah_evaluasi']); ?>
<?php endif; ?>