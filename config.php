<?php
$konek = new mysqli("localhost", "root", "", "db_kas_masjid");

if ($konek->connect_error) {
    die("Koneksi gagal: " . $konek->connect_error);
}
?>