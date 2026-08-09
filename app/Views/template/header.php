<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>SI Kesiswaan - Dashboard</title>
    <link rel="icon" href="<?= base_url('logo-sekolah.png') ?>" type="image/png">
                    <!-- Google Fonts dihapus sesuai permintaan -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <?php if (!empty($enableSelect2)): ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css">
    <?php endif; ?>
    <style>
        :root {
            --sidebar-width: 220px;
            --primary-grad-start: #667eea;
            --primary-grad-end: #764ba2;
            --sidebar-icon-bg: #eef2ff;
            --sidebar-text-muted: #6c757d;
        }
        body {
            overflow-x: hidden;
        }
        .navbar-brand {
            font-weight: bold;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }
        .navbar-brand .brand-text {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .navbar-brand .brand-logo {
            width: 36px;
            height: 36px;
            object-fit: contain;
        }
        .sidebar {
            position: fixed;
            top: 56px;
            left: 0;
            width: var(--sidebar-width);
            height: calc(100vh - 56px);
            overflow-y: auto;
            z-index: 1000;
            transition: transform 0.3s ease;
        }
        .sidebar.hide {
            transform: translateX(-100%);
        }
        .content-wrapper {
            margin-left: var(--sidebar-width);
            padding: 20px;
            min-height: calc(100vh - 56px);
            background-color: #f8f9fa;
            transition: margin-left 0.3s ease;
            margin-top: 56px;
        }
        .content-wrapper.expanded {
            margin-left: 0;
        }
        .sidebar a.list-group-item {
            background-color: #ffffff;
            border: none;
            margin: 4px 10px;
            border-radius: 12px;
            padding: 8px 10px;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: background 0.25s ease, color 0.25s ease, box-shadow 0.25s ease;
        }
        .sidebar a.list-group-item:hover {
            background-color: #f8f9fa;
        }
        .sidebar a.list-group-item i.bi {
            width: 28px;
            height: 28px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            background: var(--sidebar-icon-bg);
            color: var(--primary-grad-start);
            flex-shrink: 0;
        }
        .sidebar a.list-group-item.active {
            background: linear-gradient(135deg, var(--primary-grad-start) 0%, var(--primary-grad-end) 100%);
            border-color: transparent;
            color: #ffffff;
            box-shadow: 0 10px 24px rgba(118, 75, 162, 0.25);
        }
        .sidebar a.list-group-item.active i.bi {
            background: rgba(255,255,255,0.25);
            color: #ffffff;
        }
        .sidebar-section {
            color: var(--sidebar-text-muted);
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            padding: 12px 16px 4px;
        }
        .sidebar .list-group a.list-group-item.ps-4 {
            margin-left: 8px;
            border-radius: 10px;
            position: relative;
            font-size: 0.95rem;
            padding: 7px 10px;
            gap: 8px;
        }
        .sidebar .list-group a.list-group-item.ps-4::before {
            content: "";
            width: 5px;
            height: 5px;
            border-radius: 50%;
            background-color: #d1d5db;
            display: inline-block;
            margin-right: 6px;
        }
        .sidebar .list-group a.list-group-item.ps-4.active::before {
            background-color: #ffffff;
        }
        .sidebar .list-group a.list-group-item.ps-4 i.bi {
            width: 28px;
            height: 28px;
            border-radius: 6px;
        }
        .sidebar a[aria-expanded="true"] .bi-chevron-down {
            transform: rotate(180deg);
        }
        .sidebar .bi-chevron-down {
            transition: transform 0.2s ease;
        }
        .sidebar .collapse {
            display: none;
        }
        .sidebar .collapse.show {
            display: block;
        }
        .sidebar .collapsing {
            display: block;
            height: auto !important;
            overflow: visible !important;
            transition: none !important;
        }
        /* Sistem toggling custom untuk submenu OSIS (menghindari konflik Bootstrap) */
        .sidebar .osis-submenu {
            display: none;
        }
        .sidebar .osis-submenu.is-open {
            display: block;
        }
        .gradient-text {
            background: linear-gradient(135deg, var(--primary-grad-start) 0%, var(--primary-grad-end) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .card-hover {
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }
        .card-hover:hover {
            transform: translateY(-3px);
            box-shadow: 0 18px 22px rgba(118, 75, 162, 0.12);
        }
        .stat-card {
            background: linear-gradient(180deg, #ffffff 0%, #fafafa 100%);
            border: 1px solid #f1f1f1;
        }
        .metric-icon {
            width: 46px;
            height: 46px;
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: rgba(102, 126, 234, 0.12);
            color: var(--primary-grad-start);
        }
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .sidebar.show-mobile {
                transform: translateX(0);
            }
            .content-wrapper {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom fixed-top">
        <div class="container-fluid">
            <button class="btn btn-link" id="sidebarToggle">
                <i class="bi bi-list fs-4"></i>
            </button>
            <a class="navbar-brand" href="<?= base_url('dashboard') ?>">
                <img
                    class="brand-logo"
                    src="<?= base_url('logo-sekolah.png') ?>"
                    alt="Logo"
                    onerror="this.remove(); document.getElementById('brandIcon').style.display='inline-flex';"
                >
                <i class="bi bi-mortarboard-fill" id="brandIcon" style="display:none"></i>
                <span class="brand-text">SI Kesiswaan</span>
            </a>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle"></i> <?= session()->get('nama_lengkap') ?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><h6 class="dropdown-header">Role: <span class="badge bg-primary"><?= ucfirst(str_replace('_', ' ', session()->get('role'))) ?></span></h6></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="<?= base_url('profile') ?>"><i class="bi bi-gear"></i> Pengaturan</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="<?= base_url('auth/logout') ?>">
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
