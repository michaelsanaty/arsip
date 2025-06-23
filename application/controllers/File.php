<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class File extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library(['session', 'upload']);
        $this->load->helper(['url', 'form']);
        $this->load->model('Dashboard_model');
    }

    public function upload() {
        $data['title'] = 'Upload File';
        $data['page']  = 'file/upload';
        $this->load->view('layouts/template', $data);
    }

    public function do_upload() {
        $upload_path = FCPATH . 'uploads/';

        // Buat folder jika belum ada
        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0755, true);
        }

        // Konfigurasi upload
        $config['upload_path']   = $upload_path;
        $config['allowed_types'] = 'pdf|doc|docx|xls|xlsx|jpg|jpeg|png|zip|rar';
        $config['max_size']      = 2048; // Max 2 MB
        $config['file_name']     = time() . '_' . preg_replace("/[^a-zA-Z0-9\.]/", "_", $_FILES['file']['name']);

        $this->upload->initialize($config);

        if (!$this->upload->do_upload('file')) {
            $this->session->set_flashdata('error', $this->upload->display_errors('', ''));
            redirect('file/upload');
        }

        $file = $this->upload->data();

        // Ambil data dari form
        $jenis_paket      = $this->input->post('jenis_paket');
        $subkategori      = $this->input->post('subkategori') ?: null;
        $tahun_konstruksi = $this->input->post('tahun_konstruksi') ?: null;

        $data = [
            'jenis_paket'      => $jenis_paket,
            'subkategori'      => $subkategori,
            'tahun_konstruksi' => $tahun_konstruksi,
            'nama_paket'       => $this->input->post('nama_paket'),
            'tahun_paket' => $this->input->post('tahun'),
            'sumber_dana'      => $this->input->post('sumber_dana'),
            'nilai_paket'      => $this->input->post('nilai_paket'),
            'nilai_pagu'       => $this->input->post('nilai_pagu'),
            'tgl_upload'       => $this->input->post('tanggal'),
            'volume'           => $this->input->post('volume'),
            'file'             => $file['file_name'],
            'created_at'       => date('Y-m-d H:i:s'),
        ];

        // Simpan ke database via Dashboard_model
        $this->Dashboard_model->insert_file($data);

        $this->session->set_flashdata('success', '✅ File berhasil diunggah!');
        redirect('dashboard');
    }

    public function filter_data() {
        $subkategori = $this->input->get('subkategori');
        $tahun = $this->input->get('tahun');
        $data['result'] = $this->Dashboard_model->filter_by_subkategori_and_tahun($subkategori, $tahun);
        $this->load->view('file/tabel_filter', $data);
    }
}
