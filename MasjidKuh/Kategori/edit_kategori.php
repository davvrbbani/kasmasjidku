<?php
require_once "../config.php";
$xid = $_GET['id'];
$query = $konek->query("SELECT * FROM sub_kategori WHERE id = '$xid'");
$data = $query->fetch_assoc();
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
              <table class="table table-borderless mb-0 mt-3">
                <tr>
              <div class="d-flex justify-content-end align-items-right mt-2">
                    <a href="./?p=KT" class="btn btn-secondary btn-md float-end">
                        <i class="bi bi-arrow-left-circle"></i> Kembali
                    </a>
              </div>
                </tr>
              </table>
            </div>
            <div class="card-body">
                <?php
                if(isset($_POST['update'])){
                    $id = $_POST['id'];
                    $kategori     = $_POST['kategori'];
                    $subkategori  = $_POST['subkategori'];
                    $jenis        = $_POST['jenis'];

                    $sql = "UPDATE sub_kategori SET 
                            kategori_id = '$kategori',
                            nama_sub_kategori = '$subkategori',
                            jenis = '$jenis'
                            WHERE id = '$id'";

                    $update = $konek->query($sql);

                    if($update){
                        echo "<div class='alert alert-success'>Data kategori berhasil diupdate.
                        <a href='./?p=KT'>Lihat Data</a></div>";
                    } else {
                        echo '<div class="alert alert-danger">Data kategori gagal diupdate.</div>';
                    }
                }
                ?>
                <form method="POST" action="#">
                <table class="table table-borderless table-striped" style="width: 500px;">
                    <input type="hidden" name="id" value="<?= $data['id'] ?>">
                    <tr>
                        <td>Kategori</td>
                        <td><select class="form-control" name="kategori">
                            <?php
                            $kategori = $konek ->query("SELECT * FROM kategori ORDER BY id");
                            foreach($kategori as $k): ?>
                            <option value="<?= $k['id']; ?>" <?= ($data['kategori_id'] == $k['id']) ? '' : 'selected' ?>><?= $k['nama_kategori']; ?></option>
                            <?php endforeach;
                            ?>
                        </select></td>
                    </tr>
                    <tr>
                        <td>Sub Kategori</td>
                        <td><select class="form-control" name="subkategori">
                            <?php
                            $sub = $konek ->query("SELECT * FROM sub_kategori ORDER BY id");
                            foreach($sub as $s): ?>
                            <option value="<?= $s['id']; ?>" <?= ($data['id'] == $s['id']) ? 'selected' : '' ?>><?= $s['nama_sub_kategori']; ?></option>
                            <?php endforeach; ?>
                        </select>
                        </td>
                            
                    </tr>
                    <tr>
                        <td>Jenis</td>
                        <td>
                            <select class="form-control" name="jenis" required>
                                <option value="masuk" <?= ($data['jenis'] == 'masuk') ? 'selected' : '' ?>>Masuk</option>
                                <option value="keluar" <?= ($data['jenis'] == 'keluar') ? 'selected' : '' ?>>Keluar</option>
                            </select>
                        </td>
                    <tr>
                        <td><input type="submit" name="update" value="Simpan" class="btn btn-primary"></input></td>
                    </tr>
                    </table>
                </form>
            </div>
            </div>
          </div>
      </div>
    </div>
  </div>
</main> 