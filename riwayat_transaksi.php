<?php
require_once 'config.php'; 
function format_rupiah($angka){
    return "Rp".number_format($angka, 0, ",", ".");
}

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;
$limit = 25; 
$offset = ($page - 1) * $limit;

$query_transaksi = mysqli_query($konek, "SELECT * FROM transaksi LIMIT $limit OFFSET $offset");
$query_total = mysqli_query($konek, "SELECT COUNT(*) as total FROM transaksi");
$data_total = mysqli_fetch_array($query_total);

$total_transaksi = $data_total['total'];
$total_pages = ceil($total_transaksi/$limit);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi Masjid</title>
    <link rel="stylesheet" href="assets/css/adminlte.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<body class="bg-light">
<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6"><h3 class="mb-0"><i class="bi bi-clock-history me-2">Semua Aktivitas Transaksi</i></h3>
            </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Transaksi Log</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Menampilkan <?php echo mysqli_num_rows($query_transaksi); ?> dari <?php echo $total_transaksi; ?> Total Transaksi</h3>
                        </div>
                        
                        <div class="card-body p-0">
                            <table class="table table-striped table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 20%;">Tanggal</th>
                                        <th style="width: 50%;">Kategori</th>
                                        <th style="width: 30%;">Masuk</th>
                                        <th style="width: 30%;">Keluar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if(mysqli_num_rows($query_transaksi) == 0){
                                        echo "<tr><td colspan='4' class='text-center'>Tidak Ada Data Transaksi</td></tr>";
                                    }
                                    while($row = mysqli_fetch_array($query_transaksi)){
                                    $id_kat = $row['kategori_id'];
                                    $q_kat = mysqli_query($konek, "SELECT * FROM sub_kategori WHERE id='$id_kat'");
                                    $d_kat = mysqli_fetch_array($q_kat);
                                    ?>

                                    <tr>
                                        <td><?php echo date('d-m-Y', strtotime($row['tanggal']));?></td>
                                        <td><?php echo $d_kat['nama_kategori'];?></td>
                                        <td>
                                        <?php 
                                        if ($d_kat['jenis'] == 'masuk'){
                                            echo format_rupiah($row['jumlah']);
                                        } else {
                                            echo "-";
                                        }
                                        ?></td>
                                        <td><?php if($d_kat['jenis'] == 'keluar'){
                                            echo format_rupiah($row['jumlah']);
                                        } else {
                                            echo "-";
                                        }
                                        ?></td>
                                    </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>

                        <?php if ($total_pages > 1): ?>
                        <div class="card-footer">
                            <nav>
                                <ul class="pagination justify-content-center mb-0">
                                    <li class="page-item <?php echo ($page <= 1) ? 'disabled' : ''; ?>">
                                        <a class="page-link" href="?p=activity&page=<?php echo $page - 1; ?>">Previous</a>
                                    </li>

                                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                        <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                                            <a class="page-link" href="?p=activity&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                        </li>
                                    <?php endfor; ?>

                                    <li class="page-item <?php echo ($page >= $total_pages) ? 'disabled' : ''; ?>">
                                        <a class="page-link" href="?p=activity&page=<?php echo $page + 1; ?>">Next</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                        <?php endif; ?>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
</body>
</head>
