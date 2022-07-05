<!-- Modal -->

<form action="<?= base_url('persewaan/simpan_pelunasan') ?>" method="post" id="formPembayaran" enctype="multipart/form-data">
    <div class="modal fade" id="modalPelunasanSewa" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modalPelunasanSewaLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalPelunasanSewaLabel">Pembayaran Sewa (Kredit)</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-borderless">
                            <tbody>
                                <tr>
                                    <td>No Transaksi</td>
                                    <td>:</td>
                                    <td><?= $sewa['faktur'] ?></td>
                                </tr>

                                <tr>
                                    <td>Harga</td>
                                    <td>:</td>
                                    <td>Rp <?= number_format($sewa['harga_sewa'], "0", ",", ",") ?></td>
                                </tr>
                                <tr>
                                    <td>Terbayar</td>
                                    <td>:</td>
                                    <td>Rp <?= number_format($sewa['total_bayar'], "0", ",", ",") ?></td>
                                </tr>
                                <?php $kekurangan =  $sewa['harga_sewa'] - $sewa['total_bayar'] ?>

                            </tbody>
                        </table>
                        <hr class="sidebar-divider  d-none d-md-block">
                    </div>
                    <input type="hidden" value="<?= $sewa['faktur'] ?>" id="faktur" name="faktur">
                    <input type="hidden" value="<?= $sewa['id_sewa'] ?>" id="sewaId" name="sewaId">
                    <input type="hidden" value="<?= $sewa['total_bayar'] ?>" id="bayarOld" name="bayarOld">
                    <input type="hidden" value="<?= $kekurangan; ?>" id="kekuranganOld" name="kekuranganOld">
                    <div class="form-group">
                        <label for=""><strong>Bayar (Rp)</strong></label>
                        <input type="text" class="form-control form-control-lg font-weight-bold" name="bayar" onfocus="(this).select();" id="bayar" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="" class="label-kurleb"><strong>Kekurangan (Rp)</strong></label>
                        <input type="text" class="form-control text-danger form-control-lg font-weight-bold" name="kekurangan" id="kekurangan" autocomplete="off" value="<?= $kekurangan ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Metode pembayaran</label>
                        <select class="form-control" id="metode" name="metode" required>
                            <option value="" disabled hidden selected>--Pilih--</option>
                            <option value="Tunai">Tunai</option>
                            <option value="Transfer">Transfer</option>
                        </select>
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
            </div>
        </div>
    </div>
</form>

<script>
    function kekurangan() {
        let bayar = $("#bayar").autoNumeric('get');
        let kekurangan_sebelumnya = <?= $kekurangan; ?>;
        if (parseFloat(bayar) > parseFloat(kekurangan_sebelumnya)) {
            let nilai = parseFloat(bayar) - parseFloat(kekurangan_sebelumnya);
            let kekurangan = $("#kekurangan").val(nilai);
            let hasil = $("#kekurangan").val();
            $(".label-kurleb").html('<strong>Kembalian (Rp)</strong>');
            $("#kekurangan").removeClass('text-danger');
            $("#kekurangan").addClass('text-success');
            $("#kekurangan").autoNumeric('set', hasil);
        } else {

            let nilai = parseFloat(kekurangan_sebelumnya) - parseFloat(bayar);
            let kekurangan = $("#kekurangan").val(nilai);
            let hasil = $("#kekurangan").val();
            $(".label-kurleb").html('<strong>Kekurangan (Rp)</strong>');
            $("#kekurangan").removeClass('text-success');
            $("#kekurangan").addClass('text-danger');
            $("#kekurangan").autoNumeric('set', hasil);
        }

    }
    $(document).ready(function() {
        $(".bukti").prop('hidden', true);
        $("#metode").change(function(e) {
            e.preventDefault();
            var metode = $("#metode").val();
            if (metode == "Tunai") {
                $(".bukti").prop('hidden', true);
                $("#bukti").val('');
                $("#bukti").removeClass('is-invalid');
                $(".error-bukti").html('');
            } else {
                $(".bukti").prop('hidden', false);
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
            let kekurangan = <?= $kekurangan; ?>;
            var id = $("#sewaId").val();

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
                            $("#modalPelunasanSewa").modal('hide');
                            $('#modalPelunasanSewa').on('hidden.bs.modal', function(event) {
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
                                        var print = window.open("<?= base_url('export/print/' . $sewa['faktur']) ?>");
                                        print.print();
                                        Swal.fire({
                                            position: 'top-end',
                                            icon: 'success',
                                            title: 'Pembayaran berhasil',
                                            showConfirmButton: false,
                                            timer: 1500
                                        })
                                        berlangsung();
                                    } else {
                                        berlangsung();

                                    }
                                })
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