<!-- Modal -->
<form action="<?= base_url('users/update') ?>" method="post" id="formEditUser">
    <div class="modal fade" id="modalEditUser" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modalEditUserLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditUserLabel">Tambah User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <label for="exampleFormControlInput1">NIK</label>
                    <div class="input-group mb-3">
                        <input type="hidden" name="user" id="user" value="<?= $user['userID']; ?>">
                        <input type="hidden" name="email_old" id="email_old" value="<?= $user['email']; ?>">
                        <input type="hidden" name="username_old" id="username_old" value="<?= $user['username']; ?>">
                        <input type="text" class="form-control" id="nik" name="nik" placeholder="Masukan NIK" aria-label="Masukan NIK" autocomplete="off" value="<?= $user['nik'] ?>" readonly>
                    </div>

                    <div class="form-group">
                        <label for="nama">Nama Lengkap</label>
                        <input type="text" class="form-control" id="nama" id="nama" value="<?= $user['pegawai']; ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="jabatan">Jabatan / Petugas</label>
                        <input type="text" class="form-control" id="jabatan" name="jabatan" value="<?= $user['jabatan']; ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="role">Role</label>
                        <select class="form-control" id="role" name="role">
                            <option value="" selected disabled hidden>--Pilih--</option>
                            <?php foreach ($role as $row) : ?>
                                <option value="<?= $row['id'] ?>" <?= $row['id'] == $user['group_id'] ? 'selected="selected"' : ''; ?>><?= $row['name'] ?></option>
                            <?php endforeach; ?>

                        </select>
                        <div class="invalid-feedback error-role">

                        </div>
                    </div>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" value="<?= $user['username']; ?>" autocomplete="off">
                        <div class="invalid-feedback error-username">

                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" class="form-control" id="email" name="email" value="<?= $user['email']; ?>" autocomplete="off">
                        <div class="invalid-feedback error-email">

                        </div>
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control" id="status" name="status">
                            <option value="0" <?= $user['active'] == 0 ? 'selected="selected"' : ''; ?>>Nonaktif</option>
                            <option value="1" <?= $user['active'] == 1 ? 'selected="selected"' : ''; ?>>Aktif</option>

                        </select>
                        <div class="invalid-feedback error-role">

                        </div>
                    </div>
                </div>
                <div class=" modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="tombolTambah">Ubah</button>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    $(document).ready(function() {

        $("#formEditUser").submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: "post",
                url: $(this).attr('action'),
                data: $(this).serialize(),
                dataType: "json",
                success: function(response) {
                    if (response.error) {
                        if (response.error.role) {
                            $("#role").addClass('is-invalid');
                            $(".error-role").html(response.error.role);
                        } else {
                            $("#role").removeClass('is-invalid');
                            $(".error-role").html('');
                        }
                        if (response.error.username) {
                            $("#username").addClass('is-invalid');
                            $(".error-username").html(response.error.username);
                        } else {
                            $("#username").removeClass('is-invalid');
                            $(".error-username").html('');
                        }
                        if (response.error.email) {
                            $("#email").addClass('is-invalid');
                            $(".error-email").html(response.error.email);
                        } else {
                            $("#email").removeClass('is-invalid');
                            $(".error-email").html('');
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