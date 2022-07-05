<!-- Modal -->
<form action="<?= base_url('operasional/save') ?>" method="post" id="save">
    <div class="modal fade" id="addPemasukan" tabindex="-1" aria-labelledby="addPemasukanLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addPemasukanLabel">Tambah Pemasukan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col mx-auto">
                            <input type="hidden" name="type" id="type" value="in">
                            <div class="form-group ">
                                <label for="">Hari/Tanggal</label>
                                <input type="hidden" name="alternatif" id="alternatif">
                                <input type="text" class="form-control" name="tanggal" id="tanggal">
                                <div class="invalid-feedback invalid-tanggal">

                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="">Nominal</label>
                                <div class="input-group has-validation">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Rp</span>
                                    </div>
                                    <input type="text" class="form-control font-weight-bold" name="jumlah" id="jumlah" autocomplete="off">
                                    <div class="invalid-feedback invalid-jumlah">

                                    </div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="jenis">Pemasukan</label>
                                <select class="custom-select" id="jenis" name="jenis" aria-describedby="jenisFeedback">
                                    <option value="" disabled selected hidden>--pilih--</option>
                                    <option>Umum</option>
                                    <option>Pasar</option>
                                    <option>ATK</option>
                                </select>
                                <div id="jenisFeedback" class="invalid-feedback invalid-jenis">

                                </div>
                            </div>
                            <div class="form-group">
                                <label for="keterangan">Keterangan</label>
                                <textarea class="form-control" id="keterangan" name="keterangan" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="submit">Simpan</button>
                </div>
            </div>
        </div>
    </div>
</form>



<script>
    $(document).ready(function() {
        $("#save").submit(function(e) {
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
                        $("#addPemasukan").modal('hide');
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
        $("#tanggal").datepicker().datepicker('setDate', 'today');
    })
</script>