<?php if (in_groups('admin')) {
    echo $this->extend('templates/index');
} elseif (in_groups('ketua')) {
    echo $this->extend('templates/index_ketua');
}
?>


<?php $this->section('content') ?>

<div class="row">
    <div class="col">
        <div class="flash-data" data-flashdata="<?= session()->getFlashdata('sukses') ?>"></div>
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Detail Pegawai</h6>
                <?php if (in_groups('admin')) : ?>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item ubah" role="button" data-id="<?= $pegawai['pegawaiID'] ?>">Ubah</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item hapus" role="button" data-id="<?= $pegawai['pegawaiID'] ?>" data-pegawai="<?= $pegawai['pegawai'] ?>">Hapus</a>
                        </div>
                    </div>
                <?php endif ?>
            </div>
            <!-- Card Body -->
            <div class="card-body detail">
                <div class="row no-gutters">
                    <div class="col col-lg-8 col-md-12 col-xs-12 m-auto">
                        <table class="table table-borderless table-hover">
                            <tbody>
                                <tr>
                                    <td>Nama Lengkap</td>
                                    <td>:</td>
                                    <td><?= $pegawai['pegawai']; ?></td>
                                </tr>
                                <tr>
                                    <td>NIK</td>
                                    <td>:</td>
                                    <td><?= $pegawai['nik']; ?></td>
                                </tr>
                                <tr>
                                    <td>Jenis Kelamin</td>
                                    <td>:</td>
                                    <td><?= $pegawai['jenis_kelamin'] == 'L' ? 'Laki-laki' : 'Perempuan' ?></td>
                                </tr>
                                <tr>
                                    <td>Tempat/Tgl. Lahir</td>
                                    <td>:</td>
                                    <td><?= $pegawai['tempat_lahir'] . ", " . date('d-m-Y', strtotime($pegawai['tanggal_lahir'])) ?></td>
                                </tr>
                                <tr>
                                    <td>Alamat</td>
                                    <td>:</td>
                                    <td><?= $pegawai['alamat']; ?></td>
                                </tr>
                                <tr>
                                    <td>No Telepon</td>
                                    <td>:</td>
                                    <td><?= $pegawai['no_hp']; ?></td>
                                </tr>
                                <tr>
                                    <td>jabatan</td>
                                    <td>:</td>
                                    <td><?= $pegawai['jabatan'] ?></td>
                                </tr>
                                <tr>
                                    <td>Status</td>
                                    <td>:</td>
                                    <td><span class="badge badge-<?= $pegawai['status'] == 1 ? 'success' : 'danger' ?>"><?= $pegawai['status'] == 1 ? 'Aktif' : 'Non-Aktif' ?></span></td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <?php if ($pegawai['created_at'] == $pegawai['updated_at']) : ?>
                    <small class="text-muted">Dibuat <?= date('d-m-Y H:i:s', strtotime($pegawai['created_at'])); ?></small>
                <?php elseif ($pegawai['updated_at'] !== $pegawai['created_at']) : ?>
                    <small class="text-muted">Diubah <?= date('d-m-Y H:i:s', strtotime($pegawai['updated_at'])); ?></small>
                <?php endif ?>

            </div>
        </div>
    </div>
</div>
<div class="ubah-petugas" style="display: none;"></div>


<script>
    $(document).ready(function() {
        $(".ubah").click(function(e) {
            e.preventDefault();
            $.ajax({
                type: "get",
                url: "<?= base_url('petugas/edit') ?>",
                data: {
                    id: $(this).data("id")
                },
                dataType: "json",
                success: function(response) {
                    if (response.view) {
                        $(".ubah-petugas").html(response.view).show();
                        $("#modalUbah").modal('show');
                    }
                },
                error: function(xhr, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        });

        $(".hapus").click(function(e) {
            e.preventDefault();
            let id = $(this).data('id');
            let pegawai = $(this).data('pegawai');
            Swal.fire({
                title: 'Hapus?',
                html: `Yakin ingin menghapus pegawai ${pegawai}?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Tidak'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "post",
                        url: "<?= base_url('petugas/delete') ?>",
                        data: {
                            id: id
                        },
                        dataType: "json",
                        success: function(response) {
                            if (response.sukses) {
                                window.location.href = '<?= base_url('petugas/index') ?>'

                            }
                        },
                        error: function(xhr, thrownError) {
                            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                        }
                    });

                }
            });
        });


    });
</script>

<?php $this->endSection(); ?>