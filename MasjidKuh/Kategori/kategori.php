<?php
require_once "../config.php";
$keyword = '';
if (isset($_POST['keyword'])) {
    $keyword = $_POST['keyword'];
}
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
                    <form class="d-flex" method="POST" action="#">
                    <input style="width: 250px" class="form-control me-2" type="text" name="keyword" placeholder="Cari keterangan..." value="<?= $keyword ?>">
                    <button class="btn btn-primary" type="submit">Cari</button>
                    <a href="kategori.php" class="btn btn-secondary ms-1">Reset</a>
                  </form>
                </tr>
                </table>
            </div>
            <div class="card-body">
                    <a href="./?p=add_ktgr" class="btn btn-success">
                        <i class="bi bi-plus-circle"></i> Tambah Kategori
                    </a>
                    <a href="./?p=add_sub" class="btn btn-success">
                        <i class="bi bi-plus-circle"></i> Tambah Sub Kategori
                    </a>
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
                          $data = $konek->query("SELECT * FROM kategori ORDER BY id ASC");
                          while($d = mysqli_fetch_array($data)){ 
                              $id_kategori = $d['id'];
                              $nama_kategori = $d['nama_kategori'];

                              $q_sub = mysqli_query($konek, "SELECT * FROM sub_kategori WHERE kategori_id='$id_kategori'");
                              $cek_sub = mysqli_num_rows($q_sub);
                              if ($cek_sub > 0)
                                  while ($sub = mysqli_fetch_array($q_sub)) { 
                          ?>
                                  <tr>
                                      <td><?= $no++; ?></td>
                                      <td><?= $nama_kategori; ?></td> 
                                      <td><?= $sub['nama_sub_kategori']; ?></td> 
                                      <td style="text-align: center;"><?= ucfirst($sub['jenis']); ?></td>
                                      <td style="text-align: center;">
                                          <a href="kategori_edit.php?id=<?= $sub['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                          <a href="kategori_hapus.php?id=<?= $sub['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus?')">Hapus</a>
                                      </td>
                                  </tr>
                          <?php
                                  
                              } else {
                          ?>
                                  <tr>
                                      <td><?= $no++; ?></td>
                                      <td><?= $nama_kategori; ?></td>
                                      <td class="text-danger"> - (Kosong) </td> 
                                      <td style="text-align: center;"> - </td>
                                      <td style="text-align: center;"> - </td>
                                  </tr>
                          <?php
                              } 
                            }
                          ?>
                      </tbody>
                </table>
            </div>
            </div>
          </div>
      </div>
    </div>
  </div>
</main> 