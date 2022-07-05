<!-- Modal -->
<form action="<?= base_url('customer_atk/update/' . $customer['id']) ?>" class="form-ubah-customer">
    <div class="modal fade" id="editCustomer" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Ubah Pelanggan ATK</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <label for="nama">Nama Lengkap</label>
                        <input type="text" class="form-control" name="nama" id="nama" value="<?= (set_value('nama') ? set_value('nama') : $customer['nama']) ?>" autocomplete="off">
                        <div class="invalid-feedback error-nama">

                        </div>
                    </div>

                    <div class="form-group">
                        <label for="nama">Jenis Kelamin</label>
                        <div class="custom-control custom-radio mb-2">
                            <input type="radio" class="custom-control-input gender" id="L" value="L" name="gender" <?= $customer['jk'] == 'L' ? 'checked="checked"' : '' ?>>
                            <label class="custom-control-label" for="L">Laki-laki</label>
                        </div>
                        <div class="custom-control custom-radio mb-3">
                            <input type="radio" class="custom-control-input gender" id="P" value="P" name="gender" <?= $customer['jk'] == 'P' ? 'checked="checked"' : '' ?>>
                            <label class="custom-control-label" for="P">Perempuan</label>
                            <div class="invalid-feedback error-gender"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="no_hp">No Telepon</label>
                        <input type="text" class="form-control" id="no_hp" name="no_hp" value="<?= (set_value('no_hp') ? set_value('no_hp') : $customer['no_hp']) ?>" autocomplete="off">
                        <div class="invalid-feedback error-no_hp">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <textarea type="text" class="form-control" id="alamat" name="alamat" rows="3"> <?= (set_value('alamat') ? set_value('alamat') : $customer['alamat']) ?></textarea>
                        <div class="invalid-feedback error-alamat">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary button-ubah">Ubah</button>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    $(document).ready(function() {
        $(".form-ubah-customer").submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: "post",
                url: $(this).attr('action'),
                data: $(this).serialize(),
                dataType: "json",
                beforeSend: function() {
                    $(".button-ubah").attr('disabled', true);
                    $(".button-ubah").html('<i class="fa fa-spin fa-spinner"></i>');
                },
                complete: function() {
                    $(".button-ubah").attr('disabled', false);
                    $(".button-ubah").addClass('btn-success');
                    $(".button-ubah").html('Ubah');
                },
                success: function(response) {
                    if (response.sukses) {
                        window.location.reload();
                    } else if (response.error) {
                        if (response.error.nama) {
                            $("#nama").addClass('is-invalid');
                            $(".error-nama").html(response.error.nama);
                        } else {
                            $("#nama").removeClass('is-invalid');
                            $(".error-nama").html('');
                        }
                        if (response.error.no_hp) {
                            $("#no_hp").addClass('is-invalid');
                            $(".error-no_hp").html(response.error.no_hp);
                        } else {
                            $("#no_hp").removeClass('is-invalid');
                            $(".error-no_hp").html('');
                        }
                        if (response.error.gender) {
                            $(".gender").addClass('is-invalid');
                            $(".error-gender").html(response.error.gender);
                        } else {
                            $(".gender").removeClass('is-invalid');
                            $(".error-gender").html('');
                        }
                        if (response.error.alamat) {
                            $("#alamat").addClass('is-invalid');
                            $(".error-alamat").html(response.error.alamat);
                        } else {
                            $("#alamat").removeClass('is-invalid');
                            $(".error-alamat").html('');
                        }
                    }
                },
                error: function(xhr, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });

        })
    })
</script>