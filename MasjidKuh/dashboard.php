<?php

include "../config.php"; 

$total_masuk  = 0;
$total_keluar = 0;
$saldo_akhir  = 0;


$q_transaksi = $konek->query("SELECT * FROM transaksi");

while ($t = mysqli_fetch_array($q_transaksi)) {

    $id_sub = $t['sub_kategori_id'];
    $jumlah = $t['jumlah'];

    $q_cek_jenis = $konek->query("SELECT jenis FROM sub_kategori WHERE id='$id_sub'"); 
    $d_jenis = mysqli_fetch_array($q_cek_jenis);


    if ($d_jenis['jenis'] == 'masuk') {
        $total_masuk += $jumlah;
    } else {
        $total_keluar += $jumlah; 
    }
}

$saldo_akhir = $total_masuk - $total_keluar;

$q_tab = $konek->query("SELECT * FROM tabungan"); 
$saldo_tabungan = 0;
while($tb = mysqli_fetch_array($q_tab)){
    if($tb['jenis'] == 'setor'){
        $saldo_tabungan += $tb['jumlah'];
    } else {
        $saldo_tabungan -= $tb['jumlah'];
    }
}

?>

<main class="app-main"> <div class="app-content-header">
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
            <div class="card-header">Saldo Tabungan</div>
            <div class="card-body">
              <h4 class="card-title fw-bold">Rp <?= number_format($saldo_tabungan, 0, ',', '.') ?></h4>
              <p class="card-text"><small>Aset di Rekening/Bank</small></p>
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
        labels: ['Pemasukan', 'Pengeluaran', 'Saldo Akhir'], 
        datasets: [{
          label: 'Jumlah (Rupiah)',
          data: [
            <?= $total_masuk ?>, 
            <?= $total_keluar ?>, 
            <?= $saldo_akhir ?>
          ],
          backgroundColor: [
            'rgba(25, 135, 84, 0.7)', 
            'rgba(220, 53, 69, 0.7)',  
            'rgba(13, 110, 253, 0.7)',
          ],
          borderColor: [
            'rgba(25, 135, 84, 1)',
            'rgba(220, 53, 69, 1)',
            'rgba(13, 110, 253, 1)'
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