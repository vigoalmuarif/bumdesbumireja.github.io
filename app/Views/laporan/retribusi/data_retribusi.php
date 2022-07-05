<div class="row">
    <div class="col">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <?php if (in_groups(['bendahara'])) : ?>
                    <div class="export float-right btn-sm" id="export"></div>
                <?php endif ?>
                <h6 class="m-0 font-weight-bold text-primary mt-2">Laporan Retribusi</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal / Periode</th>
                                <th>Retribusi</th>
                                <th>Petugas</th>
                                <th>Status</th>
                                <th>Bayar</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $total_bayar = 0;
                            foreach ($laporan as $row) :
                                $total_bayar += $row['bayar'];


                            ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td class="text-left">
                                        <?= date('d-m-Y', strtotime($row['tanggal'])) ?>
                                    </td>
                                    <td><?= $row['retribusi'] ?></td>
                                    <td><?= $row['petugas'] ?></td>
                                    <td><?= $row['kerja'] == 1 ? 'Kerja' : 'Libur' ?></td>
                                    <td class="text-right"><?= number_format($row['bayar'], 0) ?></td>
                                    <td><?= $row['desc'] ?></td>
                                </tr>
                            <?php endforeach ?>

                        </tbody>
                        <tfoot class="footer" style="display: none;">
                            <tr>
                                <th class="text-center">Total</th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th><?= number_format($total_bayar, 0); ?></th>

                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="ubah-periode-bulanan"></div>

<script>
    $(document).ready(function() {
        var table = $('#dataTable').DataTable({
            buttons: [{
                    extend: 'excel',
                    footer: true,
                    title: 'Laporan Pembayaran Retribusi Pasar & Parkir',
                    messageTop: 'Pembayaran Retribusi tanggal <?= $start . ' sampai ' . $end ?>',
                    text: '<i class="fas fa-file-excel"></i> Excel',


                },
                {
                    extend: 'pdf',
                    orientation: 'potrait',
                    footer: true,
                    messageTop: 'Pembayaran Retribusi tanggal <?= $start . ' sampai ' . $end ?>',
                    messageBottom: window.location.href,
                    download: 'open',
                    text: '<i class="fas fa-file-pdf"></i> PDF',
                    title: 'Laporan Pembayaran Retribusi Pasar & Parkir',


                },
            ]
        });

        table.buttons().container()
            .appendTo($('#export'));
    })
</script>