<!-- Modal -->
<form action="<?= base_url('persewaan/update_nominal_tagihan') ?>" method="post" id="formUbahNominalTagihan" enctype="multipart/form-data">
    <div class="modal fade" id="modalUbahNominalTagihanBulanan" tabindex="-1" aria-labelledby="modalUbahNominalTagihanBulananLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalUbahNominalTagihanBulananLabel">Ubah Nominal Pembayaran</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            <input type="hidden" name="bayar_old" id="bayar_old" value="<?= $tagihan['bayar'] ?>">
                            <input type="hidden" name="id" id="id" value="<?= $tagihan['transaksiId'] ?>">
                            <input type="hidden" name="tagihanId" id="tagihanId" value="<?= $tagihan['tagihanId'] ?>">
                            <input type="hidden" name="bayarOld" id="bayrOld" value="<?= $tagihan['bayar'] ?>">
                            <input type="hidden" name="gambarOld" id="gambarOld" value="<?= $tagihan['bukti'] ?>">
                            <div class="form-group">
                                <label for="">Nama Pedagang</label>
                                <input type="text" class="form-control" name="pedagang" id="pedagang" value="<?= $tagihan['pedagang'] ?>" readonly>
                            </div>
                            <div class="form-row">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="">Periode</label>
                                        <input type="text" class="form-control" name="periode" id="periode" value="<?= bulan_tahun($tagihan['periode']) ?>" readonly>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label for="">Waktu Bayar</label>
                                        <input type="text" class="form-control" name="waktu" id="waktu" value="<?= date(('d-m-Y H:i'), strtotime($tagihan['waktuBayar'])) ?>" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="">Bayar (Rp)</label>
                                <input type="text" class="form-control form-control-lg" name="bayar" id="bayar" value="<?= $tagihan['bayar'] ?>" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label for="metode">Metode</label>
                                <select class="form-control" id="metode" name="metode">
                                    <option value="Tunai" <?= $tagihan['metode'] == 'Tunai' ? 'selected="selected"' : ''; ?>>Tunai</option>
                                    <option value="Transfer" <?= $tagihan['metode'] == 'Transfer' ? 'selected="selected"' : ''; ?>>Transfer</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="keterangan">Keterangan</label>
                                <textarea class="form-control" name="keterangan" id="keterangan" rows="2"><?= $tagihan['desc'] ?></textarea>
                            </div>

                            <div class="form-group bukti">
                                <label for="">Bukti Pembayaran</label>
                                <input class="form-control-file" type="file" name="bukti" id="bukti">
                                <div class="invalid-feedback error-bukti">

                                </div>
                                <small class="text-muted">Format Gambar: jpg, jpeg, png. Ukuran Maks. 5Mb</small>
                            </div>

                            <?php if ($tagihan['bukti'] != NULL) : ?>
                                <div class="col-md-3 mb-3 foto-bukti">
                                    <img src="/img/upload/<?= $tagihan['bukti']; ?>" class="img-thumbnail" alt="">
                                </div>
                            <?php endif ?>


                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Ubah</button>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    function bukti() {
        var metode = $("#metode").val();
        if (metode == 'Transfer') {
            $(".bukti").prop('hidden', false);
        } else {
            $(".bukti").prop('hidden', true);
        }
    }
    $(document).ready(function() {
        bukti();

        $("#metode").on('change', function(e) {
            e.preventDefault();
            var metode = $("#metode").val();
            if (metode == 'Transfer') {
                $(".bukti").prop('hidden', false);
                $(".foto-bukti").prop('hidden', false);
            } else {
                $(".bukti").prop('hidden', true);
                $("#bukti").val('');
                $(".error-bukti").html('');
                $(".foto-bukti").prop('hidden', true);
            }
        })


        $("#formUbahNominalTagihan").submit(function(e) {
            e.preventDefault();
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
                    if (response.sukses) {
                        $("#modalUbahNominalTagihanBulanan").modal('hide');
                        $('#modalUbahNominalTagihanBulanan').on('hidden.bs.modal', function(event) {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: 'Pembayaran berhasil diubah',
                                showConfirmButton: false,
                                timer: 1500
                            });
                            tagihanBulanan();
                        })
                    }
                },
                error: function(xhr, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }

            });
        })
        $("#bayar").autoNumeric('init', {
            aSep: ',',
            aDec: '.',
            mDec: '0',
        });
    })
</script>