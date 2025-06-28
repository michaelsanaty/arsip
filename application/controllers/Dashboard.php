<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Dashboard_model');
        $this->load->helper(['url', 'form']);
        $this->load->library('session');

        // Proteksi login: redirect ke auth jika belum login
        if (!$this->session->userdata('logged_in')) {
            $this->session->set_userdata('redirect_after_login', current_url());
            redirect('auth');
        }
    }

    /**
     * Halaman utama Dashboard
     */
    public function index() {
        // Ambil filter dari parameter URL
        $keyword     = $this->input->get('keyword', TRUE);        // Kata kunci pencarian
        $jenis       = $this->input->get('jenis', TRUE);          // Jenis Paket (Air Limbah, Air Bersih, dsb)
        $subkategori = $this->input->get('subkategori', TRUE);    // Subkategori (MCK, Tangki Septik, dll)
        $tahun       = $this->input->get('tahun', TRUE);          // Tahun atau Tahun Konstruksi

        // Siapkan data untuk dikirim ke view
        $data = [
            'title'     => 'Dashboard',
            'page'      => 'dashboard/index',
            'summary'   => $this->Dashboard_model->get_summary(),
            'files'     => $this->Dashboard_model->get_filtered_files($keyword, $jenis, $subkategori, $tahun),
        ];

        $this->load->view('layouts/template', $data);
    }

    /**
     * Endpoint JSON untuk filter berdasarkan jenis, subkategori, dan tahun (digunakan jika pakai AJAX)
     */
    public function filter($subkategori = '', $tahun = '', $jenis = '') {
        $result = $this->Dashboard_model->get_filtered_by_jenis($jenis, $subkategori, $tahun);

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
    }
}
