<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Dashboard_model');
    }

    public function index() {
        $subkategori = $this->input->get('subkategori');
        $tahun = $this->input->get('tahun');

        $data['title'] = 'Dashboard';
        $data['page'] = 'dashboard/index';
        $data['summary'] = $this->Dashboard_model->get_summary();

        // Ambil data berdasarkan filter (jika ada)
        if ($subkategori || $tahun) {
            $data['files'] = $this->Dashboard_model->get_filtered($subkategori, $tahun);
        } else {
            $data['files'] = $this->Dashboard_model->get_all();
        }

        $this->load->view('layouts/template', $data);
    }

    // Fungsi JSON jika diperlukan (opsional)
    public function filter($subkategori = '', $tahun = '') {
        $filtered = $this->Dashboard_model->filter_jasa_konstruksi_by_tahun($tahun);
        echo json_encode($filtered);
    }
}
