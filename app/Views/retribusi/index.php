<?= $this->extend('templates/index_retribusi'); ?>

<?= $this->section('content'); ?>
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Setor Retribusi</h1>
<hr class="sidebar-divider d-none d-md-block">
<!-- DataTales Example -->
<div class="flash-data" data-flashdata="<?= session()->getFlashdata('sukses') ?>"></div>

<div class="card">
    <div class="card-header">
        Periode Retribusi
    </div>
    <div class="card-body">

        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Periode</th>
                        <th>Retribusi</th>
                        <th class="text-center">Status</th>
                        <?php if (in_groups('bendahara')) : ?>
                            <th class="text-center">Aksi</th>
                        <?php endif ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    foreach ($retribusi as $row) : ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= longdate_indo($row['tanggal']); ?></td>
                            <td><?= $row['retribusi']; ?></td>
                            <td class="text-center"><?= $row['bayar'] < 1 ? '<span class="badge badge-outline-danger">Belum setor</span>' : '<span class="badge badge-outline-success">Sudah setor</span>' ?></td>
                            <?php if (in_groups('bendahara')) : ?>
                                <td class="text-center">
                                    <button type="button" data-id="<?= $row['pembayaranId'] ?>" data-retribusi="<?= $row['retribusiId'] ?>" class="btn btn-danger btn-sm setorRetribusi">Setor</button>
                                </td>
                            <?php endif ?>

                        </tr>

                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="setor-retribusi"></div>



<script>
    $(document).ready(function() {
        $("#dataTable").dataTable();

        $(".setorRetribusi").click(function(e) {
            e.preventDefault();
            $.ajax({
                type: "post",
                url: "<?= base_url('retribusi/edit_pembayaran_by_id') ?>",
                data: {
                    id: $(this).data('id'),
                    retribusi: $(this).data('retribusi'),
                    title: 'Setor Retribusi',
                    aksi: 'Setor',
                    pesan: 0
                },
                dataType: "json",
                success: function(response) {
                    $(".setor-retribusi").html(response.view).show();
                    $("#modalUbahPembayaranRetribusi").modal('show');
                },
                error: function(xhr, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        });
    });
</script>

<?php $this->endSection() ?>