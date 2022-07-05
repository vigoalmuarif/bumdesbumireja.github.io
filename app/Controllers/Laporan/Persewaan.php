<?php

namespace App\Controllers\Laporan;

use App\Controllers\BaseController;
use App\Models\ModelProperty;
use App\Models\ModelLaporan;

class Persewaan extends BaseController
{

    public function __construct()
    {
        $this->m_laporan = new ModelLaporan();
    }

    public function index()
    {
        $data = [
            'title' => 'Laporan Sewa Kios dan Los Pasar',
            'validation' => \config\Services::validation()
        ];
        return view('laporan/sewa/index', $data);
    }

    public function data_sewa()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'jenis' => $this->request->getVar('jenis'),
                'status' => $this->request->getVar('status'),
            ];

            $laporan = $this->m_laporan->sewa($data);
            $data = [
                'laporan' => $laporan,
                'jenis' => $this->request->getVar('jenis'),
                'type' => $this->request->getVar('status'),

            ];

            $data = [
                'view' => view('laporan/sewa/data_sewa', $data)
            ];

            echo json_encode($data);
        }
    }

    public function pajak_bulanan()
    {
        $data = [
            'title' => 'Laporan Pajak Bulanan',
            'validation' => \config\Services::validation()
        ];
        return view('laporan/pajak_bulanan/index', $data);
    }

    public function data_pajak_bulanan()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'bulan' => $this->request->getVar('bulan'),
                'tahun' => $this->request->getVar('tahun')
            ];

            $laporan = $this->m_laporan->pajak_bulanan($data);

            $data = [
                'laporan' => $laporan,
                'bulan' => $this->request->getVar('bulan'),
                'tahun' => $this->request->getVar('tahun'),

            ];


            $data = [
                'view' => view('laporan/pajak_bulanan/data_pajak_bulanan', $data)
            ];

            echo json_encode($data);
        }
    }
}
