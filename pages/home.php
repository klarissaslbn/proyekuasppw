<?php include '../components/header.php'; ?>
<?php include '../components/navbar.php'; ?>

<!-- Menandai Menu Home Sedang Aktif -->
<script>document.getElementById('nav-home').classList.add('active');</script>

<div class="container mb-5">
    <!-- Section Welcome Banner -->
    <div class="mb-4">
        <h2 class="fw-bold mb-1">Welcome,Klarissa!</h2>
        <p class="uneeds-date mb-0">Monday, 15 June 2026</p>
    </div>

    <!-- Grid 4 Kotak Indikator (Otomatis Menyesuaikan saat Layar HP) -->
    <div class="row g-3 mb-5">
        <div class="col-6 col-md-3">
            <div class="card p-3 stat-card shadow-sm">
                <div class="d-flex align-items-center gap-2 mb-2 text-secondary"><i class="fa-regular fa-clipboard"></i> My Task </div>
                <h3 class="fw-bold mb-0">8</h3>
                <small class="text-muted"> Task </small>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card p-3 stat-card shadow-sm">
                <div class="d-flex align-items-center gap-2 mb-2 text-secondary"><i class="fa-regular fa-calendar-check"></i> Habits</div>
                <h3 class="fw-bold mb-0">5</h3>
                <small class="text-muted">Active Habit</small>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card p-3 stat-card shadow-sm">
                <div class="d-flex align-items-center gap-2 mb-2 text-secondary"><i class="fa-regular fa-clock"></i> Schedule </div>
                <h3 class="fw-bold mb-0">5</h3>
                <small class="text-muted">Today Schedule</small>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card p-3 stat-card shadow-sm">
                <div class="d-flex align-items-center gap-2 mb-2 text-secondary"><i class="fa-solid fa-fire-flame-curved text-danger"></i> Streak</div>
                <h3 class="fw-bold mb-0">12</h3>
                <small class="text-muted">days</small>
            </div>
        </div>
    </div>

    <!-- Tata Letak Konten 2 Kolom -->
    <div class="row g-4">
        <!-- Kolom Kiri: Ringkasan Hari Ini -->
        <div class="col-md-6">
            <div class="card p-4 content-card shadow-sm h-100">
                <h5 class="fw-bold mb-4"> Today's To-do </h5>
                <div class="d-flex flex-column gap-3">
                    <div class="d-flex justify-content-between align-items-center p-2 rounded" style="background-color: #fafafa;">
                        <div class="form-check m-0">
                            <input class="form-check-input me-2" type="checkbox" checked disabled id="hTask1">
                            <label class="form-check-label text-muted text-decoration-line-through" for="hTask1">Kerjakan Proyek UAS PPW</label>
                        </div>
                        <span class="badge rounded-pill bg-danger-subtle text-danger">High</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center p-2 rounded" style="background-color: #fafafa;">
                        <div class="form-check m-0">
                            <input class="form-check-input m-0 me-2" type="checkbox" disabled id="hTask2">
                            <label class="form-check-label" for="hTask2">Review ERD database</label>
                        </div>
                        <span class="badge rounded-pill bg-danger-subtle text-danger">High</span>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="todo.php" class="text-decoration-none fw-bold text-success">View To Do List <i class="fa-solid fa-arrow-right ms-1"></i></a>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan: Jadwal Selanjutnya -->
        <div class="col-md-6">
            <div class="card p-4 content-card shadow-sm h-100">
                <h5 class="fw-bold mb-4">Next Schedule </h5>
                <div class="d-flex flex-column gap-3">
                    <div class="d-flex align-items-center p-2 rounded" style="background-color: #fafafa;">
                        <div class="fw-bold text-success me-4" style="min-width: 50px;">13.00</div>
                        <div class="text-dark">Review ERD & coding</div>
                    </div>
                    <div class="d-flex align-items-center p-2 rounded" style="background-color: #fafafa;">
                        <div class="fw-bold text-success me-4" style="min-width: 50px;">14.00</div>
                        <div class="text-dark">Istirahat & makan siang</div>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="schedule.php" class="text-decoration-none fw-bold text-success"> View Today Schedule <i class="fa-solid fa-arrow-right ms-1"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../components/footer.php'; ?>