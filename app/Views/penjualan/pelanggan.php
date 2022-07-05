<!-- Modal -->
<!-- Custom styles for this page -->
<link href="<?= base_url() ?>/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">


<div class="modal fade" id="modalPelanggan" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modalPelangganLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <!-- <h5 class="modal-title" id="modalPelangganLabel">Pelanggan</h5> -->
                <button type="button" id="addPelanggan" class="btn btn-primary btn-sm mb-3">Tambah Pelanggan</button>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="dataTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>JK</th>
                                <th>Alamat</th>
                                <th>No Telepon</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            <?php foreach ($pelanggan as $customer) : ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= $customer['nama']; ?></td>
                                    <td><?= $customer['jk']; ?></td>
                                    <td><?= $customer['alamat']; ?></td>
                                    <td><?= $customer['no_hp']; ?></td>
                                    <td>
                                        <button class="btn btn-info btn-sm pilih-pelanggan" data-pelanggan="<?= $customer['nama']; ?>" data-id="<?= $customer['id']; ?>">Pilih</button>
                                    </td>

                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<div class="add-pelanggan" style="display: none;"></div>

<script>
    $(document).ready(function() {
        $(".pilih-pelanggan").on('click', function() {
            let pelanggan = $(this).data("pelanggan");
            let pelangganId = $(this).data("id");
            $("#pelanggan").val(pelanggan);
            $("#pelangganId").val(pelangganId);
            $("#modalPelanggan").modal('hide');
        });
    });

    $("#addPelanggan").on('click', function(e) {
        e.preventDefault();
        $.ajax({
            type: "post",
            url: "customer_atk/create",
            data: {
                aksi: 0
            },
            dataType: "json",
            success: function(response) {
                $("#modalPelanggan").modal('hide');
                $(".add-pelanggan").html(response.view).show();
                $("#createCustomer").modal('show');
            }
        });
    });
</script>

<!-- Page level plugins -->
<script src="<?= base_url() ?>/vendor/datatables/jquery.dataTables.min.js"></script>

<script src="<?= base_url() ?>/vendor/datatables/dataTables.bootstrap4.min.js"></script>

<!-- Page level custom scripts -->
<script src="<?= base_url() ?>/js/demo/datatables-demo.js"></script>