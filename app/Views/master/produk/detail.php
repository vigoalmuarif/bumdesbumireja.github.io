<!-- Modal -->
<div class="modal fade" id="modalDetail" tabindex="-1" aria-labelledby="modalDetailLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDetailLabel">Detail Produk</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col">
                        <table class="table table-hover">
                            <tbody>
                                <tr>
                                    <td>SKU</td>
                                    <td>:</td>
                                    <td><?= $produk['sku']; ?></td>
                                </tr>
                                <tr>
                                    <td>Nama produk</td>
                                    <td>:</td>
                                    <td><?= $produk['produk']; ?></td>
                                </tr>
                                <tr>
                                    <td>Kategori</td>
                                    <td>:</td>
                                    <td><?= $produk['kategori']; ?></td>
                                </tr>
                                <tr>
                                    <td>Satuan Dasar</td>
                                    <td>:</td>
                                    <td><?= $produk['satuan']; ?></td>
                                </tr>
                                <tr>
                                    <td>Supplier</td>
                                    <td>:</td>
                                    <td><?= $produk['supplier']; ?></td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Barcode</th>
                                        <th>Nama Lain</th>
                                        <th>Satuan</th>
                                        <th>Isi</th>
                                        <th>Harga Dasar (Rp)</th>
                                        <th>Harga Jual (Rp)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                    use Faker\Core\Number;

                                    foreach ($harga as $price) : ?>

                                        <tr>
                                            <td class="text-<?= $price['barcode'] == '' ? 'center' : 'left' ?>"><?= $price['barcode'] == '' ? '-' : $price['barcode'] ?></td>
                                            <td><?= empty($price['nama_lain']) ? $price['produk'] : $price['nama_lain']; ?></td>
                                            <td><?= $price['satuan']; ?></td>
                                            <td><?= $price['isi'] . ' ' . $produk['satuan']  ?></td>
                                            <td><?= number_format($price['harga_dasar'], 0)  ?></td>
                                            <td><?= number_format($price['harga_jual'], 0) ?></td>
                                        </tr>
                                    <?php endforeach ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>