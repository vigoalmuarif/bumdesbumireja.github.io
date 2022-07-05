<!-- Custom styles for this page -->
<link href="<?= base_url() ?>/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

<div class="modal fade" id="modalProperty" tabindex="-1" aria-labelledby="modalProperty" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalProperty">Daftar Property</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>kode</th>
                                <th>Jenis</th>
                                <th>Harga</th>
                                <th>Jangka</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            foreach ($property as $properti) : ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $properti['kode_property']; ?></td>
                                    <td><?= $properti['jenis_property']; ?></td>
                                    <td>Rp. <?= number_format($properti['harga'], 0, ".", ".") ?></td>
                                    <td><?= $properti['jangka']; ?> Tahun</td>
                                    <td><span class="badge badge-success"><?= $properti['status'] == 1  ? 'Tersedia' : 'Disewa' ?></span></td>
                                    <td>
                                        <button type="button" class="btn btn-primary btn-sm btn-block pilih-property" data-id="<?= $properti['property_id'] ?>" data-kode="<?= $properti['kode_property'] ?>" data-jenis="<?= $properti['jenis_property'] ?>" data-fasilitas="<?= $properti['fasilitas'] ?>" data-harga="<?= $properti['harga'] ?>" data-jangka="<?= $properti['jangka'] ?>" title="Detail" id="pilih-property">
                                            Pilih
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach ?>

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


<script>
    $(document).ready(function() {
        $(".pilih-property").click(function(e) {
            e.preventDefault();
            let tempo = $(this).data('jangka');
            let kode = $(this).data('kode');
            let id = $(this).data('id');
            let harga = $(this).data('harga');
            $.ajax({
                type: "post",
                url: "<?= base_url('persewaan/temp_item') ?>",
                data: {
                    'id': id,
                    'kode': kode,
                    'jenis': $(this).data('jenis'),
                    'jangka': tempo,
                    'harga': harga,
                    'fasilitas': $(this).data('fasilitas'),
                },
                dataType: "json",
                success: function(response) {
                    $("#modalProperty").modal('hide');
                    $('#modalProperty').on('hidden.bs.modal', function(e) {
                        $("#formCariProperty").val(kode);
                        $("#formTransaksi").show();
                        $("#jenisPembayaran").val('');
                        $("#metodePembayaran").val('');
                        detail_item();
                    })
                },
                error: function(xhr, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });

        })
    })
</script>

<!-- Page level plugins -->
<script src="<?= base_url() ?>/vendor/datatables/jquery.dataTables.min.js"></script>

<script src="<?= base_url() ?>/vendor/datatables/dataTables.bootstrap4.min.js"></script>

<!-- Page level custom scripts -->
<script src="<?= base_url() ?>/js/demo/datatables-demo.js"></script>