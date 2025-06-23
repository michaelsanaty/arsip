<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model {

    // Ambil jumlah total file per kategori utama
    public function get_summary() {
        $summary = [];
        $kategori = [
            'Air Minum'        => 'air_mineral',
            'Air Limbah'       => 'air_limbah',
            'Bangunan Gedung'  => 'bangunan',
            'Jasa Konstruksi'  => 'jasa_konstruksi',
            'Promosi'          => 'promosi'
        ];

        foreach ($kategori as $jenis => $key) {
            $this->db->where('jenis_paket', $jenis);
            $summary[$key] = $this->db->count_all_results('file_uploads');
            $this->db->reset_query();
        }

        return $summary;
    }

    // Ambil semua file (bisa difilter berdasarkan jenis_paket)
    public function get_all($jenis_paket = null) {
        if (!empty($jenis_paket)) {
            $this->db->where('jenis_paket', $jenis_paket);
        }

        $this->db->order_by('id', 'DESC');
        return $this->db->get('file_uploads')->result();
    }

    // Simpan file yang diunggah ke database
    public function insert_file($data) {
        return $this->db->insert('file_uploads', $data);
    }

    // Ambil tahun-tahun unik berdasarkan subkategori (khusus Air Limbah)
    public function get_tahun_by_subkategori($subkategori) {
        $this->db->select('tahun');
        $this->db->from('file_uploads');
        $this->db->where('jenis_paket', 'Air Limbah');
        $this->db->where('subkategori', $subkategori);
        $this->db->group_by('tahun');
        $this->db->order_by('tahun', 'DESC');
        return $this->db->get()->result();
    }

    // Filter data berdasarkan subkategori dan tahun (khusus Air Limbah)
    public function filter_by_subkategori_and_tahun($subkategori, $tahun) {
        $this->db->from('file_uploads');
        $this->db->where('jenis_paket', 'Air Limbah');

        if (!empty($subkategori)) {
            $this->db->where('subkategori', $subkategori);
        }

        if (!empty($tahun)) {
            $this->db->where('tahun', $tahun);
        }

        $this->db->order_by('id', 'DESC');
        return $this->db->get()->result();
    }
}
