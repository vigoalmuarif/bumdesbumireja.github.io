<?= $this->extend('templates/index_sewa'); ?>

<?= $this->section('content'); ?>
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Sewa property</h1>
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
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary mt-2"><?= $title ?></h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Faktur</th>
                        <th>Pedagang</th>
                        <th>Property</th>
                        <th>Sewa</th>
                        <th>Selesai</th>
                        <th>Kekurangan</th>
                        <th>Status</th>
                        <th style="width: 20px;">Aksi</th>



                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    foreach ($sewa as $row) :
                        $kekurangan = $row['harga_sewa'] - $row['terbayar'];
                    ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $row['faktur']; ?></td>
                            <td><?= $row['pedagang']; ?></td>
                            <td><?= $row['kode_property']; ?></td>
                            <td><?= date('d-m-Y', strtotime($row['tanggal_sewa'])); ?></td>
                            <td><?= date('d-m-Y', strtotime($row['tanggal_batas'])); ?></td>
                            <td>Rp. <?= number_format(($kekurangan > 0) ? $kekurangan : 0, "0", ",", ",") ?></td>
                            <?php if (($kekurangan <= 0) && (strtotime(date('Y-m-d')) <= strtotime($row['tanggal_batas']))) : ?>
                                <td class="text-center"><span class="badge badge-outline-success">Aktif</span></td>
                            <?php elseif ($kekurangan > 0 && strtotime(date('Y-m-d')) <= strtotime($row['tanggal_batas'])) : ?>
                                <td class="text-center"><span class="badge badge-outline-success">Aktif</span></td>
                            <?php elseif ($kekurangan <= 0 && strtotime(date('Y-m-d')) > strtotime($row['tanggal_batas'])) : ?>
                                <td class="text-center"><span class="badge badge-outline-biru">Selesai</span></td>
                            <?php elseif ($kekurangan > 0 && strtotime(date('Y-m-d')) > strtotime($row['tanggal_batas'])) : ?>
                                <td class="text-center"><span class="badge badge-outline-danger">Terlambat</span></td>
                            <?php endif ?>
                            <td>
                                <button class="btn btn-info btn-sm detail" type="button" id="detail" data-id="<?= $row['sewaId']; ?>" title="Detail"><i class="fa fa-info-circle"></i></button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="detail-sewa" style="display: none;"></div>

<script>
    $(document).ready(function() {

        $(".detail").click(function(e) {
            e.preventDefault();
            $.ajax({
                type: "post",
                url: "<?= base_url('persewaan/detail_sewa') ?>",
                data: {
                    id: $(this).data('id')
                },
                dataType: "json",
                success: function(response) {
                    $(".detail-sewa").html(response.view).show();
                    $("#modalDetailSewa").modal('show');
                },
                error: function(xhr, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });

        });
    });
</script>
<?= $this->endSection() ?> -->