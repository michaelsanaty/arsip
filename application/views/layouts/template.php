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
    /* Sidebar fixed full height */
    .main-sidebar {
      position: fixed;
      top: 57px; /* height navbar */
      bottom: 0;
      left: 0;
      width: 250px;
      overflow-y: auto;
      z-index: 1030;
      transition: width 0.3s ease;
    }

    /* Content wrapper */
    .content-wrapper {
      margin-left: 250px;
      padding: 1rem;
      height: calc(100vh - 57px);
      overflow-y: auto;
      overflow-x: hidden;
      background: #f4f6f9;
      transition: margin-left 0.3s ease;
    }

    /* Navbar fixed */
    .main-header {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      height: 57px;
      z-index: 1040;
      background: #fff;
    }

    /* Padding wrapper supaya konten tidak tertutup navbar */
    .wrapper {
      padding-top: 57px;
    }

    /* Sidebar collapse */
    body.sidebar-collapse .main-sidebar {
      width: 80px;
    }

    body.sidebar-collapse .content-wrapper {
      margin-left: 80px;
    }

    /* Hide menu text on collapse */
    body.sidebar-collapse .nav-sidebar > .nav-item > .nav-link > p,
    body.sidebar-collapse .nav-sidebar > .nav-item > .nav-link > span {
      display: none;
    }

    /* Center icon menu on collapse */
    body.sidebar-collapse .nav-sidebar > .nav-item > .nav-link {
      text-align: center;
    }

    /* Enlarge icons on collapse */
    body.sidebar-collapse .nav-sidebar > .nav-item > .nav-link > i {
      font-size: 1.25rem;
    }

    /* Hide brand text on collapse */
    body.sidebar-collapse .brand-link > span {
      display: none;
    }

    body.sidebar-collapse .brand-link {
      text-align: center;
    }
  </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <ul class="navbar-nav">
        <li class="nav-item">
          <!-- Sidebar toggle button -->
          <a class="nav-link" data-widget="pushmenu" href="#" role="button" aria-label="Toggle sidebar">
            <i class="fas fa-bars"></i>
          </a>
        </li>
      </ul>

      <form class="form-inline ml-3">
        <div class="input-group input-group-sm">
          <input
            class="form-control form-control-navbar"
            type="search"
            placeholder="Search"
            aria-label="Search"
          />
          <div class="input-group-append">
            <button class="btn btn-navbar" type="submit" aria-label="Search button">
              <i class="fas fa-search"></i>
            </button>
          </div>
        </div>
      </form>
    </nav>

    <!-- Sidebar -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <a href="#" class="brand-link">
        <span class="brand-text font-weight-light">Manajemen File</span>
      </a>
      <div class="sidebar">
        <nav>
          <ul
            class="nav nav-pills nav-sidebar flex-column"
            data-widget="treeview"
          >
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

    <!-- Main Content -->
    <div class="content-wrapper p-4">
      <?php $this->load->view($page); ?>
    </div>
  </div>

  <!-- JS -->
  <script src="<?= base_url('aset/plugins/jquery/jquery.min.js') ?>"></script>
  <script src="<?= base_url('aset/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
  <script src="<?= base_url('aset/dist/js/adminlte.min.js') ?>"></script>

  <script>
    // Initialize pushmenu manually (optional, AdminLTE should auto-init)
    $(function () {
      $('[data-widget="pushmenu"]').PushMenu();
    });
  </script>
</body>
</html>
