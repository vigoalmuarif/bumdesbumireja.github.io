<!-- Modal -->
<form action="<?= base_url('retribusi/update_retribusi') ?>" method="post" id="formEditRetribusi">
    <div class="modal fade" id="modalEditRetribusi" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modalEditRetribusiLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditRetribusiLabel">Ubah Retribusi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="id" value="<?= $retribusi['id']; ?>">
                    <div class="form-group">
                        <label for="">Nama Retribusi</label>
                        <input type="text" class="form-control" name="retribusi" id="retribusi" value="<?= $retribusi['nama'] ? $retribusi['nama'] : set_value('retribusi') ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="1" <?= $retribusi['status'] == 1 ? 'selected="selected"' : '' ?>>Aktif</option>
                            <option value="0" <?= $retribusi['status'] == 0 ? 'selected="selected"' : '' ?>>Non-Aktif</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    $(document).ready(function() {

        $("#formEditRetribusi").submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: "post",
                url: $(this).attr('action'),
                data: $(this).serialize(),
                dataType: "json",
                success: function(response) {
                    if (response.status == 'sukses') {
                        $("#modalEditRetribusi").modal('hide');
                        $('#modalEditRetribusi').on('hidden.bs.modal', function(event) {
                            dataRetribusi();
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 5000,
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                    toast.addEventListener('mouseenter', Swal.stopTimer)
                                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                                }
                            })

                            Toast.fire({
                                icon: 'success',
                                html: `Data berhasil diubah.`
                            })
                        })
                    }
                }
            });
        });
    });
</script>