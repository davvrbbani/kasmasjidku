<?php
require_once "../config.php";


$xid = $_GET['id'];


$q_data = $konek->query("SELECT * FROM sub_kategori WHERE id='$xid'");
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
?>

<main class="app-main">
  <div class="app-content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">Edit Sub Kategori</h3></div>
      </div>
    </div>
  </div>

  <div class="app-content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
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
