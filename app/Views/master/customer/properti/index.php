<?php
if (in_groups(['admin', 'bendahara'])) {
    echo $this->extend('templates/index_sewa');
} elseif (in_groups('ketua')) {
    echo $this->extend('templates/index_ketua');
}
?>

<?= $this->section('content'); ?>
<!-- Page Heading -->
<?php if (in_groups(['bendahara, admin'])) : ?>
    <button type="button" class="btn btn-primary float-right btn-sm" id="createPedagang">
        <i class="fa fas fa-plus"> </i> Pedagang
    </button>
<?php endif ?>
<h3 class="">Pedagang</h3>
<hr class="sidebar-divider d-none d-md-block">
<!-- DataTales Example -->
<?php if (session()->getFlashdata('pesan')) : ?>
    <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
        <?= session()->getFlashdata('pesan') ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif ?>

<div class="card shadow mb-4">
    <div class="card-header">
        <?php if (in_groups('bendahara')) : ?>
            <div class="export float-right btn-sm" id="export"></div>
        <?php endif ?>
        <h6 class="m-0 font-weight-bold text-primary mt-2">Daftar Pedagang</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIK</th>
                        <th>Nama</th>
                        <th>Gender</th>
                        <th>No Telp.</th>
                        <th>Jenis Usaha</th>
                        <th>Alamat</th>
                        <th>status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    foreach ($customer as $cust) : ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $cust['nik']; ?></td>
                            <td><?= $cust['nama']; ?></td>
                            <td class="text-center"><?= $cust['jenis_kelamin'] == 'L' ? 'Laki-laki' : 'Perempuan' ?></td>
                            <td><?= $cust['no_hp'] ?></td>
                            <td><?= $cust['jenis_usaha'] ?></td>
                            <td><?= $cust['alamat'] ?></td>
                            <td><span class="badge <?= $cust['status'] == 1 ? 'badge-success' : 'badge-danger'; ?>"><?= $cust['status'] == 1 ? 'Aktif' : 'Non-Aktif'; ?></span></td>
                            <td>
                                <a href="<?= base_url('Pedagang/detail/' . $cust['id']) ?>" class="btn btn-info btn-sm btn-block" title="Detail">
                                    <i class="fas fa-info-circle"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach ?>

                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="form-create-pedagang" style="display: none;"></div>



<script>
    $(document).ready(function() {
        $("#createPedagang").click(function(e) {
            e.preventDefault();
            $.ajax({
                type: "post",
                url: "<?= base_url('pedagang/create') ?>",
                data: {
                    aksi: 1
                },
                dataType: "json",
                success: function(response) {
                    $(".form-create-pedagang").html(response.view).show();
                    $("#modalCreatePedagang").modal('show');
                },
                error: function(xhr, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        })

        var table = $('#dataTable').DataTable({
            buttons: [{
                    extend: 'excel',
                    'title': 'Data Pedagang Pasar Bimireja',
                    text: '<i class="fas fa-file-excel"></i> Excel',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7]
                    },

                },
                {
                    extend: 'print',
                    orientation: 'landscape',
                    // messageTop: 'BUMDes Karsa Mandiri',
                    messageBottom: window.location.href,
                    text: '<i class="fas fa-print"></i> Print',
                    title: 'Data Pedagang Pasar Bumireja',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7]
                    },
                },
            ]
        });

        table.buttons().container()
            .appendTo($('#export'));
    })
</script>


<?php $this->endSection() ?>