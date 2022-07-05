<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800 d-inline">Tagihan Bulanan</h1>
<div class="export float-right btn-sm" id="export"></div>
<hr class="sidebar-divider d-none d-md-block">
<div class="row">
    <div class="col">

        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th>Periode</th>
                        <th>Sewa</th>
                        <th>Tarif</th>
                        <th>Kekurangan</th>
                        <th>Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    if ($count > 0) :
                        $no = 1;
                        foreach ($bulanan as $key) :
                            if ($key['tarif'] > $key['bayar']) {
                                $kekurangan = ($key['tarif'] - $key['bayar']);
                            } else {
                                $kekurangan = 0;
                            }

                    ?>
                            <tr>
                                <td class="text-center"><?= $no++; ?></td>
                                <td id="periode"><?= bulan_tahun($key['periode']) ?></td>
                                <td><?= $key['kode_property'] ?></td>
                                <td class="tarif">Rp. <?= number_format($key['tarif'], 0, '.', '.'); ?></td>
                                <td class="bayar">Rp. <?= number_format(($kekurangan), 0, '.', '.'); ?></td>
                                <td><?= $key['tarif'] > $key['bayar'] ? '<span class="badge badge-danger">Belum lunas</span>' : '<span class="badge badge-success">Lunas</span>' ?></td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-<?= $key['bayar'] >= $key['tarif'] ? 'secondary' : 'success' ?> bayar-tagihan-bulanan" data-id="<?= $key['tagihanId'] ?>" data-bayar="<?= $key['bayar']; ?>" title="Bayar" <?= $key['bayar'] >= $key['tarif'] ? 'disabled' : '' ?>><i class="fa fa-money-bill-alt"></i></button>
                                    <button class="btn btn-sm btn-info riwayat-bayar-bulanan" title="Riwayat bayar" data-id="<?= $key['tagihanId'] ?>" data-periode="<?= $key['periode'] ?>" data-property="<?= $key['kode_property'] ?>"><i class="fa fas fa-history"></i></button>
                                    <button class="btn btn-sm btn-danger hapus-tagihan-bulanan" title="Hapus" data-id="<?= $key['tagihanId'] ?>" data-periode="<?= bulan_tahun($key['periode']) ?>"><i class="fa fas fa-trash-alt"></i></button>
                                </td>

                            </tr>
                        <?php endforeach ?>
                    <?php else : ?>

                        <tr>
                            <td colspan="8" class="text-center">Belum ada tagihan bulanan</td>
                        </tr>

                    <?php endif ?>

                </tbody>
            </table>
        </div>
    </div>
    <div class="pembayaran-tagihan-bulanan" style="display: none;"></div>
    <?php if ($count > 0) : ?>

        <script>
            $(document).ready(function() {
                $("#dataTable").dataTable();

                $(".hapus-tagihan-bulanan").click(function(e) {
                    let periode = $(this).data('periode');
                    Swal.fire({
                        title: 'Hapus?',
                        html: `Yakin ingin menghapus tagihan bulanan  periode <strong>${periode}</strong>?`,
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
                                url: "<?= base_url('persewaan/hapus_tagihan_bulanan/') ?>",
                                data: {
                                    id: $(this).data('id')
                                },
                                dataType: "json",
                                success: function(response) {
                                    if (response.sukses) {
                                        tagihanBulanan();
                                    }
                                }
                            });
                            Swal.fire(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                            )
                        }
                    })
                })

                $(".bayar-tagihan-bulanan").click(function(e) {
                    e.preventDefault();
                    $.ajax({
                        type: "post",
                        url: "<?= base_url('persewaan/pembayaran_tagihan_bulanan') ?>",
                        data: {
                            id: $(this).data('id'),
                            aksi: $(this).data('aksi'),
                            bayar: $(this).data('bayar')
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
                });
                $(".riwayat-bayar-bulanan").click(function(e) {
                    e.preventDefault();
                    $.ajax({
                        type: "post",
                        url: "<?= base_url('persewaan/riwayat_bayar_bulanan') ?>",
                        data: {
                            id: $(this).data('id'),
                            aksi: $(this).data('aksi'),
                            periode: $(this).data('periode'),
                            property: $(this).data('property'),
                            pedagang: '<?= $pedagang['pedagang']  ?>',
                            nik: "<?= $pedagang['nik']  ?>",

                        },
                        dataType: "json",
                        success: function(response) {
                            $(".pembayaran-tagihan-bulanan").html(response.view).show();
                            $("#modalRiwayatTagihanBulanan").modal('show');

                        },
                        error: function(xhr, thrownError) {
                            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                        }

                    });
                });

                var table = $('#dataTable').DataTable({
                    buttons: [{
                        extend: 'print',
                        messageTop: '<?= $pedagang['pedagang'] . ' [' . $pedagang['nik'] . ']' ?>',
                        messageBottom: window.location.href,
                        text: '<i class="fas fa-print"></i> Cetak semua',
                        title: 'Tagihan Bulanan',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5]
                        },
                    }, ],
                    "bDestroy": true

                });
                // table.destroy();

                table.buttons().container()
                    .appendTo($('#export'));
            })
        </script>
    <?php endif ?>