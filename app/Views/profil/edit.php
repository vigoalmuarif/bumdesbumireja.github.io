<!-- Modal -->
<form action="<?= base_url('profil/update') ?>" method="post" id="formEdit">
    <div class="modal fade" id="modalEdit" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="editLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editLabel">Ubah Profil</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col mx-auto">
                            <div class="form-group ">
                                <label for="">Logo</label>
                                <!-- <input type="file" name="alternatif" id="alternatif"> -->
                                <input type="text" class="form-control" name="tanggal" id="tanggal" autocomplete="off">
                                <div class="invalid-feedback invalid-tanggal">
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="">Nama BUMDes</label>
                                <input type="text" class="form-control" name="nama" id="nama" value="<?= $profil['nama'] ?>" autocomplete="off" required>
                                <div class="invalid-feedback invalid-nama">
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="pj">Penanggung Jawab</label>
                                <select class="custom-select" id="pj" name="pj" aria-describedby="pjFeedback" required>
                                    <option value="" disabled selected hidden>--pilih--</option>
                                    <?php foreach ($pegawai as $row) : ?>
                                        <option value="<?= $row['pegawai'] ?>" <?= $row['pegawai'] == $profil['ketua'] ? 'selected="selected"' : '' ?>> <?= $row['pegawai'] ?> (<?= $row['jabatan'] ?>)</option>
                                    <?php endforeach ?>
                                </select>
                                <div id="jenisFeedback" class="invalid-feedback invalid-pj">

                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="">No Telepon</label>
                                <input type="text" class="form-control" name="telp" id="telp" value="<?= $profil['no_hp'] ?>" autocomplete="off" required>
                                <div class="invalid-feedback invalid-telp">
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="">Email</label>
                                <input type="text" class="form-control" name="email" id="email" value="<?= $profil['email'] ?>" autocomplete="off">
                                <div class="invalid-feedback invalid-email">
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="">Alamat</label>
                                <textarea class="form-control" name="alamat" id="alamat" rows="3" required><?= $profil['alamat'] ?></textarea>
                                <div class="invalid-feedback invalid-alamat">
                                </div>
                            </div>



                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="submit">Ubah</button>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    $(document).ready(function() {
        $("#formEdit").submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: "post",
                url: "<?= base_url('profil/update') ?>",
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
    })
</script>