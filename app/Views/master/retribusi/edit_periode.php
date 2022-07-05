<!-- Modal -->
<form action="<?= base_url('retribusi/update_periode') ?>" method="post" id="formEditPeriode">
    <div class="modal fade" id="modalEditPeriode" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modalEditPeriodeLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditPeriodeLabel">Ubah Periode</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" name="periodeId" id="periodeId" value="<?= $periode['id'] ?>">
                        <input type="hidden" name="periodeOld" id="periodeOld" value="<?= $periode['tanggal'] ?>">
                        <input type="hidden" name="alternatifEdit" id="alternatifEdit" value="<?= $periode['tanggal'] ?>">
                        <label for="">Periode Retribusi</label>
                        <input type="text" class="form-control" name="periode" id="periode" value="<?= longdate_indo($periode['tanggal']) ?>" readonly>
                        <div class="invalid-feedback error-periode">

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
    $(document).ready(function() {

        $("#formEditPeriode").submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: "post",
                url: $(this).attr('action'),
                data: $(this).serialize(),
                dataType: "json",
                success: function(response) {
                    if (response.error) {
                        if (response.error.periode) {
                            $("#periode").addClass('is-invalid');
                            $(".error-periode").html(response.error.periode);
                        } else {
                            $("#periode").removeClass('is-invalid');
                            $(".error-periode").html('');
                        }
                        if (response.error.alternatifEdit) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                html: response.error.alternatifEdit,
                            })
                        }
                    } else if (response.sama) {
                        $("#modalEditPeriode").modal('hide');

                    } else {
                        $("#modalEditPeriode").modal('hide');
                        $('#modalEditPeriode').on('hidden.bs.modal', function(event) {
                            dataPeriode();
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 5000,
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                    toast.addEventListener('mouseenter', Swal.stopTimer)
                                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                                }
                            })

                            Toast.fire({
                                icon: 'success',
                                html: `Periode berhasil diubah.`
                            })
                        })
                    }
                },
                error: function(xhr, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        });


        $("#periode").datepicker({
            altField: "#alternatifEdit",
            altFormat: "yy-mm-dd",
            changeYear: true,
            changeMonth: true,
            dateFormat: "DD, dd MM yy",
            monthNames: ["Januari", "Februari", "Mart", "April", "Mai", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"],
            dayNames: ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"],
            dayNamesMin: ["Ming", "Sen", "Sel", "Rab", "Kam", "Jum", "Sab"],
            yearRange: "c-5:c+5"
        });

    });
</script>