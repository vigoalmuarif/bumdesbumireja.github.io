<!-- Modal -->
<div class="modal fade" id="modalUbahKategori" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modalUbahKategoriLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalUbahKategoriLabel">Ubah Kategori</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col">
                        <form action="<?= base_url('produk/update_kategori') ?>" id="formUpdate" method="post">
                            <input type="hidden" class="form-control" id="aksi" name="aksi" value="">
                            <div class=" col">
                                <div class="form-group">
                                    <label for="nama">Nama Kategori</label>
                                    <input type="hidden" name="id" id="id" value="<?= $kategori['id'] ?>">
                                    <input type="text" class="form-control" id="nama" name="nama" value="<?= $kategori['nama'] ?>" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary" id="simpan">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $("#formUpdate").submit(function(e) {
                e.preventDefault();
                $.ajax({
                    type: "post",
                    url: $(this).attr('action'),
                    data: $(this).serialize(),
                    dataType: "json",
                    beforeSend: function(e) {
                        $("#simpan").prop('disabled', true);
                        $("#simpan").html('<i class="fa fa-spin fa-spinner"></i>');
                    },
                    success: function(response) {
                        window.location.reload();
                    },
                    error: function(xhr, thrownError) {
                        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError)
                    }
                });
            });

        });
    </script>