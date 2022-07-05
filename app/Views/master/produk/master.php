<?php
if (in_groups(['admin', 'bendahara', 'atk'])) {
    echo $this->extend('templates/index_atk');
} elseif (in_groups('ketua')) {
    echo $this->extend('templates/index_ketua');
}
?>

<?= $this->section('content'); ?>
<!-- Page Heading -->
<?php if (in_groups(['admin', 'bendahara', 'atk'])) : ?>
    <a href="<?= base_url('produk/create') ?>" class="btn btn-primary float-right btn-sm">
        Tambah Produk
    </a>
<?php endif ?>
<h1 class="h3 mb-2 text-gray-800">Produk ATK</h1>
<hr class="sidebar-divider d-none d-md-block">
<!-- DataTales Example -->

<div class="flash-data" data-flashdata="<?= session()->getFlashdata('pesan') ?>"></div>
<div class="flash-data-error" data-error="<?= session()->getFlashdata('error') ?>"></div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <?php if (in_groups(['bendahara', 'atk'])) : ?>
            <div class="export float-right btn-sm" id="export"></div>
        <?php endif ?>
        <h6 class="m-0 font-weight-bold text-primary mt-2">Daftar Produk ATK</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>SKU</th>
                        <th>Kategori</th>
                        <th>Nama</th>
                        <th>Satuan Dasar</th>
                        <th>Supplier</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    foreach ($produk as $products) : ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $products['sku']; ?></td>
                            <td><?= $products['kategori']; ?></td>
                            <td><?= $products['produk']; ?></td>
                            <td><?= $products['satuan'] ?></td>
                            <td><?= $products['supplier']; ?></td>
                            <td class="text-center">
                                <button type="button" class="btn btn-info btn-sm detail-produk" data-id="<?= $products['produkID']; ?>" title="Detail"><span class="fas fa fa-info-circle"></span></button>
                                <a href="<?= base_url('produk/satuan_harga/' . $products['produkID']); ?>" class="btn btn-success btn-sm edit-harga" title="Satuan & Harga"><span class="fas fa fa-tags"></span></a>
                                <a href="<?= base_url('produk/ubah/' . $products['produkID']); ?>" class="btn btn-warning btn-sm edit" title="Ubah Produk"><span class="fas fa fa-edit"></span></a>
                                <button type="button" class="btn btn-danger btn-sm hapus" title="Hapus" data-id="<?= $products['produkID']; ?>" data-produk="<?= $products['produk']; ?>"><span class="fas fa fa-trash-alt"></span></button>
                            </td>
                        </tr>
                    <?php endforeach ?>

                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="detail"></div>


<script>
    $(document).ready(function() {

        $(".detail-produk").click(function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            $.ajax({
                type: "get",
                url: `<?= base_url('produk/detailProduk/') ?>/${id}`,
                data: $(this).data('id'),
                dataType: "json",
                success: function(response) {
                    if (response.data) {
                        $(".detail").html(response.data).show();
                        $("#modalDetail").modal('show');
                    }
                },
                error: function(xhr, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        });

        $(".hapus").click(function(e) {
            e.preventDefault();
            let id = $(this).data('id');
            let produk = $(this).data('produk');
            Swal.fire({
                title: 'Hapus?',
                html: `Yakin ingin menghapus produk <b>${produk}</b>?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Tidak'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "post",
                        url: "<?= base_url('produk/delete') ?>",
                        data: {
                            id: id
                        },
                        dataType: "json",
                        success: function(response) {
                            if (response.msg) {
                                window.location.reload();

                            }
                        },
                        error: function(xhr, thrownError) {
                            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                        }
                    });

                }
            });
        });

        var table = $('#dataTable').DataTable({
            buttons: [{
                    extend: 'excel',
                    'title': 'Data Produk ATK',
                    text: '<i class="fas fa-file-excel"></i> Excel',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5]
                    }

                },
                {
                    extend: 'print',
                    // messageTop: 'BUMDes Karsa Mandiri',
                    messageBottom: window.location.href,
                    text: '<i class="fas fa-print"></i> Print',
                    title: 'Data Produk ATK',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5]
                    },
                },
            ]
        });

        table.buttons().container()
            .appendTo($('#export'));
    })
</script>



<?php $this->endSection() ?>