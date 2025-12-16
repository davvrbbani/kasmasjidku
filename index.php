<?php
require_once "config.php"; 

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
$pengembangan_masjid = $d_pengembangan['total'] ?? 0;

if ($pengembangan_masjid < 0) {
    $pengembangan_masjid = 0;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi Masjid</title>
    <link rel="stylesheet" href="assets/css/adminlte.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #00A86B 0%, #004d32 100%);
            --card-green: linear-gradient(135deg, #059669 0%, #064e3b 100%);
            --card-red: linear-gradient(135deg, #dc2626 0%, #7f1d1d 100%);
            --card-blue: linear-gradient(135deg, #0284c7 0%, #0c4a6e 100%);
            --card-gold: linear-gradient(135deg, #d97706 0%, #78350f 100%);
        }

        body { background-color: #f4f6f9; }

        .hero-section {
            background: url('assets/img/masjidku.jpg');
            background-size: cover;
            background-repeat: no-repeat; 
            background-position: center center; 
            padding: 80px 0 100px 0; 
            margin-bottom: 0;
            border-bottom-left-radius: 30px;
            border-bottom-right-radius: 30px;
            position: relative;
        }

        .hero-section h2, .hero-section p { text-shadow: 0px 2px 4px rgba(0,0,0,0.6); }

        .stats-container { margin-top: -80px; }

        .card-stat {
            border: none;
            border-radius: 15px;
            color: white;
            transition: transform 0.3s ease;
            overflow: hidden;
            position: relative;
        }

        .card-stat:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.2) !important;
        }

        .bg-gradient-green { background: var(--card-green); }
        .bg-gradient-red   { background: var(--card-red); }
        .bg-gradient-blue  { background: var(--card-blue); }
        .bg-gradient-gold  { background: var(--card-gold); }

        .icon-bg {
            position: absolute;
            right: 15px;
            top: 15px;
            font-size: 4rem;
            opacity: 0.15;
            transform: rotate(-15deg);
        }

        .navbar {
            background: linear-gradient(to bottom, rgba(0, 102, 66, 0.95), rgba(5, 64, 42, 0.95)) !important;
            backdrop-filter: blur(5px);
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark shadow-sm fixed-top">
        <div class="container">
        <a class="navbar-brand fw-bold d-flex align-items-center" href="#">
            <img src="assets/img/Masjid logo.jpeg" alt="Logo Masjid" width="40" height="40" class="d-inline-block align-text-top me-2" style="border-radius: 50%">
            MASJID AL-IKHLAS
        </a>
            <div class="ms-auto">
                <a href="login.php" class="btn btn-light btn-sm px-4 rounded-pill fw-bold text-success">
                    <i class="bi bi-box-arrow-in-right me-1"></i> Login Admin
                </a>
            </div>
        </div>
    </nav>

    <section class="hero-section text-center text-white">
        <div class="container pt-4"> <h2 class="fw-bold display-5 mb-2">Laporan Keuangan Masjid</h2>
            <p class="lead opacity-75">Transparansi Dana Umat & Akuntabilitas</p>
        </div>
    </section>

    <div class="container stats-container mb-5">
        <div class="row justify-content-center g-4">
            
            <div class="col-md-3 col-10">
                <div class="card card-stat bg-gradient-green shadow">
                    <div class="card-body p-4">
                        <div class="small text-white-50 text-uppercase fw-bold ls-1">Pemasukan (<?= $label_bulan ?>)</div>
                        <div class="fs-4 fw-bold mt-2">Rp <?= number_format($total_masuk, 0, ',', '.' )?></div>
                        <i class="bi bi-arrow-down-circle-fill icon-bg"></i>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-10">
                <div class="card card-stat bg-gradient-red shadow">
                    <div class="card-body p-4">
                        <div class="small text-white-50 text-uppercase fw-bold ls-1">Pengeluaran (<?= $label_bulan ?>)</div>
                        <div class="fs-4 fw-bold mt-2">Rp <?= number_format($total_keluar, 0, ',', '.' )?></div>
                        <i class="bi bi-arrow-up-circle-fill icon-bg"></i>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-10">
                <div class="card card-stat bg-gradient-blue shadow">
                    <div class="card-body p-4">
                        <div class="small text-white-50 text-uppercase fw-bold ls-1">Saldo Kas Saat Ini</div>
                        <div class="fs-4 fw-bold mt-2">Rp <?= number_format($saldo_akhir, 0, ',', '.' )?></div>
                        <i class="bi bi-wallet2 icon-bg"></i>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-10">
                <div class="card card-stat bg-gradient-gold shadow">
                    <div class="card-body p-4">
                        <div class="small text-white-50 text-uppercase fw-bold ls-1">Dana Pengembangan</div>
                        <div class="fs-4 fw-bold mt-2">Rp <?= number_format($pengembangan_masjid, 0, ',', '.' )?></div>
                        <i class="bi bi-bricks icon-bg"></i>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="container mb-5">
        <div class="row g-4">
            
            <div class="col-lg-8">
                <div class="card shadow-sm border-0 h-100 rounded-3 overflow-hidden">
                    <div class="card-header bg-white py-3 border-bottom">
                        <h5 class="mb-0 fw-bold text-success"><i class="bi bi-journal-text me-2"></i>Riwayat Transaksi Terakhir</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover mb-0 align-middle">
                                <thead class="bg-success text-white">
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Kategori</th>
                                        <th>Keterangan</th>
                                        <th class="text-end">Masuk</th>
                                        <th class="text-end">Keluar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $q_tabel = $konek->query("SELECT * FROM transaksi ORDER BY tanggal DESC LIMIT 10");
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
                                        <td class="small"><?= date('d M Y', strtotime($d['tanggal'])) ?></td>
                                        <td>
                                            <?php if($jenis == 'masuk'){ ?>
                                                <span class="badge rounded-pill bg-success bg-opacity-10 text-success"><?= $nama ?></span>
                                            <?php } else { ?>
                                                <span class="badge rounded-pill bg-danger bg-opacity-10 text-danger"><?= $nama ?></span>
                                            <?php } ?>
                                        </td>
                                        <td class="small text-muted"><?= $d['keterangan'] ?></td>
                                        <td class="text-end fw-bold text-success">
                                            <?php if($jenis == 'masuk') echo "Rp " . number_format($d['jumlah']); else echo "-"; ?>
                                        </td>
                                        <td class="text-end fw-bold text-danger">
                                            <?php if($jenis == 'keluar') echo "Rp " . number_format($d['jumlah']); else echo "-"; ?>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer text-center bg-white border-top">
                        <a href="riwayat_transaksi.php" class="text-decoration-none fw-bold text-success">Lihat Selengkapnya <i class="bi bi-arrow-right"></i></a>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="row g-4">
                    <div class="col-12">
                        <div class="card shadow-sm border-0 rounded-3">
                            <div class="card-header bg-white py-3">
                                <h6 class="mb-0 fw-bold text-dark"><i class="bi bi-pie-chart-fill me-2 text-warning"></i>Statistik Keuangan</h6>
                            </div>
                            <div class="card-body" style="height: 250px;">
                                <canvas id="myChart"></canvas>
                            </div>
                            <div class="card-footer bg-white text-center border-0">
                                <a href = "cetaklaporan.php" class="btn btn-outline-secondary btn-sm rounded-pill">
                                    <i class="bi bi-printer me-1"></i> Cetak Laporan
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="card shadow-sm border-0 rounded-3">
                            <div class="card-header bg-white py-3">
                                <h6 class="mb-0 fw-bold text-dark"><i class="bi bi-bar-chart-fill me-2 text-info"></i>Statistik Pengembangan</h6>
                            </div>
                            <div class="card-body" style="height: 200px;">
                                <canvas id="chartPengembangan"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div> 
    </div>

    <footer class="bg-dark text-white text-center py-4 mt-auto">
        <div class="container">
            <small class="opacity-75">&copy; 2025 Masjid Al-Ikhlas. Dibuat dengan PHP Native.</small>
        </div>
    </footer>

    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
      const ctx = document.getElementById('myChart');
      new Chart(ctx, {
        type: 'bar',
        data: {
          labels: ['Pemasukan', 'Pengeluaran'],
          datasets: [{
            label: 'Total Rupiah (Bulan Ini)', // Label diperjelas agar user tau ini data bulanan
            data: [<?= $total_masuk ?>, <?= $total_keluar ?>],
            backgroundColor: [
              'rgba(25, 135, 84, 0.8)', 
              'rgba(220, 53, 69, 0.8)'  
            ],
            borderColor: [
                '#198754',
                '#dc3545'
            ],
            borderWidth: 1,
            borderRadius: 5
          }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: { beginAtZero: true, grid: { borderDash: [2, 4] } },
                x: { grid: { display: false } }
            }
        }
      });

      const ctx2 = document.getElementById('chartPengembangan');
      new Chart(ctx2, {
        type: 'bar',
        data: {
            labels: ['Dana Pengembangan'],
            datasets: [{
            label: 'Total Terkumpul',
            data: [<?= $pengembangan_masjid ?>],
            backgroundColor: ['rgba(255, 193, 7, 0.8)'], 
            borderColor: ['#ffc107'],
            borderWidth: 1,
            borderRadius: 5,
            barThickness: 50 
        }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: { beginAtZero: true, grid: { borderDash: [2, 4] } },
                x: { grid: { display: false } }
            }
        }
      });
    </script>

</body>
</html>