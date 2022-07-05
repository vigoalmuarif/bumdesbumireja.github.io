<?php

namespace App\Controllers;

use App\Models\ModelSewa;
use App\Models\ModelProperty;
use App\Models\ModelPedagang;
use App\Models\ModelBayarProperty;

class Sewa extends BaseController
{

    public function __construct()
    {
        $this->sewaModel = new ModelSewa();
        $this->propertyModel = new ModelProperty();
        $this->pedagangModel = new ModelPedagang();
        $this->bayarModel = new ModelBayarProperty();
    }

    public function dashboard()
    {
        $m_sewa = new ModelSewa();
        $m_sewa->cek_sewa();
        $m_sewa->cek_expire_pedagang();


        $data = [
            'title' => 'Home',

        ];
        return view('home/index_sewa', $data);
    }

    public function index()
    {
        // $this->sewaModel->cekSewaExpired();
        $sewa = $this->sewaModel->getSewa();
        $data = [
            'title' => 'Sewa Property',
            'sewa' => $sewa,
        ];
        return view('sewa/index', $data);
    }


    public function createPedagang()
    {
        $validation = \config\Services::validation();
        $data = [
            'title' => 'Form Tambah Pedagang',
            'validation' => $validation
        ];
        return view('sewa/createPedagang', $data);
    }


    public function savePedagang()
    {
        if (!$this->validate([
            'nama' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama lengkap tidak boleh kosong!'
                ]
            ],
            'nik' => [
                'rules' => 'required|is_unique[property_customer.nik]',
                'errors' => [
                    'required' => 'NIK tidak boleh kosong!',
                    'is_unique' => 'NIK sudah terdaftar'
                ]
            ],
            'jenis_kelamin' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Jenis kelamin tidak boleh kosong!',
                ]
            ],
            'tempat_lahir' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tempat lahir tidak boleh kosong!',
                ]
            ],
            'tanggal_lahir' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tanggallahir tidak boleh kosong!',
                ]
            ],
            'alamat' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Alamat tidak boleh kosong!',
                ]
            ],
            'no_hp' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'No telepon tidak boleh kosong!',
                ]
            ],
            'jenis_usaha' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Jenis usaha tidak boleh kosong!',
                ]
            ],
        ])) {
            $validation = \config\Services::validation();
            $data = [
                'title' => 'Form Tambah Pedagang',
                'validation' => $validation
            ];

            return view('sewa/createPedagang', $data);
        }
        $data = [
            'nama' => $this->request->getVar('nama'),
            'nik' => $this->request->getVar('nik'),
            'jenis_kelamin' => $this->request->getVar('jenis_kelamin'),
            'tempat_lahir' => $this->request->getVar('tempat_lahir'),
            'tanggal_lahir' => $this->request->getVar('tanggal_lahir'),
            'alamat' => $this->request->getVar('alamat'),
            'no_hp' => $this->request->getVar('no_hp'),
            'jenis_usaha' => $this->request->getVar('jenis_usaha')
        ];

        $this->PedagangModel->insert($data);
        session()->setFlashdata('pesan', 'Data berhasil ditambahkan!');
        return redirect()->to('/sewa/create');
    }

    public function create()
    {

        $property = $this->propertyModel->tersedia();
        $Pedagang = $this->pedagangModel->get();
        $kode = $this->sewaModel->kode();
        $sewa = $this->sewaModel->get();
        $validation =  \Config\Services::validation();
        $data = [
            'title' => 'Form Sewa Property',
            'sewa' => $sewa,
            'property' => $property,
            'penyewa' => $Pedagang,
            'invoice' => $kode,
            'validation' => $validation
        ];
        return view('sewa/create', $data);
    }

    public function save()
    {
        if (!$this->validate(
            [
                'input-nama' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Nama Pedagang harus diisi!'
                    ]
                ],
                'input-kode' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Kode property tidak boleh kosong!'
                    ]
                ],
                'tanggal_sewa' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Tanggal sewa tidak boleh kosong!'
                    ]
                ],
                'tanggal_selesai' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Tanggal selesai tidak boleh kosong!'
                    ]
                ],
                'uang_muka' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Uang muka tidak boleh kosong!'
                    ]
                ],
                'metode' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Jenis pembayaran belum dipilih!'
                    ]
                ],
            ]
        )) {
            $validation =  \Config\Services::validation();
            $property = $this->propertyModel->tersedia();
            $Pedagang = $this->pedagangModel->get();
            $kode = $this->sewaModel->kode();
            $data = [
                'title' => 'Form Sewa Property',
                'validation' => $validation,
                'invoice' => $kode,
                'property' => $property,
                'penyewa' => $Pedagang
            ];
            return view('sewa/create', $data);
        }

        $sewa = [
            'user_id' =>  user()->id,
            'no_transaksi' => $this->request->getVar('invoice'),
            'pedagang_id' => $this->request->getVar('pedagang_id'),
            'property_id' => $this->request->getVar('property_id'),
            'harga_property' => $this->request->getVar('harga'),
            'tanggal_sewa' => date("Y-m-d", strtotime($this->request->getVar('tanggal_sewa'))),
            'tanggal_batas' => date("Y-m-d", strtotime($this->request->getVar('tanggal_selesai'))),
            'user_id' => user()->id,
            'metode' => $this->request->getVar('metode'),
            'bayar' => $this->request->getVar('uang_muka'),
            'keterangan' => 'Uang Muka',
            'created_at' => date('Y-m-d H:i:s'),

        ];
        $this->sewaModel->sewa($sewa);

        session()->setFlashdata('pesan', 'Data berhasil ditambahkan!');
        return  redirect()->to('/sewa');
    }

    public function detail($id)
    {
        $byId = $this->sewaModel->getById($id);
        $pembayaran_sewa = $this->sewaModel->pembayaranSewa($id);

        $data = [
            'title' => 'Detail Sewa',
            'get' => $byId,
            'log' => $pembayaran_sewa

        ];
        return view('sewa/detail', $data);
    }

    public function bulanan()
    {
        $date = $this->sewaModel->date();
        $data = [
            'title' => 'Biaya bulanan',
            'date' => $date
        ];
        return view('sewa/bulanan/index', $data);
    }


    public function sewaSelesai()
    {
        $data = [
            'sewa_id' => $this->request->getVar('sewa_id'),
            'pedagang_id' => $this->request->getVar('pedagang_id'),
            'property_id' => $this->request->getVar('property_id')
        ];

        $this->sewaModel->sewaSelesai($data);
        return redirect()->to('detail/' . $data['sewa_id'])->withInput();
    }
}
