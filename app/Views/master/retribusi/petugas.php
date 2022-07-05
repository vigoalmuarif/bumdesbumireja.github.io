<?php
if (in_groups(['admin', 'bendahara'])) {
    echo $this->extend('templates/index_retribusi');
} elseif (in_groups('ketua')) {
    echo $this->extend('templates/index_ketua');
}
?>

<?= $this->section('content'); ?>
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Petugas Retribusi</h1>
<hr class="sidebar-divider d-none d-md-block">
<!-- DataTales Example -->
<div class="flash-data" data-flashdata="<?= session()->getFlashdata('sukses') ?>"></div>


<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                Petugas Retribusi
                <?php if (in_groups(['admin', 'bendahara'])) : ?>
                    <button type="button" class="btn btn-primary btn-sm float-right" id="addPetugas"><span class="fa fa-plus"></span> Petugas baru</button>
                <?php endif ?>
            </div>
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>NIK</th>
                                <th>Nama Petugas</th>
                                <th>Petugas</th>
                                <th class="text-center">Status</th>
                                <?php if (in_groups(['admin', 'bendahara'])) : ?>
                                    <th class="text-center">Aksi</th>
                                <?php endif ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            foreach ($employes as $row) : ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= $row['nik']; ?></td>
                                    <td><?= $row['pegawai']; ?></td>
                                    <td><?= $row['retribusi']; ?></td>
                                    <td class="text-center"><?= $row['pr_status'] == 1 ? '<span class="badge badge-outline-success">Aktif</span>' : '<span class="badge badge-outline-danger">Non-Aktif</span>' ?></td>
                                    <?php if (in_groups(['admin', 'bendahara'])) : ?>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-warning btn-sm edit-petugas-retribusi" data-id="<?= $row['pr_id']; ?>" title="Ubah"><i class="fa fa-edit"></i></button>
                                            <button type="button" class="btn btn-danger btn-sm hapus" title="Hapus" data-id="<?= $row['pr_id'] ?>" data-pegawai="<?= $row['pegawai'] ?>"><i class="fa fa-trash-alt"></i></button>
                                        </td>
                                    <?php endif ?>
                                </tr>

                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="ubah-petugas-retribusi" style="display: none;"></div>
<div class="add-petugas-retribusi" style="display: none;"></div>

<script>
    $(document).ready(function() {

        $("#addPetugas").click(function(e) {
            e.preventDefault();
            $.ajax({
                type: "get",
                url: "<?= base_url('retribusi/create_petugas/') ?>",
                dataType: "json",
                success: function(response) {
                    $(".add-petugas-retribusi").html(response.view).show();
                    $("#modalAddPetugas").modal('show');

                },
                error: function(xhr, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        })

        $(".edit-petugas-retribusi").click(function(e) {
            $.ajax({
                type: "post",
                url: "<?= base_url('retribusi/edit_petugas') ?>",
                data: {
                    id: $(this).data('id')
                },
                dataType: "json",
                success: function(response) {
                    $(".ubah-petugas-retribusi").html(response.view).show();
                    $("#modalEditPetugasRetribusi").modal('show');
                },
                error: function(xhr, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        });

        $(".hapus").click(function(e) {
            e.preventDefault();
            let id = $(this).data('id');
            let pegawai = $(this).data('pegawai');
            Swal.fire({
                title: 'Hapus?',
                html: `Yakin ingin menghapus petugas ${pegawai}?`,
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
                        url: "<?= base_url('retribusi/delete_petugas') ?>",
                        data: {
                            id: id
                        },
                        dataType: "json",
                        success: function(response) {
                            if (response.sukses) {
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
    });
</script>

<?= $this->endSection() ?>