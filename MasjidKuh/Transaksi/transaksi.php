<?php
include "../config.php";

$keyword = $_POST['keyword'] ?? '';
if(empty($keyword)){
    $data = $konek->query("SELECT * FROM transaksi ORDER BY tanggal DESC LIMIT 10");
} else {
    $data = $konek->query("SELECT * FROM transaksi WHERE keterangan LIKE '%$keyword%' ORDER BY tanggal DESC");
}
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
      <div class="row">
        <div class="col-12">
          <div class="card">
            
            <div class="card-header">
              <h3 class="card-title" style="font-weight: bold;">Data Pemasukan & Pengeluaran</h3>
              
              <div class="d-flex justify-content-end align-items-center mt-2">
                  <a href="./?p=add_tr" class="btn btn-success me-2">
                      <i class="bi bi-plus-circle"></i> Tambah Transaksi
                  </a>

                  <form class="d-flex" method="POST" action="#">
                    <input style="width: 250px" class="form-control me-2" type="text" name="keyword" placeholder="Cari keterangan..." value="<?= $keyword ?>">
                    <button class="btn btn-primary" type="submit">Cari</button>
                    <a href="./?p=TS" class="btn btn-secondary ms-1">Reset</a>
                  </form>
              </div>
            </div>

            <div class="card-body">
              <table class="table table-bordered table-hover table-striped">
                <thead class="table-light">
                  <tr class="text-center align-middle">
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

                      $id_kat = $d['sub_kategori_id'];
                      $d_kat  = $konek->query("SELECT * FROM sub_kategori WHERE id='$id_kat'")->fetch_assoc();

                      $nama_kategori = $d_kat['nama_sub_kategori'] ?? '-';
                      $jenis         = $d_kat['jenis'] ?? '';
                  ?>
                  <tr class="align-middle">
                    <td class="text-center"><?= $no++; ?></td>
                    <td class="text-center"><?= date('d-m-Y', strtotime($d['tanggal'])); ?></td>
                    <td><?= $nama_kategori; ?></td>
                    
                    <td class="text-center">
                        <?php if($jenis == 'masuk'){ ?>
                            <span class="badge bg-success">Pemasukan</span>
                        <?php } else { ?>
                            <span class="badge bg-danger">Pengeluaran</span>
                        <?php } ?>
                    </td>
                    
                    <td><?= $d['keterangan']; ?></td>
                    
                    <td class="text-center fw-bold">
                        Rp <?= number_format($d['jumlah'], 0, ',', '.'); ?>
                    </td>
                    
                    <td class="text-center">
                      <a href="./?p=edit_tr&id=<?= $d['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                      <a href="./?p=hps_tr&id=<?= $d['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus data ini?')">Hapus</a>
                    </td>
                  </tr>
                  <?php } ?>
                  
                  <?php 
                  if($data->num_rows == 0): 
                  ?>
                      <tr><td colspan="7" class="text-center text-muted fst-italic py-3">Belum ada data transaksi.</td></tr>
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