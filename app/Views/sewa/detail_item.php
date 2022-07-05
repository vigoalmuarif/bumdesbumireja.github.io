<?php if (isset($id)) : ?>
    <div class="table-responsive mt-2 mb-3">
        <table class="table">
            <thead>
                <tr>
                    <th>Kode Property</th>
                    <th>Jenis</th>
                    <th>Jangka</th>
                    <th>Harga (Rp)</th>
                    <th>Fasilitas</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?= $kode ?></td>
                    <td><?= $jenis ?></td>
                    <td><?= $jangka ?> Tahun</td>
                    <td><?= number_format($harga, 0, ",", ",") ?></td>
                    <td><?= $fasilitas ?></td>
                    <td>
                        <button type="button" class="btn btn-info btn-sm detailProperty" id="detailProperty">Detail</button>
                    </td>
                </tr>

            </tbody>
        </table>
    </div>
    <hr class="mt-2 mb-5">

    <form action="<?= base_url('persewaan/pembayaran') ?>" method="post" id="formSewa">
        <div class="row">
            <input type="hidden" name="pedagang_id" id="pedagangId" value="<?= $pedagang_id ?>">
            <input type="hidden" name="property_id" id="propertyId" value="<?= $id ?>">
            <input type="hidden" name="harga" id="harga" value="<?= $harga ?>">
            <div class="col col-md-6">
                <div class="form-group">
                    <label for="">Faktur</label>
                    <input type="text" class="form-control" name="faktur" id="faktur" value="<?= $faktur ?>" readonly>
                </div>
            </div>
            <div class="col col-md-6">
                <div class="form-group">
                    <label for="">Operator</label>
                    <input type="text" class="form-control" name="operator" id="operator" value="<?= $user['username']; ?>" readonly>
                </div>
            </div>
            <div class=" col col-md-6">
                <div class="form-group">
                    <label for="">Tanggal Sewa</label>
                    <input type="hidden" id="altSewa" name="altSewa">
                    <input type="text" class="form-control" name="tanggal_sewa" id="tanggal_sewa" autocomplete="off" readonly>
                </div>
            </div>
            <div class="col col-md-6">
                <div class="form-group">
                    <label for="">Tanggal Selesai</label>
                    <input type="hidden" id="altSelesai" name="altSelesai">
                    <input type="hidden" id="tempo" name="tempo">
                    <input type="text" class="form-control" name="tanggal_selesai" id="tanggal_selesai" autocomplete="off" readonly>
                </div>
            </div>
            <div class="col col-md-6">
                <div class="form-group">
                    <label for="jenis_pembayaran">Jenis Pembayaran</label>
                    <select class="form-control" id="jenisPembayaran" name="jenis_pembayaran">
                        <option value="" selected disabled hidden>--Pilih--</option>
                        <option value="Tunai">Tunai</option>
                        <option value="Kredit">Kredit</option>
                    </select>
                </div>
            </div>
            <div class="col col-md-6">
                <div class="form-group">
                    <label for="metode_pembayaran">Metode Pembayaran</label>
                    <select class="form-control" id="metodePembayaran" name="metode_pembayaran">
                        <option value="" selected disabled hidden>--Pilih--</option>
                        <option value="Transfer">Transfer</option>
                        <option value="Tunai">Tunai</option>
                    </select>
                </div>
            </div>
            <div class="col mt-3 mb-3">
                <button type="submit" class="btn  btn-primary">Bayar</button>
            </div>
        </div>

    </form>
    <div class="detail-property" style="display: none;"></div>
    <div class="modal-pembayaran" style="display: none;"></div>

    <script>
        // function tanggalSelesai() {
        //     var sewa = $("#tanggal_sewa").datepicker('getDate');
        //     var date = sewa.getDate();
        //     var month = sewa.getMonth();
        //     var year = sewa.getFullYear();
        //     var tempo = parseFloat($("#tempo").val());
        //     var tanggal = new Date(year + tempo, month, date);
        //     $("#tanggal_selesai").datepicker("setDate", tanggal);
        // }
        $(document).ready(function() {
            $("#detailProperty").click(function(e) {
                e.preventDefault();
                $.ajax({
                    type: "get",
                    url: "<?= base_url('persewaan/detail_property') ?>",
                    data: {
                        id: "<?= $id ?>"
                    },
                    dataType: "json",
                    success: function(response) {
                        $(".detail-property").html(response.view).show();
                        $("#modalDetailProperty").modal('show');
                    }
                });

            });

            $("#formSewa").submit(function(e) {
                e.preventDefault();
                $.ajax({
                    type: "post",
                    url: $(this).attr('action'),
                    data: $(this).serialize(),
                    dataType: "json",
                    success: function(response) {
                        if (response.status) {
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
                                html: response.status
                            })
                        } else {
                            $(".modal-pembayaran").html(response.view).show();
                            $("#modalPembayaran").modal('show');

                        }
                    },
                    error: function(xhr, thrownError) {
                        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                    }
                });
            })

            $("#tanggal_sewa").on('change', function() {
                var sewa = $("#tanggal_sewa").datepicker('getDate');
                var date = sewa.getDate();
                var month = sewa.getMonth();
                var year = sewa.getFullYear();
                var tempo = parseFloat(<?= $jangka ?>);
                var tanggal = new Date(year + tempo, month, date);
                $("#tanggal_selesai").datepicker("setDate", tanggal);

            })

            $("#tanggal_sewa").datepicker({
                altField: "#altSewa",
                altFormat: "yy-mm-dd",
                changeYear: true,
                changeMonth: true,
                dateFormat: "DD, dd MM yy",
                monthNames: ["Januari", "Februari", "Mart", "April", "Mai", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"],
                dayNames: ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"],
                dayNamesMin: ["Ming", "Sen", "Sel", "Rab", "Kam", "Jum", "Sab"],
                yearRange: "c-50:c+50"
            });
            // $("#tanggal_sewa").datepicker().datepicker('setDate', 'today');
            $("#tanggal_selesai").datepicker({
                altField: "#altSelesai",
                altFormat: "yy-mm-dd",
                changeYear: true,
                changeMonth: true,
                dateFormat: "DD, dd MM yy",
                monthNames: ["Januari", "Februari", "Mart", "April", "Mai", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"],
                dayNames: ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"],
                dayNamesMin: ["Ming", "Sen", "Sel", "Rab", "Kam", "Jum", "Sab"],
                yearRange: "c-50:c+50"
            });
        });
    </script>
<?php endif ?>