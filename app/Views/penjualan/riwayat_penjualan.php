<?= $this->extend('templates/index_atk'); ?>

<?= $this->section('content'); ?>
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Riwayat Penjualan</h1>
<hr class="sidebar-divider d-none d-md-block">
<!-- DataTales Example -->
<div class="flash-data" data-flashdata="<?= session()->getFlashdata('sukses') ?>"></div>
<form action="<?= base_url('penjualan/riwayat_penjualan') ?>" method="get">
    <div class="row">
        <div class="col">
            <div class="form-row">
                <div class="col-md-3 mb-3">
                    <label for="validationCustom01">Mulai</label>
                    <input type="hidden" name="alternatif1" id="alternatif1">
                    <input type="hidden" name="alternatif2" id="alternatif2">
                    <input type="text" class="form-control <?= $validation->hasError('mulai') ? 'is-invalid' : '' ?>" id="mulai" name="mulai" autocomplete="off" value="<?= old('mulai') ?>">
                    <div class="invalid-feedback">
                        <?= $validation->getError('mulai') ?>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="validationCustom02">Sampai</label>
                    <input type="text" class="form-control  <?= $validation->hasError('sampai') ? 'is-invalid' : '' ?>" id="sampai" name="sampai" value="<?= old('sampai') ?>" autocomplete="off">
                    <div class="invalid-feedback">
                        <?= $validation->getError('sampai') ?>
                    </div>
                </div>
                <div class="col" style="margin-top: 31px;">
                    <button class="btn btn-primary mr-2" value="" name="kirim" type="submit"><i class="fa fa-search mr-1" aria-hidden="true"> </i>Tampilkan</button>
                    <button class="btn btn-secondary" value="" name="kirim" type="reset"><i class="fa fa-reset mr-1" aria-hidden="true"> </i>reset</button>
                </div>
            </div>
        </div>
    </div>
</form>

<?php if (!empty($_GET['mulai']) && !empty($_GET['sampai'])) : ?>
    <div class="alert alert-success text-center" role="alert">
        Menampilkan penjualan periode <?= date('d-m-y', strtotime($mulai)) ?> sampai <?= date('d-m-y', strtotime($sampai)) ?>
    </div>
    <div class="card">
        <div class="card-header">
            Daftar Penjualan
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Faktur</th>
                            <th>customer</th>
                            <th>Total Harga</th>
                            <th>Pembayaran</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Aksi</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($penjualan as $row) : ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $row['date'] ?></td>
                                <td><?= $row['faktur'] ?></td>
                                <td><?= $row['customer'] ?></td>
                                <td>Rp <?= number_format($row['total'], 0, ',', ',') ?></td>
                                <td><?= $row['pembayaran'] ?></td>
                                <td><?= $row['bayar'] >= $row['total'] ? '<span class="badge badge-outline-success">Lunas</span>' : '<span class="badge badge-outline-danger">Belum Lunas</span' ?></td>
                                <td>
                                    <button class="btn btn-primary btn-sm detail-penjualan" data-id="<?= $row['penjualan_id'] ?>">Detail</button>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php endif ?>
<div class="detail" style="display: none;"></div>
<script>
    $(document).ready(function() {

        $(".detail-penjualan").click(function(e) {
            e.preventDefault();
            let id = $(this).data('id');
            $.ajax({
                type: "get",
                url: "<?= base_url('penjualan/detail_penjualan') ?>",
                data: {
                    id: id
                },
                dataType: "json",
                success: function(response) {
                    if (response.view) {
                        $(".detail").html(response.view).show();
                        $("#modalDetailPenjualan").modal('show');
                    }
                },
                error: function(xhr, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        });


        $("#mulai").datepicker({
            altField: "#alternatif1",
            altFormat: "yy-mm-dd",
            changeYear: true,
            changeMonth: true,
            dateFormat: "DD, dd MM yy",
            monthNames: ["Januari", "Februari", "Mart", "April", "Mai", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"],
            dayNames: ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"],
            dayNamesMin: ["Ming", "Sen", "Sel", "Rab", "Kam", "Jum", "Sab"],
            yearRange: "c-10:c+0"
        });
        // $("#mulai").datepicker().datepicker('setDate', $mulai);
        $("#sampai").datepicker({
            altField: "#alternatif2",
            altFormat: "yy-mm-dd",
            changeYear: true,
            changeMonth: true,
            dateFormat: "DD, dd MM yy",
            monthNames: ["Januari", "Februari", "Mart", "April", "Mai", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"],
            dayNames: ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"],
            dayNamesMin: ["Ming", "Sen", "Sel", "Rab", "Kam", "Jum", "Sab"],
            yearRange: "c-10:c+0"
        });
        // $("#sampai").datepicker().datepicker('setDate', 'today');
    })
</script>
<?php $this->endSection() ?>