<?php

namespace App\Controllers;

use App\Models\ModelPedagang;

class Pedagang extends BaseController
{

    public function __construct()
    {
        $this->PedagangModel = new ModelPedagang();
    }

    public function index()
    {
        $data = [
            'title' => 'Pedagang',
            'customer' => $this->PedagangModel->get()
        ];
        return view('master/customer/properti/index', $data);
    }

    public function create()
    {
        if ($this->request->isAJAX()) {
            $aksi['aksi'] = $this->request->getVar('aksi');
            $view = [
                'view' => view('master/customer/properti/create', $aksi)
            ];

            echo json_encode($view);
        }
    }

    public function save()
    {
        if ($this->request->isAJAX()) {
            $validation = \config\Services::validation();
            $validate = $this->validate([
                'nama' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Nama lengkap tidak boleh kosong!'
                    ]
                ],
                'nik' => [
                    'rules' => 'required|is_unique[pedagang.nik]',
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
                        'required' => 'Tanggal lahir tidak boleh kosong!',
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
                ]
            ]);
            if (!$validate) {
                $data = [
                    'error' => [
                        'nama' => $validation->getError('nama'),
                        'nik' => $validation->getError('nik'),
                        'jenis_kelamin' => $validation->getError('jenis_kelamin'),
                        'tempat_lahir' => $validation->getError('tempat_lahir'),
                        'tanggal_lahir' => $validation->getError('altTL'),
                        'tanggal_lahir' => $validation->getError('tanggal_lahir'),
                        'alamat' => $validation->getError('alamat'),
                        'no_hp' => $validation->getError('no_hp'),
                        'jenis_usaha' => $validation->getError('jenis_usaha'),
                    ]
                ];
            } else {

                $data = [
                    'nama' => $this->request->getVar('nama'),
                    'nik' => $this->request->getVar('nik'),
                    'jenis_kelamin' => $this->request->getVar('jenis_kelamin'),
                    'tempat_lahir' => $this->request->getVar('tempat_lahir'),
                    'tanggal_lahir' => $this->request->getVar('altTL'),
                    'alamat' => $this->request->getVar('alamat'),
                    'no_hp' => $this->request->getVar('no_hp'),
                    'jenis_usaha' => $this->request->getVar('jenis_usaha'),
                    'status' => 0,

                ];

                $this->PedagangModel->insert($data);
                $aksi = $this->request->getVar('aksi');
                if ($aksi == 1) {
                    session()->setFlashdata('pesan', '<strong>' . $this->request->getVar('nama') . '</strong>' . ' ' . 'berhasil ditambahkan');
                } else {
                    session()->setFlashdata('pesan', '<strong>' . $this->request->getVar('nama') . '</strong>' . ' ' . 'berhasil ditambahkan, silahkan masukan NIK pedagang untuk transaksi property');
                }
                $data = [
                    'aksi' => $aksi

                ];
            }
            echo json_encode($data);
        }
    }


    public function detail($id)
    {
        $customer_id = $this->PedagangModel->get($id);
        $data = [
            'title' => 'Detail Pedagang',
            'customer' => $customer_id
        ];
        return view('master/customer/properti/detail', $data);
    }

    public function edit($id)
    {
        $validation = \config\Services::validation();
        $customer_id = $this->PedagangModel->get($id);
        $data = [
            'title' => 'Form Ubah Pedagang',
            'customer' => $customer_id,
            'validation' => $validation
        ];
        return view('master/customer/properti/edit', $data);
    }

    public function update($id)
    {
        $cekNik = $this->PedagangModel->get($id);

        if ($cekNik['nik'] == $this->request->getVar('nik')) {
            $rules = 'required';
        } else {
            $rules = 'required|is_unique[pedagang.nik]';
        }
        if (!$this->validate([
            'nama' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama lengkap tidak boleh kosong!'
                ]
            ],
            'nik' => [
                'rules' => $rules,
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
            $customer = $this->PedagangModel->get($id);
            $validation = \config\Services::validation();
            $data = [
                'title' => 'Form Tambah Pedagang',
                'validation' => $validation,
                'customer' => $customer
            ];
            return view('master/customer/properti/edit', $data);
        }
        $data = [
            'nama' => $this->request->getVar('nama'),
            'nik' => $this->request->getVar('nik'),
            'jenis_kelamin' => $this->request->getVar('jenis_kelamin'),
            'tempat_lahir' => $this->request->getVar('tempat_lahir'),
            'tanggal_lahir' => $this->request->getVar('tanggal_lahir'),
            'alamat' => $this->request->getVar('alamat'),
            'no_hp' => $this->request->getVar('no_hp'),
            'jenis_usaha' => $this->request->getVar('jenis_usaha'),
            'status' => $this->request->getVar('status'),
        ];

        $this->PedagangModel->update($id, $data);

        session()->setFlashdata('pesan', 'Data berhasil diubah!');
        return redirect()->to('/Pedagang/index');
    }

    public function delete($id)
    {
        $data = $this->PedagangModel->get($id);
        $this->PedagangModel->delete($data);

        session()->setFlashdata('pesan', 'Data berhasil dihapus!');
        return redirect()->to('/Pedagang/index');
    }
}
