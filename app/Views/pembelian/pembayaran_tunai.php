<!-- Modal -->

<form action="<?= base_url('pembelian/simpan_pembayaran') ?>" method="post" id="formPembayaran" enctype="multipart/form-data">
    <div class="modal fade" id="modalPembayaranTunai" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modalPembayaranTunaiLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalPembayaranTunaiLabel">Pembayaran</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" name="faktur" id="faktur" value="<?= $faktur ?>">
                        <input type="hidden" name="tanggal" id="tanggal" value="<?= $created_at ?>">
                        <input type="hidden" name="supplier" id="supplier" value="<?= $supplier_id ?>">
                        <input type="hidden" name="pembayaran" id="pembayaran" value="<?= $pembayaran ?>">
                        <input type="hidden" name="referensi" id="referensi" value="<?= $referensi ?>">
                        <label for=""><strong>Total Harga (Rp)</strong></label>
                        <input type="text" class="form-control form-control-lg font-weight-bold text-primary" value="<?= number_format($total['total'], 0, ",", ",") ?>" readonly id="total" name="total">

                    </div>
                    <div class="form-group">
                        <label for=""><strong>Diskon (Rp)</strong></label>
                        <input type="text" class="form-control form-control-lg font-weight-bold" value="0" onclick="this.select();" name="diskon" id="diskon" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for=""><strong>Jumlah Bayar (Rp)</strong></label>
                        <input type="hidden" name="altBayar" id="altBayar">
                        <input type="text" class="form-control form-control-lg font-weight-bold" value="" onclick="this.select();" name="bayar" id="bayar" autocomplete="off">
                        <div class="invalid-feedback error-bayar">

                        </div>
                    </div>
                    <div class="form-group">
                        <label for=""><strong>Bukti Pembelian</strong></label>
                        <input type="file" class="form-control-file" name="bukti" id="bukti">
                        <div class="invalid-feedback error-bukti">

                        </div>
                        <small class="text-muted">Format Gambar : jpg, jpeg, png. Ukuran maks. 5Mb</small>
                    </div>
                    <div class="form-group">
                        <label for=""><strong>Keterangan</strong></label>
                        <textarea type="text" class="form-control" rows="3" id="keterangan" name="keterangan"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success simpanPembayaran">Simpan</button>
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

        // $("#diskon").keyup(function(e) {
        //     e.preventDefault()
        //     var diskon = $("#diskon").autoNumeric('get');
        //     var total = $("#total").autoNumeric('get');
        //     if (diskon == 0 || '') {
        //         diskon = 0;
        //     }
        //     var bayar = parseInt(total - diskon);
        //     $("#bayar").autoNumeric('set', bayar);
        // })

        $("#diskon").autoNumeric('init', {
            aSep: ',',
            aDec: '.',
            mDec: '0',
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
        $("#bayar").keyup(function(e) {
            let bayar = $("#bayar").autoNumeric('get');
            $("#altBayar").val(bayar);
        });

        $("#formPembayaran").submit(function(e) {
            e.preventDefault();
            let total = $("#total").autoNumeric('get');
            let diskon = $("#diskon").autoNumeric('get');
            let bayar = $("#bayar").autoNumeric('get');
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
                    $(".simpanPembayaran").html('Simpan');
                },
                success: function(response) {
                    console.log(response);
                    if (response.error) {
                        if (response.error.bayar) {
                            $("#bayar").addClass('is-invalid');
                            $(".error-bayar").html(response.error.bayar);
                        } else {
                            $("#bayar").removeClass('is-invalid');
                            $(".error-bayar").html('');
                        }
                        if (response.error.bukti) {
                            $("#bukti").addClass('is-invalid');
                            $(".error-bukti").html(response.error.bukti);
                        } else {
                            $("#bukti").removeClass('is-invalid');
                            $(".error-bukti").html('');
                        }
                    } else {
                        $("#modalPembayaranTunai").modal('hide');
                        Swal.fire({
                            title: `Kembalian Rp ${response.kembalian}`,
                            text: '',
                            icon: 'success',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Cetak Struk',
                            cancelButtonText: 'Tidak',
                            allowOutsideClick: false
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $.ajax({
                                    type: "post",
                                    url: "<?= base_url('pembelian/cetakstruk') ?>",
                                    data: {
                                        faktur: response.data
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

            return false;

        });

    });

    // function kembalian() {
    //     let bayar = $("#bayar").autoNumeric('get');
    //     let total = $("#total").autoNumeric('get');
    //     let kembali = parseFloat(bayar) - parseFloat(total);
    //     $("#kembalian").val(kembali);
    //     let kembalian = $("#kembalian").val();
    //     if (kembalian >= 0) {
    //         $("#kembalian").removeClass("text-danger")
    //         $("#kembalian").addClass("text-success")
    //     }
    //     if (kembalian < 0) {
    //         $("#kembalian").removeClass("text-success")
    //         $("#kembalian").addClass("text-danger")
    //     }
    //     $("#kembalian").autoNumeric('set', kembalian);
    // }
</script>