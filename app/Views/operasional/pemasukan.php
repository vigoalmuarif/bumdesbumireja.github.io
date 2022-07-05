<?= $this->extend('templates/index'); ?>

<?= $this->section('content'); ?>
<!-- DataTales Example -->
<div class="flash-data" data-flashdata="<?= session()->getFlashdata('sukses') ?>"></div>
<div class="p">
    <button type="button" id="tambah" class="btn btn-primary float-right btn-sm">
        <i class="fa fas fa-plus"></i> Pemasukan
    </button>
    <h3 class="">Pemasukan Lain-Lain</h3>
    <hr class="sidebar-divider d-block d-md-block">
    <?php
    $request = \Config\Services::request();

    ?>

    <div class="card">
        <div class="card-header py-2 m-0">
            <div class="form-group">
                <select class="form-control form-control-sm col-md-2 m-0" id="exampleFormControlSelect1" onchange="location = this.value">
                    <option value="<?= base_url('operasional/pemasukan/semua') ?>" <?= $request->uri->getSegment(3) == "semua" ? "selected='selected'" : '' ?>>Semua</option>
                    <option value="<?= base_url('operasional/pemasukan/umum') ?>" <?= $request->uri->getSegment(3) == "umum" ? "selected='selected'" : '' ?>>Umum</option>
                    <option value="<?= base_url('operasional/pemasukan/pasar') ?>" <?= $request->uri->getSegment(3) == "pasar" ? "selected='selected'" : '' ?>>Pasar</option>
                    <option value="<?= base_url('operasional/pemasukan/atk') ?>" <?= $request->uri->getSegment(3) == "atk" ? "selected='selected'" : '' ?>>ATK</option>
                </select>
            </div>
            <div class="export float-right" id="export"></div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Hari/Tanggal</th>
                                    <th>Pemasukan</th>
                                    <th>Jumlah</th>
                                    <th>Keterangan</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($masuk as $row) : ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= longdate_indo(date('Y-m-d', strtotime($row['date']))) ?></td>
                                        <td><?= $row['unit']; ?></td>
                                        <td>Rp. <?= number_format($row['jumlah'], 0, ',', ','); ?></td>
                                        <td><?= $row['keterangan']; ?></td>
                                        <td class="text-center">
                                            <button class="btn btn-warning btn-sm edit" data-id="<?= $row['id']; ?>"><span class="fa fa-edit"></span></button>
                                            <button class="btn btn-danger btn-sm hapus" data-id="<?= $row['id']; ?>" data-jumlah="<?= number_format($row['jumlah'], 0, ',', ','); ?>"><span class="fa fa-trash-alt"></span></button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="add-pemasukan" style="display: none;"></div>
<div class="edit-pemasukan" style="display: none;"></div>

<script>
    $(document).ready(function() {
        $('#tambah').click(function(e) {

            e.preventDefault();
            $.ajax({
                type: "get",
                url: "<?= base_url('operasional/create_pemasukan') ?>",
                dataType: "json",
                success: function(response) {
                    $('.add-pemasukan').html(response.view).show();
                    $('#addPemasukan').modal('show');
                },

                error: function(xhr, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        })


        $(".hapus").click(function(e) {
            e.preventDefault();
            let id = $(this).data('id');
            let jumlah = $(this).data('jumlah');
            Swal.fire({
                title: 'Hapus?',
                html: `Yakin ingin menghapus pemasukan sebesar Rp. ${jumlah}?`,
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
                        url: "<?= base_url('operasional/delete_pemasukan') ?>",
                        data: {
                            id: id
                        },
                        dataType: "json",
                        success: function(response) {
                            if (response.sukses) {
                                window.location.reload();

                            }
                        }
                    });

                }
            });
        });

        $(".edit").click(function(e) {
            e.preventDefault();
            let id = $(this).data('id');
            $.ajax({
                type: "post",
                url: "<?= base_url('operasional/edit_pemasukan') ?>",
                data: {
                    id: id
                },
                dataType: "json",
                success: function(response) {
                    $('.edit-pemasukan').html(response.view).show();
                    $('#editPemasukan').modal('show');
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
        });

        $("#dataTable").dataTable();
    });
</script>

<?php $this->endSection() ?>