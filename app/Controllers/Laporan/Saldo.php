<?php

namespace App\Controllers\Laporan;

use App\Controllers\BaseController;
use App\Models\ModelProperty;
use App\Models\ModelLaporan;

class Saldo extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Laporan Saldo'
        ];
        return view('laporan/saldo/index', $data);
    }

    public function data()
    {
        $tanggal = date('Y-m-d', strtotime($this->request->getVar('tanggal')));
        $m_laporan = new ModelLaporan();
        $cek = $m_laporan->saldo($tanggal);

        $data = [
            'title' => 'Laporan Saldo',
            'tanggal' => $tanggal,
            'penjualan' => $cek['penjualan']['total'],
            'transaksi_penjualan' => $cek['transaksi_penjualan']['total'],
            'sewa' => $cek['sewa']['total'],
            'transaksi_sewa' => $cek['transaksi_sewa']['total'],
            'pajak_bulanan' => $cek['pajak_bulanan']['total'],
            'transaksi_pajak_bulanan' => $cek['transaksi_pajak_bulanan']['total'],
            'retribusi' => $cek['retribusi']['total'],
            'pembelian' => $cek['pembelian']['total'],
            'transaksi_pembelian' => $cek['transaksi_pembelian']['total'],
            'pengeluaran_umum' => $cek['pengeluaran_umum']['total'],
            'pengeluaran_atk' => $cek['pengeluaran_atk']['total'],
            'pengeluaran_pasar' => $cek['pengeluaran_pasar']['total'],
            'pemasukan_lainnya' => $cek['pemasukan_lainnya']['total'],

        ];
        return view('laporan/saldo/index', $data);
    }
}
