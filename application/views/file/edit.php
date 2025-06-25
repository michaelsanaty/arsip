<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Edit File</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="<?= base_url('aset/plugins/fontawesome-free/css/all.min.css') ?>" />
  <link rel="stylesheet" href="<?= base_url('aset/dist/css/adminlte.min.css') ?>" />
  <script src="<?= base_url('aset/plugins/jquery/jquery.min.js') ?>"></script>
</head>
<body>
<div class="container mt-4">
  <div class="card shadow border-0">
    <div class="card-header bg-warning text-white">
      <h4 class="mb-0 font-weight-bold"><i class="fas fa-edit mr-2"></i> Edit File</h4>
    </div>
    <div class="card-body">

      <form action="<?= base_url('file/update/' . $file->id) ?>" method="post" enctype="multipart/form-data">

        <div class="form-group">
          <label><i class="fas fa-box mr-1"></i> Jenis Paket</label>
          <input type="text" class="form-control" name="jenis_paket" id="jenisPaket" value="<?= $file->jenis_paket ?>" readonly>
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

        <!-- Input tersembunyi untuk tahun -->
        <input type="hidden" name="tahun" id="hiddenTahun" value="<?= $file->tahun ?>">

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

  $(document).ready(function () {
    const jenis = $('#jenisPaket').val();
    const currentSub = "<?= $file->subkategori ?>";
    const currentTahun = "<?= $file->tahun ?>";

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

    // Sync selected tahun dropdown ke hidden input
    $('.tahunDropdown').on('change', function () {
      $('#hiddenTahun').val($(this).val());
    });
  });
</script>
</body>
</html>
