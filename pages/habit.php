<?php include '../components/header.php'; ?>
<?php include '../components/navbar.php'; ?>

<!-- Menandai Menu Habit Tracker Sedang Aktif di Navbar -->
<script>document.getElementById('nav-habit').classList.add('active');</script>

<div class="container mb-5">
    <!-- BARIS KEPALA: Judul Halaman & Tombol Tambah Habit -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1" style="color: var(--uneeds-text-green);">Habit Tracker</h2>
            <small class="uneeds-date">Monday, 15 June 2026</small>
        </div>
        <button class="btn btn-uneeds shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambahHabit">
            <i class="fa-solid fa-plus me-1"></i> New Habit
        </button>
    </div>

    <!-- TIGA KOTAK STATISTIK HABIT -->
    <div class="row g-3 mb-4">
        <div class="col-4">
            <div class="card p-3 stat-card text-center shadow-sm">
                <h3 class="fw-bold mb-1">5</h3>
                <small class="text-muted">Active Habit</small>
            </div>
        </div>
        <div class="col-4">
            <div class="card p-3 stat-card success-variant text-center shadow-sm">
                <h3 class="fw-bold mb-1">3</h3>
                <small class="text-muted">Finished Today</small>
            </div>
        </div>
        <div class="col-4">
            <div class="card p-3 stat-card pink-variant text-center shadow-sm">
                <h3 class="fw-bold mb-1">12</h3>
                <small class="text-muted">Streak</small>
            </div>
        </div>
    </div>

    <!-- UTAMA KOLOM KIRI: CHECK-IN HARI INI -->
    <div class="card p-4 content-card shadow-sm mb-4">
        <h6 class="fw-bold mb-3" style="color: var(--uneeds-text-green);">Today Check-in </h6>
        <div class="d-flex flex-column gap-3">
            <!-- Baris Habit 1 -->
            <div class="p-2 rounded d-flex justify-content-between align-items-center" style="background-color: #fafafa;">
                <div class="form-check m-0 d-flex align-items-center">
                    <input class="form-check-input me-3" type="checkbox" checked id="habit1" style="width: 24px; height: 24px;">
                    <label class="form-check-label fw-semibold" for="habit1">Olahraga 30 menit</label>
                </div>
                <span class="badge rounded-pill px-3 py-2" style="background-color: #e8f5e9; color: var(--uneeds-text-green); font-size: 0.8rem;">7 days in a row</span>
            </div>
            <!-- Baris Habit 2 -->
            <div class="p-2 rounded d-flex justify-content-between align-items-center" style="background-color: #fafafa;">
                <div class="form-check m-0 d-flex align-items-center">
                    <input class="form-check-input me-3" type="checkbox" checked id="habit2" style="width: 24px; height: 24px;">
                    <label class="form-check-label fw-semibold" for="habit2">Baca 20 halaman</label>
                </div>
                <span class="badge rounded-pill px-3 py-2" style="background-color: #e8f5e9; color: var(--uneeds-text-green); font-size: 0.8rem;">3 days in a row</span>
            </div>
            <!-- Baris Habit 3 -->
            <div class="p-2 rounded d-flex justify-content-between align-items-center" style="background-color: #fafafa;">
                <div class="form-check m-0 d-flex align-items-center">
                    <input class="form-check-input me-3" type="checkbox" id="habit3" style="width: 24px; height: 24px;">
                    <label class="form-check-label fw-semibold" for="habit3">Minum 2L air</label>
                </div>
                <span class="badge rounded-pill bg-light text-secondary px-3 py-2" style="font-size: 0.8rem;">Not completed</span>
            </div>
            <!-- Baris Habit 4 -->
            <div class="p-2 rounded d-flex justify-content-between align-items-center" style="background-color: #fafafa;">
                <div class="form-check m-0 d-flex align-items-center">
                    <input class="form-check-input me-3" type="checkbox" id="habit4" style="width: 24px; height: 24px;">
                    <label class="form-check-label fw-semibold" for="habit4">Coding 1 jam</label>
                </div>
                <span class="badge rounded-pill bg-light text-secondary px-3 py-2" style="font-size: 0.8rem;">Not completed</span>
            </div>
        </div>
    </div>

    <!-- KOMPONEN GRAFIK: KONSISTENSI MINGGU INI -->
    <div class="card p-4 content-card shadow-sm">
        <h6 class="fw-bold mb-4" style="color: var(--uneeds-text-green);">Consistency This Week</h6>
        
        <!-- Kontainer Grafik Batang Menggunakan CSS Flexbox Responsif -->
        <div class="d-flex justify-content-between align-items-end px-2 pt-3" style="height: 160px; border-bottom: 2px solid #eeeeee;">
            <!-- Batang Senin -->
            <div class="d-flex flex-column align-items-center w-100">
                <div class="w-50 shadow-sm" style="height: 120px; background-color: var(--uneeds-check-pink); border-radius: 8px 8px 0 0;"></div>
            </div>
            <!-- Batang Selasa -->
            <div class="d-flex flex-column align-items-center w-100">
                <div class="w-50 shadow-sm" style="height: 140px; background-color: var(--uneeds-check-pink); border-radius: 8px 8px 0 0;"></div>
            </div>
            <!-- Batang Rabu -->
            <div class="d-flex flex-column align-items-center w-100">
                <div class="w-50 shadow-sm" style="height: 110px; background-color: var(--uneeds-check-pink); border-radius: 8px 8px 0 0;"></div>
            </div>
            <!-- Batang Kamis -->
            <div class="d-flex flex-column align-items-center w-100">
                <div class="w-50 shadow-sm" style="height: 60px; background-color: var(--uneeds-check-pink); border-radius: 8px 8px 0 0;"></div>
            </div>
            <!-- Batang Jumat -->
            <div class="d-flex flex-column align-items-center w-100">
                <div class="w-50 shadow-sm" style="height: 40px; background-color: var(--uneeds-check-pink); border-radius: 8px 8px 0 0;"></div>
            </div>
            <!-- Batang Sabtu -->
            <div class="d-flex flex-column align-items-center w-100">
                <div class="w-50 shadow-sm" style="height: 15px; background-color: #eeeeee; border-radius: 4px 4px 0 0;"></div>
            </div>
            <!-- Batang Minggu -->
            <div class="d-flex flex-column align-items-center w-100">
                <div class="w-50 shadow-sm" style="height: 15px; background-color: #eeeeee; border-radius: 4px 4px 0 0;"></div>
            </div>
        </div>
        
        <!-- Label Nama Hari di Bawah Batang Grafik -->
        <div class="d-flex justify-content-between align-items-center mt-2 text-center text-muted fw-semibold" style="font-size: 0.75rem;">
            <div class="w-100">Mon</div>
            <div class="w-100">Tues</div>
            <div class="w-100">Wed</div>
            <div class="w-100">Thurs</div>
            <div class="w-100">Fri</div>
            <div class="w-100">Sat</div>
            <div class="w-100">Sun</div>
        </div>
    </div>
</div>

<!-- MODAL FORM POP-UP: TAMBAH HABIT BARU -->
<div class="modal fade" id="modalTambahHabit" tabindex="-1" aria-labelledby="modalTambahHabitLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header border-0 pt-4 px-4">
                <h5 class="modal-title fw-bold" id="modalTambahHabitLabel" style="color: var(--uneeds-text-green);">
                    <i class="fa-solid fa-arrows-spin me-2"></i>New Habit
                </h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form action="" method="POST">
                <div class="modal-body px-4 pb-4">
                    <div class="mb-3">
                        <label for="habit_name" class="form-label fw-semibold small">Habit</label>
                        <input type="text" class="form-control form-control-lg border-2 shadow-none" id="habit_name" name="habit_name" placeholder="Ex: Minum Air Putih 2L" required style="border-radius: 10px; font-size: 0.95rem;">
                    </div>
                </div>
                <div class="modal-footer border-0 px-4 pb-4 pt-0 d-flex gap-2">
                    <button type="button" class="btn btn-light w-50 fw-semibold py-2" data-bs-dismiss="modal" style="border-radius: 10px;">Cancel</button>
                    <button type="submit" name="submit_habit" class="btn btn-uneeds w-50 fw-semibold py-2" style="border-radius: 10px; background-color: var(--uneeds-text-green); color: white;">Save Habit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include '../components/footer.php'; ?>