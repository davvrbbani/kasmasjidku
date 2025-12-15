<?php
require_once '../config.php';

$id = $_GET['id'];

// ambil data transaksi
$sql = "SELECT * FROM transaksi_pengembangan WHERE id='$id'";
$q   = $konek->query($sql);
$data = mysqli_fetch_assoc($q);

// ambil data program & donatur
$program = $konek->query("SELECT id, nama_program FROM pengembangan ORDER BY nama_program ASC");
$donatur = $konek->query("SELECT id, nama_donatur FROM donatur ORDER BY nama_donatur ASC");

if (isset($_POST['update'])) {

    $id_pengembangan = $_POST['id_pengembangan'];
    $id_donatur = !empty($_POST['id_donatur']) ? $_POST['id_donatur'] : NULL;
    $tanggal = $_POST['tanggal'];
    $jenis = $_POST['jenis'];
    $jumlah = $_POST['jumlah'];
    $keterangan = $_POST['keterangan'];

    $sql_update = "
        UPDATE transaksi_pengembangan SET
            id_pengembangan = '$id_pengembangan',
            id_donatur      = " . ($id_donatur ? "'$id_donatur'" : "NULL") . ",
            tanggal         = '$tanggal',
            jenis           = '$jenis',
            jumlah          = '$jumlah',
            keterangan      = '$keterangan'
        WHERE id = '$id'
    ";

    $update = $konek->query($sql_update);

    if ($update) {
        echo "<script>alert('Data Berhasil Diupdate'); window.location='?p=TP'</script>";
    } else {
        echo "<script>alert('Data Gagal Diupdate'); window.location='?p=edit_tp&id=$id'</script>";
    }
}
?>

<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Edit Transaksi Pengembangan</h3>
                </div>
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
                        </div>

                        <div class="card-body">
                            <form method="post">
                                <table class="table table-bordered" style="max-width:600px;">

                                    <tr>
                                        <td>Program Pengembangan</td>
                                        <td>
                                            <select name="id_pengembangan" class="form-control" required>
                                                <option value="">-- Pilih Program --</option>
                                                <?php while ($p = mysqli_fetch_assoc($program)) { ?>
                                                    <option value="<?= $p['id']; ?>"
                                                        <?= ($p['id'] == $data['id_pengembangan']) ? 'selected' : ''; ?>>
                                                        <?= $p['nama_program']; ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Donatur</td>
                                        <td>
                                            <select name="id_donatur" class="form-control">
                                                <option value="">-- Pilih Donatur --</option>
                                                <?php while ($d = mysqli_fetch_assoc($donatur)) { ?>
                                                    <option value="<?= $d['id']; ?>"
                                                        <?= ($d['id'] == $data['id_donatur']) ? 'selected' : ''; ?>>
                                                        <?= $d['nama_donatur']; ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Tanggal</td>
                                        <td>
                                            <input type="date" name="tanggal" value="<?= $data['tanggal']; ?>" class="form-control" required>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Jenis Transaksi</td>
                                        <td>
                                            <select name="jenis" class="form-control" required>
                                                <option value="Masuk" <?= ($data['jenis'] == 'Masuk') ? 'selected' : ''; ?>>Masuk</option>
                                                <option value="Keluar" <?= ($data['jenis'] == 'Keluar') ? 'selected' : ''; ?>>Keluar</option>
                                            </select>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Jumlah (Rp)</td>
                                        <td>
                                            <input type="number" name="jumlah" value="<?= $data['jumlah']; ?>" class="form-control" required>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Keterangan</td>
                                        <td>
                                            <input type="text" name="keterangan" value="<?= $data['keterangan']; ?>" class="form-control">
                                        </td>
                                    </tr>

                                    <tr>
                                        <td colspan="2">
                                            <button type="submit" name="update" class="btn btn-primary">
                                                Update Data
                                            </button>
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