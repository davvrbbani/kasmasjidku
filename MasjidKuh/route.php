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
        require_once "Transaksi/add_transaksi.php";
        break;
    case 'edit_tr':
        require_once "Transaksi/edit_transaksi.php";
        break;
    case 'hps_tr':
        require_once "Transaksi/hapus_transaksi.php";
        break;
    case 'KT':
        require_once "Kategori/kategori.php";
        break;
    default:
    require_once "dashboard.php";
    break;
}
?>