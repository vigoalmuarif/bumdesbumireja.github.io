<?= $this->extend('templates/index'); ?>

<?= $this->section('content'); ?>

<div class="row">

    <div class="col">
        <div class="card shadow mb-4">
            <!-- Card Header - Accordion -->
            <a href="#collapseCardExample" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">
                <h6 class="m-0 font-weight-bold text-primary text-center">Pengelolaan ATK</h6>
            </a>
            <!-- Card Content - Collapse -->
            <div class="collapse show" id="collapseCardExample">
                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th rowspan="2" class="text-center py-auto">Keterangan</th>
                                    <th colspan="2" class="text-center">Masuk</th>
                                    <th colspan="2" class="text-center">Keluar</th>
                                </tr>
                                <tr>
                                    <th>Tunai</th>
                                    <th colspan="">Piutang</th>
                                    <th colspan="">Tunai</th>
                                    <th colspan="">Hutang</th>

                                </tr>
                            </thead>
                            <tbody>

                                <tr>
                                    <td>Penjualan</td>
                                    <td>Pembelian</td>
                                    <td>asd</td>
                                    <td>asd</td>
                                    <td>asd</td>
                                </tr>
                                <tr>
                                    <td>Pembelian</td>
                                    <td>asd</td>
                                    <td>asd</td>
                                    <td>asd</td>
                                    <td>asd</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Total</th>
                                    <th>Rp 400.000</th>
                                    <th>Rp 400.000</th>
                                    <th>Rp 400.000</th>
                                    <th>Rp 400.000</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>



                </div>
            </div>
        </div>


        <div class="card shadow mb-4">
            <!-- Card Header - Accordion -->
            <a href="#collapseCardExample" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">
                <h6 class="m-0 font-weight-bold text-primary text-center">Pengelolaan ATK</h6>
            </a>
            <!-- Card Content - Collapse -->
            <div class="collapse show" id="collapseCardExample">
                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th rowspan="2" class="text-center py-auto">Keterangan</th>
                                    <th colspan="2" class="text-center">Masuk</th>
                                    <th colspan="2" class="text-center">Keluar</th>
                                </tr>
                                <tr>
                                    <th>Tunai</th>
                                    <th colspan="">Piutang</th>
                                    <th colspan="">Tunai</th>
                                    <th colspan="">Hutang</th>

                                </tr>
                            </thead>
                            <tbody>

                                <tr>
                                    <td>Penjualan</td>
                                    <td>Pembelian</td>
                                    <td>asd</td>
                                    <td>asd</td>
                                    <td>asd</td>
                                </tr>
                                <tr>
                                    <td>Pembelian</td>
                                    <td>asd</td>
                                    <td>asd</td>
                                    <td>asd</td>
                                    <td>asd</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Total</th>
                                    <th>Rp 400.000</th>
                                    <th>Rp 400.000</th>
                                    <th>Rp 400.000</th>
                                    <th>Rp 400.000</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>



                </div>
            </div>
        </div>





    </div>
</div>

<?= $this->endSection() ?>