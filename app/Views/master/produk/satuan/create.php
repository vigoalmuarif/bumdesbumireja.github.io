<!-- Modal -->
<div class="modal fade" id="modalAddSatuan" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modalAddKategoriLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAddKategoriLabel">Tambah Satuan / Unit</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col">
                        <form action="<?= base_url('produk/save_satuan') ?>" id="formAddSatuan" method="">
                            <input type="hidden" class="form-control" id="aksi" name="aksi" value="<?= $aksi ?>">
                            <div class="col">
                                <div class="form-group">
                                    <label for="nama">Nama Satuan / Unit</label>
                                    <input type="text" class="form-control" id="nama" name="nama" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary" id="simpanSatuan">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {

            $("#formAddSatuan").submit(function(e) {
                e.preventDefault();
                $.ajax({
                    type: "post",
                    url: $(this).attr('action'),
                    data: $(this).serialize(),
                    dataType: "json",
                    beforeSend: function(e) {
                        $("#simpanSatuan").prop('disabled', true);
                        $("#simpanSatuan").html('<i class="fa fa-spin fa-spinner"></i>');
                    },
                    success: function(response) {
                        let aksi = $('#aksi').val();
                        if (response.nama) {
                            if (aksi == 1) {
                                window.location.reload();
                            } else {
                                $("#modalAddSatuan").modal('hide');
                                ambilSatuan();
                            }
                        }
                    },
                    error: function(xhr, thrownError) {
                        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError)
                    }
                });
            });
        });
    </script>