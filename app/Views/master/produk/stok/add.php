<!-- Modal -->
<form action="<?= base_url('produk/proccess_add_stok') ?>" id="formAddStok" method="post">
    <div class="modal fade" id="modalAddStok" tabindex="-1" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="d-inline">Tambah Stok</h5>
                    <button type=" button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" value="<?= $produk['produk_id'] ?>">
                    <input type="hidden" name="stok" value="<?= $produk['stok'] ?>">
                    <input type="hidden" name="stok_in" value="<?= $produk['stok_in'] ?>">
                    <div class="form-group">
                        <label for=" produk">Nama Produk</label>
                        <input type="text" class="form-control" value="<?= set_value('produk') ? set_value('produk') : $produk['produk'] ?>" name="produk" placeholder="Masukan produk" readonly>
                        <div class="invalid-feedback">

                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for=" satuan">Satuan</label>
                                <input type="text" class="form-control" value="<?= set_value('satuan') ? set_value('satuan') : $produk['satuan'] ?>" name="satuan" placeholder="Masukan satuan" readonly>
                                <div class="invalid-feedback">

                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for=" stok">Stok saat ini</label>
                                <input type="text" class="form-control" value="<?= set_value('stok') ? set_value('stok') : $produk['stok'] ?>" name="stok" placeholder="Masukan stok" readonly>
                                <div class="invalid-feedback">

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for=" jumlah">Jumlah</label>
                        <input type="text" class="form-control" value="<?= set_value('jumlah') ?>" name="jumlah" placeholder="Masukan jumlah" id="jumlah" autocomplete="off">
                        <div class="invalid-feedback error-jumlah">

                        </div>
                    </div>
                    <div class="form-group">
                        <label for=" jumlah">Keterangan</label>
                        <input type="text" class="form-control" value="<?= set_value('keterangan') ?>" name="keterangan" placeholder="Masukan keterangan" id="keterangan" autocomplete="off">
                        <small class="text-muted">Contoh : Bonus, Hadiah..</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    $(document).ready(function() {

        $("#formAddStok").submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: "post",
                url: $(this).attr('action'),
                data: $(this).serialize(),
                dataType: "json",
                success: function(response) {
                    if (response.error) {
                        if (response.error.jumlah) {
                            $("#jumlah").addClass('is-invalid');
                            $(".error-jumlah").html(response.error.jumlah);
                        } else {
                            $("#jumlah").removeClass('is-invalid');
                            $(".error-jumlah").html('');
                        }
                    } else {
                        window.location.reload();
                    }
                },
                error: function(xhr, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });

        });

        $("#jumlah").autoNumeric('init', {
            aSep: "",
            aDec: ".",
            mDec: ""
        });
    });
</script>