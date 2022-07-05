<!-- Modal -->
<div class="modal fade" id="modalEdit" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modalEdit" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEdit">Ubah Jabatan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col">
                        <form action="<?= base_url('petugas/update_jabatan') ?>" id="formEdit" method="post">
                            <div class="col">
                                <div class="form-group">
                                    <label for="nama">Nama jabatan</label>
                                    <input type="hidden" name="id" id="id" value="<?= $jabatan['id'] ?>">
                                    <input type="text" class="form-control" id="nama" name="nama" value="<?= $jabatan['nama'] ?>" autocomplete="off" required>
                                </div>
                                <div class="form-group">
                                    <label for="desc">Deskripsi</label>
                                    <textarea class="form-control" name="desc" id="desc" rows="3"><?= $jabatan['keterangan'] ?></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary" id="simpan">Ubah</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {

            $("#formEdit").submit(function(e) {
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
                        if (response.sukses == 'sukses') {
                            window.location.reload();
                        }
                    },
                    error: function(xhr, thrownError) {
                        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError)
                    }
                });
            });
        });
    </script>