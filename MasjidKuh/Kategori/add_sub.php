<?php
require_once '../config.php';

if (isset($_POST['simpan'])) {
    $kategori_id = $_POST['kategori_id'];
    $nama_sub    = $_POST['nama_sub'];
    $jenis       = $_POST['jenis'];

    if(empty($kategori_id)){
        echo "<script>alert('Semua data wajib diisi!'); window.location='?p=add_sub'</script>";
    } elseif (empty($nama_sub)){
        echo "<script>alert('Semua data wajib diisi!'); window.location='?p=add_sub'</script>";
    } elseif (empty($jenis)){
        echo "<script>alert('Semua data wajib diisi!'); window.location='?p=add_sub'</script>";
    } else {
        
        $sql = "INSERT INTO sub_kategori (nama_sub_kategori, jenis, kategori_id) 
                VALUES ('$nama_sub', '$jenis', '$kategori_id')";
        
        $simpan = $konek->query($sql);

        if ($simpan) {
            echo "<script>alert('Sub Kategori Berhasil Disimpan'); window.location='?p=KT'</script>";
        } else {
            echo "<script>alert('Gagal Disimpan: ".$konek->error."');</script>";
        }
    }
}
?>

<main class="app-main">
  <div class="app-content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">Tambah Sub Kategori</h3></div>
      </div>
    </div>
  </div>

  <div class="app-content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Form Tambah Sub Kategori</h3>
            </div>
            <div class="card-body">
              <form method="post">
                <table class="table table-bordered">
                  
                  <tr>
                    <td>Induk Kategori</td>
                    <td>
                        <select name="kategori_id" class="form-control" required>
                            <option value="">-- Pilih Kategori Utama --</option>
                            <?php
                            $q_kat = $konek->query("SELECT * FROM kategori ORDER BY nama_kategori ASC");
                            
                            foreach($q_kat as $k){
                            ?>
                                <option value="<?= $k['id'] ?>">
                                    <?= $k['nama_kategori'] ?>
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
                        <input type="text" name="nama_sub" class="form-control" placeholder="Contoh: Kotak Jumat / Bayar Listrik" required>
                    </td>
                  </tr>

                  <tr>
                    <td>Jenis</td>
                    <td>
                        <select name="jenis" class="form-control" required>
                            <option value="masuk">Pemasukan (Uang Masuk)</option>
                            <option value="keluar">Pengeluaran (Uang Keluar)</option>
                        </select>
                    </td>
                  </tr>

                  <tr>
                    <td></td>
                    <td>
                        <a href="?p=KT" class="btn btn-secondary">Kembali</a>
                        <input type="submit" name="simpan" value="Simpan" class="btn btn-primary">
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