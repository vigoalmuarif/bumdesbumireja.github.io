<!-- Modal -->
<form action="<?= base_url('retribusi/update_pembayaran_by_id') ?>" method="post" id="ubahPembayaranRetribusi">
    <div class="modal fade" id="modalUbahPembayaranRetribusi" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modalUbahPembayaranRetribusiLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalUbahPembayaranRetribusiLabel"><?= $title; ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            <input type="hidden" name="pesan" id="pesan" value="<?= $pesan ?>">
                            <input type="hidden" name="id" id="id" value="<?= $pembayaran['pembayaranRetribusiId'] ?>">
                            <div class="form-group">
                                <label for="">Periode</label>
                                <input type="text" class="form-control" name="periode" id="periode" value="<?= longdate_indo($pembayaran['tanggal']) ?>" readonly>
                            </div>

                            <div class="form-group">
                                <label for="">Jenis Retribusi</label>
                                <input type="text" class="form-control" name="retribusi" id="retribusi" value="<?= $pembayaran['retribusi'] ?>" readonly>
                            </div>

                            <div class="form-group">
                                <label for="">Status</label>
                                <select class="form-control" id="status" name="status">
                                    <option value="1" <?= $pembayaran['status_pegawai'] == 1 ? 'selected="selected"' : '' ?>>Bekerja</option>
                                    <option value="0" <?= $pembayaran['status_pegawai'] == 0 ? 'selected="selected"' : '' ?>>Libur</option>
                                </select>
                            </div>

                            <div class="form-group petugas">
                                <label for="">Perwakilan Petugas</label>
                                <select class="form-control" id="pegawai" name="pegawai">
                                    <option value="" selected hidden disabled>--Pilih--</option>
                                    <?php foreach ($petugas as $row) : ?>
                                        <option value="<?= $row['pegawaiId'] ?>" <?= $pembayaran['pegawaiId'] == $row['pegawaiId'] ? 'selected="selected"' : '' ?>><?= $row['pegawai']; ?></option>
                                    <?php endforeach ?>

                                </select>
                            </div>

                            <div class="form-group input-bayar">
                                <label for="">Bayar (Rp)</label>
                                <input type="text" class="form-control form-control-lg" onclick="$(this).select();" name="bayar" id="bayar" autocomplete="off" value="<?= $pembayaran['bayar'] ?>">
                            </div>

                            <div class="form-group">
                                <label for="exampleFormControlTextarea1">Keterangan</label>
                                <textarea class="form-control" id="keterangan" name="keterangan" rows="3"><?= $pembayaran['desc'] ?></textarea>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary"><?= $aksi; ?></button>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    function cekFrom() {
        let status = $("#status").val();
        if (status == 1) {
            $("#pegawai").attr('hidden', true);
        }
    }

    $(document).ready(function() {
        $("#status").change(function() {
            let status = $("#status").val();
            if (status == 0) {
                $(".petugas").attr('hidden', true);
                $(".input-bayar").attr('hidden', true);
            } else {
                $(".petugas").attr('hidden', false);
                $(".input-bayar").attr('hidden', false);
            }
        })
        $("#ubahPembayaranRetribusi").submit(function(e) {
            e.preventDefault();
            let petugas = $("#pegawai").val();
            let bayar = $("#bayar").autoNumeric('get');
            let status = $("#status").val();
            if (status == 1) {
                if (petugas == null) {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    })

                    Toast.fire({
                        icon: 'warning',
                        title: 'Petugas harus diisi.'
                    });
                } else if (bayar == 0) {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    })

                    Toast.fire({
                        icon: 'warning',
                        title: 'pembayaran harus diisi.'
                    });
                } else {
                    $.ajax({
                        type: "post",
                        url: $(this).attr('action'),
                        data: $(this).serialize(),
                        dataType: "json",
                        success: function(response) {
                            if (response.status == 'sukses') {
                                $("#modalUbahPembayaranRetribusi").modal('hide');
                                $('#modalUbahPembayaranRetribusi').on('hidden.bs.modal', function(event) {
                                    window.location.reload();
                                })
                            }
                        },
                        error: function(xhr, thrownError) {
                            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                        }
                    });
                }
            } else {
                $.ajax({
                    type: "post",
                    url: $(this).attr('action'),
                    data: $(this).serialize(),
                    dataType: "json",
                    success: function(response) {
                        if (response.status == 'sukses') {
                            $("#modalUbahPembayaranRetribusi").modal('hide');
                            $('#modalUbahPembayaranRetribusi').on('hidden.bs.modal', function(event) {
                                window.location.reload();
                            })
                        }
                    },
                    error: function(xhr, thrownError) {
                        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                    }
                });
            }
        })
        $("#bayar").autoNumeric('init', {
            aSep: ',',
            aDec: '.',
            mDec: '0',
        });
    })
</script>