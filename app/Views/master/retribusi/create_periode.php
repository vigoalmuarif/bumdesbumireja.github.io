<!-- Modal -->

<form action="<?= base_url('retribusi/createPeriodeRetribusi') ?>" method="post" id="formAddPeriodeRetribusi">
    <div class="modal fade" id="createPeriodeRetribusi" tabindex="-1" aria-labelledby="createPeriodeRetribusiLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createPeriodeRetribusiLabel">Tambah Periode / Tagihan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            <div class="alert alert-success" role="alert">
                                <h4 class="alert-heading">Perhatian!</h4>
                                <p>Periode atau tagihan yang dibuat berdasarkan data retribusi yang aktif dan pastikan di setiap retribusi ada petugasnya. </p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="card mb-5">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <label for="" class="text-dark"><strong>Tanggal Retribusi</strong></label>
                                            <input type="hidden" name="alternatif" id="alternatif" value="">
                                            <div class="input-group mb-2">
                                                <input type="text" class="form-control" id="tanggal" name="tanggal" autocomplete="off">
                                                <div class="invalid-feedback error-tanggal">

                                                </div>
                                            </div>
                                        </div>
                                        <div id="datepicker"></div>
                                        <div class="col-md-5">
                                            <button type="submit" class="btn btn-primary btn-tambah">Buat tagihan baru</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    $("#formAddPeriodeRetribusi").submit(function(e) {
        e.preventDefault();
        let tanggal = $("#tanggal").val();
        $.ajax({
            type: "post",
            url: $(this).attr('action'),
            data: $(this).serialize(),
            dataType: "json",
            success: function(response) {
                if (response.error) {
                    if (response.error.tanggal) {
                        $("#tanggal").addClass('is-invalid');
                        $(".error-tanggal").html(response.error.tanggal);
                    } else {
                        $("#tanggal").removeClass('is-invalid');
                        $(".error-tanggal").html('');
                    }
                    if (response.error.alternatif) {
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
                            icon: 'error',
                            html: response.error.alternatif,
                        })
                    }

                } else if (response.msg) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        html: Response.msg,
                    })
                } else {
                    $("#createPeriodeRetribusi").modal('hide');
                    $('#createPeriodeRetribusi').on('hidden.bs.modal', function(event) {
                        dataPeriode();
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
                            icon: 'success',
                            title: 'Tagihan baru berhasil dibuat'
                        })
                    })

                }
            },
            error: function(xhr, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    });



    $(document).ready(function() {
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
    })
</script>