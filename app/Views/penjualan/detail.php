 <div class="card border-left-info shadow">
     <div class="card-body">
         <div class="row no-gutters align-items-center">
             <div class="table-responsive">
                 <table class="table table-striped table-bordered">
                     <thead>
                         <tr>
                             <th scope="col">#</th>
                             <th scope="col">SKU</th>
                             <th scope="col">Nama Barang</th>
                             <th scope="col">satuan</th>
                             <th scope="col">Harga (Rp)</th>
                             <th scope="col">Qty</th>
                             <th scope="col">Sub Total (Rp)</th>
                             <th scope="col" style="width: 60px;">Aksi</th>
                         </tr>
                     </thead>
                     <tbody>
                         <?php
                            if ($cart < 1) : ?>
                             <tr>
                                 <td colspan="8" class="text-center">Tidak ada produk dalam keranjang.</td>
                             </tr>
                             <?php else :
                                $no = 1;
                                foreach ($detail->getResultArray() as $row) : ?>
                                 <tr>
                                     <td><?= $no++ ?></td>
                                     <td><?= $row['sku']; ?></td>
                                     <td><?= empty($row['nama_lain']) ? $row['produk'] : $row['nama_lain']; ?></td>
                                     <td><?= $row['satuan']; ?></td>
                                     <td><?= number_format($row['harga'], 0, ",", ","); ?></td>
                                     <td><?= $row['jumlah']; ?></td>
                                     <td><?= number_format($row['sub_total'], 0, ",", ","); ?></td>
                                     <td>
                                         <butoon title="Hapus" class="btn btn-danger btn-sm" onclick="hapusItem(`<?= $row['temp_id'] ?>`, `<?= $row['produk'] ?>`)"><i class="fas fa-trash-alt"></i></butoon>

                                     </td>
                                 </tr>
                             <?php endforeach ?>
                         <?php endif ?>


                     </tbody>
                 </table>
             </div>

         </div>
     </div>
 </div>

 <script>
     function hapusItem(temp_id, nama) {
         Swal.fire({
             title: 'Hapus Item?',
             html: `Yakin ingin menghapus item <strong>${nama}</strong> ?`,
             icon: 'warning',
             showCancelButton: true,
             confirmButtonColor: '#3085d6',
             cancelButtonColor: '#d33',
             confirmButtonText: 'Ya, hapus !',
             cancelButtonText: 'Tidak'
         }).then((result) => {
             if (result.isConfirmed) {
                 $.ajax({
                     type: "post",
                     url: "<?= base_url('penjualan/hapusItem') ?>",
                     data: {
                         temp_id: temp_id,
                     },
                     dataType: "json",
                     success: function(response) {
                         if (response.data == 'sukses') {
                             detailPenjualan();
                             clearInput();
                         }
                     },
                     error: function(xhr, thrownError) {
                         alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                     }
                 });
             }
         });


     }
 </script>