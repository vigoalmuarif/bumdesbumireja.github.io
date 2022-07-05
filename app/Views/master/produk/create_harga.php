<!-- Modal -->
<form action="<?= base_url('produk/save_satuan_harga') ?>" method="post" id="formSatuanHarga">
    <div class=" row">
        <div class="col">
            <div class="modal fade" id="modalCreateHarga" tabindex="-1" aria-labelledby="modalCreateHargaLabel" aria-hidden="true">
                <div class="modal-dialog  modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalCreateHargaLabel">Satuan Harga</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <?php if ($cek_pembelian > 0) : ?>
                                <div class="alert alert-info" role="alert">Harga Pembelian Terakhir adalah Rp. <?= number_format($pembelian['harga']) . ' / ' . $pembelian['satuan']; ?>. Silahkan atur harga dasar dan harga jual sesuai satuan yang akan ditambahkan.</div>
                            <?php endif ?>
                            <div class="form-row">

                                <div class="form-group col-md-12">
                                    <label for="nama">Produk</label>
                                    <input type="hidden" name="id" id="id" value="<?= $produkID; ?>" readonly>
                                    <input type="text" class="form-control" name="nama" id="nama" value="<?= $sku . ' - ' . $produk ?>" placeholder="Masukan nama" readonly>
                                    <div class="invalid-feedback error-nama">

                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="nama_lain">Nama Lain produk</label>
                                    <input type="text" class="form-control" name="nama_lain" id="nama_lain" placeholder="Masukan nama lain produk jika dibutuhkan">
                                    <div class="invalid-feedback error-nama_lain">

                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="barcode">Barcode</label>
                                    <input type="text" class="form-control" name="barcode" id="barcode" placeholder="Masukan Barcode" autocomplete="off">
                                    <div class="invalid-feedback error-barcode">

                                    </div>
                                </div>

                                <div class="satuan-add col-md-12" style="display: none;"></div>

                                <div class="form-group satuan col-md-6">
                                    <label for=" satuan">Satuan<strong class="text-danger">*</strong></label>
                                    <div class="input-group">
                                        <select class="custom-select" id="satuan" name="satuan">
                                            <option value=''>--Pilih--</option>
                                        </select>
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-info" id="tambahSatuan"><i class="fas fa-plus"></i></button>
                                        </div>
                                        <div class="invalid-feedback error-satuan">

                                        </div>
                                    </div>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="isi">Isi<strong class="text-danger">*</strong></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="isi" id="isi" placeholder="Masukan isi" autocomplete="off">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><?= $satuan; ?></span>
                                        </div>
                                        <div class="invalid-feedback error-isi">

                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="harga_jual">Harga Jual</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp</span>
                                        </div>
                                        <input type="text" class="form-control" name="harga_jual" id="harga_jual" value="" placeholder="Harga jual per unit" autocomplete="off">
                                        <div class="invalid-feedback error-harga_jual">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary simpan">Simpan</button>
                        </div>
                    </div>


                </div>

            </div>
        </div>
    </div>
</form>
<div class="createSatuan"></div>

<script>
    function ambilSatuan() {
        $.ajax({
            url: "<?= base_url('produk/ambilSatuan') ?>",
            dataType: "json",

            success: function(response) {
                if (response.data) {
                    $("#satuan").html(response.data);
                }

            },
            error: function(xhr, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }

    $(document).ready(function() {
        ambilSatuan();


        $("#tambahSatuan").click(function(e) {
            e.preventDefault();
            var html = '';
            html += '<div class="form-group satuan2">';
            html += '<label for=" satuan">Satuan Jual Terkecil<strong class="text-danger">*</strong></label>';
            html += '<div class="input-group">';
            html += '<input type="text" class="form-control" name="create-satuan" id="satuanCreate"  placeholder="Masukan Satuan Baru" autocomplete="off">';
            html += '<div class="input-group-append">';
            html += '<button type="button" class="btn btn-success create-satuan" id="">Tambah</button>';
            html += '<button type="button" class="btn btn-danger cancel-add-satuan" id="">Batal</button>';
            html += '</div>';
            html += '</div></div>';

            $(".satuan-add").append(html).show();
            $(".satuan").hide();
            $(".simpan").prop('disabled', true)
            $(".create-satuan").prop('disabled', true);

            $("#satuanCreate").keyup(function(e) {
                let isi = $("#satuanCreate").val();
                if (isi == '') {
                    $(".create-satuan").prop('disabled', true);

                } else {
                    $(".create-satuan").prop('disabled', false);

                }
            })

            $(".cancel-add-satuan").click(function(e) {
                e.preventDefault();
                $(this).closest(`.satuan2`).remove();
                $(".satuan-add").hide();
                $(".satuan").show();
                $(".simpan").prop('disabled', false)
            });
            $(".create-satuan").click(function(e) {
                e.preventDefault();
                $.ajax({
                    type: "post",
                    url: "<?= base_url('produk/save_satuan') ?>",
                    data: {
                        nama: $("#satuanCreate").val()
                    },
                    dataType: "json",
                    success: function(response) {
                        $(".satuan2").closest(`.satuan2`).remove();
                        $(".satuan-add").hide();
                        $(".satuan").show();
                        $(".simpan").prop('disabled', false);
                        ambilSatuan();
                    }
                });

            });

        });

        $("#formSatuanHarga").submit(function(e) {
            e.preventDefault();
            var a = $(this).serialize();
            $.ajax({
                type: "post",
                url: $(this).attr('action'),
                data: $(this).serialize(),
                dataType: "json",
                success: function(response) {

                    if (response.error) {
                        if (response.error.barcode) {
                            $("#barcode").addClass('is-invalid');
                            $(".error-barcode").html(response.error.barcode)
                        } else {
                            $("#barcode").removeClass('is-invalid');
                            $(".error-barcode").html('')
                        }
                        if (response.error.satuan) {
                            $("#satuan").addClass('is-invalid');
                            $(".error-satuan").html(response.error.satuan)
                        } else {
                            $("#satuan").removeClass('is-invalid');
                            $(".error-satuan").html('')
                        }
                        if (response.error.isi) {
                            $("#isi").addClass('is-invalid');
                            $(".error-isi").html(response.error.isi)
                        } else {
                            $("#isi").removeClass('is-invalid');
                            $(".error-isi").html('')
                        }
                    } else if (response.msg) {
                        window.location.reload();
                    }
                },
                error: function(xhr, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        });


        $("#harga_jual").autoNumeric('init', {
            aSep: ',',
            aDec: '.',
            mDec: '0'

        });

    })
</script>