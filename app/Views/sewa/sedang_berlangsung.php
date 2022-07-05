<?php if ($count_sewa < 1) : ?>
    <div class="text-center">Tidak ada sewa saat ini</div>
<?php else : ?>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Faktur</th>
                    <th>Kode Property</th>
                    <th>Tanggal Sewa</th>
                    <th>Tanggal Selesai</th>
                    <th>Kekurangan</th>
                    <th>Status</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($sewa as $row) :
                    $kekurangan = $row['harga_sewa'] - $row['total_bayar'];
                    if (!($row['total_bayar'] >= $row['harga_sewa'] && $row['tanggal_batas'] < date('Y-m-d'))) : ?>

                        <tr>
                            <td><?= $row['faktur']; ?></td>
                            <td><?= $row['kode_property']; ?></td>
                            <td><?= date('d-m-Y', strtotime($row['tanggal_sewa'])); ?></td>
                            <td><?= date('d-m-Y', strtotime($row['tanggal_batas'])); ?></td>
                            <td>Rp <?= number_format(($kekurangan > 0 ? $kekurangan : 0), "0", ",", ",") ?></td>
                            <td class="text-center"><span class="badge <?= $row['tanggal_batas'] > date('Y-m-d') ? 'badge-outline-success' : 'badge-outline-danger' ?>"><?= ($row['total_bayar'] < $row['harga_sewa'] && $row['tanggal_batas'] < date('Y-m-d')) ? 'Terlambat' : 'Aktif' ?></span></td>
                            <td class="text-center">
                                <button type="button" class="btn btn-info btn-sm detail" data-id="<?= $row['id_sewa']; ?>" title="Detail"><i class="fa fa-info-circle"></i></button>
                                <?php if (in_groups('bendahara')) : ?>
                                    <button type="button" class="btn btn-<?= $row['total_bayar'] >= $row['harga_sewa'] ? 'secondary' : 'danger' ?> btn-sm pelunasan" data-id="<?= $row['id_sewa']; ?>" title="Bayar" <?= $kekurangan > 0 ? '' : 'disabled'; ?>><i class="fa fa-money-bill-alt"></i></button>
                                <?php endif ?>
                                <?php if (in_groups('admin')) : ?>
                                    <button type="button" class="btn btn-danger btn-sm hapus-sewa" data-property="<?= $row['kode_property']; ?>" data-id="<?= $row['id_sewa']; ?>" title="Hapus"><i class="fa fa-trash-alt"></i></button>
                                <?php endif ?>
                            </td>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="view-detail-sewa" style="display: none;"></div>
    <div class="view-pelunasan-sewa" style="display: none;"></div>
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
                    $(".view-detail-sewa").html(response.view).show();
                    $("#modalDetailSewa").modal('show');
                },
                error: function(xhr, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });

        });
        $(".pelunasan").click(function(e) {
            e.preventDefault();
            $.ajax({
                type: "post",
                url: "<?= base_url('persewaan/pelunasan') ?>",
                data: {
                    id: $(this).data('id')
                },
                dataType: "json",
                success: function(response) {
                    $(".view-pelunasan-sewa").html(response.view).show();
                    $("#modalPelunasanSewa").modal('show');
                    $('#modalPelunasanSewa').on('shown.bs.modal', function(event) {
                        $("#bayar").focus();
                    })
                },
                error: function(xhr, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });

        });

        $(".hapus-sewa").click(function(e) {
            e.preventDefault();
            let id = $(this).data('id');
            let property = $(this).data('property');
            Swal.fire({
                title: 'Hapus?',
                html: `yakin ingin menghapus sewa <strong>${property}</strong>?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Tidak'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "post",
                        url: "<?= base_url('persewaan/delete_sewa') ?>",
                        data: {
                            id: $(this).data('id')
                        },
                        dataType: "json",
                        success: function(response) {
                            if (response.sukses) {

                                berlangsung();
                                Swal.fire(
                                    'Deleted!',
                                    'Your file has been deleted.',
                                    'success'
                                )
                            }

                        },
                        error: function(xhr, thrownError) {
                            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                        }
                    });
                }
            })
        })
    });
</script>