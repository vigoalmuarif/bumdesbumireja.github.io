<?php

namespace App\Controllers;

use App\Models\ModelPeriode;
use App\Models\ModelSewa;
use phpDocumentor\Reflection\PseudoTypes\False_;

class Periode extends BaseController
{

    public function __construct()
    {
        $this->periodeModel = new ModelPeriode();
        $this->sewaModel = new ModelSewa();
    }
    public function tagihanBulanan()
    {
        $data = [
            'validation' => \config\Services::validation(),
            'title' => 'Periode Tagihan Bulanan',
            'bulanan' => $this->periodeModel->get()

        ];
        return view('master/periode/bulanan', $data);
    }

    public function createPeriodeBulanan()
    {
        if (!$this->validate([
            'bulan' => [
                'rules' => 'required|is_unique[periode.periode]',
                'errors' => [
                    'required' => 'Bulan harus di isi.',
                    'is_unique' => 'sudah ada'
                ]
            ],
            'tahun' => [
                'rules' => 'required|is_unique[periode.periode]',
                'errors' => [
                    'required' => 'Tahun harus di isi.',
                    'is_unique' => 'sudah ada'
                ]
            ],
            'tarif' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tarif harus di isi.'
                ]
            ],
            'jenis' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Jenis harus di isi.'
                ]
            ]
        ])) {

            return redirect()->to('/persewaan/tagihanBulanan')->withInput();
        }
        if ($this->request->getVar('jenis') == 'Los') {
            $jenis = ['Los'];
        } elseif ($this->request->getVar('jenis') == 'Kios') {
            $jenis = ['Kios'];
        } elseif ($this->request->getVar('jenis') == 'Semua') {
            $jenis = ['Kios', 'Los'];
        }

        $bulan = $this->request->getVar('bulan');
        $tahun = $this->request->getVar('tahun');
        $date = date('Y-m-d', strtotime($tahun . '-' . $bulan  . '-' . '01'));

        $db = \config\Database::connect();
        $query = $db->table('periode');
        $periode = $query->getwhere(['periode' => $date, 'jenis' => $this->request->getVar('jenis')])->getRowArray();

        $hasil = $this->periodeModel->cariSewaByPeriode($date, $jenis);

        if ($periode !== null) {
            session()->setFlashdata('pesan', ' <div class="alert alert-warning alert-dismissible fade show text-center" role="alert">
            Periode ' . bulan_tahun(date('Y-m-d', strtotime($date))) . ' untuk jenis ' . $this->request->getVar('jenis') . ' sudah pernah ditambahkan sebelumnya.
             <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                 <span aria-hidden="true">&times;</span>
             </button>
         </div>');
            return redirect()->to('/periode/tagihanBulanan')->withInput();
        } elseif ($hasil == null) {
            session()->setFlashdata('pesan', ' <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
           Tidak ada data dalam periode ' . bulan_tahun(date('Y-m-d', strtotime($date))) . ' untuk jenis ' . $this->request->getVar('jenis') . ', periode tersebut gagal ditambahkan.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>');
            return redirect()->to('/periode/tagihanBulanan')->withInput();
        } else {
            $data = [
                'periode' => $date,
                'tarif' => $this->request->getVar('tarif'),
                'jenis' => $this->request->getVar('jenis'),
            ];

            $this->periodeModel->insertPeriodeBulanan($data, $hasil);

            session()->setFlashdata('pesan', ' <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
            Periode ' . bulan_tahun(date('Y-m-d', strtotime($date))) . ' berhasil ditambahkan.
             <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                 <span aria-hidden="true">&times;</span>
             </button>
         </div>');
            return redirect()->to('/sewa/tagihanBulanan');
        }
    }

    public function listTagihan($id)
    {
        $validation = \config\Services::validation();
        $list = $this->periodeModel->getTagihanBulanan($id)->getResultArray();
        $periode = $this->periodeModel->getTagihanBulanan($id)->getRowArray();
        $data = [
            'title' => 'Tagihan Bulanan',
            'validation' => $validation,
            'bulanan' => $list,
            'periode' => $periode

        ];

        return view('sewa/bulanan/tagihan_bulanan', $data);
    }

    public function retribusi()
    {
        $data = [
            'validation' => \config\Services::validation(),
            'title' => 'Periode Tagihan Bulanan',
            'retribusi' => $this->periodeModel->periodeRetribusi()

        ];
        return view('retribusi/index', $data);
    }

    public function createPeriodeRetribusi()
    {
        if (!$this->validate([
            'alternatif' => [
                'rules' => 'is_unique[periode_retribusi.tanggal]',
                'errors' => [
                    'is_unique' => 'Periode ' . $this->request->getVar('tanggal') . ' sudah dibuat sebelumnya'
                ]
            ],
            'tanggal' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tanggal retribusi tidak boleh kosong!'
                ]
            ],
        ])) {

            return redirect()->to('retribusi')->withInput();
        }

        $data = [
            'tanggal' => $this->request->getVar('alternatif')
        ];
        $db = \config\Database::connect();
        $builder = $db->table('retribusi');
        $retribusi = $builder->get();
        if ($retribusi->getRowArray() == null) {
            session()->setFlashdata('error', 'Data Retribusi Masih Kosong');
            return redirect()->to('retribusi')->withInput();
        }
        $this->periodeModel->insertPeriodeRetribusi($data);
        $id = $this->periodeModel->insertId();

        foreach ($retribusi->getResultArray() as $retri) {
            $a[] = [
                'retribusi_id' => $retri['id'],
                'periode_id' => $id,
                'user_id' => user_id()
            ];
        }

        $this->periodeModel->insertRetribusi($a);

        session()->setFlashdata('pesan', 'Data berhasil ditambahkan');
        return redirect()->to('retribusi');
    }


    public function listRetribusi($id)
    {
        $validation = \config\Services::validation();
        $list = $this->periodeModel->getRetribusi($id)->getResultArray();
        $periode = $this->periodeModel->getRetribusi($id)->getRowArray();

        $data = [
            'title' => 'Tagihan Bulanan',
            'validation' => $validation,
            'retribusi' => $list,
            'periode' => $periode

        ];
        return view('retribusi/detail', $data);
    }
}
