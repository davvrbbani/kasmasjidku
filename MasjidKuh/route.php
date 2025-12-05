<?php
$p = $_GET['p'] ?? '';

switch ($p) {
    case 'LP':
    require_once "Laporan/laporan_pengeluaran.php";
    break;
    case 'TM':
    require_once "Tabungan/tabungan.php";
    break;
    default:
    require_once "dashboard.php";
    break;

}