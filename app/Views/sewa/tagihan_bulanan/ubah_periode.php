<!-- Modal -->
<form action="<?= base_url('persewaan/update_periode_bulanan') ?>" method="post" id="updatePeriodeBulanan">
    <div class="modal fade" id="modalUbahPeriodeBulanan" tabindex="-1" aria-labelledby="modalUbahPeriodeBulananLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalUbahPeriodeBulananLabel">Ubah Periode Bulanan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            <div class="alert alert-warning" role="alert">
                                <strong>Note :</strong> Minimal <strong><?= bulan_tahun(date('Y-m-d', strtotime($tanggal_min['tanggal_sewa'])))  ?></strong>
                            </div>
                            <div class="form-group">
                                <input type="hidden" name="id" id="id" value="<?= $periode['id'] ?>">
                                <input type="hidden" name="periode" id="periode" value="<?= $periode['periode'] ?>">
                                <input type="hidden" name="jenis" id="jenis" value="<?= $periode['jenis'] ?>">

                                <label for="bulan">Bulan</label>
                                <select class="custom-select <?= $validation->hasError('bulan') ? 'is-invalid' : '' ?>" name="bulan" id="bulan">
                                    <option value="" hidden disabled selected>Pilih</option>
                                    <option value="01" <?= date('m', strtotime($periode['periode'])) == 1 ? 'selected="selected"' : '' ?>>Januari</option>
                                    <option value="02" <?= date('m', strtotime($periode['periode'])) == 2 ? 'selected="selected"' : '' ?>>Februari</option>
                                    <option value="03" <?= date('m', strtotime($periode['periode'])) == 3 ? 'selected="selected"' : '' ?>>Maret</option>
                                    <option value="04" <?= date('m', strtotime($periode['periode'])) == 4 ? 'selected="selected"' : '' ?>>April</option>
                                    <option value="05" <?= date('m', strtotime($periode['periode'])) == 5 ? 'selected="selected"' : '' ?>>Mei</option>
                                    <option value="06" <?= date('m', strtotime($periode['periode'])) == 6 ? 'selected="selected"' : '' ?>>Juni</option>
                                    <option value="07" <?= date('m', strtotime($periode['periode'])) == 7 ? 'selected="selected"' : '' ?>>Juli</option>
                                    <option value="08" <?= date('m', strtotime($periode['periode'])) == 8 ? 'selected="selected"' : '' ?>>Agustus</option>
                                    <option value="09" <?= date('m', strtotime($periode['periode'])) == 9 ? 'selected="selected"' : '' ?>>September</option>
                                    <option value="10" <?= date('m', strtotime($periode['periode'])) == 10 ? 'selected="selected"' : '' ?>>Oktober</option>
                                    <option value="11" <?= date('m', strtotime($periode['periode'])) == 11 ? 'selected="selected"' : '' ?>>November</option>
                                    <option value="12" <?= date('m', strtotime($periode['periode'])) == 12 ? 'selected="selected"' : '' ?>>Desember</option>
                                </select>
                                <div class="invalid-feedback">
                                    <?= $validation->getError('bulan') ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="tahun">Tahun</label>
                                <select class="custom-select  <?= $validation->hasError('tahun') ? 'is-invalid' : '' ?>" name="tahun" id="tahun">
                                    <?= $start = 1945;
                                    $end = date('Y');
                                    ?>
                                    <option value="" disabled hidden selected>Pilih</option>
                                    <?php for ($i = $end; $i >= $start; $i--) : ?>
                                        <option value="<?= $i ?>" <?= date('Y', strtotime($periode['periode'])) == $i ? 'selected="selected"' : '' ?>><?= $i ?></option>
                                    <?php endfor ?>
                                </select>
                                <div class="invalid-feedback">
                                    <?= $validation->getError('tahun') ?>
                                </div>
                            </div>

                            <label for="exampleFormControlSelect1">Tarif</label>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Rp</div>
                                </div>
                                <input type="text" class="form-control <?= $validation->hasError('tarif') ? 'is-invalid' : '' ?>" name="tarif" id="tarif" value="<?= $periode['tarif'] ?>" placeholder="Tarif" readonly>
                                <div class="invalid-feedback">
                                    <?= $validation->getError('tarif') ?>
                                </div>
                            </div>
                            <label for="exampleFormControlSelect1">Jenis</label>
                            <div class="form-group">
                                <select class="custom-select <?= $validation->hasError('jenis') ? 'is-invalid' : '' ?>" name="jenis" disabled>
                                    <option value="" disabled hidden selected>Pilih</option>
                                    <option value="Los" <?= $periode['jenis'] == 'Los' ? 'selected="selected"' : ''; ?>>Los</option>
                                    <option value="Kios" <?= $periode['jenis'] == 'Kios' ? 'selected="selected"' : ''; ?>>Kios</option>
                                    <option value="Semua" <?= $periode['jenis'] == 'Semua' ? 'selected="selected"' : ''; ?>>Semua</option>
                                </select>
                                <div class="invalid-feedback">
                                    <?= $validation->getError('jenis') ?>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="sumbit" class="btn btn-primary">Ubah</button>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    $(document).ready(function() {
        $("#updatePeriodeBulanan").submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: "post",
                url: "<?= base_url('persewaan/update_periode_bulanan') ?>",
                data: $(this).serialize(),
                dataType: "json",
                success: function(response) {
                    if (response.sukses) {
                        window.location.reload();
                    } else if (response.error) {
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
                            title: response.error
                        })
                    }
                },
                error: function(xhr, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        })
        $("#tarif").autoNumeric('init', {
            aSep: ',',
            aDec: '.',
            mDec: '0',
        })
    })
</script>