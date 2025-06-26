<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();

        // Proteksi login
        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
        }

        $this->load->model('Dashboard_model');
        $this->load->helper(['url', 'form']);
    }

    public function index() {
        // Ambil filter dari URL
        $subkategori = $this->input->get('subkategori', TRUE);
        $tahun       = $this->input->get('tahun', TRUE);
        $jenis       = $this->input->get('jenis', TRUE); // Jenis = kategori utama (contoh: Bangunan Gedung)

        $data['title']   = 'Dashboard';
        $data['page']    = 'dashboard/index';
        $data['summary'] = $this->Dashboard_model->get_summary();

        // Filter logika
        if (!empty($jenis)) {
            $data['files'] = $this->Dashboard_model->get_filtered_by_jenis($jenis, $subkategori, $tahun);
        } elseif (!empty($subkategori) || !empty($tahun)) {
            $data['files'] = $this->Dashboard_model->get_filtered($subkategori, $tahun);
        } else {
            $data['files'] = $this->Dashboard_model->get_all();
        }

        $this->load->view('layouts/template', $data);
    }

    // Endpoint JSON (opsional AJAX)
    public function filter($subkategori = '', $tahun = '', $jenis = '') {
        $result = $this->Dashboard_model->get_filtered_by_jenis($jenis, $subkategori, $tahun);
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
    }
}
