<?php

namespace App\Controllers;

use App\Models\ModelSewa;
use App\Models\ModelProperty;
use App\Models\ModelPedagang;
use App\Models\ModelPembayaran;
use App\Models\ModelPeriode;
use App\Models\ModelPetugas;

class Pembayaran extends BaseController
{
    public function __construct()
    {
        $this->sewaModel = new ModelSewa();
        $this->propertyModel = new ModelProperty();
        $this->pedagangModel = new ModelPedagang();
        $this->pembayaranModel = new ModelPembayaran();
        $this->periodeModel = new ModelPeriode();
        $this->petugasModel = new ModelPetugas();
    }
    public function sewa($id)
    {
        $validation =  \Config\Services::validation();
        $byId = $this->sewaModel->getById($id);

        $data = [
            'title' => 'Bayar Property',
            'get' => $byId,
            'validation' => $validation

        ];
        return view('sewa/bayar', $data);
    }

    public function prosesPembayaranSewa($id)
    {
        if (!$this->validate([
            'bayar' => [
                'rules' => 'required|numeric|integer',
                'errors' => [
                    'required' => 'Harap masukan jumlah pembayaran',
                    'numeric' => 'Harap masukan angka yang valid',
                    'integer' => 'angka tidak boleh mengandung titik',
                ]
            ],
            'metode' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Metode pembayaran harus diisi'
                ]
            ],
        ])) {

            $byId = $this->sewaModel->getById($id);
            $validation =  \Config\Services::validation();

            $data = [
                'validation' => $validation,
                'title' => 'Bayar Property',
                'get' => $byId,
            ];
            return view('/sewa/bayar', $data);
        }

        $kekurangan = $this->request->getVar('kekurangan');
        if ($kekurangan <= 0) {
            session()->setFlashdata('error', 'Pembayaran ' . $this->request->getVar('invoice') . ' gagal karena sudah lunas');
            return redirect()->to('/sewa/detail/' . $id)->withInput();
        } elseif ($this->request->getVar('bayar') > $this->request->getVar('harga')) {
            session()->setFlashdata('error', 'pembayaran lebih besar daripada harga sewa');
            return redirect()->to('/sewa/detail/' . $id)->withInput();
        } elseif ($this->request->getVar('bayar') > $kekurangan) {
            session()->setFlashdata('error', 'pembayaran lebih besar daripada kekurangan');
            return redirect()->to('/sewa/detail/' . $id)->withInput();
        }
        if ($this->request->getVar('bayar') == $kekurangan) {
            $tanggungan = 0;
        } else {
            $tanggungan = 1;
        }
        $data = [
            'sewa_id' => $this->request->getVar('sewa_id'),
            'user_id' => user()->id,
            'metode' => $this->request->getVar('metode'),
            'bayar' => $this->request->getVar('bayar'),
            'keterangan' => $this->request->getVar('keterangan'),
            'tanggungan' => $tanggungan,
            'pedagang' => $this->request->getVar('pedagang'),
            'created_at' => date('Y-m-d H:i:s')
        ];
        $this->pembayaranModel->savePembayaranSewa($data);
        session()->setFlashdata('pesan', 'Pembayaran ' . $this->request->getVar('invoice') . ' berhasil');
        return redirect()->to('/sewa/detail/' . $id);
    }

    public function bayarTagihanBulanan($id)
    {
        $getPedagang = $this->periodeModel->getTagihanBulananById($id);
        $validation = \config\Services::validation();
        $data = [
            'title' => 'Bayar Tagihan Bulanan',
            'validation' => $validation,
            'get' => $getPedagang,
        ];
        return view('sewa/bulanan/bayar', $data);
    }

    public function prosesBayarTagihanBulanan($id)
    {
        $bayar = $this->request->getVar('bayar');
        $tarif = $this->request->getVar('tarif');
        $metode = $this->request->getVar('metode');
        $keterangan = $this->request->getVar('keterangan');
        $periode_id = $this->request->getVar('periode_id');
        if (!$this->validate([
            'bayar' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Masukan jumlah yang akan dibayarkan'
                ]
            ],
            'metode' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Pilih metode pembayaran'
                ]
            ],
        ])) {
            $getPedagang = $this->periodeModel->getTagihanBulananById($id);
            $validation = \config\Services::validation();
            $data = [
                'title' => 'Bayar Tagihan Bulanan',
                'validation' => $validation,
                'get' => $getPedagang,
            ];

            return view('sewa/bulanan/bayar', $data);
        }
        if ($bayar !== $tarif) {
            $getPedagang = $this->periodeModel->getTagihanBulananById($id);
            $validation = \config\Services::validation();
            $data = [
                'title' => 'Bayar Tagihan Bulanan',
                'validation' => $validation,
                'get' => $getPedagang,
            ];
            session()->setFlashdata('pesan2', 'Transaksi gagal, harap bayar sesuai tarif');
            return view('sewa/bulanan/bayar', $data);
        } else {
            $data = [
                'user_id' => user_id(),
                'bayar' => $bayar,
                'metode' => $metode,
                'status' => 1,
                'keterangan' => $keterangan,
                'created_at' => date('Y-m-d H:i:s')
            ];

            $this->pembayaranModel->tagihanBulanan($id, $data);
            session()->setFlashdata('sukses', 'Transaksi berhasil!');
            $validation = \config\Services::validation();
            $list = $this->periodeModel->getTagihanBulanan($periode_id)->getResultArray();
            $periode = $this->periodeModel->getTagihanBulanan($periode_id)->getRowArray();
            $data = [
                'title' => 'Tagihan Bulanan',
                'validation' => $validation,
                'bulanan' => $list,
                'periode' => $periode

            ];
            return view('sewa/bulanan/tagihan_bulanan', $data);
        }
    }


    public function bayarRetribusi($id)
    {
        $petugas = $this->petugasModel->getPetugasByRetribusi($id);
        $validation = \config\Services::validation();
        $data = [
            'title' => 'Bayar Tagihan Bulanan',
            'validation' => $validation,
            'get' => $petugas,
        ];
        return view('sewa/bulanan/bayar', $data);
    }
}
