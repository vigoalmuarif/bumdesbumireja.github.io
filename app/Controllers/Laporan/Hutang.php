<?php

namespace App\Controllers\Laporan;

use App\Controllers\BaseController;
use App\Models\ModelProperty;
use App\Models\ModelLaporan;

class Hutang extends BaseController
{

    public function __construct()
    {
        $this->m_laporan = new ModelLaporan();
    }

    public function index()
    {
        $data = [
            'title' => 'Hutang Pembelian ATK',
            'validation' => \config\Services::validation()
        ];
        return view('laporan/hutang/hutang', $data);
    }

    public function data_hutang()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'start' => $this->request->getVar('mulai'),
                'end' => $this->request->getVar('sampai'),
            ];

            $laporan = $this->m_laporan->hutang($data);
            $data = [
                'laporan' => $laporan,
                'start' => date('d/m/Y', strtotime($this->request->getVar('mulai'))),
                'end' => date('d/m/Y', strtotime($this->request->getVar('sampai')))
            ];


            $data = [
                'view' => view('laporan/hutang/data_hutang', $data)
            ];

            echo json_encode($data);
        }
    }
}
