<!-- Modal -->
<form action="<?= base_url('persewaan/simpan_pembayaran') ?>" method="post" id="formPembayaran" enctype="multipart/form-data">

    <div class="modal fade" id="modalPembayaranTagihanBulanan" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modalPembayaranTagihanBulananLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalPembayaranTagihanBulananLabel">Periode <?= bulan_tahun($tagihan['periode']) ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="tagihanID" id="tagihanID" value="<?= $tagihan['tagihanId'] ?>">
                    <input type="hidden" name="sewa_id" id="sewaId" value="<?= $tagihan['sewa_id'] ?>">
                    <input type="hidden" name="periode_id" id="periodeId" value="<?= $tagihan['periode_id'] ?>">
                    <input type="hidden" name="bayar_old" id="bayarOld" value="<?= $bayar_old ?>">
                    <div class="form-group">
                        <label for=""><strong>Tagihan</strong></label>
                        <input type="text" class="form-control form-control-lg font-weight-bold text-danger" value="<?= $tagihan['tarif'] ?>" onclick="this.select();" id="tarif" name="tarif" readonly>
                    </div>
                    <div class="form-group">
                        <label for=""><strong>Bayar (Rp)</strong></label>
                        <input type="text" class="form-control form-control-lg font-weight-bold text-primary" id="bayarTagihan" name="bayar" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="" id="labelkurleb"><strong>Kekurangan (Rp)</strong></label>
                        <input type="text" class="form-control form-control-lg font-weight-bold text-danger" value="<?= $tagihan['tarif'] - $tagihan['bayar']  ?>" onclick="this.select();" id="kekurangan" name="kekurangan" readonly>
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Metode</label>
                        <select class="form-control" id="metode" name="metode">
                            <option value="" selected hidden disabled>--Pilih--</option>
                            <option value="Tunai">Tunai</option>
                            <option value="Transfer">Transfer</option>
                        </select>
                    </div>

                    <div class="form-group bukti">
                        <label for="">Bukti Pembayaran</label>
                        <input class="form-control-file" type="file" name="bukti" id="bukti">
                        <div class="invalid-feedback error-bukti">

                        </div>
                        <small class="text-muted">Format Gambar: jpg, jpeg, png. Ukuran Maks. 5Mb</small>
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Keterangan</label>
                        <textarea class="form-control" id="keterangan" name="keterangan" rows="2"></textarea>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success simpan-pembayaran-tagihan">Bayar</button>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    $(document).ready(function() {
        $(".bukti").prop('hidden', true);

        $("#metode").on('change', function(e) {
            e.preventDefault();
            var metode = $("#metode").val();
            if (metode == "Transfer") {
                $(".bukti").prop('hidden', false);
            } else if (metode == "Tunai") {
                $(".bukti").prop('hidden', true);
                $("#bukti").val('');
                $(".error-bukti").html('');
            }
        });
        $("#formPembayaran").submit(function(e) {
            e.preventDefault();
            let bayar = $("#bayarTagihan").autoNumeric('get');
            let metode = $("#metode").val();
            let id = "<?= $tagihan['tagihanId']; ?>";

            if (bayar < 1 || bayar.length == 0) {
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
                    title: 'Nominal pembayaran harus diisi'
                });

            } else if (metode == null) {
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
                    title: 'metode pembayaran harus diisi'
                });
            } else {
                var i = new FormData(this);
                $.ajax({
                    type: "post",
                    url: "<?= base_url('persewaan/simpan_pembayaran_tagihan') ?>",
                    data: i,
                    processData: false,
                    contentType: false,
                    dataType: "json",
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
                            $("#modalPembayaranTagihanBulanan").modal('hide');
                            $('#modalPembayaranTagihanBulanan').on('hidden.bs.modal', function(event) {
                                Swal.fire({
                                    position: 'top-end',
                                    icon: 'success',
                                    title: 'Pembayaran berhasil disimpan',
                                    showConfirmButton: false,
                                    timer: 1500
                                });

                                tagihanBulanan();
                            });
                        }
                    },
                    error: function(xhr, thrownError) {
                        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                    }
                });
            }
        })

        $("#bayarTagihan").keyup(function(e) {
            e.preventDefault();
            let bayar = $("#bayarTagihan").autoNumeric('get');
            let totalBayar = "<?= $tagihan['tarif'] - $tagihan['bayar'] ?>";
            let kekurangan = parseFloat(totalBayar) - parseFloat(bayar);
            let a = $("#kekurangan").val(kekurangan);
            // $("#kekurangan").val();
            let kembalian = parseFloat(bayar) - parseFloat(totalBayar);
            if (bayar.length == 0) {
                $("#kekurangan").autoNumeric('set', totalBayar);
            } else {

                if (kekurangan < 0) {
                    $("#labelkurleb").html('<strong>Kelebihan (Rp)</strong>');
                    $("#kekurangan").autoNumeric('set', kembalian);
                    $("#kekurangan").removeClass('text-danger');
                    $("#kekurangan").addClass('text-success');
                } else {
                    $("#kekurangan").autoNumeric('set', kekurangan);
                    $("#labelkurleb").html('<strong>Kekurangan (Rp)</strong>');
                    $("#kekurangan").removeClass('text-success');
                    $("#kekurangan").addClass('text-danger');

                }
            }
        })

        $("#tarif").autoNumeric('init', {
            aSep: ',',
            aDec: '.',
            mDec: '0',
        });
        $("#bayarTagihan").autoNumeric('init', {
            aSep: ',',
            aDec: '.',
            mDec: '0',
        });
        $("#kekurangan").autoNumeric('init', {
            aSep: ',',
            aDec: '.',
            mDec: '0',
        });
    });
</script>