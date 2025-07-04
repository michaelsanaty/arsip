<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model {

    /**
     * Ambil jumlah file per jenis_paket (untuk kotak dashboard ringkasan)
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
            $this->db->reset_query();
        }

        return $summary;
    }

    /**
     * Ambil semua file, bisa difilter berdasarkan jenis_paket
     */
    public function get_all($jenis_paket = null) {
        if (!empty($jenis_paket)) {
            $this->db->where('jenis_paket', $jenis_paket);
        }

        $this->db->order_by('id', 'DESC');
        return $this->db->get('file_uploads')->result();
    }

    /**
     * Simpan data file baru
     */
    public function insert_file($data) {
        return $this->db->insert('file_uploads', $data);
    }

    /**
     * Perbarui data file berdasarkan ID
     */
    public function update_file($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('file_uploads', $data);
    }

    /**
     * Ambil satu data file berdasarkan ID
     */
    public function get_file_by_id($id) {
        return $this->db->get_where('file_uploads', ['id' => $id])->row();
    }

    /**
     * Hapus file berdasarkan ID
     */
    public function delete_file($id) {
        $this->db->where('id', $id);
        return $this->db->delete('file_uploads');
    }

    /**
     * Filter umum berdasarkan subkategori dan/atau tahun
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
     * Filter berdasarkan kategori utama, subkategori (opsional), dan tahun
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

    /**
     * Filter default untuk kategori Air Limbah
     */
    public function filter_by_subkategori_and_tahun($subkategori, $tahun) {
        return $this->get_filtered_by_jenis('Air Limbah', $subkategori, $tahun);
    }

    /**
     * Filter khusus Jasa Konstruksi hanya berdasarkan tahun_konstruksi
     */
    public function filter_jasa_konstruksi_by_tahun($tahun) {
        return $this->get_filtered_by_jenis('Jasa Konstruksi', '', $tahun);
    }

    /**
     * Pencarian file berdasarkan nama_paket dan/atau tahun
     */
    public function cari_file($nama_paket = '', $tahun = '') {
        $this->db->from('file_uploads');

        if (!empty($nama_paket) && !empty($tahun)) {
            $this->db->group_start();
                $this->db->like('nama_paket', $nama_paket);
            $this->db->group_end();

            $this->db->group_start();
                $this->db->where('tahun', $tahun);
                $this->db->or_where('tahun_konstruksi', $tahun);
            $this->db->group_end();

        } elseif (!empty($nama_paket)) {
            $this->db->like('nama_paket', $nama_paket);

        } elseif (!empty($tahun)) {
            $this->db->group_start();
                $this->db->where('tahun', $tahun);
                $this->db->or_where('tahun_konstruksi', $tahun);
            $this->db->group_end();
        }

        $this->db->order_by('id', 'DESC');
        return $this->db->get()->result();
    }

    /**
     * Final: Filter + Pencarian gabungan untuk Dashboard
     */
    public function get_filtered_files($keyword = null, $jenis = null, $subkategori = null, $tahun = null) {
        $this->db->from('file_uploads');

        if (!empty($keyword)) {
            $this->db->group_start();
            $this->db->like('nama_paket', $keyword);
            $this->db->or_like('jenis_paket', $keyword);
            $this->db->or_like('sumber_dana', $keyword);
            $this->db->or_like('volume', $keyword);
            $this->db->group_end();
        }

        if (!empty($jenis)) {
            $this->db->where('jenis_paket', $jenis);
        }

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
