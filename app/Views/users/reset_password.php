<!-- Modal -->
<form action="<?= base_url('users/updatePassword') ?>" method="post" id="formResetPassword">
    <div class="modal fade" id="modalResetpassword" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modalResetpasswordLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalResetpasswordLabel">Reset Password</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="user" id="user" value="<?= $user['userID']; ?>">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" value="<?= $user['username']; ?>" autocomplete="off" readonly>
                        <div class="invalid-feedback error-username">

                        </div>
                    </div>
                    <div class="form-group">
                        <label for="role">Role</label>
                        <select class="form-control" id="role" name="role" disabled>
                            <option value="" selected disabled hidden>--Pilih--</option>
                            <?php foreach ($role as $row) : ?>
                                <option value="<?= $row['id'] ?>" <?= $row['id'] == $user['group_id'] ? 'selected="selected"' : ''; ?>><?= $row['name'] ?></option>
                            <?php endforeach; ?>

                        </select>
                        <div class="invalid-feedback error-role">

                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password">Password Baru</label>
                        <input type="password" class="form-control" id="password" name="password" autocomplete="off">
                        <div class="invalid-feedback error-password">

                        </div>
                    </div>

                    <div class="form-group">
                        <label for="confirm_password">Ulangi Password</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" autocomplete="off">
                        <div class="invalid-feedback error-confirm_password">

                        </div>
                    </div>

                </div>
                <div class=" modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="tombolTambah">Reset</button>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    $(document).ready(function() {

        $("#formResetPassword").submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: "post",
                url: $(this).attr('action'),
                data: $(this).serialize(),
                dataType: "json",
                success: function(response) {
                    if (response.error) {
                        if (response.error.password) {
                            $("#password").addClass('is-invalid');
                            $(".error-password").html(response.error.password);
                        } else {
                            $("#password").removeClass('is-invalid');
                            $(".error-password").html('');
                        }
                        if (response.error.confirm_password) {
                            $("#confirm_password").addClass('is-invalid');
                            $(".error-confirm_password").html(response.error.confirm_password);
                        } else {
                            $("#confirm_password").removeClass('is-invalid');
                            $(".error-confirm_password").html('');
                        }
                    }
                    if (response.sukses) {
                        window.location.reload();
                    }
                },
                error: function(xhr, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        })
    });
</script>