 <div class="card-header py-3">
     <div class="export float-right btn-sm m-0 p-0 d-flex" id="export"></div>
     <h6 class="m-0 font-weight-bold text-primary mt-2">Daftar Pelanggan</h6>
 </div>
 <div class="card-body">


     <div class="table-responsive">
         <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
             <thead>
                 <tr>
                     <th>No</th>
                     <th>Nama</th>
                     <th>JK</th>
                     <th>No Telepon</th>
                     <th>Alamat</th>
                     <th class="text-center">Aksi</th>
                 </tr>
             </thead>
             <tbody>
                 <?php
                    $no = 1;
                    foreach ($customer as $cust) : ?>
                     <tr>
                         <td><?= $no++ ?></td>
                         <td><?= $cust['nama']; ?></td>
                         <td><?= $cust['jk'] ?></td>
                         <td><?= $cust['no_hp'] ?></td>
                         <td><?= $cust['alamat'] ?></td>
                         <td style="width: 120px;" class="text-center">
                             <button type="button" class="btn btn-info btn-sm ubah" title="Ubah" data-id="<?= $cust['id'] ?>" id="ubahCustomer">
                                 <i class="fas fa-edit"></i>
                             </button>
                             <button type="button" data-nama="<?= $cust['nama'] ?>" data-id="<?= $cust['id'] ?>" id="hapus" class="btn btn-danger btn-sm hapus" title="Hapus">
                                 <i class="fas fa-trash-alt"></i>
                             </button>
                         </td>
                     </tr>
                 <?php endforeach ?>

             </tbody>
         </table>
     </div>
 </div>

 <script>
     $(document).ready(function() {
         $(".ubah").click(function(e) {
             e.preventDefault();
             let id = $(this).data('id');
             $.ajax({
                 type: "get",
                 url: "<?= base_url('customer_atk/edit') ?>",
                 data: {
                     id: id
                 },
                 dataType: "json",
                 success: function(response) {
                     if (response.view) {
                         $(".ubah-customer").html(response.view).show();
                         $("#editCustomer").modal('show');


                     }
                 },
                 error: function(xhr, thrownError) {
                     alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                 }
             });
         });
         $("#tambah").click(function(e) {
             e.preventDefault();
             $.ajax({
                 type: "post",
                 url: "<?= base_url('customer_atk/create') ?>",
                 data: {
                     aksi: 1
                 },
                 dataType: "json",
                 success: function(response) {
                     if (response.view) {
                         $(".tambah-customer").html(response.view).show();
                         $("#createCustomer").modal('show');


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
             let nama = $(this).data('nama');
             Swal.fire({
                 title: 'Hapus?',
                 text: `Yakin ingin menghapus ${nama} ?`,
                 icon: 'warning',
                 showCancelButton: true,
                 confirmButtonColor: '#3085d6',
                 cancelButtonColor: '#d33',
                 confirmButtonText: 'Yes, delete it!'
             }).then((result) => {
                 if (result.isConfirmed) {

                     $.ajax({
                         type: "post",
                         url: "<?= base_url('customer_atk/delete') ?>",
                         data: {
                             id: id
                         },
                         dataType: "json",
                         success: function(response) {
                             if (response.delete == 'sukses') {
                                 Swal.fire(
                                     'Deleted!',
                                     `${nama} berhasil dihapus.`,
                                     'success'
                                 )
                                 dataPelanggan();
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
                     'title': 'Data pelanggan',
                     text: '<i class="fas fa-file-excel"></i> Excel',
                     exportOptions: {
                         columns: [0, 1, 2, 3, 4]
                     }

                 },
                 {
                     extend: 'print',
                     // messageTop: 'BUMDes Karsa Mandiri',
                     messageBottom: window.location.href,
                     text: '<i class="fas fa-print"></i> Print',
                     title: 'Data pelanggan',
                     exportOptions: {
                         columns: [0, 1, 2, 3, 4]
                     },
                 },
             ]
         });

         table.buttons().container()
             .appendTo($('#export'));
     });
 </script>