<!-- Custom styles for this template-->
<link href="<?= base_url() ?>/css/sb-admin-2.min.css" rel="stylesheet">


<!-- Custom styles for this page -->
<link href="<?= base_url() ?>/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">



<!-- Modal -->
<div class="modal fade" id="modalProduk" tabindex="-1" aria-labelledby="modalProdukLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalProdukLabel">Data Produk</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="table-responsive">
                    <input type="hidden" name="keywordproduk" id="keywordProduk" value="<?= $keyword ?>">
                    <table class="table dataProduk table-sm table-hover table-bordered dataTable" id="dataProduk" width="100%" cellspacing="0" role="grid" aria-describedby="dataTable_info" style="width: 100%;">
                        <thead>
                            <th>No</th>
                            <th>SKU</th>
                            <th>Nama</th>
                            <th>Satuan</th>
                            <th>Stok</th>
                            <th>Harga Dasar</th>
                            <th>Harga Jual (Rp)</th>
                            <th>Aksi</th>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    function pilihProduk(produkSatuan, produkID, barcode, sku, produk, satuanID, stok, isi, totalStok, harga_dasar, harga_jual, satuan, nama_lain) {
        let prodak = sku + ' ' + '-' + ' ' + produk + ' [' + satuan + ']';
        let prodak2 = sku + ' ' + '-' + ' ' + nama_lain + ' [' + satuan + ']';
        var harga_jual = harga_jual;
        var harga_dasar = harga_dasar;

        if (nama_lain.length == 0) {

            $("#produk").val(prodak);
        } else {
            $("#produk").val(prodak2);

        }
        $("#produkId").val(produkID);
        $("#produkSatuan").val(produkSatuan);
        $("#stok").val(stok);
        $("#totalStok").val(totalStok);
        $("#qty").val(1);
        $("#satuan").val(satuan);
        $("#isi").val(isi);
        $("#satuanID").val(satuanID);
        if (barcode == "") {
            $("#barcode").val('Tidak ada barcode');
        } else {
            $("#barcode").val(barcode);
        }
        if (parseInt(stok) == 0) {
            alert('Produk tidak tersedia!');
        } else if (parseInt(harga_dasar) > parseInt(harga_jual) || harga_dasar == 0 || harga_jual == 0) {
            alert('Periksa kembali harga dasar dengan harga jual!');
        } else {
            $("#modalProduk").modal('hide');
            $('#modalProduk').on('hidden.bs.modal', function(event) {
                $("#qty").focus();
            });
        }

    }
    $(document).ready(function() {
        var table = $('#dataProduk').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "<?php echo base_url('penjualan/list') ?>",
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




<!-- Page level plugins -->
<script src="<?= base_url() ?>/vendor/datatables/jquery.dataTables.min.js"></script>

<script src="<?= base_url() ?>/vendor/datatables/dataTables.bootstrap4.min.js"></script>

<!-- Page level custom scripts -->
<script src="<?= base_url() ?>/js/demo/datatables-demo.js"></script>