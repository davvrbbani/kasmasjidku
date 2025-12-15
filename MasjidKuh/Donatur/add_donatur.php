<?php
require_once '../config.php';

if (isset($_POST['simpan'])) {
    $nama_donatur = $_POST['nama_donatur'];
    $no_hp        = $_POST['no_hp'];
    $join_date    = $_POST['join_date'];
    $alamat       = $_POST['alamat'];
    $keterangan   = $_POST['keterangan'];

    $sql = "INSERT INTO donatur (nama_donatur, no_hp, join_date, alamat, keterangan)
            VALUES ('$nama_donatur', '$no_hp', '$join_date', '$alamat', '$keterangan')";
    $simpan = $konek->query($sql);

    if ($simpan) {
        echo "<script>alert('Data Donatur Berhasil Disimpan'); window.location='?p=DN'</script>";
    } else {
        echo "<script>alert('Data Gagal Disimpan: " . $konek->error . "'); window.location='?p=add_DN'</script>";
    }
}
?>

<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Tambah Donatur</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Tambah Donatur</li>
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
                            <a href="./?p=DN" class="btn btn-secondary btn-md float-end">
                                <i class="bi bi-arrow-left-circle"></i> Kembali
                            </a>
                            <h3 class="card-title">Form Tambah Donatur</h3>
                        </div>

                        <div class="card-body">
                            <form method="post">
                                <table class="table table-bordered" style="width: 100%; max-width: 600px;">
                                    <tr>
                                        <td>Nama Donatur</td>
                                        <td><input type="text" name="nama_donatur" class="form-control" placeholder="Masukkan Nama Donatur" required></td>
                                    </tr>
                                    <tr>
                                        <td>No. HP</td>
                                        <td><input type="text" name="no_hp" class="form-control" placeholder="Masukkan Nomor HP" required></td>
                                    </tr>
                                    <tr>
                                        <td>Join Date</td>
                                        <td><input type="date" name="join_date" class="form-control" required></td>
                                    </tr>
                                    <tr>
                                        <td>Alamat</td>
                                        <td><textarea name="alamat" class="form-control" placeholder="Masukkan Alamat" rows="3" required></textarea></td>
                                    </tr>
                                    <tr>
                                        <td>Keterangan</td>
                                        <td><textarea name="keterangan" class="form-control" placeholder="Masukkan Keterangan" rows="3"></textarea></td>
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