<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style type="text/css">
        @media print {
            body {
                -webkit-print-color-adjust: exact !important;
            }

            .kop img {
                width: 80px;
                height: 80px;
                background-color: brown;
                margin-top: 20px;
                /* margin-left: 60px; */
                float: left;
            }

            .kop h2 {
                text-align: center;
                margin: 0;
                padding: 0;
            }

            .kop h1 {
                text-align: center;
                margin: 0;
                padding: 0;
            }

            .kop p {
                text-align: center;
                margin: 0;
                padding: 0;
            }

            .bumdes {
                display: inline-block;
                width: 100px;
                height: 600px;
                background-color: brown;
                margin: 0;
            }

            #garis {
                border: 2px solid black;
            }

            #pembayaran {
                font-family: Arial, Helvetica, sans-serif;
                border-collapse: collapse;
                width: 100%;
            }

            #pembayaran td,
            #pembayaran th {
                border: 1px solid #ddd;
                padding: 8px;
            }

            #pembayaran tr:nth-child(even) {
                background-color: #f2f2f2;
            }

            #pembayaran tr:hover {
                background-color: #ddd;
            }

            #pembayaran th {
                padding-top: 12px;
                padding-bottom: 12px;
                text-align: left;
            }

            .ttd table {
                float: right;
            }
        }

        @media screen {
            .kop img {
                width: 80px;
                height: 80px;
                background-color: brown;
                margin-top: 20px;
                /* margin-left: 60px; */
                float: left;
            }

            .kop h2 {
                text-align: center;
                margin: 0;
                padding: 0;
            }

            .kop h1 {
                text-align: center;
                margin: 0;
                padding: 0;
            }

            .kop p {
                text-align: center;
                margin: 0;
                padding: 0;
            }

            .bumdes {
                display: inline-block;
                width: 100px;
                height: 600px;
                background-color: brown;
                margin: 0;
            }

            #garis {
                border: 2px solid black;
            }

            #pembayaran {
                font-family: Arial, Helvetica, sans-serif;
                border-collapse: collapse;
                width: 100%;
            }

            #pembayaran td,
            #pembayaran th {
                border: 1px solid #ddd;
                padding: 8px;
            }

            #pembayaran tr:nth-child(even) {
                background-color: #f2f2f2;
            }

            #pembayaran tr:hover {
                background-color: #ddd;
            }

            #pembayaran th {
                padding-top: 12px;
                padding-bottom: 12px;
                text-align: left;

            }

            .ttd table {
                float: right;
            }
        }
    </style>
</head>

<body>

    <div class="kop">
        <!-- <img src="https://cdnt.orami.co.id/unsafe/cdn-cas.orami.co.id/parenting/images/Kartun-Hero.original.jpegquality-90.jpg" alt=""> -->
        <h2>Badan Usaha Milik Desa (BUMDes) Bumireja</h2>
        <h2>Kecamatan Kedungreja Kabupaten Cilacap</h2>

        <h1><?= $profil['nama'] ?></h1>
        <p><?= $profil['alamat'] ?></p>
    </div>
    <hr id="garis">
    <h3 style="text-align: center;">Persewaan Kios dan Los Pasar</h3>
    </br>
    <div class="pedagang">
        <table>
            <tr>
                <td>Faktur</td>
                <td>:</td>
                <td><strong><?= $sewa['faktur'] ?></strong></td>
            </tr>
            <tr>
                <td>Pedagang</td>
                <td>:</td>
                <td><strong><?= $sewa['pedagang'] ?></strong></td>
            </tr>
            <tr>
                <td>NIK</td>
                <td>:</td>
                <td><strong><?= $sewa['nik'] ?></strong></td>
            </tr>
            <tr>
                <td>Kode Property</td>
                <td>:</td>
                <td><strong><?= $sewa['kode_property'] ?></strong></td>
            </tr>
            <tr>
                <td>Jenis Property</td>
                <td>:</td>
                <td><strong><?= $sewa['jenis_property'] ?></strong></td>
            </tr>
            <tr>
                <td>Jenis Usaha</td>
                <td>:</td>
                <td><strong><?= $sewa['jenis_usaha'] ?></strong></td>
            </tr>
            <tr>
                <td>Tanggal Sewa</td>
                <td>:</td>
                <td><strong><?= date('d-m-Y', strtotime($sewa['tanggal_sewa'])) ?></strong></td>
            </tr>
            <tr>
                <td>Tanggal Selesai</td>
                <td>:</td>
                <td><strong><?= date('d-m-Y', strtotime($sewa['tanggal_batas'])) ?></strong></td>
            </tr>
            <tr>
                <td>Harga</td>
                <td>:</td>
                <td><strong>Rp. <?= number_format($sewa['harga_sewa'], "0", ",", ",") ?></strong></td>
            </tr>
            <tr>
                <td>Terbayar</td>
                <td>:</td>
                <td><strong>Rp. <?= number_format($sewa['total_bayar'], "0", ",", ",") ?></strong></td>
            </tr>
            <tr>
                <?php if ($sewa['harga_sewa'] > ($sewa['total_bayar'] - $sewa['kembali'])) {
                    $kekurangan = $sewa['harga_sewa'] - ($sewa['total_bayar'] - $sewa['kembali']);
                } else {
                    $kekurangan = 0;
                } ?>
                <td>Kekurangan</td>
                <td>:</td>
                <td><strong class="<?= $kekurangan > 0 ? 'text-danger' : '' ?>">Rp. <?= number_format($kekurangan, "0", ",", ",") ?></strong></td>
            </tr>
            <tr>
                <?php if ($sewa['harga_sewa'] > $sewa['total_bayar']) {
                    $kembalian = 0;
                } else {
                    $kembalian = $sewa['total_bayar'] - $sewa['harga_sewa'];
                } ?>
                <td>Kembalian</td>
                <td>:</td>
                <td><strong class="<?= $kembalian > 0 ? 'text-danger' : '' ?>">Rp. <?= number_format($kembalian, "0", ",", ",") ?></strong></td>
            </tr>
            <tr>
                <td>Status</td>
                <td>:</td>
                <?php if ($kekurangan >= 0 && strtotime(date('Y-m-d')) < strtotime($sewa['tanggal_batas'])) : ?>
                    <td><span class="badge badge-outline-success">Aktif</span></td>
                <?php elseif ($kekurangan <= 0 && strtotime(date('Y-m-d')) > strtotime($sewa['tanggal_batas'])) : ?>
                    <td><span class="badge badge-outline-biru">Selesai</span></td>
                <?php elseif ($kekurangan > 0 && strtotime(date('Y-m-d')) > strtotime($sewa['tanggal_batas'])) : ?>
                    <td><span class="badge badge-outline-danger">Terlambat</span></td>
                <?php endif ?>
            </tr>
        </table>
    </div>
    <br>
    <hr>
    <h4>Pembayaran</h4>
    <div class="pembayaran">
        <table class="table table-bordered table-sm" id="pembayaran">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal bayar</th>
                    <th>Metode</th>
                    <th>Petugas</th>
                    <th>Keterangan</th>
                    <th>Bayar (Rp)</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total = 0;
                $no = 1;
                foreach ($history_bayar as $rent) :
                    $total += $rent['bayar'];

                ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= date('d-m-Y H:i', strtotime($rent['tanggal_bayar'])) ?> </td>
                        <td><?= $rent['metode_bayar'] ?></td>
                        <td><?= $rent['username'] ?></td>
                        <td class="" style="text-align: <?= $rent['keterangan'] == '' ? 'center' : 'left' ?>;"><?= $rent['keterangan'] == '' ? '-' : $rent['keterangan'] ?></td>
                        <td style="text-align: right;"><?= number_format($rent['bayar'], "0", ",", ",") ?></td>
                    </tr>
                <?php endforeach ?>
                <tr>
                    <td colspan="5" style="text-align: center;"><strong>Total</strong></td>
                    <td colspan="" style="text-align: right;"><strong><?= number_format($total, 0, ",", ","); ?></strong></td>
                </tr>
            </tbody>
        </table>
    </div>
    <br>
    <br>
    <br>
    <div class="ttd">
        <table>
            <tr>
                <td style="text-align: center;">Bumireja, <?= date_indo('Y-m-d') ?></td>
            </tr>
            <tr>
                <td style="text-align: center;">Petugas BUMDes</td>
            </tr>
            <tr>
                <td style="height: 80px;"></td>
            </tr>
            <tr>
                <td style="text-align: center;"><?= $petugas['nama']; ?></td>
            </tr>
        </table>
    </div>
</body>

</html>