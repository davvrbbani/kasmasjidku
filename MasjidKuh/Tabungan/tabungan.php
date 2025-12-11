<?php
include "../config.php";

$keyword = $_POST['keyword'] ?? '';

if(!empty($keyword)){
    $data = $konek->query("SELECT * FROM tabungan WHERE keterangan LIKE '%$keyword%' ORDER BY tanggal DESC");
} else {
    $data = $konek->query("SELECT * FROM tabungan ORDER BY tanggal DESC");
}

$q_saldo = $konek->query("SELECT * FROM tabungan");
$total_tabungan = 0;

foreach($q_saldo as $row){
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
                      <h2 class="mb-0 fw-bold">Rp <?= number_format($total_tabungan, 0, ',', '.'); ?></h2>
                  </div>
              </div>
          </div>
      </div>

      <div class="row">
        <div class="col-12">
          <div class="card">
            
            <div class="card-header">
              <h3 class="card-title" style="font-weight: bold">Riwayat Setor & Tarik Tunai</h3>

              <div class="d-flex justify-content-end align-items-center mt-3">
                  <a href="?p=add_tm" class="btn btn-success me-2">
                      <i class="bi bi-plus-circle"></i> Transaksi Tabungan
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
                            <span class="badge bg-success">Setor Tunai</span>
                        <?php } else { ?>
                            <span class="badge bg-danger">Penarikan</span>
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
                      <div class="btn-group btn-group-sm"> 
                        <a href="?p=edit_tm&id=<?= $d['id']; ?>" class="btn btn-warning" title="Edit">
                            <i class="bi bi-pencil-square">Edit</i> 
                        </a>
                        <a href="?p=hapus_tm&id=<?= $d['id']; ?>" class="btn btn-danger" onclick="return confirm('Hapus data ini?')" title="Hapus">
                            <i class="bi bi-trash">Hapus</i>
                        </a>
                      </div>
                    </td>

                  </tr>
                  <?php }?>
                  
                  <?php 
                  if($data->num_rows == 0): 
                  ?>
                      <tr><td colspan="7" class="text-center text-muted fst-italic py-3">Belum ada riwayat tabungan.</td></tr>
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