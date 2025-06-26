<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit File</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="<?= base_url('aset/plugins/fontawesome-free/css/all.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('aset/dist/css/adminlte.min.css') ?>">
  <script src="<?= base_url('aset/plugins/jquery/jquery.min.js') ?>"></script>
  <style>
    body {
      background-color: #f4f6f9;
      margin: 0;
      padding: 0;
    }

    .card-wrapper {
      max-width: 800px;
      margin: 40px auto;
      padding: 0 15px;
    }

    .card-body-scrollable {
      max-height: 80vh;
      overflow-y: auto;
      padding-right: 15px;
    }

    .floating-back-btn {
      position: fixed;
      bottom: 20px;
      left: 20px;
      z-index: 9999;
    }

    iframe {
      border: 1px solid #ccc;
      border-radius: 8px;
    }
  </style>
</head>
<body>

<div class="card-wrapper">
  <div class="card shadow border-0">
    <div class="card-header bg-warning text-white">
      <h4 class="mb-0 font-weight-bold"><i class="fas fa-edit mr-2"></i> Edit File</h4>
    </div>

    <div class="card-body card-body-scrollable">
      <form action="<?= base_url('file/update/' . $file->id) ?>" method="post" enctype="multipart/form-data">
        <input type="hidden" name="tahun" id="hiddenTahun" value="<?= $file->tahun ?>">

        <div class="form-group">
          <label><i class="fas fa-box mr-1"></i> Jenis Paket</label>
          <input type="text" class="form-control" name="jenis_paket" id="jenisPaket" value="<?= $file->jenis_paket ?>" readonly>
        </div>

        <div class="form-group" id="subkategoriGroup" style="display: none;">
          <label><i class="fas fa-tags mr-1"></i> Subkategori</label>
          <select name="subkategori" class="form-control" id="subkategoriSelect">
            <option value="">-- Pilih Subkategori --</option>
          </select>
        </div>

        <div class="form-group" id="tahunGroup" style="display: none;">
          <label><i class="fas fa-calendar-alt mr-1"></i> Tahun</label>
          <select class="form-control tahunDropdown" id="tahunDropdown1">
            <option value="">-- Pilih Tahun --</option>
            <?php for ($i = 2015; $i <= 2025; $i++): ?>
              <option value="<?= $i ?>" <?= ($file->tahun == $i) ? 'selected' : '' ?>><?= $i ?></option>
            <?php endfor; ?>
          </select>
        </div>

        <div class="form-group" id="tahunDrainaseGroup" style="display: none;">
          <label><i class="fas fa-calendar-alt mr-1"></i> Tahun (Drainase)</label>
          <select class="form-control tahunDropdown" id="tahunDropdown2">
            <option value="">-- Pilih Tahun --</option>
            <?php for ($i = 2015; $i <= 2025; $i++): ?>
              <option value="<?= $i ?>" <?= ($file->tahun == $i) ? 'selected' : '' ?>><?= $i ?></option>
            <?php endfor; ?>
          </select>
        </div>

        <div class="form-group" id="tahunPerizinanGroup" style="display: none;">
          <label><i class="fas fa-calendar-alt mr-1"></i> Tahun (Perizinan)</label>
          <select class="form-control tahunDropdown" id="tahunDropdown3">
            <option value="">-- Pilih Tahun --</option>
            <?php for ($i = 2018; $i <= 2025; $i++): ?>
              <option value="<?= $i ?>" <?= ($file->tahun == $i) ? 'selected' : '' ?>><?= $i ?></option>
            <?php endfor; ?>
          </select>
        </div>

        <div class="form-group">
          <label>Nama Paket</label>
          <input type="text" class="form-control" name="nama_paket" value="<?= $file->nama_paket ?>" required>
        </div>

        <div class="form-group">
          <label>Sumber Dana</label>
          <input type="text" class="form-control" name="sumber_dana" value="<?= $file->sumber_dana ?>" required>
        </div>

        <div class="form-row">
          <div class="form-group col-md-6">
            <label>Nilai Paket</label>
            <input type="number" class="form-control" name="nilai_paket" value="<?= $file->nilai_paket ?>" required>
          </div>
          <div class="form-group col-md-6">
            <label>Nilai Pagu</label>
            <input type="number" class="form-control" name="nilai_pagu" value="<?= $file->nilai_pagu ?>" required>
          </div>
        </div>

        <div class="form-group">
          <label>Tanggal Upload</label>
          <input type="date" class="form-control" name="tanggal" value="<?= $file->tgl_upload ?>" required>
        </div>

        <div class="form-group">
          <label>Volume</label>
          <input type="text" class="form-control" name="volume" value="<?= $file->volume ?>" required>
        </div>

        <div class="form-group">
          <label>File (kosongkan jika tidak diganti)</label>
          <input type="file" name="file" class="form-control-file">
          <?php if (!empty($file->file_upload)): ?>
            <small class="text-muted">File sekarang: <strong><?= $file->file_upload ?></strong></small>
          <?php endif; ?>
        </div>

        <button type="submit" class="btn btn-primary btn-block">
          <i class="fas fa-save mr-2"></i> Simpan Perubahan
        </button>

        <!-- Preview File -->
        <?php if (!empty($file->file_upload)): ?>
          <div class="mt-4">
            <label>Pratinjau File:</label>
            <?php
              $ext = pathinfo($file->file_upload, PATHINFO_EXTENSION);
              $file_url = base_url('uploads/' . $file->file_upload);
            ?>
            <?php if (in_array(strtolower($ext), ['pdf'])): ?>
              <iframe src="<?= $file_url ?>" width="100%" height="500px"></iframe>
            <?php elseif (in_array(strtolower($ext), ['jpg','jpeg','png','gif'])): ?>
              <img src="<?= $file_url ?>" alt="Preview" class="img-fluid">
            <?php else: ?>
              <p><i class="fas fa-file"></i> <a href="<?= $file_url ?>" target="_blank">Lihat atau Unduh File</a></p>
            <?php endif; ?>
          </div>
        <?php endif; ?>

      </form>
    </div>
  </div>
</div>

<!-- Tombol kembali -->
<a href="<?= base_url('dashboard') ?>" class="btn btn-secondary floating-back-btn">
  <i class="fas fa-arrow-left mr-1"></i> Kembali
</a>

<script>
  const subkategoriMap = {
    'Air Limbah': ['MCK', 'Tangki Septik'],
    'Air Bersih': ['Jaringan Perpipaan/SR', 'Sumur Warga'],
    'Bangunan Gedung': ['Gedung Sekolah', 'Gedung Kesehatan'],
    'Perizinan': ['PBG', 'Sertifikat Layak Fungsi (SLF)', 'Rekomendasi Teknis']
  };

  $(document).ready(function () {
    const jenis = $('#jenisPaket').val();
    const currentSub = "<?= $file->subkategori ?>";
    const subkategoriSelect = $('#subkategoriSelect');
    const subkategoriGroup = $('#subkategoriGroup');
    const tahunGroup = $('#tahunGroup');
    const tahunDrainaseGroup = $('#tahunDrainaseGroup');
    const tahunPerizinanGroup = $('#tahunPerizinanGroup');

    subkategoriSelect.empty().append('<option value="">-- Pilih Subkategori --</option>');
    subkategoriGroup.hide();
    tahunGroup.hide();
    tahunDrainaseGroup.hide();
    tahunPerizinanGroup.hide();

    if (subkategoriMap[jenis]) {
      subkategoriMap[jenis].forEach(sub => {
        const selected = (sub === currentSub) ? 'selected' : '';
        subkategoriSelect.append(`<option value="${sub}" ${selected}>${sub}</option>`);
      });
      subkategoriGroup.show();
      if (jenis === 'Perizinan') {
        tahunPerizinanGroup.show();
      } else {
        tahunGroup.show();
      }
    } else if (jenis === 'Drainase') {
      tahunDrainaseGroup.show();
    } else if (jenis === 'Jasa Konstruksi') {
      tahunGroup.show();
    }

    $('.tahunDropdown').on('change', function () {
      $('#hiddenTahun').val($(this).val());
    });
  });
</script>
</body>
</html>
