<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width='device-width', initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="assets\css\adminlte.css">
<style>
        .hero-section {
            background-color: #198754; /* Warna Hijau Bootstrap */
            color: white;
            padding: 20px 0;
            margin-bottom: 30px;
            border-bottom-left-radius: 20px;
            border-bottom-right-radius: 20px;
        }
        .card-saldo {
            transition: transform 0.2s;
        }
        .card-saldo:hover {
            transform: translateY(-5px);
        }
    </style>
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-success shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">
                <i class="bi bi-building me-2"></i> MASJID AL-IKHLAS
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a href="login.php" class="btn btn-outline-light btn-sm px-4 rounded-pill">
                            <i class="bi bi-box-arrow-in-right me-1"></i> Login Admin
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <section class="hero-section text-center">
        <div class="container">
            <h2 class="fw-bold">Laporan Keuangan KasMasjidKami</h2>
            <p class="lead mb-4">Update Terakhir: Senin, 25 Oktober 2025</p>
            
            <div class="row justify-content-center g-3">
                <div class="col-md-3 col-10">
                    <div class="card text-success fw-bold shadow-sm card-saldo">
                        <div class="card-body">
                            <div class="small text-muted text-uppercase">Total Pemasukan</div>
                            <div class="fs-4">Rp 45.000.000</div>
                            <i class="bi bi-arrow-down-circle-fill text-success fs-1 position-absolute top-0 end-0 me-3 mt-3 opacity-25"></i>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-10">
                    <div class="card text-danger fw-bold shadow-sm card-saldo">
                        <div class="card-body">
                            <div class="small text-muted text-uppercase">Total Pengeluaran</div>
                            <div class="fs-4">Rp 12.500.000</div>
                            <i class="bi bi-arrow-up-circle-fill text-danger fs-1 position-absolute top-0 end-0 me-3 mt-3 opacity-25"></i>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-10">
                    <div class="card text-white bg-primary fw-bold shadow card-saldo">
                        <div class="card-body">
                            <div class="small text-white-50 text-uppercase">Saldo Kas Saat Ini</div>
                            <div class="fs-3">Rp 32.500.000</div>
                            <i class="bi bi-wallet2 fs-1 position-absolute top-0 end-0 me-3 mt-3 opacity-25"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="container mb-5">
        <div class="row">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold text-success"><i class="bi bi-journal-text me-2"></i>Riwayat Transaksi</h5>
                        <a href="#" class="btn btn-sm btn-secondary"><i class="bi bi-download me-1"></i> Download PDF</a>
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
                                    <tr>
                                        <td>25 Okt 2025</td>
                                        <td><span class="badge bg-secondary">Operasional</span></td>
                                        <td>Pembayaran Listrik Masjid</td>
                                        <td class="text-end">-</td>
                                        <td class="text-end text-danger">Rp 500.000</td>
                                    </tr>
                                    <tr>
                                        <td>24 Okt 2025</td>
                                        <td><span class="badge bg-success">Infaq/Sedekah</span></td>
                                        <td>Kotak Amal Jumat</td>
                                        <td class="text-end text-success">Rp 2.500.000</td>
                                        <td class="text-end">-</td>
                                    </tr>
                                    <tr>
                                        <td>22 Okt 2025</td>
                                        <td><span class="badge bg-secondary">Pembangunan</span></td>
                                        <td>Beli Semen 10 Sak</td>
                                        <td class="text-end">-</td>
                                        <td class="text-end text-danger">Rp 650.000</td>
                                    </tr>
                                    <tr>
                                        <td>20 Okt 2025</td>
                                        <td><span class="badge bg-success">Wakaf</span></td>
                                        <td>Hamba Allah (Untuk Karpet)</td>
                                        <td class="text-end text-success">Rp 5.000.000</td>
                                        <td class="text-end">-</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer bg-white text-center">
                        <small class="text-muted">Menampilkan 10 transaksi terakhir</small>
                    </div>
                </div>
            </div>
            </div>
<div class="row g-4 mb-4">
    
    <div class="col-lg-8">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-warning text-dark fw-bold">
                <i class="bi bi-bar-chart-line me-2"></i> Grafik Keuangan
            </div>
            <div class="card-body">
                <canvas id="myChart" style="max-height: 400px;"></canvas>
            </div>
        </div>
    </div>


    <div class="col-lg-4">
        
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-warning text-dark fw-bold">
                <i class="bi bi-info-circle me-2"></i> Info Masjid
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Jadwal Kajian
                        <span class="badge bg-primary rounded-pill">Ahad Subuh</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Jumat Depan
                        <span class="badge bg-primary rounded-pill">Ust. Fulan</span>
                    </li>
                    <li class="list-group-item">
                        <strong>Rencana Renovasi:</strong><br>
                        Pengecatan ulang kubah mulai 1 Nov.
                    </li>
                </ul>
            </div>
        </div>
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white fw-bold">
                        <i class="bi bi-pie-chart me-2"></i> Persentase Anggaran
                    </div>
                    <div class="card-body">
                        <p class="small text-muted mb-1">Penggunaan Dana Bulan Ini</p>
                        <div class="progress mb-3" style="height: 25px;">
                            <div class="progress-bar bg-danger" role="progressbar" style="width: 35%" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100">35% Terpakai</div>
                        </div>

                        <p class="small text-muted mb-1">Target Pemasukan Renovasi</p>
                        <div class="progress mb-3" style="height: 25px;">
                            <div class="progress-bar bg-success" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">75% Terkumpul</div>
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
      labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
      datasets: [{
        label: '# of Votes',
        data: [12, 19, 3, 5, 2, 3],
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
</script>
 
    <footer class="bg-dark text-white text-center py-3 mt-auto">
        <div class="container">
            <small>&copy; 2025 Masjid Al-Ikhlas. Dibuat untuk Transparansi Umat.</small>
        </div>
    </footer>

<script src="assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>