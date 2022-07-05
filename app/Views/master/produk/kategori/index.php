<?= $this->extend('templates/index_atk'); ?>

<?= $this->section('content'); ?>
<!-- Page Heading -->
<button type="button" class="btn btn-primary btn-sm float-right addKategori">Tambah Kategori</button>
<h1 class="h3 mb-2 text-gray-800">Kategori Produk ATK</h1>
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

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary mt-2">Daftar Kategori Produk ATK</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Jumlah Produk</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    foreach ($kategori as $categori) : ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $categori['kategori']; ?></td>
                            <td><?= $categori['jumlah']; ?></td>
                            <td style="width: 115px;">
                                <button type="button" class="btn btn-sm btn-warning ubah" data-id="<?= $categori['kategoriId'] ?>">Ubah</button>
                                <a href="<?= base_url('produk/delete_kategori/' . $categori['kategoriId']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin kategori <?= $categori['kategori'] ?> ingin dihapus?')">Hapus</a>
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


        $(".addKategori").click(function(e) {
            e.preventDefault();
            $.ajax({
                url: "<?= base_url('produk/create_kategori') ?>",
                dataType: "json",
                type: 'post',
                data: {
                    aksi: 1
                },
                success: function(response) {
                    if (response.data) {
                        $(".viewModalAdd").html(response.data).show();
                        $('#modalAddKategori').on('shown.bs.modal', function(event) {
                            $("#nama").focus();
                        });
                        $("#modalAddKategori").modal('show');
                    }
                },
                error: function(xhr, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        })
        $(".ubah").click(function(e) {
            e.preventDefault();
            let id = $(this).data('id')
            $.ajax({
                url: "<?= base_url('produk/ubah_kategori') ?>",
                type: 'post',
                dataType: "json",
                data: {
                    id: id
                },
                success: function(response) {
                    if (response.view) {
                        $(".viewModalEdit").html(response.view).show();

                        $("#modalUbahKategori").modal('show');
                    }
                },
                error: function(xhr, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        })
    });
</script>


<?php $this->endSection() ?>