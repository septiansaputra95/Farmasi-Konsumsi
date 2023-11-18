<!-- _modal-keterangan-farmasi.php -->
<div class="modal fade" id="modalKeteranganFarmasi" tabindex="-1" role="dialog" aria-labelledby="modalKeteranganFarmasiLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalKeteranganFarmasiLabel">Keterangan Farmasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Konten keterangan farmasi -->
                <div class="row">
                    <div class="col-md-6">
                        <h6>FARMASI EKSEKUTIF</h6>
                        <p>Rawat Jalan: <span id="rawatJalanEksekutif"></span></p>
                        <p>Rawat Inap: <span id="rawatInapEksekutif"></span></p>
                    </div>
                    <div class="col-md-6">
                        <h6>FARMASI REGULER</h6>
                        <p>Rawat Jalan: <span id="rawatJalanReguler"></span></p>
                        <p>Rawat Inap: <span id="rawatInapReguler"></span></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="tutupKeterangan">Close</button>
                <!-- <button type="submit" class="btn btn-primary">Simpan</button> -->
            </div>
        </div>
    </div>
</div>

<!-- Button untuk membuka modal -->
<!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalKeteranganFarmasi">
    Tampilkan Keterangan Farmasi
</button> -->

<!-- JavaScript untuk mengatur isi modal -->
<script>
    // Mengisi data pada modal
    function isiModalKeterangan(rawatJalanEksekutif, rawatInapEksekutif, rawatJalanReguler, rawatInapReguler) {
        document.getElementById('rawatJalanEksekutif').innerText = rawatJalanEksekutif;
        document.getElementById('rawatInapEksekutif').innerText = rawatInapEksekutif;
        document.getElementById('rawatJalanReguler').innerText = rawatJalanReguler;
        document.getElementById('rawatInapReguler').innerText = rawatInapReguler;
    }
</script>
