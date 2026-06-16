<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Uneeds</title>
    
    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- FontAwesome Icon untuk Simbol Menu -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- SweetAlert2 CSS & JS untuk UI Pop-up Cantik -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        /* Definisi Palet Warna Custom Khas Uneeds */
        :root {
            --uneeds-text-green: #004725;     /* Hijau untuk teks utama */
            --uneeds-date-green: #006F39;     /* Hijau untuk komponen tanggal */
            --uneeds-navbar-pink: #FFF1F1;    /* Pink lembut untuk background navbar */
            --uneeds-check-pink: #FFA9BF;     /* Pink cerah untuk tombol checkbox checklist */
            --uneeds-bg-success: #EAF4EB;     /* Hijau muda untuk progress selesai */
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #ffffff;
            color: var(--uneeds-text-green);
        }

        /* Styling Navigasi Atas */
        .uneeds-navbar {
            background-color: var(--uneeds-navbar-pink) !important;
            border-bottom: 1px solid #f2e2e4;
        }
        .uneeds-navbar .navbar-brand {
            color: var(--uneeds-text-green) !important;
            font-weight: 800;
            font-size: 1.5rem;
        }
        .uneeds-navbar .nav-link {
            color: #555555 !important;
            font-weight: 500;
            padding-bottom: 6px;
        }
        .uneeds-navbar .nav-link.active {
            color: var(--uneeds-text-green) !important;
            font-weight: 700;
            border-bottom: 3px solid var(--uneeds-text-green);
        }

        /* Penataan Tanggal */
        .uneeds-date {
            color: var(--uneeds-date-green) !important;
            font-weight: 600;
        }

        /* Desain Struktur Card Ringkas */
        .stat-card {
            border: 1px solid #f0f0f0;
            border-radius: 16px;
            background-color: #fcfdfe;
            color: var(--uneeds-text-green);
        }
        .stat-card.success-variant {
            background-color: var(--uneeds-bg-success);
            border: none;
        }
        .stat-card.pink-variant {
            background-color: var(--uneeds-navbar-pink);
            border: none;
        }
        .content-card {
            border: 1px solid #ffebeb !important;
            border-radius: 16px;
            background-color: #ffffff;
        }

        /* Mengubah Warna Checkbox Menjadi Pink Khas Pilihanmu */
        .form-check-input {
            border-radius: 6px;
            border: 2px solid #cccccc;
            cursor: pointer;
        }
        .form-check-input:checked {
            background-color: var(--uneeds-check-pink) !important;
            border-color: var(--uneeds-check-pink) !important;
        }

        /* Tombol Aksi Utama (+ Tugas Baru) */
        .btn-uneeds {
            background-color: var(--uneeds-navbar-pink);
            color: var(--uneeds-text-green);
            border: 1px solid #f5dbdb;
            border-radius: 12px;
            font-weight: 600;
            padding: 8px 16px;
            transition: all 0.2s;
        }
        .btn-uneeds:hover {
            background-color: #ffd9e0;
            color: var(--uneeds-text-green);
        }
    </style>
</head>
<body>