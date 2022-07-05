<?php

namespace App\Controllers;

use App\Models\ModelOperasional;
use App\Models\ModelSewa;

class Operasional extends BaseController
{
    public function __construct()
    {
        $this->m_operasional = new ModelOperasional();
    }

    public function saldo()
    {
        $data = [
            'title' => 'Saldo'
        ];

        return view('operasional/saldo', $data);
    }
    public function arus_uang()
    {
        $a = $this->m_operasional->total_penjualan();
        $b = $this->m_operasional->total_sewa();
        $c = $this->m_operasional->total_tagihan_bulanan();
        $d = $this->m_operasional->total_setoran_retribusi();
        $e = $a['bayar'] + $b['total_bayar'] + $c['total_setor'] + $d['total_setor'];
        $data = [
            'title' => 'Arus Uang',
            'validation' => \config\Services::validation()

        ];
        return view('operasional/arus_uang', $data);
    }

    public function pengeluaran($id = null)
    {

        $data = [
            'title' => $id . ' ' . 'pengeluaran',
            'masuk' => $this->m_operasional->pengeluaran($id),

        ];
        return view('operasional/pengeluaran', $data);
    }

    public function create_pengeluaran()
    {
        if ($this->request->isAJAX()) {
            $view = [
                'view' => view('operasional/create_pengeluaran')
            ];
            echo json_encode($view);
        }
    }

    public function insert_pengeluaran()
    {

        if (!$this->validate([
            'alternatif' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tanggal harus diisi'
                ]
            ],
            'tanggal' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tanggal harus diisi'
                ]
            ],
            'jumlah' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Jumlah pengeluaran harus diisi'
                ]
            ],
            'jenis' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Jenis pengeluaran belum dipilih'
                ]
            ],
        ])) {

            return redirect()->to('/operasional/pengeluaran')->withInput();
        } else {

            $data = [
                'created_at' => $this->request->getVar('alternatif') . ' ' . date('H:i:s'),
                'jumlah' => str_replace(',', '', $this->request->getVar('jumlah')),
                'unit' => $this->request->getVar('jenis'),
                'jenis' => 'Keluar',
                'user_id' => user_id(),
                'keterangan' => $this->request->getVar('keterangan')
            ];

            $this->m_operasional->sirkulasi($data);
            session()->setFlashdata('pesan', 'Data berhasil ditambahkan');
            return redirect()->to('/operasional/pengeluaran');
        }
    }

    public function pemasukan($id = null)
    {
        $data = [
            'title' => 'Pemasukan' . ' ' . $id,
            'masuk' => $this->m_operasional->pemasukan($id),

        ];
        return view('operasional/pemasukan', $data);
    }

    public function create_pemasukan()
    {
        if ($this->request->isAJAX()) {
            $view = [
                'view' => view('operasional/create_pemasukan')
            ];
            echo json_encode($view);
        }
    }

    public function save()
    {
        if ($this->request->isAJAX()) {
            $validation = \config\Services::validation();
            $validate = $this->validate([
                'tanggal' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Tanggal  harus diisi'
                    ]
                ],
                'jumlah' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Jumlah pemasukan harus diisi'
                    ]
                ],
                'jenis' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'jenis harus diisi'
                    ]
                ]
            ]);

            if (!$validate) {
                $data = [
                    'error' => [
                        'tanggal' => $validation->getError('tanggal'),
                        'jumlah' => $validation->getError('jumlah'),
                        'jenis' => $validation->getError('jenis'),
                    ]
                ];
            } else {
                $data = [
                    'date' => $this->request->getVar('alternatif') . ' ' . date('H:i:s'),
                    'jumlah' => str_replace(',', '', $this->request->getVar('jumlah')),
                    'unit' => $this->request->getVar('jenis'),
                    'jenis' => $this->request->getVar('type'),
                    'user_id' => user_id(),
                    'keterangan' => $this->request->getVar('keterangan'),
                    'created_at' => date('Y-m-d H:i:s')
                ];

                $this->m_operasional->add_pemasukan($data);
                session()->setFlashdata('sukses', 'Berhasil ditambahkan');
            }
            echo json_encode($data);
        }
    }

    public function edit_pengeluaran()
    {
        if ($this->request->isAJAX()) {
            $id =  $this->request->getVar('id');
            $db = $this->db->table('arus_uang');
            $db->where('id', $id);
            $pengeluaran = $db->get()->getRowArray();

            $data = [
                'pengeluaran' => $pengeluaran
            ];

            $view = [
                'view' => view('operasional/edit_pengeluaran', $data)
            ];
            echo json_encode($view);
        }
    }

    public function update_pengeluaran()
    {
        if ($this->request->isAJAX()) {
            $validation = \config\Services::validation();
            $validate = $this->validate([
                'tanggal' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Tanggal  harus diisi'
                    ]
                ],
                'jumlah' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Jumlah pemasukan harus diisi'
                    ]
                ],
                'jenis' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'jenis harus diisi'
                    ]
                ]
            ]);

            if (!$validate) {
                $data = [
                    'error' => [
                        'tanggal' => $validation->getError('tanggal'),
                        'jumlah' => $validation->getError('jumlah'),
                        'jenis' => $validation->getError('jenis'),
                    ]
                ];
            } else {
                $id = $this->request->getVar('id');
                $data = [
                    'date' => $this->request->getVar('alternatif') . ' ' . date('H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'jumlah' => str_replace(',', '', $this->request->getVar('jumlah')),
                    'unit' => $this->request->getVar('jenis'),
                    'jenis' => 'out',
                    'user_id' => user_id(),
                    'keterangan' => $this->request->getVar('keterangan')
                ];

                $this->m_operasional->update_arus_uang($id, $data);
                session()->setFlashdata('sukses', 'Data berhasil diubah');
            }
            echo json_encode($data);
        }
    }

    public function delete_pemasukan()
    {
        if ($this->request->isAJAX()) {
            $id =  $this->request->getVar('id');

            $db = $this->db->table('arus_uang');
            $db->where('id', $id);
            $db->delete();
            session()->setFlashdata('sukses', 'Data berhasil dihapus');
            $data = [
                'sukses' => 'sukses'
            ];

            echo json_encode($data);
        }
    }

    public function delete_pengeluaran()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');

            $db = $this->db->table('arus_uang');
            $db->where('id', $id);
            $db->delete();

            session()->setFlashdata('sukses', 'Data berhasil dihapus');

            $data = [
                'sukses' => 'sukses'
            ];

            echo json_encode($data);
        }
    }

    public function edit_pemasukan()
    {
        if ($this->request->isAJAX()) {
            $id =  $this->request->getVar('id');
            $db = $this->db->table('arus_uang');
            $db->where('id', $id);
            $pemasukan = $db->get()->getRowArray();

            $data = [
                'pemasukan' => $pemasukan
            ];

            $view = [
                'view' => view('operasional/edit_pemasukan', $data)
            ];
            echo json_encode($view);
        }
    }

    public function update_pemasukan()
    {
        if ($this->request->isAJAX()) {
            $validation = \config\Services::validation();
            $validate = $this->validate([
                'tanggal' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Tanggal  harus diisi'
                    ]
                ],
                'jumlah' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Jumlah pemasukan harus diisi'
                    ]
                ],
                'jenis' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'jenis harus diisi'
                    ]
                ]
            ]);

            if (!$validate) {
                $data = [
                    'error' => [
                        'tanggal' => $validation->getError('tanggal'),
                        'jumlah' => $validation->getError('jumlah'),
                        'jenis' => $validation->getError('jenis'),
                    ]
                ];
            } else {
                $id = $this->request->getVar('id');
                $data = [
                    'date' => $this->request->getVar('alternatif') . ' ' . date('H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'jumlah' => str_replace(',', '', $this->request->getVar('jumlah')),
                    'unit' => $this->request->getVar('jenis'),
                    'jenis' => 'in',
                    'user_id' => user_id(),
                    'keterangan' => $this->request->getVar('keterangan')
                ];

                $this->m_operasional->update_arus_uang($id, $data);
                session()->setFlashdata('sukses', 'Data berhasil diubah');
            }
            echo json_encode($data);
        }
    }
}
