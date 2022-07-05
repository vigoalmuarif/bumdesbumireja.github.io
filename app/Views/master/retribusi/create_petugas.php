<!-- Modal -->
<form action="<?= base_url('retribusi/save_petugas') ?>" method="post" id="formAddPetugas">
    <div class="modal fade" id="modalAddPetugas" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modalAddPetugasLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAddPetugasLabel">Tambah Petugas Retribusi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <label for="exampleFormControlInput1">NIK</label>
                    <div class="input-group mb-3">
                        <input type="hidden" name="pegawaiID" id="pegawaiID">
                        <input type="text" class="form-control" id="nik" name="nik" placeholder="Masukan NIK" aria-label="Masukan NIK" autocomplete="off">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button" id="cekNIK">Cek</button>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="nama">Nama Lengkap</label>
                        <input type="text" class="form-control" id="nama" id="nama" readonly>
                    </div>
                    <div class="form-group">
                        <label for="jabatan">Jabatan / Petugas</label>
                        <input type="text" class="form-control" id="jabatan" name="jabatan" readonly>
                    </div>
                    <div class="form-group">
                        <label for="retribusi">Bagian</label>
                        <select class="form-control" id="bagian" name="bagian" disabled required>
                            <option value="" selected disabled hidden>--Pilih--</option>
                            <?php foreach ($retribusi as $row) : ?>
                                <option value="<?= $row['retribusiId'] ?>"><?= $row['retribusi'] ?></option>
                            <?php endforeach; ?>

                        </select>
                    </div>
                </div>
                <div class=" modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="tambah" disabled>Tambah</button>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    function cekNIK() {
        let nik = $("#nik").val();
        if (nik.length == 0) {
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
                icon: 'error',
                title: 'Masukan NIK terlebih dahulu'
            })
        } else {
            $.ajax({
                type: "post",
                url: "<?= base_url('retribusi/cek_nik') ?>",
                data: {
                    nik: nik
                },
                dataType: "json",
                success: function(response) {
                    if (response.pegawai == 0) {
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
                            icon: 'error',
                            title: 'Petugas belum terdaftar di database BUMDes, kontak admin atau bendahara.'
                        })
                    } else if (response.pegawai == 1) {
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
                            icon: 'error',
                            title: 'Petugas telah terdaftar'
                        });
                    } else {
                        $("#nama").val(response.nama);
                        $("#pegawaiID").val(response.pegawaiID);
                        $("#jabatan").val(response.jabatan);
                        $("#tambah").removeAttr('disabled');
                        $("#bagian").removeAttr('disabled');
                    }
                },
                error: function(xhr, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        }
    }


    $(document).ready(function() {

        $("#cekNIK").click(function(e) {
            e.preventDefault();
            cekNIK();
        })
        $("#nik").keyup(function(e) {
            e.preventDefault();
            $("#nama").val('');
            $("#jabatan").val('');
        });

        $("#formAddPetugas").submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: "post",
                url: $(this).attr('action'),
                data: $(this).serialize(),
                dataType: "json",
                success: function(response) {
                    if (response.sukses) {
                        window.location.reload();
                    }
                },
                error: function(xhr, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        })
    });
</script>