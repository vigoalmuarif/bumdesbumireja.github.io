<?php

namespace App\Controllers;

use App\Models\ModelPeriode;
use App\Models\ModelSewa;
use phpDocumentor\Reflection\PseudoTypes\False_;

class Persewaan extends BaseController
{
    public function __construct()
    {
        $this->m_sewa = new ModelSewa();
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
        $data = [
            'title' => 'Daftar Sewa',
            'sewa' => $this->m_sewa->getSewa()
        ];

        return view('sewa/index', $data);
    }

    public function sewa_aktif()
    {
        $data = [
            'title' => 'Daftar Sewa Aktif',
            'sewa' => $this->m_sewa->sewa_aktif()
        ];
        return view('sewa/index', $data);
    }

    public function sewa_belum_lunas()
    {
        $data = [
            'title' => 'Daftar Sewa Belum Lunas',
            'sewa' => $this->m_sewa->sewa_belum_lunas()
        ];

        return view('sewa/index', $data);
    }
    public function sewa_selesai()
    {
        $data = [
            'title' => 'Daftar Sewa Selesai',
            'sewa' => $this->m_sewa->sewa_selesai()
        ];

        return view('sewa/index', $data);
    }

    public function pedagang()
    {
        $db = $this->db->table('users');
        $user = $db->getWhere(['id' => user_id()])->getRowArray();
        $data = [
            'title' => 'Transaksi Sewa & Tagihan',
            'user' => $user,
        ];

        return view('sewa/create', $data);
    }

    public function cari_pedagang()
    {
        if ($this->request->isAJAX()) {

            $nik = $this->request->getVar('nik');

            $db = $this->db->table('pedagang');
            $db->where('nik', $nik);
            $pedagang = $db->get();
            $penyewa = $pedagang->getNumrows();
            $tenant = $pedagang->getRowArray();


            if ($penyewa > 0) {
                $pedagang_id = [
                    'pedagang_id' => $tenant['id']
                ];
                $this->session->set($pedagang_id);
                unset(
                    $_SESSION['id'],
                    $_SESSION['kode'],
                    $_SESSION['jangka'],
                    $_SESSION['jenis'],
                    $_SESSION['harga'],
                    $_SESSION['fasilitas']
                );
                $data = [
                    'pedagang' => $tenant,
                ];
                $view = [
                    'view' => view('sewa/pedagang', $data)
                ];
            } else {
                $view = [
                    'status' => 'Pedagang tidak ditemukan!'
                ];
            }

            echo json_encode($view);
        }
    }

    public function berlangsung()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');


            $db = $this->db->table('sewa');
            $db->select('faktur, sewa.id as id_sewa, kode_property, no_transaksi, tanggal_sewa, tanggal_batas, SUM(transaksi_sewa.bayar) as total_bayar, sewa.harga as harga_sewa');
            $db->join('faktur', 'sewa.no_transaksi = faktur.id');
            $db->join('transaksi_sewa', 'transaksi_sewa.sewa_id = sewa.id', 'left');
            $db->join('property', 'property.property_id = sewa.property_id');
            $db->where('pedagang_id', $id);
            $db->groupBy('sewa.id');
            $pedagang = $db->get();
            $count_sewa = $pedagang->getNumrows();
            $sewa = $pedagang->getResultArray();

            $data = [
                'sewa' => $sewa,
                'count_sewa' => $count_sewa
            ];

            $view = [
                'view' => view('sewa/sedang_berlangsung', $data)
            ];

            echo json_encode($view);
        }
    }
    public function riwayat_sewa()
    {
        if ($this->request->isAJAX()) {

            $id = $this->request->getVar('id');

            $db = $this->db->table('transaksi_sewa');
            $db->select('faktur, sewa.id as id_sewa, kode_property, no_transaksi, tanggal_sewa, tanggal_batas, SUM(transaksi_sewa.bayar) as terbayar, sewa.harga as harga_sewa');
            $db->join('sewa', 'transaksi_sewa.sewa_id = sewa.id', 'right');
            $db->join('faktur', 'sewa.no_transaksi = faktur.id');
            $db->join('property', 'property.property_id = sewa.property_id');
            $db->where('pedagang_id', $id);
            $db->where('sewa.tanggal_batas <', date('Y-m-d'));
            $db->groupBy('sewa.id');
            $pedagang = $db->get();
            $count_sewa = $pedagang->getNumrows();
            $sewa = $pedagang->getResultArray();
            $data = [
                'sewa' => $sewa,
                'count_sewa' => $count_sewa
            ];

            $view = [
                'view' => view('sewa/riwayat_sewa', $data)
            ];

            echo json_encode($view);
        }
    }

    public function form_property()
    {
        if ($this->request->isAJAX()) {
            $view = [
                'view' => view('sewa/form_property')
            ];

            echo json_encode($view);
        }
    }

    public function data_property()
    {
        if ($this->request->isAJAX()) {
            $db = $this->db->table('property');
            $db->where('status', 1);
            $property['property'] = $db->get()->getResultArray();

            $view = [
                'view' => view('sewa/data_property', $property)
            ];

            echo json_encode($view);
        }
    }

    public function detail_item()
    {
        if ($this->request->isAJAX()) {

            $db = $this->db->table('users');
            $user = $db->getWhere(['id' => user_id()])->getRowArray();


            $data = [
                'id' => $this->session->id,
                'kode' => $this->session->kode,
                'jenis' => $this->session->jenis,
                'jangka' => $this->session->jangka,
                'harga' => $this->session->harga,
                'fasilitas' => $this->session->fasilitas,
                'pedagang_id' => $this->session->pedagang_id,
                'faktur' => $this->m_sewa->buatFaktur(),
                'user' => $user
            ];
            $view = [
                'view' => view('sewa/detail_item', $data)
            ];

            echo json_encode($view);
        }
    }
    public function detail_sewa()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');

            $sewa = [
                'sewa' => $this->m_sewa->detailSewaById($id),
                'history_bayar' => $this->m_sewa->riwayat_bayar_by_id($id)->getResultArray()
            ];

            $view = [
                'view' => view('sewa/detail_sewa', $sewa)
            ];

            echo json_encode($view);
        }
    }
    public function detail_property()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');

            $db = $this->db->table('property');

            $db->where('property_id', $id);
            $property = $db->get()->getRowArray();
            $property = [
                'property' => $property
            ];
            $view = [
                'view' => view('sewa/detail_property', $property)
            ];

            echo json_encode($view);
        }
    }
    public function temp_item()
    {
        if ($this->request->isAJAX()) {

            $data = [
                'id' => $this->request->getVar('id'),
                'kode' => $this->request->getVar('kode'),
                'jenis' => $this->request->getVar('jenis'),
                'jangka' => $this->request->getVar('jangka'),
                'harga' => $this->request->getVar('harga'),
                'fasilitas' => $this->request->getVar('fasilitas'),

            ];
            $this->session->set($data);


            $msg = [
                'sukses' => 'sukses',
            ];

            echo json_encode($msg);
        }
    }

    public function pembayaran()
    {
        if ($this->request->isAJAX()) {
            $jenis_pembayaran = $this->request->getVar('jenis_pembayaran');
            $tanggal_sewa = $this->request->getVar('altSewa');
            $tanggal_selesai = $this->request->getVar('altSelesai');
            $metode_pembayaran = $this->request->getVar('metode_pembayaran');

            $data = [
                'pedagang_id' => $this->request->getVar('pedagang_id'),
                'property_id' => $this->request->getVar('property_id'),
                'faktur' => $this->request->getVar('faktur'),
                'tanggal_sewa' => $this->request->getVar('altSewa'),
                'tanggal_selesai' => $this->request->getVar('altSelesai'),
                'jenis_pembayaran' => $this->request->getVar('jenis_pembayaran'),
                'metode_pembayaran' => $this->request->getVar('metode_pembayaran'),
                'harga' => $this->request->getVar('harga'),
            ];

            if (empty($tanggal_sewa)) {
                $msg = [
                    'status' => 'Tanggal Sewa harus diisi'
                ];
            } else if (empty($tanggal_selesai)) {
                $msg = [
                    'status' => 'Tanggal Selesai harus diisi'
                ];
            } else if (empty($jenis_pembayaran)) {
                $msg = [
                    'status' => 'Jenis pembayaran harus diisi'
                ];
            } else if (empty($metode_pembayaran)) {
                $msg = [
                    'status' => 'Metode pembayaran harus diisi'
                ];
            } else {
                if ($jenis_pembayaran == "Tunai") {
                    $msg = [
                        'view' => view('sewa/pembayaran_tunai', $data)
                    ];
                } else {
                    $msg = [
                        'view' => view('sewa/pembayaran_kredit', $data)
                    ];
                }
            }

            echo json_encode($msg);
        }
    }

    public function simpan_pembayaran()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $metode_bayar = $this->request->getVar('metode_pembayaran');
            if ($metode_bayar == "Transfer") {
                $rules = 'uploaded[bukti]|is_image[bukti]|mime_in[bukti,image/jpg,image/jpeg,image/png]|max_size[bukti,5120]';
            } else {
                $rules = 'is_image[bukti]|mime_in[bukti,image/jpg,image/jpeg,image/png]|max_size[bukti,5120]';
            }

            $validate = $this->validate([
                'bukti' => [
                    'rules' => $rules,
                    'errors' => [
                        'uploaded' => 'Unggah bukti pembayaran.',
                        'is_image' => 'Yang anda masukan bukan gambar',
                        'mime_in' => 'Yang anda masukan bukan gambar',
                        'max_size' => 'Ukuran gambar terlalu besar'
                    ]
                ],
            ]);
            if (!$validate) {
                $data = [
                    'error' => [
                        'bukti' => $validation->getError('bukti')
                    ]
                ];
            } else {
                unset(
                    $_SESSION['id'],
                    $_SESSION['kode'],
                    $_SESSION['jangka'],
                    $_SESSION['jenis'],
                    $_SESSION['harga'],
                    $_SESSION['fasilitas']
                );
                $faktur = [
                    'faktur' => $this->request->getVar('no_transaksi'),
                    'jenis' => 'Sewa',
                    'pembuat' => user_id()
                ];
                if ($metode_bayar == "Transfer") {
                    $fileGambar = $this->request->getFile('bukti');
                    $namaGambar = $fileGambar->getRandomName();
                    $fileGambar->move('img/upload/', $namaGambar);
                } else {
                    $namaGambar = NULL;
                }

                $sewa = [
                    'pedagang_id' => $this->request->getVar('pedagang_id'),
                    'property_id' => $this->request->getVar('property_id'),
                    'jenis_pembayaran' => $this->request->getVar('jenis_pembayaran'),
                    'harga' => str_replace(',', '',  $this->request->getVar('total')),
                    'total_bayar' => str_replace(',', '',  $this->request->getVar('bayar')),
                    'tanggal_sewa' => $this->request->getVar('tanggal_sewa'),
                    'tanggal_batas' => $this->request->getVar('tanggal_selesai'),
                    'bayar' => str_replace(',', '',  $this->request->getVar('bayar')),
                    'metode_bayar' => $this->request->getVar('metode_pembayaran'),
                    'bukti' => $namaGambar,
                    'keterangan' => $this->request->getVar('keterangan'),
                    'created_at' => date('Y-m-d H:i:s'),
                    'user_id' => user_id(),
                ];

                $this->m_sewa->save_sewa($sewa, $faktur);
                $data = [
                    'status' => 'sukses'
                ];
            }

            echo json_encode($data);
        }
    }


    public function delete_sewa()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');
            $this->m_sewa->delete_sewa($id);

            $msg = [
                'sukses' => 'sukses'
            ];
            echo json_encode($msg);
        }
    }

    public function pelunasan()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');
            $detail =
                [
                    'sewa' => $this->m_sewa->detailSewaById($id),
                ];
            $view = [
                'view' => view('sewa/pelunasan', $detail)
            ];

            echo json_encode($view);
        }
    }

    public function simpan_pelunasan()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $metode_bayar = $this->request->getVar('metode');
            if ($metode_bayar == "Transfer") {
                $rules = 'uploaded[bukti]|is_image[bukti]|mime_in[bukti,image/jpg,image/jpeg,image/png]|max_size[bukti,5120]';
            } else {
                $rules = 'is_image[bukti]|mime_in[bukti,image/jpg,image/jpeg,image/png]|max_size[bukti,5120]';
            }
            $validate = $this->validate([
                'bukti' => [
                    'rules' => $rules,
                    'errors' => [
                        'uploaded' => 'Bukti pembayaran harus diunggah.',
                        'is_image' => 'Yang anda masukan bukan gambar',
                        'mime_in' => 'Yang anda masukan bukan gambar',
                        'max_size' => 'Ukuran gambar terlalu besar'
                    ]
                ],
            ]);
            if (!$validate) {
                $data = [
                    'error' => [
                        'bukti' => $validation->getError('bukti')
                    ]
                ];
            } else {
                unset(
                    $_SESSION['id'],
                    $_SESSION['kode'],
                    $_SESSION['jangka'],
                    $_SESSION['jenis'],
                    $_SESSION['harga'],
                    $_SESSION['fasilitas']
                );
                if ($metode_bayar == "transfer") {
                    $fileGambar = $this->request->getFile('bukti');
                    $namaGambar = $fileGambar->getRandomName();
                    $fileGambar->move('img/upload/', $namaGambar);
                } else {
                    $namaGambar = NULL;
                }
                $bayarOld = str_replace(",", "", $this->request->getVar('bayarOld'));
                $new_bayar = str_replace(",", "", $this->request->getVar('bayar'));
                $kekurangan_old = str_replace(",", "", $this->request->getVar('kekuranganOld'));
                if ($new_bayar > $kekurangan_old) {
                    $kembalian = intval($new_bayar) - intval($kekurangan_old);
                } else {
                    $kembalian = 0;
                }
                $total_bayar = [
                    'total_bayar' => (intval($bayarOld) + intval($new_bayar))
                ];

                $pembayaran = [
                    'sewa_id' => $this->request->getVar('sewaId'),
                    'bayar' => str_replace(',', '',  $this->request->getVar('bayar')),
                    'kembalian' => $kembalian,
                    'metode_bayar' => $this->request->getVar('metode'),
                    'bukti' => $namaGambar,
                    'keterangan' => $this->request->getVar('keterangan'),
                    'user_id' => user_id(),
                    'created_at' => date('Y-m-d H:i:s'),
                ];

                $this->m_sewa->save_pelunasan($pembayaran, $total_bayar);
                $data = [
                    'status' => 'sukses'
                ];
            }
            echo json_encode($data);
        }
    }

    public function edit_pembayaran_sewa()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');
            $data = [
                'transaksi' => $this->m_sewa->edit_bayar_by_id($id)->getRowArray(),
                'faktur' => $this->request->getVar('faktur'),
                'pedagang' => $this->request->getVar('pedagang'),
                'property' => $this->request->getVar('property')
            ];


            $view = [
                'view' => view('sewa/edit_nominal_sewa', $data)
            ];

            echo json_encode($view);
        }
    }

    public function update_pembayaran_sewa()
    {
        if ($this->request->isAJAX()) {
            $metode = $this->request->getVar('metode');
            $gambar_old = $this->request->getVar('gambar_old');
            $fileGambar = $this->request->getFile('bukti');
            $validation = \config\Services::validation();
            if ($metode == "Transfer") {
                if (!empty($gambar_old)) {
                    $rules = 'is_image[bukti]|mime_in[bukti,image/jpg,image/jpeg,image/png]|max_size[bukti,5120]';
                } else {
                    $rules = 'uploaded[bukti]|is_image[bukti]|mime_in[bukti,image/jpg,image/jpeg,image/png]|max_size[bukti,5120]';
                }
            } elseif ($metode == "Tunai") {
                $rules = 'is_image[bukti]|mime_in[bukti,image/jpg,image/jpeg,image/png]|max_size[bukti,5120]';
            }


            $validate = $this->validate([
                'bukti' => [
                    'rules' => $rules,
                    'errors' => [
                        'uploaded' => 'Unggah bukti pembayaran.',
                        'is_image' => 'Yang anda masukan bukan gambar',
                        'mime_in' => 'Yang anda masukan bukan gambar',
                        'max_size' => 'Ukuran gambar terlalu besar'
                    ]
                ],
            ]);
            if (!$validate) {
                $data = [
                    'error' => [
                        'bukti' => $validation->getError('bukti')
                    ]
                ];
            } else {
                if ($metode == "Transfer") {
                    if ($fileGambar->getError() == 4) {
                        $namaGambar = $gambar_old;
                    } else {
                        if (empty($gambar_old)) {
                            $namaGambar = $fileGambar->getRandomName();
                            $fileGambar->move('img/upload/', $namaGambar);
                        } else {
                            $namaGambar = $fileGambar->getRandomName();
                            $fileGambar->move('img/upload/', $namaGambar);
                            unlink('img/upload/' . $gambar_old);
                        }
                    }
                } elseif ($metode == "Tunai") {
                    if (empty($gambar_old)) {
                        $namaGambar = Null;
                    } else {
                        $namaGambar = Null;
                        unlink('img/upload/' . $gambar_old);
                    }
                }


                $transaksiid = $this->request->getVar('id');
                $sewaid = $this->request->getVar('sewaid');
                $bayarold = $this->request->getVar('bayarold');
                $new_bayar = str_replace(',', '', $this->request->getVar('bayar'));
                $metode = $this->request->getVar('metode');

                $db = $this->db->table('sewa');
                $db->where('id', $sewaid);
                $sewa = $db->get()->getRowArray();

                $update_bayar = (($sewa['total_bayar'] - $bayarold) + $new_bayar);
                if ($update_bayar > $sewa['harga']) {
                    $kembalian = $update_bayar - $sewa['harga'];
                } else {
                    $kembalian = 0;
                }

                $data = [
                    'bayar' => $new_bayar,
                    'kembalian' => $kembalian,
                    'metode_bayar' => $metode,
                    'bukti' => $namaGambar,
                    'keterangan' => $this->request->getVar('keterangan'),
                    'user_id' => user_id(),
                    'updated_at' => date('Y-m-d H:i:s')
                ];

                $this->m_sewa->update_pembayaran_sewa($data, $transaksiid, $sewaid, $update_bayar);

                $data = [
                    'status' => 'sukses'
                ];
            }


            echo json_encode($data);
        }
    }

    public function hapus_pembayaran_sewa()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');


            $db = $this->db->table('transaksi_sewa');
            $db->where('id', $id);
            $bukti = $db->get()->getRowArray();

            if (!empty($bukti['bukti'])) {
                unlink('img/upload/' . $bukti['bukti']);
            }

            $db = $this->db->table('transaksi_sewa');
            $db->where('id', $id);
            $db->delete();

            $data = [
                'status' => 'sukses'
            ];
            echo json_encode($data);
        }
    }

    public function periode_bulanan()
    {
        $validation = \config\Services::validation();
        $data = [
            'title' => 'Tagihan Bulanan',
            'validation' => $validation
        ];
        return view('sewa/tagihan_bulanan/index', $data);
    }

    public function data_periode()
    {
        if ($this->request->isAJAX()) {

            $data = [
                'bulanan' => $this->m_sewa->periode_bulanan()
            ];

            $data = [
                'view' => view('sewa/tagihan_bulanan/data_periode', $data)
            ];

            echo json_encode($data);
        }
    }


    public function tagihan_bulanan_belum_lunas()
    {
        $data = [
            'title' => 'Tagihan Bulanan',
            'tagihan' => $this->m_sewa->tagihan_bulanan_belum_lunas()
        ];
        return view('sewa/tagihan_bulanan/tagihan_belum_lunas', $data);
    }



    public function createPeriodeBulanan()
    {
        if (!$this->validate([
            'bulan' => [
                'rules' => 'required|is_unique[periode_bulanan.periode]',
                'errors' => [
                    'required' => 'Bulan harus di isi.',
                    'is_unique' => 'sudah ada'
                ]
            ],
            'tahun' => [
                'rules' => 'required|is_unique[periode_bulanan.periode]',
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

            return redirect()->to('/persewaan/periode_bulanan')->withInput();
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


        $db = $this->db->table('periode_bulanan');
        $db->where('periode', $date);
        $db->where('jenis', $this->request->getVar('jenis'));
        $count = $db->countAllResults();

        $hasil = $this->m_sewa->cek_tanggal_sewa($date, $jenis);

        if ($count  > 0) {
            session()->setFlashdata('error', ' <div class="alert alert-warning alert-dismissible fade show text-center" role="alert">
            Periode ' . bulan_tahun(date('Y-m-d', strtotime($date))) . ' untuk jenis ' . $this->request->getVar('jenis') . ' sudah pernah ditambahkan sebelumnya.
             <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                 <span aria-hidden="true">&times;</span>
             </button>
         </div>');
            return redirect()->to('/persewaan/periode_bulanan')->withInput();
        } elseif ($hasil == 0) {
            session()->setFlashdata('error', ' <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
           Tidak ada data dalam periode ' . bulan_tahun(date('Y-m-d', strtotime($date))) . ' untuk jenis ' . $this->request->getVar('jenis') . ', periode tersebut gagal ditambahkan.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>');
            return redirect()->to('/persewaan/periode_bulanan')->withInput();
        } else {
            $data = [
                'periode' => $date,
                'tarif' => $this->request->getVar('tarif'),
                'jenis' => $this->request->getVar('jenis'),
                'created_at' => date('Y-m-d H:i:s')
            ];

            $this->m_sewa->create_tagihan_bulanan($data, $date, $jenis);

            session()->setFlashdata('pesan', 'Periode ' . bulan_tahun(date('Y-m-d', strtotime($date))) . ' berhasil ditambahkan');
            return redirect()->to('/persewaan/periode_bulanan');
        }
    }
    public function ubah_periode()
    {
        if ($this->request->isAJAX()) {

            $id = $this->request->getVar('id');

            $db = $this->db->table('periode_bulanan');
            $periode = $db->getWhere(['id' => $id])->getRowArray();

            $sewa = $this->db->table('sewa');
            $sewa->selectMin('tanggal_sewa');
            $sewa_min  = $sewa->get('1')->getRowArray();

            $sewa = $this->db->table('sewa');
            $sewa->selectMax('tanggal_batas');
            $sewa_max  = $sewa->get('1')->getRowArray();


            $data = [
                'title' => 'Ubah Periode Bulanan',
                'periode' => $periode,
                'validation' => \config\Services::validation(),
                'tanggal_min' => $sewa_min,
                'tanggal_max' => $sewa_max
            ];
            $view = [
                'view' => view('sewa/tagihan_bulanan/ubah_periode', $data)
            ];

            echo json_encode($view);
        }
    }

    public function update_periode_bulanan()
    {
        if ($this->request->isAJAX()) {
            $bulan = $this->request->getVar('bulan');
            $tahun = $this->request->getVar('tahun');
            $tarif = $this->request->getVar('tarif');
            $jenis = $this->request->getVar('jenis');
            $periode_old = $this->request->getVar('periode');
            $periode_new = date('Y-m-d', strtotime($tahun . '-' . $bulan . '-' . 1));

            $periode = $this->db->table('periode_bulanan');
            $periode->where('periode', $periode_new);
            $periode->where('jenis', $jenis);
            $count_periode = $periode->countAllResults();

            if ($jenis == 'Semua') {
                $jenis = ['Kios', 'Los'];
            } else {
                $jenis = [$jenis];
            }


            $sewa = $this->db->table('sewa');
            $sewa->Select('*');
            $sewa->join('property', 'property.property_id = sewa.property_id');
            $sewa->where('tanggal_sewa <=', date('Y-m-d', strtotime('+1 month', strtotime($periode_new))));
            $sewa->where('tanggal_batas >=', date('Y-m-d'));
            $sewa->whereIn('jenis_property', $jenis);
            $count_sewa  = $sewa->countAllResults();


            if ($periode_old == $periode_new && $jenis == $jenis) {
                $period = 0;
            } elseif ($count_periode > 0) {
                $period = 1;
            } else {
                $period = 0;
            }


            if ($count_sewa == 0) {
                $data = [
                    'error' =>  "Perhatikan bulan dan tahun"
                ];
            } elseif ($period > 0) {
                $data = [
                    'error' => 'Periode sudah ada'
                ];
            } elseif ($tarif < 1) {
                $data = [
                    'error' => 'Masukan tarif periode bulanan'
                ];
            } else {
                $id = $this->request->getVar('id');
                $data = [
                    'periode' => $periode_new,
                    'tarif' => str_replace(',', '', $tarif)
                ];
                $this->m_sewa->update_periode_bulanan($id, $data);
                session()->setFlashdata('pesan', 'Periode berhasil diubah');
                $data = [
                    'sukses' => 'sukses'
                ];
            }
            echo json_encode($data);
        }
    }

    public function delete_periode()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');

            $db = $this->db->table('periode_bulanan');
            $db->where('id', $id);
            $db->delete();

            $data = [
                'sukses' => 'sukses'
            ];

            echo json_encode($data);
        }
    }


    public function data_detail_periode()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('periode');

            $detail_periode = $this->m_sewa->detail_periode($id)->getResultArray();
            // $periode = $this->m_sewa->detail_periode($id)->getNumRows();

            $data = [
                'bulanan' => $detail_periode,
                'periode' => $id

            ];

            $view = [
                'view' => view('sewa/tagihan_bulanan/data_detail_periode', $data)
            ];

            echo json_encode($view);
        }
    }
    public function data_riwayat_tagihan()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');


            $tagihan = $this->m_sewa->tagihan_bulanan_by_id($id);
            $history = $this->m_sewa->riwayat_tagihan_bulanan($id);

            $data = [
                'history' => $history,
                'tagihan' => $tagihan,
                'periode' => $this->request->getVar('periode'),

            ];

            $view = [
                'view' => view('sewa/tagihan_bulanan/data_riwayat', $data)
            ];

            echo json_encode($view);
        }
    }


    public function edit_pembayaran_tagihan_bulanan()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');

            $data = [
                'tagihan' => $id,
                'periode' => $this->request->getVar('periode'),

            ];

            $view = [
                'view' => view('sewa/tagihan_bulanan/edit_tagihan_by_id', $data)
            ];

            echo json_encode($view);
        }
    }
    public function riwayat_bayar_bulanan()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');
            $tagihan = $this->m_sewa->tagihan_bulanan_by_id($id);

            $db = $this->db->table('transaksi_bulanan');
            $db->where('tagihan_id', $id);
            $total = $db->countAllResults();

            // $db = $this->db->table('tagihan_bulanan');
            // $kekurangan = $db->getWhere(["id" => $id])->getRowArray();

            // $kekurangan = $kekurangan['tarif'] - $kekurangan['total_setor'];

            $history = $this->m_sewa->riwayat_tagihan_bulanan($id);
            $data = [
                'tagihan' => $tagihan,
                'history' => $history,
                'pedagang' => $this->request->getVar('pedagang'),
                'nik' => $this->request->getVar('nik'),
                'total' => $total,
                'periode' => $this->request->getVar('periode'),
                'property' => $this->request->getVar('property'),
                'tarif' => $tagihan['tarif'],
                'bayar' => $tagihan['total_bayar'],
                'id' => $id
            ];

            $view = [
                'view' => view('sewa/riwayat_pembayaran_bulanan', $data)
            ];

            echo json_encode($view);
        }
    }

    public function edit_nominal_pembayaran_bulanan()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');

            $tagihan = $this->m_sewa->edit_nominal_tagihan_bulanan($id);

            $data = [
                'tagihan' => $tagihan,
            ];

            $view = [
                'view' => view('sewa/tagihan_bulanan/edit_nominal', $data)
            ];

            echo json_encode($view);
        }
    }

    public function update_nominal_tagihan()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');
            $metode = $this->request->getVar('metode');
            $gambar_old = $this->request->getVar('gambarOld');
            $fileGambar = $this->request->getFile('bukti');
            if ($metode == "Transfer") {
                if (!empty($gambar_old)) {
                    $rules = 'is_image[bukti]|mime_in[bukti,image/jpg,image/jpeg,image/png]|max_size[bukti,5120]';
                } else {
                    $rules = 'uploaded[bukti]|is_image[bukti]|mime_in[bukti,image/jpg,image/jpeg,image/png]|max_size[bukti,5120]';
                }
            } elseif ($metode == "Tunai") {
                $rules = 'is_image[bukti]|mime_in[bukti,image/jpg,image/jpeg,image/png]|max_size[bukti,5120]';
            }

            $validation = \config\Services::validation();
            $validate = $this->validate([
                'bukti' => [
                    'rules' => $rules,
                    'errors' => [
                        'uploaded' => 'Bukti pembayaran harus diunggah.',
                        'is_image' => 'Yang anda masukan bukan gambar',
                        'mime_in' => 'Yang anda masukan bukan gambar',
                        'max_size' => 'Ukuran gambar terlalu besar'
                    ]
                ],
            ]);


            if (!$validate) {
                $msg = [
                    'error' => [
                        'bukti' => $validation->getError('bukti')
                    ]
                ];
            } else {

                if ($metode == "Transfer") {
                    if ($fileGambar->getError() == 4) {
                        $namaGambar = $gambar_old;
                    } else {
                        if (empty($gambar_old)) {
                            $namaGambar = $fileGambar->getRandomName();
                            $fileGambar->move('img/upload/', $namaGambar);
                        } else {
                            $namaGambar = $fileGambar->getRandomName();
                            $fileGambar->move('img/upload/', $namaGambar);
                            unlink('img/upload/' . $gambar_old);
                        }
                    }
                } elseif ($metode == "Tunai") {
                    if (empty($gambar_old)) {
                        $namaGambar = Null;
                    } else {
                        $namaGambar = Null;
                        unlink('img/upload/' . $gambar_old);
                    }
                }
                $data = [
                    'id' => $id,
                    'bayar' => str_replace(',', '', $this->request->getVar('bayar')),
                    'metode' => $this->request->getVar('metode'),
                    'bukti' => $namaGambar,
                    'keterangan' => $this->request->getVar('keterangan'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'user_id' => user_id()
                ];


                $this->m_sewa->update_nominal_tagihan($data);
                session()->setFlashdata('sukses', 'Data berhasil diubah');
                $msg = ['sukses' => 'sukses'];
            }
            echo json_encode($msg);
        }
    }

    public function delete_pedagang_by_periode()
    {
        if ($this->request->isAJAX()) {

            $id = $this->request->getVar('id');

            $this->m_sewa->delete_pedagang_by_periode($id);

            $data = [
                'sukses' => 'sukses',
            ];
            session()->setFlashdata('pesan', 'Data berhasil dihapus');
            echo json_encode($data);
        }
    }
    public function delete_riwayat_bayar_by_id()
    {
        if ($this->request->isAJAX()) {

            $bukti = $this->request->getVar('bukti');
            if (!empty($bukti)) {
                unlink('img/upload/' . $bukti);
            }
            $data = [
                'id' => $this->request->getVar('id'),
                'bayar' => $this->request->getVar('bayar'),
                'tagihanId' => $this->request->getVar('tagihan'),
            ];

            $this->m_sewa->delete_riwayat_bayar_by_id($data);

            $data = [
                'sukses' => 'sukses',
            ];

            echo json_encode($data);
        }
    }

    public function tagihan_bulanan_by_pedagang()
    {
        if ($this->request->isAJAX()) {

            $id = $this->request->getVar('id');
            $detail_periode = $this->m_sewa->tagihan_bulanan_by_pedagang($id);

            $db = $this->db->table('tagihan_bulanan');
            $db->select('pedagang.nama as pedagang, nik');
            $db->join('sewa', 'sewa.id = tagihan_bulanan.sewa_id', 'left');
            $db->join('pedagang', 'pedagang.id = sewa.pedagang_id', 'left');
            $db->where('sewa.pedagang_id', $id);
            $pedagang =  $db->get()->getRowArray();
            // $db = $this->db->table('tagihan_bulanan');
            // $db->count('id', $id);
            // $db->get()->getRowArray();

            $db = $this->db->table('tagihan_bulanan');
            $db->select('pedagang.nama as pedagang, nik');
            $db->join('sewa', 'sewa.id = tagihan_bulanan.sewa_id', 'left');
            $db->join('pedagang', 'pedagang.id = sewa.pedagang_id', 'left');
            $db->where('sewa.pedagang_id', $id);
            $count =  $db->countAllResults();

            $data = [
                'title' => 'Periode Bulan',
                'bulanan' => $detail_periode,
                'pedagang' => $pedagang,
                'count' => $count
            ];

            $view = [
                'view' => view('sewa/tagihan_bulanan_by_pedagang', $data)
            ];

            echo json_encode($view);
        }
    }

    public function pembayaran_tagihan_bulanan()
    {
        if ($this->request->isAJAX()) {

            $id = $this->request->getVar('id');
            $bayar_old = $this->request->getVar('bayar');

            $db = $this->db->table('tagihan_bulanan');
            $db->select('*,tagihan_bulanan.id as tagihanId, sum(bayar) as bayar');
            $db->join('periode_bulanan', 'periode_bulanan.id = tagihan_bulanan.periode_id');
            $db->join('sewa', 'sewa.id = tagihan_bulanan.sewa_id');
            $db->join('transaksi_bulanan', 'transaksi_bulanan.tagihan_id = tagihan_bulanan.id', 'left');
            $db->where('tagihan_bulanan.id', $id);
            $tagihan = $db->get()->getRowArray();


            $data = [
                'tagihan' => $tagihan,
                'aksi' => $this->request->getVar('aksi'),
                'kekurangan' => $tagihan['tarif'] - $tagihan['bayar'],
                'bayar_old' => $bayar_old
            ];

            $view = [
                'view' => view('sewa/tagihan_bulanan/pembayaran_tagihan', $data)
            ];

            echo json_encode($view);
        }
    }

    public function simpan_pembayaran_tagihan()
    {
        if ($this->request->isAJAX()) {
            $metode = $this->request->getVar('metode');
            if ($metode == "Transfer") {
                $rules = 'uploaded[bukti]|is_image[bukti]|mime_in[bukti,image/jpg,image/jpeg,image/png]|max_size[bukti,5120]';
            } else {
                $rules = 'is_image[bukti]|mime_in[bukti,image/jpg,image/jpeg,image/png]|max_size[bukti,5120]';
            }

            $validation = \config\Services::validation();

            $validate = $this->validate([
                'bukti' => [
                    'rules' => $rules,
                    'errors' => [
                        'uploaded' => 'Bukti pembayaran harus diunggah.',
                        'is_image' => 'Yang anda masukan bukan gambar',
                        'mime_in' => 'Yang anda masukan bukan gambar',
                        'max_size' => 'Ukuran gambar terlalu besar'
                    ]
                ],
            ]);

            if (!$validate) {
                $data = [
                    'error' => [
                        'bukti' => $validation->getError('bukti')
                    ]
                ];
            } else {
                if ($metode == "Transfer") {
                    $fileGambar = $this->request->getFile('bukti');
                    $namaGambar = $fileGambar->getRandomName();
                    $fileGambar->move('img/upload/', $namaGambar);
                } else {
                    $namaGambar = Null;
                }
                $bayar = str_replace(',', '', $this->request->getVar('bayar'));
                $bayar_old = intval($this->request->getVar('bayar_old'));
                $tarif = str_replace(',', '', $this->request->getVar('tarif'));

                $kekurangan = $tarif - $bayar_old;

                if ($bayar > $kekurangan) {
                    $kembalian = $bayar - $kekurangan;
                } else {
                    $kembalian = 0;
                }



                $data =   [
                    'tagihan_id' => $this->request->getVar('tagihanID'),
                    'bayar' => $bayar,
                    'kembalian' => $kembalian,
                    'metode' => $metode,
                    'bukti' => $namaGambar,
                    'keterangan' => $this->request->getVar('keterangan'),
                    'user_id' => user_id(),
                    'created_at' => date('Y-m-d H:i:s')
                ];

                $data2 = [
                    'total_bayar' => intval($this->request->getVar('bayar_old')) + $bayar
                ];
                $this->m_sewa->simpan_pembayaran_tagihan($data, $data2);

                $data = [
                    'status' => 'sukses'
                ];
            }
            echo json_encode($data);
        }
    }

    public function hapus_tagihan_bulanan()
    {
        if ($this->request->isAJAX()) {

            $id = $this->request->getVar('id');

            $db = $this->db->table('tagihan_bulanan');
            $db->where('id', $id);
            $db->delete();

            $data = [
                'sukses' => 'sukses'
            ];

            echo json_encode($data);
        }
    }
}
