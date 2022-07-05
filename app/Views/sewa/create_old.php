<?php $this->extend('templates/index') ?>

<?php $this->section('content') ?>

<h1 class="h3 mb-2 text-gray-800">Tambah Sewa Baru</h1>
<hr class="sidebar-divider d-none d-md-block">
<?php if (session()->getFlashdata('pesan')) : ?>
    <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
        <?= session()->getFlashdata('pesan') ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif ?>
<div class="card shadow-lg">
    <h5 class="card-header text-center">From Sewa Property</h5>
    <form action="<?= base_url('sewa/save') ?>" method="post">
        <div class="card-body">
            <div class="row">

                <div class="col">
                    <div class="card mb-3">
                        <div class="card-header">
                            Data Penyewa
                        </div>
                        <div class="card-body">
                            <div class="form-row ">
                                <input type="hidden" id="pedagang_id" value="<?= set_value('pedagang_id') ?>" name="pedagang_id">
                                <input type="hidden" id="invoice" value="<?= $invoice ?>" name="invoice">
                                <div class="form-group nama-sewa col-md-12">
                                    <label for="input-nama">Nama Penyewa</label>
                                    <div class="input-group ">
                                        <input type="text" class="form-control   <?= $validation->hasError('input-nama') ? 'is-invalid' : '' ?>" value="<?= set_value('input-nama') ?>" placeholder="Cari nama penyewa" id="input-nama" name="input-nama" readonly>
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-info" id="cari-nama" data-toggle="modal" data-target="#penyewa-modal"><span class="fa fa-search"></span></button>
                                        </div>
                                    </div>
                                    <small id="emailHelp" class="form-text text-danger"><?= $validation->getError('input-nama') ?></small>
                                </div>

                                <div class="form-group col-12">
                                    <label for="nik">NIK</label>
                                    <input type="text" class="form-control form-control-sm m-0 " id="nik" name="nik" value="<?= set_value('nik') ?>" readonly>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="alamat">Alamat</label>
                                    <input type="text" class="form-control form-control-sm m-0" id="alamat" name="alamat" value="<?= set_value('alamat') ?>" readonly>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="no_hp">No Telp.</label>
                                    <input type="text" class="form-control form-control-sm m-0" id="no_hp" name="no_hp" value="<?= set_value('no_hp') ?>" readonly>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="card mb-3">
                        <div class="card-header">
                            Data Property
                        </div>
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-md-12  nama-sewa">
                                    <label for="input-kode">Kode Property</label>
                                    <input type="hidden" id="property_id" name="property_id" value="<?= set_value('property_id') ?>">
                                    <input type="hidden" id="rega" name="rega" value="<?= set_value('rega') ?>">
                                    <div class="input-group">
                                        <input type="text" class="form-control <?= $validation->hasError('input-kode') ? 'is-invalid' : '' ?>" value="<?= set_value('input-kode') ?>" placeholder="Cari property tersedia" id="input-kode" name="input-kode" readonly>
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#property-modal"><span class="fa fa-search"></span></button>
                                        </div>
                                    </div>
                                    <small class="form-text text-danger"><?= $validation->getError('input-kode') ?></small>
                                </div>
                                <div class="form-group col-12">
                                    <label for="jenis">Jenis</label>
                                    <input type="text" class="form-control form-control-sm m-0 " id="jenis" name="jenis" value="<?= set_value('jenis') ?>" readonly>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="fasilitas">Fasilitas</label>
                                    <input type="text" class="form-control form-control-sm m-0" id="fasilitas" name="fasilitas" value="<?= set_value('fasilitas') ?>" readonly>
                                </div>
                                <div class="form-group   col-md-12">
                                    <label for="harga_property">Harga</label>
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-append">
                                            <span class="input-group-text ">Rp</span>
                                        </div>
                                        <input type="text" class="form-control form-control-sm" name="harga_property" id="harga_property" value="<?= set_value('harga_property') ?>" readonly>
                                        <div class="invalid-feedback">

                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>


            <div class="card">
                <div class="card-header">
                    No Transaksi: <?= $invoice; ?>
                </div>
                <div class="card-body">
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="validationDefault01">Tanggal Sewa</label>
                            <input type="text" class="form-control  <?= $validation->hasError('tanggal_sewa') ? 'is-invalid' : '' ?>" value="<?= set_value('tanggal_sewa') ?>" name="tanggal_sewa" id="tanggal_sewa">
                            <div class="invalid-feedback">
                                <?= $validation->getError('tanggal_sewa') ?>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationDefault02">Tanggal Selesai</label>
                            <input type="text" class="form-control <?= $validation->hasError('tanggal_selesai') ? 'is-invalid' : '' ?>" value="<?= set_value('tanggal_selesai') ?>" name="tanggal_selesai" id="tanggal_selesai">
                            <div class="invalid-feedback">
                                <?= $validation->getError('tanggal_selesai') ?>
                            </div>
                        </div>
                        <div class="form-group  col-md-6">
                            <label for="uang_muka">Uang Muka</label>
                            <div class="input-group">
                                <div class="input-group-append">
                                    <span class="input-group-text">Rp</span>
                                </div>
                                <input type="text" class="form-control  <?= $validation->hasError('uang_muka') ? 'is-invalid' : '' ?>" placeholder="Masukan uang muka" name="uang_muka" id="uang_muka" value="<?= set_value('uang_muka') ?>">
                                <div class="invalid-feedback">
                                    <?= $validation->getError('uang_muka') ?>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="metode">Jenis Pembayaran</label>
                                <select class="form-control  <?= $validation->hasError('metode') ? 'is-invalid' : '' ?>" id="metode" name="metode">

                                    <option value="" disabled selected hidden>---Belum dipilih---</option>

                                    <option value="Tunai" <?= set_value('metode') == "Tunai" ? 'selected="selected"' : '' ?>>Tunai</option>
                                    <option value="Transfer" <?= set_value('metode') == "Transfer" ? 'selected="selected"' : '' ?>>Transfer</option>

                                </select>
                                <div class="invalid-feedback">
                                    <?= $validation->getError('metode') ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group  col-md-6">
                            <label for="kekurangan">Kekurangan</label>
                            <div class="input-group">
                                <div class="input-group-append">
                                    <span class="input-group-text">Rp</span>
                                </div>
                                <input type="hidden" class="form-control " name="harga" id="harga" value="<?= set_value('harga') ?>">
                                <input type="text" class="form-control text-danger" name="kekurangan" id="kekurangan" value="<?= set_value('kekurangan') ?>" readonly>
                                <div class="invalid-feedback">

                                </div>
                            </div>
                        </div>
                    </div>
                    <a href="<?= base_url('sewa/index/') ?>" class="btn btn-secondary float-right" onclick="return confirm('Yakin ingin membatalkan?')">Batal</a>
                    <button type="submit" id="simpan" class="btn btn-primary float-right mr-1">Simpan</button>
                </div>
            </div>

        </div>
    </form>
</div>

<!-- Modal Data Penyewa-->
<div class="modal fade" id="penyewa-modal" tabindex="-1" aria-labelledby="penyewa-label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="penyewa-label">Daftar Penyewa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <a href="<?= base_url('sewa/createPedagang') ?>" class="btn btn-primary btn-sm mb-3">Tambah</a>
                <div class="table-responsive">
                    <table class="table table-bordered dataTable" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>No HP</th>
                                <th>Tangggungan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            foreach ($penyewa as $cust) : ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td style="min-width: 200px;"><?= $cust['nama']; ?></td>
                                    <td><?= $cust['no_hp']; ?></td>
                                    <td><?= $cust['tanggungan'] == 0 ? '<span class="badge badge-success">Tidak ada</span>' : '<span class="badge badge-danger">Ada</span>' ?></td>
                                    <td>
                                        <button type="button" class="btn btn-primary btn-sm  pilih-penyewa" data-id="<?= $cust['id'] ?>" data-nama="<?= $cust['nama'] ?>" data-nik="<?= $cust['nik'] ?>" data-alamat="<?= $cust['alamat'] ?>" data-no_hp="<?= $cust['no_hp'] ?>" id="pilih-penyewa" <?= $cust['tanggungan'] == 1 ? 'disabled' : '' ?>>
                                            Pilih
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach ?>

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Data Property-->
<div class="modal fade" id="property-modal" tabindex="-1" aria-labelledby="property-modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="property-modal">Daftar Property</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered dataTable" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>kode</th>
                                <th>Jenis</th>
                                <th>Harga</th>
                                <th>Jangka</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            foreach ($property as $properti) : ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $properti['kode_property']; ?></td>
                                    <td><?= $properti['jenis_property']; ?></td>
                                    <td>Rp. <?= number_format($properti['harga'], 0, ".", ".") ?></td>
                                    <td><?= $properti['jangka']; ?> Tahun</td>
                                    <td><span class="badge badge-success"><?= $properti['status'] == 1  ? 'Tersedia' : 'Disewa' ?></span></td>
                                    <td>
                                        <button class="btn btn-primary btn-sm btn-block pilih-property" data-id="<?= $properti['property_id'] ?>" data-kode="<?= $properti['kode_property'] ?>" data-jenis="<?= $properti['jenis_property'] ?>" data-fasilitas="<?= $properti['fasilitas'] ?>" data-harga="<?= $properti['harga'] ?>" data-jangka="<?= $properti['jangka'] ?>" title="Detail" id="pilih-property">
                                            Pilih
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach ?>

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {

        $('#uang_muka, #harga').keyup(function() {
            let uang_muka = $("#uang_muka").val()
            let harga = $("#harga").val();
            let juml = harga - uang_muka

            $("#kekurangan").val(juml.toLocaleString());
        })

        // // form penyewa, properti

        // $(".table-penyewa").is(function() {
        //     $(".table-penyewa").toggle(function() {
        //         $(".pilih-penyewa").click(function() {
        //             $(".table-penyewa").show()

        //         })
        //     })
        // });

        // // $(".table-penyewa").hide(function() {
        // //     $(".pilih-penyewa").click(function() {
        // //         $(".table-penyewa").show();
        // //     })
        // // });
        // $(".table-property").hide(function() {
        //     $(".pilih-property").click(function() {
        //         $(".table-property").show();
        //     })
        // });


        $(document).on('click', '#pilih-penyewa', function() {
            var id = $(this).data('id')
            var nama = $(this).data('nama');
            var nik = $(this).data("nik");
            var alamat = $(this).data("alamat");
            var no_hp = $(this).data("no_hp");
            $("#pedagang_id").val(id);
            $("#input-nama").val(nama);
            $("#nik").val(nik);
            $("#alamat").val(alamat);
            $("#no_hp").val(no_hp);
            $("#penyewa-modal").modal("hide");

        })
        $(document).on('click', '.pilih-property', function() {
            var id = $(this).data('id')
            var kode = $(this).data('kode');
            var jenis = $(this).data("jenis");
            var fasilitas = $(this).data("fasilitas");
            var harga = $(this).data("harga");
            var jangka = $(this).data("jangka");
            $("#property_id").val(id);
            $("#input-kode").val(kode);
            $("#jenis").val(jenis);

            $("#jangka").val(jangka);
            $("#fasilitas").val(fasilitas);
            $("#kekurangan").val(harga);
            $("#harga_property").val(harga.toLocaleString() + ' / ' + jangka + ' Tahun');
            $("#harga").val(harga);
            $("#uang_muka").val(null);
            $("#tanggal_sewa").datepicker('setDate', null);
            $("#tanggal_selesai").datepicker('setDate', null);
            $("#property-modal").modal("hide");


            $("#tanggal_sewa").change(function() {
                var sewa = $("#tanggal_sewa").datepicker('getDate');
                var date = sewa.getDate();
                var month = sewa.getMonth();
                var year = sewa.getFullYear();
                var tanggal = new Date(year + jangka, month, date);
                var curr_date = $.datepicker.formatDate("dd-mm-yy", tanggal)

                $("#tanggal_selesai").val(curr_date);

            })

        })

        // end form penyewa

        // form tanggal sewa, tanggal selesai
        $("#tanggal_sewa").datepicker({
            changeYear: true,
            changeMonth: true,
            dateFormat: "dd-mm-yy",
            dayNamesMin: ["Ming", "Sen", "Sel", "Rab", "Kam", "Jum", "Sab"],
            yearRange: "c-50:c+50"
        });
        $("#tanggal_selesai").datepicker({
            changeYear: true,
            changeMonth: true,
            dateFormat: "dd-mm-yy",
            navigationAsDateFormat: true,
            dayNamesMin: ["Ming", "Sen", "Sel", "Rab", "Kam", "Jum", "Sab"],
            yearRange: "c-50:c+50"
        });

    });
</script>

<?php $this->endSection() ?>