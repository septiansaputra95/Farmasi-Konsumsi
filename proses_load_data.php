<?php
// Include koneksi.php atau file yang mengatur koneksi ke database
include 'koneksi.php';

// Panggil fungsi untuk mendapatkan data
$data = getDataFromDatabase($pdo);

// Kirim data sebagai respons JSON
echo json_encode($data);

// Fungsi untuk mendapatkan data dari database
function getDataFromDatabase($pdo) {
    $query = "SELECT data_id, nama_petugas, tanggal FROM pharmacy_consumption_header ORDER BY tanggal DESC";
    $result = $pdo->query($query);

    return $result->fetchAll(PDO::FETCH_ASSOC);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data_id = $_POST['data_id'];

    // Panggil fungsi generateDataFromDatabase
    //$result = generateDataFromDatabase($pdo, $data_id);

    // Mengembalikan hasil generate sebagai respons JSON
    echo json_encode($result);
}

// Fungsi untuk generate data dari database
function generateDataFromDatabase($pdo, $data_id) {
    // Lakukan proses generate data di sini
    // Gantilah dengan logika sesuai kebutuhan Anda
     // Contoh: mengembalikan array asosiatif
    return array(
        'data_id' => $data_id,
        'message' => "Data dengan ID $data_id berhasil di-generate!"
    );
}
?>
