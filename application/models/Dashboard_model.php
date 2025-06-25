<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model {

    /**
     * Ringkasan jumlah file per jenis paket (untuk kotak dashboard)
     */
    public function get_summary() {
        $summary = [];

        $kategori = [
            'Air Bersih'       => 'air_bersih',
            'Air Limbah'       => 'air_limbah',
            'Bangunan Gedung'  => 'bangunan',
            'Jasa Konstruksi'  => 'jasa_konstruksi',
            'Drainase'         => 'drainase',
            'Perizinan'        => 'perizinan',
        ];

        foreach ($kategori as $jenis => $key) {
            $this->db->where('jenis_paket', $jenis);
            $summary[$key] = $this->db->count_all_results('file_uploads');
            $this->db->reset_query(); // Reset agar tidak terbawa ke iterasi selanjutnya
        }

        return $summary;
    }

    /**
     * Ambil semua data file (bisa dengan filter jenis_paket jika diisi)
     */
    public function get_all($jenis_paket = null) {
        if (!empty($jenis_paket)) {
            $this->db->where('jenis_paket', $jenis_paket);
        }
        $this->db->order_by('id', 'DESC');
        return $this->db->get('file_uploads')->result();
    }

    /**
     * Insert data file baru
     */
    public function insert_file($data) {
        return $this->db->insert('file_uploads', $data);
    }

    /**
     * Filter berdasarkan subkategori dan tahun (digunakan jika jenis tidak diisi)
     */
    public function get_filtered($subkategori = '', $tahun = '') {
        $this->db->from('file_uploads');

        if (!empty($subkategori)) {
            $this->db->where('subkategori', $subkategori);
        }

        if (!empty($tahun)) {
            $this->db->group_start();
            $this->db->where('tahun', $tahun);
            $this->db->or_where('tahun_konstruksi', $tahun);
            $this->db->group_end();
        }

        $this->db->order_by('id', 'DESC');
        return $this->db->get()->result();
    }

    /**
     * Filter utama berdasarkan jenis_paket, subkategori (opsional), dan tahun (opsional)
     */
    public function get_filtered_by_jenis($jenis, $subkategori = '', $tahun = '') {
        $this->db->from('file_uploads');
        $this->db->where('jenis_paket', $jenis);

        if (!empty($subkategori)) {
            $this->db->where('subkategori', $subkategori);
        }

        if (!empty($tahun)) {
            $this->db->group_start();
            $this->db->where('tahun', $tahun);
            $this->db->or_where('tahun_konstruksi', $tahun);
            $this->db->group_end();
        }

        $this->db->order_by('id', 'DESC');
        return $this->db->get()->result();
    }
}
