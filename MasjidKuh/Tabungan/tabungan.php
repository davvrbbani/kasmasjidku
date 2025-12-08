<?php
include "../config.php";
$keyword = $_POST['keyword'] ?? '';

if(!empty($keyword)){
    $query_str = "SELECT * FROM tabungan WHERE keterangan LIKE '%$keyword%' ORDER BY tanggal DESC";
} else {
    $query_str = "SELECT * FROM tabungan ORDER BY tanggal DESC";
}

$data = mysqli_query($konek, $query_str);

$q_saldo = mysqli_query($konek, "SELECT * FROM tabungan");
$total_tabungan = 0;
while($row = mysqli_fetch_array($q_saldo)){
    if($row['jenis'] == 'setor'){
        $total_tabungan += $row['jumlah'];
    } else {
        $total_tabungan -= $row['jumlah'];
    }
}
?>

<main class="app-main">
  <div class="app-content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">Rekening / Tabungan Masjid</h3></div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tabungan</li>
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
                      <h5 class="mb-0">Total Aset / Saldo Tabungan:</h5>
                      <h2 class="mb-0 fw-bold">Rp. <?= number_format($total_tabungan, 0, ',', '.'); ?></h2>
                  </div>
              </div>
          </div>
      </div>

      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Riwayat Setor & Tarik Tunai</h3>

              <div class="d-flex justify-content-between align-items-center mt-3">
                  
                  <a href="?p=add_tm" class="btn btn-success">
                      <i class="bi bi-plus-circle"></i> Transaksi Tabungan
                  </a>

                  <form class="d-flex" method="POST" action="">
                    <input class="form-control me-2" type="text" name="keyword" placeholder="Cari keterangan..." value="<?= $keyword ?>">
                    <button class="btn btn-primary" type="submit">Cari</button>
                    <a href="tabungan.php" class="btn btn-secondary ms-1">Reset</a>
                  </form>
              </div>
            </div>

            <div class="card-body">
              <table class="table table-bordered table-striped table-hover">
                <thead>
                  <tr style="text-align: center;">
                    <th width="5%">No</th>
                    <th>Tanggal</th>
                    <th>Keterangan</th>
                    <th>Jenis Transaksi</th>
                    <th>Debit (Masuk)</th>
                    <th>Kredit (Keluar)</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $no = 1;
                  while($d = mysqli_fetch_array($data)){
                  ?>
                  <tr style="text-align: center;">
                    <td><?= $no++; ?></td>
                    <td><?= date('d-m-Y', strtotime($d['tanggal'])); ?></td>
                    <td><?= $d['keterangan']; ?></td>
                    
                    <td>
                        <?php if($d['jenis'] == 'setor'){ ?>
                            <span class="badge bg-success">Setor Tunai</span>
                        <?php } else { ?>
                            <span class="badge bg-danger">Penarikan</span>
                        <?php } ?>
                    </td>

                    <td class="text-success fw-bold">
                        <?php 
                        if($d['jenis'] == 'setor'){
                            echo "Rp. " . number_format($d['jumlah'], 0, ',', '.');
                        } else {
                            echo "-";
                        }
                        ?>
                    </td>

                    <td class="text-danger fw-bold">
                        <?php 
                        if($d['jenis'] == 'tarik'){
                            echo "Rp. " . number_format($d['jumlah'], 0, ',', '.');
                        } else {
                            echo "-";
                        }
                        ?>
                    </td>

                    <td align="center">
                      <!-- Pilih versi yang folder-nya benar -->
                      <a href="?p=edit_tm&id=<?= $d['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                      <a href="?p=hapus_tm&id=<?= $d['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus data ini?')">Hapus</a>
                    </td>
                  </tr>
                  <?php } ?>
                  
                  <?php if(mysqli_num_rows($data) == 0): ?>
                      <tr><td colspan="7" class="text-center">Belum ada riwayat tabungan.</td></tr>
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
