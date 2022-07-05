<div class="flash-data" data-flashdata="<?= session()->getFlashdata('sukses') ?>"></div>
<div class="flash-data-error" data-error="<?= session()->getFlashdata('error') ?>"></div>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <button type="button" class="btn btn-primary float-right btn-sm" id="addRetribusi">
            <i class="fa fa-plus"></i> Retribusi baru
        </button>
        <h6 class="m-0 font-weight-bold text-primary mt-2">Daftar Property</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0" id="dataTable">
                <thead>
                    <tr>
                        <td class="text-center">No</td>
                        <td>Retribusi</td>
                        <td class="text-center">Status</td>
                        <td class="text-center">Aksi</td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    foreach ($retribusi as $row) :
                    ?>
                        <tr>
                            <td class="text-center"><?= $no++; ?></td>
                            <td><?= $row['retribusi']; ?></td>
                            <td class="text-center"><span class="badge badge-<?= $row['status'] == 1 ? 'success' : 'danger' ?>"><?= $row['status'] == 1 ? 'Aktif' : 'Non-Aktif' ?></span></td>
                            <td class="text-center">
                                <button type="button" class="btn btn-warning btn-sm edit-retribusi" title="Ubah <?= $row['retribusi'] ?>" data-id="<?= $row['retribusiId'] ?>"><i class=" fa fa-edit"></i></button>
                                <button type="button" class="btn btn-danger btn-sm hapus-retribusi" title="Hapus <?= $row['retribusi'] ?>" data-nama="<?= $row['retribusi'] ?>" data-id="<?= $row['retribusiId'] ?>"><i class="fa fa-trash-alt"></i></button>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="tambah-retribusi" style="display: none;"></div>
<div class="ubah-retribusi" style="display: none;"></div>
<script>
    $(document).ready(function() {
        $("#dataTable").dataTable();

        $("#addRetribusi").click(function(e) {
            e.preventDefault();
            $.ajax({
                type: "get",
                url: "<?= base_url('retribusi/create_retribusi') ?>",
                dataType: "json",
                success: function(response) {
                    $(".tambah-retribusi").html(response.view).show();
                    $("#modalAddRetribusi").modal('show');
                },
                error: function(xhr, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        });
        $(".edit-retribusi").click(function(e) {
            e.preventDefault();
            $.ajax({
                type: "post",
                url: "<?= base_url('retribusi/edit_retribusi') ?>",
                data: {
                    id: $(this).data('id')
                },
                dataType: "json",
                success: function(response) {
                    $(".ubah-retribusi").html(response.view).show();
                    $("#modalEditRetribusi").modal('show');
                },
                error: function(xhr, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        });

        $(".hapus-retribusi").click(function(e) {
            e.preventDefault();
            let retribusi = $(this).data('nama');
            Swal.fire({
                title: 'Hapus?',
                html: `Yakin ingin menghapus retribusi <strong>${retribusi}</strong> ?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Tidak'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "get",
                        url: "<?= base_url('retribusi/delete_retribusi') ?>",
                        data: {
                            id: $(this).data('id')
                        },
                        dataType: "json",
                        success: function(response) {
                            // window.location.reload();
                            if (response.status) {
                                dataRetribusi();

                                Swal.fire(
                                    'Terhapus!',
                                    'Data berhasil dihapus!',
                                    'success'
                                )
                            }

                        },
                        error: function(xhr, thrownError) {
                            // alert(xhr.status);
                            if (xhr.status == 500) {
                                Swal.fire(
                                    'Gagal!',
                                    `Data gagal dihapus, data sudah berelasi!`,
                                    'warning'
                                )
                            } else {

                                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                            }


                        }
                    });

                }
            })

        });


    })
</script>