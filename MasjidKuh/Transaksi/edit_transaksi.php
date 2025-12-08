<?php
require_once "../config.php";
$xid = $_GET['id'];
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
                    <a href="./?p=TS" class="btn btn-secondary btn-md float-end">
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
                    $tanggal = $_POST['tanggal'];
                    $subkategori = $_POST['subkategori'];
                    $keterangan = $_POST['keterangan'];
                    $jumlah = $_POST['jumlah'];

                    $sql = "UPDATE transaksi SET 
                            tanggal = '$tanggal',
                            sub_kategori_id = '$subkategori',
                            keterangan = '$keterangan',
                            jumlah = '$jumlah'
                            WHERE id = '$id'";

                    $update = $konek->query($sql);

                    if($update){
                        echo "<div class='alert alert-success'>Data transaksi berhasil diupdate.
                        <a href='./?p=TS'>Lihat Data</a></div>";
                    } else {
                        echo '<div class="alert alert-danger">Data transaksi gagal diupdate.</div>';
                    }
                }
                $query = "SELECT * FROM transaksi WHERE id='$xid'";
                $data = $konek->query($query)->fetch_assoc();
                ?>
                <form method="POST" action="#">
                    <input type="hidden" name="id" value="<?= $data['id']; ?>">
                    <table class="table table-borderless table-striped" style="width: 500px;">
                    <tr>
                        <td>Tanggal</td>
                        <td><input type="date" name="tanggal" class="form-control" value="<?= $data['tanggal']; ?>"></td>
                    </tr>
                    <tr>
                        <td>Sub Kategori</td>
                        <td><select name="subkategori" class="form-control">
                            <option value="">Pilih Sub Kategori</option>
                            <?php
                            $subkategori = $konek->query("SELECT * FROM sub_kategori ORDER BY nama_sub_kategori ASC");
                            while($sk = $subkategori->fetch_assoc()){
                                $selected = ($sk['id'] == $data['sub_kategori_id']) ? 'selected' : '';
                                echo "<option value='{$sk['id']}' $selected>{$sk['nama_sub_kategori']}</option>";
                            }
                            ?>
                        </select></td>
                    </tr>
                    <tr>
                        <td>Keterangan</td>
                        <td><input type="text" name="keterangan" class="form-control" value="<?= $data['keterangan']; ?>"></td>
                    </tr>
                    <tr>
                        <td>Jumlah</td>
                        <td><input type="number" name="jumlah" class="form-control" value="<?= $data['jumlah']; ?>"></td>
                    </tr>
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