<?php
include "../config.php"; 

// Inisialisasi Variabel
$total_masuk  = 0;
$total_keluar = 0;
$saldo_akhir  = 0;

$q_transaksi = $konek->query("SELECT * FROM transaksi");

foreach ($q_transaksi as $t) {

    $id_sub = $t['sub_kategori_id'];
    $jumlah = $t['jumlah'];

    $d_jenis = $konek->query("SELECT jenis FROM sub_kategori WHERE id='$id_sub'")->fetch_assoc();

    $jenis_transaksi = $d_jenis['jenis'] ?? '';

    if ($jenis_transaksi == 'masuk') {
        $total_masuk += $jumlah;
    } else {
        $total_keluar += $jumlah; 
    }
}

$saldo_akhir = $total_masuk - $total_keluar;

$q_tab = $konek->query("SELECT * FROM pengembangan"); 
$saldo_pengembangan = 0;

foreach ($q_tab as $tb) {
    if($tb['jenis'] == 'setor'){
        $saldo_pengembangan += $tb['jumlah'];
    } else {
        $saldo_pengembangan -= $tb['jumlah'];
    }
}
?>

<main class="app-main"> 
  <div class="app-content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">Dashboard Admin</h3></div>
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
              <p class="card-text"><small>Total Uang Tunai Saat Ini</small></p>
            </div>
          </div>
        </div>

        <div class="col-lg-3 col-6">
          <div class="card text-white bg-success mb-3">
            <div class="card-header">Total Pemasukan</div>
            <div class="card-body">
              <h4 class="card-title fw-bold">Rp <?= number_format($total_masuk, 0, ',', '.') ?></h4>
              <p class="card-text"><small>Akumulasi Uang Masuk</small></p>
            </div>
          </div>
        </div>

        <div class="col-lg-3 col-6">
          <div class="card text-white bg-danger mb-3">
            <div class="card-header">Total Pengeluaran</div>
            <div class="card-body">
              <h4 class="card-title fw-bold">Rp <?= number_format($total_keluar, 0, ',', '.') ?></h4>
              <p class="card-text"><small>Akumulasi Uang Keluar</small></p>
            </div>
          </div>
        </div>

        <div class="col-lg-3 col-6">
          <div class="card text-dark bg-warning mb-3">
            <div class="card-header">Saldo pembangunan masjid</div>
            <div class="card-body">
              <h4 class="card-title fw-bold">Rp <?= number_format($saldo_pengembangan, 0, ',', '.') ?></h4>
              <p class="card-text"><small>Aset di Rekening</small></p>
            </div>
          </div>
        </div>

      </div>

      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Grafik Keuangan</h3>
            </div>
            <div class="card-body">
              <canvas id="myChart" style="min-height: 300px; height: 300px; max-height: 300px; max-width: 100%;"></canvas>
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
        labels: ['Pemasukan', 'Pengeluaran', 'Saldo Akhir','Saldo pembangunan masjid'], 
        datasets: [{
          label: 'Jumlah (Rupiah)',
          data: [
            <?= $total_masuk ?>, 
            <?= $total_keluar ?>, 
            <?= $saldo_akhir ?>,
            <?= $saldo_pengembangan ?>,
          ],
          backgroundColor: [
            'rgba(25, 135, 84, 0.7)', 
            'rgba(220, 53, 69, 0.7)',  
            'rgba(13, 110, 253, 0.7)',
            'rgba(255, 193, 7, 0.7)',
          ],
          borderColor: [
            'rgba(25, 135, 84, 1)',
            'rgba(220, 53, 69, 1)',
            'rgba(13, 110, 253, 1)',
            'rgba(255, 193, 7, 0.7)',
          ],
          borderWidth: 1
        }]
      },
      options: {
        responsive: true,
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    });
  </script>

</main>