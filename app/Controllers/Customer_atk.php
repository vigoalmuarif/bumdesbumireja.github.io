<?php

namespace App\Controllers;

use App\Models\ModelCustomerAtk;

class customer_atk extends BaseController
{
    public function __construct()
    {
        $this->m_customer_atk = new ModelCustomerAtk();
    }
    public function index()
    {
        $data = [
            'title' => 'Daftar Customer ATK',
        ];
        return view('master/customer/atk/index', $data);
    }
    public function data_pelanggan()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'customer' => $this->m_customer_atk->get_customer()
            ];
            $view = [
                'view' => view('master/customer/atk/data', $data)
            ];

            echo json_encode($view);
        }
    }

    public function edit()
    {
        if ($this->request->isAJAX()) {
            $cust_id = $this->request->getVar('id');
            $db = $this->db->table('customer_atk');
            $customer['customer'] = $db->getWhere(['id' => $cust_id])->getRowArray();
            $data = [
                'view' => view('master/customer/atk/edit', $customer)
            ];

            echo json_encode($data);
        }
    }

    public function update($id)
    {
        if ($this->request->isAJAX()) {
            $validation = \config\Services::validation();
            $valid = $this->validate([

                'nama' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Nama harus diisi.'
                    ]
                ],
                'no_hp' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Nomor telepon harus diisi.'
                    ]
                ],
                'gender' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Gender harus diisi.'
                    ]
                ],
                'alamat' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Alamat harus diisi.'
                    ]
                ]


            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nama' => $validation->getError('nama'),
                        'gender' => $validation->getError('gender'),
                        'no_hp' => $validation->getError('no_hp'),
                        'alamat' => $validation->getError('alamat')

                    ]
                ];
            } else {
                $data = [
                    'nama' => $this->request->getVar('nama'),
                    'jk' => $this->request->getVar('gender'),
                    'no_hp' => $this->request->getVar('no_hp'),
                    'alamat' => $this->request->getVar('alamat')
                ];

                $db = $this->db->table('customer_atk');
                $db->where('id', $id);
                $db->update($data);

                $msg = ['sukses' => 'sukses'];
                session()->setFlashdata('pesan', 'Data berhasil diubah!');
            }
            echo json_encode($msg);
        }
    }

    public function create()
    {
        if ($this->request->isAJAX()) {

            $aksi['aksi'] = $this->request->getVar('aksi');
            $data = [
                'view' => view('master/customer/atk/create', $aksi)
            ];

            echo json_encode($data);
        }
    }

    public function save()
    {
        if ($this->request->isAJAX()) {
            $validation = \config\Services::validation();
            $valid = $this->validate([

                'nama' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Nama harus diisi.'
                    ]
                ],
                'no_hp' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Nomor telepon harus diisi.'
                    ]
                ],
                'gender' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Gender harus diisi.'
                    ]
                ],
                'alamat' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Alamat harus diisi.'
                    ]
                ]


            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nama' => $validation->getError('nama'),
                        'gender' => $validation->getError('gender'),
                        'no_hp' => $validation->getError('no_hp'),
                        'alamat' => $validation->getError('alamat')

                    ]
                ];
            } else {
                $data = [
                    'nama' => $this->request->getVar('nama'),
                    'jk' => $this->request->getVar('gender'),
                    'no_hp' => $this->request->getVar('no_hp'),
                    'alamat' => $this->request->getVar('alamat')
                ];

                $db = $this->db->table('customer_atk');
                $db->insert($data);

                $msg = ['sukses' => 'sukses'];
            }
            echo json_encode($msg);
        }
    }

    public function delete()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');

            $db = $this->db->table('customer_atk');
            $db->where('id', $id);
            $db->delete();

            $data = [
                'delete' => 'sukses'
            ];
            echo json_encode($data);
        }
    }
}
