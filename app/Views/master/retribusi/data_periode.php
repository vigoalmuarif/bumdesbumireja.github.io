<div class="card">
    <div class="card-header">
        Periode Retribusi
        <button type="button" class="btn btn-primary btn-sm float-right" id="createPeriode"><span class="fa fa-plus"></span> Periode Baru</button>
    </div>
    <div class="card-body">

        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Periode</th>
                        <th>Jumlah</th>
                        <th class="text-center">Aksi</th>

                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    foreach ($periode as $row) : ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= longdate_indo($row['tanggal']); ?></td>
                            <td>Rp <?= number_format($row['bayar'], 0, ",", ","); ?></td>
                            <td class="text-center">
                                <a href="<?= base_url('retribusi/detail_periode/' . $row['periodeId']) ?>" class="btn btn-sm btn-info"><i class="fa fa-info-circle"></i></a>
                                <button class="btn btn-sm btn-warning edit-periode" title="Edit Periode <?= longdate_indo($row['tanggal']); ?>" data-id="<?= $row['periodeId'] ?>"><i class="fa fa-edit"></i></button>
                                <button class="btn btn-sm btn-danger delete-periode" title="Hapus Periode <?= longdate_indo($row['tanggal']); ?>" data-id="<?= $row['periodeId'] ?>" data-periode="<?= longdate_indo($row['tanggal']); ?>"><i class="fa fa-trash-alt"></i></button>
                            </td>

                        </tr>

                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="ubah-periode"></div>
<div class="create-periode" style="display: none;"></div>

<script>
    function tanggal() {

    }

    $(document).ready(function() {
        $("#dataTable").dataTable();

        $("#createPeriode").click(function() {
            $.ajax({
                type: "get",
                url: "<?= base_url('retribusi/create_periode') ?>",
                dataType: "json",
                success: function(response) {
                    if (response.view) {
                        $(".create-periode").html(response.view).show();
                        $("#createPeriodeRetribusi").modal('show');
                    }
                },
                error: function(xhr, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        })

        $(".edit-periode").click(function(e) {
            e.preventDefault();
            $.ajax({
                type: "post",
                url: "<?= base_url('retribusi/edit_periode') ?>",
                data: {
                    id: $(this).data('id')
                },
                dataType: "json",
                success: function(response) {
                    $(".ubah-periode").html(response.view).show();
                    $("#modalEditPeriode").modal('show');
                },
                error: function(xhr, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        });
        $(".delete-periode").click(function(e) {
            e.preventDefault();
            let periode = $(this).data('periode');
            Swal.fire({
                title: `<p>Hapus Periode ${periode} ? </p>`,
                text: "Data tagihan retribusi dengan periode tersebut juga akan ikut terhapus",
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
                        url: "<?= base_url('retribusi/delete_periode') ?>",
                        data: {
                            id: $(this).data('id')
                        },
                        dataType: "json",
                        success: function(response) {
                            dataPeriode();
                            Swal.fire(
                                'Terhapus!',
                                'Data berhasil dihapus.',
                                'success'
                            )
                        },
                        error: function(xhr, thrownError) {
                            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                        }
                    });
                }
            })

        });

    });
</script>