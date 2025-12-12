<?php
require_once '../config.php';
$id = $_GET['id'];
$sql = "SELECT * FROM pengembangan WHERE id='$id'";
$q=$konek->query($sql);
$data =mysqli_fetch_array($q);
if (isset($_POST['update'])) {
    $tanggal = $_POST['tanggal'];
    $keterangan = $_POST['keterangan'];
    $jenis = $_POST['jenis'];
    $jumlah = $_POST['jumlah'];



    $sql = "UPDATE pengembangan SET tanggal='$tanggal',keterangan='$keterangan',jenis='$jenis',jumlah='$jumlah'

            WHERE id='$id'";
    $update = $konek->query($sql);

    if ($update) {
        echo "<script>alert('Data Berhasil Diupdate'); window.location='?p=PG'</script>";
    } else {
        echo "<script>alert('Data Gagal Diupdate'); window.location='?p=edit_pg&id=$id'</script>";
    }
}
?>
<main class="app-main">
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6"><h3 class="mb-0">Edit Transaksi Pengembangan</h3></div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Edit Transaksi Pengembangan</li>
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
                    <a href="./?p=PG" class="btn btn-secondary btn-md float-end">
                <i class="bi bi-arrow-left-circle"></i> Kembali
              </a>
                    <h3 class="card-title">Edit Transaksi</h3>
                </div>

                <div class="card-body">
                    <form method="post">
                        <table class="table table-bordered" style="width: 100%; max-width: 600px;">
                            <tr>
                                <td>Tanggal</td>
                                <td><input type="date" name="tanggal" value="<?php echo $data['tanggal'];?>" class="form-control" required></td>
                            </tr>
                            <tr>
                                <td>Keterangan</td>
                                <td><input type="text" name="keterangan" value="<?php echo $data['keterangan'];?>" class="form-control" required></td>
                            </tr>
                            <tr>
                                <td>Jenis Transaksi</td>
                                <td>
                                    <select name="jenis" class="form-control" required>
                                        <option value="setor"<?php if($data['jenis']=='setor') echo 'selected'; ?>>setor(masuk)</option>
                                        <option value="tarik"<?php if($data['jenis']=='tarik') echo 'selected'; ?>>tarik (keluar)</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Jumlah</td>
                                <td><input type="number" name="jumlah" value="<?php echo $data['jumlah'];?>" class="form-control" required></td>
                            </tr>
                            <tr>
                                <td><input type="submit" name="update" value="update" class="btn btn-primary"></td>
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
