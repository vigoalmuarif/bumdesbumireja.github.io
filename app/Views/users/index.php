<?= $this->extend('templates/index'); ?>

<?= $this->section('content'); ?>
<!-- DataTales Example -->
<div class="flash-data" data-flashdata="<?= session()->getFlashdata('sukses') ?>"></div>
<div class="p">
    <button type="button" id="tambah" class="btn btn-primary float-right btn-sm">
        Tambah User
    </button>
    <h3 class="">Users</h3>
    <hr class="sidebar-divider d-block d-md-block">
    <?php
    $request = \Config\Services::request();

    ?>

    <div class="card">
        <div class="card-header py-3">
            Daftar Users
        </div>
        <div class="card-body">

            <?php if (in_groups('admin')) : ?>
                <div class="row">
                    <div class="col">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama lengkap</th>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach ($users as $row) : ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= $row['nama'] ?></td>
                                            <td><?= $row['username'] ?></td>
                                            <td><?= $row['email'] ?></td>
                                            <td><?= $row['role'] ?></td>
                                            <td class="text-center"><?= $row['active'] == 1  ? '<div class="badge badge-outline-success">Aktif</div>' : '<div class="badge badge-outline-danger">Nonaktif</div>' ?></td>
                                            <td class="text-center">
                                                <button class="btn btn-info btn-sm edit" data-id="<?= $row['userID']; ?>" title="Ubah"><span class="fa fa-edit"></span></button>
                                                <button class="btn btn-warning btn-sm reset" data-id="<?= $row['userID']; ?>" title="Ubah Password"><span class="fa fa-key"></span></button>
                                                <button class="btn btn-danger btn-sm hapus" data-id="<?= $row['userID']; ?>" data-user="<?= $row['username'] ?>" <?= $row['role'] == 'admin' ? 'disabled' : '' ?> title="Hapus"><span class="fa fa-trash-alt"></span></button>

                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <?php endif ?>
        </div>
    </div>
</div>
<div class="create" style="display: none;"></div>
<div class="edit-modal" style="display: none;"></div>
<div class="reset-modal" style="display: none;"></div>

<script>
    $(document).ready(function() {
        $("#tambah").click(function(e) {
            e.preventDefault();
            $.ajax({
                type: "get",
                url: "<?= base_url('users/create') ?>",
                dataType: "json",
                success: function(response) {
                    $(".create").html(response.view).show();
                    $("#modalCreateUser").modal('show');
                },
                error: function(xhr, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        });

        $(".edit").click(function(e) {
            e.preventDefault();
            $.ajax({
                type: "get",
                url: "<?= base_url('users/edit') ?>",
                data: {
                    id: $(this).data('id')
                },
                dataType: "json",
                success: function(response) {
                    $(".edit-modal").html(response.view).show();
                    $("#modalEditUser").modal('show');
                },
                error: function(xhr, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        })
        $(".reset").click(function(e) {
            e.preventDefault();
            $.ajax({
                type: "get",
                url: "<?= base_url('users/resetPassword') ?>",
                data: {
                    id: $(this).data('id')
                },
                dataType: "json",
                success: function(response) {
                    $(".reset-modal").html(response.view).show();
                    $("#modalResetpassword").modal('show');
                },
                error: function(xhr, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        })

        $(".hapus").click(function(e) {
            e.preventDefault();
            let id = $(this).data('id');
            let nama = $(this).data('user');
            Swal.fire({
                title: 'Hapus?',
                text: `Yakin ingin menghapus user ${nama} ?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Tidak',

            }).then((result) => {
                if (result.isConfirmed) {

                    $.ajax({
                        type: "post",
                        url: "<?= base_url('users/delete') ?>",
                        data: {
                            id: id
                        },
                        dataType: "json",
                        success: function(response) {
                            if (response.sukses == 'sukses') {
                                window.location.reload();
                            }
                        },
                        error: function(xhr, thrownError) {
                            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                        }
                    });

                }
            });
        });
    })
</script>

<?php $this->endSection() ?>