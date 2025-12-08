<?php
require_once "../config.php";
?>

<main class="app-main">
  <div class="app-content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">Kategori Transaksi Masjid</h3></div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Data Kategori</li>
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
              <h3 class="card-title" style="font-weight: bold;">Katalog Kategori & Sub Kategori</h3>

              <table class="table table-borderless mb-0 mt-3">
                <tr>
                <div class="d-flex justify-content-end align-items-right mt-2">
                    <a href="kategori_tambah.php" class="btn btn-success">
                        <i class="bi bi-plus-circle"></i> Tambah Kategori
                    </a>
                </tr>
                </table>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-hover table-striped">
                    <thead>
                    <tr style="text-align: center;">
                        <th>No</th>
                        <th>Kategori</th>
                        <th>Sub Kategori</th>
                        <th>Jenis</th>
                        <th>Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $no = 1;
                    $data = $konek ->query("SELECT * FROM sub_kategori ORDER BY id ASC");
                    foreach(($data) as $d){
                        if($d['kategori_id'] == 1){
                            $induk = "Pemasukan Rutin";
                        } elseif ($d['kategori_id'] == 2){
                            $induk = "Operasional Masjid";
                        } elseif ($d['kategori_id'] == 3){
                            $induk = "Pembangunan & Renovasi";
                        } elseif ($d['kategori_id'] == 4){
                            $induk = "Kegiatan Ibadah";
                        }     
                    ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= $induk; ?></td>
                        <td><?= $d['nama_sub_kategori']; ?></td>
                        <td style="text-align: center;"><?= ucfirst($d['jenis']); ?></td>
                        <td style="text-align: center;">
                            <a href="kategori_edit.php?id=<?= $d['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="kategori_hapus.php?id=<?= $d['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
                    </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
            </div>
          </div>
      </div>
    </div>
  </div>
</main> 