<?php
include "../config.php";

$tgl_awal  = $_POST['tgl_awal'] ?? date('Y-m-01');
$tgl_akhir = $_POST['tgl_akhir'] ?? date('Y-m-d');
$keyword   = $_POST['keyword'] ?? '';
$jenis     = $_POST['jenis'] ?? ''; 
$kategori  = $_POST['kategori_id'] ?? ''; 

$sql = "SELECT t.*, sk.nama_sub_kategori, sk.jenis 
        FROM transaksi t
        JOIN sub_kategori sk ON t.sub_kategori_id = sk.id
        WHERE (t.tanggal BETWEEN '$tgl_awal' AND '$tgl_akhir')";

if (!empty($jenis)) {
    $sql .= " AND sk.jenis = '$jenis'";
}

if (!empty($kategori)) {
    $sql .= " AND t.sub_kategori_id = '$kategori'";
}

if (!empty($keyword)) {
    $sql .= " AND t.keterangan LIKE '%$keyword%'";
}

$sql .= " ORDER BY t.tanggal DESC";

$data = $konek->query($sql);

$q_kat = $konek->query("SELECT * FROM sub_kategori ORDER BY jenis ASC, nama_sub_kategori ASC");
?>

<main class="app-main">
  <div class="app-content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">Transaksi Kas Masjid</h3></div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Data Transaksi</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <div class="app-content">
    <div class="container-fluid">
      
      <div class="card mb-4 shadow-sm">
        <div class="card-header bg-success text-white">
          <h3 class="card-title"><i class="bi bi-funnel"></i> Filter Laporan Kas</h3>
        </div>
        <div class="card-body">
          <form method="POST" action="">
            <div class="row align-items-end g-3">
              
              <div class="col-md-3">
                <label class="form-label fw-bold small">Dari Tanggal</label>
                <input type="date" name="tgl_awal" class="form-control" value="<?= $tgl_awal; ?>" required>
              </div>
              <div class="col-md-3">
                <label class="form-label fw-bold small">Sampai Tanggal</label>
                <input type="date" name="tgl_akhir" class="form-control" value="<?= $tgl_akhir; ?>" required>
              </div>

              <div class="col-md-3">
                <label class="form-label fw-bold small">Jenis Transaksi</label>
                <select name="jenis" class="form-select">
                    <option value="">-- Semua Jenis --</option>
                    <option value="masuk" <?= ($jenis == 'masuk') ? 'selected' : '' ?>>Pemasukan</option>
                    <option value="keluar" <?= ($jenis == 'keluar') ? 'selected' : '' ?>>Pengeluaran</option>
                </select>
              </div>

              <div class="col-md-3">
                <label class="form-label fw-bold small">Kategori Spesifik</label>
                <select name="kategori_id" class="form-select">
                    <option value="">-- Semua Kategori --</option>
                    <?php foreach($q_kat as $k): ?>
                        <option value="<?= $k['id'] ?>" <?= ($kategori == $k['id']) ? 'selected' : '' ?>>
                            [<?= strtoupper($k['jenis']) ?>] <?= $k['nama_sub_kategori'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
              </div>

              <div class="col-md-8">
                <input type="text" name="keyword" class="form-control" placeholder="Cari keterangan transaksi..." value="<?= $keyword ?>">
              </div>

              <div class="col-md-4 d-flex gap-2">
                 <button type="submit" class="btn btn-primary flex-fill">
                    <i class="bi bi-search me-1"></i> Tampilkan
                 </button>
                 <a href="./?p=TS" class="btn btn-secondary" title="Reset">
                    <i class="bi bi-arrow-clockwise"></i>
                 </a>
              </div>

            </div>
          </form>
        </div>
      </div>

      <div class="row">
        <div class="col-12">
          <div class="card shadow-sm">
            
            <div class="card-header d-flex justify-content-between align-items-center">
              <h3 class="card-title fw-bold">
                 Data Periode: <?= date('d/m/Y', strtotime($tgl_awal)) ?> - <?= date('d/m/Y', strtotime($tgl_akhir)) ?>
              </h3>
              
              <div class="d-flex gap-2">
                  <a href="./?p=add_tr" class="btn btn-success btn-sm">
                      <i class="bi bi-plus-circle"></i> Tambah Baru
                  </a>
                  </div>
            </div>

            <div class="card-body">
              <div class="table-responsive">
                  <table class="table table-bordered table-hover table-striped align-middle">
                    <thead class="table-light">
                      <tr class="text-center">
                        <th style="width: 5%;">No</th>
                        <th>Tanggal</th>
                        <th>Kategori</th>
                        <th>Jenis</th>
                        <th>Keterangan</th>
                        <th>Jumlah (Rp)</th>
                        <th style="width: 15%;">Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $no = 1;
                      foreach($data as $d){
                      ?>
                      <tr>
                        <td class="text-center"><?= $no++; ?></td>
                        <td class="text-center"><?= date('d-m-Y', strtotime($d['tanggal'])); ?></td>
                        
                        <td><?= $d['nama_sub_kategori']; ?></td>
                        
                        <td class="text-center">
                            <?php if($d['jenis'] == 'masuk'){ ?>
                                <span class="badge bg-success bg-opacity-75">Pemasukan</span>
                            <?php } else { ?>
                                <span class="badge bg-danger bg-opacity-75">Pengeluaran</span>
                            <?php } ?>
                        </td>
                        
                        <td><?= $d['keterangan']; ?></td>
                        
                        <td class="text-end fw-bold <?= ($d['jenis'] == 'masuk') ? 'text-success' : 'text-danger' ?>">
                            <?= ($d['jenis'] == 'keluar' ? '- ' : '+ ') ?>
                            Rp <?= number_format($d['jumlah'], 0, ',', '.'); ?>
                        </td>
                        
                        <td class="text-center">
                          <a href="./?p=edit_tr&id=<?= $d['id'] ?>" class="btn btn-sm btn-warning"><i class="bi bi-pencil-square"></i></a>
                          <a href="./?p=hps_tr&id=<?= $d['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus transaksi ini? Saldo akan berubah.')"><i class="bi bi-trash"></i></a>
                        </td>
                      </tr>
                      <?php } ?>
                      
                      <?php if($data->num_rows == 0): ?>
                          <tr><td colspan="7" class="text-center text-muted fst-italic py-4">Tidak ada data transaksi yang ditemukan.</td></tr>
                      <?php endif; ?>
                    </tbody>
                  </table>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</main>