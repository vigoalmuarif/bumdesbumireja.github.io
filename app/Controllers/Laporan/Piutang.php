<?php

namespace App\Controllers\Laporan;

use App\Controllers\BaseController;
use App\Models\ModelProperty;
use App\Models\ModelLaporan;

class piutang extends BaseController
{

    public function __construct()
    {
        $this->m_laporan = new ModelLaporan();
    }

    public function index()
    {
        $data = [
            'title' => 'Piutang Penjualan ATK',
            'validation' => \config\Services::validation()
        ];
        return view('laporan/piutang/piutang', $data);
    }

    public function data_piutang()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'start' => $this->request->getVar('mulai'),
                'end' => $this->request->getVar('sampai'),
            ];

            $laporan = $this->m_laporan->piutang($data);
            $data = [
                'laporan' => $laporan,
                'start' => date('d/m/Y', strtotime($this->request->getVar('mulai'))),
                'end' => date('d/m/Y', strtotime($this->request->getVar('sampai')))
            ];


            $data = [
                'view' => view('laporan/piutang/data_piutang', $data)
            ];

            echo json_encode($data);
        }
    }
}
