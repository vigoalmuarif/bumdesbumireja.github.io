<!-- Modal -->

<form action="<?= base_url('penjualan/simpan_pembayaran') ?>" method="post" id="formPembayaran">
    <div class="modal fade" id="modalBayarPiutang" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modalBayarPiutangLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalBayarPiutangLabel">Pembayaran (Hutang)</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="form-group">
                            <input type="hidden" name="faktur" id="faktur" value="<?= $faktur ?>">
                            <input type="hidden" name="tanggal" id="tanggal" value="<?= $tanggal ?>">
                            <input type="hidden" name="pelanggan" id="pelanggan" value="<?= $pelanggan ?>">
                            <input type="hidden" name="pembayaran" id="pembayaran" value="<?= $pembayaran ?>">
                            <label for=""><strong>Total Bayar (Rp)</strong></label>
                            <input type="text" class="form-control form-control-lg font-weight-bold text-primary" value="<?= $total ?>" readonly id="total" name="total">
                        </div>
                        <label for=""><strong>Uang Muka (Rp)</strong></label>
                        <input type="text" class="form-control form-control-lg font-weight-bold" onfocus="(this).select();" value="0" name="bayar" id="bayar" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for=""><strong>Kekurangan (Rp)</strong></label>
                        <input type="text" class="form-control form-control-lg font-weight-bold text-danger" id="kekurangan" value="<?= $total ?>" readonly name="kekurangan">
                    </div>
                    <div class="form-group">
                        <label for=""><strong>Keterangan</strong></label>
                        <textarea type="text" class="form-control" rows="3" id="keterangan" name="keterangan"></textarea>
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
        $("#kekurangan").autoNumeric('init', {
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

            if (bayar == "") {
                Toast.fire({
                    icon: 'error',
                    title: 'Uang muka minimal 0 Rupiah',
                });
            } else if (parseFloat(bayar) > parseFloat(total)) {

                Toast.fire({
                    icon: 'error',
                    title: 'Uang muka lebih besar daripada total bayar',
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
                                    alert('cetak struk');
                                    window.location.reload();
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
        let total = $("#total").autoNumeric('get');
        let kurang = parseFloat(total) - parseFloat(bayar);
        $("#kekurangan").val(kurang);
        let kekurangan = $("#kekurangan").val();
        $("#kekurangan").autoNumeric('set', kekurangan);
        if (kurang >= 0) {

        }
        if (kurang < 0) {
            $("#kekurangan").val('Tidak Valid');
        }
    }
</script>