<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model {

    /**
     * Ringkasan jumlah file per jenis paket (untuk kotak dashboard)
     */
    public function get_summary() {
        $summary = [];

        // Mapping nama kategori dengan key dashboard
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
            $this->db->reset_query();
        }

        return $summary;
    }

    /**
     * Ambil semua data file (jika jenis_paket diberikan, hanya untuk kategori tersebut)
     */
    public function get_all($jenis_paket = null) {
        if (!empty($jenis_paket)) {
            $this->db->where('jenis_paket', $jenis_paket);
        }

        $this->db->order_by('id', 'DESC');
        return $this->db->get('file_uploads')->result();
    }

    /**
     * Simpan data file ke database
     */
    public function insert_file($data) {
        return $this->db->insert('file_uploads', $data);
    }

    /**
     * Filter umum berdasarkan subkategori dan tahun
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
     * Filter lengkap berdasarkan jenis_paket, subkategori, dan tahun
     * Filter tahun disesuaikan berdasarkan kategori
     */
    public function get_filtered_by_jenis($jenis, $subkategori = '', $tahun = '') {
        $this->db->from('file_uploads');
        $this->db->where('jenis_paket', $jenis);

        if (!empty($subkategori)) {
            $this->db->where('subkategori', $subkategori);
        }

        if (!empty($tahun)) {
            switch ($jenis) {
                case 'Jasa Konstruksi':
                case 'Drainase':
                    $this->db->where('tahun_konstruksi', $tahun);
                    break;

                case 'Air Bersih':
                case 'Air Limbah':
                case 'Bangunan Gedung':
                case 'Perizinan':
                default:
                    $this->db->where('tahun', $tahun);
                    break;
            }
        }

        $this->db->order_by('id', 'DESC');
        return $this->db->get()->result();
    }

    /**
     * Filter khusus kategori Air Limbah
     */
    public function filter_by_subkategori_and_tahun($subkategori, $tahun) {
        return $this->get_filtered_by_jenis('Air Limbah', $subkategori, $tahun);
    }

    /**
     * Filter khusus Jasa Konstruksi berdasarkan tahun konstruksi
     */
    public function filter_jasa_konstruksi_by_tahun($tahun) {
        return $this->get_filtered_by_jenis('Jasa Konstruksi', '', $tahun);
    }
}
