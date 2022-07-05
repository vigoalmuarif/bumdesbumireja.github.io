<?= $this->extend('templates/index_retribusi'); ?>

<?= $this->section('content'); ?>
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Retribusi Pasar & Parkir</h1>
<hr class="sidebar-divider d-none d-md-block">
<!-- DataTales Example -->
<div class="flash-data" data-flashdata="<?= session()->getFlashdata('sukses') ?>"></div>


<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                Retribusi Periode <strong><?= longdate_indo($periode['tanggal']); ?></strong>
            </div>
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Retribusi</th>
                                <th>Petugas</th>
                                <th>Jumlah</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Aksi</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            foreach ($detail as $row) : ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= $row['retribusi']; ?></td>
                                    <td class="text-<?= $row['petugas_id'] == NULL ? 'center' : 'left' ?>"><?= $row['petugas_id'] == NULL ? '-' : $row['pegawai'] ?></td>
                                    <td>Rp <?= number_format($row['bayar'], 0, ",", ","); ?></td>
                                    <td class="text-center"><span class="badge badge-outline-<?= $row['status_pembayaran'] == 1 ? 'success' : 'danger' ?>"><?= $row['status_pembayaran'] == 1 ? 'Bekerja' : 'Libur' ?></span></td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-warning btn-sm edit-pembayaran-retribusi" data-id="<?= $row['pembayaranRetribusiId'] ?>" data-retribusi="<?= $row['retribusiId'] ?>" title="Ubah"><i class="fa fa-edit"></i></button>
                                        <button type="button" class="btn btn-danger btn-sm hapus-pembayaran-retribusi" title="Hapus" data-id="<?= $row['pembayaranRetribusiId'] ?>" data-retribusi="<?= $row['retribusiId'] ?>"><i class="fa fa-trash-alt"></i></button>
                                    </td>

                                </tr>

                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="ubah-pembayaran-retribusi" style="display: none;"></div>

<script>
    $(document).ready(function() {

        $(".hapus-pembayaran-retribusi").click(function(e) {
            e.preventDefault();
            let id = $(this).data('id');
            let retribusi = $(this).data('retribusi');
            let periode = "<?= longdate_indo($periode['tanggal']) ?>"
            Swal.fire({
                title: 'Hapus?',
                html: `Yakin ingin menghapus retribusi <strong>${retribusi}</strong> periode <strong>${periode}?</strong>`,
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
                        url: "<?= base_url('retribusi/hapus_pembayaran_by_id') ?>",
                        data: {
                            id: id
                        },
                        dataType: "json",
                        success: function(response) {
                            window.location.reload();

                        },
                        error: function(xhr, thrownError) {
                            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                        }
                    });
                }
            });
        });


        $(".edit-pembayaran-retribusi").click(function(e) {
            e.preventDefault();
            $.ajax({
                type: "post",
                url: "<?= base_url('retribusi/edit_pembayaran_by_id') ?>",
                data: {
                    id: $(this).data('id'),
                    retribusi: $(this).data('retribusi'),
                    title: 'Ubah Setoran Retribusi',
                    aksi: 'Ubah',
                    pesan: 1
                },
                dataType: "json",
                success: function(response) {
                    $(".ubah-pembayaran-retribusi").html(response.view).show();
                    $("#modalUbahPembayaranRetribusi").modal('show');
                    $('#modalUbahPembayaranRetribusi').on('shown.bs.modal', function(event) {
                        let status = $("#status").val();
                        if (status == 0) {
                            $(".petugas").attr('hidden', true);
                            $(".input-bayar").attr('hidden', true);
                        } else {
                            $(".petugas").attr('hidden', false);
                            $(".input-bayar").attr('hidden', false);
                        }
                    })
                }
            });
        })

    });
</script>

<?= $this->endSection() ?>