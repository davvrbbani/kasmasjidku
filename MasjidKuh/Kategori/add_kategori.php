<?php
require_once '../config.php';

if (isset($_POST['simpan'])) {
    $nama = $_POST['nama_kategori'];

    $sql = "INSERT INTO kategori (nama_kategori) VALUES ('$nama')";
    $simpan = $konek->query($sql);

    if ($simpan) {
        echo "<script>alert('Data Berhasil Disimpan'); window.location='?p=KT'</script>";
    } else {
        echo "<script>alert('Data Gagal Disimpan'); window.location='?p=add_ktgr'</script>";
    }
}
?>
<main class="app-main">
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6"><h3 class="mb-0">Tambah Kategori</h3></div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Tambah Kategori Utama</li>
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
                    <a href="./?p=KT" class="btn btn-secondary btn-md float-end">
                <i class="bi bi-arrow-left-circle"></i> Kembali
              </a>
                    <h3 class="card-title">Tambah Kategori Utama</h3>
                </div>

                <div class="card-body">
                    <form method="post">
                        <table class="table table-bordered" style="width: 100%; max-width: 600px;">
                            <tr>
                                <td>Nama Kategori</td>
                                <td><input type="text" name="nama_kategori" class="form-control" placeholder="Masukkan Kategori Di sini!" required></td>
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
