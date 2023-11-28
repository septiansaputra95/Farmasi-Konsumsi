<?php
// Include koneksi.php, header.php, dan footer.php
include 'koneksi.php';
include 'header.php';

// Tampilkan notifikasi jika parameter success ada dalam URL
if (isset($_GET['success']) && $_GET['success'] == 1) {
    $successMessage = '<div class="alert alert-success" role="alert">Data berhasil disimpan!</div>';
} else {
    $successMessage = ''; // Jika tidak ada notifikasi, kosongkan variabel
}

?>

<div class="container mt-5">
    <h2>Data Konsumsi</h2>
    <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#modalFormKonsumsi" id="tambah-data">Tambah Data</button>
    <!-- <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#modalKeteranganFarmasi" id="tambah">Tambah ce</button> -->
    <?php echo $successMessage; ?>
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
//include 'proses_load_data.php';
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
            
            $('#tabel-konsumsi tbody').on('click', '.btn-generate', function () {
            var dataId = $(this).data('id');

            // Memanggil fungsi khusus untuk generate dengan AJAX
            generateData(dataId);
        });

        // Fungsi untuk generate data dengan AJAX
        function generateData(data_id) {
            console.log('Data ID yang dikirim:', data_id);
            $.ajax({
                type: 'POST',
                url: 'proses_generate_data.php',
                data: {data_id: data_id},
                success: function (response) {
                    // Menampilkan hasil generate dalam alert
                    //console.log(response);
                    alert(response);
                },
                error: function () {
                    alert('Terjadi kesalahan saat mencoba generate data.');
                }
            });
        }
    });
</script>
