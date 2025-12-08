<?php
$p = $_GET['p'] ?? '';

switch ($p) {
    case 'LP':
        require_once "Laporan/laporan_pengeluaran.php";
    break;
    case 'LPC':
        require_once "Laporan/laporan_print.php";
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
    case 'hapus_tm':
        require_once "Tabungan/hapus_tabungan.php";
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
<<<<<<< HEAD
    case 'add_kt':
        require_once "Kategori/add_kategori.php";
        break;
    case 'edit_kt':
        require_once "Kategori/edit_kategori.php";
        break;
    case 'hps_kt':
        require_once "Kategori/hapus_kategori.php";
=======
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
>>>>>>> 0137569fd8ce35368d157dc8df424e633fcc727d
    default:
    require_once "dashboard.php";
    break;
}
?>