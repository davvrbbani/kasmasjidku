<?php
// error_reporting(0);
require_once '../config.php';
?>


<main class="app-main">
  <div class="app-content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">Tambah Katalog Kategori & Sub Kategori</h3></div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tambah Katalog Kategori & Sub Kategori</li>
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
              <h3 class="card-title" style="font-weight: bold;">Edit Data Katalog</h3>
              <a href="./?p=KT" class="btn btn-secondary btn-md float-end">
                <i class="bi bi-arrow-left-circle"></i> Kembali
              </a>
            </div>
            <div class="card-body">
              <?php
                if(isset($_POST['simpan'])){
                    $kategori     = $_POST['kategori'];
                    $subkategori  = $_POST['subkategori'];
                    $jenis        = $_POST['jenis'];

                    $sqlKategori = "INSERT INTO kategori (nama_kategori) VALUES ('$kategori')";
                    $simpanKategori = $konek->query($sqlKategori);

                    if($simpanKategori){
                        $kategori_id = $konek->insert_id;

                        $sqlSub = "INSERT INTO sub_kategori (kategori_id, nama_sub_kategori, jenis)
                                VALUES ('$kategori_id', '$subkategori', '$jenis')";

                        $simpanSub = $konek ->query($sqlSub);

                        if($simpanSub){
                            echo "<div class='alert alert-success'>
                                    Kategori & Sub kategori berhasil disimpan.
                                    <a href='./?p=KT'>Lihat Data</a>
                                </div>";
                        } else {
                            echo "<div class='alert alert-danger'>Gagal menyimpan sub kategori.</div>";
                        }

                    } else {
                        echo "<div class='alert alert-danger'>Gagal menyimpan kategori.</div>";
                    }
                }
                ?>
              <form method="POST" action="#">
                <table class="table table-borderless table-striped" style="width: 500px;">
                <tr>
                    <td>Kategori</td>
                    <td>
                    <input type="text" name="kategori" class="form-control" placeholder="Isikan Kategori" required>
                    </td>
                </tr>
                <tr>
                    <td>Sub Kategori</td>
                    <td>
                    <input type="text" name="subkategori" class="form-control" placeholder="Isikan Sub Kategori" required>
                    </td>
                </tr>
                <tr>
                    <td>Jenis</td>
                    <td>
                    <select class="form-control" name="jenis" required>
                        <option value="">Pilih Jenis</option>
                        <option value="masuk">masuk</option>
                        <option value="keluar">keluar</option>
                    </select>
                    </td>
                </tr>
                <tr>
                    <td><input type="submit" name="simpan" value=Simpan class="btn btn-primary mt-3">
                    </input></td>
                </table>
               </form>
            </div>
            </div>
          </div>
      </div>
    </div>
  </div>
</main>