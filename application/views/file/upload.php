<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Upload File</title>
  <link rel="stylesheet" href="<?= base_url('aset/plugin/fontawesome-free/css/all.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('aset/dist/css/adminlte.min.css') ?>">
  <script src="<?= base_url('aset/plugin/jquery/jquery.min.js') ?>"></script>
</head>
<body>
<div class="container mt-4">
  <div class="card shadow-lg border-0">
    <div class="card-header bg-primary text-white">
      <h4 class="mb-0 font-weight-bold"><i class="fas fa-upload mr-2"></i> Upload File</h4>
    </div>
    <div class="card-body">
      <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <i class="fas fa-check-circle mr-2"></i> <?= $this->session->flashdata('success') ?>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      <?php endif; ?>

      <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <i class="fas fa-times-circle mr-2"></i> <?= $this->session->flashdata('error') ?>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      <?php endif; ?>

      <form action="<?= site_url('file/do_upload') ?>" method="post" enctype="multipart/form-data">
        <div class="form-group">
          <label><i class="fas fa-box mr-1"></i> Jenis Paket</label>
          <select name="jenis_paket" class="form-control" id="jenisPaket" required>
            <option value="">-- Pilih --</option>
            <option value="Air Minum">Air Minum</option>
            <option value="Air Limbah">Air Limbah</option>
            <option value="Bangunan Gedung">Bangunan Gedung</option>
            <option value="Jasa Konstruksi">Jasa Konstruksi</option>
            <option value="Promosi">Promosi</option>
          </select>
        </div>

        <!-- Subkategori khusus Air Limbah -->
        <div class="form-group" id="subJenisGroup" style="display:none;">
          <label><i class="fas fa-filter mr-1"></i> Sub Jenis Air Limbah</label>
          <select name="subkategori" class="form-control">
            <option value="">-- Pilih Sub Jenis --</option>
            <option value="Tangki Septik">Tangki Septik</option>
            <option value="MCK">MCK</option>
          </select>
        </div>

        <div class="form-group">
          <label><i class="fas fa-pen-nib mr-1"></i> Nama Paket</label>
          <input type="text" name="nama_paket" class="form-control" required>
        </div>

        <div class="form-group">
          <label><i class="fas fa-calendar-alt mr-1"></i> Tahun</label>
          <input type="number" name="tahun" class="form-control" min="2010" max="2030" required>
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

<!-- Script aktifkan subkategori jika jenis paket "Air Limbah" -->
<script>
  $(document).ready(function() {
    $('#jenisPaket').change(function() {
      if ($(this).val() === 'Air Limbah') {
        $('#subJenisGroup').slideDown();
      } else {
        $('#subJenisGroup').slideUp();
      }
    });
  });
</script>
</body>
</html>
