<div class="modal fade" id="modalDetailSewa" tabindex="-1" aria-labelledby="modalDetailSewa" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDetailSewa">Detail Sewa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-sm table-borderless">

                        <tbody>
                            <tr>
                                <td>No Transaksi</td>
                                <td>:</td>
                                <td><strong><?= $sewa['faktur'] ?></strong></td>
                            </tr>
                            <tr>
                                <td>Pedagang</td>
                                <td>:</td>
                                <td><strong><?= $sewa['pedagang'] ?></strong></td>
                            </tr>
                            <tr>
                                <td>NIK</td>
                                <td>:</td>
                                <td><strong><?= $sewa['nik'] ?></strong></td>
                            </tr>
                            <tr>
                                <td>Kode Property</td>
                                <td>:</td>
                                <td><strong><?= $sewa['kode_property'] ?></strong></td>
                            </tr>
                            <tr>
                                <td>Jenis Property</td>
                                <td>:</td>
                                <td><strong><?= $sewa['jenis_property'] ?></strong></td>
                            </tr>
                            <tr>
                                <td>Jenis Usaha</td>
                                <td>:</td>
                                <td><strong><?= $sewa['jenis_usaha'] ?></strong></td>
                            </tr>
                            <tr>
                                <td>Tanggal Sewa</td>
                                <td>:</td>
                                <td><strong><?= date('d-m-Y', strtotime($sewa['tanggal_sewa'])) ?></strong></td>
                            </tr>
                            <tr>
                                <td>Tanggal Selesai</td>
                                <td>:</td>
                                <td><strong><?= date('d-m-Y', strtotime($sewa['tanggal_batas'])) ?></strong></td>
                            </tr>
                            <tr>
                                <td>Harga</td>
                                <td>:</td>
                                <td><strong>Rp. <?= number_format($sewa['harga_sewa'], "0", ",", ",") ?></strong></td>
                            </tr>
                            <tr>
                                <td>Terbayar</td>
                                <td>:</td>
                                <td><strong>Rp. <?= number_format($sewa['total_bayar'], "0", ",", ",") ?></strong></td>
                            </tr>
                            <tr>
                                <?php $kekurangan =  ($sewa['harga_sewa'] - $sewa['total_bayar']);
                                $kembalian =  ($sewa['total_bayar'] - $sewa['harga_sewa']);
                                ?>
                                <td>Kekurangan</td>
                                <td>:</td>
                                <td><strong class="<?= $kekurangan > 0 ? 'text-danger' : '' ?>">Rp. <?= number_format(($kekurangan > 0 ? $kekurangan : 0), "0", ",", ",") ?></strong></td>
                            </tr>
                            <tr>
                                <td>kembalian</td>
                                <td>:</td>
                                <td><strong class="<?= $kembalian > 0 ? 'text-success' : '' ?>">Rp. <?= number_format(($kembalian > 0 ? $kembalian : 0), "0", ",", ",") ?></strong></td>
                            </tr>
                            <tr>
                                <td>Status</td>
                                <td>:</td>
                                <?php if ($kekurangan >= 0 && strtotime(date('Y-m-d')) < strtotime($sewa['tanggal_batas'])) : ?>
                                    <td><span class="badge badge-outline-success">Aktif</span></td>
                                <?php elseif ($kekurangan <= 0 && strtotime(date('Y-m-d')) > strtotime($sewa['tanggal_batas'])) : ?>
                                    <td><span class="badge badge-outline-biru">Selesai</span></td>
                                <?php elseif ($kekurangan > 0 && strtotime(date('Y-m-d')) > strtotime($sewa['tanggal_batas'])) : ?>
                                    <td><span class="badge badge-outline-danger">Terlambat</span></td>
                                <?php endif ?>
                            </tr>

                        </tbody>
                    </table>
                </div>
                <button class="btn btn-info btn-sm mb-2" id="cetak">Cetak</button>
                <div class="table-responsive">
                    <table class="table table-bordered table-sm">
                        <thead>
                            <tr>
                                <th>Tanggal bayar</th>
                                <th>Metode</th>
                                <th>Penerima</th>
                                <th>Keterangan</th>
                                <th>Bukti</th>
                                <th>Bayar (Rp)</th>
                                <?php if (in_groups('admin')) : ?>
                                    <th class="text-center">Aksi</th>
                                <?php endif ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $total = 0;
                            foreach ($history_bayar as $rent) :
                                $total += $rent['bayar'];

                            ?>
                                <tr>
                                    <td><?= date('d-m-Y H:i', strtotime($rent['tanggal_bayar'])) ?> </td>
                                    <td><?= $rent['metode_bayar'] ?></td>
                                    <td><?= $rent['username'] ?></td>
                                    <td class="<?= $rent['keterangan'] == '' ? 'text-center' : '' ?>"><?= $rent['keterangan'] == '' ? '-' : $rent['keterangan'] ?></td>

                                    <td style="width: 140px;" class="text-<?= empty($rent['bukti']) ? 'center' : '' ?>"><?= empty($rent['bukti']) ? '-' : '<a href="/img/upload/' . $rent['bukti'] . '" target="_blank">Lihat Bukti</a>' ?></td>

                                    <td><?= number_format($rent['bayar'], "0", ",", ",") ?></td>
                                    <?php if (in_groups('admin')) : ?>
                                        <td class="text-center">
                                            <!-- <button class="btn btn-warning btn-sm edit-pembayaran-sewa" title="Ubah" data-id="<?= $rent['transaksiId'] ?>"><i class="fa fa-edit"></i></button> -->
                                            <button class="btn btn-danger btn-sm delete-pembayaran-sewa" title="Hapus" data-id="<?= $rent['transaksiId'] ?>" data-bayar="<?= number_format($rent['bayar'], "0", ",", ",") ?>"><i class="fa fa-trash-alt"></i></button>
                                        </td>
                                    <?php endif ?>
                                </tr>
                            <?php endforeach ?>
                            <tr>
                                <td colspan="5" class="text-center"><strong>Total</strong></td>
                                <td colspan=""><strong><?= number_format($total, 0, ",", ","); ?></strong>
                                </td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="ubah-pembayaran-sewa" style="display: none;"></div>

<script>
    $(document).ready(function() {
        $(".edit-pembayaran-sewa").click(function(e) {
            e.preventDefault();
            $.ajax({
                type: "post",
                url: "<?= base_url('persewaan/edit_pembayaran_sewa') ?>",
                data: {
                    id: $(this).data('id'),
                    faktur: "<?= $sewa['faktur'] ?>",
                    pedagang: "<?= $sewa['pedagang'] ?>",
                    property: "<?= $sewa['kode_property'] ?>",
                },
                dataType: "json",
                success: function(response) {
                    $("#modalDetailSewa").modal('hide');
                    $('#modalDetailSewa').on('hidden.bs.modal', function(event) {
                        $(".ubah-pembayaran-sewa").html(response.view).show();
                        $("#modalEditPembayaranSewa").modal('show');
                    })
                },
                error: function(xhr, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        });

        $(".delete-pembayaran-sewa").click(function(e) {
            let bayar = $(this).data('bayar');
            Swal.fire({
                title: 'Hapus?',
                html: `yakin ingin menghapus pembayaran sewa <strong><?= $sewa['kode_property'] ?></strong> senilai <strong>Rp ${bayar}</strong>?`,
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
                        url: "<?= base_url('persewaan/hapus_pembayaran_sewa') ?>",
                        data: {
                            id: $(this).data('id')
                        },
                        dataType: "json",
                        success: function(response) {
                            $("#modalDetailSewa").modal('hide');
                            $('#modalDetailSewa').on('hidden.bs.modal', function(event) {
                                berlangsung();
                                Swal.fire(
                                    'Deleted!',
                                    'Your file has been deleted.',
                                    'success'
                                )
                            })
                        }
                    });
                }
            })
        });

        $("#cetak").click(function(e) {
            e.preventDefault();
            var print = window.open("<?= base_url('export/print/' . $sewa['faktur']) ?>");
            print.print();
        })
    });
</script>