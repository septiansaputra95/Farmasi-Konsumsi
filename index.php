<?php
// Include koneksi.php, header.php, dan footer.php
include 'koneksi.php';
include 'header.php';
?>

<div class="container mt-5">
    <h2>Data Konsumsi</h2>
    <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#modalFormKonsumsi" id="tambah-data">Tambah Data</button>
    <!-- <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#modalKeteranganFarmasi" id="tambah">Tambah ce</button> -->
    <table class="table" id="tabel-konsumsi">
        <thead>
            <tr>
                <th>Data ID</th>
                <th>Nama Petugas</th>
                <th>Tanggal Input</th>
                <th>Aksi </th>
            </tr>
        </thead>
        <tbody>
            
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
include 'script.js';
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
