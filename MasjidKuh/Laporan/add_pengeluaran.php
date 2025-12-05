<?php
$tanggal    = $_POST['tanggal'];
$uraian     = $_POST['uraian'];
$nominal    = $_POST['nominal'];
$keterangan = $_POST['keterangan'];

if ($_POST['simpan']) {
    require_once "config.php";
    $sql = "INSERT INTO pengeluaran SET 
                tanggal='$tanggal',
                uraian='$uraian',
                nominal='$nominal',
                keterangan='$keterangan'";
    $q = $db->query($sql);
    if ($q) {
        echo "<div class='alert alert-success'>Data pengeluaran berhasil disimpan.
        <a href='./?action=Laporan/laporan_pengeluaran'>Lihat Data</a></div>";
    } else {
        echo "<div class='alert alert-danger'>Gagal menyimpan data!</div>";
    }
}
?>

<div class="content-wrapper">
    <section class="content-header">
        <h1 class="m-0">Tambah Pengeluaran</h1>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-body">
                <form method="post" action="#">
                    <table class="table">
                        <tr>
                            <td>Tanggal</td>
                            <td><input type="date" name="tanggal" class="form-control" value="<?=date('Y-m-d');?>"></td>
                        </tr>
                        <tr>
                            <td>Uraian</td>
                            <td><input type="text" name="uraian" class="form-control" value="<?=$uraian?>"></td>
                        </tr>
                        <tr>
                            <td>Nominal</td>
                            <td><input type="number" name="nominal" class="form-control" value="<?=$nominal?>"></td>
                        </tr>
                        <tr>
                            <td>Keterangan</td>
                            <td><textarea name="keterangan
