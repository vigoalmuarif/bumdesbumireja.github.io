<?= $this->extend('templates/index_atk'); ?>

<?= $this->section('content'); ?>
<!-- DataTales Example -->
<div class="flash-data" data-flashdata="<?= session()->getFlashdata('sukses') ?>"></div>
<div class="p">
    <?php if ($cek < 1) : ?>
        <button type="button" id="create" class="btn btn-primary float-right btn-sm">
            Ubah
        </button>
    <?php else : ?>
        <button type="button" id="edit" class="btn btn-primary float-right btn-sm" data-id="<?= $printer['id'] ?>">
            Ubah
        </button>
    <?php endif ?>
    <h3 class="">Printer Thermal</h3>
    <hr class="sidebar-divider d-block d-md-block">
    <div class="row">
        <div class="col">
            <div class="card">

                <div class="card-body">
                    <table class="table table-striped">
                        <tr>
                            <td>Nama Printer</td>
                            <td class="text-left">:</td>
                            <td><?= isset($printer['printer']) ? $printer['printer'] : 'Nama printer' ?></td>
                        </tr>
                        <tr>
                            <td>Nama Toko</td>
                            <td class="text-left">:</td>
                            <td><?= isset($printer['nama_toko']) ? $printer['nama_toko'] : 'Nama Toko' ?></td>
                        </tr>
                        <tr>
                            <td>Alamat Toko</td>
                            <td class="text-left">:</td>
                            <td><?= isset($printer['alamat']) ? $printer['alamat'] : 'Alamat Toko' ?></td>
                        </tr>
                        <tr>
                            <td>Footer Toko 1</td>
                            <td class="text-left">:</td>
                            <td><?= isset($printer['footer_1']) ? $printer['footer_1'] : 'Pesan singkat di bagian dibawah' ?></td>
                        </tr>
                        <tr>
                            <td>Footer Toko 1</td>
                            <td class="text-left">:</td>
                            <td><?= isset($printer['footer_2']) ? $printer['footer_2'] : 'Pesan singkat di bagian dibawah' ?></td>
                        </tr>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
<div class="create-printer" style="display: none;"></div>
<div class="edit-printer" style="display: none;"></div>

<script>
    $("#create").click(function(e) {
        e.preventDefault();
        $.ajax({
            type: "get",
            url: "<?= base_url('profil/create_printer') ?>",
            dataType: "json",
            success: function(response) {
                $('.create-printer').html(response.view).show();
                $('#modalCreate').modal('show');
            },

            error: function(xhr, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    });
    $("#edit").click(function(e) {
        e.preventDefault();
        $.ajax({
            type: "get",
            url: "<?= base_url('profil/edit_printer') ?>",
            data: {
                id: $(this).data('id')
            },
            dataType: "json",
            success: function(response) {
                $('.edit-printer').html(response.view).show();
                $('#modalEdit').modal('show');
            },

            error: function(xhr, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    });

    $("#pemasukan").change(function(e) {
        e.preventDefault();
        if (this.select) {

        }
    })
</script>
<?php $this->endSection() ?>