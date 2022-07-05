<?= $this->extend('templates/index'); ?>

<?= $this->section('content'); ?>
<!-- DataTales Example -->
<div class="flash-data" data-flashdata="<?= session()->getFlashdata('sukses') ?>"></div>
<div class="p">
    <button type="button" id="ubah" class="btn btn-primary float-right btn-sm">
        Ubah
    </button>
    <h3 class="">Profil</h3>
    <hr class="sidebar-divider d-block d-md-block">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Logo</td>
                                <td class="text-left">:</td>
                                <td>Nama BUMDes</td>
                            </tr>
                            <tr>
                                <td>Nama BUMDes</td>
                                <td class="text-left">:</td>
                                <td><?= $profil['nama'] ?></td>
                            </tr>
                            <tr>
                                <td>Ketua</td>
                                <td class="text-left">:</td>
                                <td><?= $profil['ketua'] ?></td>
                            </tr>
                            <tr>
                                <td>No Telepon</td>
                                <td class="text-left">:</td>
                                <td><?= $profil['no_hp'] ?></td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td class="text-left">:</td>
                                <td><?= $profil['email'] ?></td>
                            </tr>
                            <tr>
                                <td>Alamat</td>
                                <td class="text-left">:</td>
                                <td><?= $profil['alamat'] ?></td>
                            </tr>

                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
<div class="edit-profil" style="display: none;"></div>

<script>
    $("#ubah").click(function(e) {
        e.preventDefault();
        $.ajax({
            type: "get",
            url: "<?= base_url('profil/edit') ?>",
            dataType: "json",
            success: function(response) {
                $('.edit-profil').html(response.view).show();
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