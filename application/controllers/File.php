<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class File extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library(['session', 'upload']);
        $this->load->helper(['url', 'form', 'file']);
        $this->load->model('Dashboard_model');
    }

    // Halaman form upload
    public function upload() {
        $data['title'] = 'Upload File';
        $data['page']  = 'file/upload';
        $this->load->view('layouts/template', $data);
    }

    // Proses upload file
    public function do_upload() {
        $upload_path = FCPATH . 'uploads/';

        // Buat folder uploads jika belum ada
        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0755, true);
        }

        $config['upload_path']   = $upload_path;
        $config['allowed_types'] = 'pdf|doc|docx|xls|xlsx|jpg|jpeg|png|zip|rar';
        $config['max_size']      = 2048;
        $config['file_name']     = time() . '_' . preg_replace("/[^a-zA-Z0-9\.]/", "_", $_FILES['file']['name']);

        $this->upload->initialize($config);

        if (!$this->upload->do_upload('file')) {
            $this->session->set_flashdata('error', $this->upload->display_errors('', ''));
            redirect('file/upload');
        }

        $file = $this->upload->data();

        // Ambil inputan
        $jenis_paket      = $this->input->post('jenis_paket');
        $subkategori      = $this->input->post('subkategori');
        $tahun_hidden     = $this->input->post('tahun');             // dari input hidden JS
        $tahun_dropdown   = $this->input->post('tahun_konstruksi'); // dari select biasa

        // Tentukan tahun final
        $tahun_final = !empty($tahun_hidden) ? $tahun_hidden : $tahun_dropdown;

        // Jika jenis paket tidak pakai subkategori
        $kategori_tanpa_sub = ['Jasa Konstruksi', 'Drainase'];
        if (in_array($jenis_paket, $kategori_tanpa_sub)) {
            $subkategori = null;
        }

        // Validasi jika tahun kosong
        if (empty($tahun_final)) {
            $this->session->set_flashdata('error', '❌ Tahun belum dipilih.');
            redirect('file/upload');
        }

        // Simpan ke database
        $data = [
            'jenis_paket'      => $jenis_paket,
            'subkategori'      => $subkategori,
            'tahun'            => $tahun_final,
            'tahun_konstruksi' => $tahun_final,
            'nama_paket'       => $this->input->post('nama_paket'),
            'sumber_dana'      => $this->input->post('sumber_dana'),
            'nilai_paket'      => $this->input->post('nilai_paket'),
            'nilai_pagu'       => $this->input->post('nilai_pagu'),
            'tgl_upload'       => $this->input->post('tanggal'),
            'volume'           => $this->input->post('volume'),
            'file_upload'      => $file['file_name'],
            'created_at'       => date('Y-m-d H:i:s'),
        ];

        $inserted = $this->Dashboard_model->insert_file($data);

        if ($inserted) {
            $this->session->set_flashdata('success', '✅ File berhasil diunggah!');
        } else {
            $this->session->set_flashdata('error', '❌ Gagal menyimpan ke database.');
        }

        redirect('dashboard');
    }

    // Hapus file dan data
    public function delete($id) {
        $this->load->database();
        $this->db->where('id', $id);
        $file = $this->db->get('file_uploads')->row();

        if ($file) {
            $file_path = FCPATH . 'uploads/' . $file->file_upload;
            if (file_exists($file_path)) {
                unlink($file_path);
            }

            $this->db->where('id', $id);
            $this->db->delete('file_uploads');
            $this->session->set_flashdata('success', '✅ File berhasil dihapus.');
        } else {
            $this->session->set_flashdata('error', '❌ File tidak ditemukan.');
        }

        redirect('dashboard');
    }

    // Untuk filter via AJAX (opsional)
    public function filter_data() {
        $subkategori = $this->input->get('subkategori');
        $tahun       = $this->input->get('tahun');

        $data['result'] = $this->Dashboard_model->filter_by_subkategori_and_tahun($subkategori, $tahun);
        $this->load->view('file/tabel_filter', $data);
    }
}
