<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- FontAwesome & AdminLTE -->
  <link rel="stylesheet" href="<?= base_url('aset/plugins/fontawesome-free/css/all.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('aset/dist/css/adminlte.min.css') ?>">

  <style>
    body {
      margin: 0;
      background: url("<?= base_url('aset/img/1.png') ?>") no-repeat center center fixed;
      background-size: cover;
      font-family: 'Segoe UI', sans-serif;
      height: 100vh;
      overflow: hidden;
      position: relative;
    }

    /* 🔹 TOP NAVIGATION */
    .top-nav {
      position: absolute;
      top: 50px;
      right: 100px;
      display: flex;
      gap: 80px; /* ~2cm antar menu */
      z-index: 10;
    }

    .top-nav a {
      color: #000000;
      font-weight: 600;
      text-decoration: none;
      font-size: 16px;
      transition: color 0.3s ease;
    }

    .top-nav a:hover {
      color: #00aaff;
    }

    .login-box {
      width: 380px;
      position: absolute;
      bottom: 85px;
      right: 445px;
      z-index: 2;
    }

    .login-form-group {
      margin-bottom: 14px;
    }

    label {
      color: #000;
      font-weight: 600;
      margin-bottom: 5px;
      display: block;
      font-size: 18px;
    }

    .form-control {
      background-color: #60C9E1;
      border: none;
      border-radius: 10px;
      color: #000;
      padding: 12px 15px;
      box-shadow: 2px 2px 10px rgba(0,0,0,0.12);
      font-size: 15px;
       width: 75%;
    }

    .form-control::placeholder {
      color: #444;
    }

    .btn-primary {
      background-color:rgb(22, 125, 148);
      border: none;
      border-radius: 10px;
      font-weight: bold;
      padding: 10px;
      margin-top: 6px;
      box-shadow: 0 6px 14px rgba(0, 170, 255, 0.4);
      transition: 0.3s ease-in-out;
      width: 285px;
    }

    .btn-primary:hover {
      background-color: #008ecc;
    }

    .alert {
      font-size: 14px;
    }

    @media (max-width: 768px) {
      .login-box {
        width: 90%;
        bottom: 40px;
        right: 50%;
        transform: translateX(50%);
      }

      .top-nav {
        right: 20px;
        gap: 25px;
        font-size: 14px;
      }
    }
  </style>
</head>
<body>

  <!-- 🔹 TOP NAV -->
  <div class="top-nav">
    <a href="#">Home</a>
    <a href="#">About</a>
    <a href="#">Contact</a>
  </div>

  <!-- 🔸 LOGIN FORM -->
  <div class="login-box">
    <?php if ($this->session->flashdata('error')): ?>
      <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
    <?php endif; ?>

    <form action="<?= base_url('auth/login') ?>" method="post">
      <div class="login-form-group">
        <label for="nama">User Name</label>
        <input type="text" id="nama" name="nama" class="form-control" placeholder="" required>
      </div>

      <div class="login-form-group">
        <label for="sandi">Password</label>
        <input type="password" id="sandi" name="sandi" class="form-control" placeholder="" required>
      </div>

      <button type="submit" class="btn btn-primary btn-block">Login</button>
    </form>
  </div>

  <!-- JS -->
  <script src="<?= base_url('aset/plugins/jquery/jquery.min.js') ?>"></script>
  <script src="<?= base_url('aset/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
  <script src="<?= base_url('aset/dist/js/adminlte.min.js') ?>"></script>

  <script>
    setTimeout(() => {
      $('.alert').fadeOut('slow');
    }, 3000);
  </script>
</body>
</html>
