<!-- _modal-form-konsumsi.php -->
<div class="modal fade" id="modalFormKonsumsi" tabindex="-1" role="dialog" aria-labelledby="modalFormKonsumsiLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalFormKonsumsiLabel">Tambah Data Konsumsi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Form untuk input data konsumsi -->
                <form action="proses_simpan_konsumsi.php" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="namaPetugas">Nama Petugas:</label>
                        <input type="text" class="form-control" id="nama-Petugas" name="nama_Petugas" required>
                    </div>
                    <div class="form-group">
                        <label for="fileUpload">File Upload:</label>
                        <input type="file" class="form-control" id="file-Upload" name="file_Upload" accept=".xls, .xlsx" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="closeModalBtn">Close</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
