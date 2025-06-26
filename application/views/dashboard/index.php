<style>
  .custom-box {
    border-radius: 16px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1);
    color: #fff;
    position: relative;
    height: 180px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    padding: 16px 20px;
  }

  .custom-box:hover {
    transform: translateY(-6px);
    box-shadow: 0 18px 30px rgba(0, 0, 0, 0.15);
  }

  .custom-box.bg-info { background: linear-gradient(135deg, #17a2b8, #0d6efd); }
  .custom-box.bg-success { background: linear-gradient(135deg, #28a745, #218838); }
  .custom-box.bg-warning { background: linear-gradient(135deg, #ffc107, #fd7e14); }
  .custom-box.bg-danger { background: linear-gradient(135deg, #dc3545, #c82333); }
  .custom-box.bg-secondary { background: linear-gradient(135deg, #6c757d, #5a6268); }
  .custom-box.bg-primary { background: linear-gradient(135deg, #007bff, #0056b3); }

  .custom-box h4 {
    font-size: 1.2rem;
    font-weight: 700;
    margin-bottom: 0.25rem;
  }

  .custom-box p {
    font-size: 0.9rem;
    margin-bottom: 0;
    color: rgba(255, 255, 255, 0.9);
  }

  .custom-box i.fa-3x {
    opacity: 0.2;
    position: absolute;
    bottom: 12px;
    right: 16px;
  }

  .wrapper-container {
    position: relative;
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    justify-content: center;
  }

  .wrapper-container .btn {
    font-size: 0.78rem;
    padding: 6px 12px;
    white-space: nowrap;
    max-width: 100%;
    text-overflow: ellipsis;
  }

  /* Untuk tombol-tombol vertikal (khusus Perizinan) */
  .subkategori-vertical {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 10px;
    margin-top: 10px;
  }

  .subkategori-vertical .btn {
    width: 100%;
    text-align: center;
  }

  .tahun-wrapper {
    position: absolute;
    top: -170%;
    left: 50%;
    transform: translateX(-50%) scale(0.95);
    opacity: 0;
    pointer-events: none;
    flex-wrap: wrap;
    justify-content: center;
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    padding: 12px;
    border-radius: 14px;
    box-shadow: 0 16px 30px rgba(0, 0, 0, 0.2);
    transition: opacity 0.4s ease, transform 0.4s ease;
    z-index: 9999;
    min-width: 250px;
  }

  .tahun-wrapper.show {
    opacity: 1;
    transform: translateX(-50%) scale(1);
    pointer-events: auto;
  }

  .tahun-badge {
    font-size: 0.75rem;
    padding: 4px 10px;
    margin: 4px;
    border-radius: 20px;
    border: 1px solid #ccc;
    background: #fff;
    cursor: pointer;
    transition: all 0.2s ease-in-out;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
    color: #333;
    display: inline-block;
    text-decoration: none;
  }

  .tahun-badge:hover, .tahun-badge.active {
    background-color: #28a745;
    color: #fff;
    transform: scale(1.05);
  }
</style>


<div class="content-header">
  <div class="container-fluid">
    <h1 class="mb-4 font-weight-bold"><i class="fas fa-tachometer-alt mr-2"></i> Dashboard</h1>

    <div class="row">
      <?php
        $categories = [
          ['key' => 'air_bersih', 'label' => 'Air Bersih', 'color' => 'info', 'icon' => 'tint'],
          ['key' => 'air_limbah', 'label' => 'Air Limbah', 'color' => 'success', 'icon' => 'recycle'],
          ['key' => 'bangunan', 'label' => 'Bangunan Gedung', 'color' => 'warning', 'icon' => 'city'],
          ['key' => 'jasa_konstruksi', 'label' => 'Jasa Konstruksi', 'color' => 'danger', 'icon' => 'hard-hat'],
          ['key' => 'drainase', 'label' => 'Drainase', 'color' => 'secondary', 'icon' => 'water'],
          ['key' => 'perizinan', 'label' => 'Perizinan', 'color' => 'primary', 'icon' => 'file-signature'],
        ];
        foreach ($categories as $c):
      ?>
      <div class="col-md-4 mb-4">
        <div class="custom-box bg-<?= $c['color'] ?> p-4">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <h4 class="mb-1 text-white font-weight-bold"><?= $c['label'] ?></h4>
              <p class="text-light mb-2"><i class="fas fa-<?= $c['icon'] ?> mr-2"></i><?= $summary[$c['key']] ?? 0 ?> File</p>
            </div>
            <i class="fas fa-<?= $c['icon'] ?> fa-3x text-white-50"></i>
          </div>

          <?php if ($c['label'] === 'Air Limbah'): ?>
            <div class="wrapper-container mt-3 text-center">
              <button class="btn btn-light rounded-pill px-4 py-2 mx-2 btn-subkategori" data-target="tahun-limbah-septik">Tangki Septik</button>
              <button class="btn btn-light rounded-pill px-4 py-2 mx-2 btn-subkategori" data-target="tahun-limbah-mck">MCK</button>
              <div id="tahun-limbah-septik" class="tahun-wrapper"></div>
              <div id="tahun-limbah-mck" class="tahun-wrapper"></div>
            </div>
          <?php elseif ($c['label'] === 'Jasa Konstruksi'): ?>
            <div class="wrapper-container mt-3 text-center">
              <button class="btn btn-light rounded-pill px-4 py-2 mx-2 btn-tahun" data-target="tahun-jasa-konstruksi">Filter Tahun</button>
              <div id="tahun-jasa-konstruksi" class="tahun-wrapper"></div>
            </div>
          <?php elseif ($c['label'] === 'Air Bersih'): ?>
            <div class="wrapper-container mt-3 text-center">
              <button class="btn btn-light rounded-pill px-4 py-2 mx-2 btn-subkategori" data-target="tahun-air-sr">Jaringan Perpipaan/SR</button>
              <button class="btn btn-light rounded-pill px-4 py-2 mx-2 btn-subkategori" data-target="tahun-air-sumur">Sumur Warga</button>
              <div id="tahun-air-sr" class="tahun-wrapper"></div>
              <div id="tahun-air-sumur" class="tahun-wrapper"></div>
            </div>
          <?php elseif ($c['label'] === 'Drainase'): ?>
            <div class="wrapper-container mt-3 text-center">
              <button class="btn btn-light rounded-pill px-4 py-2 mx-2 btn-tahun" data-target="tahun-drainase">Filter Tahun</button>
              <div id="tahun-drainase" class="tahun-wrapper"></div>
            </div>
          <?php elseif ($c['label'] === 'Bangunan Gedung'): ?>
            <div class="wrapper-container mt-3 text-center">
              <button class="btn btn-light rounded-pill px-4 py-2 mx-2 btn-subkategori" data-target="tahun-gedung-sekolah">Gedung Sekolah</button>
              <button class="btn btn-light rounded-pill px-4 py-2 mx-2 btn-subkategori" data-target="tahun-gedung-kesehatan">Gedung Kesehatan</button>
              <div id="tahun-gedung-sekolah" class="tahun-wrapper"></div>
              <div id="tahun-gedung-kesehatan" class="tahun-wrapper"></div>
            </div>
          <?php elseif ($c['label'] === 'Perizinan'): ?>
            <div class="wrapper-container mt-3 text-center">
              <button class="btn btn-light rounded-pill px-4 py-2 mx-2 btn-subkategori" data-target="tahun-pbg">PBG</button>
              <button class="btn btn-light rounded-pill px-4 py-2 mx-2 btn-subkategori" data-target="tahun-slf">Sertifikat Layak Fungsi (SLF)</button>
              <button class="btn btn-light rounded-pill px-4 py-2 mx-2 btn-subkategori" data-target="tahun-rekomtek">Rekomendasi Teknis</button>
              <div id="tahun-pbg" class="tahun-wrapper"></div>
              <div id="tahun-slf" class="tahun-wrapper"></div>
              <div id="tahun-rekomtek" class="tahun-wrapper"></div>
            </div>
          <?php endif; ?>
        </div>
      </div>
      <?php endforeach; ?>
    </div>

    <div class="card mt-4">
      <div class="card-header bg-dark text-white">
        <h5 class="mb-0 font-weight-bold"><i class="fas fa-folder-open mr-2"></i> Daftar File</h5>
      </div>
      <div class="card-body table-responsive">
        <table class="table table-bordered table-striped table-hover">
          <thead class="thead-dark text-center">
            <tr>
              <th>No</th>
              <th>Jenis Paket</th>
              <th>Nama Paket</th>
              <th>Tahun</th>
              <th>Sumber Dana</th>
              <th>Nilai Paket</th>
              <th>Nilai Pagu</th>
              <th>Tanggal Upload</th>
              <th>Volume</th>
              <th>File</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($files)): $no = 1; foreach ($files as $file): ?>
              <tr>
                <td class="text-center"><?= $no++ ?></td>
                <td><?= $file->jenis_paket ?></td>
                <td><?= $file->nama_paket ?></td>
                <td><?= $file->tahun_konstruksi ?: $file->tahun ?></td>
                <td><?= $file->sumber_dana ?></td>
                <td><?= number_format($file->nilai_paket, 0, ',', '.') ?></td>
                <td><?= number_format($file->nilai_pagu, 0, ',', '.') ?></td>
                <td><?= date('d-m-Y', strtotime($file->tgl_upload)) ?></td>
                <td><?= $file->volume ?></td>
                <td>
                  <?php if (!empty($file->file_upload)): ?>
                    <a href="<?= base_url('uploads/' . $file->file_upload) ?>" target="_blank" class="btn btn-sm btn-primary">Lihat</a>
                  <?php else: ?>
                    <span class="text-muted">-</span>
                  <?php endif; ?>
                </td>
                <td class="text-center">
                  <a href="<?= site_url('file/edit/' . $file->id) ?>" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                  <a href="<?= site_url('file/delete/' . $file->id) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus file ini?')"><i class="fas fa-trash"></i></a>
                </td>
              </tr>
            <?php endforeach; else: ?>
              <tr><td colspan="11" class="text-center">Belum ada data.</td></tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<script>
  const tahunWrappers = {
    'tahun-limbah-septik': { jenis: 'Air Limbah', subkategori: 'Tangki Septik' },
    'tahun-limbah-mck': { jenis: 'Air Limbah', subkategori: 'MCK' },
    'tahun-jasa-konstruksi': { jenis: 'Jasa Konstruksi' },
    'tahun-air-sr': { jenis: 'Air Bersih', subkategori: 'Jaringan Perpipaan/SR' },
    'tahun-air-sumur': { jenis: 'Air Bersih', subkategori: 'Sumur Warga' },
    'tahun-drainase': { jenis: 'Drainase' },
    'tahun-gedung-sekolah': { jenis: 'Bangunan Gedung', subkategori: 'Gedung Sekolah' },
    'tahun-gedung-kesehatan': { jenis: 'Bangunan Gedung', subkategori: 'Gedung Kesehatan' },
    'tahun-pbg': { jenis: 'Perizinan', subkategori: 'PBG' },
    'tahun-slf': { jenis: 'Perizinan', subkategori: 'Sertifikat Layak Fungsi (SLF)' },
    'tahun-rekomtek': { jenis: 'Perizinan', subkategori: 'Rekomendasi Teknis' }
  };

  const hideTimers = {};

  document.querySelectorAll('.btn-subkategori, .btn-tahun').forEach(btn => {
    btn.addEventListener('click', function () {
      const targetId = this.dataset.target;

      Object.keys(tahunWrappers).forEach(id => {
        document.getElementById(id).classList.remove('show');
      });

      const targetEl = document.getElementById(targetId);
      setTimeout(() => {
        targetEl.classList.add('show');
      }, 100);

      if (targetEl.innerHTML.trim() === '') {
        const data = tahunWrappers[targetId];
        const startYear = (data.jenis === 'Perizinan') ? 2018 : 2015;
        const endYear = 2025;

        let html = '';

        // Tombol ALL di atas tahun
        let allUrl = `<?= base_url('dashboard') ?>?jenis=${encodeURIComponent(data.jenis)}`;
        if (data.subkategori) allUrl += `&subkategori=${encodeURIComponent(data.subkategori)}`;
        html += `<a href="${allUrl}" class="tahun-badge" style="background:#343a40;color:#fff;">ALL</a>`;

        // Tombol Tahun
        for (let y = startYear; y <= endYear; y++) {
          let url = `<?= base_url('dashboard') ?>?tahun=${y}&jenis=${encodeURIComponent(data.jenis)}`;
          if (data.subkategori) url += `&subkategori=${encodeURIComponent(data.subkategori)}`;
          html += `<a href="${url}" class="tahun-badge">${y}</a>`;
        }

        targetEl.innerHTML = html;
      }
    });
  });

  Object.keys(tahunWrappers).forEach(id => {
    const el = document.getElementById(id);
    el.addEventListener('mouseleave', () => {
      hideTimers[id] = setTimeout(() => {
        el.classList.remove('show');
      }, 1000);
    });
    el.addEventListener('mouseenter', () => {
      clearTimeout(hideTimers[id]);
    });
  });
</script>
