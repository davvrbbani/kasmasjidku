<?php
require_once '../config.php';

if (isset($_POST['simpan'])) {
    $tanggal = $_POST['tanggal'];
    $keterangan = $_POST['keterangan'];
    $jenis = $_POST['jenis'];
    $jumlah = $_POST['jumlah'];

    $sql = "INSERT INTO tabungan (tanggal,keterangan,jenis,jumlah) 
            VALUES ('$tanggal','$keterangan','$jenis','$jumlah')";
    $simpan = $konek->query($sql);

    if ($simpan) {
        echo "<script>alert('Data Berhasil Disimpan'); window.location='?p=TM'</script>";
    } else {
        echo "<script>alert('Data Gagal Disimpan'); window.location='?p=add_tm'</script>";
    }
}
?>
<main class="app-main">
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6"><h3 class="mb-0">Tambah Tabungan</h3></div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Tambah Tabungan</li>
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
                    <h3 class="card-title">Tambah Tabungan</h3>
                </div>

                <div class="card-body">
                    <form method="post">
                        <table class="table table-bordered" style="width: 100%; max-width: 600px;">
                            <tr>
                                <td>Tanggal</td>
                                <td><input type="date" name="tanggal" class="form-control" required></td>
                            </tr>
                            <tr>
                                <td>Keterangan</td>
                                <td><input type="text" name="keterangan" class="form-control" required></td>
                            </tr>
                            <tr>
                                <td>Jenis Transaksi</td>
                                <td>
                                    <select name="jenis" class="form-control" required>
                                        <option value="setor">setor(masuk)</option>
                                        <option value="tarik">tarik (keluar)</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Jumlah</td>
                                <td><input type="number" name="jumlah" class="form-control" required></td>
                            </tr>
                            <tr>
                                <td></td>
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
