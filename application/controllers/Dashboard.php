<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Dashboard_model');
    }

    public function index() {
        $data['title'] = 'Dashboard';
        $data['page'] = 'dashboard/index';
        $data['summary'] = $this->Dashboard_model->get_summary();
        $data['files'] = $this->Dashboard_model->get_all();
        $this->load->view('layouts/template', $data);
    }

    // Fungsi untuk filter data berdasarkan subkategori dan tahun (AJAX)
    public function filter($subkategori = '', $tahun = '') {
        $filtered = $this->Dashboard_model->get_filtered($subkategori, $tahun);
        echo json_encode($filtered);
    }
}
