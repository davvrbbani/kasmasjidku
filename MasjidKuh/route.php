<?php
$p = $_GET['p'] ?? '';

switch ($p) {
    case 'LP':
        require_once "Laporan/laporan_pengeluaran.php";
    break;
    case 'TM':
        include "Tabungan/tabungan.php";
    break;
    case 'add_tm':
        require_once "Tabungan/add_tabungan.php";
        break;
    case 'edit_tm':
        require_once "Tabungan/edit_tabungan.php";
        break;
    case 'TS':
        require_once "Transaksi/transaksi.php";
    break;
    case 'add_tr':
        require_once "Transaksi/tambah_transaksi.php";
        break;
    default:
    require_once "dashboard.php";
    break;
}
?>