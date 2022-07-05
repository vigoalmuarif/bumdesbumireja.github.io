<?php

namespace App\Controllers\Laporan;

use App\Controllers\BaseController;
use App\Models\ModelProperty;
use App\Models\ModelLaporan;

class In_Out extends BaseController
{

    public function __construct()
    {
        $this->m_laporan = new ModelLaporan();
    }

    public function index()
    {
        $data = [
            'title' => 'Laporan Pemasukan & Pengeluarannya Lainnya',
            'validation' => \config\Services::validation()
        ];
        return view('laporan/keluar_masuk/index', $data);
    }

    public function data()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'start' => $this->request->getVar('mulai'),
                'end' => $this->request->getVar('sampai'),
                'jenis' => $this->request->getVar('jenis'),
                'unit' => $this->request->getVar('unit'),
            ];

            $laporan = $this->m_laporan->in_out($data);

            $jenis = $this->request->getVar('jenis');
            if ($jenis == 'semua') {
                $jenis = 'Pemasukan & Pengeluaran Lainnya';
            } elseif ($jenis == 'in') {
                $jenis = "Pemasukan Lainnya";
            } elseif ($jenis == 'out') {
                $jenis = 'Pengeluaran';
            }
            $data = [
                'laporan' => $laporan,
                'start' => date('d/m/Y', strtotime($this->request->getVar('mulai'))),
                'end' => date('d/m/Y', strtotime($this->request->getVar('sampai'))),
                'jenis' => $jenis,
                'unit' => $this->request->getVar('unit'),
            ];


            $data = [
                'view' => view('laporan/keluar_masuk/data', $data)
            ];

            echo json_encode($data);
        }
    }
}
