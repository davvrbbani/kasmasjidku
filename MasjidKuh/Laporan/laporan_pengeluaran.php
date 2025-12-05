<?php
include "../config.php";

// Default tanggal: Awal bulan ini sampai hari ini
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
                    <a href="laporan_print.php?tgl_awal=<?= $tgl_awal?>&tgl_akhir=<?= $tgl_akhir?>" target="_blank" class="btn btn-secondary w-100 ms-2">Cetak / PDF</a>
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
                <thead>
                  <tr class="text-center">
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


                  $query = mysqli_query($konek, "SELECT * FROM transaksi WHERE tanggal BETWEEN '$tgl_awal' AND '$tgl_akhir' ORDER BY tanggal ASC");
                  
                  while($d = mysqli_fetch_array($query)){

                      $id_kat = $d['kategori_id'];
                      $q_kat = mysqli_query($konek, "SELECT * FROM sub_kategori WHERE id='$id_kat'");
                      $d_kat = mysqli_fetch_array($q_kat);

                      $nama_kat = $d_kat['nama_kategori'];
                      $jenis    = $d_kat['jenis'];
                      

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
                    <td align="center"><?= $no++; ?></td>
                    <td align="center"><?= date('d-m-Y', strtotime($d['tanggal'])); ?></td>
                    <td>
                        <b><?= $nama_kat; ?></b><br>
                        <small class="text-muted"><?= $d['keterangan']; ?></small>
                    </td>
                    <td align="right"><?= ($pemasukan_row > 0) ? number_format($pemasukan_row,0,',','.') : '-'; ?></td>
                    <td align="right"><?= ($pengeluaran_row > 0) ? number_format($pengeluaran_row,0,',','.') : '-'; ?></td>
                  </tr>
                  <?php } ?>

                  <?php if(mysqli_num_rows($query) == 0): ?>
                      <tr><td colspan="5" class="text-center">Tidak ada transaksi pada periode ini.</td></tr>
                  <?php endif; ?>
                </tbody>
                <tfoot>
                    <tr class="fw-bold bg-light">
                        <td colspan="3" align="center">TOTAL</td>
                        <td align="right" class="text-success"><?= number_format($total_masuk,0,',','.'); ?></td>
                        <td align="right" class="text-danger"><?= number_format($total_keluar,0,',','.'); ?></td>
                    </tr>
                    <tr class="fw-bold bg-dark text-white">
                        <td colspan="3" align="center">SALDO AKHIR (Pemasukan - Pengeluaran)</td>
                        <td colspan="2" align="center">
                            Rp. <?= number_format($total_masuk - $total_keluar, 0, ',', '.'); ?>
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