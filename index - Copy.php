<?php include 'koneksi.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard Modern</title>

  <!-- AdminLTE + Bootstrap -->
  <link rel="stylesheet" href="assets/adminlte.min.css">

  <!-- Google Font Modern -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap">

  <style>
      body {
          font-family: 'Inter', sans-serif;
          background: linear-gradient(135deg, #e8f5e9, #d0f0d4);
          min-height: 100vh;
          padding: 20px;
      }

      .modern-card {
          border-radius: 20px;
          padding: 25px;
          background: rgba(255, 255, 255, 0.75);
          backdrop-filter: blur(10px);
          box-shadow: 0 8px 18px rgba(0,0,0,0.08);
          transition: 0.3s ease;
      }

      .modern-card:hover {
          transform: translateY(-5px);
          box-shadow: 0 12px 25px rgba(0,0,0,0.12);
      }

      .card-title {
          font-size: 18px;
          font-weight: 600;
          margin-bottom: 8px;
      }

      .card-total {
          font-size: 34px;
          font-weight: 700;
          color: #006241;
      }

      /* Chart container */
      #chartContainer {
          border-radius: 20px;
          padding: 25px;
          background: rgba(255,255,255,0.85);
          box-shadow: 0 10px 20px rgba(0,0,0,0.08);
      }
  </style>
</head>

<body>

<div class="container">

  <!-- ROW CARDS -->
  <div class="row">

    <!-- PEMASUKAN -->
    <div class="col-md-4 mb-4">
      <div class="modern-card">
        <div class="card-title">Total Pemasukan</div>
        <div class="card-total">
          Rp <?= number_format($total_masuk,0,',','.') ?>
        </div>
      </div>
    </div>

    <!-- PENGELUARAN -->
    <div class="col-md-4 mb-4">
      <div class="modern-card">
        <div class="card-title">Total Pengeluaran</div>
        <div class="card-total" style="color:#c62828">
          Rp <?= number_format($total_keluar,0,',','.') ?>
        </div>
      </div>
    </div>

    <!-- DANA PENGEMBANGAN -->
    <div class="col-md-4 mb-4">
      <div class="modern-card">
        <div class="card-title">Dana Pengembangan Masjid</div>
        <div class="card-total" style="color:#0077b6">
          Rp <?= number_format($pengembangan_masjid,0,',','.') ?>
        </div>
      </div>
    </div>

  </div>


  <!-- CHART -->
  <div id="chartContainer" class="mt-4">
      <h5 style="font-weight:600; color:#004d40; margin-bottom:15px;">Grafik Keuangan Masjid</h5>
      <canvas id="myChart" height="110"></canvas>
  </div>

</div>


<!-- CHART JS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const ctx = document.getElementById('myChart');

new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ['Pemasukan', 'Pengeluaran', 'Pengembangan Masjid'],
      datasets: [{
        label: 'Total Rupiah',
        data: [
            <?= $total_masuk ?>,
            <?= $total_keluar ?>,
            <?= $pengembangan_masjid ?>
        ],
        backgroundColor: [
          '#2e7d32',
          '#c62828',
          '#0277bd'
        ],
        borderWidth: 2,
        borderRadius: 8
      }]
    },
    options: {
      responsive: true,
      scales: {
        y: { beginAtZero: true }
      }
    }
});
</script>

</body>
</html>
