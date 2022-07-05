<div class="row">
    <div class="col">
        <label for="">Property</label>
        <div class="input-group mb-3">
            <input type="text" class="form-control col-md-3" placeholder="" id="formCariProperty" readonly>
            <div class="input-group-append">
                <button type="button" id="cariProperty" class="btn btn-info"><i class="fa fa-search"></i> Cari</button>
            </div>
        </div>
    </div>
</div>

<div class="detail-item"></div>


<div class="data-property" style="display: none;"></div>

<script>
    function detail_item() {
        $.ajax({
            type: "get",
            url: "<?= base_url('persewaan/detail_item') ?>",
            dataType: "json",
            success: function(response) {
                $(".detail-item").html(response.view);
                // $("#formTransaksi").show();
            },
            error: function(xhr, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }

    $(document).ready(function() {
        detail_item();

        $("#cariProperty").click(function(e) {
            $.ajax({
                type: "get",
                url: "<?= base_url('persewaan/data_property') ?>",
                dataType: "json",
                success: function(response) {
                    $(".data-property").html(response.view).show();
                    $("#modalProperty").modal('show');
                },
                error: function(xhr, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        });
    });
</script>