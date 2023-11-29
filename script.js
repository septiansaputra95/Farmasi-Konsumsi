<script>
$(document).ready(function () {
   $('#tabel-konsumsi').DataTable({
        "ajax": {
            "url": "proses_load_data.php",
            "dataSrc": ""
        },
        "columns": [
            {"data": "data_id"},
            {"data": "konsumsi_tanggal"},
            {"data": "nama_petugas"},
            {"data": "tanggal"},
            {
                "data": "data_id",
                "render": function (data, type, row, meta) {
                    return '<button class="btn btn-generateResep btn-success" data-id="' + data + '" id="generate">Generate Resep</button>';
                }
            },
            {
                "data": "data_id",
                "render": function (data, type, row, meta) {
                    // return '<button class="btn btn-generateResep btn-success" data-id="' + data + '" id="generate">Generate Resep</button>';
                    return '<button class="btn btn-generate btn-danger" data-id="' + data + '" id="generate">Generate Sub Resep</button>';
                }
            }
        ]
   })
});


</script>