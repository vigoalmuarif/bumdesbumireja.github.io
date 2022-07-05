<!-- Modal -->
<form action="<?= base_url('retribusi/save_retribusi') ?>" method="post" id="formAddRetribusi">
    <div class="modal fade" id="modalAddRetribusi" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modalAddRetribusiLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAddRetribusiLabel">Tambah Retribusi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Nama Retribusi</label>
                        <input type="text" class="form-control" name="retribusi" id="retribusi" required>
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="" disabled hidden selected>--Pilih--</option>
                            <option value="1">Aktif</option>
                            <option value="0">Non-Aktif</option>
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

        $("#formAddRetribusi").submit(function(e) {
            e.preventDefault();
            let retribusi = $("#retribusi").val();
            $.ajax({
                type: "post",
                url: $(this).attr('action'),
                data: $(this).serialize(),
                dataType: "json",
                success: function(response) {
                    if (response.status == 'sukses') {
                        $("#modalAddRetribusi").modal('hide');
                        $('#modalAddRetribusi').on('hidden.bs.modal', function(event) {
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
                                html: `<strong>${retribusi}</strong> berhasil ditambahkan.`
                            })
                        })
                    }
                }
            });
        });
    });
</script>