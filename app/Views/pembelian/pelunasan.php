<!-- Modal -->

<form action="<?= base_url('pembelian/save_bayar_hutang') ?>" method="post" id="formPembayaran">
    <div class="modal fade" id="modalBayarHutang" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modalBayarHutangLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalBayarHutangLabel">Pembayaran Hutang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            <table class="table table-borderless table-sm">
                                <thead></thead>
                                <tbody>
                                    <tr>
                                        <td>Faktur</td>
                                        <td>:</td>
                                        <td><?= $detail['faktur']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Supplier</td>
                                        <td>:</td>
                                        <td><?= $detail['supplier']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Total</td>
                                        <td>:</td>
                                        <td>Rp. <?= number_format($detail['total'], 0, ",", ","); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Diskon</td>
                                        <td>:</td>
                                        <td>Rp. <?= number_format($detail['diskon'], 0, ",", ","); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Total Bayar</td>
                                        <td>:</td>
                                        <td>Rp. <?= number_format($detail['total'] - $detail['diskon'], 0, ",", ","); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Dibayar</td>
                                        <td>:</td>
                                        <td>Rp. <?= number_format($detail['bayar'], 0, ",", ","); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Sisa Hutang</td>
                                        <td>:</td>
                                        <td>Rp. <?= number_format(($detail['total'] - $detail['diskon']) - $detail['bayar'], 0, ",", ","); ?></td>
                                    </tr>
                                </tbody>
                            </table>
                            <hr>
                            <div class="form-group">
                                <input type="hidden" name="pembelian" id="pembelian" value="<?= $detail['pembelian_id'] ?>">
                                <input type="hidden" name="total" id="total" value="<?= $detail['total'] ?>">
                                <input type="hidden" name="diskon" id="diskon" value="<?= $detail['diskon'] ?>">
                                <input type="hidden" name="terbayar" id="terbayar" value="<?= $detail['bayar'] ?>">
                                <label for=""><strong>Bayar (Rp)</strong></label>
                                <input type="text" class="form-control form-control-lg font-weight-bold" onfocus="(this).select();" value="0" name="bayar" id="bayar" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label for=""><strong class="labelKekurangan">Kekurangan (Rp)</strong></label>
                                <input type="text" class="form-control form-control-lg font-weight-bold kurleb text-danger" id="kurleb" value="<?= ($detail['total'] - $detail['diskon']) - $detail['bayar'] ?>" readonly name="kurleb">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success simpanPembayaran">Bayar</button>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    $(document).ready(function() {
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

        $("#bayar").keyup(function(e) {

            kekurangan();
        });

        $("#total").autoNumeric('init', {
            aSep: ',',
            aDec: '.',
            mDec: '0',
        });

        $("#bayar").autoNumeric('init', {
            aSep: ',',
            aDec: '.',
            mDec: '0',
        });
        $("#terbayar").autoNumeric('init', {
            aSep: ',',
            aDec: '.',
            mDec: '0',
        });
        $("#kurleb").autoNumeric('init', {
            aSep: ',',
            aDec: '.',
            mDec: '0',
        });

        $("#formPembayaran").submit(function(e) {
            let bayar = $("#bayar").autoNumeric('get');
            let total = $("#total").autoNumeric('get');
            // let kurang = parseFloat(total);
            // $("#kekurangan").val(kurang);
            // let kembalian = $("#kekurangan").val();
            // $("#kekurangan").autoNumeric('set', kembalian);

            if (bayar == "" || bayar == 0) {
                Toast.fire({
                    icon: 'warning',
                    title: 'Masukan Nominal bayar',
                });
            } else {
                $.ajax({
                    type: "post",
                    url: $(this).attr('action'),
                    data: $(this).serialize(),
                    dataType: "json",
                    beforeSend: function() {
                        $(".simpanPembayaran").prop('disabled', true);
                        $(".simpanPembayaran").html('<i class=" fa fa-spin fa-spinner "</i>');
                    },
                    complete: function() {
                        $(".simpanPembayaran").prop('disabled', false);
                        $(".simpanPembayaran").html('Menyimpan');
                    },
                    success: function(response) {

                        if (response.data == 'sukses') {
                            $("#modalPembayaran").modal('hide');
                            Swal.fire({
                                title: 'Cetak Struk',
                                text: "Apakah ingin cetak struk pembayaran?",
                                icon: 'question',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Ya, Cetak',
                                cancelButtonText: 'Tidak',
                                allowOutsideClick: false
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $.ajax({
                                        type: "post",
                                        url: "<?= base_url('pembelian/cetakstruk') ?>",
                                        data: {
                                            faktur: '<?= $detail['faktur'] ?>'
                                        },
                                        dataType: "json",
                                        success: function(response) {
                                            if (response.print == 'sukses')
                                                window.location.reload();
                                        },
                                        error: function(xhr, thrownError) {
                                            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                                        }
                                    });
                                } else {

                                    window.location.reload();
                                }
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

    function kekurangan() {
        let bayar = $("#bayar").autoNumeric('get');
        let harga = $("#total").autoNumeric('get');
        let total = harga - parseInt("<?= $detail['diskon'] ?>");
        let terbayar = $("#terbayar").autoNumeric('get');
        if (bayar == "") {

            var totalBayar = parseFloat(terbayar) + 0;
        } else {
            var totalBayar = parseFloat(terbayar) + parseFloat(bayar);

        }
        let kurang = parseFloat(total) - parseFloat(totalBayar);
        let kembali = parseFloat(totalBayar) - parseFloat(total);
        $("#kurleb").val(kurang);
        let kekurangan = $("#kurleb").val();
        $("#kurleb").autoNumeric('set', kekurangan);
        if (kurang > 0) {
            $(".labelKekurangan").text('Kekurangan (Rp)');
            $(".kurleb").addClass('text-danger');
            $(".kurleb").removeClass('text-success');
            $("#kurleb").autoNumeric('set', kekurangan);
        } else {
            $(".labelKekurangan").text('Kembalian (Rp)');
            $(".kurleb").removeClass('text-danger');
            $(".kurleb").addClass('text-success');
            $("#kurleb").val(kurang);
            $("#kurleb").autoNumeric('set', kembali);
        }

    }
</script>