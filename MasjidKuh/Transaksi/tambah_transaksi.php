<?php
require_once '../config.php';
$data=$konek ->query("SELECT * FROM transaksi ");
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
              <button class="btn btn-secondary btn-md float-end" onclick="history.back()">
                <i class="bi bi-arrow-left-circle"></i> Kembali
            </div>
            <div class="card-body">
              <?php 
              if($_POST['simpan']){
                $tanggal = $_POST['tanggal'];
                $kategori = $_POST['kategori'];
                $subkategori = $_POST['subkategori'];
                $keterangan = $_POST['keterangan'];
                $jenis = $_POST['jenis'];
                $jumlah = $_POST['jumlah'];

                $sql = ("INSERT INTO transaksi SET tanggal='$tanggal', kategori='$kategori', subkategori='$subkategori', keterangan='$keterangan', jenis='$jenis', jumlah='$jumlah'");
                $simpan = $konek ->query($sql);

                if($simpan){
                  echo '<div class="alert alert-success alert-dismissible">
                  <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                  Data transaksi berhasil disimpan.
                  </div>';
                } else {
                  echo '<div class="alert alert-danger alert-dismissible">
                  <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                  Data transaksi gagal disimpan.
                  </div>';
                }
              }
              ?>
                <form method="POST" action="#">
                    <div class="mb-3">
                    <label for="tanggal" class="form-label">Tanggal</label>
                    <input type="date" class="form-control" id="tanggal" name="tanggal" value="<?= $tanggal ?>">
                    </div>
                    < class="mb-3">
                  <form method="GET" action="">
                  <label>Kategori</label>
                  <select name="kategori" class="form-select" onchange="this.form.submit()">
                      <option value="">Pilih Kategori</option>
                      <?php 
                      $kat = $konek->query("SELECT * FROM kategori");
                      while($row = $kat->fetch_assoc()){
                          $selected = (isset($_GET['kategori']) && $_GET['kategori'] == $row['id']) ? 'selected' : '';
                          echo '<option value="'.$row['id'].'" '.$selected.'>'.$row['nama_induk_kategori'].'</option>';
                      }
                      ?>
                  </select>
                  </form>
                      <?php if(isset($_GET['kategori'])): ?>
    <form method="POST" action="">
        <label>Sub Kategori</label>
        <select name="subkategori" class="form-select">
            <option value="">Pilih Subkategori</option>
            <?php 
            $kat_id = $_GET['kategori'];
            $sub = $konek->query("SELECT * FROM subkategori WHERE induk_id='$kat_id'");
            while($row = $sub->fetch_assoc()){
                echo '<option value="'.$row['id'].'">'.$row['nama_kategori'].'</option>';
            }
            ?>
        </select>

        <!-- form lanjutan transaksi -->
        <label>Keterangan</label>
        <input type="text" name="keterangan" class="form-control">

        <label>Jenis</label>
        <select name="jenis" class="form-select">
            <option value="masuk">Masuk</option>
            <option value="keluar">Keluar</option>
        </select>

        <label>Jumlah</label>
        <input type="number" name="jumlah" class="form-control">

        <br>
        <input type="submit" name="simpan" value="Simpan" class="btn btn-primary">
    </form>
<?php endif; ?>
                    <div class="mb-3">
                    <label for="keterangan" class="form-label">Keterangan</label>
                    <input type="text" class="form-control" id="keterangan" name="keterangan"">
                    </div>
                    <div class="mb-3">
                    <label for="jenis" class="form-label">Jenis</label>
                    <select class="form-select" id="jenis" name="jenis">
                        <option value="" disabled selected>Pilih Jenis</option>
                        <option value="masuk">Masuk</option>
                        <option value="keluar">Keluar</option>
                    </select>
                    </div>
                    <div class="mb-3">
                    <label for="jumlah" class="form-label">Jumlah (Rp)</label>
                    <input type="number" class="form-control" id="jumlah" name="jumlah" value="<?= $jumlah ?>">
                    </div>
                    <input type="submit" name="simpan" value="Simpan" class="btn btn-primary">  </input>
                </form>
            </div>
            </div>
          </div>
      </div>
    </div>
  </div>
</main>