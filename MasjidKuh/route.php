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
        require_once "Program Pengembangan/p-pengembangan.php";
        break;
    case 'add_pg':
        require_once "Program Pengembangan/add_p-pengembangan.php";
        break;
    case 'edit_pg':
        require_once "Program Pengembangan/edit_p-pengembangan.php";
        break;
    case 'hps_pg':
        require_once "Program Pengembangan/hapus_p-pengembangan.php";
        break;
    case 'TP':
        require_once "Transaksi Pengembangan/t-pengembangan.php";
        break;
    case 'add_tp':
        require_once "Transaksi Pengembangan/add_t-pengembangan.php";
        break;
    case 'edit_tp':
        require_once "Transaksi Pengembangan/edit_t-pengembangan.php";
        break;
    case 'hps_tp':
        require_once "Transaksi Pengembangan/hapus_t-pengembangan.php";
        break;
    case 'prtp':
        require_once "Transaksi Pengembangan/print_t-pengembangan.php";
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
    case 'add_kat':
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
    case 'DN':
        require_once "Donatur/donatur.php";
        break;
    case 'add_dn':
        require_once "Donatur/add_donatur.php";
        break;
    case 'edit_dn':
        require_once "Donatur/edit_donatur.php";
        break;
    case 'hps_dn':
        require_once "Donatur/hapus_donatur.php";
        break;
    default:
    require_once "dashboard.php";
        break;
}
?>