<?php include '../components/header.php'; ?>
<?php include '../components/navbar.php'; ?>

<script>document.getElementById('nav-evaluation').classList.add('active');</script>

<div class="container mb-5" style="max-width: 800px;">
    <form action="" method="POST" id="formEvaluasi">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold mb-1" style="color: var(--uneeds-text-green);">Evaluation</h2>
                <small class="uneeds-date">Monday, 15 June 2026</small>
            </div>
            <button type="submit" name="submit_evaluation" class="btn btn-uneeds shadow-sm px-4">Save</button>
        </div>

        <div class="card p-4 content-card shadow-sm mb-4">
            <h6 class="fw-bold mb-3" style="color: var(--uneeds-text-green);">How do you feel today?</h6>
            
            <div class="d-flex justify-content-around align-items-center py-2">
                <div class="text-center">
                    <input type="radio" class="btn-check" name="mood" id="mood_sedih" value="Sedih" required>
                    <label class="btn btn-outline-light rounded-circle p-2 fs-3 shadow-sm border border-2" for="mood_sedih" style="width: 55px; height: 55px; transition: all 0.2s;">😢</label>
                </div>
                <div class="text-center">
                    <input type="radio" class="btn-check" name="mood" id="mood_bad" value="Kurang Baik">
                    <label class="btn btn-outline-light rounded-circle p-2 fs-3 shadow-sm border border-2" for="mood_bad" style="width: 55px; height: 55px; transition: all 0.2s;">🙁</label>
                </div>
                <div class="text-center">
                    <input type="radio" class="btn-check" name="mood" id="mood_neutral" value="Biasa Saja" checked>
                    <label class="btn btn-outline-light rounded-circle p-2 fs-3 shadow-sm border border-2" for="mood_neutral" style="width: 55px; height: 55px; transition: all 0.2s; border-color: var(--uneeds-check-pink) !important; background-color: #fff5f6;">😐</label>
                </div>
                <div class="text-center">
                    <input type="radio" class="btn-check" name="mood" id="mood_happy" value="Senang">
                    <label class="btn btn-outline-light rounded-circle p-2 fs-3 shadow-sm border border-2" for="mood_happy" style="width: 55px; height: 55px; transition: all 0.2s;">🙂</label>
                </div>
                <div class="text-center">
                    <input type="radio" class="btn-check" name="mood" id="mood_excited" value="Sangat Senang">
                    <label class="btn btn-outline-light rounded-circle p-2 fs-3 shadow-sm border border-2" for="mood_excited" style="width: 55px; height: 55px; transition: all 0.2s;">😆</label>
                </div>
            </div>
        </div>

        <div class="card p-4 content-card shadow-sm mb-4">
            <h6 class="fw-bold mb-2" style="color: var(--uneeds-text-green);">Productivity Score</h6>
            
            <div class="d-flex gap-2 py-2 fs-3" style="color: var(--uneeds-check-pink); cursor: pointer;">
                <i class="fa-solid fa-star" onclick="setRating(1)"></i>
                <i class="fa-solid fa-star" onclick="setRating(2)"></i>
                <i class="fa-solid fa-star" onclick="setRating(3)"></i>
                <i class="fa-solid fa-star" onclick="setRating(4)"></i>
                <i class="fa-solid fa-star" onclick="setRating(5)"></i>
                <input type="hidden" name="productivity_score" id="productivity_score" value="5">
            </div>
        </div>

        <div class="card p-4 content-card shadow-sm mb-4">
            <label for="achievement" class="fw-bold mb-3 h6" style="color: var(--uneeds-text-green);">Achievement Today</label>
            <textarea class="form-control border-0 bg-light p-3 shadow-none" id="achievement" name="achievement" rows="3" placeholder="Tuliskan keberhasilanmu hari ini..." style="border-radius: 12px; font-size: 0.95rem; resize: none;">Selesai mengerjakan ERD untuk tugas akhir</textarea>
        </div>

        <div class="card p-4 content-card shadow-sm">
            <label for="obstacle" class="fw-bold mb-3 h6" style="color: var(--uneeds-text-green);">Today's Challenge</label>
            <textarea class="form-control border-0 bg-light p-3 shadow-none" id="obstacle" name="obstacle" rows="3" placeholder="Apa kendala yang kamu hadapi?" style="border-radius: 12px; font-size: 0.95rem; resize: none;">Sulit fokus di sore hari</textarea>
        </div>
    </form>
</div>

<script>
function setRating(ratingValue) {
    document.getElementById('productivity_score').value = ratingValue;
    const stars = document.querySelectorAll('.fa-star');
    stars.forEach((star, index) => {
        if (index < ratingValue) {
            star.classList.remove('fa-regular');
            star.classList.add('fa-solid');
        } else {
            star.classList.remove('fa-solid');
            star.classList.add('fa-regular');
        }
    });
}
</script>

<?php include '../components/footer.php'; ?>