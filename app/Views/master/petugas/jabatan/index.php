<?= $this->extend('templates/index'); ?>

<?= $this->section('content'); ?>
<!-- Page Heading -->
<button class="btn btn-primary float-right btn-sm" id="create"><i class="fas fa fa-plus"></i> Jabatan baru</button>

<h1 class="h3 mb-2 text-gray-800">Jabatan</h1>
<hr class="sidebar-divider d-none d-md-block">
<!-- DataTales Example -->
<div class="flash-data" data-flashdata="<?= session()->getFlashdata('sukses') ?>"></div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary mt-2">Daftar jabatan</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th>Jabatan</th>
                        <th>Deskripsi</th>
                        <th style="width: 120px;" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    foreach ($jabatan as $title) : ?>
                        <tr>
                            <td class="text-center"><?= $no++ ?></td>
                            <td><?= $title['nama']; ?></td>
                            <td><?= $title['keterangan']; ?></td>
                            <td class="text-center">
                                <button class="btn btn-warning btn-sm ubah" data-id="<?= $title['id'] ?>">Ubah</button>
                                <button class="btn btn-danger btn-sm hapus" data-id="<?= $title['id'] ?>" data-jabatan="<?= $title['nama'] ?>">Hapus</button>
                            </td>
                        </tr>
                    <?php endforeach ?>

                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="create" style="display: none;"></div>
<div class="edit" style="display: none;"></div>



<script>
    $(document).ready(function() {
        $("#create").click(function(e) {
            e.preventDefault();
            $.ajax({
                type: "get",
                url: "<?= base_url('petugas/create_jabatan') ?>",
                dataType: "json",
                success: function(response) {
                    if (response.view) {
                        $(".create").html(response.view).show();
                        $("#modalCreate").modal('show');
                    }
                },
                error: function(xhr, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        });
        $(".ubah").click(function(e) {
            e.preventDefault();
            $.ajax({
                type: "get",
                url: "<?= base_url('petugas/edit_jabatan') ?>",
                data: {
                    id: $(this).data('id')
                },
                dataType: "json",
                success: function(response) {
                    if (response.view) {
                        $(".edit").html(response.view).show();
                        $("#modalEdit").modal('show');
                    }
                },
                error: function(xhr, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        });


        $(".hapus").click(function(e) {
            e.preventDefault();
            let id = $(this).data('id');
            let jabatan = $(this).data('jabatan');
            Swal.fire({
                title: 'Hapus?',
                html: `Yakin ingin menghapus Jabatan ${jabatan}?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Tidak'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "post",
                        url: "<?= base_url('petugas/delete_jabatan') ?>",
                        data: {
                            id: id
                        },
                        dataType: "json",
                        success: function(response) {
                            if (response.sukses) {
                                window.location.href = '<?= base_url('petugas/jabatan') ?>'

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