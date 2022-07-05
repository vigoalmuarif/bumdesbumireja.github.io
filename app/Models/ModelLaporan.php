<?php

namespace App\Models;

use CodeIgniter\Model;

class Modellaporan extends Model
{
    public function penjualan_harian($data)
    {
        $db = $this->db->table('penjualan');
        $db->select('*, penjualan.created_at as date, sum(penjualan_detail.qty) as jml, customer_atk.nama as customer, sum(penjualan_detail.harga)as jual, sum(penjualan_detail.harga_beli) as beli, sum((penjualan_detail.harga - penjualan_detail.harga_beli) * penjualan_detail.qty) as laba, pembayaran, produk.nama as produk');
        $db->join('faktur', 'faktur.id = penjualan.faktur_id');
        $db->join('penjualan_detail', 'penjualan_detail.penjualan_id = penjualan.id');
        $db->join('produk_harga', 'produk_harga.id = penjualan_detail.produk_harga_id');
        $db->join('produk', 'produk.id = produk_harga.produk_id');
        $db->join('customer_atk', 'customer_atk.id = penjualan.customer_id');
        $db->where('date(penjualan.created_at) >=', date('Y-m-d', strtotime($data['start'])));
        $db->where('date(penjualan.created_at) <=', date('Y-m-d', strtotime($data['end'])));
        $db->groupBy('penjualan.id');
        return $db->get()->getResultArray();
    }
    public function penjualan_bulanan($data)
    {
        $db = $this->db->table('penjualan');
        $db->select('*, penjualan.created_at as date, sum(penjualan_detail.qty) as jml, sum(penjualan_detail.harga)as jual, sum(penjualan_detail.harga_beli) as beli, sum((penjualan_detail.harga - penjualan_detail.harga_beli) * penjualan_detail.qty) as laba, sum(sub_total) as total_bayar');
        $db->join('faktur', 'faktur.id = penjualan.faktur_id');
        $db->join('penjualan_detail', 'penjualan_detail.penjualan_id = penjualan.id');
        $db->join('produk_harga', 'produk_harga.id = penjualan_detail.produk_harga_id');
        $db->join('produk', 'produk.id = produk_harga.produk_id');
        $db->where('Month(penjualan.created_at)', $data['bulan']);
        $db->where('Year(penjualan.created_at)', $data['tahun']);
        $db->groupBy('day(penjualan.created_at)');
        return $db->get()->getResultArray();
    }
    public function penjualan_tahunan($data)
    {
        $db = $this->db->table('penjualan');
        $db->select('penjualan.created_at as date, sum(penjualan_detail.qty) as jml, sum(penjualan_detail.harga)as jual, sum(penjualan_detail.harga_beli) as beli, sum((penjualan_detail.harga - penjualan_detail.harga_beli) * penjualan_detail.qty) as laba, sum(sub_total ) as total_bayar');
        $db->join('faktur', 'faktur.id = penjualan.faktur_id', 'left');
        $db->join('penjualan_detail', 'penjualan_detail.penjualan_id = penjualan.id', 'left');
        $db->join('produk_harga', 'produk_harga.id = penjualan_detail.produk_harga_id');
        $db->join('produk', 'produk.id = produk_harga.produk_id');
        $db->groupBy(['MONTH(penjualan.created_at)', 'YEAR(penjualan.created_at)']);
        $db->where('year(penjualan.created_at)', $data['tahun']);
        // $db->groupBy('faktur_id');
        return $a =  $db->get()->getResultArray();
    }

    public function penjualan_produk($data)
    {
        $db = $this->db->table('penjualan');
        $db->select('penjualan.created_at as date, sum(penjualan_detail.qty) as jml, penjualan_detail.harga as jual, sum(penjualan_detail.harga_beli) as beli, sum((penjualan_detail.harga - penjualan_detail.harga_beli) * penjualan_detail.qty) as laba, sum(sub_total) as total_bayar, produk.nama as produk,produk_harga.nama_lain, produk_satuan.nama as satuan, sku, harga');
        $db->join('faktur', 'faktur.id = penjualan.faktur_id', 'right');
        $db->join('penjualan_detail', 'penjualan_detail.penjualan_id = penjualan.id', 'right');
        $db->join('produk_harga', 'produk_harga.id = penjualan_detail.produk_harga_id');
        $db->join('produk', 'produk.id = produk_harga.produk_id');
        $db->join('produk_satuan', 'produk_satuan.id = produk_harga.satuan_id');
        $db->where('date(penjualan.created_at) >=', date('Y-m-d', strtotime($data['start'])));
        $db->where('date(penjualan.created_at) <=', date('Y-m-d', strtotime($data['end'])));
        $db->groupBy(['produk_harga_id', 'day(penjualan.created_at)']);
        $db->orderBy('penjualan.created_at', 'asc');
        return $db->get()->getResultArray();
    }

    public function penjualan_produk_bulanan($data)
    {
        $db = $this->db->table('penjualan');
        $db->select('penjualan.created_at as date, sum(penjualan_detail.qty) as jml, sum(penjualan_detail.harga)as jual, sum(penjualan_detail.harga_beli) as beli, sum((penjualan_detail.harga - penjualan_detail.harga_beli) *penjualan_detail.qty) as laba, sum(sub_total) as total_bayar, produk.nama as produk, produk_satuan.nama as satuan, sku, nama_lain');
        $db->join('penjualan_detail', 'penjualan_detail.penjualan_id = penjualan.id');
        $db->join('produk_harga', 'produk_harga.id = penjualan_detail.produk_harga_id');
        $db->join('produk', 'produk.id = produk_harga.produk_id');
        $db->join('produk_satuan', 'produk_satuan.id = produk_harga.satuan_id');
        $db->where('Month(penjualan.created_at)', $data['bulan']);
        $db->where('Year(penjualan.created_at)', $data['tahun']);
        $db->groupBy(['produk_harga_id', 'month(penjualan.created_at)']);
        return $db->get()->getResultArray();
    }
    public function penjualan_produk_tahunan($data)
    {
        $db = $this->db->table('penjualan');
        $db->select('penjualan.created_at as date, sum(penjualan_detail.qty) as jml, sum(penjualan_detail.harga)as jual, sum(penjualan_detail.harga_beli) as beli, sum((penjualan_detail.harga - penjualan_detail.harga_beli) * penjualan_detail.qty) as laba, sum(sub_total) as total_bayar, produk.nama as produk, produk_satuan.nama as satuan, sku, nama_lain');
        $db->join('penjualan_detail', 'penjualan_detail.penjualan_id = penjualan.id');
        $db->join('produk_harga', 'produk_harga.id = penjualan_detail.produk_harga_id');
        $db->join('produk', 'produk.id = produk_harga.produk_id');
        $db->join('produk_satuan', 'produk_satuan.id = produk_harga.satuan_id');
        $db->where('Year(penjualan.created_at)', $data['tahun']);
        $db->groupBy(['produk_harga_id']);
        return $db->get()->getResultArray();
    }
    public function pembelian($data)
    {
        $db = $this->db->table('pembelian');
        $db->select('*, pembelian.created_at as date, sum(pembelian_detail.qty) as jml, produk_supplier.nama as supplier, sum(pembelian_detail.harga)as jual, pembayaran, produk.nama as produk');
        $db->join('faktur', 'faktur.id = pembelian.faktur_id');
        $db->join('pembelian_detail', 'pembelian_detail.pembelian_id = pembelian.id');
        $db->join('produk_harga', 'produk_harga.id = pembelian_detail.produk_harga_id');
        $db->join('produk', 'produk.id = produk_harga.produk_id');
        $db->join('produk_satuan', 'produk_satuan.id = produk_harga.satuan_id');
        $db->join('produk_supplier', 'produk_supplier.id = pembelian.supplier_id');
        $db->where('date(pembelian.created_at) >=', date('Y-m-d', strtotime($data['start'])));
        $db->where('date(pembelian.created_at) <=', date('Y-m-d', strtotime($data['end'])));
        $db->orderBy('pembelian.created_at');
        $db->groupBy('pembelian.id');
        return $db->get()->getResultArray();
    }
    public function diskon($data)
    {
        $db = $this->db->table('pembelian');
        $db->select('sum(diskon) as diskon');
        $db->where('date(pembelian.created_at) >=', date('Y-m-d', strtotime($data['start'])));
        $db->where('date(pembelian.created_at) <=', date('Y-m-d', strtotime($data['end'])));
        return $db->get()->getRowArray();
    }
    public function produk($data)
    {
        $db = $this->db->table('pembelian');
        $db->select('sum(pembelian_detail.qty) as jml, produk_satuan.nama as satuan, produk.nama as produk, sku, bayar, total, sum(sub_total) subTotal, pembelian_detail.harga as harga_dasar, diskon');
        $db->join('faktur', 'faktur.id = pembelian.faktur_id');
        $db->join('pembelian_detail', 'pembelian_detail.pembelian_id = pembelian.id');
        $db->join('produk_harga', 'produk_harga.id = pembelian_detail.produk_harga_id');
        $db->join('produk', 'produk.id = produk_harga.produk_id');
        $db->join('produk_satuan', 'produk_satuan.id = produk_harga.satuan_id');
        $db->where('date(pembelian.created_at) >=', date('Y-m-d', strtotime($data['start'])));
        $db->where('date(pembelian.created_at) <=', date('Y-m-d', strtotime($data['end'])));
        $db->groupBy('produk.id');
        return $db->get()->getResultArray();
    }

    public function piutang($data)
    {
        $db = $this->db->table('penjualan');
        $db->select('*, penjualan.created_at as date, sum(penjualan_detail.qty) as jml, customer_atk.nama as customer, sum(penjualan_detail.harga)as jual, sum(penjualan_detail.harga_beli) as beli, sum(sub_total) as totalHarga, pembayaran, produk.nama as produk, nama_lain');
        $db->join('faktur', 'faktur.id = penjualan.faktur_id');
        $db->join('penjualan_detail', 'penjualan_detail.penjualan_id = penjualan.id');
        $db->join('produk_harga', 'produk_harga.id = penjualan_detail.produk_harga_id');
        $db->join('produk', 'produk.id = produk_harga.produk_id');
        $db->join('produk_satuan', 'produk_satuan.id = produk_harga.satuan_id');
        $db->join('customer_atk', 'customer_atk.id = penjualan.customer_id');
        $db->where('date(penjualan.created_at) >=', date('Y-m-d', strtotime($data['start'])));
        $db->where('date(penjualan.created_at) <=', date('Y-m-d', strtotime($data['end'])));
        $db->where('bayar < total');
        $db->groupBy('penjualan.id');
        return $db->get()->getResultArray();
    }

    public function hutang($data)
    {
        $db = $this->db->table('pembelian');
        $db->select('*, pembelian.created_at as date, sum(pembelian_detail.qty) as jml, produk_supplier.nama as supplier, produk.nama as produk, sum(sub_total) as totalHarga, bayar');
        $db->join('faktur', 'faktur.id = pembelian.faktur_id');
        $db->join('pembelian_detail', 'pembelian.id = pembelian_detail.pembelian_id');
        $db->join('produk_harga', 'produk_harga.id = pembelian_detail.produk_harga_id');
        $db->join('produk', 'produk.id = produk_harga.produk_id');
        $db->join('produk_satuan', 'produk_satuan.id = produk_harga.satuan_id');
        $db->join('produk_supplier', 'produk_supplier.id = pembelian.supplier_id');
        $db->where('date(pembelian.created_at) >=', date('Y-m-d', strtotime($data['start'])));
        $db->where('date(pembelian.created_at) <=', date('Y-m-d', strtotime($data['end'])));
        $db->where('total > bayar+diskon');
        $db->orderBy('pembelian.created_at');
        $db->groupBy('pembelian.id');
        return $db->get()->getResultArray();
    }

    public function sewa($data)
    {
        $db = $this->db->table('sewa');
        $db->select('sum(transaksi_sewa.bayar) as bayar, sum(kembalian) as kembalian,pedagang.nama as pedagang,jenis_usaha, faktur, property.kode_property, nik, sewa.harga as hargasewa, total_bayar, tanggal_sewa, tanggal_batas, jenis_property');
        $db->join('faktur', 'faktur.id = sewa.no_transaksi');
        $db->join('transaksi_sewa', 'transaksi_sewa.sewa_id = sewa.id');
        $db->join('pedagang', 'pedagang.id = sewa.pedagang_id');
        $db->join('property', 'property.property_id = sewa.property_id');
        $db->groupBy('sewa.id');

        if ($data['jenis'] == "semua") {
            $jenis = ['Kios', 'Los'];
        } else {
            $jenis = [$data['jenis']];
        }
        $db->whereIn('jenis_property', $jenis);
        if ($data['status'] == "sewa_lunas_aktif") {
            $db->where('sewa.harga <= total_bayar');
            $db->where('date(sewa.tanggal_batas) >', date('Y-m-d'));
            return $db->get()->getResultArray();
        } elseif ($data['status'] == "sewa_belum_lunas") {
            $db->where('sewa.harga > total_bayar');
            return $db->get()->getResultArray();
        } elseif ($data['status'] == "sewa_aktif") {
            $db->where('date(sewa.tanggal_batas) >', date('Y-m-d'));
            return $db->get()->getResultArray();
        } elseif ($data['status'] == "sewa_selesai") {
            $db->where('date(sewa.tanggal_batas) <', date('Y-m-d'));
            return $db->get()->getResultArray();
        } elseif ($data['status'] == "semua") {
            return $db->get()->getResultArray();
        }

        return $db->get()->getResultArray();
    }

    public function pajak_bulanan($data)
    {
        $db = $this->db->table('tagihan_bulanan');
        $db->select('*, COALESCE(sum(bayar), 0) as bayar, COALESCE(sum(kembalian), 0) as kembalian, tagihan_bulanan.total_bayar as bayarPajak, pedagang.nama as pedagang');
        $db->join('periode_bulanan', 'periode_bulanan.id = tagihan_bulanan.periode_id', 'left');
        $db->join('transaksi_bulanan', 'transaksi_bulanan.tagihan_id = tagihan_bulanan.id', 'left');
        $db->join('sewa', 'sewa.id = tagihan_bulanan.sewa_id', 'left');
        $db->join('property', 'property.property_id = sewa.property_id', 'left');
        $db->join('pedagang', 'pedagang.id = sewa.pedagang_id', 'left');
        $db->where('month(periode_bulanan.periode)', $data['bulan']);
        $db->where('year(periode_bulanan.periode)', $data['tahun']);
        $db->groupBy('tagihan_bulanan.id');
        return $db->get()->getResultArray();
    }

    public function retribusi($data)
    {
        $db = $this->db->table('pembayaran_retribusi');
        $db->select('*, retribusi.nama as retribusi, pegawai.nama as petugas, pembayaran_retribusi.status as kerja, pembayaran_retribusi.keterangan as desc');
        $db->join('periode_retribusi', 'periode_retribusi.id = pembayaran_retribusi.periode_id', 'left');
        $db->join('pegawai', 'pegawai.id = pembayaran_retribusi.petugas_id', 'left');
        $db->join('retribusi', 'retribusi.id = pembayaran_retribusi.retribusi_id', 'left');
        $db->where('date(periode_retribusi.tanggal) >=', date('Y-m-d', strtotime($data['start'])));
        $db->where('date(periode_retribusi.tanggal) <=', date('Y-m-d', strtotime($data['end'])));
        return $db->get()->getResultArray();
    }

    public function in_out($data)
    {

        if ($data['jenis'] == 'semua') {
            $jenis = ['in', 'out'];
        } else {
            $jenis = [$data['jenis']];
        }

        if ($data['unit'] == 'semua') {
            $unit = ['Umum', 'ATK', 'Pasar'];
        } else {
            $unit = [$data['unit']];
        }


        $db = $this->db->table('arus_uang');
        $db->whereIn('jenis', $jenis);
        $db->whereIn('unit', $unit);
        $db->where('date(created_at) >=', $data['start']);
        $db->where('date(created_at) <=', $data['end']);
        return $db->get()->getResultArray();
    }


    public function laba($data)
    {
        $db = $this->db->table('penjualan');
        $db->select('SUM(transaksi_penjualan.bayar - kembalian) as total');
        $db->join('transaksi_penjualan', 'transaksi_penjualan.penjualan_id = penjualan.id');
        $db->where('date(penjualan.created_at) >=', $data['start']);
        $db->where('date(penjualan.created_at) <=', $data['end']);
        $menerima =  $db->get()->getRowArray();

        $db = $this->db->table('penjualan');
        $db->select('SUM(penjualan.total - penjualan.bayar) as total');
        $db->where('total > penjualan.bayar');
        $db->where('date(penjualan.created_at) >=', $data['start']);
        $db->where('date(penjualan.created_at) <=', $data['end']);
        $piutang =  $db->get()->getRowArray();


        $db = $this->db->table('penjualan');
        $db->select('SUM(harga_beli * qty) as total');
        $db->join('penjualan_detail', 'penjualan_detail.penjualan_id = penjualan.id');
        $db->where('date(penjualan.created_at) >=', $data['start']);
        $db->where('date(penjualan.created_at) <=', $data['end']);
        $hpp =  $db->get()->getRowArray();

        $db = $this->db->table('arus_uang');
        $db->select('SUM(jumlah) as total');
        $db->where('unit', 'Atk');
        $db->where('jenis', 'out');
        $db->where('date(created_at) >=', $data['start']);
        $db->where('date(created_at) <=', $data['end']);
        $pengeluaran_atk =  $db->get()->getRowArray();

        $db = $this->db->table('arus_uang');
        $db->select('SUM(jumlah) as total');
        $db->where('unit', 'Atk');
        $db->where('jenis', 'in');
        $db->where('date(created_at) >=', $data['start']);
        $db->where('date(created_at) <=', $data['end']);
        $pendapatan_atk =  $db->get()->getRowArray();


        // sewa
        $db = $this->db->table('sewa');
        $db->select('SUM(transaksi_sewa.bayar - kembalian) as total');
        $db->join('transaksi_sewa', 'transaksi_sewa.sewa_id = sewa.id');
        $db->where('date(sewa.created_at) >=', $data['start']);
        $db->where('date(sewa.created_at) <=', $data['end']);
        $menerima_uang_sewa =  $db->get()->getRowArray();

        $db = $this->db->table('sewa');
        $db->select('SUM(harga - total_bayar) as total');
        $db->join('transaksi_sewa', 'transaksi_sewa.sewa_id = sewa.id');
        $db->where('harga > total_bayar');
        $db->where('date(sewa.created_at) >=', $data['start']);
        $db->where('date(sewa.created_at) <=', $data['end']);
        $piutang_sewa =  $db->get()->getRowArray();

        $db = $this->db->table('tagihan_bulanan');
        $db->select('SUM(bayar - kembalian) as total_bayar_pajak');
        $db->join('periode_bulanan', 'periode_bulanan.id = tagihan_bulanan.periode_id', 'left');
        $db->join('transaksi_bulanan', 'transaksi_bulanan.tagihan_id = tagihan_bulanan.id', 'left');
        $db->where('date(transaksi_bulanan.created_at) >=', $data['start']);
        $db->where('date(transaksi_bulanan.created_at) <=', $data['end']);
        $pajak_bulanan_terbayar =  $db->get()->getRowArray();

        $db = $this->db->table('tagihan_bulanan');
        $db->select('sum(tarif) as tarif');
        $db->join('periode_bulanan', 'periode_bulanan.id = tagihan_bulanan.periode_id', 'left');
        $db->where('month(periode_bulanan.periode) >=', date('m', strtotime($data['start'])));
        $db->where('year(periode_bulanan.periode) >=', date('Y', strtotime($data['start'])));
        $db->where('year(periode_bulanan.periode) <=', date('Y', strtotime($data['end'])));
        $db->where('month(periode_bulanan.periode) <=', date('m', strtotime($data['end'])));
        $pajak_bulanan =  $db->get()->getRowArray();

        $db = $this->db->table('pembayaran_retribusi');
        $db->select('sum(bayar) as total');
        $db->where('date(created_at) >=', $data['start']);
        $db->where('date(created_at) <=', $data['end']);
        $retribusi =  $db->get()->getRowArray();

        $db = $this->db->table('arus_uang');
        $db->select('SUM(jumlah) as total');
        $db->where('unit', 'Pasar');
        $db->where('jenis', 'in');
        $db->where('date(created_at) >=', $data['start']);
        $db->where('date(created_at) <=', $data['end']);
        $pendapatan_pasar =  $db->get()->getRowArray();

        $db = $this->db->table('arus_uang');
        $db->select('SUM(jumlah) as total');
        $db->where('unit', 'Pasar');
        $db->where('jenis', 'out');
        $db->where('date(created_at) >=', $data['start']);
        $db->where('date(created_at) <=', $data['end']);
        $pengeluaran_pasar =  $db->get()->getRowArray();

        $data = [
            'menerima' => $menerima,
            'piutang' => $piutang,
            'hpp' => $hpp,
            'pengeluaran_atk' => $pengeluaran_atk,
            'pendapatan_atk' => $pendapatan_atk,
            'sewa_diterima' => $menerima_uang_sewa,
            'piutang_sewa' => $piutang_sewa,
            'pajak_bulanan_terbayar' => $pajak_bulanan_terbayar,
            'pajak_bulanan' => $pajak_bulanan,
            'retribusi' => $retribusi,
            'pendapatan_pasar' => $pendapatan_pasar,
            'pengeluaran_pasar' => $pengeluaran_pasar
        ];

        return $data;
    }
    public function saldo($tanggal)
    {
        $db = $this->db->table('penjualan');
        $db->select('SUM(total) as total');
        $db->where('date(penjualan.created_at) <=', $tanggal);
        $penjualan =  $db->get()->getRowArray();

        $db = $this->db->table('penjualan');
        $db->select('sum(transaksi_penjualan.bayar - transaksi_penjualan.kembalian) as total');
        $db->join('transaksi_penjualan', 'transaksi_penjualan.penjualan_id = penjualan.id');
        $db->where('date(transaksi_penjualan.created_at) <=', $tanggal);
        $transaksi_penjualan =  $db->get()->getRowArray();

        $db = $this->db->table('sewa');
        $db->select('SUM(harga) as total');
        $db->where('date(sewa.created_at) <=', $tanggal);
        $sewa =  $db->get()->getRowArray();

        $db = $this->db->table('sewa');
        $db->select('SUM(transaksi_sewa.bayar - kembalian) as total');
        $db->join('transaksi_sewa', 'transaksi_sewa.sewa_id = sewa.id');
        $db->where('date(transaksi_sewa.created_at) <=', $tanggal);
        $transaksi_sewa =  $db->get()->getRowArray();


        $db = $this->db->table('tagihan_bulanan');
        $db->select('sum(tarif) as total');
        $db->join('periode_bulanan', 'periode_bulanan.id = tagihan_bulanan.periode_id', 'left');
        $db->where('month(periode_bulanan.created_at) <=', date('m', strtotime($tanggal)));
        $db->where('year(periode_bulanan.created_at) <=', date('Y', strtotime($tanggal)));
        $pajak_bulanan =  $db->get()->getRowArray();

        $db = $this->db->table('tagihan_bulanan');
        $db->select('sum(bayar-kembalian) as total');
        $db->join('periode_bulanan', 'periode_bulanan.id = tagihan_bulanan.periode_id', 'left');
        $db->join('transaksi_bulanan', 'transaksi_bulanan.tagihan_id = tagihan_bulanan.id', 'left');
        $db->where('date(transaksi_bulanan.created_at) <=', $tanggal);
        $transaksi_pajak_bulanan =  $db->get()->getRowArray();

        $db = $this->db->table('pembelian');
        $db->select('SUM(total-diskon) as total');
        $db->where('date(pembelian.created_at) <=', $tanggal);
        $pembelian =  $db->get()->getRowArray();

        $db = $this->db->table('pembelian');
        $db->select('SUM(transaksi_pembelian.bayar - transaksi_pembelian.kembalian) as total');
        $db->join('transaksi_pembelian', 'transaksi_pembelian.pembelian_id = pembelian.id');
        $db->where('date(pembelian.created_at) <=', $tanggal);
        $transaksi_pembelian =  $db->get()->getRowArray();


        $db = $this->db->table('pembayaran_retribusi');
        $db->select('SUM(bayar) as total');
        $db->where('date(created_at) <=', $tanggal);
        $retribusi =  $db->get()->getRowArray();

        $db = $this->db->table('arus_uang');
        $db->select('SUM(jumlah) as total');
        $db->where('jenis', 'out');
        $db->where('unit', 'umum');
        $db->where('date(created_at) <=', $tanggal);
        $pengeluaran_umum =  $db->get()->getRowArray();

        $db = $this->db->table('arus_uang');
        $db->select('SUM(jumlah) as total');
        $db->where('jenis', 'out');
        $db->where('unit', 'atk');
        $db->where('date(created_at) <=', $tanggal);
        $pengeluaran_atk =  $db->get()->getRowArray();

        $db = $this->db->table('arus_uang');
        $db->select('SUM(jumlah) as total');
        $db->where('jenis', 'out');
        $db->where('unit', 'pasar');
        $db->where('date(created_at) <=', $tanggal);
        $pengeluaran_pasar =  $db->get()->getRowArray();

        $db = $this->db->table('arus_uang');
        $db->select('SUM(jumlah) as total');
        $db->where('jenis', 'in');
        $db->where('date(created_at) <=', $tanggal);
        $pemasukan_lainnya =  $db->get()->getRowArray();

        $data = [
            'penjualan' => $penjualan,
            'transaksi_penjualan' => $transaksi_penjualan,
            'sewa' => $sewa,
            'transaksi_sewa' => $transaksi_sewa,
            'pajak_bulanan' => $pajak_bulanan,
            'transaksi_pajak_bulanan' => $transaksi_pajak_bulanan,
            'pembelian' => $pembelian,
            'transaksi_pembelian' => $transaksi_pembelian,
            'retribusi' => $retribusi,
            'pengeluaran_umum' => $pengeluaran_umum,
            'pengeluaran_atk' => $pengeluaran_atk,
            'pengeluaran_pasar' => $pengeluaran_pasar,
            'pemasukan_lainnya' => $pemasukan_lainnya,
        ];

        return $data;
    }

    public function keuangan($start, $end){
        
        $db = $this->db->table('penjualan');
        $db->select('SUM(total) as total');
        $db->where('date(penjualan.created_at) >=', $start);
        $db->where('date(penjualan.created_at) <=', $end);
        $penjualan =  $db->get()->getRowArray();

        $db = $this->db->table('penjualan');
        $db->select('sum(transaksi_penjualan.bayar - transaksi_penjualan.kembalian) as total');
        $db->join('transaksi_penjualan', 'transaksi_penjualan.penjualan_id = penjualan.id');
        $db->where('date(transaksi_penjualan.created_at) >=', $start);
        $db->where('date(transaksi_penjualan.created_at) <=', $end);
        $transaksi_penjualan =  $db->get()->getRowArray();

        $db = $this->db->table('sewa');
        $db->select('SUM(harga) as total');
        $db->where('date(sewa.created_at) >=', $start);
        $db->where('date(sewa.created_at) <=', $end);
        $sewa =  $db->get()->getRowArray();

        $db = $this->db->table('sewa');
        $db->select('SUM(transaksi_sewa.bayar - kembalian) as total');
        $db->join('transaksi_sewa', 'transaksi_sewa.sewa_id = sewa.id');
        $db->where('date(transaksi_sewa.created_at) >=', $start);
        $db->where('date(transaksi_sewa.created_at) <=', $end);
        $transaksi_sewa =  $db->get()->getRowArray();


        $db = $this->db->table('tagihan_bulanan');
        $db->select('sum(tarif) as total');
        $db->join('periode_bulanan', 'periode_bulanan.id = tagihan_bulanan.periode_id', 'left');
        $db->where('date(periode_bulanan.created_at) >=', date('Y-m-d', strtotime($start)));
        $db->where('date(periode_bulanan.created_at) <=', date('Y-m-d', strtotime($end)));
        $pajak_bulanan =  $db->get()->getRowArray();

        $db = $this->db->table('tagihan_bulanan');
        $db->select('sum(bayar-kembalian) as total');
        $db->join('periode_bulanan', 'periode_bulanan.id = tagihan_bulanan.periode_id', 'left');
        $db->join('transaksi_bulanan', 'transaksi_bulanan.tagihan_id = tagihan_bulanan.id', 'left');
        $db->where('date(transaksi_bulanan.created_at) >=', $start);
        $db->where('date(transaksi_bulanan.created_at) <=', $end);
        $transaksi_pajak_bulanan =  $db->get()->getRowArray();

        $db = $this->db->table('pembelian');
        $db->select('SUM(total-diskon) as total');
        $db->where('date(pembelian.created_at) >=', $start);
        $db->where('date(pembelian.created_at) <=', $end);
        $pembelian =  $db->get()->getRowArray();

        $db = $this->db->table('pembelian');
        $db->select('SUM(transaksi_pembelian.bayar - transaksi_pembelian.kembalian) as total');
        $db->join('transaksi_pembelian', 'transaksi_pembelian.pembelian_id = pembelian.id');
        $db->where('date(pembelian.created_at) >=', $start);
        $db->where('date(pembelian.created_at) <=', $end);
        $transaksi_pembelian =  $db->get()->getRowArray();


        $db = $this->db->table('pembayaran_retribusi');
        $db->select('SUM(bayar) as total');
        $db->where('date(created_at) >=', $start);
        $db->where('date(created_at) <=', $end);
        $retribusi =  $db->get()->getRowArray();

        $db = $this->db->table('arus_uang');
        $db->select('SUM(jumlah) as total');
        $db->where('jenis', 'out');
        $db->where('unit', 'umum');
        $db->where('date(created_at) >=', $start);
        $db->where('date(created_at) <=', $end);
        $pengeluaran_umum =  $db->get()->getRowArray();

        $db = $this->db->table('arus_uang');
        $db->select('SUM(jumlah) as total');
        $db->where('jenis', 'out');
        $db->where('unit', 'atk');
        $db->where('date(created_at) >=', $start);
        $db->where('date(created_at) <=', $end);
        $pengeluaran_atk =  $db->get()->getRowArray();

        $db = $this->db->table('arus_uang');
        $db->select('SUM(jumlah) as total');
        $db->where('jenis', 'out');
        $db->where('unit', 'pasar');
        $db->where('date(created_at) >=', $start);
        $db->where('date(created_at) <=', $end);
        $pengeluaran_pasar =  $db->get()->getRowArray();

        $db = $this->db->table('arus_uang');
        $db->select('SUM(jumlah) as total');
        $db->where('jenis', 'in');
        $db->where('date(created_at) >=', $start);
        $db->where('date(created_at) <=', $end);
        $pemasukan_lainnya =  $db->get()->getRowArray();

        $data = [
            'penjualan' => $penjualan,
            'transaksi_penjualan' => $transaksi_penjualan,
            'sewa' => $sewa,
            'transaksi_sewa' => $transaksi_sewa,
            'pajak_bulanan' => $pajak_bulanan,
            'transaksi_pajak_bulanan' => $transaksi_pajak_bulanan,
            'pembelian' => $pembelian,
            'transaksi_pembelian' => $transaksi_pembelian,
            'retribusi' => $retribusi,
            'pengeluaran_umum' => $pengeluaran_umum,
            'pengeluaran_atk' => $pengeluaran_atk,
            'pengeluaran_pasar' => $pengeluaran_pasar,
            'pemasukan_lainnya' => $pemasukan_lainnya,
        ];

        return $data;
    }
}
