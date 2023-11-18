<?php
// Include koneksi.php, header.php, dan footer.php
include 'koneksi.php';
include 'header.php';
?>

<div class="container mt-5">
    <h2>Data Konsumsi</h2>
    <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#modalFormKonsumsi" id="tambah-data">Tambah Data</button>
    <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#modalKeteranganFarmasi" id="tambah">Tambah ce</button>
    <table class="table">
        <thead>
            <tr>
                <th>Data ID</th>
                <th>Nama Petugas</th>
                <th>Tanggal Input</th>
                <th>Aksi </th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Ambil data dari tabel pharmacy_consumption_header
            $query = "SELECT data_id, nama_petugas, tanggal FROM pharmacy_consumption_header";
            $result = $pdo->query($query);

            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>{$row['data_id']}</td>";
                echo "<td>{$row['nama_petugas']}</td>";
                echo "<td>{$row['tanggal']}</td>";
                echo "<td><button id='data-konsumsi' name='data_konsumsi' class='btn btn-danger' value='{$row['data_id']}'>Print</button></td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<?php
// Include footer.php
include 'footer.php';
?>

<?php
// Include modal-form-konsumsi.php
include '_modal-form-konsumsi.php';
include '_modal-jumlah-resep.php';

?>

<!-- JavaScript untuk menampilkan modal secara otomatis -->
<script>
    $(document).ready(function () {
        // $('#modalKeteranganFarmasi').modal('show');
        
        // $("#tambah-data").click(function(){
        //     $('#modalKeteranganFarmasi').modal('show');
        // });

        // $('#tutupKeterangan').click(function () {
        //     $('#modalKeteranganFarmasi').modal('hide');
        // });
        
        $("#tambah-data").click(function(){
            $('#modalFormKonsumsi').modal('show');
        });

        $('#closeModalBtn').click(function () {
            $('#modalFormKonsumsi').modal('hide');
        });
    });
</script>
