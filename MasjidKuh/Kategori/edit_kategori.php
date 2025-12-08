<?php
require_once "../config.php";
<<<<<<< HEAD
$xid = $_GET['id'];
$query = $konek->query("SELECT * FROM sub_kategori WHERE id = '$xid'");
$data = $query->fetch_assoc();
=======


$xid = $_GET['id'];


$q_data = mysqli_query($konek, "SELECT * FROM sub_kategori WHERE id='$xid'");
$data = mysqli_fetch_array($q_data);


if(isset($_POST['update'])){

    $id             = $_POST['id'];
    $kategori_id    = $_POST['kategori_id']; 
    $nama_sub       = $_POST['nama_sub_kategori'];
    $jenis          = $_POST['jenis'];

    $sql = "UPDATE sub_kategori SET 
            nama_sub_kategori = '$nama_sub',
            jenis = '$jenis',
            kategori_id = '$kategori_id'
            WHERE id = '$id'";

    $update = mysqli_query($konek, $sql);

    if($update){
        echo "<script>alert('Data Berhasil Diupdate!'); window.location='./?p=KT';</script>";
    } else {
        echo "<script>alert('Gagal Update: ".mysqli_error($konek)."');</script>";
    }
}
>>>>>>> 0137569fd8ce35368d157dc8df424e633fcc727d
?>

<main class="app-main">
  <div class="app-content-header">
    <div class="container-fluid">
      <div class="row">
<<<<<<< HEAD
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
=======
        <div class="col-sm-6"><h3 class="mb-0">Edit Sub Kategori</h3></div>
      </div>
    </div>
  </div>

>>>>>>> 0137569fd8ce35368d157dc8df424e633fcc727d
  <div class="app-content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
<<<<<<< HEAD
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
=======
              <h3 class="card-title">Form Edit Data</h3>
              <a href="./?p=KT" class="btn btn-secondary btn-sm float-end">Kembali</a>
            </div>
            <div class="card-body">
                
                <form method="POST" action="">
                    <input type="hidden" name="id" value="<?= $data['id']; ?>">

                    <table class="table table-bordered" style="width: 100%; max-width: 600px;">
                        
                        <tr>
                            <td>Induk Kategori</td>
                            <td>
                                <select name="kategori_id" class="form-control" required>
                                    <option value="">-- Pilih Kategori --</option>
                                    <?php

                                    $q_kat = mysqli_query($konek, "SELECT * FROM kategori ORDER BY nama_kategori ASC");
                                    
                                    while($k = mysqli_fetch_array($q_kat)){
                                        if($k['id'] == $data['kategori_id']){
                                            $pilih = "selected";
                                        } else {
                                            $pilih = "";
                                        }
                                        ?>
                                        <option value="<?= $k['id']; ?>" <?= $pilih; ?>>
                                            <?= $k['nama_kategori']; ?>
                                        </option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>

                        <tr>
                            <td>Nama Sub Kategori</td>
                            <td>
                                <input type="text" name="nama_sub_kategori" class="form-control" value="<?= $data['nama_sub_kategori']; ?>" required>
                            </td>
                        </tr>

                        <tr>
                            <td>Jenis Arus Kas</td>
                            <td>
                            <select name="jenis" class="form-control" required>
                                <option value="masuk" <?php if($data['jenis'] == 'masuk') { echo 'selected'; } ?>>Pemasukan</option>
                                <option value="keluar" <?php if($data['jenis'] == 'keluar') { echo 'selected'; } ?>>Pengeluaran</option>
                            </select>
                            </td>
                        </tr>

                        <tr>
                            <td></td>
                            <td>
                                <input type="submit" name="update" value="Simpan Perubahan" class="btn btn-primary">
                            </td>
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
>>>>>>> 0137569fd8ce35368d157dc8df424e633fcc727d
