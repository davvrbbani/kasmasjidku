<?php
require_once "../config.php";

$xid = $_GET['id'];

// ambil data lama
$sql = $konek->query("SELECT * FROM pengembangan WHERE id='$xid'");
$data = $sql->fetch_assoc();

if (isset($_POST['update'])) {

    $nama_program = $_POST['nama_program'];
    $target_dana  = $_POST['target_dana'];
    $status       = $_POST['setatus'];

    if ($status == '') {
        echo "<script>alert('Status wajib dipilih');history.back();</script>";
        exit;
    }

    $sql_update = "UPDATE pengembangan SET 
                    nama_program = '$nama_program',
                    target_dana  = '$target_dana',
                    setatus      = '$status'
                   WHERE id = '$xid'";

    $update = $konek->query($sql_update);

    if ($update) {
        echo "<script>alert('Data Berhasil Diupdate!'); window.location='./?p=PG';</script>";
    } else {
        echo "<script>alert('Gagal Update: " . $konek->error . "');</script>";
    }
}
?>

<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <h3 class="mb-0">Edit Rencana Pengembangan</h3>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Form Edit Data</h3>
                    <a href="./?p=PG" class="btn btn-secondary btn-md float-end">
                        <i class="bi bi-arrow-left-circle"></i> Kembali
                    </a>
                </div>

                <div class="card-body">
                    <form method="POST">
                        <table class="table table-bordered" style="max-width:600px;">

                            <tr>
                                <td>Nama Program</td>
                                <td>
                                    <input type="text" name="nama_program"
                                           class="form-control"
                                           value="<?= $data['nama_program']; ?>"
                                           required>
                                </td>
                            </tr>

                            <tr>
                                <td>Target Dana (Rp)</td>
                                <td>
                                    <input type="number" name="target_dana"
                                           class="form-control"
                                           value="<?= $data['target_dana']; ?>"
                                           required>
                                </td>
                            </tr>

                            <tr>
                                <td>Status</td>
                                <td>
                                    <select name="setatus" class="form-control" required>
                                        <option value="">-- Pilih Status --</option>
                                        <option value="Direncanakan" <?= ($data['setatus']=='Direncanakan')?'selected':''; ?>>Direncanakan</option>
                                        <option value="Berjalan" <?= ($data['setatus']=='Berjalan')?'selected':''; ?>>Berjalan</option>
                                        <option value="Ditunda" <?= ($data['setatus']=='Ditunda')?'selected':''; ?>>Ditunda</option>
                                        <option value="Selesai" <?= ($data['setatus']=='Selesai')?'selected':''; ?>>Selesai</option>
                                    </select>
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
