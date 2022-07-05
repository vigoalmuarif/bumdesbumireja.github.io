<!-- Modal -->
<form action="<?= base_url('produk/proccess_less_stok') ?>" id="formLessStok" method="post">
    <div class="modal fade" id="modalLessStok" tabindex="-1" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="d-inline">Pengurangan Stok</h5>
                    <button type=" button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning" role="alert">Perhatian! Setelah melakukan pengurangan stok, tidak dapat diubah maupun dihapus.</div>
                    <?php if ($produk['qty_master'] == 0) : ?>
                        <div class="alert alert-danger text-center" role="alert">
                            Stok saat ini tidak tersedia.
                        </div>
                    <?php endif ?>
                    <input type="hidden" name="id" value="<?= $produk['produkID'] ?>">
                    <input type="hidden" name="stok" value="<?= $produk['qty_master'] ?>">
                    <input type="hidden" name="isi" id="isi">
                    <input type="hidden" name="harga_id" id="hargaID">
                    <div class="form-group">
                        <label for=" produk">Nama Produk</label>
                        <input type="text" class="form-control" value="<?= set_value('produk') ? set_value('produk') : $produk['sku'] . ' - ' .  $produk['produk'] ?>" name="produk" placeholder="Masukan produk" readonly>
                        <div class="invalid-feedback">

                        </div>
                    </div>
                    <div class="row">

                        <div class="col col-md-6">
                            <div class="form-group">
                                <label for=" stok">Stok saat ini</label>
                                <input type="text" class="form-control" value="<?= set_value('stok') ? set_value('stok') : number_format($produk['qty_master'], 0) ?>" name="stok" placeholder="Masukan stok" id="stok" readonly>
                                <div class="invalid-feedback">

                                </div>
                            </div>
                        </div>
                        <div class="col col-md-6">
                            <div class="form-group">
                                <label for=" satuan">Satuan</label>
                                <input type="text" class="form-control" value="<?= set_value('satuan') ? set_value('satuan') : $produk['satuan'] ?>" name="satuan" id="satuan" placeholder="Masukan satuan" readonly>
                                <div class="invalid-feedback">

                                </div>
                            </div>
                        </div>
                        <div class="col col-md-6">
                            <div class="form-group">
                                <label for="">Satuan Pengurangan</label>
                                <select class="custom-select" name="satuan_kurang" id="satuanPengurangan">
                                    <option value="" disabled selected hidden>--Pilih--</option>
                                    <?php foreach ($satuan as $unit) : ?>
                                        <option value="<?= $unit['satuanID']; ?>" data-isi="<?= $unit['isi']; ?>" data-id="<?= $unit['produk_harga_id']; ?>"><?= $unit['satuan']; ?></option>
                                    <?php endforeach ?>
                                </select>
                                <div class="invalid-feedback error-satuan">

                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-6 mb-3">
                            <label for=" jumlah">Jumlah Pengurangan</label>
                            <input type="text" class="form-control" value="<?= set_value('jumlah') ?>" name="jumlah" placeholder="Masukan jumlah" id="jumlahPengurangan" autocomplete="off">
                            <div class="invalid-feedback error-jumlah">

                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for=" jumlah">Keterangan</label>
                        <input type="text" class="form-control" value="<?= set_value('keterangan') ?>" name="keterangan" placeholder="Contoh: Hilang, Rusak, Keperluan toko, dsb..." id="keteranganPengurangan" autocomplete="off">

                        <div class="invalid-feedback error-keterangan"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary button-kurangi-stok">Simpan</button>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    function stok() {
        let stok = $("#stok").val();
        if (stok < 1) {
            $("#jumlah").prop("disabled", true);
            $("#keterangan").prop("disabled", true);
            $(".button-kurangi-stok").prop("disabled", true);
        }
    }


    $(document).ready(function() {
        stok();
        $("#satuanPengurangan").change(function(e) {
            e.preventDefault();
            var isi = $("#satuanPengurangan option:selected").data('isi');
            var id = $("#satuanPengurangan option:selected").data('id');
            $("#isi").val(isi);
            $("#hargaID").val(id);

        })

        $("#formLessStok").submit(function(e) {
            e.preventDefault();
            var isi = $("#isi").val();
            var jumlah = $("#jumlahPengurangan").val();
            if (isi.length == 0) {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })

                Toast.fire({
                    icon: 'warning',
                    html: 'Pilih Satuan pengurangan!'
                })
            } else if (jumlah.length == 0) {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })

                Toast.fire({
                    icon: 'warning',
                    html: 'Masukan jumlah pengurangan!'
                })
            } else {

                $.ajax({
                    type: "post",
                    url: $(this).attr('action'),
                    data: $(this).serialize(),
                    dataType: "json",
                    success: function(response) {
                        if (response.status) {
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                    toast.addEventListener('mouseenter', Swal.stopTimer)
                                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                                }
                            })

                            Toast.fire({
                                icon: 'warning',
                                html: response.status
                            })
                        } else if (response.error) {
                            if (response.error.satuan_kurang) {
                                $("#satuanPengurangan").addClass('is-invalid');
                                $(".error-satuan").html(response.error.satuan_kurang);
                            } else {
                                $("#satuanPengurangan").removeClass('is-invalid');
                                $(".error-satuan").html('');
                            }
                            if (response.error.jumlah) {
                                $("#jumlahPengurangan").addClass('is-invalid');
                                $(".error-jumlah").html(response.error.jumlah);
                            } else {
                                $("#jumlahPengurangan").removeClass('is-invalid');
                                $(".error-jumlah").html('');
                            }
                            if (response.error.keterangan) {
                                $("#keteranganPengurangan").addClass('is-invalid');
                                $(".error-keterangan").html(response.error.keterangan);
                            } else {
                                $("#keteranganPengurangan").removeClass('is-invalid');
                                $(".error-keterangan").html('');
                            }
                        } else {
                            window.location.reload();
                        }
                    },
                    error: function(xhr, thrownError) {
                        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                    }
                });
            }

        });

        $("#jumlahPengurangan").autoNumeric('init', {
            aSep: "",
            aDec: ".",
            mDec: ""
        });
    });
</script>