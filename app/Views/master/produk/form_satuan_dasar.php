<!-- Modal -->
<form action="<?= base_url('produk/save_satuan_dasar') ?>" method="post" id="formSatuanDasar">
    <div class="row">
        <div class="col">
            <div class="modal fade" id="modalSatuanDasar" tabindex="-1" aria-labelledby="modalDetailLabel" aria-hidden="true">
                <div class="modal-dialog  modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalDetailLabel">Satuan Terkecil(Dasar)</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-row">
                                <div class="form-group">
                                    <div class="alert alert-success" role="alert">Satuan jual terkecil/dasar digunakan sebagai acuan stok dan harga dasar pada produk <strong><?= $produk ?></strong>.</div>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="nama">Produk</label>
                                    <input type="hidden" name="id" id="id" value="<?= $produkID; ?>" readonly>
                                    <input type="hidden" name="isi" id="isi" value="1" readonly>
                                    <input type="text" class="form-control" name="nama" id="nama" value="<?= $sku . ' - ' . $produk ?>" placeholder="Masukan nama" readonly>
                                    <div class="invalid-feedback error-nama">

                                    </div>
                                </div>

                                <div class="satuan-add col-md-12" style="display: none;"></div>

                                <div class="form-group satuan col-md-12">
                                    <label for=" satuan">Satuan Jual Terkecil<strong class="text-danger">*</strong></label>
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
                var isi = $("#satuanCreate").val();
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

        $("#formSatuanDasar").submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: "post",
                url: $(this).attr('action'),
                data: $(this).serialize(),
                dataType: "json",
                success: function(response) {
                    if (response.error) {
                        if (response.error.satuan) {
                            $("#satuan").addClass('is-invalid');
                            $(".error-satuan").html(response.error.satuan)
                        } else {
                            $("#satuan").removeClass('is-invalid');
                            $(".error-satuan").html('')
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