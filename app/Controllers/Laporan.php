<?php

namespace App\Controllers;

use App\Models\ModelProperty;
use App\Models\ModelSewa;

class Laporan extends BaseController
{
    public function penjualan()
    {
        $data = [
            'title' => 'Laporan',

        ];
        return view('laporan/index', $data);
    }

    public function penjualan_harian($id)
    {

        if ($this->request->isAJAX()) {
            $a = $this->request->getVar('mulai');
            $data = [
                'view' => view('laporan/penjualan_harian')
            ];

            echo json_encode($data);
        }
    }

    public function periode()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'title' => $this->request->getVar('report')
            ];

            $view = [
                'view' => view('laporan/periode', $data)
            ];

            echo json_encode($view);
        }
    }

    public function form_periode()
    {
        $data = [
            'title' => 'Periode Penjualan Harian',
            'validation' => \config\Services::validation()
        ];
        return view('laporan/form_periode', $data);
    }

    public function sewa()
    {
        $data = [
            'title' => 'Laporan sewa',
        ];
    }
}
