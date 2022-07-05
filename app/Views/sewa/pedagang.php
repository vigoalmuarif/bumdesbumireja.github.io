<div class="row">
    <div class="col">
        <div class="card mb-3 card-pedagang">
            <div class="row ">
                <div class="col-md-3">
                    <img class="img-pedagang" src="<?= base_url('/img/profile.png') ?>" alt="...">
                </div>
                <div class="col">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm table-borderless">
                                <tbody>
                                    <tr>
                                        <td>NIK</td>
                                        <td>:</td>
                                        <td><strong><?= $pedagang['nik'] ?></strong></td>
                                    </tr>
                                    <tr>
                                        <td>Nama</td>
                                        <td>:</td>
                                        <td><strong><?= $pedagang['nama'] ?></strong></td>

                                    </tr>
                                    <tr>
                                        <td>Tempat/Tanggal Lahir</td>
                                        <td>:</td>
                                        <td><strong><?= $pedagang['tempat_lahir'] . ', ' . date('d-m-Y', strtotime($pedagang['tanggal_lahir'])) ?></strong></td>
                                    </tr>
                                    <tr>
                                        <td>No Telp.</td>
                                        <td>:</td>
                                        <td><strong><?= $pedagang['no_hp'] ?></strong></td>
                                    </tr>
                                    <tr>
                                        <td>Jenis Usaha</td>
                                        <td>:</td>
                                        <td><strong><?= $pedagang['jenis_usaha'] ?></strong></td>
                                    </tr>
                                    <tr>
                                        <td>Alamat</td>
                                        <td>:</td>
                                        <td><strong><?= $pedagang['alamat'] ?></strong></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card">
    <div class="btn-group" role="group" aria-label="Basic example">
        <?php if (in_groups('bendahara')) : ?>
            <a class="btn btn-pink rounded-0" href="#" tabindex="1" role="button" id="sewaBaru">Sewa Baru</a>
        <?php endif ?>
        <a class="btn btn-pink sedang-berlangsung" id="berlangsung" href="#" role="button">Sewa Saat Ini</a>
        <a class="btn btn-pink tagihan-bulanan" id="tagihanBulanan" href="#" role="button">Tagihan Bulanan</a>
        <a class="btn btn-pink rounded-0" href="#" id="riwayatSewa" role="button">Riwayat Sewa</a>

    </div>
    <div class="card-body border-left-secondary shadow">
        <div class="sewa"></div>
    </div>
</div>

<script>
    function tagihanBulanan() {
        $.ajax({
            type: "post",
            url: "<?= base_url('persewaan/tagihan_bulanan_by_pedagang') ?>",
            data: {
                id: <?= $pedagang['id'] ?>
            },
            dataType: "json",
            success: function(response) {
                $(".sewa").html(response.view);
                $("#sewaBaru").removeClass('active');
                $("#riwayatSewa").removeClass('active');
                $("#berlangsung").removeClass('active');
                $("#tagihanBulanan").addClass('active');
            },
            error: function(xhr, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }

    function berlangsung() {
        $.ajax({
            type: "post",
            url: "<?= base_url('persewaan/berlangsung') ?>",
            data: {
                id: "<?= $pedagang['id'] ?>"
            },
            dataType: "json",
            success: function(response) {
                $(".sewa").html(response.view);
                $("#berlangsung").addClass('active');

            },
            error: function(xhr, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });

    }

    $(document).ready(function() {
        berlangsung();

        $("#sewaBaru").click(function(e) {
            e.preventDefault();
            $.ajax({
                type: "get",
                url: "<?= base_url('persewaan/form_property') ?>",
                dataType: "json",
                success: function(response) {
                    $(".sewa").html(response.view);
                    $(".sedang-berlangsung").removeClass('active');
                    $("#riwayatSewa").removeClass('active');
                    $("#tagihanBulanan").removeClass('active');
                    $("#sewaBaru").addClass('active');
                },
                error: function(xhr, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        });
        $("#berlangsung").click(function(e) {
            e.preventDefault();
            $.ajax({
                type: "post",
                url: "<?= base_url('persewaan/berlangsung') ?>",
                data: {
                    id: <?= $pedagang['id'] ?>
                },
                dataType: "json",
                success: function(response) {
                    $(".sewa").html(response.view);
                    $("#sewaBaru").removeClass('active');
                    $("#riwayatSewa").removeClass('active');
                    $("#tagihanBulanan").removeClass('active');
                    $("#berlangsung").addClass('active');
                },
                error: function(xhr, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        });
        $("#tagihanBulanan").click(function(e) {
            e.preventDefault();
            tagihanBulanan();
        });
        $("#riwayatSewa").click(function(e) {
            e.preventDefault();
            $.ajax({
                type: "post",
                url: "<?= base_url('persewaan/riwayat_sewa') ?>",
                data: {
                    id: <?= $pedagang['id'] ?>
                },
                dataType: "json",
                success: function(response) {
                    $(".sewa").html(response.view);
                    $("#sewaBaru").removeClass('active');
                    $("#berlangsung").removeClass('active');
                    $("#tagihanBulanan").removeClass('active');
                    $("#riwayatSewa").addClass('active');
                },
                error: function(xhr, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        });

    })
</script>