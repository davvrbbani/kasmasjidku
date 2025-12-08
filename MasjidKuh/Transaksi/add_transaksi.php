<?php
// error_reporting(0);
require_once '../config.php';

if (!isset($_SESSION['users_id'])) {
    die("User belum login / session users_id tidak ditemukan.");
}

$user_id = $_SESSION['users_id'];
?>


<main class="app-main">
  <div class="app-content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">Transaksi Kas Masjid</h3></div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tambah Transaksi</li>
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
              <h3 class="card-title" style="font-weight: bold;">Tambah Transaksi</h3>
              <a href="./?p=TS" class="btn btn-secondary btn-md float-end">
                <i class="bi bi-arrow-left-circle"></i> Kembali
              </a>
            </div>
            <div class="card-body">
              <?php
              if(isset($_POST['simpan'])){
              $tanggal = $_POST['tanggal'];
              $subkategori = $_POST['subkategori'];
              $keterangan = $_POST['keterangan'];
              $jumlah = $_POST['jumlah'];

              if (empty($subkategori)){
                echo '<div class ="alert alert-warning">Harap Pilih <b>Sub Kategori</b>Terlebih Dahulu!</div>';
              } elseif(empty($tanggal)) {
                echo '<div class ="alert alert-warning">Harap Isi <b>Tanggal</b>Terlebih Dahulu!</div>';                
              }
              else{
              $sql = "INSERT INTO transaksi (tanggal, sub_kategori_id, keterangan, jumlah, users_id)
                      VALUES ('$tanggal', '$subkategori', '$keterangan', '$jumlah', '$user_id')";

              $simpan = $konek->query($sql);
              
              if($simpan){
                  echo "<div class='alert alert-success'>Data transaksi berhasil disimpan.
                  <a href='./?p=TS'>Lihat Data</a></div>";
                  
              } else {
                  echo '<div class="alert alert-danger">Data transaksi gagal disimpan.</div>';
                  }
                }
              }
              ?>
              <form method="POST" action="#">
                <table style="width: 500px;">
                <tr>
                    <td>Tanggal</td>
                    <td><input type="date" name="tanggal" class="form-control" value="<?= $tanggal ?>"></td>
                </tr>
                <tr>
                    <td>Kategori</td>
                    <td>
                    <select class="form-control" name="kategori">  
                      <option value="">Pilih Kategori</option>
                        <?php
                        $kategori = $konek ->query("SELECT * FROM kategori ORDER BY id ASC");
                        foreach($kategori as $k): ?>
                      <option value="<?= $k['id']; ?>"><?= $k['nama_kategori']; ?></option>
                      <?php endforeach;
                      ?>
                    </select></td>
                </tr>
                <tr>
                    <td>Sub Kategori</td>
                    <td>
                    <select class="form-control" name="subkategori">  
                      <option value="">Pilih Sub Kategori</option>
                        <?php
                        $sub = $konek ->query("SELECT * FROM sub_kategori ORDER BY id ASC");
                        foreach($sub as $s): ?>
                      <option 
                        value="<?= $s['id']; ?>"
                        data-kat="<?= $s['kategori_id']; ?>">
                        <?= $s['nama_sub_kategori']; ?>
                      </option>
                      <?php endforeach;
                      ?>
                    </select></td>
                </tr>
                <tr>
                    <td>Keterangan</td>
                    <td><input type="text" name="keterangan" placeholder="Masukkan keterangan" value="" class="form-control" value="<?= $keterangan ?>"></td>
                </tr>
                <tr>
                    <td>Jumlah (Rp)</td>
                    <td><input type="number" name="jumlah" placeholder="Masukkan Jumlah dalam Rp" value="" class="form-control" value="<?= $jumlah ?>"></td>
                </tr>
                <tr>
                    <td><input type="submit" name="simpan" value=Simpan class="btn btn-primary mt-3">
                    </input></td>
                </table>
               </form>
               <script>
                document.querySelector('select[name="kategori"]').addEventListener('change', function() {
                    let idKat = this.value;
                    let sub = document.querySelector('select[name="subkategori"]');

                    [...sub.options].forEach(opt => {
                        if (opt.value === "") return;
                        opt.hidden = opt.getAttribute('data-kat') !== idKat;
                    });

                    sub.value = "";
                });
                </script>
            </div>
            </div>
          </div>
      </div>
    </div>
  </div>
</main>