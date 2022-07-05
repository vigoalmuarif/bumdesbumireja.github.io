<div class="table-responsive">
    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th class="text-center">No</th>
                <th>Nama Pedagang</th>
                <th>Tarif</th>
                <th class="text-center">Jumlah Sewa</th>
                <th>Tagihan (Rp)</th>
                <th>Kekurangan (Rp)</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>

            <?php
            $no = 1;
            if ($periode < 0) : ?>
                <tr>
                    <td>kosng</td>
                </tr>
                <?php else :
                foreach ($bulanan as $key) :
                    $kekurangan = $key['totalTarif'] - $key['total_setor'];
                ?>
                    <tr>
                        <td class="text-center"><?= $no++; ?></td>
                        <td><?= $key['pedagang'] ?></td>
                        <td><?= number_format($key['tarif'], 0, '.', '.'); ?></td>
                        <td class="text-center"><?= $key['totalTarif'] / $key['tarif']; ?></td>
                        <td><?= number_format($key['totalTarif'], 0, '.', '.'); ?></td>
                        <td class="text-<?= $kekurangan > 0 ? 'danger' : 'success' ?>"><?= number_format($kekurangan, 0, '.', '.'); ?></td>
                        <?php if ($kekurangan > 0) : ?>
                            <td class="text-center"><span class="badge badge-outline-danger">Menunggu</span></td>
                        <?php else : ?>
                            <td class="text-center"><span class="badge badge-outline-success">Lunas</span></td>
                        <?php endif ?>
                        <td class="text-center">
                            <button type="button" class="btn btn-info btn-sm edit-pembayaran-bulanan" data-aksi="1" data-id="<?= $key['tagihanId'] ?>" data-periode="<?= $key['periode'] ?>"> <i class="fa fa-history"></i></button>
                            <button type="button" class="btn btn-danger btn-sm delete-pembayaran-bulanan" data-aksi="1" data-id="<?= $key['tagihanId'] ?>"><i class="fa fa-trash-alt"></i></button>

                        </td>
                    </tr>
                <?php endforeach ?>
            <?php endif ?>
        </tbody>
    </table>
</div>
<div class="pembayaran-tagihan-bulanan" style="display: none;"></div>
<script>
    function detail() {
        $(".edit-pembayaran-bulanan").click(function(e) {
            e.preventDefault();
            $.ajax({
                type: "post",
                url: "<?= base_url('persewaan/edit_pembayaran_tagihan_bulanan') ?>",
                data: {
                    id: $(this).data('id'),
                    aksi: 1,
                    periode: $(this).data('periode')
                },
                dataType: "json",
                success: function(response) {
                    $(".pembayaran-tagihan-bulanan").html(response.view).show();
                    $("#modalEditTagihanBulanan").modal('show');
                },
                error: function(xhr, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }

            });
        })
    }
    $(document).ready(function() {
        detail();


        $(".delete-pembayaran-bulanan").click(function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Hapus?',
                html: "Yakin ingin menghapus pembayaran tagihan bulanan <?= '<strong>' . $periode['pedagang'] . '</strong> periode ' . $periode['periode'] ?>?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Tidak'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "post",
                        url: "<?= base_url('persewaan/delete_pedagang_by_periode') ?>",
                        data: {
                            id: $(this).data('id'),
                            bayar: $(this).data('bayar'),
                            pembayaran_id: $(this).data('pembayaran'),
                        },
                        dataType: "json",
                        success: function(response) {
                            window.location.reload();
                        },
                        error: function(xhr, thrownError) {
                            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                        }
                    });
                }
            })
        });
    })
</script>