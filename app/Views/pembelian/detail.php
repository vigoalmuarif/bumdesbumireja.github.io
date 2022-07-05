<div class="card border-left-info shadow mb-1">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Produk</th>
                        <th>Satuan</th>
                        <th>Harga (Rp)</th>
                        <th>Qty</th>
                        <th>Sub Total (Rp)</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($cart == 0) : ?>
                        <tr>
                            <td colspan="7" class="text-center">Belum ada item dalam keranjang</td>
                        </tr>

                        <?php
                    else :
                        $no = 1;
                        foreach ($produk as $prodak) : ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= $prodak['produk']; ?></td>
                                <td><?= $prodak['satuan']; ?></td>
                                <td><?= number_format($prodak['harga'], 0, ",", ","); ?></td>
                                <td><?= $prodak['qty']; ?></td>
                                <td><?= number_format($prodak['sub_total'], 0, ",", ","); ?></td>
                                <td>
                                    <button class="btn btn-danger btn-sm hapus-item" onclick="hapusItemPembelian(`<?= $prodak['produk'] ?>`, `<?= $prodak['temp_id'] ?>`)"><i class="fa fa-trash-alt"></i></button>
                                </td>
                            </tr>
                    <?php
                        endforeach;
                    endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function hapusItemPembelian(nama, id) {

        Swal.fire({
            title: 'Hapus?',
            html: `Yakin ingin menghapus item <strong>${nama}</strong> dari keranjang?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "post",
                    url: "<?= base_url('pembelian/hapus_item') ?>",
                    data: {
                        id: id
                    },
                    dataType: "json",
                    success: function(response) {
                        Swal.fire(
                                'Hapus!',
                                `Item ${nama} berhasil dihapus!`,
                                'success'
                            ),
                            detail();
                        totalBayar();


                    },
                    error: function(xhr, thrownError) {
                        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                    }
                });


            }
        });
    }
</script>