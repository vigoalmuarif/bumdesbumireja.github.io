<?php if (in_groups('ketua')) {
    echo $this->extend('templates/index_ketua');
} elseif (in_groups(['admin', 'bendahara'])) {
    echo $this->extend('templates/index');
}
?>

<?= $this->section('content'); ?>
<!-- Page Heading -->
<?php if (in_groups(['admin', 'bendahara'])) : ?>
    <button class="btn btn-primary float-right btn-sm" id="create"><i class="fas fa fa-plus"></i> Petugas baru</button>
<?php endif ?>
<h1 class="h3 mb-2 text-gray-800">Pegawai</h1>
<hr class="sidebar-divider d-none d-md-block">
<!-- DataTales Example -->
<div class="flash-data" data-flashdata="<?= session()->getFlashdata('sukses') ?>"></div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <?php if (in_groups('bendahara')) : ?>
            <div class="export float-right btn-sm" id="export"></div>
        <?php endif ?>
        <h6 class="m-0 font-weight-bold text-primary mt-2">Daftar Pegawai</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th>NIK</th>
                        <th>Nama</th>
                        <th class="text-center">Gender</th>
                        <th>Jabatan</th>
                        <th>Alamat</th>
                        <th class="text-center">status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    foreach ($petugas as $employes) : ?>
                        <tr>
                            <td class="text-center"><?= $no++ ?></td>
                            <td><?= $employes['nik']; ?></td>
                            <td><?= $employes['petugas']; ?></td>
                            <td class="text-center"><?= $employes['jenis_kelamin'] == 'L' ? 'Laki-laki' : 'Perempuan' ?></td>
                            <td><?= $employes['jabatan'] ?></td>
                            <td><?= $employes['alamat'] ?></td>
                            <td class="text-center"><span class="badge badge-<?= $employes['status'] == 1 ? 'success' : 'danger'; ?>"><?= $employes['status'] == 1 ? 'Aktif' : 'Non-Aktif'; ?></span></td>
                            <td style="width: 30px;">
                                <a href="<?= base_url('petugas/detail/' . $employes['pegawaiID']) ?>" class="btn btn-info btn-sm" title="Detail">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    <?php endforeach ?>

                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="create" style="display: none;"></div>



<script>
    $(document).ready(function() {
        $("#create").click(function(e) {
            e.preventDefault();
            $.ajax({
                type: "get",
                url: "<?= base_url('petugas/create') ?>",
                dataType: "json",
                success: function(response) {
                    if (response.view) {
                        $(".create").html(response.view).show();
                        $("#modalCreatePetugas").modal('show');
                    }
                },
                error: function(xhr, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        });

        var table = $('#dataTable').DataTable({
            buttons: [{
                    extend: 'excel',
                    'title': 'Data Karyawan BUMDes Karsa Mandiri',
                    text: '<i class="fas fa-file-excel"></i> Excel',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6]
                    }

                },
                {
                    extend: 'print',
                    // messageTop: 'BUMDes Karsa Mandiri',
                    messageBottom: window.location.href,
                    text: '<i class="fas fa-print"></i> Print',
                    title: 'Data Karyawan BUMDes Karsa Mandiri',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6]
                    },
                },
            ]
        });

        table.buttons().container()
            .appendTo($('#export'));
    })
</script>


<?php $this->endSection() ?>