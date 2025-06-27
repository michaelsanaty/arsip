<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Login - Arsip Digital PU</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- AdminLTE & FontAwesome -->
  <link rel="stylesheet" href="<?= base_url('aset/plugins/fontawesome-free/css/all.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('aset/dist/css/adminlte.min.css') ?>">

  <style>
    body {
      background: url("<?= base_url('aset/img/1.jpg') ?>") no-repeat center center fixed;
      background-size: cover;
      font-family: 'Segoe UI', sans-serif;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .login-box {
      width: 380px;
      z-index: 2;
    }

    .login-card-body {
      backdrop-filter: blur(10px);
      background-color: rgba(255, 255, 255, 0.08);
      border: 1px solid rgba(255, 255, 255, 0.2);
      border-radius: 12px;
      color: #fff;
      padding: 30px;
      box-shadow: 0 0 25px rgba(0, 0, 0, 0.4);
    }

    .login-logo {
      font-size: 28px;
      font-weight: bold;
      color: #ffffff;
      margin-bottom: 25px;
      text-shadow: 1px 1px 6px rgba(0, 0, 0, 0.6);
      text-align: center;
    }

    .form-control {
      background: rgba(255, 255, 255, 0.1);
      border: 1px solid rgba(255, 255, 255, 0.2);
      color: #fff;
    }

    .form-control::placeholder {
      color: #ccc;
    }

    .input-group-text {
      background: rgba(255, 255, 255, 0.1);
      border: 1px solid rgba(255, 255, 255, 0.2);
      color: #fff;
    }

    .btn-primary {
      background-color: transparent;
      border: 2px solid #ffffff;
      color: #fff;
      transition: 0.3s ease;
    }

    .btn-primary:hover {
      background-color: rgba(255, 255, 255, 0.15);
      border-color: #fff;
      color: #fff;
    }

    .alert {
      font-size: 14px;
    }
  </style>
</head>
<body>
  <div class="login-box">
    <div class="login-logo">
      <i class="fas fa-archive"></i> PU ARSIP
    </div>

    <div class="card login-card-body">
      <h5 class="mb-4 text-center font-weight-bold">LOGIN</h5>

      <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
      <?php endif; ?>

      <form action="<?= base_url('auth/login') ?>" method="post">
        <div class="input-group mb-3">
          <input type="text" name="nama" class="form-control" placeholder="Nama Pengguna" required>
          <div class="input-group-append">
            <div class="input-group-text"><span class="fas fa-user"></span></div>
          </div>
        </div>

        <div class="input-group mb-3">
          <input type="password" name="sandi" class="form-control" placeholder="Kata Sandi" required>
          <div class="input-group-append">
            <div class="input-group-text"><span class="fas fa-lock"></span></div>
          </div>
        </div>

        <div class="row mt-3">
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">Masuk</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <!-- JS -->
  <script src="<?= base_url('aset/plugins/jquery/jquery.min.js') ?>"></script>
  <script src="<?= base_url('aset/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
  <script src="<?= base_url('aset/dist/js/adminlte.min.js') ?>"></script>

  <!-- 🔁 Fade out alert otomatis -->
  <script>
    setTimeout(() => {
      $('.alert').fadeOut('slow');
    }, 3000);
  </script>
</body>
</html>
