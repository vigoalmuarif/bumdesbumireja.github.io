<?php

namespace App\Controllers\Laporan;

use App\Controllers\BaseController;
use App\Models\ModelProperty;
use App\Models\ModelLaporan;

class Pembelian extends BaseController
{

    public function __construct()
    {
        $this->m_laporan = new ModelLaporan();
    }


    public function index()
    {
        $data = [
            'title' => 'Laporan Pembelian',
            'validation' => \config\Services::validation(),
            'link' => 'laporan/pembelian'
        ];
        return view('laporan/pembelian/pembelian', $data);
    }
    public function data_pembelian()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'start' => $this->request->getVar('mulai'),
                'end' => $this->request->getVar('sampai'),
            ];

            $laporan = $this->m_laporan->pembelian($data);
            $data = [
                'laporan' => $laporan,
                'start' => date('d/m/Y', strtotime($this->request->getVar('mulai'))),
                'end' => date('d/m/Y', strtotime($this->request->getVar('sampai')))
            ];


            $data = [
                'view' => view('laporan/pembelian/data_pembelian', $data)
            ];

            echo json_encode($data);
        }
    }


    public function produk()
    {
        $data = [
            'title' => 'Pembelian Per Produk',
            'validation' => \config\Services::validation()
        ];
        return view('laporan/pembelian/per_produk', $data);
    }

    public function data_produk()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'start' => $this->request->getVar('mulai'),
                'end' => $this->request->getVar('sampai'),
            ];
            $laporan = $this->m_laporan->produk($data);
            $diskon = $this->m_laporan->diskon($data);

            $data = [
                'laporan' => $laporan,
                'start' => date('d/m/Y', strtotime($this->request->getVar('mulai'))),
                'end' => date('d/m/Y', strtotime($this->request->getVar('sampai'))),
                'diskon' => $diskon
            ];


            $data = [
                'view' => view('laporan/pembelian/data_per_produk', $data)
            ];

            echo json_encode($data);
        }
    }
}
