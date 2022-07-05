<!-- Modal -->
<form action="<?= base_url('pembelian/save_temp') ?>" id="formPembelian">
    <div class="modal fade" id="modalAddProduk" tabindex="-1" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog  modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalProdukLabel">Pembelian Produk</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="alert alert-success" role="alert">Jika satuan beli tidak ada atau kosong, tambahkan dahulu (satuan) pada menu master produk.</div>
                    </div>
                    <input type="hidden" name="produkID" id="produkID" value="<?= isset($produk['produkID']) ? $produk['produkID'] : $temp['produkID'] ?>" readonly>
                    <div class="form-group">
                        <label for="nama">Nama Barang</label>
                        <input type="text" class="form-control" id="nama" name="nama" value="<?= isset($produk['produk']) ? $produk['sku'] . ' - ' . $produk['produk'] : $temp['sku'] . ' - ' . $temp['produk'] ?>" readonly>
                    </div>
                    <div class="form-row">
                        <div class="col col-md-6">
                            <div class="form-group">
                                <label for="satuan_beli">Satuan Beli</label>
                                <select class="custom-select" name="satuan_beli" id="satuanBeli">
                                    <option value="" selected disabled hidden>--Pilih--</option>
                                    <?php foreach ($satuan as $row) : ?>
                                        <option value="<?= $row['satuan_id']; ?>" <?php if (isset($temp['satuan_id'])) {
                                                                                        if ($temp['satuan_id'] == $row['satuan_id']) {
                                                                                            echo 'selected="selected"';
                                                                                        }
                                                                                    } ?>><?= strtoupper($row['satuan']); ?></option>
                                    <?php endforeach ?>
                                </select>
                                <div class="invalid-feedback error-satuan_beli">

                                </div>
                            </div>
                        </div>
                        <div class="col col-md-6">
                            <div class="form-group">
                                <label for="qty">Jumlah</label>
                                <input type="number" min="0" value="<?= isset($temp['qty']) ? $temp['qty'] : ''; ?>" class="form-control" id="qty" name="qty">
                                <div class="invalid-feedback error-qty">

                                </div>
                            </div>
                        </div>
                        <div class="col col-md-6">
                            <div class="form-group">
                                <label for="total">Harga Beli Total (Rp)</label>
                                <input type="text" class="form-control" id="total" name="total" value="<?= isset($temp['sub_total']) ? $temp['sub_total'] : ''; ?>" autocomplete="off">
                                <div class="invalid-feedback error-harga-total">

                                </div>
                            </div>
                        </div>
                        <div class="col col-md-6">
                            <div class="form-group">
                                <label for="harga_satuan">Harga Beli/Unit</label>
                                <input type="text" class="form-control" id="harga_satuan" name="harga_satuan" value="<?= isset($temp['harga_beli']) ? $temp['harga_beli'] : ''; ?>" autocomplete="off">
                                <div class="invalid-feedback error-harga-satuan">

                                </div>
                            </div>
                        </div>
                        <div class="col col-md-12">
                            <div class="form-group">
                                <label for="harga_beli">Keterangan</label>
                                <textarea class="form-control" name="keterangan" id="keterangan" cols="3" rows="4"><?= isset($temp['keterangan']) ? $temp['keterangan'] : ''; ?></textarea>
                            </div>
                        </div>

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="batal" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="simpan"><?= isset($temp['produkID']) ? 'Ubah' : 'Simpan'; ?></button>
                </div>
            </div>
        </div>
    </div>
</form>
<script>
    function batal() {
        $.ajax({
            type: "get",
            url: "<?= base_url('pembelian/list_produk') ?>",
            dataType: "json",
            success: function(response) {
                $("#modalAddProduk").modal('hide');
                $(".modalListProduk").html(response.data).show();
                $("#modalProduk").modal('show');
            }
        });
    }


    $(document).ready(function() {

        $("#batal").click(function(e) {
            e.preventDefault();
            batal();
        });

        $("#formPembelian").submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: "post",
                url: $(this).attr('action'),
                data: $(this).serialize(),
                dataType: "json",
                success: function(response) {
                    if (response.error) {
                        if (response.error.satuan_beli) {
                            $("#satuanBeli").addClass('is-invalid');
                            $(".error-satuan_beli").html(response.error.satuan_beli);
                        } else {
                            $("#satuanBeli").removeClass('is-invalid');
                            $(".error-qty").html('');
                        }
                        if (response.error.qty) {
                            $("#qty").addClass('is-invalid');
                            $(".error-qty").html(response.error.qty);
                        } else {
                            $("#qty").removeClass('is-invalid');
                            $(".error-qty").html('');
                        }
                        if (response.error.harga_total) {
                            $("#total").addClass('is-invalid');
                            $(".error-harga-total").html(response.error.harga_total);
                        } else {
                            $("#total").removeClass('is-invalid');
                            $(".error-harga-total").html('');
                        }
                        if (response.error.harga_satuan) {
                            $("#harga_satuan").addClass('is-invalid');
                            $(".error-harga-satuan").html(response.error.harga_satuan);
                        } else {
                            $("#harga_satuan").removeClass('is-invalid');
                            $(".error-harga-satuan").html('');
                        }
                        if (response.error.lebih_besar) {
                            $("#harga_satuan").addClass('is-invalid');
                            $(".error-harga-satuan").html(response.error.lebih_besar);
                        } else {
                            $("#harga_satuan").removeClass('is-invalid');
                            $(".error-harga-satuan").html('');
                        }


                        // const Toast = Swal.mixin({
                        //     toast: true,
                        //     position: 'top-end',
                        //     showConfirmButton: false,
                        //     timer: 3000,
                        //     timerProgressBar: true,
                        //     didOpen: (toast) => {
                        //         toast.addEventListener('mouseenter', Swal.stopTimer)
                        //         toast.addEventListener('mouseleave', Swal.resumeTimer)
                        //     }
                        // })

                        // Toast.fire({
                        //     icon: 'warning',
                        //     html: response.error
                        // })
                    } else {
                        if (response.sukses) {
                            $("#modalAddProduk").modal('hide');
                            $('#modalAddProduk').on('hidden.bs.modal', function(event) {
                                $("#barcode").focus();
                            });
                            $("#barcode").val('');
                            detail();
                            totalBayar();
                        }
                    }
                },
                error: function(xhr, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        });

        $("#total, #qty").keyup(function() {
            let total = $("#total").autoNumeric('get');
            let qty = $("#qty").val();
            let harga_satuan = parseInt(total / qty);
            let nilai = $("#harga_satuan").autoNumeric('set', harga_satuan);


        });
        // $("#qty").keyup(function() {
        //     let harga_beli = $("#harga_beli").autoNumeric('get');
        //     let qty = $("#qty").val();
        //     let total = parseFloat(harga_beli) * parseFloat(qty);
        //     $("#total").val(total);
        //     let total_harga = $("#total").val();
        //     $("#total").autoNumeric('set', total_harga);

        // });
        $("#qty").click(function() {
            let total = $("#total").autoNumeric('get');
            let qty = $("#qty").val();
            let harga_satuan = parseInt(total / qty);
            let nilai = $("#harga_satuan").autoNumeric('set', harga_satuan);

        });


        $("#harga_beli").autoNumeric('init', {
            'aSep': ',',
            'aDec': '.',
            'mDec': ''
        })
        $("#harga_satuan").autoNumeric('init', {
            'aSep': ',',
            'aDec': '.',
            'mDec': ''
        })
        $("#total").autoNumeric('init', {
            'aSep': ',',
            'aDec': '.',
            'mDec': ''
        })


    });
</script>