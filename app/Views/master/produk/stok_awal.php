<!-- Modal -->
<form action="<?= base_url('produk/save_stok_awal') ?>" method="post" id="formStokAwal">
    <div class=" row">
        <div class="col">
            <div class="modal fade" id="modalStokAwal" tabindex="-1" aria-labelledby="modalStokAwalLabel" aria-hidden="true">
                <div class="modal-dialog  modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalStokAwalLabel">Stok Awal</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="alert alert-warning" role="alert">Stok awal hanya dapat ditambahkan sebelum ada pembelian pada produk <strong><?= $produk ?></strong>.</div>
                            <div class="form-row">

                                <div class="form-group col-md-12">
                                    <label for="nama">Produk</label>
                                    <input type="hidden" name="satuan" id="satuan" value="<?= $satuan; ?>" readonly>
                                    <input type="hidden" name="satuanID" id="satuanID" value="<?= $satuanID; ?>" readonly>
                                    <input type="hidden" name="id" id="id" value="<?= $produkID; ?>" readonly>
                                    <input type="text" class="form-control" name="nama" id="nama" value="<?= $sku . ' - ' . $produk ?>" placeholder="Masukan nama" readonly>
                                    <div class="invalid-feedback error-nama">

                                    </div>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="isi">Jumlah<strong class="text-danger">*</strong></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="jumlah" id="jumlah" placeholder="Masukan jumlah" autocomplete="off" required>
                                        <div class="input-group-append">
                                            <span class="input-group-text"><?= $satuan; ?></span>
                                        </div>
                                        <div class="invalid-feedback error-isi">

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary simpan">Simpan</button>
                        </div>
                    </div>


                </div>

            </div>
        </div>
    </div>
</form>
<div class="createSatuan"></div>

<script>
    $(document).ready(function() {
        $("#formStokAwal").submit(function(e) {
            e.preventDefault();
            var a = $(this).serialize();
            $.ajax({
                type: "post",
                url: $(this).attr('action'),
                data: $(this).serialize(),
                dataType: "json",
                success: function(response) {

                    if (response.error) {
                        Swal.fire(
                            'Error?',
                            response.error,
                            'question'
                        )
                    } else if (response.msg) {
                        window.location.reload();
                    }
                },
                error: function(xhr, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        });


        $("#jumlah").autoNumeric('init', {
            aSep: ',',
            aDec: '.',
            mDec: '0'

        });

    })
</script>