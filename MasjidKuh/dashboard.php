<?php
include "../config.php";

$bulan_ini = date('m');
$tahun_ini = date('Y');
$nama_bulan = [
    '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April',
    '05' => 'Mei',     '06' => 'Juni',     '07' => 'Juli',  '08' => 'Agustus',
    '09' => 'September','10' => 'Oktober', '11' => 'November','12' => 'Desember'
];
$label_bulan = $nama_bulan[$bulan_ini] . " " . $tahun_ini;



$query_masuk_bln = "SELECT SUM(jumlah) AS total FROM transaksi 
                    WHERE sub_kategori_id IN (SELECT id FROM sub_kategori WHERE jenis = 'masuk')
                    AND MONTH(tanggal) = '$bulan_ini' AND YEAR(tanggal) = '$tahun_ini'";
$d_masuk = mysqli_fetch_assoc($konek->query($query_masuk_bln));
$total_masuk = $d_masuk['total'] ?? 0;

$query_keluar_bln = "SELECT SUM(jumlah) AS total FROM transaksi 
                     WHERE sub_kategori_id IN (SELECT id FROM sub_kategori WHERE jenis = 'keluar')
                     AND MONTH(tanggal) = '$bulan_ini' AND YEAR(tanggal) = '$tahun_ini'";
$d_keluar = mysqli_fetch_assoc($konek->query($query_keluar_bln));
$total_keluar = $d_keluar['total'] ?? 0;

$q_all_masuk = "SELECT SUM(jumlah) AS total FROM transaksi 
                WHERE sub_kategori_id IN (SELECT id FROM sub_kategori WHERE jenis = 'masuk')";
$all_masuk = mysqli_fetch_assoc($konek->query($q_all_masuk))['total'] ?? 0;

$q_all_keluar = "SELECT SUM(jumlah) AS total FROM transaksi 
                 WHERE sub_kategori_id IN (SELECT id FROM sub_kategori WHERE jenis = 'keluar')";
$all_keluar = mysqli_fetch_assoc($konek->query($q_all_keluar))['total'] ?? 0;

$saldo_akhir = $all_masuk - $all_keluar;

if ($saldo_akhir < 0) {
    $saldo_akhir = 0;
}


$query_pengembangan = "SELECT SUM(CASE WHEN jenis = 'Masuk' THEN jumlah ELSE -jumlah END) AS total 
                       FROM transaksi_pengembangan";
$d_pengembangan = mysqli_fetch_assoc($konek->query($query_pengembangan));
$saldo_pengembangan = $d_pengembangan['total'] ?? 0;

?>

<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Dashboard Admin</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="card text-white bg-primary mb-3">
                        <div class="card-header">Saldo Kas Masjid</div>
                        <div class="card-body">
                            <h4 class="card-title fw-bold">Rp <?= number_format($saldo_akhir, 0, ',', '.') ?></h4>
                            <p class="card-text"><small>Total Uang Kas</small></p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="card text-white bg-success mb-3">
                        <div class="card-header">Pemasukan (<?= $label_bulan ?>)</div>
                        <div class="card-body">
                            <h4 class="card-title fw-bold">Rp <?= number_format($total_masuk, 0, ',', '.') ?></h4>
                            <p class="card-text"><small>Total Pemasukkan Bulan Ini</small></p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="card text-white bg-danger mb-3">
                        <div class="card-header">Pengeluaran (<?= $label_bulan ?>)</div>
                        <div class="card-body">
                            <h4 class="card-title fw-bold">Rp <?= number_format($total_keluar, 0, ',', '.') ?></h4>
                            <p class="card-text"><small>Total Pengeluaran Bulan Ini</small></p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="card text-dark bg-warning mb-3">
                        <div class="card-header">Saldo Pengembangan Masjid</div>
                        <div class="card-body">
                            <h4 class="card-title fw-bold">Rp <?= number_format($saldo_pengembangan, 0, ',', '.') ?></h4>
                            <p class="card-text"><small>Total Saldo/Aset</small></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h3 class="card-title">Grafik Keuangan</h3>
                        </div>
                        <div class="card-body">
                            <div class="chart-container" style="position: relative; height: 400px; width: 100%;">
                                <canvas id="myChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const ctx = document.getElementById('myChart');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Pemasukan (Bln Ini)', 'Pengeluaran (Bln Ini)', 'Saldo Akhir (Total)', 'Dana Pembangunan'],
                datasets: [{
                    label: 'Nominal (Rupiah)',
                    data: [
                        <?= $total_masuk ?>,
                        <?= $total_keluar ?>,
                        <?= $saldo_akhir ?>,
                        <?= $saldo_pengembangan ?>,
                    ],
                    backgroundColor: [
                        'rgba(25, 135, 84, 0.7)',  // Hijau
                        'rgba(220, 53, 69, 0.7)',  // Merah
                        'rgba(13, 110, 253, 0.7)', // Biru
                        'rgba(255, 193, 7, 0.7)',  // Kuning
                    ],
                    borderColor: [
                        'rgba(25, 135, 84, 1)',
                        'rgba(220, 53, 69, 1)',
                        'rgba(13, 110, 253, 1)',
                        'rgba(255, 193, 7, 1)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    legend: {
                        display: false 
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(context.parsed.y);
                                }
                                return label;
                            }
                        }
                    }
                }
            }
        });
    </script>

</main>