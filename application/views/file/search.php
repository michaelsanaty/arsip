<div class="container-fluid">
  <h4 class="mb-4">🔍 Pencarian File</h4>

  <!-- Form Pencarian -->
  <form method="get" action="<?= base_url('file/search') ?>">
    <div class="input-group mb-4">
      <input type="text" name="keyword" class="form-control" placeholder="Cari berdasarkan nama paket, sumber dana, tahun, dll" value="<?= html_escape($this->input->get('keyword')) ?>" required>
      <div class="input-group-append">
        <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i> Cari</button>
      </div>
    </div>
  </form>

  <!-- Hasil Pencarian -->
  <?php if (isset($results)): ?>
    <div class="card shadow-sm">
      <div class="card-header bg-info text-white">Hasil Pencarian</div>
      <div class="card-body table-responsive p-0">
        <?php if (count($results) > 0): ?>
          <table class="table table-striped">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama Paket</th>
                <th>Jenis Paket</th>
                <th>Subkategori</th>
                <th>Tahun</th>
                <th>Volume</th>
                <th>File</th>
              </tr>
            </thead>
            <tbody>
              <?php $no = 1; foreach ($results as $r): ?>
                <tr>
                  <td><?= $no++ ?></td>
                  <td><?= html_escape($r->nama_paket) ?></td>
                  <td><?= html_escape($r->jenis_paket) ?></td>
                  <td><?= html_escape($r->subkategori) ?></td>
                  <td><?= html_escape($r->tahun ?? $r->tahun_konstruksi) ?></td>
                  <td><?= html_escape($r->volume) ?></td>
                  <td>
                    <a href="<?= base_url('uploads/' . $r->file_upload) ?>" target="_blank" class="btn btn-sm btn-success">
                      <i class="fas fa-download"></i> Unduh
                    </a>
                  </td>
                </tr>
              <?php endforeach ?>
            </tbody>
          </table>
        <?php else: ?>
          <div class="text-danger">❌ Tidak ada hasil ditemukan.</div>
        <?php endif ?>
      </div>
    </div>
  <?php endif ?>
</div>
