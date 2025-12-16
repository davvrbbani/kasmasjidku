<?php
require_once "config.php"; 

// Ambil bulan dan tahun sekarang
$bulan_ini = date('m'); 
$tahun_ini = date('Y'); 
$nama_bulan = [
    '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April',
    '05' => 'Mei',     '06' => 'Juni',     '07' => 'Juli',  '08' => 'Agustus',
    '09' => 'September','10' => 'Oktober', '11' => 'November','12' => 'Desember'
];
$label_bulan = $nama_bulan[$bulan_ini] . " " . $tahun_ini;

// Hitung pemasukan bulan ini
$query_masuk_bln = "SELECT SUM(jumlah) AS total FROM transaksi 
                    WHERE sub_kategori_id IN (SELECT id FROM sub_kategori WHERE jenis = 'masuk')
                    AND MONTH(tanggal) = '$bulan_ini' AND YEAR(tanggal) = '$tahun_ini'";
$d_masuk = mysqli_fetch_assoc($konek->query($query_masuk_bln));
$total_masuk = $d_masuk['total'] ?? 0;

// Hitung pengeluaran bulan ini
$query_keluar_bln = "SELECT SUM(jumlah) AS total FROM transaksi 
                     WHERE sub_kategori_id IN (SELECT id FROM sub_kategori WHERE jenis = 'keluar')
                     AND MONTH(tanggal) = '$bulan_ini' AND YEAR(tanggal) = '$tahun_ini'";
$d_keluar = mysqli_fetch_assoc($konek->query($query_keluar_bln));
$total_keluar = $d_keluar['total'] ?? 0;

// Saldo akhir
$q_all_masuk = "SELECT SUM(jumlah) AS total FROM transaksi 
                WHERE sub_kategori_id IN (SELECT id FROM sub_kategori WHERE jenis = 'masuk')";
$all_masuk = mysqli_fetch_assoc($konek->query($q_all_masuk))['total'] ?? 0;

$q_all_keluar = "SELECT SUM(jumlah) AS total FROM transaksi 
                 WHERE sub_kategori_id IN (SELECT id FROM sub_kategori WHERE jenis = 'keluar')";
$all_keluar = mysqli_fetch_assoc($konek->query($q_all_keluar))['total'] ?? 0;

$saldo_akhir = max($all_masuk - $all_keluar, 0);

// Dana pengembangan
$query_pengembangan = "SELECT SUM(CASE WHEN jenis = 'setor' THEN jumlah ELSE -jumlah END) AS total 
                       FROM transaksi_pengembangan";
$d_pengembangan = mysqli_fetch_assoc($konek->query($query_pengembangan));
$pengembangan_masjid = $d_pengembangan['total'] ?? 0;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan Keuangan Masjid</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 14px; margin: 20px; color: #000; }
        h2 { text-align: center; margin-bottom: 5px; }
        p { text-align: center; margin-top: 0; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #000; padding: 6px 8px; text-align: left; }
        th { background-color: #f0f0f0; }
        .text-right { text-align: right; }
        .summary { margin-bottom: 30px; }
        .summary div { margin: 5px 0; }
        @media print {
            button { display: none; } /* sembunyikan tombol saat print */
        }
    </style>
</head>
<body>

    <h2>Laporan Keuangan Masjid Al-Ikhlas</h2>
    <p><?= $label_bulan ?></p>

    <div class="summary">
        <div><strong>Total Pemasukan Bulan Ini:</strong> Rp <?= number_format($total_masuk, 0, ',', '.') ?></div>
        <div><strong>Total Pengeluaran Bulan Ini:</strong> Rp <?= number_format($total_keluar, 0, ',', '.') ?></div>
        <div><strong>Saldo Kas Saat Ini:</strong> Rp <?= number_format($saldo_akhir, 0, ',', '.') ?></div>
        <div><strong>Dana Pengembangan:</strong> Rp <?= number_format($pengembangan_masjid, 0, ',', '.') ?></div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Kategori</th>
                <th>Keterangan</th>
                <th class="text-right">Masuk</th>
                <th class="text-right">Keluar</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $q_tabel = $konek->query("SELECT * FROM transaksi ORDER BY tanggal DESC LIMIT 20");
            while($d = mysqli_fetch_array($q_tabel)){
                $id = $d['sub_kategori_id'];
                $q_kat = $konek->query("SELECT * FROM sub_kategori WHERE id='$id'");
                
                if($q_kat && mysqli_num_rows($q_kat) > 0) {
                    $kat   = mysqli_fetch_array($q_kat);
                    $nama  = $kat['nama_sub_kategori']; 
                    $jenis = $kat['jenis'];
                } else {
                    $nama = "Kategori Terhapus";
                    $jenis = "unknown";
                }
            ?>
            <tr>
                <td><?= date('d M Y', strtotime($d['tanggal'])) ?></td>
                <td><?= $nama ?></td>
                <td><?= $d['keterangan'] ?></td>
                <td class="text-right"><?= $jenis == 'masuk' ? "Rp " . number_format($d['jumlah']) : "-" ?></td>
                <td class="text-right"><?= $jenis == 'keluar' ? "Rp " . number_format($d['jumlah']) : "-" ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

    <div style="text-align: center;">
        <button onclick="window.print()">Cetak Laporan</button>
    </div>

</body>
</html>
