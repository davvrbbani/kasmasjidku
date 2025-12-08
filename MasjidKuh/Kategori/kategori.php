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
                    <a href="./?p=add_kt" class="btn btn-success">
                        <i class="bi bi-plus-circle"></i> Tambah Kategori
                    </a>

                    <form class="d-flex" method="POST" action="#">
                    <input style="width: 250px" class="form-control me-2" type="text" name="keyword" placeholder="Cari keterangan..." value="<?= $keyword ?>">
                    <button class="btn btn-primary" type="submit">Cari</button>
                    <input type="reset" class="btn btn-secondary ms-1" value="Reset">
                  </form>
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
                    $data = $konek ->query("SELECT * FROM sub_kategori");
                    foreach(($data) as $d){
                        $induk = '';
                        $kat_id = $d['kategori_id'];
                        $kategori = $konek ->query("SELECT nama_kategori FROM kategori WHERE id = '$kat_id'");
                        foreach($kategori as $k){
                            $induk = $k['nama_kategori'];
                        }
                        if($d['jenis'] == 'masuk'){
                            $badge = '<span class="badge bg-success">Pemasukan</span>';
                        } else {
                            $badge = '<span class="badge bg-danger">Pengeluaran</span>';
                        }
                    ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= $induk; ?></td>
                        <td><?= $d['nama_sub_kategori']; ?></td>
                        <td style="text-align: center;"><?= $badge; ?></td>
                        <td style="text-align: center;">
                            <a href="./?p=edit_kt&id=<?= $d['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="./?p=hps_kt&id=<?= $d['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus data ini?')">Hapus</a>
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