<!-- Modal -->
<div class="modal fade" id="modalDetailPembelian" tabindex="-1" aria-labelledby="modalDetailPembelianLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header danger">
                <h5 class="modal-title" id="modalDetailPembelianLabel">Detail Pembelian</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card border-light border-lg mb-3">

                    <div class="card-body">
                        <button class="btn btn-sm btn-info print"><i class="fa fas fa-print"></i> Cetak</button>
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
                                    <td><?= date('d/m/Y', strtotime($total['date'])) ?></td>
                                </tr>
                                <tr>
                                    <td>Kasir</td>
                                    <td>:</td>
                                    <td><?= $total['username'] ?></td>
                                    <td>Supplier</td>
                                    <td>:</td>
                                    <td><?= $total['supplier'] ?></td>
                                </tr>

                                <tr>
                                    <td>Referensi</td>
                                    <td>:</td>
                                    <td><?= $total['referensi'] == "" ? '-' : $total['referensi'] ?></td>
                                    <td>Status</td>
                                    <td>:</td>
                                    <td><?= ($total['total'] - $total['diskon']) > $total['terbayar'] ? '<span class="badge badge-outline-danger">Belum Lunas</span>' : '<span class="badge badge-outline-success">Lunas</span>' ?></td>
                                </tr>

                            </tbody>
                        </table>
                        <hr>

                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th>Total Harga</th>
                                        <th class="text-center">Terbayar</th>
                                        <th class="text-right">Kekurangan</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Rp <?= number_format($total['totalHarga'] - $total['diskon'], 0, ',', ',') ?></td>
                                        <td class="text-center">Rp <?= number_format($total['terbayar'], 0, ',', ',') ?></td>
                                        <td class="text-right <?= $total['total'] > $total['terbayar'] ? 'text-danger' : 'text-grey' ?>">Rp <?= number_format(($total['totalHarga'] - $total['diskon']) - $total['terbayar'] < 0 ? 0 : ($total['totalHarga'] - $total['diskon']) - $total['terbayar'], 0, ',', ',') ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

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
                                            <td><?= $det['qty_beli'] ?></td>
                                            <td class="text-right"><?= number_format($det['sub_total'], 0, ',', ',')  ?></td>
                                        </tr>

                                    <?php endforeach ?>
                                <tfoot>
                                    <tr>
                                        <th>Sub Total</th>
                                        <th colspan="4" class="text-right"><?= number_format($totalHarga, 0, ',', ',') ?></th>

                                    </tr>
                                    <tr>
                                        <th>Diskon</th>
                                        <th colspan="4" class="text-right"><?= number_format($total['diskon'], 0, ',', ',') ?></th>

                                    </tr>
                                    <tr>
                                        <th>Total</th>
                                        <th colspan="4" class="text-right"><?= number_format($totalHarga - $total['diskon'], 0, ',', ',') ?></th>

                                    </tr>
                                </tfoot>
                                </tbody>
                            </table>
                        </div>
                        <?php

                        if ($aksi == 1) : ?>

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
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if ($sum['pay'] == 0) : ?>
                                            <tr>
                                                <td colspan="5" class="text-center">Belum ada pembayaran</td>
                                            </tr>
                                            <?php else :
                                            $no = 1;
                                            $totalBayar = 0;
                                            foreach ($transaksi as $row) : ?>
                                                <?php $totalBayar += $row['pay'] ?>
                                                <tr>
                                                    <td><?= $no++ ?></td>
                                                    <td><?= date('d-m-Y H:i', strtotime($row['date'])) ?></td>
                                                    <td><?= $row['username'] ?></td>
                                                    <td class="text-right"><?= number_format($row['pay'], 0, ',', ',') ?></td>
                                                    <td class="text-center">
                                                        <button class="btn btn-danger btn-sm hapus" title="Hapus" data-id="<?= $row['transaksiID'] ?>" data-totalbayar="<?= $total['terbayar'] ?>" data-bayar="<?= number_format($row['pay'], 0, ',', ',') ?>" data-pembelian="<?= $row['pembelian_id'] ?>"><span class=" fas fa fa-trash-alt" "></span></button>
                                                    </td>
                                            </tr>
                                        <?php endforeach ?>
                                <tfoot>
                                    <tr>
                                        <th>Total</th>
                                        <th colspan=" 3" class="text-right"><?= number_format($totalBayar, 0, ',', ',') ?></th>
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
            let pembelian_id = $(this).data('pembelian')
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
                        url: "<?= base_url('pembelian/delete_pembayaran_hutang') ?>",
                        data: {
                            id: id,
                            bayar: bayar,
                            totalBayar: totalBayar,
                            pembelian_id: pembelian_id
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


        $(".print").click(function(e) {
            e.preventDefault();
            $.ajax({
                type: "post",
                url: "<?= base_url('pembelian/cetakstruk') ?>",
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


    });
</script>