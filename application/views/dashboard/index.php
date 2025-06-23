<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="content-header">
  <div class="container-fluid">
    <h1 class="mb-4 font-weight-bold"><i class="fas fa-tachometer-alt mr-2"></i> Dashboard</h1>

    <!-- BOX RINGKASAN -->
    <div class="row">
      <?php
        $categories = [
          ['key' => 'air_mineral', 'label' => 'Air Minum', 'color' => 'info', 'icon' => 'glass-whiskey'],
          ['key' => 'air_limbah', 'label' => 'Air Limbah', 'color' => 'success', 'icon' => 'recycle'],
          ['key' => 'bangunan', 'label' => 'Bangunan Gedung', 'color' => 'warning', 'icon' => 'city'],
          ['key' => 'jasa_konstruksi', 'label' => 'Jasa Konstruksi', 'color' => 'danger', 'icon' => 'hard-hat'],
          ['key' => 'promosi', 'label' => 'Promosi', 'color' => 'secondary', 'icon' => 'bullhorn'],
        ];
        foreach ($categories as $c):
      ?>
      <div class="col-md-3 mb-3">
        <div class="small-box bg-<?= $c['color'] ?> shadow-lg rounded">
          <div class="inner">
            <h3 class="font-weight-bold">
              <?= isset($summary[$c['key']]) ? $summary[$c['key']] : 0 ?> <small>File</small>
            </h3>
            <p class="font-weight-bold"><?= $c['label'] ?></p>
          </div>
          <div class="icon">
            <i class="fas fa-<?= $c['icon'] ?>"></i>
          </div>
          <?php if ($c['key'] == 'air_limbah'): ?>
            <div class="dropdown small-box-footer">
              <button class="btn btn-sm text-white dropdown-toggle" type="button" id="dropdownAirLimbah" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Pilih Subkategori <i class="fas fa-caret-down"></i>
              </button>
              <div class="dropdown-menu" aria-labelledby="dropdownAirLimbah">
                <h6 class="dropdown-header">Tangki Septik</h6>
                <?php for ($y = 2015; $y <= 2025; $y++): ?>
                  <a class="dropdown-item year-filter" href="#" data-sub="Tangki Septik" data-year="<?= $y ?>"><?= $y ?></a>
                <?php endfor; ?>
                <div class="dropdown-divider"></div>
                <h6 class="dropdown-header">MCK</h6>
                <?php for ($y = 2015; $y <= 2025; $y++): ?>
                  <a class="dropdown-item year-filter" href="#" data-sub="MCK" data-year="<?= $y ?>"><?= $y ?></a>
                <?php endfor; ?>
              </div>
            </div>
          <?php else: ?>
            <a href="#" class="small-box-footer">Detail <i class="fas fa-arrow-circle-right"></i></a>
          <?php endif; ?>
        </div>
      </div>
      <?php endforeach; ?>
    </div>

    <!-- TABEL DATA FILE -->
    <div class="card shadow-lg">
      <div class="card-header bg-primary text-white">
        <h3 class="card-title font-weight-bold"><i class="fas fa-folder-open mr-2"></i> Daftar File</h3>
      </div>
      <div class="card-body table-responsive p-0">
        <table class="table table-hover table-bordered text-nowrap">
          <thead class="bg-light font-weight-bold text-center">
            <tr>
              <th>No</th>
              <th>Jenis Paket</th>
              <th>Sub Jenis</th>
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
                <td><?= $file->jenis_paket ?></td>
                <td><?= $file->sub_jenis_paket ?></td>
                <td><?= $file->nama_paket ?></td>
                <td><?= $file->tahun_paket ?></td>
                <td><?= $file->sumber_dana ?></td>
                <td><?= number_format($file->nilai_paket, 0, ',', '.') ?></td>
                <td><?= number_format($file->nilai_pagu, 0, ',', '.') ?></td>
                <td><?= date('d-m-Y', strtotime($file->tgl_upload)) ?></td>
                <td><?= $file->volume ?></td>
                <td class="text-center">
                  <a href="<?= base_url('uploads/' . $file->file_upload) ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-eye"></i> Lihat
                  </a>
                </td>
              </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="11" class="text-center">Belum ada data file.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- STYLE TAMBAHAN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<style>
@keyframes hoverBounce {
  0%   { transform: translateY(0) scale(1); }
  50%  { transform: translateY(-6px) scale(1.05); }
  100% { transform: translateY(0) scale(1); }
}

.small-box {
  transition: all 0.2s ease-in-out;
  cursor: pointer;
}

.small-box:hover {
  animation: hoverBounce 0.4s ease;
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
}

.table-bordered td, .table-bordered th {
  border: 1px solid #dee2e6 !important;
}

.dropdown-header {
  font-size: 14px;
  font-weight: bold;
  color: #343a40;
}
</style>

<!-- SCRIPT FILTER TABEL -->
<script>
document.addEventListener('DOMContentLoaded', function() {
  const yearFilters = document.querySelectorAll('.year-filter');

  yearFilters.forEach(btn => {
    btn.addEventListener('click', function(e) {
      e.preventDefault();
      const subkategori = this.dataset.sub;
      const tahun = this.dataset.year;

      fetch(`<?= base_url('dashboard/filter/') ?>${subkategori}/${tahun}`)
        .then(res => res.json())
        .then(data => {
          const tbody = document.getElementById('file-table-body');
          tbody.innerHTML = '';
          if (data.length === 0) {
            tbody.innerHTML = '<tr><td colspan="11" class="text-center">Tidak ada data.</td></tr>';
            return;
          }

          data.forEach((file, index) => {
            tbody.innerHTML += `
              <tr>
                <td class="text-center">${index + 1}</td>
                <td>${file.jenis_paket}</td>
                <td>${file.sub_jenis_paket || ''}</td>
                <td>${file.nama_paket}</td>
                <td>${file.tahun_paket}</td>
                <td>${file.sumber_dana}</td>
                <td>${parseInt(file.nilai_paket).toLocaleString('id-ID')}</td>
                <td>${parseInt(file.nilai_pagu).toLocaleString('id-ID')}</td>
                <td>${new Date(file.tgl_upload).toLocaleDateString('id-ID')}</td>
                <td>${file.volume}</td>
                <td class="text-center">
                  <a href="<?= base_url('uploads/') ?>${file.file_upload}" target="_blank" class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-eye"></i> Lihat
                  </a>
                </td>
              </tr>`;
          });
        });
    });
  });
});
</script>