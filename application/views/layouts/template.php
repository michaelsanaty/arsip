<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title><?= $title ?></title>

  <!-- AdminLTE CSS -->
  <link rel="stylesheet" href="<?= base_url('aset/plugins/fontawesome-free/css/all.min.css') ?>" />
  <link rel="stylesheet" href="<?= base_url('aset/dist/css/adminlte.min.css') ?>" />

  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
    }

    .main-sidebar {
      position: fixed;
      top: 0;
      bottom: 0;
      left: 0;
      width: 200px; /* Lebar sidebar dikurangi */
      background-color: #343a40;
      overflow-x: hidden;
      overflow-y: hidden;
      transition: width 0.3s ease;
    }

    .content-wrapper {
      margin-left: 200px;
      padding: 1rem;
      min-height: 100vh;
      background: #f4f6f9;
      transition: margin-left 0.3s ease;
    }

    body.sidebar-collapse .main-sidebar {
      width: 80px;
    }

    body.sidebar-collapse .content-wrapper {
      margin-left: 80px;
    }

    body.sidebar-collapse .nav-sidebar > .nav-item > .nav-link > p,
    body.sidebar-collapse .brand-text {
      display: none;
    }

    .brand-link {
      display: flex;
      justify-content: space-between;
      align-items: center;
      background-color: #343a40;
      padding: 0.75rem 1rem;
      color: #fff;
      font-weight: bold;
      height: 60px;
    }

    .brand-text {
      margin-left: 0.25rem;
      font-size: 1rem;
    }

    .brand-toggle-btn {
      background: none;
      border: none;
      color: #fff;
      font-size: 18px;
      cursor: pointer;
    }

    .sidebar {
      padding-top: 0.5rem;
    }

    .nav-link i {
      width: 20px;
      text-align: center;
      margin-right: 10px;
    }

    .nav-sidebar .nav-item {
      margin-bottom: 0.2rem;
    }

    body.sidebar-collapse .brand-link {
      justify-content: center;
    }
  </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed sidebar-collapse">
  <div class="wrapper">

    <!-- Sidebar -->
    <aside class="main-sidebar elevation-4">
      <div class="brand-link">
        <span class="brand-text">Manajemen File</span>
        <button class="brand-toggle-btn" id="toggleSidebar" title="Toggle Sidebar">
          <i class="fas fa-bars"></i>
        </button>
      </div>

      <div class="sidebar">
        <nav>
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview">
            <li class="nav-item">
              <a href="<?= base_url('dashboard') ?>" class="nav-link">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>Dashboard</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= base_url('file/upload') ?>" class="nav-link">
                <i class="nav-icon fas fa-upload"></i>
                <p>Upload File</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= base_url('file/search') ?>" class="nav-link">
                <i class="nav-icon fas fa-search"></i>
                <p>File Search</p>
              </a>
            </li>
          </ul>
        </nav>
      </div>
    </aside>

    <!-- Konten Utama -->
    <div class="content-wrapper">
      <?php if (isset($page)) $this->load->view($page); ?>
    </div>

  </div>

  <!-- JS -->
  <script src="<?= base_url('aset/plugins/jquery/jquery.min.js') ?>"></script>
  <script src="<?= base_url('aset/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
  <script src="<?= base_url('aset/dist/js/adminlte.min.js') ?>"></script>

  <script>
    document.getElementById('toggleSidebar').addEventListener('click', function (e) {
      e.preventDefault();
      document.body.classList.toggle('sidebar-collapse');
    });
  </script>
</body>
</html>
