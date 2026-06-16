<nav class="navbar navbar-expand-lg navbar-light uneeds-navbar py-3 shadow-sm mb-4">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="home.php">
            <i class="fa-solid fa-leaf me-2" style="font-size: 1.3rem;"></i>
            <span><span style="color: #FFA9BF;">u</span>needs</span>
        </a>
        
        <div class="d-flex align-items-center order-lg-last gap-3 ms-auto me-3 me-lg-0">
            <a href="#" class="text-decoration-none position-relative text-secondary">
                <i class="fa-regular fa-bell fs-5" style="color: var(--uneeds-text-green);"></i>
                <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle">
                    <span class="visually-hidden">New alerts</span>
                </span>
            </a>

            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-decoration-none" id="dropdownProfile" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=100&auto=format&fit=crop&q=80" 
                         alt="Profil" 
                         class="rounded-circle border border-2 shadow-sm" 
                         style="width: 36px; height: 36px; object-fit: cover; border-color: var(--uneeds-check-pink) !important;">
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2" aria-labelledby="dropdownProfile" style="border-radius: 12px;">
                    <li><h6 class="dropdown-header fw-bold" style="color: var(--uneeds-text-green);">Andi R.</h6></li>
                    <li><a class="dropdown-item py-2" href="#"><i class="fa-regular fa-user me-2 text-muted"></i> Pengaturan Profil</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item py-2 text-danger" href="../logout.php"><i class="fa-solid fa-right-from-bracket me-2"></i> Keluar</a></li>
                </ul>
            </div>
        </div>
        
        <button class="navbar-toggler border-0 shadow-none p-0" type="button" data-bs-toggle="collapse" data-bs-target="#uneedsNavMenu" aria-controls="uneedsNavMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse justify-content-end" id="uneedsNavMenu">
            <ul class="navbar-nav gap-1 mt-3 mt-lg-0 text-start me-lg-4">
                <li class="nav-item"><a class="nav-link" href="home.php" id="nav-home"><i class="fa-solid fa-house me-1"></i> Home</a></li>
                <li class="nav-item"><a class="nav-link" href="todo.php" id="nav-todo"><i class="fa-solid fa-list-check me-1"></i> To Do List</a></li>
                <li class="nav-item"><a class="nav-link" href="habit.php" id="nav-habit"><i class="fa-solid fa-arrows-spin me-1"></i> Habit Tracker</a></li>
                <li class="nav-item"><a class="nav-link" href="schedule.php" id="nav-schedule"><i class="fa-solid fa-calendar-day me-1"></i> Today Schedule</a></li>
                <li class="nav-item"><a class="nav-link" href="evaluation.php" id="nav-evaluation"><i class="fa-solid fa-face-smile me-1"></i> Evaluation</a></li>
            </ul>
        </div>
    </div>
</nav>