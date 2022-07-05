<!-- Modal -->
<div class="modal fade" id="modalDetailPenjualan" tabindex="-1" aria-labelledby="modalDetailPenjualanLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header danger">
                <h5 class="modal-title" id="modalDetailPenjualanLabel">Detail Penjualan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card border-light border-lg mb-3">
                    <div class="card-body">
                        <button class="btn btn-sm btn-info cetak"><i class="fa fas fa-print"> </i> Cetak</button>

                        <table class="table table-borderless table-sm">
                            <thead>

                            </thead>
                            <tbody>
                                <tr>
                                    <td>Faktur</td>
                                    <td>:</td>
                                    <td><?= $total['faktur'] ?></td>
                                    <td>Tanggal</td>
                                    <td>:</td>
                                    <td><?= date('d/m/Y H:i', strtotime($total['date'])) ?></td>
                                </tr>

                                <tr>
                                    <td>Kasir</td>
                                    <td>:</td>
                                    <td><?= $total['username'] ?></td>
                                    <td>Pelanggan</td>
                                    <td>:</td>
                                    <td><?= $total['nama'] ?></td>
                                </tr>

                                <tr>
                                    <td>Status</td>
                                    <td>:</td>
                                    <td><?= $total['total'] > $total['terbayar'] ? '<span class="badge badge-outline-danger">Belum Lunas</span>' : '<span class="badge badge-outline-success">Lunas</span>' ?></td>
                                </tr>
                            </tbody>
                        </table>
                        <hr>

                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th>Total Harga</th>
                                        <th class="text-center">Bayar</th>
                                        <th class="text-right">Kekurangan</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $kekurangan = $total['totalHarga'] - $total['terbayar'] ?>
                                    <tr>
                                        <td>Rp <?= number_format($total['totalHarga'], 0, ',', ',') ?></td>
                                        <td class="text-center">Rp <?= number_format($total['terbayar'], 0, ',', ',') ?></td>
                                        <td class="text-right text-danger">Rp <?= number_format($kekurangan < 0 ? '0' : $kekurangan, 0, ',', ',') ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <hr>

                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>item</th>
                                        <th>Harga</th>
                                        <th>QTY</th>
                                        <th class="text-right">Sub Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    $totalHarga = 0;
                                    foreach ($detail as $det) : ?>
                                        <?php $totalHarga += $det['sub_total'] ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= empty($det['nama_lain']) ? $det['produk'] : $det['nama_lain'] ?></td>
                                            <td><?= number_format($det['harga'], 0, ',', ',') ?></td>
                                            <td><?= $det['qty_jual'] ?></td>
                                            <td class="text-right"><?= number_format($det['sub_total'], 0, ',', ',')  ?></td>
                                        </tr>

                                    <?php endforeach ?>
                                <tfoot>
                                    <tr>
                                        <th colspan="4">Total</th>
                                        <th class="text-right"><?= number_format($totalHarga, 0, ',', ',') ?></th>
                                    </tr>
                                </tfoot>
                                </tbody>
                            </table>
                        </div>
                        <?php if ($aksi == 1) : ?>
                            <hr>
                            <h5>Pembayaran</h5>
                            <div class="table-responsive">
                                <table class="table table-borderless">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal</th>
                                            <th>Kasir</th>
                                            <th class="text-right">Bayar</th>
                                            <!-- <th class="text-center">Aksi</th> -->

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if ($sum['pay'] == 0) : ?>
                                            <tr>
                                                <td colspan="4" class="text-center">Belum ada pembayaran</td>
                                            </tr>
                                            <?php else :
                                            $no = 1;
                                            $totalBayar = 0;
                                            foreach ($transaksi as $row) : ?>

                                                <tr>
                                                    <td><?= $no++ ?></td>
                                                    <td><?= date('d-m-Y H:i', strtotime($row['date'])) ?></td>
                                                    <td><?= $row['username'] ?></td>
                                                    <td class="text-right"><?= number_format($row['pay'], 0, ',', ',') ?></td>
                                                    <!-- <td class="text-center">
                                                        <button class="btn btn-danger btn-sm hapus" title="Hapus" data-id="<?= $row['transaksiID'] ?>" data-totalbayar="<?= $total['terbayar'] ?>" data-bayar="<?= number_format($row['pay'], 0, ',', ',') ?>" data-penjualan="<?= $row['penjualan_id'] ?>"><span class=" fas fa fa-trash-alt"></span></button>
                                                    </td> -->
                                                </tr>
                                                <?php $totalBayar += $row['pay'] ?>
                                            <?php endforeach ?>
                                    <tfoot>
                                        <tr>
                                            <th colspan=" 3">Total</th>
                                            <th class="text-right"><?= number_format($totalBayar, 0, ',', ',') ?></th>
                                        </tr>
                                    </tfoot>
                                <?php endif ?>
                                </tbody>
                                </table>
                            </div>
                        <?php endif ?>


                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {

        $(".hapus").click(function(e) {
            e.preventDefault();
            let bayar = $(this).data('bayar')
            let id = $(this).data('id');
            let totalBayar = $(this).data('totalbayar')
            let penjualan_id = $(this).data('penjualan')
            Swal.fire({
                title: 'Hapus?',
                html: `Yakin ingin menghapus pembayaran sebesar Rp. ${bayar}?`,
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
                        url: "<?= base_url('penjualan/delete_pembayaran_piutang') ?>",
                        data: {
                            id: id,
                            bayar: bayar,
                            totalBayar: totalBayar,
                            penjualan_id: penjualan_id
                        },
                        dataType: "json",
                        success: function(response) {
                            if (response.data) {
                                window.location.reload();
                            }
                        },
                        error: function(xhr, thrownError) {
                            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                        }
                    });

                }
            });
        });

        $(".cetak").click(function(e) {
            e.preventDefault();
            $.ajax({
                type: "post",
                url: "<?= base_url('penjualan/cetakstruk') ?>",
                data: {
                    faktur: '<?= $total['faktur'] ?>'
                },
                dataType: "json",
                success: function(response) {
                    if (response.print == 'sukses')
                        window.location.reload();
                },
                error: function(xhr, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        })

    })
</script>