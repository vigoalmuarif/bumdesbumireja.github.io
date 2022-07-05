<?php $this->extend('templates/index_retribusi') ?>

<?php $this->section('content') ?>

<?php if (in_groups('admin')) : ?>
    <div class="row">
        <div class="col-xl-4 col-md-12 mb-2">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Petugas Retribusi Aktif</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $petugas; ?> Petugas</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-database fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-12 mb-2">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Total periode</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $periode; ?> Periode</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-archive fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-12 mb-2">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Retribusi Aktif</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $retribusi_aktif['total'] . ' ' . 'dari' . ' ' . $jml_retribusi['total'] ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-toggle-on fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php endif ?>

<?php if (in_groups('bendahara')) : ?>
    <div class="row">
        <div class="col-xl-3 col-md-12 mb-2">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Pendapatan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Rp <?= number_format($pendapatan_retribusi['total'], 0, ',', ',') ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-database fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-12 mb-2">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Pendapatan Tahun ini</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Rp <?= number_format($pendapatan_tahun['total'], 0, ',', ',') ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-wallet fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-12 mb-2">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Pendapatan bulan ini</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Rp <?= number_format($pendapatan_bulan['total'], 0, ',', ',') ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-archive fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-12 mb-2">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Retribusi Aktif</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $retribusi_aktif['total'] . ' ' . 'dari' . ' ' . $jml_retribusi['total'] ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-toggle-on fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif ?>
<div class="card">
    <div class="card-header">
        Setoran Retribusi
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