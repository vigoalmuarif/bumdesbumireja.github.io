<?= $this->extend('templates/index_atk'); ?>

<?= $this->section('content'); ?>
<!-- Page Heading -->
<h1 class="h4 mb-2 text-gray-800">Penjualan</h1>
<hr class="sidebar-divider d-none d-md-block">
<!-- DataTales Example -->
<?php if (session()->getFlashdata('pesan')) : ?>
    <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
        <?= session()->getFlashdata('pesan') ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif ?>
<?php if (session()->getFlashdata('error')) : ?>
    <div class="alert alert-warning alert-dismissible fade show text-center" role="alert">
        <?= session()->getFlashdata('error') ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif ?>

<?php if ($validation->getError('alternatif')) : ?>
    <div class="alert alert-warning alert-dismissible fade show text-center" role="alert">
        <?= $validation->getError('alternatif') ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif ?>


<div class="row">
    <div class="col col-md-9">
        <div class="card border-left-warning shadow mb-1" style="min-height: 70px;">
            <div class="card-body" style="padding-top: 2px; padding-bottom:0px;">
                <div class="form-row">

                    <div class="form-group col-md-4" style="margin: 0px;">
                        <label for="faktur" class="col-form-label-sm" style="margin: 0px;">Faktur</label>
                        <input type="text" class="form-control form-control-sm" value="<?= $faktur; ?>" id="faktur" readonly>
                    </div>
                    <div class="form-group col-md-4" style="margin-bottom: 18px;">
                        <label for="kasir" class="col-form-label-sm" style="margin: 0px;">Kasir</label>
                        <input type="text" class="form-control form-control-sm" value="<?= $user['username']; ?>" id="kasir" readonly>
                    </div>

                    <div class="form-group col-md-4" style="margin: 0px;">
                        <label for="tanggal" class="col-form-label-sm" style="margin: 0px;">Hari/Tanggal</label>
                        <input type="text" class="form-control form-control-sm" id="tanggal" name="tanggal">
                        <input type="hidden" class="form-control form-control-sm" id="alternatif" name="alternatif">
                    </div>
                </div>
            </div>
        </div>
        <div class="card border-left-primary shadow mb-1">
            <div class="card-body">
                <div class="form-row">
                    <div class="input-group mb-2  mr-3" style="width: 225px;">
                        <input type="hidden" id="produkId" name="produkId">
                        <input type="hidden" id="produkSatuan" name="produkSatuan">
                        <input type="hidden" id="stok" name="stok">
                        <input type="hidden" id="isi" name="isi">
                        <input type="hidden" id="satuan" name="satuan">
                        <input type="hidden" id="totalStok" name="totalStok">
                        <input type="hidden" id="satuanID" name="satuanID">
                        <input type="text" class="form-control " placeholder="Cari barang / Barcode" id="barcode" name="barcode" readonly>
                        <div class="input-group-append">
                            <button class="btn btn-info" type="button" id="cariProduk"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                    <div class="input-group mb-2 mr-3" style="width: 412px;">
                        <input type="text" class="form-control " placeholder="SKU - Nama Barang" id="produk" name="produk" readonly>
                    </div>
                    <div class="input-group mr-2" style="width: 90px;">
                        <input type="number" min="1" oninput="this.value = Math.abs(this.value)" class="form-control" placeholder="Jumlah" id="qty">
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary" id="keranjang"><i class="fas fa-cart-plus "> </i> Add</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="detail mb-1">
        </div>
    </div>
    <div class="co col-md-3">
        <div class="card border-left-danger shadow mb-1">
            <div class=" card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-lg font-weight-bold text-danger text-uppercase mb-1">
                            Total Bayar</div>
                        <div class="h3 mb-0 font-weight-bold text-gray-800 total-bayar"></div>
                    </div>

                </div>
            </div>
        </div>

        <div class="card shadow mb-0">
            <!-- <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary mt-2">Nota</h6>
            </div> -->
            <div class="card-body">
                <div class="form-group" style="margin-bottom: 5px;">
                    <label for="exampleFormControlSelect1">Pembayaran</label>
                    <select class="form-control form-control-sm" id="jenisBayar">
                        <option value="Tunai">Tunai</option>
                        <option value="Kredit">Kredit</option>
                    </select>
                </div>
                <input type="hidden" name="pelanggan_id" id="pelangganId" value="1">
                <label for="inputEmail3">Pelanggan</label>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" id="pelanggan" value="umum" name="pelanggan" readonly>
                    <div class="input-group-append">
                        <button type="button" class="btn btn-info" id="cariPelanggan"><i class="fa fa-search"></i></button>
                    </div>
                </div>

                <button class="btn btn-danger btn-sm mr-1" id="batalTransaksi">Batal</button>
                <button class="btn btn-success btn-sm" id="simpanTransaksi">Simpan</button>
            </div>
        </div>

    </div>
</div>

<div class="modalProduk" style="display: none;"></div>
<div class="modalPembayaran" style="display: none;"></div>
<div class="modalPelanggan" style="display: none;"></div>

<script>
    function pelanggan() {
        $.ajax({
            type: "post",
            url: "<?= base_url('penjualan/pelanggan') ?>",
            dataType: "json",
            success: function(response) {

                $(".modalPelanggan").html(response.view).show();
                $("#modalPelanggan").modal('show');

            },
            error: function(xhr, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }


    function detailPenjualan() {
        $.ajax({
            type: "post",
            url: "<?= base_url('penjualan/detailPenjualan') ?>",
            dataType: "json",
            beforeSend: function() {
                $(".detail").html('<i class="fa fa-spin fa-spinner"></i>')
            },
            success: function(response) {
                if (response.data) {
                    $(".detail").html(response.data);
                }
            },
            error: function(xhr, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }

    function cekProduk() {
        // let produk = $("#produk").val();
        let produkId = $("#produkId").val();
        let barcode = $("#barcode").val();

        if (barcode.length == 0) {
            $.ajax({
                type: "post",
                url: "<?= base_url('penjualan/produk') ?>",
                dataType: "json",
                success: function(response) {
                    $(".modalProduk").html(response.data).show();
                    $("#modalProduk").modal('show');
                }
            });
        } else {
            $.ajax({
                type: "post",
                url: "<?= base_url('penjualan/save_temp') ?>",
                data: {
                    // produk: produk,
                    produkId: produkId,
                    produkSatuan: $("#produkSatuan").val(),
                    satuanID: $("#satuanID").val(),
                    produk: $("#produk").val(),
                    stok: $("#stok").val(),
                    totalStok: $("#totalStok").val(),
                    qty: $("#qty").val(),
                    isi: $("#isi").val(),
                    satuan: $("#satuan").val(),
                    faktur: $("#faktur").val()
                },
                dataType: "json",

                success: function(response) {
                    if (response.data) {
                        detailPenjualan();
                        clearInput();
                        $("#barcode").focus();
                    }
                    if (response.error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            html: response.error
                        });
                        detailPenjualan();

                    }

                },
                error: function(xhr, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        }
    }

    function cariProduk() {
        let produk = $("#produk").val();

        $.ajax({
            type: "post",
            url: "<?= base_url('penjualan/produk') ?>",
            dataType: "json",
            success: function(response) {
                $(".modalProduk").html(response.data).show();
                $("#modalProduk").modal('show');
            }
        });

    }

    function totalBayar() {
        let faktur = $("#faktur").val();

        $.ajax({
            type: "post",
            url: "<?= base_url('penjualan/totalBayar') ?>",
            data: {
                'faktur': faktur
            },
            dataType: "json",
            success: function(response) {
                if (response.total) {
                    $("div.total-bayar").text(response.total);
                }
            },
            error: function(xhr, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });

    }

    function clearInput() {
        $("#barcode").val('');
        $("#produk").val('');
        $("#qty").val('');
        totalBayar();
    }

    function pembayaran() {
        if ($("#jenisBayar").val() == 'Tunai') {
            $.ajax({
                type: "post",
                url: "<?= base_url('penjualan/pembayaran_tunai') ?>",
                data: {
                    faktur: $("#faktur").val(),
                    tanggal: $("#alternatif").val(),
                    pelanggan: $("#pelangganId").val(),
                    pembayaran: $("#jenisBayar").val(),
                },
                dataType: "json",
                success: function(response) {
                    if (response.view) {
                        $(".modalPembayaran").html(response.view).show();
                        $("#modalPembayaran").modal('show');
                        $('#modalPembayaran').on('shown.bs.modal', function(event) {
                            $("#bayar").focus();
                        });
                    }
                    if (response.error) {
                        Swal.fire({
                            icon: 'question',
                            title: 'Oops...',
                            html: response.error
                        });
                    }
                },
                error: function(xhr, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);

                }
            });
        } else if ($("#jenisBayar").val() == 'Kredit') {
            $.ajax({
                type: "post",
                url: "<?= base_url('penjualan/pembayaran_hutang') ?>",
                data: {
                    faktur: $("#faktur").val(),
                    tanggal: $("#alternatif").val(),
                    pelanggan: $("#pelangganId").val(),
                    pembayaran: $("#jenisBayar").val(),
                },
                dataType: "json",
                success: function(response) {
                    if (response.view) {
                        $(".modalPembayaran").html(response.view).show();
                        $("#modalPembayaran").modal('show');
                        $('#modalPembayaran').on('shown.bs.modal', function(event) {
                            $("#bayar").focus();
                        });
                    }
                    if (response.error) {
                        Swal.fire({
                            icon: 'question',
                            title: 'Oops...',
                            html: response.error
                        });
                    }
                },
                error: function(xhr, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);

                }
            });
        }

    }

    // function pelanggan() {
    //     let metode = $("#jenisBayar").val();
    //     if (metode == 0) {
    //         $("#pelanggan").val('e888ee');
    //     }
    // }


    $(document).ready(function() {
        detailPenjualan();
        totalBayar();

        $('ul.navbar-nav').addClass('toggled')

        $("#simpanTransaksi").click(function(e) {
            e.preventDefault();
            pembayaran();
        });
        $("#cariPelanggan").click(function(e) {
            e.preventDefault();
            pelanggan();
        });
        $("#jenisBayar").on('change', function(e) {
            e.preventDefault();
            let metode = $("#jenisBayar").val();
            if (metode == 'Kredit') {
                $("#pelanggan").val('');
                $("#pelangganId").val('');

            } else if (metode == 'Tunai') {
                $("#pelanggan").val('umum');
                $("#pelangganId").val('1');
            }
        });
        $("#batalTransaksi").click(function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Batal Transaksi?',
                text: "Yakin ingin membatalkan transaksi?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Batal !',
                cancelButtonText: 'Tidak'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "post",
                        url: "<?= base_url('penjualan/batal_transaksi') ?>",
                        dataType: "json",
                        success: function(response) {
                            if (response.data == 'sukses') {
                                window.location.reload();

                            }
                        }
                    });
                }
            })
        })

        $("#barcode").keydown(function(e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                cekProduk();
            }
        });
        $("#qty").keydown(function(e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                cekProduk();
            }
        });
        $("#cariProduk").click(function(e) {

            e.preventDefault();
            cariProduk();
        });
        $("#keranjang").click(function(e) {

            e.preventDefault();
            cekProduk();
        });

        $("#tanggal").datepicker({
            altField: "#alternatif",
            altFormat: "yy-mm-dd",
            changeYear: true,
            changeMonth: true,
            dateFormat: "DD, dd MM yy",
            monthNames: ["Januari", "Februari", "Mart", "April", "Mai", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"],
            dayNames: ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"],
            dayNamesMin: ["Ming", "Sen", "Sel", "Rab", "Kam", "Jum", "Sab"],
            yearRange: "c-5:c+5"
        });
        $("#tanggal").datepicker().datepicker('setDate', 'today');
    });
</script>

<?= $this->endSection() ?>