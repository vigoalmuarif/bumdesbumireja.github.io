<!-- Custom styles for this template-->
<link href="<?= base_url() ?>/css/sb-admin-2.min.css" rel="stylesheet">


<!-- Custom styles for this page -->
<link href="<?= base_url() ?>/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">



<!-- Modal -->
<div class="modal fade" id="modalProduk" tabindex="-1" aria-labelledby="modalProdukLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalProdukLabel">Daftar Produk</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="table-responsive">
                    <input type="hidden" name="keywordproduk" id="keywordProduk" value="<?= $keyword ?>">
                    <table class="table dataProduk table-bordered dataTable" id="dataProduk" width="100%" cellspacing="0" role="grid" aria-describedby="dataTable_info" style="width: 100%;">
                        <thead>
                            <th>No</th>
                            <th>SKU</th>
                            <th>Nama</th>
                            <th>Aksi</th>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="close" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    function pilihProduk(id, sku) {

        $.ajax({
            type: "post",
            url: "<?= base_url('pembelian/produk') ?>",
            data: {
                produkID: id
            },
            dataType: "json",
            success: function(response) {
                console.log(response.temp);
                $("#modalProduk").modal('hide');
                $('#modalProduk').on('hidden.bs.modal', function(event) {
                    $(".modalProduk").html(response.data).show();
                    $("#modalAddProduk").modal('show');
                })
            },
            error: function(xhr, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }


    $(document).ready(function() {

        // $(".pilih-produk").on(function(e) {
        //     pilihProduk();
        //     var i = $(".pilih-produk").val();
        //     console.log(i);
        // })
        // $("#close").click(function(e) {
        //     e.preventDefault();
        //     $('#modalProduk').on('hidden.bs.modal', function(event) {
        //         $("#barcode").focus();
        //     })
        // })

        var table = $('#dataProduk').DataTable({
            "Processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "<?php echo base_url('pembelian/list') ?>",
                "type": "POST",
                "data": {
                    keyword: $("#keywordProduk").val()
                }
            },
            //optional

            "columnDefs": [{
                "targets": [],
                "orderable": false,
            }, ],
        });

    });
</script>