<?php
require_once '../config.php';

if (isset($_POST['simpan'])) {
    $tanggal = $_POST['tanggal'];
    $keterangan = $_POST['keterangan'];
    $jenis = $_POST['jenis'];
    $jumlah = $_POST['jumlah'];

    $sql = "INSERT INTO pengembangan (tanggal,keterangan,jenis,jumlah) 
            VALUES ('$tanggal','$keterangan','$jenis','$jumlah')";
    $simpan = $konek->query($sql);

    if ($simpan) {
        echo "<script>alert('Data Berhasil Disimpan'); window.location='?p=PG'</script>";
    } else {
        echo "<script>alert('Data Gagal Disimpan'); window.location='?p=add_pg'</script>";
    }
}
?>
<main class="app-main">
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6"><h3 class="mb-0">Tambah Transaksi Pengembangan</h3></div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Tambah Transaksi Pengembangan</li>
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

                    <h3 class="card-title"> Tambah pengembangan masjid</h3>

                    <h3 class="card-title">Tambah Data</h3>

                    <a href="./?p=PG" class="btn btn-secondary btn-md float-end">
                        <i class="bi bi-arrow-left-circle"></i>Kembali</a>
                </div>

                <div class="card-body">
                    <form method="post" action="#">
                        <table class="table table-borderless table-striped" style="width: 500px;">
                            <tr>
                                <td>Tanggal</td>
                                <td><input type="date" name="tanggal" class="form-control" required></td>
                            </tr>
                            <tr>
                                <td>Keterangan</td>
                                <td><input type="text" name="keterangan" class="form-control" placeholder="Masukkan Keterangan..."></td>
                            </tr>
                            <tr>
                                <td>Jenis Transaksi</td>
                                <td>
                                    <select name="jenis" class="form-control" required>
                                        <option value="">-- Pilih Jenis Transaksi --</option>
                                        <option value="setor">setor(masuk)</option>
                                        <option value="tarik">tarik (keluar)</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Jumlah (Rp.)</td>
                                <td><input type="number" name="jumlah" class="form-control" placeholder="Jumlah dalam satuan Rupiah" required></td>
                            </tr>
                            <tr>
                                <td><input type="submit" name="simpan" value="Simpan" class="btn btn-primary"></td>
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
