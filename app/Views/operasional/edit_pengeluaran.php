<!-- Modal -->
<form action="<?= base_url('operasional/update_pengeluaran') ?>" method="post" id="edit">
    <div class="modal fade" id="editPengeluaran" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="editPengeluaranLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPengeluaranLabel">Ubah Pengeluaran</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col mx-auto">
                            <input type="hidden" name="id" id="id" value="<?= $pengeluaran['id'] ?>">
                            <div class="form-group ">
                                <label for="">Hari/Tanggal</label>
                                <input type="hidden" name="alternatif" id="alternatif">
                                <input type="text" class="form-control" name="tanggal" id="tanggal">
                                <div class="invalid-feedback invalid-tanggal">

                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="">Jumlah</label>
                                <div class="input-group has-validation">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Rp</span>
                                    </div>
                                    <input type="text" class="form-control font-weight-bold" name="jumlah" id="jumlah" autocomplete="off" value="<?= $pengeluaran['jumlah'] ?>">
                                    <div class="invalid-feedback invalid-jumlah">

                                    </div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="jenis">pengeluaran</label>
                                <select class="custom-select" id="jenis" name="jenis" aria-describedby="jenisFeedback">
                                    <option value="" disabled selected hidden>--pilih--</option>
                                    <option value="Umum" <?= $pengeluaran['unit'] == "Umum" ? "selected='selected'" : '' ?>>Umum</option>
                                    <option value="Pasar" <?= $pengeluaran['unit'] == "Pasar" ? "selected='selected'" : '' ?>>Pasar</option>
                                    <option value="ATK" <?= $pengeluaran['unit'] == "ATK" ? "selected='selected'" : '' ?>>ATK</option>
                                </select>
                                <div id="jenisFeedback" class="invalid-feedback invalid-jenis">

                                </div>
                            </div>
                            <div class="form-group">
                                <label for="keterangan">Keterangan</label>
                                <textarea class="form-control" id="keterangan" name="keterangan" rows="3"><?= $pengeluaran['keterangan'] ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="submit">Ubah</button>
                </div>
            </div>
        </div>
    </div>
</form>



<script>
    $(document).ready(function() {
        $("#edit").submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: "post",
                url: $(this).attr('action'),
                data: $(this).serialize(),
                dataType: "json",
                success: function(response) {
                    if (response.error) {
                        if (response.error.tanggal) {
                            $("#tanggal").addClass('is-invalid');
                            $(".invalid-tanggal").html(response.error.tanggal)
                        } else {
                            $("#tanggal").removeClass('is-invalid');
                            $(".invalid-tanggal").html('');
                        }
                        if (response.error.jumlah) {
                            $("#jumlah").addClass('is-invalid');
                            $(".invalid-jumlah").html(response.error.jumlah)
                        } else {
                            $("#jumlah").removeClass('is-invalid');
                            $(".invalid-jumlah").html('');
                        }
                        if (response.error.jenis) {
                            $("#jenis").addClass('is-invalid');
                            $(".invalid-jenis").html(response.error.jenis)
                        } else {
                            $("#jenis").removeClass('is-invalid');
                            $(".invalid-jenis").html('');
                        }
                    } else {
                        window.location.reload();
                        $("#editPengeluaran").modal('hide');
                    }
                },
                error: function(xhr, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        })



        $("#jumlah").autoNumeric('init', {
            aSep: ',',
            aDec: '.',
            mDec: '0',
        });

        $("#tanggal").datepicker({
            altField: "#alternatif",
            altFormat: "yy-mm-dd",
            changeYear: true,
            changeMonth: true,
            dateFormat: "DD, dd MM yy",
            monthNames: ["Januari", "Februari", "Mart", "April", "Mai", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"],
            dayNames: ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"],
            dayNamesMin: ["Ming", "Sen", "Sel", "Rab", "Kam", "Jum", "Sab"],
            yearRange: "c-5:c+5"
        });
        let date = "<?= date('Y-m-d', strtotime($pengeluaran['date'])) ?>";
        let newdate = new Date(date);

        $("#tanggal").datepicker().datepicker('setDate', newdate);
    })
</script>