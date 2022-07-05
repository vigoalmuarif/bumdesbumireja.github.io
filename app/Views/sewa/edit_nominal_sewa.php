<!-- Modal -->

<form action="<?= base_url('persewaan/update_pembayaran_sewa') ?>" method="post" id="formUbahPembayaran" enctype="multipart/form-data">
    <div class="modal fade" id="modalEditPembayaranSewa" tabindex="-1" aria-labelledby="modalEditPembayaranSewaLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditPembayaranSewaLabel">Ubah Pembayaran Sewa</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" name="id" id="id" value="<?= $transaksi['transaksiId'] ?>">
                        <input type="hidden" name="sewaid" id="sewaid" value="<?= $transaksi['sewa_id'] ?>">
                        <input type="hidden" name="bayarold" id="bayarold" value="<?= $transaksi['bayar'] ?>">
                        <input type="hidden" name="gambar_old" id="gambar_old" value="<?= $transaksi['bukti'] ?>">

                        <label for=""><strong>Faktur</strong></label>
                        <input type="text" class="form-control form-control-sm font-weight-bold text-primary" value="<?= $faktur ?>" readonly id="faktur" name="faktur">
                    </div>
                    <div class="form-group">
                        <label for=""><strong>Pedagang</strong></label>
                        <input type="text" class="form-control form-control-sm font-weight-bold" name="pedagang" value="<?= $pedagang ?>" id="pedagang" autocomplete="off" readonly>
                    </div>
                    <div class="form-group">
                        <label for=""><strong>Kode Property</strong></label>
                        <input type="text" class="form-control form-control-sm font-weight-bold" name="property" value="<?= $property ?>" id="property" autocomplete="off" readonly>
                    </div>
                    <div class="form-group">
                        <label for=""><strong>Tanggal Bayar</strong></label>
                        <input type="text" class="form-control form-control-sm font-weight-bold" name="created" value="<?= date('d-m-Y H:i', strtotime($transaksi['tanggal_bayar'])) ?>" id="created" autocomplete="off" readonly>
                    </div>
                    <div class="form-group">
                        <label for=""><strong>Bayar (Rp)</strong></label>
                        <input type="text" class="form-control form-control-lg font-weight-bold text-danger" name="bayar" value="<?= $transaksi['bayar'] ?>" id="bayar" autocomplete="off">
                    </div>

                    <div class="form-group">
                        <label for="metode"><strong>Metode Bayar</strong></label>
                        <select class="form-control" id="metode" name="metode">
                            <option value="Tunai" <?= $transaksi['metode_bayar'] == 'Tunai' ? 'selected="selected"' : '' ?>>Tunai</option>
                            <option value="Transfer" <?= $transaksi['metode_bayar'] == 'Transfer' ? 'selected="selected"' : '' ?>>Transfer</option>
                        </select>
                    </div>


                    <div class="form-group">
                        <label for=""><strong>Keterangan</strong></label>
                        <textarea type="text" class="form-control" rows="3" id="keterangan" name="keterangan"><?= $transaksi['keterangan'] ?></textarea>
                    </div>


                    <div class="form-group bukti">
                        <label for="">Bukti Pembayaran</label>
                        <input class="form-control-file" type="file" name="bukti" id="bukti">
                        <div class="invalid-feedback error-bukti">

                        </div>
                        <small class="text-muted">Format Gambar: jpg, jpeg, png. Ukuran Maks. 5Mb</small>
                    </div>
                    <?php if ($transaksi['bukti'] != NULL) : ?>
                        <div class="col-md-3 mb-3 foto-bukti">
                            <img src="/img/upload/<?= $transaksi['bukti']; ?>" class="img-thumbnail" alt="">
                        </div>
                    <?php endif ?>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success simpanPembayaran">Ubah</button>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    function bukti() {
        const metode = $("#metode").val();
        if (metode == "Transfer") {
            $(".bukti").prop('hidden', false);
        } else {
            $(".bukti").prop('hidden', true);
        }
    }
    $(document).ready(function() {
        bukti();

        $("#metode").on('change', function(e) {
            e.preventDefault();
            const metode = $("#metode").val();
            if (metode == "Transfer") {
                $(".bukti").prop('hidden', false);
                $(".foto-bukti").prop('hidden', false);
            } else {
                $(".bukti").prop('hidden', true);
                $("#bukti").val('');
                $(".error-bukti").html('');
                $(".foto-bukti").prop('hidden', true);
            }
        })


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
        });

        $("#bayar").autoNumeric('init', {
            aSep: ',',
            aDec: '.',
            mDec: '0',
        });


        $("#formUbahPembayaran").submit(function(e) {
            let bayar = $("#bayar").autoNumeric('get');

            if (bayar == 0 || bayar == "") {
                Toast.fire({
                    icon: 'error',
                    title: 'Masukan jumlah pembayaran'
                });
            } else {
                var i = new FormData(this);
                $.ajax({
                    type: "post",
                    url: $(this).attr('action'),
                    data: i,
                    processData: false,
                    contentType: false,
                    dataType: "json",
                    beforeSend: function() {
                        $(".simpanPembayaran").prop('disabled', true);
                        $(".simpanPembayaran").html('<i class=" fa fa-spin fa-spinner "</i>');
                    },
                    complete: function() {
                        $(".simpanPembayaran").prop('disabled', false);
                        $(".simpanPembayaran").html('mengubah');
                    },
                    success: function(response) {
                        if (response.error) {
                            if (response.error) {
                                if (response.error.bukti) {
                                    $("#bukti").addClass('is-invalid');
                                    $(".error-bukti").html(response.error.bukti);
                                } else {
                                    $("#bukti").removeClass('is-invalid');
                                    $(".error-bukti").html('');
                                }
                            }
                        } else if (response.status == 'sukses') {
                            $("#modalEditPembayaranSewa").modal('hide');
                            $('#modalEditPembayaranSewa').on('hidden.bs.modal', function(event) {
                                berlangsung();
                                Swal.fire(
                                    'Diubah!',
                                    'Pembayaran berhasil diubah.',
                                    'success'
                                )
                            })
                        }
                    },
                    error: function(xhr, thrownError) {
                        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                    }

                });
            }
            return false;

        });

    });
</script>