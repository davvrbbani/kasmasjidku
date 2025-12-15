<?php
require_once '../config.php';

// PROSES SIMPAN
if (isset($_POST['simpan'])) {
    $tanggal    = $_POST['tanggal'];
    $keterangan = $_POST['keterangan'];
    $jenis      = $_POST['jenis'];
    $jumlah     = $_POST['jumlah'];
    $id_pengembangan = $_POST['id_pengembangan'];

    // logika donatur
    if ($jenis === 'Masuk') {
        if (empty($_POST['id_donatur'])) {
            echo "<script>alert('Donatur wajib dipilih untuk transaksi pemasukan!');history.back();</script>";
            exit;
        }
        $id_donatur = $_POST['id_donatur'];
    } else {
        $id_donatur = NULL;
    }

    $sql = "INSERT INTO transaksi_pengembangan 
            (tanggal, keterangan, jenis, jumlah, id_donatur, id_pengembangan)
            VALUES
            ('$tanggal', '$keterangan', '$jenis', '$jumlah', " . ($id_donatur ? "'$id_donatur'" : "NULL") . ", '$id_pengembangan')";

    if ($konek->query($sql)) {
        echo "<script>alert('Data Berhasil Disimpan'); window.location='?p=TP';</script>";
    } else {
        echo "<script>alert('Data Gagal Disimpan'); history.back();</script>";
    }
}
?>

<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Tambah Transaksi Pengembangan</h3>
                </div>
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
                            <h3 class="card-title" style="font-weight: bold;">Form Tambah Transaksi Pengembangan</h3>
                            <a href="./?p=TP" class="btn btn-secondary btn-md float-end">
                                <i class="bi bi-arrow-left-circle"></i> Kembali
                            </a>
                        </div>

                        <div class="card-body">
                            <form method="post">
                                <table class="table table-borderless" style="width:500px">

                                    <!-- Nama Program -->
                                     <tr>
                                        <td>Program Pengembangan</td>
                                        <td>
                                            <select name="id_pengembangan" id="pengembangan" class="form-control">
                                                <option value="">-- Pilih Nama Program --</option>
                                                <?php
                                                $donatur = $konek->query("SELECT id, nama_program FROM pengembangan ORDER BY nama_program");
                                                while ($d = $donatur->fetch_assoc()) {
                                                    echo "<option value='{$d['id']}'>{$d['nama_program']}</option>";
                                                }
                                                ?>
                                            </select>
                                        </td>
                                    </tr>

                                    <!-- DONATUR -->
                                    <tr>
                                        <td>Nama Donatur</td>
                                        <td>
                                            <select name="id_donatur" id="donatur" class="form-control">
                                                <option value="">-- Pilih Nama Donatur --</option>
                                                <?php
                                                $donatur = $konek->query("SELECT id, nama_donatur FROM donatur ORDER BY nama_donatur");
                                                while ($d = $donatur->fetch_assoc()) {
                                                    echo "<option value='{$d['id']}'>{$d['nama_donatur']}</option>";
                                                }
                                                ?>
                                            </select>
                                        </td>
                                    </tr>

                                    <!-- TANGGAL -->
                                    <tr>
                                        <td>Tanggal</td>
                                        <td>
                                            <input type="date" name="tanggal" class="form-control" required>
                                        </td>
                                    </tr>

                                    <!-- KETERANGAN -->
                                    <tr>
                                        <td>Keterangan</td>
                                        <td>
                                            <input type="text" name="keterangan" class="form-control"
                                                placeholder="Contoh: Donasi pembangunan Canopy">
                                        </td>
                                    </tr>

                                    <!-- JENIS -->
                                    <tr>
                                        <td>Jenis Transaksi</td>
                                        <td>
                                            <select name="jenis" id="jenis" class="form-control" required onchange="toggleDonatur()">
                                                <option value="">-- Pilih Jenis Transaksi --</option>
                                                <option value="masuk">Setor (Pemasukan)</option>
                                                <option value="keluar">Tarik (Pengeluaran)</option>
                                            </select>
                                        </td>
                                    </tr>

                                    <!-- JUMLAH -->
                                    <tr>
                                        <td>Jumlah (Rp)</td>
                                        <td>
                                            <input type="number" name="jumlah" class="form-control"
                                                placeholder="Masukkan nominal" required>
                                        </td>
                                    </tr>

                                    <!-- SUBMIT -->
                                    <tr>
                                        <td></td>
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

<script>
    function toggleDonatur() {
        const jenis = document.getElementById('jenis').value;
        const donatur = document.getElementById('donatur');

        if (jenis === 'Keluar') {
            donatur.value = "";
            donatur.disabled = true;
        } else {
            donatur.disabled = false;
        }
    }
</script>