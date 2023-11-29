<?php

$host = '10.33.111.2';
$port = '5432'; // Port default PostgreSQL
$dbname = 'data_hinai_pekalongan'; // Ganti dengan nama database yang sesuai
$username = 'postgres';
$password = 'p0stgr3s#33';

try {
    $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$dbname;user=$username;password=$password");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Koneksi berhasil!";
} catch (PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}

?>
