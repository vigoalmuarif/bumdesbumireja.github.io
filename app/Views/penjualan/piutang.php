<?= $this->extend('templates/index_atk'); ?>

<?= $this->section('content'); ?>
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Piutang Penjualan ATK</h1>
<hr class="sidebar-divider d-none d-md-block">
<!-- DataTales Example -->
<div class="flash-data" data-flashdata="<?= session()->getFlashdata('sukses') ?>"></div>

<div class="card">
    <div class="card-header">
        Daftar Piutang
    </div>
    <div class="card-body">

        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Pelanggan</th>
                        <th>Total Harga (Rp)</th>
                        <th>Bayar (Rp)</th>
                        <th>Kekurangan (Rp)</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Aksi</th>

                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    foreach ($piutang as $row) : ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $row['customer']; ?></td>
                            <td><?= number_format($row['totalHarga'], 0, ",", ","); ?></td>
                            <td><?= number_format($row['terbayar'], 0, ",", ","); ?></td>
                            <td><?= number_format($row['totalHarga'] - $row['terbayar'], 0, ",", ","); ?></td>
                            <td><?= $row['terbayar'] < $row['totalHarga'] ? '<span class="badge badge-outline-danger">Belum Lunas</span>' : '' ?></td>
                            <td class="text-center">
                                <a href="<?= base_url('penjualan/listpiutang/' . $row['customer_id']) ?>" class="btn btn-info btn-sm">Lihat</a>
                            </td>

                        </tr>

                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="piutang"></div>
<div class="pelunasanPiutang"></div>



<script>
    function listPiutang(id, customer) {

        $.ajax({
            type: "get",
            url: "<?= base_url('penjualan/listPiutangByName') ?>",
            data: {
                id: id,
                customerID: customer,
            },
            dataType: "json",
            success: function(response) {
                $(".piutang").html(response.view);
                $("#listPiutang").modal('show');

            },
            error: function(xhr, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });

    }

    $(document).ready(function() {
        $("#dataTable").dataTable();


        $(".pelunasan-piutang").click(function(e) {
            e.preventDefault();
            $.ajax({
                type: "get",
                url: "<?= base_url('penjualan/pelunasan') ?>",
                data: {
                    id: $(this).data('id')
                },
                dataType: "json",
                success: function(response) {
                    $(".pelunasanPiutang").html(response.view);
                    $("#modalPelunasan").modal('show');

                },
                error: function(xhr, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        });
    });
</script>

<?php $this->endSection() ?>