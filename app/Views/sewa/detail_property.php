<div class="modal fade" id="modalDetailProperty" tabindex="-1" aria-labelledby="modalDetailProperty" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDetailProperty">Detail Property</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-sm table-borderless">
                        <tbody>
                            <tr>
                                <td>Kode Propeerty</td>
                                <td>:</td>
                                <td><strong><?= $property['kode_property'] ?></strong></td>
                            </tr>
                            <tr>
                                <td>Jenis Property</td>
                                <td>:</td>
                                <td><strong><?= $property['jenis_property'] ?></strong></td>
                            </tr>
                            <tr>
                                <td>Luas Tanah</td>
                                <td>:</td>
                                <td><strong><?= $property['luas_tanah'] ?> m</strong></td>
                            </tr>
                            <tr>
                                <td>Luas Bangunan</td>
                                <td>:</td>
                                <td><strong><?= $property['luas_bangunan'] ?> m</strong></td>
                            </tr>
                            <tr>
                                <td>Harga (Rp)</td>
                                <td>:</td>
                                <td><strong><?= number_format($property['harga'], "0", ",", ",") . ' / ' . $property['jangka'] . ' Tahun' ?></strong></td>
                            </tr>
                            <tr>
                                <td>Fasilitas</td>
                                <td>:</td>
                                <td><strong><?= $property['fasilitas'] ?></strong></td>
                            </tr>
                            <tr>
                                <td>Status</td>
                                <td>:</td>
                                <td><strong class="<?= $property['status'] == 1 ? 'text-success' : 'text-danger'; ?>"><?= $property['status'] == 1 ? 'Tersedia' : 'Disewa'; ?></strong></td>
                            </tr>
                            <tr>
                                <td>Alamat</td>
                                <td>:</td>
                                <td><strong><?= $property['alamat'] ?></strong></td>
                            </tr>
                            <tr>
                                <td>Keterangan</td>
                                <td>:</td>
                                <td><strong><?= $property['keterangan'] ?></strong></td>
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