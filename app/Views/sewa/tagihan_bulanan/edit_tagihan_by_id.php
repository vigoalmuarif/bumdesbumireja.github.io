<div class="modal fade" id="modalEditTagihanBulanan" tabindex="-1" aria-labelledby="modalEditTagihanBulananLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditTagihanBulananLabel">Periode <?= bulan_tahun($periode) ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="data-riwayat"></div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-success simpan-pembayaran-tagihan">Bayar</button>
            </div>
        </div>
    </div>
</div>

<div class="ubah-nominal" style="display: none;"></div>

<script>
    function data_riwayat_tagihan() {
        $.ajax({
            type: "post",
            url: "<?= base_url('persewaan/data_riwayat_tagihan') ?>",
            data: {
                id: "<?= $tagihan ?>"
            },
            dataType: "json",
            success: function(response) {
                $(".data-riwayat").html(response.view);
            },
            error: function(xhr, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }


    $(document).ready(function() {
        data_riwayat_tagihan();

        $("#bayar").autoNumeric('init', {
            aSep: ',',
            aDec: '.',
            mDec: '0',
        });

    })
</script>