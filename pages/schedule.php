<?php include '../components/header.php'; ?>
<?php include '../components/navbar.php'; ?>

<script>document.getElementById('nav-schedule').classList.add('active');</script>

<div class="container mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1" style="color: var(--uneeds-text-green);">Today Schedule</h2>
            <small class="uneeds-date">Monday, 15 June 2026</small>
        </div>
        <button class="btn btn-uneeds shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambahJadwal">
            <i class="fa-solid fa-plus me-1"></i> New Schedule
        </button>
    </div>

    <div class="card p-4 content-card shadow-sm">
        <div class="position-relative">
            
            <div class="position-absolute d-none d-md-block" style="left: 85px; top: 10px; bottom: 10px; width: 2px; background-color: #eef2f0;"></div>

            <div class="row align-items-center mb-4 position-relative g-2">
                <div class="col-12 col-md-1">
                    <span class="fw-bold text-muted d-block" style="font-size: 0.95rem;">07.00</span>
                </div>
                <div class="col-12 col-md-11 ps-md-4">
                    <div class="p-3 rounded-3 shadow-sm border-0" style="background-color: var(--uneeds-bg-success); border-left: 5px solid var(--uneeds-text-green) !important;">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="fw-bold mb-1 text-dark">Olahraga pagi</h6>
                                <small class="text-secondary"><i class="fa-regular fa-clock me-1"></i> 07.00 - 07.30</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row align-items-center mb-4 position-relative g-2">
                <div class="col-12 col-md-1">
                    <span class="fw-bold text-muted d-block" style="font-size: 0.95rem;">08.00</span>
                </div>
                <div class="col-12 col-md-11 ps-md-4">
                    <div class="p-3 rounded-3 shadow-sm border-0" style="background-color: var(--uneeds-navbar-pink); border-left: 5px solid var(--uneeds-check-pink) !important;">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="fw-bold mb-1 text-dark">Kerjakan BAB 2 skripsi</h6>
                                <small class="text-secondary"><i class="fa-regular fa-clock me-1"></i> 08.00 - 10.00</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row align-items-center mb-4 position-relative g-2">
                <div class="col-12 col-md-1">
                    <span class="fw-bold text-muted d-block" style="font-size: 0.95rem;">10.00</span>
                </div>
                <div class="col-12 col-md-11 ps-md-4">
                    <div class="p-3 rounded-3 shadow-sm border-0" style="background-color: #f0f7f4; border-left: 5px solid #2e7d32 !important;">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="fw-bold mb-1 text-dark">Meeting dosen pembimbing</h6>
                                <small class="text-secondary"><i class="fa-regular fa-clock me-1"></i> 10.00 - 11.00</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row align-items-center mb-4 position-relative g-2">
                <div class="col-12 col-md-1">
                    <span class="fw-bold text-muted d-block" style="font-size: 0.95rem;">11.00</span>
                </div>
                <div class="col-12 col-md-11 ps-md-4">
                    <div class="p-3 rounded-3 shadow-sm border-0" style="background-color: #fffde7; border-left: 5px solid #fbc02d !important;">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="fw-bold mb-1 text-dark">Istirahat & makan siang</h6>
                                <small class="text-secondary"><i class="fa-regular fa-clock me-1"></i> 11.00 - 12.00</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row align-items-center position-relative g-2">
                <div class="col-12 col-md-1">
                    <span class="fw-bold text-muted d-block" style="font-size: 0.95rem;">13.00</span>
                </div>
                <div class="col-12 col-md-11 ps-md-4">
                    <div class="p-3 rounded-3 shadow-sm border-0" style="background-color: var(--uneeds-navbar-pink); border-left: 5px solid var(--uneeds-check-pink) !important;">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="fw-bold mb-1 text-dark">Review ERD & coding</h6>
                                <small class="text-secondary"><i class="fa-regular fa-clock me-1"></i> 13.00 - 15.00</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="modalTambahJadwal" tabindex="-1" aria-labelledby="modalTambahJadwalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header border-0 pt-4 px-4">
                <h5 class="modal-title fw-bold" id="modalTambahJadwalLabel" style="color: var(--uneeds-text-green);">
                    <i class="fa-solid fa-calendar-plus me-2"></i>New Schedule
                </h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form action="" method="POST">
                <div class="modal-body px-4 pb-4">
                    <div class="mb-3">
                        <label for="schedule_title" class="form-label fw-semibold small">Activity Name</label>
                        <input type="text" class="form-control form-control-lg border-2 shadow-none" id="schedule_title" name="schedule_title" placeholder="Ex: Kuliah Basis Data" required style="border-radius: 10px; font-size: 0.95rem;">
                    </div>
                    
                    <div class="row g-3 mb-3">
                        <div class="col-6">
                            <label for="start_time" class="form-label fw-semibold small">Start</label>
                            <input type="time" class="form-control border-2 shadow-none" id="start_time" name="start_time" required style="border-radius: 10px; height: 45px;">
                        </div>
                        <div class="col-6">
                            <label for="end_time" class="form-label fw-semibold small">Finish</label>
                            <input type="time" class="form-control border-2 shadow-none" id="end_time" name="end_time" required style="border-radius: 10px; height: 45px;">
                        </div>
                    </div>

                </div>
                
                <div class="modal-footer border-0 px-4 pb-4 pt-0 d-flex gap-2">
                    <button type="button" class="btn btn-light w-50 fw-semibold py-2" data-bs-dismiss="modal" style="border-radius: 10px;">Cancel</button>
                    <button type="submit" name="submit_schedule" class="btn btn-uneeds w-50 fw-semibold py-2" style="border-radius: 10px; background-color: var(--uneeds-text-green); color: white;">Save Schedule</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include '../components/footer.php'; ?>