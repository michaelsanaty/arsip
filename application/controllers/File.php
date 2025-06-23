<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class File extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('upload');
        $this->load->model('Dashboard_model');
    }

    public function upload() {
        $data['title'] = 'Upload File';
        $data['page']  = 'file/upload';
        $this->load->view('layouts/template', $data);
    }

    public function do_upload() {
        // Path folder uploads
        $upload_path = FCPATH . 'uploads/';

        // Buat folder jika belum ada
        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0755, true);
        }

        // Konfigurasi upload
        $config['upload_path']   = $upload_path;
        $config['allowed_types'] = 'pdf|doc|docx|xls|xlsx|jpg|jpeg|png|zip|rar';
        $config['max_size']      = 2048; // 2 MB
        $config['file_name']     = time() . '_' . preg_replace("/[^a-zA-Z0-9\.]/", "_", $_FILES['file']['name']);

        $this->upload->initialize($config);

        if (!$this->upload->do_upload('file')) {
            $this->session->set_flashdata('error', $this->upload->display_errors('', ''));
            redirect('file/upload');
        } else {
            $file = $this->upload->data();

            // Ambil input post
            $jenis_paket = $this->input->post('jenis_paket');
            $subkategori = ($jenis_paket == 'Air Limbah') ? $this->input->post('subkategori') : NULL;

            // Data untuk insert
            $data = [
                'jenis_paket'     => $jenis_paket,
                'subkategori'     => $subkategori, // Hanya untuk Air Limbah
                'nama_paket'      => $this->input->post('nama_paket'),
                'tahun_paket'     => $this->input->post('tahun'),
                'sumber_dana'     => $this->input->post('sumber_dana'),
                'nilai_paket'     => $this->input->post('nilai_paket'),
                'nilai_pagu'      => $this->input->post('nilai_pagu'),
                'tgl_upload'      => $this->input->post('tanggal'),
                'volume'          => $this->input->post('volume'),
                'file_upload'     => $file['file_name']
            ];

            // Simpan ke database
            $this->db->insert('file_uploads', $data);

            // Feedback
            $this->session->set_flashdata('success', '✅ File berhasil diunggah!');
            redirect('dashboard');
        }
    }
}