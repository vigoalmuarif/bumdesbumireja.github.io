<?php

namespace App\Controllers;

use App\Models\ModelPeriode;
use App\Models\ModelRetribusi;
use App\Models\ModelSewa;


class Retribusi extends BaseController
{
    public function __construct()
    {
        $this->periodeModel = new ModelPeriode();
        $this->retribusiModel = new ModelRetribusi();
        $this->sewaModel = new ModelSewa();
    }
    public function index()
    {

        $data = [
            'validation' => \config\Services::validation(),
            'title' => 'Setor Retribusi',
            'retribusi' => $this->retribusiModel->setor_retribusi()

        ];
        return view('retribusi/index', $data);
    }
    public function retribusi()
    {
        // $a = $this->retribusiModel->list_retribusi();
        // dd($a);
        $data = [
            'validation' => \config\Services::validation(),
            'title' => 'Retribusi Pasar dan Parkir',

        ];
        return view('master/retribusi/index', $data);
    }

    public function data_retribusi()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'validation' => \config\Services::validation(),
                'title' => 'Retribusi Pasar dan Parkir',
                'retribusi' => $this->retribusiModel->list_retribusi(),

            ];
            $view = [
                'view' => view('master/retribusi/data_retribusi', $data)
            ];
            echo json_encode($view);
        }
    }
    public function create_retribusi()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'validation' => \config\Services::validation(),
            ];
            $view = [
                'view' => view('master/retribusi/add_retribusi', $data)
            ];
            echo json_encode($view);
        }
    }
    public function create_periode()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'validation' => \config\Services::validation(),
            ];
            $view = [
                'view' => view('master/retribusi/create_periode', $data)
            ];
            echo json_encode($view);
        }
    }
    public function save_retribusi()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'nama' => $this->request->getVar('retribusi'),
                'status' => $this->request->getVar('status'),
            ];

            $db = $this->db->table('retribusi');
            $db->insert($data);
            $status = [
                'status' => 'sukses'
            ];

            echo json_encode($status);
        }
    }

    public function edit_retribusi()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');
            $db = $this->db->table('retribusi');
            $retribusi = $db->getWhere(['id' => $id])->getRowArray();
            $data = [
                'validation' => \config\Services::validation(),
                'retribusi' => $retribusi
            ];
            $view = [
                'view' => view('master/retribusi/edit_retribusi', $data)
            ];
            echo json_encode($view);
        }
    }

    public function update_retribusi()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');
            $data = [
                'nama' => $this->request->getVar('retribusi'),
                'status' => $this->request->getVar('status'),
            ];

            $db = $this->db->table('retribusi');
            $db->where('id', $id);
            $db->update($data);
            $status = [
                'status' => 'sukses'
            ];
            echo json_encode($status);
        }
    }


    public function delete_retribusi()
    {
        if ($this->request->isAJAX()) {
            $id =  $this->request->getVar('id');


            $db = $this->db->table('retribusi');
            $db->where('id', $id);
            $db->delete();

            $status = [
                'status' => 'sukses'
            ];
            session()->setFlashdata('pesan', 'Data berhasil dihapus');
            echo json_encode($status);
        }
    }

    public function petugas()
    {
        $data = [
            'validation' => \config\Services::validation(),
            'title' => 'Petugas Retribusi Pasar dan Parkir',
            'employes' => $this->retribusiModel->petugas_retribusi(),

        ];
        return view('master/retribusi/petugas', $data);
    }

    public function create_petugas()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'retribusi' => $this->retribusiModel->list_retribusi()
            ];
            $view = [
                'view' => view('master/retribusi/create_petugas', $data)
            ];
        }

        echo json_encode($view);
    }
    public function cek_nik()
    {
        if ($this->request->isAJAX()) {
            $nik = $this->request->getVar('nik');

            $cek = $this->db->table('pegawai')->where('nik', $nik)->countAllResults();

            $cek2 = $this->db->table('retribusi_group_user');
            $cek2->join('pegawai', 'pegawai.id = retribusi_group_user.pegawai_id', 'left');
            $cek2->where('nik', $nik);
            $petugas = $cek2->countAllResults();


            if ($cek == 0) {
                $data = [
                    'pegawai' => 0
                ];
            } elseif ($petugas == 1) {
                $data = [
                    'pegawai' => 1
                ];
            } else {
                $db = $this->db->table('pegawai');
                $db->select('pegawai.id as pegawaiId, nik, pegawai.nama as pegawai, pegawai_jabatan.nama as jabatan');
                $db->join('pegawai_jabatan', 'pegawai_jabatan.id = pegawai.jabatan_id');
                $db->where('pegawai.nik', $nik);
                $pegawai = $db->get()->getRowArray();

                $data = [
                    'nama' => $pegawai['pegawai'],
                    'jabatan' => $pegawai['jabatan'],
                    'pegawaiID' => $pegawai['pegawaiId']
                ];
            }
        }

        echo json_encode($data);
    }

    public function save_petugas()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'pegawai_id' => $this->request->getVar('pegawaiID'),
                'retribusi_id' => $this->request->getVar('bagian'),
                'status' => 1
            ];

            $db = $this->db->table('retribusi_group_user');
            $db->insert($data);

            $msg = [
                'sukses' => $data
            ];
            session()->setFlashdata('sukses', 'Petugas berhasil ditambahkan!');
            echo json_encode($msg);
        }
    }

    public function edit_petugas()
    {
        if ($this->request->isAJAX()) {
            $id_pegawai = $this->request->getVar('id');

            $retribusi = null;

            $data = [
                'validation' => \config\Services::validation(),
                'petugas' => $this->retribusiModel->petugas_retribusi($retribusi, $id_pegawai),
                'retribusi' => $this->retribusiModel->list_retribusi()
            ];
            $view = [
                'view' => view('master/retribusi/edit_petugas', $data)
            ];
            echo json_encode($view);
        }
    }
    public function update_petugas()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');
            $data = [
                'retribusi_id' => $this->request->getVar('petugas'),
                'status' => $this->request->getVar('status'),
            ];

            $db = $this->db->table('retribusi_group_user');
            $db->where('id', $id);
            $db->update($data);
            $msg = [
                'sukses' => 'sukses'
            ];
            session()->setFlashdata('sukses', 'Petugas berhasil diubah!');
            echo json_encode($msg);
        }
    }

    public function delete_petugas()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');
            $db = $this->db->table('retribusi_group_user');
            $db->where('id', $id);
            $db->delete();
            $data = [
                'sukses' => 'sukses',
            ];
            session()->setFlashdata('sukses', 'Petugas berhasil dihapus!');
            echo json_encode($data);
        }
    }

    public function data_periode()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'validation' => \config\Services::validation(),
                'title' => 'Retribusi Pasar dan Parkir',
                'periode' => $this->retribusiModel->list_periode(),


            ];
            $view = [
                'view' => view('master/retribusi/data_periode', $data)
            ];
            echo json_encode($view);
        }
    }

    public function periodeRetribusi()
    {
        $n = $this->retribusiModel->list_retribusi();
        $db = $this->db->table('retribusi');
        $db->get()->getResultArray();

        $data = [
            'validation' => \config\Services::validation(),
            'title' => 'Periode Retribusi',
            'b' => $n,
            'retribusi' => $this->retribusiModel->list_retribusi()

        ];
        return view('master/retribusi/periode', $data);
    }
    // public function index()
    // {
    //     $data = [
    //         'validation' => \config\Services::validation(),
    //         'title' => 'Retribusi Bulan' . ' ' . bulan_tahun('Y-m-d'),

    //     ];
    //     return view('retribusi/index', $data);
    // }
    public function retribusi_bulan_ini()
    {
        if ($this->request->isAJAX()) {
            $retribusi = $this->retribusiModel->get_periode_bulan_ini();
            $data = [
                'retribusi' => $retribusi,
                'bagian' => $this->retribusiModel->get_petugas_bagian()

            ];
            $view = [
                'view' => view('retribusi/retribusi_bulan_ini', $data)
            ];

            echo json_encode($view);
        }
    }

    public function createPeriodeRetribusi()
    {
        if ($this->request->isAJAX()) {
            $validation = \config\Services::validation();
            $validate = $this->validate([
                'alternatif' => [
                    'rules' => 'is_unique[periode_retribusi.tanggal]',
                    'errors' => [
                        'is_unique' => 'Periode sudah dibuat'
                    ]
                ],
                'tanggal' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Tanggal retribusi tidak boleh kosong!'
                    ]
                ],
            ]);

            if (!$validate) {
                $msg = [
                    'error' => [
                        'alternatif' => $validation->getError('alternatif'),
                        'tanggal' => $validation->getError('tanggal')
                    ]
                ];
            } else {

                $data = [
                    'tanggal' => $this->request->getVar('alternatif')
                ];

                $db = $this->db->table('retribusi');
                $count = $db->countAll();

                if ($count == 0) {
                    $msg = [
                        'msg' => 'Belum ada data retribusi'
                    ];
                } else {

                    $this->retribusiModel->save_tagihan_retribusi($data);
                    $msg = [
                        'status' => 'sukses'
                    ];
                }
            }
            echo json_encode($msg);
        }
    }


    public function detail_periode($id)
    {

        $data = [
            'validation' => \config\Services::validation(),
            'title' => 'Detail Periode Retribusi',
            'detail' => $this->retribusiModel->detail_periode($id),
            'periode' => $this->retribusiModel->get_periode($id)

        ];
        return view('master/retribusi/detail_periode', $data);
    }
    public function hapus_pembayaran_by_id()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');
            $db = $this->db->table('pembayaran_retribusi');
            $db->where('id', $id);
            $db->delete();
            $data = [
                'periode' => $this->retribusiModel->get_periode($id),
                'flashdata' => 'flashdata'
            ];
            session()->setFlashdata('sukses', 'Data berhasil dihapus');
            echo json_encode($data);
        }
    }
    public function edit_pembayaran_by_id()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');
            $retribusi = $this->request->getVar('retribusi');

            $id_pegawai = null;

            $data = [
                'pembayaran' => $this->retribusiModel->pembayaran_by_id($id),
                'petugas' => $this->retribusiModel->petugas_retribusi($retribusi, $id_pegawai),
                'title' => $this->request->getVar('title'),
                'aksi' => $this->request->getVar('aksi'),
                'pesan' => $this->request->getVar('pesan')
            ];

            $view = [
                'view' => view('master/retribusi/edit_pembayaran_by_id', $data),
            ];
            echo json_encode($view);
        }
    }
    public function update_pembayaran_by_id()
    {
        if ($this->request->isAJAX()) {

            $data = [
                'id' => $this->request->getVar('id'),
                'pegawai_id' => $this->request->getVar('pegawai'),
                'bayar' => str_replace(',', '', $this->request->getVar('bayar')),
                'status' => $this->request->getVar('status'),
                'keterangan' => $this->request->getVar('keterangan')
            ];
            $this->retribusiModel->update_pembayaran($data);



            $status = [
                'status' => 'sukses'
            ];
            $flashdata = $this->request->getVar('pesan');
            if ($flashdata == 1) {
                $pesan = 'Data berhasil diubah';
            } else {
                $pesan = 'Setoran berhasil diproses';
            }
            session()->setFlashdata('sukses', $pesan);
            echo json_encode($status);
        }
    }


    public function edit_periode()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');
            $db = $this->db->table('periode_retribusi');
            $periode = $db->getWhere(['id' => $id])->getRowArray();
            $data = [
                'validation' => \config\Services::validation(),
                'periode' => $periode
            ];
            $view = [
                'view' => view('master/retribusi/edit_periode', $data)
            ];
            echo json_encode($view);
        }
    }


    public function update_periode()
    {
        if ($this->request->isAJAX()) {
            $periode_old = strtotime($this->request->getVar('periodeOld'));
            $periode_new = strtotime($this->request->getVar('alternatifEdit'));

            if ($periode_old == $periode_new) {
                $rules = 'required';
            } else {
                $rules = 'required|is_unique[periode_retribusi.tanggal]';
            }
            $validation = \config\Services::validation();
            $validate = $this->validate([
                'alternatifEdit' => [
                    'rules' => $rules,
                    'errors' => [
                        'required' => 'Periode tidak boleh kosong',
                        'is_unique' => 'Periode ' . $this->request->getVar('periode') . ' sudah dibuat sebelumnya'
                    ]
                ],
                'periode' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Tanggal retribusi tidak boleh kosong!'
                    ]
                ],
            ]);

            if (!$validate) {
                $msg = [
                    'error' => [
                        'alternatifEdit' => $validation->getError('alternatifEdit'),
                        'periode' => $validation->getError('periode')
                    ]
                ];
            } else {

                if ($periode_old == $periode_new) {
                    $msg = [
                        'sama' => 'sama'
                    ];
                } else {

                    $data = [
                        'id' => $this->request->getVar('periodeId'),
                        'tanggal' => $this->request->getVar('alternatifEdit')
                    ];


                    $this->retribusiModel->update_periode($data);
                    $msg = [
                        'status' => 'sukses'
                    ];
                }
            }
            echo json_encode($msg);
        }
    }


    public function delete_periode()
    {
        if ($this->request->isAJAX()) {
            $id =  $this->request->getVar('id');

            $this->retribusiModel->delete_periode($id);

            $status = [
                'status' => 'sukses'
            ];
            session()->setFlashdata('sukses', 'Data berhasil dihapus');
            echo json_encode($status);
        }
    }
}
