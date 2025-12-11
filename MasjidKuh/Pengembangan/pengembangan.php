<?php
include "../config.php";

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

      <div class="row">
        <div class="col-12">
          <div class="card">
            
            <div class="card-header">
              <h3 class="card-title" style="font-weight: bold">Riwayat Setor & Tarik</h3>

              <div class="d-flex justify-content-end align-items-center mt-3">
                  <a href="?p=add_tm" class="btn btn-success me-2">
                      <i class="bi bi-plus-circle"></i> Tambah Data
                  </a>

                  <form class="d-flex" method="POST" action="">
                    <input class="form-control me-2" type="text" name="keyword" placeholder="Cari keterangan..." value="<?= $keyword ?>">
                    <button class="btn btn-primary" type="submit">Cari</button>
                    <a href="?p=TM" class="btn btn-secondary ms-1">Reset</a>
                  </form>
              </div>
            </div>

            <div class="card-body">
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
                  <tr class="align-middle"> 
                    <td class="text-center"><?= $no++; ?></td>
                    
                    <td class="text-center"><?= date('d-m-Y', strtotime($d['tanggal'])); ?></td>
                    
                    <td><?= $d['keterangan']; ?></td>
                    
                    <td class="text-center">
                        <?php if($d['jenis'] == 'setor'){ ?>
                            <span class="badge bg-success">Setor</span>
                        <?php } else { ?>
                            <span class="badge bg-danger">Tarik</span>
                        <?php } ?>
                    </td>

                    <td class="text-end text-success fw-bold">
                        <?php 
                        if($d['jenis'] == 'setor'){
                            echo "Rp " . number_format($d['jumlah'], 0, ',', '.');
                        } else {
                            echo "-";
                        }
                        ?>
                    </td>

                    <td class="text-end text-danger fw-bold">
                        <?php 
                        if($d['jenis'] == 'tarik'){
                            echo "Rp " . number_format($d['jumlah'], 0, ',', '.');
                        } else {
                            echo "-";
                        }
                        ?>
                    </td>

                    <td class="text-center">
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