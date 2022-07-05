<div class="modal fade" id="modalRiwayatTagihanBulanan" tabindex="-1" aria-labelledby="modalRiwayatTagihanBulananLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalRiwayatTagihanBulananLabel"><?= bulan_tahun($periode) . ' ' . '(' . $property . ')' ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php if ($total > 0) : ?>
                    <form action="<?= base_url('export/printpembayaranbulanan/' . $id) ?>" method="post" id="cetak">
                        <input type="hidden" name="periode" id="" value="<?= $periode ?>">
                        <input type="hidden" name="property" id="" value="<?= $property ?>">
                        <input type="hidden" name="pedagang" id="" value="<?= $pedagang ?>">
                        <input type="hidden" name="nik" id="" value="<?= $nik ?>">
                        <input type="hidden" name="tarif" id="" value="<?= $tarif ?>">
                        <input type="hidden" name="bayar" id="" value="<?= $bayar ?>">
                        <input type="hidden" name="id" id="" value="<?= $id ?>">
                        <button type="submit" class="btn btn-info btn-sm mb-2 float-right">Cetak</button>
                    </form>
                    <!-- <a href="" class="btn btn-info btn-sm mb-2 float-right" id="cetakpembayaran">Cetak Tagihan Bulanan</a> -->
                <?php endif ?>
                <table class="mb-3">
                    <tr>
                        <td>Tarif</td>
                        <td>:</td>
                        <td>Rp <?= number_format($tarif, 0); ?></td>
                    </tr>
                    <tr>
                        <td>Total Bayar</td>
                        <td>:</td>
                        <td>Rp <?= number_format($bayar, 0); ?></td>
                    </tr>
                    <tr>
                        <td>Kekurangan</td>
                        <td>:</td>
                        <td>Rp <?= number_format(($bayar < $tarif ? ($tarif - $bayar) : 0), 0); ?></td>
                    </tr>
                    <tr>
                        <td>Kembalian</td>
                        <td>:</td>
                        <td>Rp <?= number_format(($bayar > $tarif ? ($bayar - $tarif) : 0), 0); ?></td>
                    </tr>
                </table>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal Masuk</th>
                                <th>Metode</th>
                                <th>Keterangan</th>
                                <th>Bayar (Rp)</th>
                                <th>Bukti</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($total > 0) :

                                $no = 1;
                                $total = 0;
                                foreach ($history as $row) :
                                    $total += $row['bayar'];
                            ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= date('d-m-Y H:i', strtotime($row['tanggal_bayar'])); ?></td>
                                        <td><?= $row['metode']; ?></td>
                                        <td><?= $row['keterangan'] ?></td>
                                        <td class="text-right"><?= number_format($row['bayar'], 0, ",", ","); ?></td>

                                        <td class="text-<?= empty($row['bukti']) ? 'center' : '' ?>"><?= empty($row['bukti']) ? '-' : '<a href="/img/upload/' . $row['bukti'] . '" target="_blank">Lihat Bukti</a>'; ?></td>

                                        <td class="text-center">
                                            <!-- <button class="btn btn-sm btn-warning ubah-nominal-pembayaran-tagihan" title="Ubah" data-id="<?= $row['transaksiId'] ?>"><i class="fa fas fa-edit"></i></button> -->
                                            <button class="btn btn-sm btn-danger hapus-pembayaran-bulanan" title="Hapus" data-id="<?= $row['transaksiId'] ?>" data-tagihan="<?= $row['tagihanId'] ?>" data-setor="<?= $row['bayar'] ?>" data-bayar=" <?= number_format($row['bayar'], 0, ",", ","); ?>" data-bukti="<?= $row['bukti']; ?>"><i class="fa fas fa-trash-alt"></i></button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                <tr>
                                    <td class="text-right" colspan="4"><strong>Total(Rp)</strong></td>
                                    <td class="text-right" colspan=""><strong><?= number_format($total, 0, ",", ","); ?></strong>
                                    </td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            <?php else : ?>
                                <tr>
                                    <td colspan="6" class="text-center">Belum ada data pembayaran</td>
                                </tr>
                            <?php endif ?>
                        </tbody>
                    </table>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">tutup</button>
            </div>
        </div>
    </div>
</div>

<div class="ubah-nominal-pembayaran-bulanan" style="display: none;"></div>

<script>
    $(document).ready(function() {
        $(".ubah-nominal-pembayaran-tagihan").click(function(e) {
            e.preventDefault();
            $.ajax({
                type: "get",
                url: "<?= base_url('persewaan/edit_nominal_pembayaran_bulanan')  ?>",
                data: {
                    id: $(this).data('id')
                },
                dataType: "json",
                success: function(response) {
                    $("#modalRiwayatTagihanBulanan").modal('hide');
                    $('#modalRiwayatTagihanBulanan').on('hidden.bs.modal', function(event) {
                        $(".ubah-nominal-pembayaran-bulanan").html(response.view).show();
                        $("#modalUbahNominalTagihanBulanan").modal('show');
                    })
                },
                error: function(xhr, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        })
        $(".hapus-pembayaran-bulanan").click(function(e) {
            e.preventDefault();
            let id = $(this).data('id');
            let bayar = $(this).data('bayar');

            Swal.fire({
                title: 'Hapus?',
                html: `Yakin ingin menghapus pembayaran tagihan Rp <strong>${bayar}</strong>?`,
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
                        url: "<?= base_url('persewaan/delete_riwayat_bayar_by_id')  ?>",
                        data: {
                            id: $(this).data('id'),
                            tagihan: $(this).data('tagihan'),
                            bayar: $(this).data('setor'),
                            bukti: $(this).data('bukti')
                        },
                        dataType: "json",
                        success: function(response) {
                            $("#modalRiwayatTagihanBulanan").modal('hide');
                            $('#modalRiwayatTagihanBulanan').on('hidden.bs.modal', function(event) {
                                tagihanBulanan();
                                Swal.fire(
                                    'Dihapus!',
                                    'Pembayaran berhasil dihapus.',
                                    'success'
                                )
                            })
                        },
                        error: function(xhr, thrownError) {
                            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                        }
                    });

                }
            })

        })


    })
</script>