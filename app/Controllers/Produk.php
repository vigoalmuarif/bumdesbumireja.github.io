<?php

namespace App\Controllers;

use App\Models\ModelProduk;
use SebastianBergmann\Type\NullType;

class Produk extends BaseController
{

    public function __construct()
    {
        $this->produkModel = new ModelProduk();
    }
    public function data()
    {
        $data = [
            'title' => 'Produk ATK',
            'produk' => $this->produkModel->produk()

        ];

        return view('master/produk/master', $data);
    }
    public function index()
    {
        $data = [
            'title' => 'Produk ATK',
            'produk' => $this->produkModel->getProduk()

        ];
        return view('master/produk/index', $data);
    }
    public function detailProduk($id)
    {
        $produk = [
            'produk' => $this->produkModel->produk($id),
            'harga' => $this->produkModel->harga_satuan($id),
        ];
        $data = [
            'id' => $id,
            'title' => 'Produk ATK',
            'data' => view('master/produk/detail', $produk)
        ];
        echo json_encode($data);
    }

    public function create()
    {
        $data = [
            'title' => 'Form Tambah Produk ATK',
            'supplier' => $this->produkModel->getSupplier(),
            'satuan' => $this->produkModel->getSatuan(),
            'kategori' => $this->produkModel->getKategori(),
            'validation' => \config\Services::validation(),
            'satuan' => $satuan = $this->produkModel->getSatuan()
        ];
        return view('master/produk/create', $data);
    }

    public function saveProduk()
    {
        if ($this->request->isAJAX()) {
            $validation = \config\services::validation();

            $validate = $this->validate([
                'sku' => [
                    'rules' => 'is_unique[produk.sku]',
                    'errors' => [
                        'is_unique' => 'SKU sudah digunakan pada produk lain'
                    ]
                ],
                'nama' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Nama produk harus diisi'
                    ]
                ],

                // 'harga_beli' => [
                //     'rules' => 'required',
                //     'errors' => [
                //         'required' => 'Harga beli produk harus diisi',
                //     ]
                // ],

                'kategori' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Kategori produk harus diisi'

                    ]
                ],
            ]);

            if (!$validate) {
                $data = [
                    'error' => [
                        'nama' => $validation->getError('nama'),
                        'kategori' => $validation->getError('kategori'),
                        'sku' => $validation->getError('sku')
                    ]
                ];
            } else {

                $produk = [
                    'sku' => empty($this->request->getVar('sku')) ? NULL : $this->request->getVar('sku'),
                    'harga_beli' => 0,
                    'nama' => $this->request->getVar('nama'),
                    'kategori_id' => $this->request->getVar('kategori'),
                    'created_at' => date('Y-m-d H:i:s'),
                ];

                $produk =  $this->produkModel->tambahProduk($produk);
                $data = [
                    'produk_id' => base_url('produk/satuan_harga/' . $produk),
                    'sukses' => 'sukses'
                ];

                // $jumlSatuan = count($satuan);
                // for ($i = 0; $i < $jumlSatuan; $i++) {
                //     $data1[] = [
                //         'barcode' => empty($barcode[$i]) ? 'NULL' : $satuan[$i],
                //         'satuan_id' => $satuan[$i],
                //         'isi' => $isi[$i],
                //         'harga_jual' => str_replace(',', '', $harga_jual[$i]),
                //         'created_at' => $created_at
                //     ];
                // }
                // print_r($data1);
            }

            // else {
            //     $satuan_beli = $this->request->getVar('satuan_beli');
            //     $satuan_beli_text = $this->request->getVar('satuan_beli_alternatif');
            //     $jumlahSatuan = $this->request->getVar('satuan');
            //     $cek_harga_jual_parent = count(array_keys($jumlahSatuan, $satuan_beli));

            //     if ($cek_harga_jual_parent == 0) {
            //         $data = [
            //             'msg' => 'error',
            //             'satuan_beli' => $satuan_beli_text
            //         ];
            //     } else {
            //         $jumlahSatuan = count($this->request->getVar('satuan'));
            //         $qty = [];

            //         for ($i = 0; $i < $jumlahSatuan; $i++) {

            //             $qty[] =   $this->request->getVar('isi')[$i];
            //         }

            //         $qty = max($qty);

            //         $stok = $qty * empty($this->request->getVar('stok'))  ? 0 : $this->request->getVar('stok');

            //         $produk = [
            //             'sku' => empty($this->request->getVar('sku')) ? NULL : $this->request->getVar('sku'),
            //             'nama' => $this->request->getVar('nama'),
            //             'kategori_id' => $this->request->getVar('kategori'),
            //             'supplier_id' => empty($this->request->getVar('supplier'))  ? NULL :  $this->request->getVar('supplier'),
            //             'satuan_id' => $this->request->getVar('satuan_terkecil'),
            //             'harga_beli' => empty($this->request->getVar('harga_beli')) ? 0 : str_replace(',', '', $this->request->getVar('harga_beli')),
            //             'qty' => $stok,
            //             'created_at' => date('Y-m-d H:i:s'),
            //         ];


            //         $harga = [
            //             'barcode' => $this->request->getVar('barcode'),
            //             'satuan' => $this->request->getVar('satuan'),
            //             'isi' => $this->request->getVar('isi'),
            //             'children' => $this->request->getVar('satuan_terkecil'),
            //             'harga_jual' => str_replace(',', '', $this->request->getVar('harga_jual')),
            //             'created_at' => date('Y-m-d H:i:s')
            //         ];
            //         $this->produkModel->tambahProduk($produk, $harga);
            //         $data = [
            //             'sukses' => 'sukses'
            //         ];

            //         // $jumlSatuan = count($satuan);
            //         // for ($i = 0; $i < $jumlSatuan; $i++) {
            //         //     $data1[] = [
            //         //         'barcode' => empty($barcode[$i]) ? 'NULL' : $satuan[$i],
            //         //         'satuan_id' => $satuan[$i],
            //         //         'isi' => $isi[$i],
            //         //         'harga_jual' => str_replace(',', '', $harga_jual[$i]),
            //         //         'created_at' => $created_at
            //         //     ];
            //         // }
            //         // print_r($data1);
            //     }
            // }

            echo json_encode($data);
            // $barcode = $this->request->getVar('barcode');
            // $supplier = $this->request->getVar('supplier');
            // if (empty($barcode)) {
            //     $barcode = NULL;
            // } else {
            //     $barcode;
            // }

            // if (empty($supplier)) {
            //     $supplier = Null;
            // } else {
            //     $supplier;
            // }
            // if (!$this->validate([])) {
            //     $data = [
            //         'title' => 'Form Tambah Produk ATK',
            //         'supplier' => $this->produkModel->getSupplier(),
            //         'satuan' => $this->produkModel->getSatuan(),
            //         'kategori' => $this->produkModel->getKategori(),
            //         'validation' => \config\Services::validation()
            //     ];
            //     return view('master/produk/create', $data);
            // }
            // $harga_beli = str_replace(',', '', $this->request->getVar('harga_beli'));
            // $harga_jual = str_replace(',', '', $this->request->getVar('harga_jual'));
            // if ($harga_jual < $harga_beli) {
            //     $data = [
            //         'title' => 'Form Tambah Produk ATK',
            //         'supplier' => $this->produkModel->getSupplier(),
            //         'satuan' => $this->produkModel->getSatuan(),
            //         'kategori' => $this->produkModel->getKategori(),
            //         'validation' => \config\Services::validation()
            //     ];
            //     session()->setFlashdata('pesan', 'Harga jual tidak boleh lebih kecil dari harga beli');
            //     return view('master/produk/create', $data);
            // }
            // $data = [
            //     'barcode' => $barcode,
            //     'sku' => $this->request->getVar('sku'),
            //     'nama' => $this->request->getVar('nama'),
            //     'harga_beli' => str_replace(',', '', $this->request->getVar('harga_beli')),
            //     'harga_jual' => str_replace(',', '', $this->request->getVar('harga_jual')),
            //     'satuan_id' => $this->request->getVar('satuan'),
            //     'kategori_id' => $this->request->getVar('kategori'),
            //     'stok' => str_replace(',', '', $this->request->getVar('stok')),
            //     'stok_in' => $this->request->getVar('stok'),
            //     'supplier_id' => $supplier,
            //     'keterangan' => $this->request->getVar('keterangan'),
            //     'created_at' => date('Y-m-d H:i:s')
            // ];

            // $this->produkModel->tambahProduk($data);
            // session()->setFlashdata('pesan', 'Produk berhasil ditambahkan');
            // return redirect()->to('index');
        }
    }

    public function ubah($id)
    {

        $data = [
            'title' => 'Ubah Produk ATK',
            'produk' => $this->produkModel->produk($id),
            'validation' => \config\Services::validation(),
            'supplier' => $this->produkModel->getSupplier(),
            'satuan' => $this->produkModel->getSatuan(),
            'kategori' => $this->produkModel->getKategori(),
        ];

        return view('master/produk/edit', $data);
    }

    public function update($id)
    {

        $sku = $this->request->getVar('sku');
        $old_sku = $this->request->getVar('old_sku');
        $supplier = $this->request->getVar('supplier');
        if ($old_sku == $sku) {
            $rules = 'string';
        } else {
            $rules = 'is_unique[produk.sku]';
        }

        if (!$this->validate([
            'sku' => [
                'rules' => $rules,
                'errors' => [
                    'required' => 'SKU produk harus diisi',
                    'is_unique' => 'SKU sudah digunakan'
                ]
            ],
            'nama' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama produk harus diisi'
                ]
            ],
            'kategori' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Kategori produk harus diisi'

                ]
            ],
            'supplier' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'supplier produk harus diisi'

                ]
            ],
        ])) {
            $data = [
                'title' => 'Form Ubah Produk ATK',
                'produk' => $this->produkModel->produk($id),
                'supplier' => $this->produkModel->getSupplier(),
                'satuan' => $this->produkModel->getSatuan(),
                'kategori' => $this->produkModel->getKategori(),
                'validation' => \config\Services::validation()
            ];
            return view('master/produk/edit', $data);
        }

        $data = [
            'nama' => $this->request->getVar('nama'),
            'kategori_id' => $this->request->getVar('kategori'),
            'supplier_id' => $supplier,
            'updated_at' => date('Y-m-d H:i:s')
        ];
        $db = $this->db->table('produk');
        $db->where('id', $id);
        $db->update($data);

        session()->setFlashdata('pesan', 'Produk berhasil diubah');
        return redirect()->to('/produk/data')->withInput();
    }


    public function satuan_harga($id)
    {

        $db = $this->db->table('produk_harga');
        $db->where('produk_id', $id);
        $count = $db->countAllResults();

        $db = $this->db->table('pembelian_detail');
        $db->select('count(produk.id)');
        $db->join('produk_harga', 'produk_harga.id = pembelian_detail.produk_harga_id');
        $db->join('produk', 'produk.id = produk_harga.produk_id');
        $db->where('produk_id', $id);
        $cekPembelian = $db->countAllResults();
        // dd($cekPembelian);

        $produk = [
            'title' => 'Satuan Harga',
            'produk' => $this->produkModel->Produk($id),
            'count' => $count,
            'harga' => $this->produkModel->harga_satuan($id),
            'cekPembelian' => $cekPembelian
        ];
        return view('master/produk/satuan_harga', $produk);
    }

    public function create_satuan_dasar()
    {
        if ($this->request->isAJAX()) {
            $produkID = [
                'produkID' => $this->request->getVar('id'),
                'sku' => $this->request->getVar('sku'),
                'produk' => $this->request->getVar('produk'),
            ];
            $data = [
                'data' => view('master/produk/form_satuan_dasar', $produkID),

            ];

            echo json_encode($data);
        }
    }

    public function save_satuan_dasar()
    {
        if ($this->request->isAJAX()) {
            $validation = \config\Services::validation();
            $validate = $this->validate([
                'satuan' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Satuan dasar harus diisi.'
                    ]
                ],
                'isi' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Isi harus diisi.'
                    ]
                ],
            ]);
            if (!$validate) {
                $data = [
                    'error' => [
                        'satuan' => $validation->getError('satuan'),
                        'isi' => $validation->getError('isi'),
                    ]
                ];
            } else {
                $id = $this->request->getVar('id');
                $data1 = [
                    'satuan_id' => $this->request->getVar('satuan'),
                ];
                $data2 = [
                    'produk_id' => $id,
                    'nama_lain' => NULL,
                    'barcode' => NULL,
                    'satuan_id' => $this->request->getVar('satuan'),
                    'isi' => $this->request->getVar('isi'),
                    'harga_jual' => 0,
                    'created_at' => date('Y-m-d H:i:s'),
                ];
                $this->produkModel->save_satuan_dasar($data1, $data2, $id);
                $data = [
                    'msg' => 'sukses'
                ];
                session()->setFlashdata('flashdata', 'Satuan dasar berhasil ditambahkan');
            }

            echo json_encode($data);
        }
    }

    public function edit_satuan_dasar()
    {
        if ($this->request->isAJAX()) {
            $produkID = $this->request->getVar('id');

            $db = $this->db->table('produk');
            $db->select('satuan_id, produk.id as produk_id, nama, sku');
            $db->where('id', $produkID);
            $produk = $db->get()->getRowArray();

            $produk = [
                'satuanDasar' => $produk
            ];

            $data = [
                'data' => view('master/produk/edit_satuan_dasar', $produk),

            ];

            echo json_encode($data);
        }
    }

    public function update_satuan_dasar()
    {
        if ($this->request->isAJAX()) {
            $validation = \config\Services::validation();
            $barcode = $this->request->getVar('barcode') == '' ? NULL : $this->request->getVar('barcode');
            $barcode_old = $this->request->getVar('barcode_old') == '' ? NULL : $this->request->getVar('barcode');

            if ($barcode != $barcode_old) {
                $rules = "is_unique[produk_harga.barcode]|string";
            } else {
                $rules = 'string';
            }

            $validate = $this->validate([
                'satuan' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Satuan dasar harus diisi.'
                    ]
                ],
                'isi' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Isi harus diisi.'
                    ]
                ],
            ]);
            if (!$validate) {
                $data = [
                    'error' => [
                        'barcode' => $validation->getError('barcode'),
                        'satuan' => $validation->getError('satuan'),
                        'isi' => $validation->getError('isi'),
                    ]
                ];
            } else {
                $produkID = $this->request->getVar('produkID');
                $data = [
                    'satuan_id' => $this->request->getVar('satuan'),
                ];

                $this->produkModel->update_satuan_dasar($data, $produkID);
                $data = [
                    'msg' => 'sukses'
                ];
                session()->setFlashdata('flashdata', 'Satuan dasar berhasil diubah!');
            }

            echo json_encode($data);
        }
    }

    public function create_stok_awal()
    {
        if ($this->request->isAJAX()) {
            $produk = [
                'produkID' => $this->request->getVar('id'),
                'sku' => $this->request->getVar('sku'),
                'produk' => $this->request->getVar('produk'),
                'satuan' => $this->request->getVar('satuan'),
                'satuanID' => $this->request->getVar('satuanID'),
            ];
            $data = [
                'data' => view('master/produk/stok_awal', $produk)
            ];

            echo json_encode($data);
        }
    }
    public function save_stok_awal()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');
            $jumlah = $this->request->getVar('jumlah');

            if ($id == '' || null) {
                $data = [
                    'error' => 'produk tidak ditemukan!'
                ];
            } else {
                if ($jumlah == '' || null) {
                    $data = [
                        'error' => 'masukan jumlah stok awal'
                    ];
                } else {
                    try {
                        $produk = [
                            'stok_awal' => str_replace(',', '', $this->request->getVar('jumlah')),
                            'qty' => str_replace(',', '', $this->request->getVar('jumlah'))
                        ];
                        $db = $this->db->table('produk');
                        $db->where('id', $id);
                        $db->update($produk);

                        $satuan = $this->request->getVar('satuanID');
                        $db = $this->db->table('produk_harga');
                        $db->where('satuan_id', $satuan);
                        $db->where('produk_id', $id);
                        $produk_satuan = $db->get()->getRowArray();


                        $produk = [
                            'qty' => $this->request->getVar('jumlah'),
                            'produk_harga_id' => $produk_satuan['id'],
                            'type' => 'in',
                            'user_id' => user_id(),
                            'keterangan' => 'Stok awal' . ' (' . $jumlah . ' ' . $this->request->getVar('satuan') . ')',
                            'created_at' => date('Y-m-d H:i:s')
                        ];
                        $db = $this->db->table('produk_stok');
                        $db->insert($produk);
                        $data = [
                            'msg' => 'sukses'
                        ];
                        session()->setFlashdata('flashdata', 'Stok Awal berhasil dibuat!');
                    } catch (\Throwable $e) {

                        $data = [
                            'error' => $e->getMessage()
                        ];
                    }
                }
            }
            echo json_encode($data);
        }
    }
    public function edit_stok_awal()
    {
        if ($this->request->isAJAX()) {
            $produk = [
                'produkID' => $this->request->getVar('id'),
                'sku' => $this->request->getVar('sku'),
                'produk' => $this->request->getVar('produk'),
                'satuan' => $this->request->getVar('satuan'),
                'satuanID' => $this->request->getVar('satuanID'),
                'stok_awal' => $this->request->getVar('stok_awal'),
                'qty' => $this->request->getVar('qty'),

            ];
            $data = [
                'data' => view('master/produk/edit_stok_awal', $produk)
            ];

            echo json_encode($data);
        }
    }

    public function update_stok_awal()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');
            $jumlah = str_replace(',', '', $this->request->getVar('jumlah'));
            $jumlahOld = str_replace(',', '', $this->request->getVar('jumlahOld'));
            $qty = str_replace(',', '', $this->request->getVar('qty'));

            $qty_new = $jumlahOld - $qty;
            $update_qty = $jumlah - $qty_new;

            if ($id == '' || null) {
                $data = [
                    'error' => 'produk tidak ditemukan!'
                ];
            } else {
                if ($jumlah == '' || null) {
                    $data = [
                        'error' => 'masukan jumlah stok awal'
                    ];
                } else {
                    try {
                        $produk = [
                            'stok_awal' => str_replace(',', '', $this->request->getVar('jumlah')),
                            'qty' => str_replace(',', '', $update_qty),
                        ];
                        $db = $this->db->table('produk');
                        $db->where('id', $id);
                        $db->update($produk);

                        $satuan = $this->request->getVar('satuanID');
                        $db = $this->db->table('produk_stok');
                        $db->select('produk_stok.id as stok_id');
                        $db->join('produk_harga', 'produk_harga.id = produk_stok.produk_harga_id');
                        $db->where('satuan_id', $satuan);
                        $db->where('produk_id', $id);
                        $produk_satuan = $db->get()->getRowArray();

                        $produk = [
                            'qty' => $this->request->getVar('jumlah'),
                            'user_id' => user_id(),
                            'keterangan' => 'Stok awal' . ' (' . $jumlah . ' ' . $this->request->getVar('satuan') . ')',
                            'created_at' => date('Y-m-d H:i:s')
                        ];
                        $db = $this->db->table('produk_stok');
                        $db->where('id', $produk_satuan['stok_id']);
                        $db->update($produk);
                        $data = [
                            'msg' => 'sukses'
                        ];
                        session()->setFlashdata('flashdata', 'Stok Awal berhasil diubah!');
                    } catch (\Throwable $e) {

                        $data = [
                            'error' => $e->getMessage()
                        ];
                    }
                }
            }
            echo json_encode($data);
        }
    }
    public function create_harga()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');

            $db = $this->db->table('pembelian');
            $db->select('pembelian_detail.harga, produk_satuan.nama as satuan');
            $db->join('pembelian_detail', 'pembelian_detail.pembelian_id = pembelian.id');
            $db->join('produk_harga', 'pembelian_detail.produk_harga_id = produk_harga.id');
            $db->join('produk_satuan', 'produk_harga.satuan_id = produk_satuan.id');
            $db->where('produk_id', $id);
            $db->orderBy('pembelian.created_at', 'desc');
            $get = $db->get();
            $cek_pembelian = $get->getNumRows();
            if ($cek_pembelian > 0) {
                $pembelian = $get->getRowArray();
            } else {
                $pembelian = '';
            }

            $produk = [
                'produkID' => $this->request->getVar('id'),
                'sku' => $this->request->getVar('sku'),
                'produk' => $this->request->getVar('produk'),
                'satuan' => $this->request->getVar('satuan'),
                'cek_pembelian' => $cek_pembelian,
                'pembelian' => $pembelian
            ];
            $data = [
                'data' => view('master/produk/create_harga', $produk)
            ];

            echo json_encode($data);
        }
    }

    public function save_satuan_harga()
    {
        if ($this->request->isAJAX()) {
            $validation = \config\Services::validation();
            $validate = $this->validate([
                'barcode' => [
                    'rules' => 'is_unique[produk_harga.barcode]',
                    'errors' => [
                        'is_unique' => 'Barcode sudah digunakan pada produk lain.',

                    ]
                ],
                'satuan' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Satuan dasar harus diisi.'
                    ]
                ],
                'isi' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Isi harus diisi.'
                    ]
                ],
            ]);
            if (!$validate) {
                $data = [
                    'error' => [
                        'barcode' => $validation->getError('barcode'),
                        'satuan' => $validation->getError('satuan'),
                        'isi' => $validation->getError('isi'),
                    ]
                ];
            } else {

                $data = [
                    'produk_id' => $this->request->getVar('id'),
                    'nama_lain' => empty($this->request->getVar('nama_lain')) ? NULL : $this->request->getVar('nama_lain'),
                    'barcode' => empty($this->request->getVar('barcode')) ? NULL : $this->request->getVar('barcode'),
                    'satuan_id' => $this->request->getVar('satuan'),
                    'isi' => $this->request->getVar('isi'),
                    'harga_jual' => empty($this->request->getVar('harga_jual')) ? 0 : str_replace(',', '', $this->request->getVar('harga_jual')),
                    'created_at' => date('Y-m-d H:i:s'),
                ];

                $this->produkModel->save_satuan_harga($data);
                $data = [
                    'msg' => 'sukses'
                ];
                session()->setFlashdata('flashdata', 'Satuan harga berhasil ditambahkan');
            }

            echo json_encode($data);
        }
    }

    public function edit_satuan_harga()
    {
        if ($this->request->isAJAX()) {
            $produkID = $this->request->getVar('hargaID');

            $db = $this->db->table('produk_harga');
            $db->select('satuan_id, produk_id, id, harga_jual, isi, barcode, harga_dasar, nama_lain');
            $db->where('id', $produkID);
            $produk = $db->get()->getRowArray();

            $db = $this->db->table('pembelian');
            $db->select('pembelian_detail.harga, produk_satuan.nama as satuan, isi');
            $db->join('pembelian_detail', 'pembelian_detail.pembelian_id = pembelian.id');
            $db->join('produk_harga', 'pembelian_detail.produk_harga_id = produk_harga.id');
            $db->join('produk_satuan', 'produk_harga.satuan_id = produk_satuan.id');
            $db->where('produk_id', $produk['produk_id']);
            $db->orderBy('pembelian.created_at', 'desc');
            $get = $db->get();
            $cek_pembelian = $get->getNumRows();
            if ($cek_pembelian > 0) {
                $pembelian = $get->getRowArray();
            } else {
                $pembelian = '';
            }

            $produk = [
                'produkID' => $this->request->getVar('id'),
                'sku' => $this->request->getVar('sku'),
                'produk' => $this->request->getVar('produk'),
                'satuanID' => $this->request->getVar('satuanID'),
                'satuan' => $this->request->getVar('satuan'),
                'satuan_harga' => $this->request->getVar('satuan_harga'),
                'satuanHarga' => $produk,
                'cek_pembelian' => $cek_pembelian,
                'pembelian' => $pembelian
            ];

            $data = [
                'data' => view('master/produk/edit_satuan_harga', $produk),

            ];

            echo json_encode($data);
        }
    }

    public function update_satuan_harga()
    {
        if ($this->request->isAJAX()) {
            $barcode = $this->request->getVar('barcode');
            $barcode_old = $this->request->getVar('barcode_old');

            if ($barcode != $barcode_old) {
                $rules = "is_unique[produk_harga.barcode]|integer";
            } else {
                $rules = "string";
            }
            $validation = \config\Services::validation();
            $validate = $this->validate([
                'barcode' => [
                    'rules' => $rules,
                    'errors' => [
                        'is_unique' => 'Barcode sudah digunakan pada produk lain.',
                        'string' => 'Barcode mengandung string',
                        'integer' => 'Barcode hanya boleh mengandung angka'

                    ]
                ],
                'satuan' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Satuan dasar harus diisi.'
                    ]
                ],
                'isi' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Isi harus diisi.'
                    ]
                ],
                'harga_jual' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'harga jual harus diisi.'
                    ]
                ],
                'harga_dasar' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Harga dasar harus diisi.'
                    ]
                ],
            ]);
            if (!$validate) {
                $data = [
                    'error' => [
                        'barcode' => $validation->getError('barcode'),
                        'satuan' => $validation->getError('satuan'),
                        'harga_dasar' => $validation->getError('harga_dasar'),
                        'harga_jual' => $validation->getError('harga_jual'),
                    ]
                ];
            } else {

                $id = $this->request->getVar('id');

                $data = [
                    'nama_lain' => empty($this->request->getVar('nama_lain')) ? NULL : $this->request->getVar('nama_lain'),
                    'barcode' => empty($this->request->getVar('barcode')) ? NULL : $this->request->getVar('barcode'),
                    'satuan_id' => $this->request->getVar('satuan'),
                    'isi' => $this->request->getVar('isi'),
                    'harga_dasar' => empty($this->request->getVar('harga_dasar')) ? 0 : str_replace(',', '', $this->request->getVar('harga_dasar')),
                    'harga_jual' => empty($this->request->getVar('harga_jual')) ? 0 : str_replace(',', '', $this->request->getVar('harga_jual')),
                    'updated_at' => date('Y-m-d H:i:s'),
                ];

                $this->produkModel->update_satuan_harga($data, $id);

                $data = [
                    'msg' => 'sukses'
                ];
                session()->setFlashdata('flashdata', 'Satuan harga berhasil diubah');
            }

            echo json_encode($data);
        }
    }

    public function delete_satuan_harga()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');

            $db = $this->db->table('produk_harga');
            $db->where('id', $id);
            $db->delete();

            $data = [
                'msg' => 'sukses'
            ];

            echo json_encode($data);
        }
    }


    public function delete()
    {
        if ($this->request->isAJAX()) {

            $id = $this->request->getVar('id');
            try {
                $db = $this->db->table('produk');
                $db->where('id', $id);
                $db->delete();
                $data = [
                    'msg' => 'sukses'
                ];
                session()->setFlashdata('pesan', 'Produk berhasil dihapus');
            } catch (\Throwable $db) {

                $data = [
                    'msg' => $db->getMessage()
                ];
                session()->setFlashdata('error', 'Produk sudah berelasi, tidak bisa dihapus!');
            }

            echo json_encode($data);
        }
    }

    public function stok()
    {
        $produk = [];
        $data = $this->produkModel->getStok();
        foreach ($data as $row) {
            $produk[] = [
                'parent' => $row,
                'harga' => $this->produkModel->stok($row['produkID']),
                'stok_in' => $this->produkModel->stok_in($row['produkID']),
                'stok_out' => $this->produkModel->stok_out($row['produkID']),

            ];
        }

        $a = [
            'produk' => $produk,
            'title' => 'stok',

        ];

        return view('master/produk/stok/index',  $a);
    }

    public function history_stok()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');

            $stok = [
                'master_stok' => $this->request->getVar('stok'),
                'stock' => $this->produkModel->history_stok($id),
                'produk' => $this->produkModel->Produk($id),
                'satuan' => $this->request->getVar('satuan')
            ];
            $data = [
                'view' => view('master/produk/stok/history', $stok)

            ];
            echo json_encode($data);
        }
    }

    public function add_stok()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');
            $produk = [
                'produk' => $this->produkModel->getProduk($id),
            ];

            $data = [
                'view' => view('master/produk/stok/add', $produk)
            ];

            echo json_encode($data);
        }
    }

    public function proccess_add_stok()
    {
        if ($this->request->isAJAX()) {
            $validation = \config\Services::validation();

            $validate = $this->validate([
                'jumlah' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Jumlah stok harus diisi.'
                    ]
                ]
            ]);

            if (!$validate) {
                $data = [
                    'error' => [
                        'jumlah' => $validation->getError('jumlah')
                    ]
                ];
            } else {
                $stok_in = $this->request->getVar('stok_in');
                $stok = $this->request->getVar('stok');
                $jumlah = $this->request->getVar('jumlah');
                $id = $this->request->getVar('id');

                $new_stok = $stok + $jumlah;
                $new_stok_in = $stok_in + $jumlah;

                $data = [
                    'stok' => $new_stok,
                    'produk_id' => $id,
                    'jumlah' => $jumlah,
                    'stok_in' => $new_stok_in,
                    'keterangan' => $this->request->getVar('keterangan')
                ];

                $this->produkModel->tambahstok($data);
                session()->setFlashdata('pesan', 'Stok berhasil ditambahkan');
            }
            echo json_encode($data);
        }
    }


    public function less_stok()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');
            $produk = [
                'produk' => $this->produkModel->pengurangan_stok_get_produk($id),
                'satuan' => $this->produkModel->satuan($id)
            ];

            $data = [
                'view' => view('master/produk/stok/less', $produk)
            ];

            echo json_encode($data);
        }
    }

    public function proccess_less_stok()
    {
        if ($this->request->isAJAX()) {
            $validation = \config\Services::validation();

            $validate = $this->validate([
                'satuan_kurang' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Satuan harus diisi.'
                    ]
                ],
                'jumlah' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Jumlah stok harus diisi.'
                    ]
                ],
                'keterangan' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Setidaknya berikan alasan.'
                    ]
                ],
            ]);
            $stok = intval($this->request->getVar('stok'));
            $jumlah = intval($this->request->getVar('jumlah'));
            $isi = intval($this->request->getVar('isi'));
            $id = $this->request->getVar('id');
            $produk_harga_id = $this->request->getVar('harga_id');

            $new_stok = ($stok - ($jumlah * $isi));

            if (!$validate) {
                $data = [
                    'error' => [
                        'jumlah' => $validation->getError('jumlah'),
                        'keterangan' => $validation->getError('keterangan'),
                        'satuan_kurang' => $validation->getError('satuan_kurang'),
                    ]
                ];
            } else if ($new_stok < $jumlah) {
                $data = [
                    'status' => 'Jumlah pengurangan terlalu besar dari stok tersedia.'
                ];
            } else {

                $data = [
                    'qty' => $this->request->getVar('jumlah'),
                    'new_stok' => $new_stok,
                    'produk_id' => $id,
                    'produk_harga_id' => $produk_harga_id,
                    'satuan_dasar' => $this->request->getVar('satuan'),
                    'jumlah' => $jumlah,
                    'isi' => $isi,
                    'keterangan' => $this->request->getVar('keterangan')
                ];

                $this->produkModel->less_stok($data);
                session()->setFlashdata('pesan', 'Stok berhasil dikurangi');
            }
            echo json_encode($data);
        }
    }

    public function supplier()
    {
        $data = [
            'title' => 'Produk ATK',
            'supplier' => $this->produkModel->getSupplier()

        ];
        return view('master/produk/supplier/index', $data);
    }

    public function create_supplier()
    {
        $data = [
            'title' => 'Produk ATK',
            'supplier' => $this->produkModel->getSupplier(),
            'validation' => \config\Services::validation()

        ];
        return view('master/produk/supplier/create', $data);
    }

    public function save_supplier()
    {
        if (!$this->validate([
            'nama' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama Perusahaan harus diisi.'
                ]
            ],
            'no_hp' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nomer Telepon harus diisi.'
                ]
            ],
            'alamat' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Alamat Perusahaan harus diisi.'
                ]
            ],
        ])) {
            return redirect()->to('create_supplier')->withInput();
        }
        $data = [
            'nama' => $this->request->getVar('nama'),
            'no_hp' => $this->request->getVar('no_hp'),
            'alamat' => $this->request->getVar('alamat'),
            'created_at' => date('Y-m-d H:i:s')
        ];
        $this->produkModel->tambah_supplier($data);
        session()->setFlashdata('pesan', 'Supplier berhasil ditambahkan');
        return redirect()->to('supplier');
    }

    public function edit_supplier($id)
    {
        $data = [
            'title' => 'Produk ATK',
            'supplier' => $this->produkModel->getSupplier($id),
            'validation' => \config\Services::validation()

        ];

        return view('master/produk/supplier/edit', $data);
    }

    public function update_supplier($id)
    {
        if (!$this->validate([
            'nama' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama Perusahaan harus diisi.'
                ]
            ],
            'no_hp' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nomer Telepon harus diisi.'
                ]
            ],
            'alamat' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Alamat Perusahaan harus diisi.'
                ]
            ],
        ])) {
            return redirect()->to('/produk/edit_supplier/' . $id)->withInput();
        }
        $data = [
            'nama' => $this->request->getVar('nama'),
            'no_hp' => $this->request->getVar('no_hp'),
            'alamat' => $this->request->getVar('alamat'),
            'created_at' => date('Y-m-d H:i:s')
        ];
        $this->produkModel->ubah_supplier($id, $data);
        session()->setFlashdata('pesan', 'Supplier berhasil diubah');
        return redirect()->to('/produk/supplier');
    }

    public function delete_supplier($id)
    {
        $this->produkModel->hapus_supplier($id);
        session()->setFlashdata('pesan', 'Supplier berhasil dihapus');
        return redirect()->to('/produk/supplier');
    }

    public function kategori()
    {
        $data = [
            'title' => 'Kategori Produk ATK',
            'kategori' => $this->produkModel->getCategori()
        ];
        return view('master/produk/kategori/index', $data);
    }
    public function ambilKategori()
    {
        if ($this->request->isAJAX()) {

            $kategori = $this->produkModel->getCategori();

            $isi = "<option value=''>--Pilih--</option>";

            foreach ($kategori as $row) :

                $isi .= "<option value='" . $row['kategoriId'] . "'>" . $row['kategori'] . "</option>";
            endforeach;

            $data = [
                'data' => $isi
            ];

            echo json_encode($data);
        }
    }

    public function create_kategori()
    {
        if ($this->request->isAJAX()) {
            $aksi = [
                'aksi' => $this->request->getPost('aksi')
            ];
            $data = [
                'data' => view('master/produk/kategori/create', $aksi)
            ];

            echo json_encode($data);
        } else {
            exit('Maaf tidak ada halaman yang bisa ditampilkan');
        }
    }

    public function save_kategori()
    {
        $data = [
            'nama' => $this->request->getVar('nama')
        ];
        $this->produkModel->tambah_kategori($data);

        session()->setFlashdata('pesan', 'Kategori ' . $data['nama'] . ' berhasil ditambahkan');
        echo json_encode($data);
    }

    public function ubah_kategori()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');
            $data = [
                'kategori' => $this->produkModel->kategoriById($id)
            ];
            $view = [
                'view' => view('master/produk/kategori/ubah', $data)
            ];

            echo json_encode($view);
        }
    }

    public function update_kategori()
    {
        $data = [
            'id' => $this->request->getVar('id'),
            'nama' => $this->request->getVar('nama')
        ];
        $this->produkModel->update_kategori($data);

        session()->setFlashdata('pesan', 'Kategori ' . $data['nama'] . ' berhasil diubah');
        echo json_encode($data);
    }

    public function delete_kategori($id)
    {
        $this->produkModel->hapus_kategori($id);
        session()->setFlashdata('pesan', 'Kategori berhasil dihapus.');
        return redirect()->to('/produk/kategori');
    }

    public function satuan()
    {
        $data = [
            'title' => 'Kategori Produk ATK',
            'satuan' => $this->produkModel->getsatuan()
        ];
        return view('master/produk/satuan/index', $data);
    }

    public function create_satuan()
    {
        if ($this->request->isAJAX()) {
            $aksi = [
                'aksi' => $this->request->getPost('aksi')
            ];
            $data = [
                'data' => view('master/produk/satuan/create', $aksi)
            ];

            echo json_encode($data);
        } else {
            exit('Maaf tidak ada halaman yang bisa ditampilkan');
        }
    }

    public function save_satuan()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'nama' => $this->request->getVar('nama')
            ];
            $this->produkModel->tambah_satuan($data);

            session()->setFlashdata('pesan', 'Satuan ' . $data['nama'] . ' berhasil ditambahkan');
            echo json_encode($data);
        }
    }

    public function edit_satuan()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');

            $data = [
                'satuan' => $this->produkModel->satuanById($id)
            ];
            $view = [
                'view' => view('master/produk/satuan/ubah', $data)
            ];

            echo json_encode($view);
        } else {
            exit('Maaf tidak ada halaman yang bisa ditampilkan');
        }
    }

    public function update_satuan()
    {
        $data = [
            'id' => $this->request->getVar('id'),
            'nama' => $this->request->getVar('nama')
        ];
        $this->produkModel->update_satuan($data);

        session()->setFlashdata('pesan', 'Satuan ' . $data['nama'] . ' berhasil diubah');
        echo json_encode($data);
    }

    public function delete_satuan($id)
    {
        $this->produkModel->hapus_satuan($id);
        session()->setFlashdata('pesan', 'Satuan berhasil dihapus.');
        return redirect()->to('/produk/satuan');
    }

    public function ambilSatuan()
    {
        if ($this->request->isAJAX()) {

            $satuan = $this->produkModel->getSatuan();

            $isi = "<option value='' selected hidden disabled>--Pilih--</option>";

            foreach ($satuan as $row) :

                $isi .= "<option value='" . $row['id'] . "' >" . $row['nama'] . "</option>";
            endforeach;

            $data = [
                'data' => $isi
            ];

            echo json_encode($data);
        }
    }
}
