<!-- Modal -->

<form action="<?= base_url('penjualan/simpan_pembayaran') ?>" method="post" id="formPembayaran">
    <div class="modal fade" id="modalPembayaran" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modalPembayaranLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalPembayaranLabel">Pembayaran</h5>
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
                        <label for=""><strong>Bayar (Rp)</strong></label>
                        <input type="text" class="form-control form-control-lg font-weight-bold" name="bayar" value="<?= $total ?>" onfocus="(this).select();" id="bayar" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for=""><strong class="label-kurleb">Kekurangan (Rp)</strong></label>
                        <input type="text" class="form-control form-control-lg font-weight-bold" value="" id="kembalian" readonly name="kembalian">
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
        kembali();
        $("#bayar").keyup(function(e) {

            kembalian();
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
        $("#kembalian").autoNumeric('init', {
            aSep: ',',
            aDec: '.',
            mDec: '0',
        });

        $("#formPembayaran").submit(function(e) {
            let bayar = $("#bayar").autoNumeric('get');
            let total = $("#total").autoNumeric('get');

            if (bayar == 0 || bayar == "") {
                Toast.fire({
                    icon: 'error',
                    title: 'Masukan jumlah pembayaran'
                });
            } else if (parseFloat(bayar) < parseFloat(total)) {

                Toast.fire({
                    icon: 'warning',
                    title: 'Jumlah uang belum mencukupi'
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

                        if (response.title) {
                            $("#modalPembayaran").modal('hide');
                            Swal.fire({
                                title: response.title + ' ' + response.jumlah,
                                text: '',
                                icon: 'success',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                cancelButtonText: 'Lanjut Transaksi',
                                confirmButtonText: 'Cetak Struk',
                                allowOutsideClick: false
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $.ajax({
                                        type: "post",
                                        url: "<?= base_url('penjualan/cetakstruk') ?>",
                                        data: {
                                            faktur: response.faktur
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

    function kembali() {
        let bayar = $("#bayar").val();
        let total = $("#total").val();
        let kembali = parseFloat(bayar) - parseFloat(total);
        $("#kembalian").val(kembali);
        $("#kembalian").val();
    }

    function kembalian() {
        let bayar = $("#bayar").autoNumeric('get');
        let total = $("#total").autoNumeric('get');
        let kembali = parseFloat(bayar) - parseFloat(total);
        $("#kembalian").val(kembali);
        let kembalian = $("#kembalian").val();
        if (kembalian >= 0) {
            $(".label-kurleb").text('Kembalian')
            $("#kembalian").removeClass("text-danger")
            $("#kembalian").addClass("text-success")
        }
        if (kembalian < 0) {
            $(".label-kurleb").text('Kekurangan')
            $("#kembalian").removeClass("text-success")
            $("#kembalian").addClass("text-danger")
        }
        $("#kembalian").autoNumeric('set', kembalian);
    }
</script>