<?php

namespace App\Controllers\Laporan;

use App\Controllers\BaseController;
use App\Models\ModelProperty;
use App\Models\ModelLaporan;

class Retribusi extends BaseController
{

    public function __construct()
    {
        $this->m_laporan = new ModelLaporan();
    }

    public function index()
    {
        $data = [
            'title' => 'Laporan Retribusi Pasar dan Parkir',
            'validation' => \config\Services::validation()
        ];
        return view('laporan/retribusi/index', $data);
    }

    public function data_retribusi()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'start' => $this->request->getVar('mulai'),
                'end' => $this->request->getVar('sampai'),
            ];

            $laporan = $this->m_laporan->retribusi($data);
            $data = [
                'laporan' => $laporan,
                'start' => date('d/m/Y', strtotime($this->request->getVar('mulai'))),
                'end' => date('d/m/Y', strtotime($this->request->getVar('sampai')))
            ];


            $data = [
                'view' => view('laporan/retribusi/data_retribusi', $data)
            ];

            echo json_encode($data);
        }
    }
}
