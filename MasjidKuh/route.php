<?php
$p = $_GET['p'] ?? '';

switch ($p) {
    case 'LP':
        require_once "Laporan/laporan_pengeluaran.php";
    break;
    case 'TM':
        include "Tabungan/tabungan.php";
    break;
    case 'TS':
        require_once "Transaksi/transaksi.php";
    break;
    default:
    require_once "dashboard.php";
    break;

}