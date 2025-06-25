<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Upload File</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="<?= base_url('aset/plugins/fontawesome-free/css/all.min.css') ?>" />
  <link rel="stylesheet" href="<?= base_url('aset/dist/css/adminlte.min.css') ?>" />
  <script src="<?= base_url('aset/plugins/jquery/jquery.min.js') ?>"></script>
</head>
<body>
<div class="container mt-4">
  <div class="card shadow border-0">
    <div class="card-header bg-primary text-white">
      <h4 class="mb-0 font-weight-bold"><i class="fas fa-upload mr-2"></i> Upload File</h4>
    </div>
    <div class="card-body">

      <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show">
          <i class="fas fa-check-circle mr-2"></i> <?= $this->session->flashdata('success') ?>
          <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
      <?php endif; ?>

      <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show">
          <i class="fas fa-times-circle mr-2"></i> <?= $this->session->flashdata('error') ?>
          <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
      <?php endif; ?>

      <form action="<?= site_url('file/do_upload') ?>" method="post" enctype="multipart/form-data">
        <div class="form-group">
          <label><i class="fas fa-box mr-1"></i> Jenis Paket</label>
          <select name="jenis_paket" class="form-control" id="jenisPaket" required>
            <option value="">-- Pilih --</option>
            <option value="Air Bersih">Air Bersih</option>
            <option value="Air Limbah">Air Limbah</option>
            <option value="Bangunan Gedung">Bangunan Gedung</option>
            <option value="Jasa Konstruksi">Jasa Konstruksi</option>
            <option value="Drainase">Drainase</option>
            <option value="Perizinan">Perizinan</option>
          </select>
        </div>

        <!-- Subkategori -->
        <div class="form-group" id="subkategoriGroup" style="display: none;">
          <label><i class="fas fa-tags mr-1"></i> Subkategori</label>
          <select name="subkategori" class="form-control" id="subkategoriSelect">
            <option value="">-- Pilih Subkategori --</option>
          </select>
        </div>

        <!-- Tahun -->
        <div class="form-group" id="tahunGroup" style="display: none;">
          <label><i class="fas fa-calendar-alt mr-1"></i> Tahun</label>
          <select class="form-control tahunDropdown">
            <option value="">-- Pilih Tahun --</option>
            <?php for ($i = 2015; $i <= 2025; $i++): ?>
              <option value="<?= $i ?>"><?= $i ?></option>
            <?php endfor; ?>
          </select>
        </div>

        <div class="form-group" id="tahunDrainaseGroup" style="display: none;">
          <label><i class="fas fa-calendar-alt mr-1"></i> Tahun (Drainase)</label>
          <select class="form-control tahunDropdown">
            <option value="">-- Pilih Tahun --</option>
            <?php for ($i = 2015; $i <= 2025; $i++): ?>
              <option value="<?= $i ?>"><?= $i ?></option>
            <?php endfor; ?>
          </select>
        </div>

        <div class="form-group" id="tahunPerizinanGroup" style="display: none;">
          <label><i class="fas fa-calendar-alt mr-1"></i> Tahun (Perizinan)</label>
          <select class="form-control tahunDropdown">
            <option value="">-- Pilih Tahun --</option>
            <?php for ($i = 2018; $i <= 2025; $i++): ?>
              <option value="<?= $i ?>"><?= $i ?></option>
            <?php endfor; ?>
          </select>
        </div>

        <!-- Tahun tersimpan di sini -->
        <input type="hidden" name="tahun" id="hiddenTahun" />

        <div class="form-group">
          <label><i class="fas fa-pen-nib mr-1"></i> Nama Paket</label>
          <input type="text" name="nama_paket" class="form-control" required>
        </div>

        <div class="form-group">
          <label><i class="fas fa-money-bill-wave mr-1"></i> Sumber Dana</label>
          <input type="text" name="sumber_dana" class="form-control" required>
        </div>

        <div class="form-row">
          <div class="form-group col-md-6">
            <label><i class="fas fa-coins mr-1"></i> Nilai Paket</label>
            <input type="number" name="nilai_paket" class="form-control" required>
          </div>
          <div class="form-group col-md-6">
            <label><i class="fas fa-cash-register mr-1"></i> Nilai Pagu</label>
            <input type="number" name="nilai_pagu" class="form-control" required>
          </div>
        </div>

        <div class="form-group">
          <label><i class="fas fa-calendar-day mr-1"></i> Tanggal Upload</label>
          <input type="date" name="tanggal" class="form-control" required>
        </div>

        <div class="form-group">
          <label><i class="fas fa-layer-group mr-1"></i> Volume</label>
          <input type="text" name="volume" class="form-control" required>
        </div>

        <div class="form-group">
          <label><i class="fas fa-file-upload mr-1"></i> Upload File</label>
          <input type="file" name="file" class="form-control-file" required>
        </div>

        <button type="submit" class="btn btn-success btn-block font-weight-bold">
          <i class="fas fa-cloud-upload-alt mr-2"></i> Upload Sekarang
        </button>
      </form>
    </div>
  </div>
</div>

<script>
  const subkategoriMap = {
    'Air Limbah': ['MCK', 'Tangki Septik'],
    'Air Bersih': ['Jaringan Perpipaan/SR', 'Sumur Warga'],
    'Bangunan Gedung': ['Gedung Sekolah', 'Gedung Kesehatan'],
    'Perizinan': ['PBG', 'Sertifikat Layak Fungsi (SLF)', 'Rekomendasi Teknis']
  };

  $('#jenisPaket').on('change', function () {
    const val = $(this).val();
    const subkategoriGroup    = $('#subkategoriGroup');
    const subkategoriSelect   = $('#subkategoriSelect');
    const tahunGroup          = $('#tahunGroup');
    const tahunDrainaseGroup  = $('#tahunDrainaseGroup');
    const tahunPerizinanGroup = $('#tahunPerizinanGroup');

    subkategoriSelect.empty().append('<option value="">-- Pilih Subkategori --</option>');
    subkategoriGroup.hide();
    tahunGroup.hide();
    tahunDrainaseGroup.hide();
    tahunPerizinanGroup.hide();
    $('#hiddenTahun').val('');

    if (subkategoriMap[val]) {
      subkategoriMap[val].forEach(item => {
        subkategoriSelect.append(`<option value="${item}">${item}</option>`);
      });
      subkategoriGroup.show();

      if (val === 'Perizinan') {
        tahunPerizinanGroup.show();
      } else {
        tahunGroup.show();
      }
    } else if (val === 'Jasa Konstruksi') {
      tahunGroup.show();
    } else if (val === 'Drainase') {
      tahunDrainaseGroup.show();
    }
  });

  $('.tahunDropdown').on('change', function () {
    $('#hiddenTahun').val($(this).val());
  });
</script>
</body>
</html>
