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

    // Ambil semua file (bisa difilter berdasarkan jenis_paket kalau diperlukan)
    public function get_all($jenis_paket = null) {
        if (!empty($jenis_paket)) {
            $this->db->where('jenis_paket', $jenis_paket);
        }

        $this->db->order_by('id', 'DESC');
        return $this->db->get('file_uploads')->result();
    }

    // Ambil data file berdasarkan subkategori dan tahun (khusus untuk jenis 'Air Limbah')
    public function get_filtered($subkategori = '', $tahun = '') {
        $this->db->from('file_uploads');
        $this->db->where('jenis_paket', 'Air Limbah');

        if (!empty($subkategori)) {
            $this->db->where('sub_jenis_paket', $subkategori);
        }

        if (!empty($tahun)) {
            $this->db->where('tahun_paket', $tahun);
        }

        $this->db->order_by('id', 'DESC');
        return $this->db->get()->result();
    }
}
