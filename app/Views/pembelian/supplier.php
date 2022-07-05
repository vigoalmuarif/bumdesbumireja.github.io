<div class="form-group" style="margin-bottom: 10px;">
    <label for="exampleFormControlSelect1">Supplier</label>
    <select class="form-control form-control-sm" name="supplierId" id="supplierId">
        <option value="" disabled selected hidden>Pilih Supplier</option>
        <?php foreach ($suppliers as $row) : ?>
            <option value="<?= $row['id'] ?>"><?= $row['nama'] ?></option>
        <?php
        endforeach
        ?>
    </select>
</div>
<div class="addSupplier"></div>

<button class="btn  btn-sm btn-primary mb-2" id="tambahSupplier"><i class="fa fas fa-plus"></i> Supplier Baru</button>

<script>
    $(document).ready(function() {
        $("#tambahSupplier").click(function(e) {
            e.preventDefault();
            $.ajax({
                type: "get",
                url: "<?= base_url('pembelian/tambah_supplier') ?>",
                dataType: "json",
                success: function(response) {
                    $(".addSupplier").html(response.view).show();
                    $("#modalAddSupplier").modal('show');
                }
            });
        })
    })
</script>