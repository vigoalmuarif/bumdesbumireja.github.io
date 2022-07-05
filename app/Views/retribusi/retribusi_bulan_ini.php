<div class="row">
    <div class="col">
        <div class="card shadow mb-4">
            <div class="card-header py-3">

                <h6 class="m-0 font-weight-bold text-primary mt-2">Retribusi Bulan <?= bulan_tahun('Y-m-d') ?></h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Retribusi</th>
                                <th>Total</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            <?php foreach ($retribusi as $retri) : ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= longdate_indo($retri['tanggal']); ?></td>
                                    <td>Rp <?= $retri['bayar'] ?></td>
                                    <td>Rp <?= number_format($retri['total'], 0, ".", ".") ?>20.000</td>
                                    <td>Rp <?= number_format($retri['total'], 0, ".", ".") ?>20.000</td>
                                    <td>Rp <?= number_format($retri['total'], 0, ".", ".") ?>20.000</td>
                                    <td>Rp <?= number_format($retri['total'], 0, ".", ".") ?>20.000</td>
                                    <td>Rp <?= number_format($retri['total'], 0, ".", ".") ?>20.000</td>

                                    <td>
                                        <a href="<?= base_url('periode/listRetribusi/' . $retri['id']) ?>" class="btn btn-info btn-sm">Lihat</a>
                                    </td>
                                </tr>
                            <?php endforeach ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>