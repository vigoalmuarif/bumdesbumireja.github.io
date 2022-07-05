<?php

namespace App\Controllers\Laporan;

use App\Controllers\BaseController;
use App\Models\ModelProperty;
use App\Models\ModelLaporan;

class Laba extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Laporan Laba'
        ];
        return view('laporan/laba/index', $data);
    }

    public function data()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'start' => $this->request->getVar('mulai'),
                'end' => $this->request->getVar('sampai'),
            ];

            $m_laporan = new ModelLaporan();
            $laba = $m_laporan->laba($data);
            $data = [
                'start' => $this->request->getVar('mulai'),
                'end' => $this->request->getVar('sampai'),
                'penjualan_lunas' => $laba['menerima'],
                'penjualan_belum_lunas' => $laba['piutang'],
                'hpp' => $laba['hpp'],
                'pengeluaran_atk' => $laba['pengeluaran_atk'],
                'pendapatan_atk' => $laba['pendapatan_atk'],
                'uang_sewa_diterima' => $laba['sewa_diterima'],
                'piutang_sewa' => $laba['piutang_sewa'],
                'pajak_bulanan_terbayar' => $laba['pajak_bulanan_terbayar'],
                'pajak_bulanan' => $laba['pajak_bulanan'],
                'retribusi' => $laba['retribusi'],
                'pendapatan_pasar' => $laba['pendapatan_pasar'],
                'pengeluaran_pasar' => $laba['pengeluaran_pasar'],
            ];
            $data = [
                'view' => view('laporan/laba/data', $data)
            ];

            echo json_encode($data);
        }
    }
}
