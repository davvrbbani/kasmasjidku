<?php
require_once '../config.php';

$xid = $_GET['id'];

// ambil data donatur lama
$sql = $konek->query("SELECT * FROM donatur WHERE id='$xid'");
$data = $sql->fetch_assoc();

if (isset($_POST['update'])) {
    $nama_donatur = $_POST['nama_donatur'];
    $no_hp        = $_POST['no_hp'];
    $join_date    = $_POST['join_date'];
    $alamat       = $_POST['alamat'];
    $keterangan   = $_POST['keterangan'];

    // validasi sederhana
    if ($nama_donatur == '' || $no_hp == '' || $join_date == '' || $alamat == '') {
        echo "<script>alert('Nama, No. HP, Join Date, dan Alamat wajib diisi');history.back();</script>";
        exit;
    }

    $sql_update = "UPDATE donatur SET 
                    nama_donatur = '$nama_donatur',
                    no_hp        = '$no_hp',
                    join_date    = '$join_date',
                    alamat       = '$alamat',
                    keterangan   = '$keterangan'
                   WHERE id = '$xid'";

    $update = $konek->query($sql_update);

    if ($update) {
        echo "<script>alert('Data Donatur Berhasil Diupdate!'); window.location='./?p=DN';</script>";
    } else {
        echo "<script>alert('Gagal Update: " . $konek->error . "');</script>";
    }
}
?>

<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <h3 class="mb-0">Edit Data Donatur</h3>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Form Edit Donatur</h3>
                    <a href="./?p=DN" class="btn btn-secondary btn-md float-end">
                        <i class="bi bi-arrow-left-circle"></i> Kembali
                    </a>
                </div>

                <div class="card-body">
                    <form method="POST">
                        <table class="table table-bordered" style="max-width:600px;">

                            <tr>
                                <td>Nama Donatur</td>
                                <td>
                                    <input type="text" name="nama_donatur"
                                        class="form-control"
                                        value="<?= $data['nama_donatur']; ?>"
                                        required>
                                </td>
                            </tr>

                            <tr>
                                <td>No. HP</td>
                                <td>
                                    <input type="text" name="no_hp"
                                        class="form-control"
                                        value="<?= $data['no_hp']; ?>"
                                        required>
                                </td>
                            </tr>

                            <tr>
                                <td>Join Date</td>
                                <td>
                                    <input type="date" name="join_date"
                                        class="form-control"
                                        value="<?= $data['join_date']; ?>"
                                        required>
                                </td>
                            </tr>

                            <tr>
                                <td>Alamat</td>
                                <td>
                                    <textarea name="alamat" class="form-control" rows="3" required><?= $data['alamat']; ?></textarea>
                                </td>
                            </tr>

                            <tr>
                                <td>Keterangan</td>
                                <td>
                                    <textarea name="keterangan" class="form-control" rows="3"><?= $data['keterangan']; ?></textarea>
                                </td>
                            </tr>

                            <tr>
                                <td colspan="2">
                                    <input type="submit" name="update"
                                        value="Simpan Perubahan"
                                        class="btn btn-primary">
                                </td>
                            </tr>

                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>