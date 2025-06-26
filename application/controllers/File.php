<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class File extends CI_Controller {

    public function __construct() {
        parent::__construct();

        // 🔒 Proteksi login agar semua method hanya bisa diakses jika sudah login
        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
        }

        $this->load->library(['session', 'upload']);
        $this->load->helper(['url', 'form', 'file']);
        $this->load->model('Dashboard_model');
    }

    // 🔼 TAMPIL HALAMAN UPLOAD
    public function upload() {
        $data['title'] = 'Upload File';
        $data['page']  = 'file/upload';
        $this->load->view('layouts/template', $data);
    }

    // ⬆️ PROSES UPLOAD
    public function do_upload() {
        $upload_path = FCPATH . 'uploads/';
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
            return redirect('file/upload');
        }

        $file = $this->upload->data();
        $jenis_paket = $this->input->post('jenis_paket');
        $subkategori = $this->input->post('subkategori');
        $tahun       = $this->input->post('tahun');

        // Kosongkan subkategori jika tidak relevan
        $kategori_tanpa_sub = ['Jasa Konstruksi', 'Drainase'];
        if (in_array($jenis_paket, $kategori_tanpa_sub)) {
            $subkategori = null;
        }

        if (empty($tahun)) {
            $this->session->set_flashdata('error', '❌ Tahun belum dipilih.');
            return redirect('file/upload');
        }

        $data = [
            'jenis_paket'      => $jenis_paket,
            'subkategori'      => $subkategori,
            'tahun_konstruksi' => $tahun,
            'tahun'            => $tahun,
            'nama_paket'       => $this->input->post('nama_paket'),
            'sumber_dana'      => $this->input->post('sumber_dana'),
            'nilai_paket'      => $this->input->post('nilai_paket'),
            'nilai_pagu'       => $this->input->post('nilai_pagu'),
            'tgl_upload'       => $this->input->post('tanggal'),
            'volume'           => $this->input->post('volume'),
            'file_upload'      => $file['file_name'],
            'created_at'       => date('Y-m-d H:i:s'),
        ];

        $insert = $this->Dashboard_model->insert_file($data);
        $this->session->set_flashdata($insert ? 'success' : 'error', $insert ? '✅ File berhasil diunggah!' : '❌ Gagal menyimpan ke database.');
        redirect('dashboard');
    }

    // ✏️ TAMPIL HALAMAN EDIT
    public function edit($id) {
        $file = $this->Dashboard_model->get_file_by_id($id);
        if (!$file) {
            show_404();
        }

        $data['title'] = 'Edit File';
        $data['file']  = $file;
        $data['page']  = 'file/edit';
        $this->load->view('layouts/template', $data);
    }

    // 🔄 PROSES UPDATE FILE
    public function update($id) {
        $file_lama = $this->Dashboard_model->get_file_by_id($id);
        if (!$file_lama) {
            show_404();
        }

        $jenis_paket = $this->input->post('jenis_paket');
        $subkategori = $this->input->post('subkategori');

        // Kosongkan subkategori jika tidak berlaku
        $kategori_tanpa_sub = ['Jasa Konstruksi', 'Drainase'];
        if (in_array($jenis_paket, $kategori_tanpa_sub)) {
            $subkategori = null;
        }

        $data = [
            'jenis_paket'      => $jenis_paket,
            'subkategori'      => $subkategori,
            'tahun_konstruksi' => $this->input->post('tahun'),
            'tahun'            => $this->input->post('tahun'),
            'nama_paket'       => $this->input->post('nama_paket'),
            'sumber_dana'      => $this->input->post('sumber_dana'),
            'nilai_paket'      => $this->input->post('nilai_paket'),
            'nilai_pagu'       => $this->input->post('nilai_pagu'),
            'tgl_upload'       => $this->input->post('tanggal'),
            'volume'           => $this->input->post('volume'),
        ];

        if (!empty($_FILES['file']['name'])) {
            $config['upload_path']   = FCPATH . 'uploads/';
            $config['allowed_types'] = 'pdf|doc|docx|xls|xlsx|jpg|jpeg|png|zip|rar';
            $config['max_size']      = 2048;
            $config['file_name']     = time() . '_' . preg_replace("/[^a-zA-Z0-9\.]/", "_", $_FILES['file']['name']);
            $this->upload->initialize($config);

            if ($this->upload->do_upload('file')) {
                $upload_data = $this->upload->data();
                $data['file_upload'] = $upload_data['file_name'];

                $old_path = FCPATH . 'uploads/' . $file_lama->file_upload;
                if (file_exists($old_path)) {
                    unlink($old_path);
                }
            } else {
                $this->session->set_flashdata('error', $this->upload->display_errors('', ''));
                return redirect('file/edit/' . $id);
            }
        }

        $this->Dashboard_model->update_file($id, $data);
        $this->session->set_flashdata('success', '✅ Data berhasil diperbarui.');
        redirect('dashboard');
    }

    // ❌ HAPUS FILE
    public function delete($id) {
        $file = $this->Dashboard_model->get_file_by_id($id);
        if ($file) {
            $path = FCPATH . 'uploads/' . $file->file_upload;
            if (file_exists($path)) {
                unlink($path);
            }
            $this->Dashboard_model->delete_file($id);
            $this->session->set_flashdata('success', '✅ File berhasil dihapus.');
        } else {
            $this->session->set_flashdata('error', '❌ File tidak ditemukan.');
        }
        redirect('dashboard');
    }

    // 🔍 PENCARIAN FILE (Fitur Search)
    public function search() {
        $keyword = $this->input->get('q');
        $data['title']   = 'File Search';
        $data['page']    = 'file/search';
        $data['keyword'] = $keyword;

        if (!empty($keyword)) {
            $data['results'] = $this->Dashboard_model->search_file($keyword);
        } else {
            $data['results'] = [];
        }

        $this->load->view('layouts/template', $data);
    }

    // 🔃 AJAX FILTER (khusus air limbah dan lainnya)
    public function filter_data() {
        $subkategori = $this->input->get('subkategori');
        $tahun       = $this->input->get('tahun');

        $data['result'] = $this->Dashboard_model->filter_by_subkategori_and_tahun($subkategori, $tahun);
        $this->load->view('file/tabel_filter', $data);
    }
}
