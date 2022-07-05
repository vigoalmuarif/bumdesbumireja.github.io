<?= $this->extend('templates/index_sewa'); ?>

<?= $this->section('content'); ?>

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Tagihan Bulanan</h1>
<hr class="sidebar-divider d-none d-md-block">
<div class="row">
    <div class="col">
        <div class="card shadow mb-4">
            <div class="card-header py-3">

                <h6 class="m-0 font-weight-bold text-primary mt-2">Daftar Tagihan Bulan</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th>Nama Pedagang</th>
                                <th>Total Tagihan</th>
                                <th>Total Tarif</th>
                                <th>Total Bayar</th>
                                <th class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            foreach ($tagihan as $row) : ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= $row['pedagang']; ?></td>
                                    <td><?= $row['bulan']; ?></td>
                                    <td><?= number_format($row['totalTarif'], 0); ?></td>
                                    <td><?= number_format($row['bayar'], 0); ?></td>
                                    <td class="text-center"><span class="badge badge-outline-danger"><?= $row['bayar'] > $row['totalTarif'] ? 'Lunas' : 'Belum Lunas'; ?></span></td>
                                </tr>
                            <?php endforeach ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="pembayaran-tagihan-bulanan" style="display: none;"></div>
<script>
    $(document).ready(function() {
        $("#dataTable").dataTable();
    })

    $(".bayar-tagihan-bulanan").click(function(e) {
        e.preventDefault();
        $.ajax({
            type: "post",
            url: "<?= base_url('persewaan/pembayaran_tagihan_bulanan') ?>",
            data: {
                id: $(this).data('id'),
                aksi: 0,
            },
            dataType: "json",
            success: function(response) {
                $(".pembayaran-tagihan-bulanan").html(response.view).show();
                $("#modalPembayaranTagihanBulanan").modal('show');
                $('#modalPembayaranTagihanBulanan').on('shown.bs.modal', function(event) {
                    $("#bayarTagihan").focus();
                })
            },
            error: function(xhr, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }

        });
    })
</script>


<?= $this->endSection() ?>