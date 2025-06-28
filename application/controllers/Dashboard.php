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

    public function index() {
        // Ambil data dari URL GET
        $keyword     = $this->input->get('keyword', TRUE);
        $jenis       = $this->input->get('jenis', TRUE);
        $subkategori = $this->input->get('subkategori', TRUE);
        $tahun       = $this->input->get('tahun', TRUE);

        $data['title']   = 'Dashboard';
        $data['page']    = 'dashboard/index';
        $data['summary'] = $this->Dashboard_model->get_summary();

        // Ambil data file sesuai filter pencarian
        $data['files'] = $this->Dashboard_model->get_filtered_files($keyword, $jenis, $subkategori, $tahun);

        $this->load->view('layouts/template', $data);
    }

    // Endpoint JSON untuk filter AJAX (opsional)
    public function filter($subkategori = '', $tahun = '', $jenis = '') {
        $result = $this->Dashboard_model->get_filtered_by_jenis($jenis, $subkategori, $tahun);
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
    }
}
