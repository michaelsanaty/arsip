<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<style>
  .tahun-wrapper {
    position: absolute;
    z-index: 10;
    top: 100%;
    left: 50%;
    transform: translateX(-50%);
    background: #fff;
    padding: 12px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    animation: fadeIn 0.3s ease-in-out;
    display: none;
  }

  @keyframes fadeIn {
    from { opacity: 0; transform: translate(-50%, -5%); }
    to { opacity: 1; transform: translate(-50%, 0); }
  }

  .tahun-badge {
    border: 1px solid #ccc;
    padding: 6px 14px;
    margin: 4px;
    border-radius: 20px;
    cursor: pointer;
    display: inline-block;
    transition: all 0.2s ease-in-out;
  }

  .tahun-badge:hover {
    background-color: #007bff;
    color: #fff;
    border-color: #007bff;
  }

  .position-relative-box {
    position: relative;
  }
</style>

<div class="content-header">
  <div class="container-fluid">
    <h1 class="mb-4 font-weight-bold"><i class="fas fa-tachometer-alt mr-2"></i> Dashboard</h1>

    <div class="row">
      <?php
        $categories = [
          ['key' => 'air_mineral', 'label' => 'Air Minum', 'color' => 'info', 'icon' => 'glass-whiskey'],
          ['key' => 'air_limbah', 'label' => 'Air Limbah', 'color' => 'success', 'icon' => 'recycle'],
          ['key' => 'bangunan', 'label' => 'Bangunan Gedung', 'color' => 'warning', 'icon' => 'city'],
          ['key' => 'jasa_konstruksi', 'label' => 'Jasa Konstruksi', 'color' => 'danger', 'icon' => 'hard-hat'],
          ['key' => 'drainase', 'label' => 'Drainase', 'color' => 'secondary', 'icon' => 'water'],
          ['key' => 'perizinan', 'label' => 'Perizinan', 'color' => 'primary', 'icon' => 'file-signature'],
        ];
        foreach ($categories as $c):
      ?>
      <div class="col-md-4 mb-3">
        <div class="small-box bg-<?= $c['color'] ?> text-white shadow-lg rounded p-3 position-relative-box">
          <div class="inner">
            <h3><?= isset($summary[$c['key']]) ? $summary[$c['key']] : 0 ?> <small>File</small></h3>
            <p class="font-weight-bold"><?= $c['label'] ?></p>
          </div>
          <div class="icon">
            <i class="fas fa-<?= $c['icon'] ?>"></i>
          </div>

          <?php if ($c['label'] === 'Jasa Konstruksi'): ?>
          <div class="text-center mt-2">
            <button class="btn btn-sm btn-light btn-filter-toggle" type="button">
              <i class="fas fa-filter mr-1"></i> Filter Tahun
            </button>
            <div class="tahun-wrapper text-dark text-center">
              <?php for ($y = 2015; $y <= 2025; $y++): ?>
                <span class="tahun-badge" data-sub="-" data-year="<?= $y ?>"><?= $y ?></span>
              <?php endfor; ?>
            </div>
          </div>
          <?php else: ?>
          <div class="text-center mt-2">
            <button class="btn btn-sm btn-light">Subkategori A</button>
            <button class="btn btn-sm btn-light">Subkategori B</button>
          </div>
          <?php endif; ?>
        </div>
      </div>
      <?php endforeach; ?>
    </div>

    <!-- TABEL -->
    <div class="card shadow-lg mt-4">
      <div class="card-header bg-primary text-white">
        <h3 class="card-title font-weight-bold"><i class="fas fa-folder-open mr-2"></i> Daftar File</h3>
      </div>
      <div class="card-body table-responsive p-0">
        <table class="table table-hover table-bordered text-nowrap">
          <thead class="bg-light font-weight-bold text-center">
            <tr>
              <th>No</th>
              <th>Jenis Paket</th>
              <th>Subkategori</th>
              <th>Nama Paket</th>
              <th>Tahun</th>
              <th>Sumber Dana</th>
              <th>Nilai Paket</th>
              <th>Nilai Pagu</th>
              <th>Tgl Upload</th>
              <th>Volume</th>
              <th>File</th>
            </tr>
          </thead>
          <tbody id="file-table-body">
            <?php if (!empty($files)): ?>
              <?php $no = 1; foreach ($files as $file): ?>
              <tr>
                <td class="text-center"><?= $no++ ?></td>
                <td><?= $file->jenis_paket ?? '-' ?></td>
                <td><?= $file->subkategori ?? '-' ?></td>
                <td><?= $file->nama_paket ?? '-' ?></td>
                <td><?= $file->tahun_konstruksi ?? '-' ?></td>
                <td><?= $file->sumber_dana ?? '-' ?></td>
                <td><?= number_format($file->nilai_paket ?? 0, 0, ',', '.') ?></td>
                <td><?= number_format($file->nilai_pagu ?? 0, 0, ',', '.') ?></td>
                <td><?= isset($file->tgl_upload) ? date('d-m-Y', strtotime($file->tgl_upload)) : '-' ?></td>
                <td><?= $file->volume ?? '-' ?></td>
                <td class="text-center">
                  <?php if (!empty($file->file_upload)): ?>
                    <a href="<?= base_url('uploads/' . $file->file_upload) ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                      <i class="fas fa-eye"></i> Lihat
                    </a>
                  <?php else: ?>
                    <span class="text-muted">-</span>
                  <?php endif; ?>
                </td>
              </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr><td colspan="11" class="text-center">Belum ada data file.</td></tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- SCRIPT -->
<script>
document.addEventListener('DOMContentLoaded', function () {
  const filterBtn = document.querySelector('.btn-filter-toggle');
  const tahunWrapper = document.querySelector('.tahun-wrapper');

  if (filterBtn && tahunWrapper) {
    filterBtn.addEventListener('click', () => {
      tahunWrapper.style.display = (tahunWrapper.style.display === 'none' || tahunWrapper.style.display === '') ? 'block' : 'none';
    });
  }

  document.querySelectorAll('.tahun-badge').forEach(el => {
    el.addEventListener('click', function () {
      const tahun = this.dataset.year;
      const subkategori = this.dataset.sub;

      fetch(`<?= base_url('dashboard/filter/') ?>${subkategori}/${tahun}`)
        .then(res => res.json())
        .then(data => {
          const tbody = document.getElementById('file-table-body');
          tbody.innerHTML = '';
          if (data.length === 0) {
            tbody.innerHTML = '<tr><td colspan="11" class="text-center">Tidak ada data.</td></tr>';
            return;
          }

          data.forEach((file, i) => {
            tbody.innerHTML += `
              <tr>
                <td class="text-center">${i + 1}</td>
                <td>${file.jenis_paket ?? '-'}</td>
                <td>${file.subkategori ?? '-'}</td>
                <td>${file.nama_paket ?? '-'}</td>
                <td>${file.tahun_konstruksi ?? '-'}</td>
                <td>${file.sumber_dana ?? '-'}</td>
                <td>${parseInt(file.nilai_paket).toLocaleString('id-ID')}</td>
                <td>${parseInt(file.nilai_pagu).toLocaleString('id-ID')}</td>
                <td>${new Date(file.tgl_upload).toLocaleDateString('id-ID')}</td>
                <td>${file.volume ?? '-'}</td>
                <td class="text-center">
                  ${file.file_upload ? `<a href="<?= base_url('uploads/') ?>${file.file_upload}" target="_blank" class="btn btn-sm btn-outline-primary"><i class="fas fa-eye"></i> Lihat</a>` : '<span class="text-muted">-</span>'}
                </td>
              </tr>`;
          });
        });
    });
  });
});
</script>
