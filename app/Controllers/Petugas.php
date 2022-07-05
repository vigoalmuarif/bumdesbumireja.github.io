<?php

namespace App\Controllers;

use App\Models\ModelPetugas;

class Petugas extends BaseController
{

    public function __construct()
    {
        $this->petugasModel = new ModelPetugas();
    }

    public function index()
    {
        $data = [
            'title' => 'Petugas BUMDes',
            'petugas' => $this->petugasModel->get()
        ];
        return view('master/petugas/index', $data);
    }


    public function create()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'petugas' => $this->petugasModel->get(),
                'jabatan' => $this->petugasModel->getJabatan(),
                'validation' =>  \config\Services::validation(),
            ];
            $view = [
                'view' => view('master/petugas/create', $data)
            ];

            echo json_encode($view);
        }
    }

    public function save()
    {
        if ($this->request->isAJAX()) {

            $validation = \config\Services::validation();
            $validate = $this->validate([
                'nik' => [
                    'rules' => 'required|numeric|is_unique[pegawai.nik]',
                    'errors' => [
                        'required' => 'NIK harus diisi',
                        'numeric' => 'NIK harus menggunakan angka',
                        'is_unique' => 'NIK sudah terdaftar sebelumnya'
                    ]
                ],
                'nama' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'NIK harus diisi',
                        'unique' => 'NIK sudah terdaftar sebelumnya'
                    ]
                ],
                'jenis_kelamin' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Jenis kelamin harus diisi',
                    ]
                ],
                'tempat_lahir' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Tempat lahir harus diisi',
                    ]
                ],
                'tanggal_lahir' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Tanggal lahir harus diisi',
                    ]
                ],
                'alamat' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Alamat harus diisi',
                    ]
                ],
                'no_hp' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Nomer HP harus diisi',
                    ]
                ],
                'jabatan' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Jabatan harus diisi',
                    ]
                ],

            ]);

            if (!$validate) {
                $msg = [
                    'error' => [
                        'nik' => $validation->getError('nik'),
                        'nama' => $validation->getError('nama'),
                        'jenis_kelamin' => $validation->getError('jenis_kelamin'),
                        'tempat_lahir' => $validation->getError('tempat_lahir'),
                        'tanggal_lahir' => $validation->getError('tanggal_lahir'),
                        'alamat' => $validation->getError('alamat'),
                        'no_hp' => $validation->getError('no_hp'),
                        'jabatan' => $validation->getError('jabatan'),
                    ]
                ];
            } else {
                $data = [
                    'nik' => $this->request->getVar('nik'),
                    'nama' => $this->request->getVar('nama'),
                    'jenis_kelamin' => $this->request->getVar('jenis_kelamin'),
                    'tempat_lahir' => $this->request->getVar('tempat_lahir'),
                    'tanggal_lahir' => $this->request->getVar('altTL'),
                    'alamat' => $this->request->getVar('alamat'),
                    'no_hp' => $this->request->getVar('no_hp'),
                    'jabatan_id' => $this->request->getVar('jabatan'),
                    'status' => 1,
                ];

                $this->petugasModel->insert($data);

                session()->setFlashdata('sukses', 'Petugas berhasil ditambahkan');
                $msg = [
                    'sukses' => 'sukses'
                ];
                // return redirect()->to('/petugas/index');
            }
            echo json_encode($msg);
        }
    }

    public function detail($id)
    {
        $data = [
            'title' => 'Detail Petugas',
            'pegawai' => $this->petugasModel->get($id)
        ];
        return view('master/petugas/detail', $data);
    }

    public function edit()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');
            $data = [
                'pegawai' => $this->petugasModel->get($id),
                'jabatan' => $this->petugasModel->getJabatan()
            ];

            $view = [
                'view' => view('master/petugas/edit', $data)
            ];

            echo json_encode($view);
        }
    }

    public function update()
    {
        if ($this->request->isAJAX()) {
            $new_nik = $this->request->getVar('nik');
            $old_nik = $this->request->getVar('old_nik');

            if ($new_nik == $old_nik) {
                $rules = 'required';
            } else {
                $rules = 'required|numeric|is_unique[pegawai.nik]';
            }

            $validation = \config\Services::validation();
            $validate = $this->validate([
                'nik' => [
                    'rules' => $rules,
                    'errors' => [
                        'required' => 'NIK harus diisi',
                        'numeric' => 'NIK harus menggunakan angka',
                        'is_unique' => 'NIK sudah terdaftar sebelumnya'
                    ]
                ],
                'nama' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'NIK harus diisi',
                        'unique' => 'NIK sudah terdaftar sebelumnya'
                    ]
                ],
                'jenis_kelamin' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Jenis kelamin harus diisi',
                    ]
                ],
                'tempat_lahir' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Tempat lahir harus diisi',
                    ]
                ],
                'tanggal_lahir' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Tanggal lahir harus diisi',
                    ]
                ],
                'alamat' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Alamat harus diisi',
                    ]
                ],
                'no_hp' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Nomer HP harus diisi',
                    ]
                ],
                'jabatan' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Jabatan harus diisi',
                    ]
                ],

            ]);

            if (!$validate) {
                $msg = [
                    'error' => [
                        'nik' => $validation->getError('nik'),
                        'nama' => $validation->getError('nama'),
                        'jenis_kelamin' => $validation->getError('jenis_kelamin'),
                        'tempat_lahir' => $validation->getError('tempat_lahir'),
                        'tanggal_lahir' => $validation->getError('tanggal_lahir'),
                        'alamat' => $validation->getError('alamat'),
                        'no_hp' => $validation->getError('no_hp'),
                        'jabatan' => $validation->getError('jabatan'),
                    ]
                ];
            } else {
                $data = [
                    'id' => $this->request->getVar('id'),
                    'nik' => $this->request->getVar('nik'),
                    'nama' => $this->request->getVar('nama'),
                    'jenis_kelamin' => $this->request->getVar('jenis_kelamin'),
                    'tempat_lahir' => $this->request->getVar('tempat_lahir'),
                    'tanggal_lahir' => $this->request->getVar('altTL'),
                    'alamat' => $this->request->getVar('alamat'),
                    'no_hp' => $this->request->getVar('no_hp'),
                    'jabatan_id' => $this->request->getVar('jabatan'),
                    'status' => $this->request->getVar('status'),
                ];
                $this->petugasModel->save($data);

                if ($data['status'] == 0) {
                    $db = $this->db->table('retribusi_group_user');
                    $db->where('pegawai_id', $data['id']);
                    $db->update(['status' => 0]);
                }

                session()->setFlashdata('sukses', 'Petugas berhasil diubah');
                $msg = [
                    'sukses' => 'sukses'
                ];
                // return redirect()->to('/petugas/index');
            }
            echo json_encode($msg);
        }
    }

    public function delete()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');

            $db = $this->db->table('pegawai');
            $db->where('id', $id);
            $db->delete();
            session()->setFlashdata('sukses', 'Petugas berhasil dihapus!');
            $msg = [
                'sukses' => 'sukses'
            ];
            echo json_encode($msg);
        }
    }

    public function jabatan()
    {
        $data = [
            'title' => 'Jabatan BUMDes',
            'jabatan' => $this->petugasModel->getJabatan()
        ];
        return view('master/petugas/jabatan/index', $data);
    }

    public function create_jabatan()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'validation' =>  \config\Services::validation(),
            ];
            $view = [
                'view' => view('master/petugas/jabatan/create', $data)
            ];

            echo json_encode($view);
        }
    }

    public function save_jabatan()
    {
        if ($this->request->isAJAX()) {

            $data = [
                'nama' => $this->request->getVar('nama'),
                'keterangan' => $this->request->getVar('desc')
            ];

            $db = $this->db->table('pegawai_jabatan');
            $db->insert($data);

            $msg = [
                'sukses' => 'sukses'
            ];
            session()->setFlashdata('sukses', 'Jabatan berhasil ditambahkan');

            echo json_encode($msg);
        }
    }

    public function edit_jabatan()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');
            $data = [
                'jabatan' =>  $this->petugasModel->getJabatan($id)
            ];
            $view = [
                'view' => view('master/petugas/jabatan/edit', $data)
            ];

            echo json_encode($view);
        }
    }
    public function update_jabatan()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');
            $data = [
                'nama' =>  $this->request->getVar('nama'),
                'keterangan' =>  $this->request->getVar('desc')
            ];
            $this->petugasModel->editJabatan($id, $data);
            $msg = [
                'sukses' => 'sukses'
            ];
            session()->setFlashdata('sukses', 'Jabatan berhasil diubah!');

            echo json_encode($msg);
        }
    }

    public function delete_jabatan()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');
            $db = $this->db->table('pegawai_jabatan');
            $db->where('id', $id);
            $db->delete();

            $msg = [
                'sukses' => 'sukses'
            ];
            session()->setFlashdata('sukses', 'Jabatan berhasil dihapus!');

            echo json_encode($msg);
        }
    }
}
