<!-- Modal -->
<form action="<?= base_url('pembelian/save_supplier') ?>" method="post" id="formAddSupplier">
    <div class="modal fade" id="modalAddSupplier" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="tambahProdukBaruLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Tambah Supplier Baru</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row">

                        <div class="col col-md-12 ">
                            <div class="form-group">
                                <label for="nama">Nama Supplier</label>
                                <input type="text" class="form-control" id="namaSupplier" name="namaSupplier" autocomplete="off">
                                <div class="invalid-feedback error-namaSupplier"></div>
                            </div>
                        </div>
                        <div class="col col-md-12 ">
                            <div class="form-group">
                                <label for="no_hp">No Telepon</label>
                                <input type="text" class="form-control" id="noHp" name="noHp" autocomplete="off">
                                <div class="invalid-feedback error-noHp"></div>
                            </div>
                        </div>
                        <div class="col col-md-12 ">
                            <div class="form-group">
                                <label for="alamat">Alamat</label>
                                <textarea class="form-control" id="alamat" name="alamat"></textarea>
                                <div class="invalid-feedback error-alamat"></div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary simpanProduk">Simpan</button>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    $(document).ready(function() {




        $("#formAddSupplier").submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: "post",
                url: $(this).attr('action'),
                data: $(this).serialize(),
                dataType: "json",
                success: function(response) {

                    if (response.error) {

                        if (response.error.namaSupplier) {
                            $("#namaSupplier").addClass('is-invalid');
                            $(".error-namaSupplier").html(response.error.namaSupplier);
                        } else {
                            $("#namaSupplier").removeClass('is-invalid');
                            $(".error-namaSupplier").html('');
                        }
                        if (response.error.noHp) {
                            $("#noHp").addClass('is-invalid');
                            $(".error-noHp").html(response.error.noHp);
                        } else {
                            $("#noHp").removeClass('is-invalid');
                            $(".error-noHp").html('');
                        }
                        if (response.error.alamat) {
                            $("#alamat").addClass('is-invalid');
                            $(".error-alamat").html(response.error.alamat);
                        } else {
                            $("#alamat").removeClass('is-invalid');
                            $(".error-alamat").html('');
                        }

                    } else {

                        $("#modalAddSupplier").modal('hide');
                        supplier();
                    }

                },
                error: function(xhr, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        });

    })
</script>