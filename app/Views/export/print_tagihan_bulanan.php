<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
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
            background-color: #04AA6D;
            color: white;
        }

        .ttd table {
            float: right;
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
    <h3 style="text-align: center;">Pembayaran Rutin Bulanan Persewaan</h3>
    </br>
    <div class="pedagang">
        <table>
            <tr>
                <td>Periode</td>
                <td>:</td>
                <td><strong><?= bulan_tahun($periode) ?></strong></td>
            </tr>
            <tr>
                <td>property</td>
                <td>:</td>
                <td><strong><?= $property ?></strong></td>
            </tr>
            <tr>
                <td>Pedagang</td>
                <td>:</td>
                <td><strong><?= $pedagang ?></strong></td>
            </tr>
            <tr>
                <td>NIK</td>
                <td>:</td>
                <td><strong><?= $nik ?></strong></td>
            </tr>
            <tr>
                <td>Tarif</td>
                <td>:</td>
                <td><strong>Rp <?= number_format($tarif, 0, ",", ",") ?></strong></td>
            </tr>
            <tr>
                <td>Bayar</td>
                <td>:</td>
                <td><strong>Rp <?= number_format($bayar, 0, ",", ",") ?></strong></td>
            </tr>
            <tr>
                <?php
                $kekurangan = $tarif - $bayar;
                $kembalian = $bayar - $tarif
                ?>
                <td>Kekurangan</td>
                <td>:</td>
                <td><strong>Rp <?= $kekurangan > 0 ? number_format($kekurangan, 0, ',', ',') : '0' ?></strong></td>
            </tr>
            <tr>
                <td>kembalian</td>
                <td>:</td>
                <td><strong>Rp <?= $kembalian > 0 ? number_format($kembalian, 0, ',', ',') : '0' ?></strong></td>
            </tr>

            <tr>
                <td>Status</td>
                <td>:</td>
                <?php if ($tarif > $bayar) : ?>
                    <td><span class="badge badge-outline-success">Belum Lunas</span></td>
                <?php elseif ($tarif <= $bayar) : ?>
                    <td><span class="badge badge-outline-biru">Lunas</span></td>
                <?php endif ?>
            </tr>
        </table>
    </div>
    <br>
    <hr>
    <h4>Pembayaran</h4>
    <div class="pembayaran">
        <table class="table" id="pembayaran">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Metode</th>
                    <th>Keterangan</th>
                    <th>Bayar (Rp)</th>
                </tr>
            </thead>
            <tbody>
                <?php

                $no = 1;
                $total = 0;
                foreach ($history as $row) :
                    $total += $row['bayar'];
                ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= date('d-m-Y H:i', strtotime($row['tanggal_bayar'])); ?></td>
                        <td><?= $row['metode']; ?></td>
                        <td><?= $row['keterangan'] ?></td>
                        <td><?= number_format($row['bayar'], 0, ",", ","); ?></td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td class="text-right" colspan="4"><strong>Total (Rp)</strong></td>
                    <td colspan="2"><strong><?= number_format($total, 0, ",", ","); ?></strong></td>
                </tr>


            </tbody>
        </table>
    </div>
    <br><br><br><br><br><br><br><br><br><br>
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