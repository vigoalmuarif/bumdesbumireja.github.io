<!-- Modal -->
<div class="modal fade" id="periode" tabindex="-1" aria-labelledby="periodeLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="periodeLabel"><?= $title ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="exampleFormControlSelect1">Periode</label>
                    <select class="form-control" id="exampleFormControlSelect1" onchange="location  =this.value">
                        <option value="" disabled selected hidden>Pilih</option>
                        <option value="<?= base_url($harian) ?>">Harian</option>
                        <option value="<?= base_url($bulanan) ?>">Bulanan</option>
                        <option value="<?= base_url($tahunan) ?>">Tahunan</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>