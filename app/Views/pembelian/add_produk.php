<!-- Modal -->
<form action="<?= base_url('pembelian/save_produk') ?>" method="post" id="formAddProduk">
    <div class="modal fade" id="modalAddProdukBaru" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="tambahProdukBaruLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Tambah Produk Baru</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        <div class="col col-md-6">
                            <div class="form-group">
                                <label for="barcode">Barcode</label>
                                <input type="text" class="form-control" id="kode" name="barcode" autocomplete="off">
                                <div class="invalid-feedback error-barcode"></div>
                            </div>
                        </div>
                        <div class="col col-md-6">
                            <div class="form-group">
                                <label for="sku">SKU</label>
                                <input type="text" class="form-control" id="sku" name="sku" autocomplete="off">
                                <div class="invalid-feedback error-sku"></div>
                            </div>
                        </div>
                        <div class="col col-md-12 ">
                            <div class="form-group">
                                <label for="nama">Nama Produk</label>
                                <input type="text" class="form-control" id="nama" name="nama" autocomplete="off">
                                <div class="invalid-feedback error-nama"></div>
                            </div>
                        </div>
                        <div class="col col-md-6">
                            <label for="harga_jual">Satuan</label>
                            <div class="input-group mb-3">
                                <select class="custom-select" id="satuan" name="satuan">

                                </select>
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-sm btn-info" id="addSatuan" for="satuan"><i class="fa fas fa-plus"></i></button>
                                </div>
                                <div class="invalid-feedback error-satuan"></div>
                            </div>
                        </div>
                        <div class="col col-md-6">
                            <label for="kategori">Kategori</label>
                            <div class="input-group mb-3">
                                <select class="custom-select" id="kategori" name="kategori">


                                </select>
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-sm btn-info" id="addKategori" for="kategori"><i class="fa fas fa-plus"></i></button>
                                </div>
                                <div class="invalid-feedback error-kategori"></div>
                            </div>
                        </div>

                        <div class="col col-md-6">
                            <label for="harga_beli">Harga Beli</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon3">Rp</span>
                                </div>
                                <input type="text" class="form-control" id="harga_beli" name="harga_beli" autocomplete="off">
                                <div class="invalid-feedback error-harga_beli"></div>
                            </div>
                        </div>
                        <div class="col col-md-6">
                            <label for="harga_jual">Harga Jual</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon3">Rp</span>
                                </div>
                                <input type="text" class="form-control" id="harga_jual" name="harga_jual" autocomplete="off">
                                <div class="invalid-feedback error-harga_jual"></div>
                            </div>
                        </div>
                        <div class="col col-md-6">
                            <div class="form-group">
                                <label for="qty">Jumlah</label>
                                <input type="text" class="form-control" id="qty" name="qty" autocomplete="off">
                                <div class="invalid-feedback error-qty"></div>
                            </div>
                        </div>
                        <div class="col col-md-6">
                            <label for="harga_beli_total">Total Harga Beli</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon3">Rp</span>
                                </div>
                                <input type="text" class="form-control" id="harga_beli_total" name="harga_beli_total" autocomplete="off" readonly>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="harga_jual">Keterangan</label>
                                <textarea class="form-control" name="keterangan" id="keterangan"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary simpanProduk">Simpan</button>
                </div>
            </div>
        </div>
    </div>
</form>
<div class="addKategori" style="display: none;"></div>

<script>
    function ambilKategori() {
        $.ajax({
            type: "get",
            url: "<?= base_url('pembelian/ambilKategori') ?>",
            dataType: "json",
            success: function(response) {
                $("#kategori").html(response.isi);
            },
            error: function(xhr, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }

    function ambilSatuan() {
        $.ajax({
            type: "get",
            url: "<?= base_url('pembelian/ambilSatuan') ?>",
            dataType: "json",
            success: function(response) {
                $("#satuan").html(response.isi);
            },
            error: function(xhr, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }

    function tambahKategori() {
        $.ajax({
            type: "post",
            url: "<?= base_url('produk/create_kategori') ?>",
            data: {
                aksi: 0
            },
            dataType: "json",
            success: function(response) {
                $(".addKategori").html(response.data).show();
                $("#modalAddKategori").modal('show');

            },
            error: function(xhr, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }

    function tambahSatuan() {
        $.ajax({
            type: "post",
            url: "<?= base_url('produk/create_satuan') ?>",
            data: {
                aksi: 0
            },
            dataType: "json",
            success: function(response) {
                $(".addKategori").html(response.data).show();
                $("#modalAddSatuan").modal('show');

            },
            error: function(xhr, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }

    $(document).ready(function() {
        ambilKategori();
        ambilSatuan();

        $("#addKategori").click(function(e) {
            e.preventDefault();
            tambahKategori();

        });
        $("#addSatuan").click(function(e) {
            e.preventDefault();
            tambahSatuan();

        });

        $("#formAddProduk").submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: "post",
                url: $(this).attr('action'),
                data: $(this).serialize(),
                dataType: "json",
                success: function(response) {
                    if (response.status) {
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
                            title: 'Harga jual lebih kecil daripada harga beli!'
                        })
                    } else
                    if (response.error) {

                        if (response.error.barcode) {
                            $("#kode").addClass('is-invalid');
                            $(".error-barcode").html(response.error.barcode);
                        } else {
                            $("#kode").removeClass('is-invalid');
                            $(".error-barcode").html('');
                        }
                        if (response.error.nama) {
                            $("#nama").addClass('is-invalid');
                            $(".error-nama").html(response.error.nama);
                        } else {
                            $("#nama").removeClass('is-invalid');
                            $(".error-nama").html('');
                        }
                        if (response.error.sku) {
                            $("#sku").addClass('is-invalid');
                            $(".error-sku").html(response.error.sku);
                        } else {
                            $("#sku").removeClass('is-invalid');
                            $(".error-sku").html('');
                        }
                        if (response.error.satuan) {
                            $("#satuan").addClass('is-invalid');
                            $(".error-satuan").html(response.error.satuan);
                        } else {
                            $("#satuan").removeClass('is-invalid');
                            $(".error-satuan").html('');
                        }
                        if (response.error.kategori) {
                            $("#kategori").addClass('is-invalid');
                            $(".error-kategori").html(response.error.kategori);
                        } else {
                            $("#kategori").removeClass('is-invalid');
                            $(".error-kategori").html('');
                        }
                        if (response.error.harga_beli) {
                            $("#harga_beli").addClass('is-invalid');
                            $(".error-harga_beli").html(response.error.harga_beli);
                        } else {
                            $("#harga_beli").removeClass('is-invalid');
                            $(".error-harga_beli").html('');
                        }
                        if (response.error.harga_jual) {
                            $("#harga_jual").addClass('is-invalid');
                            $(".error-harga_jual").html(response.error.harga_jual);
                        } else {
                            $("#harga_jual").removeClass('is-invalid');
                            $(".error-harga_jual").html('');
                        }
                        if (response.error.qty) {
                            $("#qty").addClass('is-invalid');
                            $(".error-qty").html(response.error.qty);
                        } else {
                            $("#qty").removeClass('is-invalid');
                            $(".error-qty").html('');
                        }
                    } else {

                        $("#modalAddProdukBaru").modal('hide');
                        detail();
                    }

                },
                error: function(xhr, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        });

        $("#harga_beli").keyup(function(e) {
            e.preventDefault();
            let beli = $("#harga_beli").autoNumeric('get');
            let qty = $("#qty").autoNumeric('get');
            let total = parseFloat(beli) * parseFloat(qty);
            $("#harga_beli_total").val(total);
            let bayar = $("#harga_beli_total").val()
            $("#harga_beli_total").autoNumeric('set', bayar);
        })
        $("#qty").keyup(function(e) {
            e.preventDefault();
            let beli = $("#harga_beli").autoNumeric('get');
            let qty = $("#qty").autoNumeric('get');
            let total = parseFloat(beli) * parseFloat(qty);
            $("#harga_beli_total").val(total);
            let bayar = $("#harga_beli_total").val()
            $("#harga_beli_total").autoNumeric('set', bayar);
        })

        $("#harga_beli").autoNumeric('init', {
            aSep: ",",
            aDec: ".",
            mDec: ""
        });
        $("#harga_jual").autoNumeric('init', {
            aSep: ",",
            aDec: ".",
            mDec: ""
        });
        $("#qty").autoNumeric('init', {
            aSep: ",",
            aDec: ".",
            mDec: ""
        });
        $("#harga_beli_total").autoNumeric('init', {
            aSep: ",",
            aDec: ".",
            mDec: ""
        });
    })
</script>