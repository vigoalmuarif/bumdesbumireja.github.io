<?php if ($count_sewa < 1) : ?>
    <div class="text-center">Tidak ada riwayat sewa</div>
<?php else : ?>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No Transaksi</th>
                    <th>Kode Property</th>
                    <th>Tanggal Sewa</th>
                    <th>Tanggal Selesai</th>
                    <th>Kekurangan (Rp)</th>
                    <th>Status</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($sewa as $row) :
                    $kekurangan = $row['harga_sewa'] - $row['terbayar'];
                ?>
                    <tr>
                        <td><?= $row['faktur']; ?></td>
                        <td><?= $row['kode_property']; ?></td>
                        <td><?= date('d-m-Y', strtotime($row['tanggal_sewa'])); ?></td>
                        <td><?= date('d-m-Y', strtotime($row['tanggal_batas'])); ?></td>
                        <td><?= number_format($kekurangan > 0 ? $kekurangan : 0, "0", ",", ",") ?></td>
                        <?php if ($kekurangan >= 0 && strtotime(date('Y-m-d')) < strtotime($row['tanggal_batas'])) : ?>
                            <td class="text-center"><span class="badge badge-outline-success">Aktif</span></td>
                        <?php elseif ($kekurangan <= 0 && strtotime(date('Y-m-d')) > strtotime($row['tanggal_batas'])) : ?>
                            <td class="text-center"><span class="badge badge-outline-biru">Selesai</span></td>
                        <?php elseif ($kekurangan > 0 && strtotime(date('Y-m-d')) > strtotime($row['tanggal_batas'])) : ?>
                            <td class="text-center"><span class="badge badge-outline-danger">Terlambat</span></td>
                        <?php endif ?>
                        <td class="text-center">
                            <button type="button" class="btn btn-info btn-sm  detail" data-id="<?= $row['id_sewa']; ?>" title="Detail"><i class="fa fa-info-circle"></i></button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="detail-property" style="display: none;"></div>
    <div class="view-riwayat-bayar" style="display: none;"></div>
<?php endif ?>
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
                    $(".detail-property").html(response.view).show();
                    $("#modalDetailSewa").modal('show');
                },
                error: function(xhr, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });

        });

        $(".riwayat-bayar").click(function(e) {
            e.preventDefault();
            $.ajax({
                type: "post",
                url: "<?= base_url('persewaan/riwayat_bayar') ?>",
                data: {
                    id: $(this).data('id')
                },
                dataType: "json",
                success: function(response) {
                    $(".view-riwayat-bayar").html(response.view).show();
                    $("#modalRiwayatBayar").modal('show');
                },
                error: function(xhr, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });

        });
    });
</script>