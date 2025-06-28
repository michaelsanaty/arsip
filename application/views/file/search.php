<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container mt-3">
  <h4 class="mb-4"><i class="fas fa-search"></i> Pencarian File</h4>

  <form method="get" action="<?= base_url('file/search') ?>" class="mb-4">
    <div class="row g-2">
      <div class="col-md-5">
        <input type="text" name="nama_paket" class="form-control" placeholder="🔎 Nama Paket..." value="<?= html_escape($nama_paket ?? '') ?>">
      </div>
      <div class="col-md-3">
        <select name="tahun" class="form-control">
          <option value="">-- Pilih Tahun --</option>
          <?php for ($i = 2015; $i <= 2025; $i++): ?>
            <option value="<?= $i ?>" <?= isset($tahun) && $tahun == $i ? 'selected' : '' ?>><?= $i ?></option>
          <?php endfor; ?>
        </select>
      </div>
      <div class="col-md-2">
        <button type="submit" class="btn btn-primary btn-block w-100">
          <i class="fas fa-search"></i> Cari
        </button>
      </div>
      <div class="col-md-2">
        <a href="<?= base_url('file/search') ?>" class="btn btn-secondary btn-block w-100">Reset</a>
      </div>
    </div>
  </form>

  <?php if (!empty($results)) : ?>
    <div class="table-responsive">
      <table class="table table-bordered table-striped table-hover">
        <thead class="table-dark">
          <tr class="text-center">
            <th>No</th>
            <th>Jenis Paket</th>
            <th>Subkategori</th>
            <th>Nama Paket</th>
            <th>Tahun</th>
            <th>Sumber Dana</th>
            <th>Nilai Paket</th>
            <th>Nilai Pagu</th>
            <th>Volume</th>
            <th>Tanggal Upload</th>
            <th>File</th>
          </tr>
        </thead>
        <tbody>
          <?php $no = 1; foreach ($results as $row): ?>
            <tr>
              <td class="text-center"><?= $no++ ?></td>
              <td><?= html_escape($row->jenis_paket) ?></td>
              <td><?= html_escape($row->subkategori ?: '-') ?></td>
              <td><?= html_escape($row->nama_paket) ?></td>
              <td class="text-center"><?= html_escape($row->tahun ?: $row->tahun_konstruksi) ?></td>
              <td><?= html_escape($row->sumber_dana) ?></td>
              <td class="text-end"><?= number_format($row->nilai_paket, 0, ',', '.') ?></td>
              <td class="text-end"><?= number_format($row->nilai_pagu, 0, ',', '.') ?></td>
              <td><?= html_escape($row->volume) ?></td>
              <td class="text-center"><?= date('d/m/Y', strtotime($row->tgl_upload)) ?></td>
              <td class="text-center">
                <a href="<?= base_url('uploads/' . $row->file_upload) ?>" target="_blank" class="btn btn-sm btn-success">
                  <i class="fas fa-download"></i> Unduh
                </a>
              </td>
            </tr>
          <?php endforeach ?>
        </tbody>
      </table>
    </div>
  <?php else: ?>
    <div class="alert alert-warning text-center mt-4">❗ Tidak ada file yang cocok dengan pencarian.</div>
  <?php endif ?>
</div>
