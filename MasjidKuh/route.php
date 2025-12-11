<?php
$p = $_GET['p'] ?? '';

switch ($p) {
    case 'LP':
        require_once "Laporan/laporan_pengeluaran.php";
    break;
    case 'LPC':
        require_once "Laporan/laporan_print.php";
        break;
    case 'PG':
        include "Pengembangan/pengembangan.php";
    break;
    case 'add_pg':
        require_once "Pengembangan/add_pengembangan.php";
        break;
    case 'edit_pg':
        require_once "Pengembangan/edit_pengembangan.php";
        break;
    case 'hapus_pg':
        require_once "Pengembangan/hapus_pengembangan.php";
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
    case 'add_ktgr':
        require_once "Kategori/add_kategori.php";
        break;
    case 'add_sub':
        require_once "Kategori/add_sub.php";
        break;
    case 'edit_kat':
        require_once "Kategori/edit_kategori.php";
        break;
    case 'hps_kat':
        require_once "Kategori/hps_kategori.php";
        break;
    default:
    require_once "dashboard.php";
    break;
}
?>