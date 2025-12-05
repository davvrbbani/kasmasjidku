

<div class="content-wrapper">
    <section class="content-header">
        <h1 class="m-0">Tambah Pengeluaran</h1>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-body">
                <form method="post" action="#">
                    <h3>Laporan Keuangan Masjid</h3>

<?php
include 'config.php';

$total_pemasukan = 0;
$total_pengeluaran = 0;
?>

<table>
    <tr>
        <th>No</th>
        <th>Tanggal</th>
        <th>Uraian / Kategori</th>
        <th>Pemasukan</th>
        <th>Pengeluaran</th>
    </tr>

    <?php
    $no = 1;
    $query = mysqli_query($konek, "SELECT * FROM transaksi ORDER BY tanggal ASC");
    
    while($row = mysqli_fetch_array($query)){
        // --- LOGIKA TANPA JOIN ---
        $id_kat = $row['kategori_id'];
        
        // Cari data sub kategori untuk tau ini masuk/keluar
        $q_kat = mysqli_query($konek, "SELECT * FROM sub_kategori WHERE id='$id_kat'");
        $d_kat = mysqli_fetch_array($q_kat);
        
        $jenis = $d_kat['jenis'];
        $nama_kat = $d_kat['nama_kategori'];
        $jumlah = $row['jumlah'];

        // --- LOGIKA HITUNG SALDO ---
        $pemasukan_row = 0;
        $pengeluaran_row = 0;

        if($jenis == 'masuk'){
            $total_pemasukan += $jumlah; // Tambah ke total
            $pemasukan_row = $jumlah;
        } else if($jenis == 'keluar'){
            $total_pengeluaran += $jumlah; // Tambah ke total
            $pengeluaran_row = $jumlah;
        }
    ?>
    <tr>
        <td><?= $no++; ?></td>
        <td><?= $row['tanggal']; ?></td>
        <td><?= $nama_kat; ?> <br> <small><i><?= $row['keterangan']; ?></i></small></td>
        <td ><?= ($pemasukan_row > 0) ? "Rp. ".number_format($pemasukan_row) : "-"; ?></td>
        <td ><?= ($pengeluaran_row > 0) ? "Rp. ".number_format($pengeluaran_row) : "-"; ?></td>
    </tr>
    <?php } ?>
    
    <tr style="font-weight:bold; background-color:#f0f0f0;">
        <td colspan="3">TOTAL</td>
        <td>Rp. <?= number_format($total_pemasukan); ?></td>
        <td>Rp. <?= number_format($total_pengeluaran); ?></td>
    </tr>
    
    <tr style="font-weight:bold; background-color:#ddd;">
        <td colspan="3" >SALDO AKHIR KAS</td>
        <td colspan="2" >
            Rp. <?= number_format($total_pemasukan - $total_pengeluaran); ?>
        </td>
    </tr>
</table>