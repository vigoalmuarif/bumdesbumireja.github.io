<div class="row">
    <div class="col">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <?php if (in_groups(['bendahara'])) : ?>
                    <div class="export float-right btn-sm" id="export"></div>
                <?php endif ?>
                <h6 class="m-0 font-weight-bold text-primary mt-2">Laporan Per Produk Bulan</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Faktur</th>
                                <th class="text-left">Pedagang</th>
                                <th class="text-left">Property</th>
                                <th>Tgl Sewa</th>
                                <th>Tgl Selesai</th>
                                <th>Status</th>
                                <th>Harga</th>
                                <th>Bayar</th>
                                <th>Kekurangan</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $total_harga = 0;
                            $total_bayar = 0;
                            $total_kekurangan = 0;
                            foreach ($laporan as $row) :
                                $status = $row['hargasewa'] - $row['total_bayar'];
                                $terbayar = $row['bayar'] - $row['kembalian'];
                                $total_harga += $row['hargasewa'];
                                $total_bayar += $row['bayar'] - $row['kembalian'];
                                $total_kekurangan += ($row['hargasewa'] - ($row['bayar'] - $row['kembalian']));

                            ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $row['faktur'] ?></td>
                                    <td><?= $row['pedagang'] . ' (' . $row['jenis_usaha'] . ')'  ?></td>
                                    <td><?= $row['jenis_property'] . ' (' . $row['kode_property'] . ')' ?></td>
                                    <td><?= date('d/m/Y', strtotime($row['tanggal_sewa'])) ?></td>
                                    <td><?= date('d/m/Y', strtotime($row['tanggal_batas'])) ?></td>
                                    <td><?= $status > 0 ? 'Belum Lunas' : 'Lunas' ?></td>
                                    <td class="text-right"><?= number_format($row['hargasewa'], 0) ?></td>
                                    <td class="text-right"><?= number_format($terbayar, 0) ?></td>
                                    <td class="text-right"><?= number_format($status > 0 ? $status : '0', 0) ?></td>


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
                                <th></th>
                                <th></th>
                                <th><?= number_format($total_harga, 0); ?></th>
                                <th><?= number_format($total_bayar, 0); ?></th>
                                <th><?= number_format($total_kekurangan, 0); ?></th>

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
                    title: 'Laporan Sewa Kios dan Los Pasar Bumireja',
                    messageTop: 'Jenis Property :<?= $jenis . ' | ' . 'Status :' . $type ?>',
                    text: '<i class="fas fa-file-excel"></i> Excel',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9]
                    }

                },
                {
                    extend: 'pdfHtml5',
                    orientation: 'landscape',
                    footer: true,
                    messageTop: 'Jenis Property :<?= $jenis . ' | ' . 'Status :' . $type ?>',
                    messageBottom: window.location.href,
                    download: 'open',
                    text: '<i class="fas fa-file-pdf"></i> PDF',
                    title: 'Laporan Sewa Kios dan Los Pasar Bumireja',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9]
                    },

                },
            ]
        });

        table.buttons().container()
            .appendTo($('#export'));
    })
</script>