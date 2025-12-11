<?php
require_once 'config.php'; 

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;
$limit = 25; 
$offset = ($page - 1) * $limit;

$query_transaksi = $konek->query("SELECT * FROM transaksi ORDER BY tanggal DESC LIMIT $limit OFFSET $offset");

$query_total = $konek->query("SELECT COUNT(*) as total FROM transaksi");
$data_total  = $query_total->fetch_assoc(); 

$total_transaksi = $data_total['total'];
$total_pages     = ceil($total_transaksi / $limit);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi Masjid</title>
    <link rel="stylesheet" href="assets/css/adminlte.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="bg-light">

<main class="app-main">
    
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0"><i class="bi bi-clock-history me-2"></i>Semua Aktivitas Transaksi</h3>
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
                            <h3 class="card-title">
                                Menampilkan <?php echo $query_transaksi->num_rows; ?> dari <?php echo $total_transaksi; ?> Total Transaksi
                            </h3>
                        </div>
                        
                        <div class="card-body p-0">
                            <table class="table table-striped table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 20%;">Tanggal</th>
                                        <th style="width: 50%;">Kategori</th>
                                        <th style="width: 15%;" class="text-end">Masuk</th>
                                        <th style="width: 15%;" class="text-end">Keluar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if($query_transaksi->num_rows == 0){
                                        echo "<tr><td colspan='4' class='text-center py-4 text-muted'>Tidak Ada Data Transaksi</td></tr>";
                                    }

                                    foreach ($query_transaksi as $row) {
                                        
                                        $id_kat = $row['sub_kategori_id'];
                                        
                                        $d_kat = $konek->query("SELECT * FROM sub_kategori WHERE id='$id_kat'")->fetch_assoc();

                                        $nama_kat = $d_kat['nama_sub_kategori'] ?? '-';
                                        $jenis    = $d_kat['jenis'] ?? '';
                                    ?>
                                    <tr>
                                        <td><?php echo date('d-m-Y', strtotime($row['tanggal'])); ?></td>
                                        
                                        <td><?php echo $nama_kat; ?></td>
                                        
                                        <td class="text-end text-success">
                                            <?php 
                                            if ($jenis == 'masuk'){
                                                echo "Rp " . number_format($row['jumlah'], 0, ',', '.');
                                            } else {
                                                echo "-";
                                            }
                                            ?>
                                        </td>
                                        
                                        <td class="text-end text-danger">
                                            <?php 
                                            if($jenis == 'keluar'){
                                                echo "Rp " . number_format($row['jumlah'], 0, ',', '.');
                                            } else {
                                                echo "-";
                                            }
                                            ?>
                                        </td>
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

<script src="assets/js/bootstrap.bundle.min.js"></script>

</body>
</html>