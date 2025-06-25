<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Dashboard_model');
        $this->load->helper(['url', 'form']);
    }

    public function index() {
        // Ambil parameter dari URL (GET)
        $jenis       = $this->input->get('jenis', TRUE);        // Jenis Paket
        $subkategori = $this->input->get('subkategori', TRUE);  // Subkategori
        $tahun       = $this->input->get('tahun', TRUE);        // Tahun Konstruksi

        $data['title']   = 'Dashboard';
        $data['page']    = 'dashboard/index';
        $data['summary'] = $this->Dashboard_model->get_summary();

        // Logika prioritas filter
        if (!empty($jenis)) {
            $data['files'] = $this->Dashboard_model->get_filtered_by_jenis($jenis, $subkategori, $tahun);
        } elseif (!empty($subkategori) || !empty($tahun)) {
            $data['files'] = $this->Dashboard_model->get_filtered($subkategori, $tahun);
        } else {
            $data['files'] = $this->Dashboard_model->get_all();
        }

        // Tampilkan ke template utama
        $this->load->view('layouts/template', $data);
    }

    // Opsional: Endpoint JSON (bisa digunakan untuk AJAX filter dinamis)
    public function filter($subkategori = '', $tahun = '', $jenis = '') {
        $result = $this->Dashboard_model->get_filtered_by_jenis($jenis, $subkategori, $tahun);
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
    }
}
