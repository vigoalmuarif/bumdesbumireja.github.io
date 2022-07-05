<?php
if (in_groups(['atk', 'bendahara'])) {
    echo $this->extend('templates/index_atk');
} elseif (in_groups('ketua')) {
    echo $this->extend('templates/index_ketua');
}
?>

<?php $this->section('content') ?>
<!-- Button trigger modal -->
<h1 class="h3 mb-2 text-gray-800">Laporan</h1>
<hr class="sidebar-divider d-none d-md-block">

<?php if (session()->getFlashdata('pesan')) : ?>
    <div class="alert alert-warning alert-dismissible fade show text-center" role="alert">
        <?= session()->getFlashdata('pesan') ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif ?>

<div class="row">
    <div class="col">
        <div class="card shadow-lg">


            <div class="card">
                <div class="card-header">
                    <b>Laporan Penjualan & Pembelian ATK</b>
                </div>
                <div class="list-group list-group-flush">
                    <button type="button" id="penjualan" class="list-group-item list-group-item-action">Ringkasan Penjualan</button>
                    <button type="button" class="list-group-item list-group-item-action" id="produk">Penjualan Per Produk/Item</button>
                    <button type="button" id="pembelian" class="list-group-item list-group-item-action">Pembelian</button>
                    <button type="button" id="pembelianProduk" class="list-group-item list-group-item-action">Pembelian Per Produk/item</button>
                    <button type="button" id="piutang" class="list-group-item list-group-item-action">Piutang Penjualan</button>
                    <button type="button" id="hutang" class="list-group-item list-group-item-action">Hutang Pembelian</button>
                </div>
            </div>


        </div>
    </div>
</div>

<div class="viewModal" style="display: none;"></div>

<script>
    $(document).ready(function() {
        $("#penjualan").click(function() {
            $.ajax({
                type: "get",
                url: "<?= base_url('laporan/penjualan/periode') ?>",
                data: {
                    aksi: 'ringkasan_penjualan'
                },
                dataType: "json",
                success: function(response) {
                    $(".viewModal").html(response.view).show();
                    $("#periode").modal('show');
                }
            });
        });
        $("#produk").click(function() {
            $.ajax({
                type: "get",
                url: "<?= base_url('laporan/penjualan/periode') ?>",
                data: {
                    aksi: 'penjualan_per_produk'
                },
                dataType: "json",
                success: function(response) {
                    $(".viewModal").html(response.view).show();
                    $("#periode").modal('show');
                }
            });
        });
        $("#pembelian").click(function() {
            window.location.href = "<?= base_url('laporan/pembelian') ?>"
        });
        $("#pembelianProduk").click(function() {
            window.location.href = "<?= base_url('laporan/pembelian/per_produk') ?>"
        });
        $("#piutang").click(function() {
            window.location.href = "<?= base_url('laporan/piutang/index') ?>"
        });
        $("#hutang").click(function() {
            window.location.href = "<?= base_url('laporan/hutang/index') ?>"
        });
        $("#sewa").click(function() {
            window.location.href = "<?= base_url('laporan/sewa/index') ?>"
        });
    })
</script>
<?php $this->endSection() ?>