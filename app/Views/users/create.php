<!-- Modal -->
<form action="<?= base_url('users/save') ?>" method="post" id="formAddUser">
    <div class="modal fade" id="modalCreateUser" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modalCreateUserLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCreateUserLabel">Tambah User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <label for="exampleFormControlInput1">NIK</label>
                    <div class="input-group mb-3">
                        <input type="hidden" name="pegawaiID" id="pegawaiID">
                        <input type="text" class="form-control" id="nik" name="nik" placeholder="Masukan NIK" aria-label="Masukan NIK" autocomplete="off">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button" id="cekNIK">Cek</button>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="nama">Nama Lengkap</label>
                        <input type="text" class="form-control" id="nama" id="nama" readonly>
                    </div>
                    <div class="form-group">
                        <label for="jabatan">Jabatan / Petugas</label>
                        <input type="text" class="form-control" id="jabatan" name="jabatan" readonly>
                    </div>
                    <div class="form-group">
                        <label for="role">Role</label>
                        <select class="form-control" id="role" name="role" disabled>
                            <option value="" selected disabled hidden>--Pilih--</option>
                            <?php foreach ($role as $row) : ?>
                                <option value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
                            <?php endforeach; ?>

                        </select>
                        <div class="invalid-feedback error-role">

                        </div>
                    </div>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" autocomplete="off" readonly>
                        <div class="invalid-feedback error-username">

                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" class="form-control" id="email" name="email" autocomplete="off" readonly>
                        <div class="invalid-feedback error-email">

                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" autocomplete="off" readonly>
                        <div class="invalid-feedback error-password">

                        </div>
                    </div>
                    <div class="form-group">
                        <label for="confirm_password">Ulangi Password</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" autocomplete="off" readonly>
                        <div class="invalid-feedback error-confirm-password">

                        </div>
                    </div>
                </div>
                <div class=" modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="tombolTambah" disabled>Tambah</button>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    function cekNIK() {
        let nik = $("#nik").val();
        if (nik.length == 0) {
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
                title: 'Masukan NIK terlebih dahulu'
            })
        } else {
            $.ajax({
                type: "get",
                url: "<?= base_url('users/cek_nik') ?>",
                data: {
                    nik: nik
                },
                dataType: "json",
                success: function(response) {
                    if (response.pegawai == 0) {
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
                            title: 'Petugas belum terdaftar di database BUMDes, kontak admin atau bendahara.'
                        })
                    } else if (response.pegawai == 1) {
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
                            title: 'Pegawai telah terdaftar'
                        });
                    } else {
                        $("#nama").val(response.pegawai);
                        $("#pegawaiID").val(response.pegawaiID);
                        $("#jabatan").val(response.jabatan);
                        $("#tombolTambah").prop('disabled', false);
                        $("#role").prop('disabled', false);
                        $("#username").prop('readonly', false);
                        $("#email").prop('readonly', false);
                        $("#password").prop('readonly', false);
                        $("#confirm_password").prop('readonly', false);
                    }
                },
                error: function(xhr, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        }
    }


    $(document).ready(function() {

        $("#cekNIK").click(function(e) {
            e.preventDefault();
            cekNIK();
        })
        $("#nik").keyup(function(e) {
            e.preventDefault();
            $("#nama").val('');
            $("#jabatan").val('');
            $("#role").val('').prop('disabled', true);
        });

        $("#formAddUser").submit(function(e) {
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
                        if (response.error.password) {
                            $("#password").addClass('is-invalid');
                            $(".error-password").html(response.error.password);
                        } else {
                            $("#password").removeClass('is-invalid');
                            $(".error-password").html('');
                        }
                        if (response.error.confirm_password) {
                            $("#confirm_password").addClass('is-invalid');
                            $(".error-confirm-password").html(response.error.confirm_password);
                        } else {
                            $("#confirm_password").removeClass('is-invalid');
                            $(".error-confirm-password").html('');
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