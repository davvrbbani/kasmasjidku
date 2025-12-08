<?php
// --- BAGIAN LOGIC PHP (Tetap sama) ---
require_once "config.php"; // Pastikan path ini benar!

$total_masuk = 0;
$total_keluar = 0;

// Hitung Saldo Total
$qsaldo = $konek->query("SELECT * FROM transaksi");
while ($row = mysqli_fetch_array($qsaldo)){
    $idkat = $row['sub_kategori_id'];
    $qkat = $konek->query("SELECT * FROM sub_kategori WHERE id='$idkat'");
    $dkat = mysqli_fetch_array($qkat);

    if ($dkat['jenis'] == 'masuk'){
        $total_masuk += $row['jumlah'];
    } else {
        $total_keluar += $row['jumlah'];
    }
}
$saldo_akhir = $total_masuk - $total_keluar;
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
        .hero-section {
            background-color: #198754;
            color: white;
            padding: 30px 0;
            margin-bottom: 30px;
            border-bottom-left-radius: 20px;
            border-bottom-right-radius: 20px;
        }
    </style>
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-success shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">
                <i class="bi bi-building me-2"></i> MASJID AL-IKHLAS
            </a>
            <div class="ms-auto">
                <a href="login.php" class="btn btn-outline-light btn-sm px-4 rounded-pill">
                    <i class="bi bi-box-arrow-in-right me-1"></i> Login Admin
                </a>
            </div>
        </div>
    </nav>

    <section class="hero-section text-center">
        <div class="container">
            <h2 class="fw-bold">Laporan Keuangan Masjid</h2>
            <p class="lead mb-4">Transparansi Dana Umat</p>
            
            <div class="row justify-content-center g-3">
                <div class="col-md-4 col-10">
                    <div class="card text-success fw-bold shadow-sm">
                        <div class="card-body">
                            <div class="small text-muted text-uppercase">Total Pemasukan</div>
                            <div class="fs-4">Rp <?= number_format($total_masuk, 0, ',', '.' )?></div>
                            <i class="bi bi-arrow-down-circle-fill text-success fs-1 position-absolute top-0 end-0 me-3 mt-3 opacity-25"></i>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 col-10">
                    <div class="card text-danger fw-bold shadow-sm">
                        <div class="card-body">
                            <div class="small text-muted text-uppercase">Total Pengeluaran</div>
                            <div class="fs-4">Rp <?= number_format($total_keluar, 0, ',', '.' )?></div>
                            <i class="bi bi-arrow-up-circle-fill text-danger fs-1 position-absolute top-0 end-0 me-3 mt-3 opacity-25"></i>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 col-10">
                    <div class="card text-white bg-primary fw-bold shadow">
                        <div class="card-body">
                            <div class="small text-white-50 text-uppercase">Saldo Kas Saat Ini</div>
                            <div class="fs-3">Rp <?= number_format($saldo_akhir, 0, ',', '.' )?></div>
                            <i class="bi bi-wallet2 fs-1 position-absolute top-0 end-0 me-3 mt-3 opacity-25"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="container mb-5">
        <div class="row g-4">
            
            <div class="col-lg-8">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold text-success"><i class="bi bi-journal-text me-2"></i>Riwayat Transaksi Terakhir</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover mb-0 align-middle">
                                <thead class="table-success">
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
                                    // Query 10 Data Terakhir
                                    $q_tabel = $konek->query("SELECT * FROM transaksi ORDER BY tanggal DESC LIMIT 10");
                                    
                                    while($d = mysqli_fetch_array($q_tabel)){
                                        $id = $d['sub_kategori_id'];
                                        $q_kat = $konek->query("SELECT * FROM sub_kategori WHERE id='$id'");
                                        $kat   = mysqli_fetch_array($q_kat);
                                        $nama  = $kat['nama_sub_kategori']; 
                                        $jenis = $kat['jenis'];
                                    ?>
                                    <tr>
                                        <td><?= date('d M Y', strtotime($d['tanggal'])) ?></td>
                                        <td>
                                            <?php if($jenis == 'masuk'){ ?>
                                                <span class="badge bg-success"><?= $nama ?></span>
                                            <?php } else { ?>
                                                <span class="badge bg-danger"><?= $nama ?></span>
                                            <?php } ?>
                                        </td>
                                        <td><?= $d['keterangan'] ?></td>
                                        
                                        <td class="text-end text-success">
                                            <?php if($jenis == 'masuk') echo "Rp " . number_format($d['jumlah']); else echo "-"; ?>
                                        </td>
                                        
                                        <td class="text-end text-danger">
                                            <?php if($jenis == 'keluar') echo "Rp " . number_format($d['jumlah']); else echo "-"; ?>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                        <div class="card-footer text-center bg-light">
                            <small class="d-block text-muted mb2">Hanya menampilkan 10 aktivitas terakhir</small>
                            ><a href="riwayat_transaksi.php">lihat selengkapnya</a><
                        </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-warning text-dark fw-bold">
                        <i class="bi bi-pie-chart-fill me-2"></i> Statistik Keuangan
                    </div>
                    <div class="card-body d-flex auto">
                        <canvas id="myChart"></canvas>
                    </div>
                </div>
            </div>

        </div> </div> <footer class="bg-dark text-white text-center py-3 mt-auto">
        <div class="container">
            <small>&copy; 2025 Masjid Al-Ikhlas. Dibuat dengan PHP Native.</small>
        </div>
    </footer>

    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
      const ctx = document.getElementById('myChart');

      new Chart(ctx, {
        type: 'bar', // Saya ganti ke Bar (Batang) biar lebih jelas dibanding Line
        data: {
          labels: ['Pemasukan', 'Pengeluaran'],
          datasets: [{
            label: 'Total Rupiah',
            data: [<?= $total_masuk ?>, <?= $total_keluar ?>],
            backgroundColor: [
              '#198754', // Hijau
              '#dc3545'  // Merah
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
            }
        }
      });
    </script>

</body>
</html>