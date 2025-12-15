<?php
require_once '../../config.php';

session_start();

$tgl_awal  = $_GET['tgl_awal'];
$tgl_akhir = $_GET['tgl_akhir'];

$id_user = $_SESSION['users_id'] ?? 0; 
$nama_bendahara = "......................"; 

if($id_user > 0){

    $q_user = $konek->query("SELECT nama_lengkap FROM users WHERE id='$id_user'")->fetch_assoc();
    $nama_bendahara = $q_user['nama_lengkap'] ?? "Administrator";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>-------------------------------------------------------------------------------------------------- Laporan Transakasi Pengembangan Masjid Al-Ikhlas <?= date('Y') ?></title>
    
    <link rel="stylesheet" href="../assets/css/adminlte.css"> 
    
    <style>
        @media print {
            @page { size: A4; margin: 2cm; }
            body { -webkit-print-color-adjust: exact; margin: 0; }
            .no-print { display: none; }
        }
        
        body { 
            background: white; 
            font-family: 'Times New Roman', Times, serif; 
            font-size: 12pt;
            color: #000;
        }

        .table-kop {
            width: 100%;
            border-bottom: 4px double #000;
            margin-bottom: 20px;
            padding-bottom: 10px;
        }
        
        .table-kop td {
            border: none !important;
            padding: 5px;
            vertical-align: middle;
        }

        .td-logo { width: 120px; text-align: right; }
        .logo-masjid { width: 100px; height: auto; }
        .td-text { text-align: left; }

        .table-laporan { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .table-laporan th, .table-laporan td { border: 1px solid #000; padding: 8px; }
        .table-laporan thead { background-color: #e9ecef !important; -webkit-print-color-adjust: exact; }
    </style>
</head>
<body>

    <table class="table-kop">
        <tr>
            <td class="td-text">
                <h2 style="margin: 0; font-weight: bold; font-size: 24pt;">MASJID AL-IKHLAS</h2>
                <p style="margin: 5px 0 0 0; font-size: 12pt;">Jl. MT. Haryono, Desa Karangsentul, Kec. Padamara, Purbalingga</p>
                <p style="margin: 0; font-size: 11pt; font-style: italic;">Telp: 0812-3456-7890 | Email: dkm@alikhlas.com</p>
            </td>
            <td class="td-logo">
                <img src="../../assets/img/Masjid logo.jpeg" alt="Logo" class="logo-masjid">
            </td>
        </tr>
    </table>

    <div class="text-center mb-4">
        <h3 style="text-decoration: underline; margin-bottom: 5px; font-weight: bold;">LAPORAN TRANSAKSI PENGEMBANGAN</h3>
        <p class="mb-0">Periode: <?= date('d-m-Y', strtotime($tgl_awal)) ?> s/d <?= date('d-m-Y', strtotime($tgl_akhir)) ?></p>
    </div>

    <table class="table-laporan">
        <thead>
            <tr class="text-center">
                <th width="5%">No</th>
                <th width="15%">Tanggal</th>
                <th>Kategori / Keterangan</th>
                <th width="20%">Pemasukan</th>
                <th width="20%">Pengeluaran</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            $total_masuk = 0;
            $total_keluar = 0;

            $query = $konek->query("SELECT * FROM transaksi_pengembangan WHERE tanggal BETWEEN '$tgl_awal' AND '$tgl_akhir' ORDER BY tanggal ASC");

            foreach($query as $d){
                
                $id_kat = $d['id'];
                $d_kat  = $konek->query("SELECT * FROM transaksi_pengembangan WHERE id='$id_kat'")->fetch_assoc();

                $nama_kat = $d_kat['keterangan'] ?? '-';
                $jenis    = $d_kat['jenis'] ?? '';

                $masuk = 0;
                $keluar = 0;

                if($jenis == 'Masuk'){
                    $masuk = $d['jumlah'];
                    $total_masuk += $masuk;
                } else {
                    $keluar = $d['jumlah'];
                    $total_keluar += $keluar;
                }
            ?>
            <tr>
                <td style="text-align: center;"><?= $no++; ?></td>
                <td style="text-align: center;"><?= date('d/m/Y', strtotime($d['tanggal'])); ?></td>
                <td>
                    <strong><?= $nama_kat; ?></strong><br>
                    <span style="font-size: 10pt; font-style: italic; color: #555;"><?= $d['keterangan']; ?></span>
                </td>
                <td style="text-align: right;"><?= ($masuk > 0) ? number_format($masuk, 0, ',', '.') : '-'; ?></td>
                <td style="text-align: right;"><?= ($keluar > 0) ? number_format($keluar, 0, ',', '.') : '-'; ?></td>
            </tr>
            <?php } ?>

            <?php if($query->num_rows == 0): ?>
                <tr><td colspan="5" style="text-align: center; padding: 20px;">Tidak ada data transaksi pada periode ini.</td></tr>
            <?php endif; ?>
        </tbody>
        <tfoot>
            <tr style="background-color: #f8f9fa; font-weight: bold;">
                <td colspan="3" style="text-align: center;">TOTAL</td>
                <td style="text-align: right;">Rp <?= number_format($total_masuk, 0, ',', '.'); ?></td>
                <td style="text-align: right;">Rp <?= number_format($total_keluar, 0, ',', '.'); ?></td>
            </tr>
            <tr style="background-color: #343a40; color: white; font-weight: bold;">
                <td colspan="3" style="text-align: center;">SALDO AKHIR</td>
                <td colspan="2" style="text-align: center; font-size: 14pt;">
                    Rp <?= number_format($total_masuk - $total_keluar, 0, ',', '.'); ?>
                </td>
            </tr>
        </tfoot>
    </table>

    <div style="margin-top: 50px;">
        <table width="100%">
            <tr>
                <td width="70%"></td> 
                <td width="30%" class="align: center;">
                    <p style="margin-bottom: 60px;">
                        Purbalingga, <?= date('d F Y') ?> <br>
                        Mengetahui,<br>Bendahara Masjid
                    </p>
                    
                    <p style="font-weight: bold; text-decoration: underline; text-transform: uppercase;">
                        <?= $nama_bendahara; ?>
                    </p>
                </td>
            </tr>
        </table>
    </div>

    <script>
        window.print();
    </script>

</body>
</html>