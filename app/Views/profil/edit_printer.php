<!-- Modal -->
<form action="<?= base_url('profil/save_printer') ?>" method="post" id="formEdit">
    <div class="modal fade" id="modalEdit" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="editLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editLabel">Ubah printer</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col mx-auto">
                            <div class="form-group ">
                                <label for="">Nama Printer Thermal</label>
                                <input type="hidden" name="aksi" id="aksi" value="0">
                                <input type="text" class="form-control" name="printer" required id="printer" autocomplete="off" value="<?= $printer['printer'] ?>">
                                <div class="invalid-feedback invalid-tanggal">
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="">Nama Toko</label>
                                <input type="text" class="form-control" name="nama" id="nama" autocomplete="off" required value="<?= $printer['nama_toko'] ?>">
                                <div class="invalid-feedback invalid-nama">
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="">Alamat</label>
                                <textarea class="form-control" name="alamat" id="alamat" rows="3" required><?= $printer['alamat'] ?></textarea>
                                <div class="invalid-feedback invalid-alamat">
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="">Footer 1</label>
                                <input type="text" class="form-control" name="footer_1" id="footer_1" autocomplete="off" required placeholder=" contoh, Terimakasih sudah berbelanja" value="<?= $printer['footer_1'] ?>">
                                <div class="invalid-feedback invalid-nama">
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="">Footer 2</label>
                                <input type="text" class="form-control" name="footer_2" id="footer_2" autocomplete="off" required placeholder="Opsional" value="<?= $printer['footer_2'] ?>">
                                <div class="invalid-feedback invalid-nama">
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="submit">Ubah</button>
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