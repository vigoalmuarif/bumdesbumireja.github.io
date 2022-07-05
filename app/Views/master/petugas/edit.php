<!-- Modal -->
<form action="<?= base_url('petugas/update') ?>" id="formUbah" method="post">
    <div class="modal fade" id="modalUbah" tabindex="-1" aria-labelledby="UbahLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="UbahLabel">Ubah Petugas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col">
                        <div class="form-group">
                            <label for="nik">NIK</label>
                            <div class="input-group">
                                <input type="hidden" name="old_nik" id="old_nik" value="<?= $pegawai['nik']  ?>">
                                <input type="hidden" name="id" id="id" value="<?= $pegawai['pegawaiID']  ?>">
                                <input type="number" class="form-control" value="<?= $pegawai['nik']  ?>" id="nik" placeholder="Masukan no KTP" name="nik">
                                <div class="invalid-feedback error-nik">

                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="nama">Nama Lengkap</label>
                            <input type="text" class="form-control" id="nama" value="<?= $pegawai['pegawai']  ?>" name="nama" placeholder="Masukan nama lengkap">
                            <div class="invalid-feedback error-nama">

                            </div>
                        </div>
                        <label for="nama">Jenis Kelamin</label>
                        <div class="form-group">
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="male" name="jenis_kelamin" class="custom-control-input jenis-kelamin" value="L" <?= $pegawai['jenis_kelamin'] == 'L' ? 'checked="checked"' : '' ?>>
                                <label class="custom-control-label" for="male">Laki-laki</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="female" name="jenis_kelamin" class="custom-control-input jenis-kelamin" value="P" <?= $pegawai['jenis_kelamin']  == 'P' ? 'checked="checked"' : '' ?>> <label class="custom-control-label" for="female">Perempuan</label>
                                <div class="invalid-feedback col error-jenis-kelamin">

                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="tempat_lahir">Tempat Lahir</label>
                            <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" value="<?= $pegawai['tempat_lahir']  ?>" aria-describedby="tempat_lahir" placeholder="Masukan tempat lahir">
                            <div class="invalid-feedback error-tempat-lahir">

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="tanggal_lahir">Tanggal Lahir</label>
                            <input type="hidden" name="altTL" id="altTL">
                            <input type="text" class="form-control" id="tanggal_lahir" name="tanggal_lahir" value="<?= $pegawai['tanggal_lahir']  ?>" placeholder="Masukan tanggal lahir" autocomplete="off">
                            <div class="invalid-feedback error-tanggal-lahir">

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <textarea type="text" class="form-control" id="alamat" name="alamat" placeholder="Masukan alamat"><?= $pegawai['alamat']  ?></textarea>
                            <div class="invalid-feedback error-alamat">

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="no_hp">No Telepon / WhatsApp</label>
                            <input type="text" class="form-control" id="no_hp" name="no_hp" value="<?= $pegawai['no_hp'] ?>" placeholder="Masukan no telp. atau whatsapp">
                            <div class="invalid-feedback error-no-hp">

                            </div>
                        </div>
                        <div class="form-group">

                            <label for="exampleFormControlSelect1">Jabatan</label>
                            <select class="form-control" name="jabatan" id="jabatan">
                                <option value="" disabled hidden selected>--Pilih---</option>

                                <?php foreach ($jabatan as $title) : ?>
                                    <option value="<?= $title['id'] ?>" <?= $pegawai['jabatanID']  == $title['id'] ? 'selected="selected"' : '' ?>><?= $title['nama'] ?></option>
                                <?php endforeach ?>

                            </select>
                            <div class="invalid-feedback error-jabatan">

                            </div>
                        </div>
                        <div class="form-group">

                            <label for="exampleFormControlSelect1">Status</label>
                            <select class="form-control" name="status" id="status">
                                <option value="1" <?= $pegawai['status']  == 1 ? 'selected="selected"' : '' ?>>Aktif</option>
                                <option value="0" <?= $pegawai['status']  == 0 ? 'selected="selected"' : '' ?>>Non-Aktif</option>
                            </select>
                            <div class="invalid-feedback error-jabatan">

                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Ubah</button>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    $(document).ready(function() {

        $("#formUbah").submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: "post",
                url: $(this).attr('action'),
                data: $(this).serialize(),
                dataType: "json",
                success: function(response) {
                    if (response.error) {
                        if (response.error.nama) {
                            $("#nama").addClass('is-invalid');
                            $(".error-nama").html(response.error.nama);
                        } else {
                            $("#nama").removeClass('is-invalid');
                            $(".error-nama").html('');
                        }
                        if (response.error.nik) {
                            $("#nik").addClass('is-invalid');
                            $(".error-nik").html(response.error.nik);
                        } else {
                            $("#nik").removeClass('is-invalid');
                            $(".error-nik").html('');
                        }
                        if (response.error.jenis_kelamin) {
                            $(".jenis-kelamin").addClass('is-invalid');
                            $(".error-jenis-kelamin").html(response.error.jenis_kelamin);
                        } else {
                            $(".jenis-kelamin").removeClass('is-invalid');
                            $(".error-jenis-kelamin").html('');
                        }
                        if (response.error.tempat_lahir) {
                            $("#tempat_lahir").addClass('is-invalid');
                            $(".error-tempat-lahir").html(response.error.tempat_lahir);
                        } else {
                            $("#tempat_lahir").removeClass('is-invalid');
                            $(".error-tempat-lahir").html('');
                        }
                        if (response.error.tanggal_lahir) {
                            $("#tanggal_lahir").addClass('is-invalid');
                            $(".error-tanggal-lahir").html(response.error.tanggal_lahir);
                        } else {
                            $("#tanggal_lahir").removeClass('is-invalid');
                            $(".error-tanggal-lahir").html('');
                        }
                        if (response.error.alamat) {
                            $("#alamat").addClass('is-invalid');
                            $(".error-alamat").html(response.error.alamat);
                        } else {
                            $("#alamat").removeClass('is-invalid');
                            $(".error-alamat").html('');
                        }
                        if (response.error.no_hp) {
                            $("#no_hp").addClass('is-invalid');
                            $(".error-no-hp").html(response.error.no_hp);
                        } else {
                            $("#no_hp").removeClass('is-invalid');
                            $(".error-no-hp").html('');
                        }
                        if (response.error.jabatan) {
                            $("#jabatan").addClass('is-invalid');
                            $(".error-jabatan").html(response.error.jabatan);
                        } else {
                            $("#jabatan").removeClass('is-invalid');
                            $(".error-jabatan").html('');
                        }

                    } else {
                        window.location.reload();
                        $("#modalCreatePetugas").modal('hide');

                    }
                },
                error: function(xhr, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        })

        $("#tanggal_lahir").datepicker({
            altField: "#altTL",
            altFormat: "yy-mm-dd",
            changeYear: true,
            changeMonth: true,
            dateFormat: "dd MM yy",
            monthNames: ["Januari", "Februari", "Mart", "April", "Mai", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"],
            dayNames: ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"],
            dayNamesMin: ["Ming", "Sen", "Sel", "Rab", "Kam", "Jum", "Sab"],
            yearRange: "c-80:c+0"
        });
    })
</script>