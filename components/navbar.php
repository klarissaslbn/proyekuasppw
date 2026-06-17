<nav class="navbar navbar-expand-lg navbar-light shadow-sm sticky-top py-3" style="background-color: #FFF1F1;">
    <div class="container">
        <a class="navbar-brand fw-bold fs-4" href="home.php" style="color: #004725;">Uneeds</a>
        
        <button class="navbar-toggler border-0 shadow-none p-0" type="button" data-bs-toggle="collapse" data-bs-target="#uneedsNavMenu" aria-controls="uneedsNavMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="uneedsNavMenu">
            <ul class="navbar-nav gap-1 mt-3 mt-lg-0 text-start me-lg-4" style="--bs-navbar-nav-link-padding-x: 0.5rem;">
                <li class="nav-item">
                    <a class="nav-link fw-semibold" href="home.php" id="nav-home" style="color: #004725;">
                        <i class="fa-solid fa-house me-1"></i> Home
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-semibold" href="todo.php" id="nav-todo" style="color: #004725;">
                        <i class="fa-solid fa-list-check me-1"></i> To Do List
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-semibold" href="habit.php" id="nav-habit" style="color: #004725;">
                        <i class="fa-solid fa-arrows-spin me-1"></i> Habit Tracker
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-semibold" href="schedule.php" id="nav-schedule" style="color: #004725;">
                        <i class="fa-solid fa-calendar-day me-1"></i> Today Schedule
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-semibold" href="evaluation.php" id="nav-evaluation" style="color: #004725;">
                        <i class="fa-solid fa-face-smile me-1"></i> Evaluation
                    </a>
                </li>
                
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle fw-bold" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="color: #004725;">
                        <i class="fa-solid fa-circle-user me-1"></i> <?= isset($_SESSION['nama_user']) ? $_SESSION['nama_user'] : 'Klarissa'; ?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0" aria-labelledby="navbarDropdown" style="border-radius: 10px;">
                        <li><a class="dropdown-item small" href="#"><i class="fa-solid fa-user-gear me-2 text-muted"></i> Pengaturan Profil</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item small text-danger fw-bold" href="logout.php"><i class="fa-solid fa-right-from-bracket me-2"></i> Keluar</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>