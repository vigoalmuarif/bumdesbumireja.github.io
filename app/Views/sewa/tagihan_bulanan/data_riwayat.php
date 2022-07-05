<table class="table table-sm table-borderless">
    <tbody>
        <tr>
            <td>Nama Pedagang</td>
            <td>:</td>
            <td><?= $tagihan['pedagang'] ?></td>
        </tr>
        <tr>
            <td>Total Tagihan</td>
            <td>:</td>
            <td>Rp <?= number_format($tagihan['tarifTotal'], 0, ",", ",") ?></td>
        </tr>
        <tr>
            <td>Terbayar</td>
            <td>:</td>
            <td>Rp <?= number_format($tagihan['total_setor'], 0, ",", ",") ?></td>
        </tr>
        <tr>
            <td>Kekurangan</td>
            <td>:</td>
            <td class="text-danger">Rp <?= number_format($tagihan['tarifTotal'] - $tagihan['total_setor'], 0, ",", ",") ?></td>
        </tr>
    </tbody>
</table>
<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Penerima</th>
                <th>Metode</th>
                <th>Bayar (Rp)</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            $total = 0;
            foreach ($history as $row) :
                $total += $row['bayar']
            ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $row['tanggal_bayar']; ?></td>
                    <td><?= $row['username']; ?></td>
                    <td><?= $row['metode']; ?></td>
                    <td><?= number_format($row['bayar'], 0, ",", ","); ?></td>
                    <td class="text-center">
                        <button type="button" class="btn btn-sm btn-warning edit-nominal" data-nominal="<?= $row['bayar'] ?>" data-id="<?= $row['tagihanId'] ?>"><i class="fa fa-edit"></i></button>
                        <button type="button" class="btn btn-sm btn-danger delete-bayar-tagihan" data-id="<?= $row['tagihanId'] ?>" data-bayar="<?= $row['bayar'] ?>" data-pembayaran="<?= $row['bayar'] ?>"><i class="fa fa-trash-alt"></i></button>

                    </td>
                </tr>

            <?php endforeach; ?>
            <tr>
                <td colspan="4" class="text-right"><strong>Jumlah</strong></td>
                <td colspan="2"><strong><?= number_format($total, 0, ",", ","); ?></strong></td>
            </tr>
        </tbody>
    </table>
</div>

<script>
    $(document).ready(function() {
        $(".edit-nominal").click(function() {

            $.ajax({
                type: "post",
                url: "<?= base_url('persewaan/edit_nominal_tagihan_bulanan') ?>",
                data: {
                    id: $(this).data('id'),
                    nominal: $(this).data('nominal'),
                },
                dataType: "json",
                success: function(response) {
                    $("#modalEditTagihanBulanan").modal('hide');
                    $('#modalEditTagihanBulanan').on('hidden.bs.modal', function(event) {
                        $(".ubah-nominal").html(response.view).show();
                        $("#modalUbahNominalTagihanBulanan").modal('show');
                    })
                },
                error: function(xhr, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }

            });
        })


        $("#delete-bayar-tagihan").click(function(e) {

            e.preventDefault();
            Swal.fire({
                title: 'Hapus?',
                text: "Yakin ingin menghapus pembayaran tagihan bulanan?",
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
                        url: "<?= base_url('persewaan/delete_riwayat_bayar_by_id') ?>",
                        data: {
                            id: $(this).data('id'),
                            bayar: $(this).data('bayar'),
                            pembayaran_id: $(this).data('pembayaran'),
                        },
                        dataType: "json",
                        success: function(response) {
                            data_riwayat_tagihan();
                            $('#modalEditTagihanBulanan').on('hidden.bs.modal', function(event) {
                                isi_periode();
                            })
                            Swal.fire(
                                'Terhapus!',
                                'Data berhasil dihapus',
                                'success'
                            )
                        },
                        error: function(xhr, thrownError) {
                            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                        }
                    });
                }
            })
        })
    })
</script>