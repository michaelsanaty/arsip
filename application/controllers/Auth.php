<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

  public function __construct() {
    parent::__construct();
    $this->load->helper(['url', 'form']);
    $this->load->library('session');
  }

  // Tampilkan halaman login
  public function index() {
    $this->load->view('auth/login');
  }

  // Proses login
  public function login() {
    $nama  = $this->input->post('nama', true);   // 'true' = XSS filtering
    $sandi = $this->input->post('sandi', true);

    // Validasi hardcoded
    if (strtolower($nama) === 'admin' && $sandi === 'admin123@') {
      // Simpan session login
      $this->session->set_userdata([
        'nama'       => 'Admin',
        'logged_in'  => true
      ]);

      // Redirect ke halaman yang dituju sebelumnya (jika ada)
      $redirect = $this->session->userdata('redirect_after_login') ?: 'dashboard';
      $this->session->unset_userdata('redirect_after_login');

      redirect($redirect);
    } else {
      // Login gagal, kembalikan ke halaman login dengan pesan error
      $this->session->set_flashdata('error', 'Nama atau sandi salah!');
      redirect('auth');
    }
  }

  // Logout
  public function logout() {
    $this->session->sess_destroy();
    redirect('auth');
  }
}
