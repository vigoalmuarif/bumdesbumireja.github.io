<?php $this->extend('templates/index_sewa') ?>

<?php $this->section('content') ?>
<h1 class="h4 mb-2 text-gray-800">Transaksi Property & Tagihan Bulanan</h1>
<hr class="sidebar-divider d-none d-md-block">
<div class="row">
    <div class="col">
        <div class="card border-left-primary shadow mb-2">
            <div class="card-body">
                <div class="row">
                    <div class="col col-md-4">
                        <div class="input-group">
                            <input type="text" class="form-control form-control" name="ktp" id="ktp" placeholder="Masukan NIK Pedagang">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-info cari-pelanggan"><i class="fa fas fa-search"></i> Cari</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <button type="button" id="createPedagang" class="btn btn-primary"><i class="fa fa-plus"></i> Pedagang Baru</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="pedagang"></div>


    </div>
</div>

<div class="form-create-pedagang" style="display: none;"></div>


<script>
    function cariPelanggan() {
        let nik = $("#ktp").val();
        if (nik.length < 1) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Masukan NIK pelanggan terlebih dahulu!',
            })
        } else {
            $.ajax({
                type: "post",
                url: "<?= base_url('persewaan/cari_pedagang') ?>",
                data: {
                    nik: $("#ktp").val()
                },
                dataType: "json",
                beforeSend: function() {
                    $(".cari-pelanggan").html('<i class="fa fa-spin fa-spinner"></i>');
                },
                complete: function() {
                    $(".cari-pelanggan").html('<i class="fa fa-search"></i> Cari');
                    $(".cari-pelanggan").attr('disabled', false);
                },
                success: function(response) {
                    if (response.view) {
                        $(".pedagang").html(response.view);
                        $(".sedang-berlangsung").addClass('active');
                        $("#formTransaksi").hide();
                    } else {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Oops...',
                            html: response.status,
                        });
                        $(".pedagang").html('');
                        $("#formTransaksi").hide();
                    }
                },
                error: function(xhr, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        }
    }
    $(document).ready(function() {

        $('ul.navbar-nav').addClass('toggled');

        $(".cari-pelanggan").click(function(e) {
            cariPelanggan();
        });

        $("#createPedagang").click(function(e) {
            e.preventDefault();
            $.ajax({
                type: "post",
                url: "<?= base_url('pedagang/create') ?>",
                data: {
                    aksi: 0
                },
                dataType: "json",
                success: function(response) {
                    $(".form-create-pedagang").html(response.view).show();
                    $("#modalCreatePedagang").modal('show');
                },
                error: function(xhr, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        });

    });
</script>
<?php $this->endSection() ?>