<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model {

    public function get_summary() {
        $summary = [];
        $kategori = [
            'Air Minum'        => 'air_mineral',
            'Air Limbah'       => 'air_limbah',
            'Bangunan Gedung'  => 'bangunan',
            'Jasa Konstruksi'  => 'jasa_konstruksi',
            'Drainase'         => 'drainase',
            'Perizinan'        => 'perizinan',
        ];

        foreach ($kategori as $jenis => $key) {
            $this->db->where('jenis_paket', $jenis);
            $summary[$key] = $this->db->count_all_results('file_uploads');
            $this->db->reset_query();
        }

        return $summary;
    }

    public function get_all($jenis_paket = null) {
        if (!empty($jenis_paket)) {
            $this->db->where('jenis_paket', $jenis_paket);
        }

        $this->db->order_by('id', 'DESC');
        return $this->db->get('file_uploads')->result();
    }

    public function insert_file($data) {
        return $this->db->insert('file_uploads', $data);
    }

    /**
     * ✅ FINAL: Fungsi filter fleksibel berdasarkan subkategori dan tahun
     */
    public function get_filtered($subkategori = '', $tahun = '') {
        $this->db->from('file_uploads');

        if (!empty($subkategori)) {
            $this->db->where('subkategori', $subkategori);
        }

        if (!empty($tahun)) {
            $this->db->where('tahun_konstruksi', $tahun);
        }

        $this->db->order_by('id', 'DESC');
        return $this->db->get()->result();
    }

    // Tetap disediakan jika butuh filter khusus per kategori
    public function filter_by_subkategori_and_tahun($subkategori, $tahun) {
        $this->db->from('file_uploads');
        $this->db->where('jenis_paket', 'Air Limbah');

        if (!empty($subkategori)) {
            $this->db->where('subkategori', $subkategori);
        }

        if (!empty($tahun)) {
            $this->db->where('tahun_konstruksi', $tahun);
        }

        $this->db->order_by('id', 'DESC');
        return $this->db->get()->result();
    }

    public function filter_jasa_konstruksi_by_tahun($tahun) {
        $this->db->from('file_uploads');
        $this->db->where('jenis_paket', 'Jasa Konstruksi');

        if (!empty($tahun)) {
            $this->db->where('tahun_konstruksi', $tahun);
        }

        $this->db->order_by('id', 'DESC');
        return $this->db->get()->result();
    }
}
