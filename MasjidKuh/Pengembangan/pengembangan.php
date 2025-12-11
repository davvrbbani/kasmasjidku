<?php
include "../config.php";
$tgl_awal  = $_POST['tgl_awal'] ?? date('Y-m-01');
$tgl_akhir = $_POST['tgl_akhir'] ?? date('Y-m-d');

$tgl_awal  = $_POST['tgl_awal'] ?? date('Y-m-01');
$tgl_akhir = $_POST['tgl_akhir'] ?? date('Y-m-d');

$keyword = $_POST['keyword'] ?? '';

if(!empty($keyword)){
    $data = $konek->query("SELECT * FROM pengembangan WHERE keterangan LIKE '%$keyword%' ORDER BY tanggal DESC");
} else {
    $data = $konek->query("SELECT * FROM pengembangan ORDER BY tanggal DESC");
}

$q_saldo = $konek->query("SELECT * FROM pengembangan");
$total = 0;

foreach($q_saldo as $row){
    if($row['jenis'] == 'setor'){
        $total += $row['jumlah'];
    } else {
        $total -= $row['jumlah'];
    }
}
?>

<main class="app-main">
  <div class="app-content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">Transaksi Pengembangan Masjid</h3></div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Transaksi Pengembangan Masjid</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <div class="app-content">
    <div class="container-fluid">
      
      <div class="row mb-3">
          <div class="col-12">
              <div class="alert alert-info d-flex align-items-center">
                  <i class="bi bi-wallet2 fs-2 me-3"></i>
                  <div>
                      <h5 class="mb-0">Total Aset / Saldo</h5>
                      <h2 class="mb-0 fw-bold">Rp <?= number_format($total, 0, ',', '.'); ?></h2>
                  </div>
              </div>
          </div>
      </div>

      <div class="card mb-4">
            <div class="card-header bg-primary text-white">
              <h3 class="card-title">Filter Laporan</h3>
            </div>
            <div class="card-body">
            <form method="POST" action="">
                <div class="row align-items-end"> <div class="col-md-4 mb-3 mb-md-0">
                        <label class="form-label fw-bold">Dari Tanggal</label>
                        <input type="date" name="tgl_awal" class="form-control" value="<?= $tgl_awal; ?>" required>
                    </div>
                    <div class="col-md-4 mb-3 mb-md-0">
                        <label class="form-label fw-bold">Sampai Tanggal</label>
                        <input type="date" name="tgl_akhir" class="form-control" value="<?= $tgl_akhir; ?>" required>
                    </div>
                    <div class="col-md-4">
                        <div class="d-grid gap-2 d-md-flex"> <button type="submit" class="btn btn-primary flex-fill">
                                <i class="bi bi-search me-1"></i> Tampilkan
                            </button>
                            
                            <a href="Pengembangan/print_pengembangan.php?tgl_awal=<?= $tgl_awal ?>&tgl_akhir=<?= $tgl_akhir ?>" target="_blank" class="btn btn-secondary flex-fill">
                                <i class="bi bi-printer me-1"></i> Cetak PDF
                            </a>
                        </div>
                    </div>
                </div>
            </form>
            </div>
          </div>

      <div class="row">
        <div class="col-12">
          <div class="card">

            
            <div class="card-header">
              <h3 class="card-title" style="font-weight: bold">Riwayat Setor & Tarik</h3>
          
              <div class="d-flex justify-content-end align-items-center mt-3">
                    <div class="col mb-3 mb-md-0 me-2">
                <label class="form-label fw-bold">Dari Tanggal</label>
                        <input type="date" name="tgl_awal" class="form-control" value="<?= $tgl_awal; ?>" required>
                    </div>
                    <div class="col mb-3 mb-md-0 me-2">
                        <label class="form-label fw-bold">Sampai Tanggal</label>
                        <input type="date" name="tgl_akhir" class="form-control" value="<?= $tgl_akhir; ?>" required>
                      </div>
                  <a href="?p=add_pg" class="btn btn-success me-2">
                      <i class="bi bi-plus-circle"></i> Tambah Data
                  </a>


                  <form class="d-flex" method="POST" action="">
                    <input class="form-control me-2" type="text" name="keyword" placeholder="Cari keterangan..." value="<?= $keyword ?>">
                    <button class="btn btn-primary" type="submit">Cari</button>
                    <a href="?p=PG" class="btn btn-secondary ms-1">Reset</a>
                  </form>
              </div>


          <div class="card-header">
              <h3 class="card-title">
                Laporan Periode: <b><?= date('d-m-Y', strtotime($tgl_awal)); ?></b> s/d <b><?= date('d-m-Y', strtotime($tgl_akhir)); ?></b>
              </h3>

            </div>


            <div class="card-body">
              
              <div class="d-flex justify-content-start align-items-center mb-3">
                    <a href="./?p=add_pg" class="btn btn-success space-right me-2">
                        <i class="bi bi-plus-circle"></i> Tambah Data
                    </a>
              </div>

              <table class="table table-bordered table-striped table-hover">
                <thead class="table-light"> 
                  <tr class="text-center align-middle"> 
                    <th style="width: 5%;">No</th> 
                    <th>Tanggal</th>
                    <th>Keterangan</th>
                    <th>Jenis</th>
                    <th>Debit (Masuk)</th>
                    <th>Kredit (Keluar)</th>
                    <th style="width: 15%;">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $no = 1;

                  foreach($data as $d){
                  ?>
                  <tr class="text-center align-middle"> 
                    <td><?= $no++; ?></td>
                    
                    <td><?= date('d-m-Y', strtotime($d['tanggal'])); ?></td>
                    
                    <td><?= $d['keterangan']; ?></td>
                    
                    <td>
                        <?php if($d['jenis'] == 'setor'){ ?>
                            <span class="badge bg-success">Setor</span>
                        <?php } else { ?>
                            <span class="badge bg-danger">Tarik</span>
                        <?php } ?>
                    </td>

                    <td>>
                        <?php 
                        if($d['jenis'] == 'setor'){
                            echo "Rp " . number_format($d['jumlah'], 0, ',', '.');
                        } else {
                            echo "-";
                        }
                        ?>
                    </td>

                    <td>>
                        <?php 
                        if($d['jenis'] == 'tarik'){
                            echo "Rp " . number_format($d['jumlah'], 0, ',', '.');
                        } else {
                            echo "-";
                        }
                        ?>
                    </td>

                    <td>
                        <a href="?p=edit_pg&id=<?= $d['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                        <a href="?p=hapus_pg&id=<?= $d['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus data ini?')">Hapus</a>
                    </td>

                  </tr>
                  <?php }?>
                  
                  <?php 
                  if($data->num_rows == 0): 
                  ?>
                      <tr><td colspan="7" class="text-center text-muted fst-italic py-3">Belum ada riwayat Pengeluaran atau Pemasukan</td></tr>
                  <?php endif; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>