<!-- Modal -->
<form action="<?= base_url('retribusi/update_petugas') ?>" method="post" id="formEdit">
    <div class="modal fade" id="modalEditPetugasRetribusi" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modalEditPetugasRetribusiLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditPetugasRetribusiLabel">Ubah Petugas Retribusi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php if ($petugas['in_pegawai'] == 0) : ?>
                        <div class="alert alert-warning alert-dismissible fade show text-center" role="alert">
                            Petugas telah di nonaktifkan dari data pegawai.
                            <button type="button" class="close" data-dismiss="alert">
                            </button>
                        </div>
                    <?php endif ?>
                    <div class="form-group">
                        <input type="hidden" name="id" id="id" value="<?= $petugas['groupID'] ?>">
                        <label for="">Nama Petugas</label>
                        <input type="text" class="form-control" name="petugas" id="petugas" value="<?= $petugas['pegawai'] ?>" readonly>
                        <div class="invalid-feedback error-periode">

                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">NIK</label>
                        <input type="text" class="form-control" name="nik" id="nik" value="<?= $petugas['nik'] ?>" readonly>
                        <div class="invalid-feedback error-periode">

                        </div>
                    </div>

                    <div class="form-group">
                        <label for="petugas">Petugas</label>
                        <select class="form-control" id="petugas" name="petugas" <?= $petugas['in_pegawai'] == 0 ? "disabled" : '' ?>>
                            <?php foreach ($retribusi as $retribution) : ?>

                                <option value="<?= $retribution['retribusiId'] ?>" <?= $retribution['retribusiId'] == $petugas['retribusiID'] ? 'selected="selected"' : '' ?>><?= $retribution['retribusi'] ?></option>
                            <?php endforeach ?>
                        </select>
                        <div class="invalid-feedback error-jabatan">

                        </div>
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control" id="status" name="status" <?= $petugas['in_pegawai'] == 0 ? "disabled" : '' ?>>

                            <option value="1" <?= $petugas['pr_status'] == 1 ? 'selected="selected"' : '' ?>>Aktif</option>
                            <option value="0" <?= $petugas['pr_status'] == 0 ? 'selected="selected"' : '' ?>>Non-aktif</option>

                        </select>
                        <div class="invalid-feedback error-jabatan">

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" <?= $petugas['in_pegawai'] == 0 ? "disabled" : '' ?>>Ubah</button>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    $(document).ready(function() {
        $("#formEdit").submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: "post",
                url: $(this).attr('action'),
                data: $(this).serialize(),
                dataType: "json",
                success: function(response) {
                    if (response.sukses) {
                        window.location.reload();
                    }
                },
                error: function(xhr, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        })
    })
</script>