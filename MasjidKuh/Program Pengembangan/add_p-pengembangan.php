<?php
require_once '../config.php';

if (isset($_POST['simpan'])) {
  $nama_program = $_POST['nama_program'];
  $target_dana  = $_POST['target_dana'];
  $status       = $_POST['setatus'];

  $sql = "INSERT INTO pengembangan (nama_program, target_dana, setatus) 
                VALUES ('$nama_program', '$target_dana', '$status')";

  $simpan = $konek->query($sql);

  if ($simpan) {
    echo "<script>alert('Data Berhasil Disimpan'); window.location='?p=PG'</script>";
  } else {
    echo "<script>alert('Gagal Disimpan: " . $konek->error . "');</script>";
  }
}
?>

<main class="app-main">
  <div class="app-content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6">
          <h3 class="mb-0">Tambah Rencana pengembangan</h3>
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
              <a href="./?p=PG" class="btn btn-secondary btn-md float-end">
                <i class="bi bi-arrow-left-circle"></i> Kembali
              </a>
              <h3 class="card-title">Form Tambah Rencana pengembangan</h3>
            </div>
            <div class="card-body">
              <form method="post">
                <table class="table table-bordered" style="width: 100%; max-width: 600px;">

                  <tr>
                    <td>Nama Program</td>
                    <td>
                      <input type="text" name="nama_program" class="form-control" placeholder="Contoh: Pembuatan Tempat Wudhu" required>
                    </td>
                  </tr>

                  <tr>
                    <td>Target Dana (Rp.)</td>
                    <td>
                      <input type="text" name="target_dana" class="form-control" placeholder="Masukkan dalam satuan Rp." required>
                    </td>
                  </tr>

                  <tr>
                    <td>Status</td>
                    <td>
                      <select name="setatus" class="form-control" required>
                        <option value="">-- Pilih Status --</option>
                        <option value="Direncanakan">Direncanakan</option>
                        <option value="Berjalan">Berjalan</option>
                        <option value="Ditunda">Ditunda</option>
                        <option value="Selesai">Selesai</option>
                      </select>

                    </td>
                  </tr>

                  <tr>
                    <td>
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