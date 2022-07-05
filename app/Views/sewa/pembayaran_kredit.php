<!-- Modal -->

<div class="modal fade" id="modalPembayaran" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modalPembayaranLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalPembayaranLabel">Pembayaran Sewa (Kredit)</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('persewaan/simpan_pembayaran') ?>" method="post" id="formPembayaran" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" name="no_transaksi" id="noTransaksi" value="<?= $faktur ?>">

                        <input type="hidden" name="tanggal_sewa" id="tanggalSewa" value="<?= $tanggal_sewa ?>">

                        <input type="hidden" name="tanggal_selesai" id="tanggalSelesai" value="<?= $tanggal_selesai ?>">

                        <input type="hidden" name="pedagang_id" id="pedagangId" value="<?= $pedagang_id ?>">

                        <input type="hidden" name="property_id" id="propertyId" value="<?= $property_id ?>">

                        <input type="hidden" name="jenis_pembayaran" id="jenisPembayaran" value="<?= $jenis_pembayaran ?>">

                        <input type="hidden" name="metode_pembayaran" id="metodePembayaran" value="<?= $metode_pembayaran ?>">

                        <input type="hidden" name="harga" id="harga" value="<?= $harga ?>">

                        <label for=""><strong>Harga Sewa (Rp)</strong></label>
                        <input type="text" class="form-control form-control-lg font-weight-bold text-primary" value="<?= $harga ?>" readonly id="total" name="total">
                    </div>
                    <div class="form-group">
                        <label for=""><strong>Uang Muka (Rp)</strong></label>
                        <input type="text" class="form-control form-control-lg font-weight-bold" name="bayar" value="0" onfocus="(this).select();" id="bayar" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for=""><strong>Kekurangan (Rp)</strong></label>
                        <input type="text" class="form-control form-control-lg font-weight-bold" name="kekurangan" id="kekurangan" autocomplete="off" readonly>
                    </div>
                    <div class="form-group bukti">
                        <label for=""><strong>Bukti Pembayaran</strong></label>
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
                    <button type="submit" class="btn btn-success simpanPembayaran">Bayar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function kekurangan() {
        let bayar = $("#bayar").autoNumeric('get');
        let total = $("#total").autoNumeric('get');
        let nilai = parseFloat(total) - parseFloat(bayar);
        let kekurangan = $("#kekurangan").val(nilai);
        let hasil = $("#kekurangan").val();
        $("#kekurangan").autoNumeric('set', hasil);

    }
    $(document).ready(function() {
        var metode_bayar = $("#metodePembayaran").val();
        if (metode_bayar == "Tunai") {
            $(".bukti").prop('hidden', true);
        }
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

        $("#bayar").keyup(function(e) {
            e.preventDefault();
            kekurangan();
        });


        $("#formPembayaran").submit(function(e) {
            let bayar = $("#bayar").autoNumeric('get');
            let total = $("#total").autoNumeric('get');

            if (bayar == 0 || bayar == "") {
                Toast.fire({
                    icon: 'error',
                    title: 'Masukan jumlah pembayaran'
                });
            } else if (parseFloat(bayar) >= parseFloat(total)) {

                Toast.fire({
                    icon: 'warning',
                    title: 'Jumlah uang harus lebih kecil sama dengan dari harga property'
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
                        $(".simpanPembayaran").html('Menyimpan');
                    },
                    success: function(response) {
                        if (response.error) {
                            if (response.error.bukti) {
                                $("#bukti").addClass('is-invalid');
                                $(".error-bukti").html(response.error.bukti);
                            } else {
                                $("#bukti").removeClass('is-invalid');
                                $(".error-bukti").html('');
                            }
                        }

                        if (response.status == 'sukses') {
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

                                    var print = window.open("<?= base_url('export/print/' . $faktur) ?>");
                                    print.print();
                                    window.location.href = "<?= base_url('persewaan/index') ?>";
                                } else {
                                    window.location.href = "<?= base_url('persewaan/index') ?>";
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
</script>