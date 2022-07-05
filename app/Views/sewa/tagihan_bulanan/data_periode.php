<div class="row">
    <div class="col">
        <div class="card shadow mb-4">
            <div class="card-header py-3">

                <h6 class="m-0 font-weight-bold text-primary mt-2">Daftar Periode Tagihan</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Periode</th>
                                <th>Jenis</th>
                                <th>Tarif</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            $no = 1;
                            foreach ($bulanan as $key) :

                            ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= bulan_indo(date('Y-m-d', strtotime($key['periode']))) . ' ' . date('Y', strtotime($key['periode'])); ?></td>
                                    <td><?= $key['jenis']; ?></td>
                                    <td>Rp. <?= number_format($key['tarif'], 0, '.', '.'); ?></td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-warning btn-sm edit-periode-bulanan" data-id="<?= $key['id'] ?>">Ubah</button>
                                        <button type="button" class="btn btn-danger btn-sm delete-periode-bulanan" data-id="<?= $key['id'] ?>" data-periode="<?= bulan_indo(date('Y-m-d', strtotime($key['periode']))) . ' ' . date('Y', strtotime($key['periode'])); ?>">Hapus</button>
                                    </td>
                                </tr>
                            <?php endforeach ?>


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="ubah-periode-bulanan" style="display: none;"></div>
<script>
    $(document).ready(function() {
        $("#dataTable").dataTable();

        $(".edit-periode-bulanan").click(function(e) {
            $.ajax({
                type: "get",
                url: "<?= base_url('persewaan/ubah_periode') ?>",
                data: {
                    id: $(this).data('id')
                },
                dataType: "json",
                success: function(response) {
                    $(".ubah-periode-bulanan").html(response.view).show();
                    $("#modalUbahPeriodeBulanan").modal('show');
                },
                error: function(xhr, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        })
        $(".delete-periode-bulanan").click(function(e) {
            e.preventDefault();
            let periode = $(this).data('periode')
            Swal.fire({
                title: 'Hapus?',
                html: `Yakin ingin menghapus periode ${periode}`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Jangan'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "post",
                        url: "<?= base_url('persewaan/delete_periode') ?>",
                        data: {
                            id: $(this).data('id')
                        },
                        dataType: "json",
                        success: function(response) {
                            if (response.sukses) {
                                periode_bulanan();
                                Swal.fire(
                                    'Berhasil!',
                                    `Periode ${periode} berhasil dihapus`,
                                    'success'
                                )
                            }

                        }
                    });
                }
            })
        })
    })
</script>