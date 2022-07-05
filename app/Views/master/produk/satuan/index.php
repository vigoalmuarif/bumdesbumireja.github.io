<?= $this->extend('templates/index_atk'); ?>

<?= $this->section('content'); ?>
<!-- Page Heading -->
<button type="button" class="btn btn-primary btn-sm float-right addSatuan">Tambah Satuan</button>
<h1 class="h3 mb-2 text-gray-800">Satuan Produk</h1>
<hr class="sidebar-divider d-none d-md-block">
<!-- DataTales Example -->
<?php if (session()->getFlashdata('pesan')) : ?>
    <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
        <?= session()->getFlashdata('pesan') ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif ?>

<div class="card shadow mb-4 mx-auto">
    <div class="card-header py-3">

        <h6 class=" m-0 font-weight-bold text-primary mt-2">Daftar Satuan/Unit Produk ATK</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    foreach ($satuan as $unit) : ?>
                        <tr>
                            <td style="width: 50px;"><?= $no++ ?></td>
                            <td><?= $unit['nama']; ?></td>
                            <td style="width: 150px;" class="text-center">
                                <button class="btn btn-warning btn-sm ubah" data-id="<?= $unit['id'] ?>">Ubah</button>
                                <a href="<?= base_url('produk/delete_satuan/' . $unit['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin satuan <?= $unit['nama'] ?> ingin dihapus?')">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach ?>

                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="viewModalAdd" style="display: none;"></div>
<div class="viewModalEdit" style="display: none;"></div>


<script>
    $(document).ready(function() {
        $(".addSatuan").click(function(e) {
            e.preventDefault();
            $.ajax({
                url: "<?= base_url('produk/create_satuan') ?>",
                dataType: "json",
                type: 'post',
                data: {
                    aksi: 1
                },
                success: function(response) {
                    if (response.data) {
                        $(".viewModalAdd").html(response.data).show();
                        $('#modalAddSatuan').on('shown.bs.modal', function(event) {
                            $("#nama").focus();
                        });
                        $("#modalAddSatuan").modal('show');
                    }
                },
                error: function(xhr, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        });

        $(".ubah").click(function(e) {
            e.preventDefault();
            $.ajax({
                url: "<?= base_url('produk/edit_satuan') ?>",
                dataType: "json",
                type: 'post',
                data: {
                    id: $(this).data('id')
                },
                success: function(response) {
                    if (response.view) {
                        $(".viewModalEdit").html(response.view).show();

                        $("#modalUbahSatuan").modal('show');
                    }
                },
                error: function(xhr, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        });


    });
</script>


<?php $this->endSection() ?>