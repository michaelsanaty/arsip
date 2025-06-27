<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

  public function __construct() {
    parent::__construct();
  }

  public function index() {
    $this->load->view('auth/login');
  }

  public function login() {
    $nama  = $this->input->post('nama', true);
    $sandi = $this->input->post('sandi', true);

    // Login hardcoded: nama dan sandi = admin
    if (strtolower($nama) == 'admin' && $sandi === 'admin123@') {
      $this->session->set_userdata([
        'nama' => 'Admin',
        'logged_in' => true
      ]);

      // 🔁 Cek apakah ada halaman tujuan sebelumnya
      $redirect = $this->session->userdata('redirect_after_login') ?: 'dashboard';
      $this->session->unset_userdata('redirect_after_login');
      redirect($redirect); // Kembali ke halaman tujuan

    } else {
      $this->session->set_flashdata('error', 'Nama atau sandi salah!');
      redirect('auth');
    }
  }

  public function logout() {
    $this->session->sess_destroy();
    redirect('auth');
  }
}
