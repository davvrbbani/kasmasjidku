<?php
require_once "config.php";
session_start();

$bulan_ini = date('m');
$tahun_ini = date('Y');

$nama_bulan = [
    '01' => 'Januari',
    '02' => 'Februari',
    '03' => 'Maret',
    '04' => 'April',
    '05' => 'Mei',
    '06' => 'Juni',
    '07' => 'Juli',
    '08' => 'Agustus',
    '09' => 'September',
    '10' => 'Oktober',
    '11' => 'November',
    '12' => 'Desember'
];

$label_periode = $nama_bulan[$bulan_ini] . " " . $tahun_ini;

$id_user = $_SESSION['users_id'] ?? 0;
$nama_bendahara = "Administrator";

if ($id_user > 0) {
    $q_user = $konek->query("SELECT nama_lengkap FROM users WHERE id='$id_user'");
    if ($q_user && $q_user->num_rows > 0) {
        $nama_bendahara = $q_user->fetch_assoc()['nama_lengkap'];
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Keuangan Masjid Al-Ikhlas</title>

    <style>
        @media print {
            @page {
                size: A4;
                margin: 2cm;
            }

            body {
                margin: 0;
            }
        }

        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 12pt;
            color: #000;
        }

        /* KOP */
        .table-kop {
            width: 100%;
            border-bottom: 4px double #000;
            margin-bottom: 20px;
        }

        .table-kop td {
            border: none;
            vertical-align: middle;
        }

        .logo {
            width: 100px;
        }

        /* TABEL */
        .table-laporan {
            width: 100%;
            border-collapse: collapse;
        }

        .table-laporan th,
        .table-laporan td {
            border: 1px solid #000;
            padding: 8px;
        }

        .table-laporan thead {
            background: #e9ecef;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }
    </style>
</head>

<body>

    <!-- KOP SURAT -->
    <table class="table-kop">
        <tr>
            <td>
                <h2 style="margin:0;font-size:24pt;">MASJID AL-IKHLAS</h2>
                <p style="margin:5px 0 0;">Jl. MT. Haryono, Desa Karangsentul, Padamara</p>
                <p style="margin:0;font-size:11pt;font-style:italic;">
                    Telp: 0812-3456-7890 | Email: dkm@alikhlas.com
                </p>
            </td>
            <td style="text-align: right;">
                <img src="assets/img/Masjid logo.jpeg" class="logo">
            </td>
        </tr>
    </table>

    <!-- JUDUL -->
    <div class="text-center">
        <h3 style="text-decoration:underline;margin-bottom:5px;">
            LAPORAN KEUANGAN KAS
        </h3>
        <p>Periode: <?= $label_periode ?></p>
    </div>

    <!-- TABEL DATA -->
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

            $q = $konek->query("
    SELECT t.*, s.nama_sub_kategori, s.jenis
    FROM transaksi t
    LEFT JOIN sub_kategori s ON t.sub_kategori_id = s.id
    WHERE MONTH(tanggal)='$bulan_ini' AND YEAR(tanggal)='$tahun_ini'
    ORDER BY tanggal ASC
");

            if ($q->num_rows > 0) {
                while ($d = $q->fetch_assoc()) {
                    $masuk = $keluar = 0;

                    if ($d['jenis'] == 'masuk') {
                        $masuk = $d['jumlah'];
                        $total_masuk += $masuk;
                    } else {
                        $keluar = $d['jumlah'];
                        $total_keluar += $keluar;
                    }
            ?>
                    <tr>
                        <td class="text-center"><?= $no++ ?></td>
                        <td class="text-center"><?= date('d/m/Y', strtotime($d['tanggal'])) ?></td>
                        <td>
                            <strong><?= $d['nama_sub_kategori'] ?? '-' ?></strong><br>
                            <span style="font-size:10pt;font-style:italic;">
                                <?= $d['keterangan'] ?>
                            </span>
                        </td>
                        <td class="text-right"><?= $masuk ? number_format($masuk, 0, ',', '.') : '-' ?></td>
                        <td class="text-right"><?= $keluar ? number_format($keluar, 0, ',', '.') : '-' ?></td>
                    </tr>
                <?php }
            } else { ?>
                <tr>
                    <td colspan="5" class="text-center">Tidak ada data transaksi</td>
                </tr>
            <?php } ?>
        </tbody>

        <tfoot>
            <tr style="font-weight:bold;">
                <td colspan="3" class="text-center">TOTAL</td>
                <td class="text-right">Rp <?= number_format($total_masuk, 0, ',', '.') ?></td>
                <td class="text-right">Rp <?= number_format($total_keluar, 0, ',', '.') ?></td>
            </tr>
            <tr style="font-weight:bold;background:#343a40;color:white;">
                <td colspan="3" class="text-center">SALDO AKHIR</td>
                <td colspan="2" class="text-center" style="font-size:14pt;">
                    Rp <?= number_format($total_masuk - $total_keluar, 0, ',', '.') ?>
                </td>
            </tr>
        </tfoot>
    </table>

    <!-- TTD -->
    <div style="margin-top:60px;">
        <table width="100%">
            <tr>
                <td width="70%"></td>
                <td width="30%" class="text-center">
                    <p>
                        Purbalingga, <?= date('d F Y') ?><br>
                        Bendahara Masjid
                    </p>
                    <br><br><br>
                    <p style="font-weight:bold;text-decoration:underline;">
                        <?= strtoupper($nama_bendahara) ?>
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