<?php
include "../config.php";

$tgl_awal  = $_POST['tgl_awal'] ?? date('Y-m-01');
$tgl_akhir = $_POST['tgl_akhir'] ?? date('Y-m-d');
?>

<main class="app-main">
  <div class="app-content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">Laporan Keuangan</h3></div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Laporan</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <div class="app-content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          
          <div class="card mb-4">
            <div class="card-header bg-primary text-white">
              <h3 class="card-title">Filter Laporan</h3>
            </div>
            <div class="card-body">
              <form method="POST" action="">
                <div class="row">
                  <div class="col-md-4">
                    <label>Dari Tanggal</label>
                    <input type="date" name="tgl_awal" class="form-control" value="<?= $tgl_awal; ?>" required>
                  </div>
                  <div class="col-md-4">
                    <label>Sampai Tanggal</label>
                    <input type="date" name="tgl_akhir" class="form-control" value="<?= $tgl_akhir; ?>" required>
                  </div>
                  <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">Tampilkan Laporan</button>
                  </div>
                </div>
              </form>
            </div>
          </div>

          <div class="card">
            <div class="card-header">
              <h3 class="card-title">
                Laporan Periode: <b><?= date('d-m-Y', strtotime($tgl_awal)); ?></b> s/d <b><?= date('d-m-Y', strtotime($tgl_akhir)); ?></b>
              </h3>
            </div>
            <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead class="table-light">
                    <tr class="text-center align-middle">
                        <th width="5%">No</th>
                        <th>Tanggal</th>
                        <th>Kategori & Keterangan</th>
                        <th>Pemasukan (Rp)</th>
                        <th>Pengeluaran (Rp)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    $total_masuk = 0;
                    $total_keluar = 0;

                    $query = $konek->query("SELECT * FROM transaksi WHERE tanggal BETWEEN '$tgl_awal' AND '$tgl_akhir' ORDER BY tanggal ASC");
                    
                    foreach($query as $d){

                        $id_kat = $d['sub_kategori_id'];
                        $d_kat = $konek->query("SELECT * FROM sub_kategori WHERE id='$id_kat'")->fetch_assoc();

                        $nama_kat = $d_kat['nama_sub_kategori'] ?? '-';
                        $jenis    = $d_kat['jenis'] ?? '';
                        
                        $pemasukan_row = 0;
                        $pengeluaran_row = 0;

                        if($jenis == 'masuk'){
                            $pemasukan_row = $d['jumlah'];
                            $total_masuk += $d['jumlah'];
                        } else {
                            $pengeluaran_row = $d['jumlah'];
                            $total_keluar += $d['jumlah'];
                        }
                    ?>
                    <tr>
                        <td class="text-center"><?= $no++; ?></td>
                        <td class="text-center"><?= date('d-m-Y', strtotime($d['tanggal'])); ?></td>
                        <td>
                            <b><?= $nama_kat; ?></b><br>
                            <small class="text-muted"><?= $d['keterangan']; ?></small>
                        </td>
                        
                        <td class="text-end">
                            <?= ($pemasukan_row > 0) ? number_format($pemasukan_row, 0, ',', '.') : '-'; ?>
                        </td>
                        
                        <td class="text-end">
                            <?= ($pengeluaran_row > 0) ? number_format($pengeluaran_row, 0, ',', '.') : '-'; ?>
                        </td>
                    </tr>
                    <?php }?>

                    <?php 
                    if($query->num_rows == 0): 
                    ?>
                        <tr><td colspan="5" class="text-center fst-italic py-3">Tidak ada transaksi pada periode ini.</td></tr>
                    <?php endif; ?>
                </tbody>
                
                <tfoot>
                    <tr class="fw-bold bg-light">
                        <td colspan="3" class="text-center">TOTAL</td>
                        <td class="text-end text-success"><?= number_format($total_masuk, 0, ',', '.'); ?></td>
                        <td class="text-end text-danger"><?= number_format($total_keluar, 0, ',', '.'); ?></td>
                    </tr>
                    <tr class="fw-bold bg-dark text-white">
                        <td colspan="3" class="text-center">SALDO AKHIR (Pemasukan - Pengeluaran)</td>
                        <td colspan="2" class="text-center">
                            Rp <?= number_format($total_masuk - $total_keluar, 0, ',', '.'); ?>
                        </td>
                    </tr>
                </tfoot>
            </table>
            </div>
          </div>
          </div>
      </div>
    </div>
  </div>
</main>