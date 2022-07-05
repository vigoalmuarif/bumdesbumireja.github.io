<?php

namespace App\Controllers\Laporan;

use App\Controllers\BaseController;
use App\Models\ModelProperty;
use App\Models\ModelLaporan;

class Penjualan extends BaseController
{

    public function __construct()
    {
        $this->m_laporan = new ModelLaporan();
    }

    public function harian()
    {
        $data = [
            'title' => 'Ringkasan Penjualan Harian',
            'validation' => \config\Services::validation()
        ];
        return view('laporan/penjualan/penjualan_harian', $data);
    }

    public function data_harian()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'start' => $this->request->getVar('mulai'),
                'end' => $this->request->getVar('sampai'),
            ];

            $laporan = $this->m_laporan->penjualan_harian($data);
            $data = [
                'laporan' => $laporan,
                'start' => date('d/m/Y', strtotime($this->request->getVar('mulai'))),
                'end' => date('d/m/Y', strtotime($this->request->getVar('sampai')))
            ];


            $data = [
                'view' => view('laporan/penjualan/data_penjualan_harian', $data)
            ];

            echo json_encode($data);
        }
    }

    public function periode()
    {
        if ($this->request->isAJAX()) {
            $aksi = $this->request->getVar('aksi');
            if ($aksi == 'ringkasan_penjualan') {
                $data = [
                    'harian' => "laporan/penjualan/harian",
                    'bulanan' => "laporan/penjualan/bulanan",
                    'tahunan' => "laporan/penjualan/tahunan",
                    'title' => 'Ringkasan Penjualan'

                ];
            } elseif ($aksi == 'penjualan_per_produk') {
                $data = [
                    'harian' => "laporan/penjualan_produk/harian",
                    'bulanan' => "laporan/penjualan_produk/bulanan",
                    'tahunan' => "laporan/penjualan_produk/tahunan",
                    'title' => 'Penjualan per produk'
                ];
            }


            $view = [
                'view' => view('laporan/penjualan/periode', $data)
            ];

            echo json_encode($view);
        }
    }

    public function bulanan()
    {
        $data = [
            'title' => 'Ringkasan Penjualan Bulanan',
            'validation' => \config\Services::validation()
        ];
        return view('laporan/penjualan/penjualan_bulanan', $data);
    }

    public function data_bulanan()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'bulan' => $this->request->getVar('bulan'),
                'tahun' => $this->request->getVar('tahun'),
            ];

            $laporan = $this->m_laporan->penjualan_bulanan($data);
            $data = [
                'laporan' => $laporan,
                'bulan' => bulan_tahun($this->request->getVar('tahun') . '-' . $this->request->getVar('bulan') . '-01')
            ];


            $data = [
                'view' => view('laporan/penjualan/data_penjualan_bulanan', $data)
            ];

            echo json_encode($data);
        }
    }

    public function tahunan()
    {
        $data = [
            'title' => 'Ringkasan Penjualan tahunan',
            'validation' => \config\Services::validation()
        ];
        return view('laporan/penjualan/penjualan_tahunan', $data);
    }

    public function data_tahunan()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'tahun' => $this->request->getVar('tahun'),
            ];

            $laporan = $this->m_laporan->penjualan_tahunan($data);
            $data = [
                'laporan' => $laporan,
                'tahun' => $this->request->getVar('tahun')
            ];

            $data = [
                'view' => view('laporan/penjualan/data_penjualan_tahunan', $data)
            ];

            echo json_encode($data);
        }
    }

    public function produk_harian()
    {
        $data = [
            'title' => 'Penjualan per produk',
            'validation' => \config\Services::validation()
        ];
        return view('laporan/penjualan/penjualan_per_produk', $data);
    }

    public function data_produk_harian()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'start' => $this->request->getVar('mulai'),
                'end' => $this->request->getVar('sampai'),
            ];
            $laporan = $this->m_laporan->penjualan_produk($data);

            $data = [
                'laporan' => $laporan,
                'start' => date('d/m/Y', strtotime($this->request->getVar('mulai'))),
                'end' => date('d/m/Y', strtotime($this->request->getVar('sampai')))
            ];


            $data = [
                'view' => view('laporan/penjualan/data_produk_harian', $data)
            ];

            echo json_encode($data);
        }
    }

    public function produk_bulanan()
    {
        $data = [
            'title' => 'Penjualan Per Produk Bulanan',
            'validation' => \config\Services::validation()
        ];
        return view('laporan/penjualan/penjualan_per_produk_bulanan', $data);
    }

    public function data_produk_bulanan()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'bulan' => $this->request->getVar('bulan'),
                'tahun' => $this->request->getVar('tahun'),
            ];

            $laporan = $this->m_laporan->penjualan_produk_bulanan($data);

            $data = [
                'laporan' => $laporan,
                'bulan' => bulan_tahun($this->request->getVar('tahun') . '-' . $this->request->getVar('bulan') . '-01')
            ];


            $data = [
                'view' => view('laporan/penjualan/data_produk_bulanan', $data)
            ];

            echo json_encode($data);
        }
    }
    public function produk_tahunan()
    {
        $data = [
            'title' => 'Penjualan Per Produk Tahunan',
            'validation' => \config\Services::validation()
        ];
        return view('laporan/penjualan/penjualan_per_produk_tahunan', $data);
    }

    public function data_produk_tahunan()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'tahun' => $this->request->getVar('tahun'),
            ];

            $laporan = $this->m_laporan->penjualan_produk_tahunan($data);

            $data = [
                'laporan' => $laporan,
                'tahun' => $this->request->getVar('tahun')
            ];


            $data = [
                'view' => view('laporan/penjualan/data_produk_tahunan', $data)
            ];

            echo json_encode($data);
        }
    }
}
