<?php $this->extend('templates/index_atk') ?>

<?php $this->section('content') ?>
<!-- Button trigger modal -->
<h1 class="h3 mb-2 text-gray-800">Tambah Produk ATK</h1>
<hr class="sidebar-divider d-none d-md-block">

<?php if (session()->getFlashdata('pesan')) : ?>
    <div class="alert alert-warning alert-dismissible fade show text-center" role="alert">
        <?= session()->getFlashdata('pesan') ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif ?>

<form action="<?= base_url('produk/saveProduk') ?>" method="post" id="createProduk">
    <div class="row">
        <div class="col">
            <div class="card shadow-lg">
                <h5 class="card-header text-center">From Tambah Produk ATK</h5>
                <div class="card-body">
                    <div class="form-group col-md-6 mx-auto">
                        <label for="sku">SKU</label>
                        <input type="text" class="form-control" name="sku" id="sku" placeholder="Masukan SKU">
                        <div class="invalid-feedback error-sku">

                        </div>
                    </div>
                    <div class="form-group col-md-6 mx-auto">
                        <label for="nama">Nama<strong class="text-danger">*</strong></label>
                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukan nama produk">
                        <div class="invalid-feedback error-nama">

                        </div>
                    </div>

                    <div class="form-group col-md-6 mx-auto">
                        <label for=" kategori">Kategori<strong class="text-danger">*</strong></label>
                        <div class="input-group">
                            <select class="custom-select" id="kategori" name="kategori">
                                <option value=''>--Pilih--</option>
                            </select>
                            <div class="input-group-append">
                                <button type="button" class="btn btn-info" id="tambahKategori"><i class="fas fa-plus"></i></button>
                            </div>
                            <div class="invalid-feedback error-kategori">

                            </div>
                        </div>
                    </div>

                    <div class="form-group col-md-6 mx-auto mt-5">
                        <a href="<?= base_url('produk/index') ?>" class="btn btn-secondary btn-md float-right mr-2" onclick="return confirm('Yakin ingin membatalkan?')">Batal</a>
                        <button type="submit" class="btn btn-success btn-md float-right mr-2">Simpan</button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</form>
<div class="viewModal"></div>

<script>
    function ambilKategori() {
        $.ajax({
            url: "<?= base_url('produk/ambilKategori') ?>",
            dataType: "json",

            success: function(response) {
                if (response.data) {
                    $("#kategori").html(response.data);
                }

            },
            error: function(xhr, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }

    // function ambilSatuan() {
    //     $.ajax({
    //         url: "<?= base_url('produk/ambilSatuan') ?>",
    //         dataType: "json",

    //         success: function(response) {
    //             if (response.data) {
    //                 $(".satuan").html(response.data);
    //             }

    //         },
    //         error: function(xhr, thrownError) {
    //             alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
    //         }
    //     });
    // }

    function harga_jual() {
        $(".harga_jual").autoNumeric('init', {
            aSep: ',',
            aDec: '.',
            mDec: '0'
        });
    }


    $(document).ready(function() {

        ambilKategori();
        // ambilSatuan();
        harga_jual();

        $(".satuan-terkecil").change(function(e) {
            e.preventDefault();
            var satuan = $(".satuan-terkecil").val();
            var unit = $(".satuan-terkecil option:selected").text();
            console.log(unit);
            $(".unit").text(unit);
            $("#satuan_terkecil").val(satuan);
        })
        $("#satuan_beli").change(function(e) {
            e.preventDefault();
            var satuan_beli = $("#satuan_beli option:selected").text();
            console.log(satuan_beli);
            $(".satuan_beli").val(satuan_beli);
        })

        // $("#addRow").on('click', function(e) {
        //     e.preventDefault();

        //     var html = '';
        //     html += `<div class="form-row form-new">`;

        //     html += '<div class="form-group col-md-3">';
        //     html += '<label for="barcode">Barcode</label>';
        //     html += `<input type="text" class="form-control barcode" name="barcode[]" placeholder="Masukan barcode" autocomplete="off" id="barcode">`;
        //     html += '<div class="invalid-feedback error-barcode">';
        //     html += '</div></div>';

        //     html += ' <div class="col col-md-2 mb-6">';
        //     html += '<label for="satuan">Satuan<strong class="text-danger">*</strong></label>';
        //     html += ' <div class="input-group">';
        //     html += '<select class="custom-select satuan" id="satuan" name="satuan[]" required><option value="" disabled selected hidden>--Pilih--</option> ';
        //     html += '<?php foreach ($satuan as $unit) : ?>';
        //     html += '<option value="<?= $unit['id']; ?>"><?= $unit['nama']; ?></option>';
        //     html += '<?php endforeach ?> </select>';
        //     html += '<div class="invalid-feedback">';
        //     html += '</div></div></div>';

        //     html += '<div class="form-group col-md-3">';
        //     html += '<label for="stok">isi</label>';
        //     html += '<div class="input-group">';
        //     html += '<input type="text" class="form-control isi" value="" name="isi[]" placeholder="Masukan isi" id="isi" autocomplete="off" required>';
        //     html += '<div class="input-group-append">';
        //     html += '<span class="input-group-text unit" id="basic-addon2"></span>';
        //     html += '</div></div></div>';

        //     html += '<div class="form-group col-md-3">';
        //     html += '<label for="harga_jual" class="label-satuan1">Harga Jual</label>';
        //     html += '<div class="input-group">';
        //     html += '<div class="input-group-append">';
        //     html += '<span class="input-group-text">Rp</span>';
        //     html += '</div>';
        //     html += '<input type="text" class="form-control harga_jual" value="" placeholder="Masukan harga jual" name="harga_jual[]" id="harga_jual" autocomplete="off">';
        //     html += '<div class="invalid-feedback">';
        //     html += '</div></div></div>';

        //     html += '<div class="form-group col-md-1">';
        //     html += '<label></label>';
        //     html += '<button type="button" class="btn mt-2 hapus btn-danger d-block"  id="hapus"><i class="fa fa-trash-alt"></i></button>';
        //     html += '</div>';
        //     html += '</div>';

        //     $("#newRow").append(html);
        //     $(".hapus").click(function(e) {
        //         e.preventDefault();
        //         $(this).closest(`.form-new`).remove();
        //     });
        //     // ambilSatuan()

        //     var a = $(".satuan-terkecil option:selected").text()
        //     $(".unit").text(a);

        //     harga_jual();

        // });


        $("#createProduk").submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: "post",
                url: $(this).attr('action'),
                data: $(this).serialize(),
                dataType: "json",
                success: function(response) {

                    if (response.error) {
                        if (response.error.nama) {
                            $("#nama").addClass('is-invalid');
                            $(".error-nama").html(response.error.nama);
                        } else {
                            $("#nama").removeClass('is-invalid');
                            $(".error-nama").html('');
                        }
                        // if (response.error.satuan_beli) {
                        //     $("#satuan_beli").addClass('is-invalid');
                        //     $(".error-satuan_beli").html(response.error.satuan_beli);
                        // } else {
                        //     $("#satuan_beli").removeClass('is-invalid');
                        //     $(".error-satuan_beli").html('');
                        // }
                        if (response.error.kategori) {
                            $("#kategori").addClass('is-invalid');
                            $(".error-kategori").html(response.error.kategori);
                        } else {
                            $("#kategori").removeClass('is-invalid');
                            $(".error-kategori").html('');
                        }
                        // if (response.error.harga_beli) {
                        //     $("#harga_beli").addClass('is-invalid');
                        //     $(".error-harga_beli").html(response.error.harga_beli);
                        // } else {
                        //     $("#harga_beli").removeClass('is-invalid');
                        //     $(".error-harga_beli").html('');
                        // }
                        if (response.error.sku) {
                            $("#sku").addClass('is-invalid');
                            $(".error-sku").html(response.error.sku);
                        } else {
                            $("#sku").removeClass('is-invalid');
                            $(".error-sku").html('');
                        }


                        // if (response.error.barcode) {

                        //     Swal.fire(
                        //         'Barcode?',
                        //         'Terdapat barcode yang sudah ada pada produk lain.',
                        //         'error'
                        //     )

                        // }
                    }
                    // else if (response.msg) {
                    //     Swal.fire(
                    //         `Satuan ${response.satuan_beli}?`,
                    //         `Harga jual dalam satuan <b>${response.satuan_beli}</b> belum dibuat.`,
                    //         'error'

                    //     )
                    // } 
                    else if (response.sukses) {
                        var id = response.produk_id;
                        window.location.href = response.produk_id;
                    }

                },
                error: function(xhr, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        })


        $("#harga_beli").autoNumeric('init', {
            aSep: ',',
            aDec: '.',
            mDec: '0'

        });

        $("#stok").autoNumeric('init', {
            aSep: ',',
            aDec: '.',
            mDec: '0'
        });
        $("#tambahKategori").click(function(e) {
            e.preventDefault();
            $.ajax({
                url: "<?= base_url('produk/create_kategori') ?>",
                dataType: "json",
                type: 'post',
                data: {
                    aksi: 0
                },
                success: function(response) {
                    if (response.data) {
                        $(".viewModal").html(response.data).show();
                        $('#modalAddKategori').on('shown.bs.modal', function(event) {
                            $("#nama").focus();
                        });
                        $("#modalAddKategori").modal('show');
                    }
                },
                error: function(xhr, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        });
        $("#tambahSatuan").click(function(e) {
            e.preventDefault();
            $.ajax({
                url: "<?= base_url('produk/create_satuan') ?>",
                dataType: "json",
                type: 'post',
                data: {
                    aksi: 0
                },
                success: function(response) {
                    if (response.data) {
                        $(".viewModal").html(response.data).show();
                        $('#modalAddSatuan').on('shown.bs.modal', function(event) {
                            $("#nama").focus();
                        });
                        $("#modalAddSatuan").modal('show');
                    }
                },
                error: function(xhr, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        });
    });
</script>
<?php $this->endSection() ?>