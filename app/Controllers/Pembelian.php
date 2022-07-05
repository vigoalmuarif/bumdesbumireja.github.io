<?php

namespace App\Controllers;

use App\Models\ModelPedagang;
use App\Models\ModelPembelian;
use App\Models\ModelDataProdukPembelian;
use Config\Services;
use PhpParser\Builder\Function_;
use PhpParser\Node\Expr\FuncCall;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\CapabilityProfile;
use Mike42\Escpos\Printer;

class Pembelian extends BaseController
{

    public function __construct()
    {
        $this->pembelianModel = new ModelPembelian();
    }
    public function index()
    {
        $db = \config\Database::connect();
        $user = $db->table('users');

        $user = $user->getWhere(['id' => user_id()], 1)->getRowArray();

        $data = [
            'title' => 'Form Transaksi Pembelian ATK',
            'faktur' => $this->pembelianModel->buatFaktur(),
            'validation' => \config\Services::validation(),
            'user' => $user,
        ];

        return view('pembelian/index', $data);
    }

    public function list_produk()
    {
        if ($this->request->isAJAX()) {
            $keyword = [
                'keyword' => $this->request->getVar('keyword')
            ];
            $data = [
                'data' => view('pembelian/list_produk', $keyword),
            ];
            echo json_encode($data);
        }
    }
    public function produk()
    {
        if ($this->request->isAJAX()) {
            $produkID = $this->request->getVar('produkID');
            $nama = $this->request->getVar('nama');

            $produk = $this->db->table('produk');
            $produk->select('produk.nama as produk, sku, id as produkID');
            $produk->where('produk.nama', $nama);
            $produk->orWhere('produk.id', $produkID);
            $produk->orwhere('produk.sku', $nama);

            $db = $produk->get();
            $produk = $db->getRowArray();
            $hasil = $db->getNumRows();


            if ($hasil < 1) {
                $data = [
                    'error' => 'error'
                ];
            } else {
                $db = $this->db->table('produk_harga');
                $db->select('satuan_id, produk_satuan.nama as satuan');
                $db->join('produk_satuan', 'produk_satuan.id = produk_harga.satuan_id', 'left');
                $db->where('produk_id', $produk['produkID']);
                $db->groupBy('satuan_id');
                $satuan = $db->get()->getResultArray();


                $db = $this->db->table('pembelian_temp');
                $db->where('produk_id', $produkID);
                $count_produk_temp = $db->countAllResults();

                if ($count_produk_temp > 0) {
                    $db = $this->db->table('pembelian_temp');
                    $db->select('produk.nama as produk, produk.sku, produk_harga.produk_id as produkID, pembelian_temp.qty, produk_harga.satuan_id, pembelian_temp.harga_beli, sub_total, keterangan');
                    $db->join('produk_harga', 'produk_harga.id = pembelian_temp.produk_harga_id', 'left');
                    $db->join('produk', 'produk.id = pembelian_temp.produk_id', 'left');
                    $db->where('pembelian_temp.produk_id', $produkID);
                    $ambil_produk = $db->get()->getRowArray();

                    $data = [
                        'satuan' => $satuan,
                        'temp' => $ambil_produk
                    ];
                    $data = [
                        'data' => view('pembelian/produk', $data),

                    ];
                } else {
                    $data = [
                        'produk' => $produk,
                        'satuan' => $satuan,
                        'ambil' => 0
                    ];
                    $data = [
                        'data' => view('pembelian/produk', $data),

                    ];
                }
            }
            echo json_encode($data);
        }
    }

    public function list()
    {
        $request = Services::request();
        $keyword = $this->request->getVar('keyword');
        $m_produk = new ModelDataProdukPembelian($request);
        if ($request->getMethod(true) == 'POST') {
            $lists = $m_produk->get_datatables($keyword);
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $list) {
                $no++;
                $row = [];
                $row[] = $no;
                $row[] = $list->sku;
                $row[] = $list->nama;
                $row[] = "<button type='button' class='btn btn-primary btn-sm pilih-produk' onClick=\"pilihProduk('" . $list->produkID . "', '" . $list->sku . "')\">Pilih</button>";
                $data[] = $row;
            }
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $m_produk->count_all($keyword),
                "recordsFiltered" => $m_produk->count_filtered($keyword),
                "data" => $data
            ];
            echo json_encode($output);
        }
    }

    public function add_produk()
    {
        if ($this->request->isAJAX()) {

            $data = [
                'view' => view('pembelian/add_produk'),
            ];

            echo json_encode($data);
        }
    }

    public function save_produk()
    {
        if ($this->request->isAJAX()) {
            $validation = \config\Services::validation();
            $validate = $this->validate([
                'barcode' => [
                    'rules' => 'is_unique[produk.barcode]',
                    'errors' => [
                        'is_unique' => 'barcode sudah digunakan sebelumnya'
                    ]
                ],
                'sku' => [
                    'rules' => 'required|is_unique[produk.sku]',
                    'errors' => [
                        'required' => 'SKU produk harus diisi',
                        'is_unique' => 'SKU sudah ada sebelumnya'
                    ]
                ],
                'nama' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Nama produk harus diisi'
                    ]
                ],
                'satuan' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'satuan produk harus diisi'
                    ]
                ],
                'kategori' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'kategori produk harus diisi'
                    ]
                ],
                'harga_beli' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'harga beli produk harus diisi'
                    ]
                ],
                'harga_jual' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'harga jual produk harus diisi'
                    ]
                ],
                'qty' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'jumlah item produk harus diisi'
                    ]
                ],
            ]);

            if (!$validate) {
                $data = [
                    'error' => [
                        'barcode' => $validation->getError('barcode'),
                        'sku' => $validation->getError('sku'),
                        'nama' => $validation->getError('nama'),
                        'satuan' => $validation->getError('satuan'),
                        'kategori' => $validation->getError('kategori'),
                        'harga_beli' => $validation->getError('harga_beli'),
                        'harga_jual' => $validation->getError('harga_jual'),
                        'qty' => $validation->getError('qty'),
                    ]
                ];
            } else {
                $harga_beli = str_replace(",", "", $this->request->getVar('harga_beli'));
                $harga_jual = str_replace(",", "", $this->request->getVar('harga_jual'));
                if ($harga_jual < $harga_beli) {
                    $data = [
                        'status' => 'error'
                    ];
                } else {
                    $barcode = $this->request->getVar('barcode');
                    $barcode = empty($barcode) ? NULL : $barcode;
                    $data = [
                        'barcode' => $barcode,
                        'sku' => $this->request->getVar('sku'),
                        'nama' => $this->request->getVar('nama'),
                        'satuan' => $this->request->getVar('satuan'),
                        'kategori' => $this->request->getVar('kategori'),
                        'harga_beli' => $harga_beli,
                        'harga_jual' => $harga_jual,
                        'qty' => str_replace(",", "", $this->request->getVar('qty')),
                        'total' => str_replace(",", "", $this->request->getVar('harga_beli_total')),
                    ];
                    $this->pembelianModel->save_produk($data);
                }
            }
            echo json_encode($data);
        }
    }

    public function ambilKategori()
    {
        $db = $this->db->table('produk_kategori');
        $db->orderBy('nama');
        $kategori = $db->get()->getResultArray();

        $isi = '<option value="" selected disabled hidden>--Pilih--</option>';
        foreach ($kategori as $catalog) {
            $isi .= '<option value="' . $catalog['id'] . '">' . $catalog['nama'] . '</option>';
        }

        $data = [
            'isi' => $isi
        ];


        echo json_encode($data);
    }
    public function ambilSatuan()
    {
        $db = $this->db->table('produk_satuan');
        $db->orderBy('nama');
        $kategori = $db->get()->getResultArray();

        $isi = '<option value="" selected disabled hidden>--Pilih--</option>';
        foreach ($kategori as $catalog) {
            $isi .= '<option value="' . $catalog['id'] . '">' . $catalog['nama'] . '</option>';
        }

        $data = [
            'isi' => $isi
        ];


        echo json_encode($data);
    }

    public function save_temp()
    {
        if ($this->request->isAJAX()) {
            $satuan_beli = $this->request->getVar('satuan_beli');
            $produkID = $this->request->getVar('produkID');
            $sub_total = str_replace(',', '', $this->request->getVar('total'));
            $harga_satuan = str_replace(',', '', $this->request->getVar('harga_satuan'));
            $qty = $this->request->getVar('qty');
            $keterangan = $this->request->getVar('keterangan');


            if ($satuan_beli == 0 || $satuan_beli == '') {
                $data = [
                    'error' => [
                        'satuan_beli' => 'Satuan beli harus diisi.'
                    ]
                ];
            } else if ($qty == 0 || $qty == '') {
                $data = [
                    'error' => [
                        'qty' => 'Masukan jumlah pembelian produk'
                    ]
                ];
            } else if ($sub_total == 0 || $sub_total == '') {
                $data = [
                    'error' => [
                        'harga_total' => 'Masukan harga beli total'
                    ]
                ];
            } else if ($harga_satuan == 0 || $harga_satuan == '') {
                $data = [
                    'error' => [
                        'harga_satuan' => 'Masukan harga beli satuan'
                    ]
                ];
            } else  if ($harga_satuan > $sub_total) {
                $data = [
                    'error' => [
                        'lebih_besar' => 'Harga satuan tidak boleh lebih besar dari harga beli total!'
                    ]
                ];
            } else {
                $db = $this->db->table('produk_harga');
                $db->where('produk_id', $produkID);
                $db->where('satuan_id', $satuan_beli);
                $produk = $db->get()->getRowArray();


                $temp = [
                    'produk_id' => $produk['produk_id'],
                    'produk_harga_id' => $produk['id'],
                    'harga_beli' => $harga_satuan,
                    'sub_total' => $sub_total,
                    'qty' => $qty,
                    'keterangan' => empty($keterangan) ? Null : $keterangan,
                ];


                $db = $this->db->table('pembelian_temp');
                $db->where('produk_id', $produkID);
                $count_produk = $db->countAllResults();

                if ($count_produk == 0) {

                    $this->pembelianModel->save_temp($temp);
                    $data = [
                        'sukses' => 'sukses'
                    ];
                } else {
                    $this->pembelianModel->update_temp($temp, $produk);
                    $data = [
                        'sukses' => 'sukses'
                    ];
                }
            }
            echo json_encode($data);
        }
    }

    public function detail()
    {
        if ($this->request->isAJAX()) {
            $produk = $this->db->table('pembelian_temp');
            $produk->select('pembelian_temp.id as temp_id, produk.nama as produk, produk_satuan.nama as satuan, produk.satuan_id, pembelian_temp.harga_beli as harga, sub_total, pembelian_temp.qty');
            $produk->join('produk_harga', 'pembelian_temp.produk_harga_id  = produk_harga.id', 'left');
            $produk->join('produk', 'produk_harga.produk_id  = produk.id', 'left');
            $produk->join('produk_satuan', 'produk_satuan.id  = produk_harga.satuan_id', 'left');
            $produk = $produk->get()->getResultArray();

            $db = $this->db->table('pembelian_temp');
            $cart = $db->countAll();

            $data = [
                'produk' => $produk,
                'cart' => $cart
            ];

            $data = [
                'data' => view('pembelian/detail', $data)
            ];
            echo json_encode($data);
        }
    }

    public function totalBayar()
    {
        if ($this->request->isAJAX()) {

            $total_bayar = $this->pembelianModel->total_bayar();

            $data = [
                'total' => 'Rp ' . number_format($total_bayar['sub_total'], 0, ",", ",")
            ];
            echo json_encode($data);
        }
    }

    public function hapus_item()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');

            $this->pembelianModel->hapus_item($id);

            $data = [
                'data' => 'sukses'
            ];

            echo json_encode($data);
        }
    }

    public function supplier()
    {
        if ($this->request->isAJAX()) {

            $supplier = [
                'suppliers' => $this->pembelianModel->get_supplier()
            ];
            $data = [
                'view' => view('pembelian/supplier', $supplier)
            ];

            echo json_encode($data);
        }
    }
    public function tambah_supplier()
    {
        if ($this->request->isAJAX()) {


            $data = [
                'view' => view('pembelian/add_supplier')
            ];

            echo json_encode($data);
        }
    }


    public function save_supplier()
    {
        if ($this->request->isAJAX()) {
            $validation = \config\Services::validation();
            $validate = $this->validate([
                'noHp' => [
                    'rules' => 'is_unique[produk_supplier.no_hp]',
                    'errors' => [
                        'is_unique' => 'No telepon sudah digunakan sebelumnya'
                    ]
                ],
                'alamat' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Alamat produk harus diisi'

                    ]
                ],
                'namaSupplier' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Nama Supplier harus diisi'
                    ]
                ]

            ]);

            if (!$validate) {
                $data = [
                    'error' => [
                        'namaSupplier' => $validation->getError('namaSupplier'),
                        'noHp' => $validation->getError('noHp'),
                        'alamat' => $validation->getError('alamat'),
                    ]
                ];
            } else {
                $data = [
                    'nama' => $this->request->getVar('namaSupplier'),
                    'no_hp' => $this->request->getVar('noHp'),
                    'alamat' => $this->request->getVar('alamat'),
                    'created_at' => date('Y-m-d H:i:s')
                ];
                $db = $this->db->table('produk_supplier');
                $db->insert($data);
            }
            echo json_encode($data);
        }
    }

    public function pembayaran()
    {
        if ($this->request->isAJAX()) {
            $faktur = $this->request->getVar('faktur');
            $tanggal = $this->request->getVar('tanggal');
            $jenis_bayar = $this->request->getVar('jenisBayar');
            $referensi = $this->request->getVar('referensi');
            $supplier = $this->request->getVar('supplier');

            $db = $this->db->table('pembelian_temp');
            $db->select('SUM(sub_total) as total');
            $total = $db->get()->getRowArray();

            $db = $this->db->table('pembelian_temp');
            $cart = $db->countAll();

            $data = [
                'faktur' => $faktur,
                'created_at' => $tanggal,
                'pembayaran' => $jenis_bayar,
                'referensi' => $referensi,
                'supplier_id' => $supplier,
                'total' => $total
            ];
            if ($cart == 0) {
                $view = [
                    'error' => 'Tidak ada item dalam kerajang!'
                ];
            } elseif ($supplier == '') {
                $view = [
                    'error' => 'Pilih Supplier'
                ];
            } else {

                if ($jenis_bayar == 'Tunai') {

                    $view = [
                        'view' => view('pembelian/pembayaran_tunai', $data)
                    ];
                } else {
                    $view = [
                        'view' => view('pembelian/pembayaran_kredit', $data)
                    ];
                }
            }

            echo json_encode($view);
        }
    }

    public function simpan_pembayaran()
    {
        if ($this->request->isAJAX()) {

            $subtotal = str_replace(",", "", $this->request->getVar('total'));
            $diskon = str_replace(",", "", $this->request->getVar('diskon'));
            $total_bayar = $subtotal - $diskon;
            $bayar = str_replace(",", "", $this->request->getVar('bayar'));
            $faktur = $this->request->getVar('faktur');
            $supplier = $this->request->getVar('supplier');
            $supplier = empty($supplier) ? NULL : $supplier;
            $referensi = empty($supplier) ? NULL : $this->request->getVar('referensi');
            $keterangan = empty($supplier) ? NULL : $this->request->getVar('keterangan');
            $pembayaran = $this->request->getVar('pembayaran');
            if ($pembayaran == 'Tunai') {
                $rules = 'required|greater_than_equal_to[' . $total_bayar . ']';
            } else {
                $rules = 'required|less_than[' . $total_bayar . ']';
            }

            $validation = \config\Services::validation();
            $validate = $this->validate([
                'bukti' => [
                    'rules' => 'uploaded[bukti]|is_image[bukti]|mime_in[bukti,image/jpg,image/jpeg,image/png]|max_size[bukti, 5120]',
                    'errors' => [
                        'uploaded' => 'Unggah bukti pembelian.',
                        'is_image' => 'Yang anda masukan bukan gambar.',
                        'mime_in' => 'Pastikan format gambar sesuai.',
                        'max_size' => 'Gambar terlalu besar, maks. 5Mb'
                    ]
                ],
                'altBayar' => [
                    'rules' => $rules,
                    'errors' => [
                        'less_than' => 'Uang muka tidak valid.',
                        'greater_than_equal_to' => 'Pembayaran belum mencukupi.',
                        'required' => 'Masukan jumlah pembayaran!'
                    ]
                ],
            ]);

            if (!$validate) {
                $data = [
                    'error' => [
                        'bukti' => $validation->getError('bukti'),
                        'bayar' => $validation->getError('altBayar'),
                    ]
                ];
            } else {

                $fileGambar = $this->request->getFile('bukti');
                if ($fileGambar->getError() == 4) {
                    $namaGambar = NULL;
                } else {
                    $namaGambar = $fileGambar->getRandomName();
                    $fileGambar->move('img/upload/', $namaGambar);
                }

                $data = [
                    'pembayaran' => $this->request->getVar('pembayaran'),
                    'referensi' => $referensi,
                    'supplier_id' => $supplier,
                    'total' => str_replace(',', '', $this->request->getVar('total')),
                    'diskon' => empty($this->request->getVar('diskon')) ? 0 : str_replace(',', '', $this->request->getVar('diskon')),
                    'bayar' => empty($this->request->getVar('bayar')) ? 0 : str_replace(',', '', $this->request->getVar('bayar')),
                    'keterangan' => $keterangan,
                    'bukti' => $namaGambar,
                    'created_at' => date('Y-m-d', strtotime($this->request->getVar('tanggal'))) . ' ' . date('H:i:s')
                ];

                $this->pembelianModel->save_pembayaran($data, $faktur);
                $kembalian = $bayar - $total_bayar;
                $data = [
                    'data' => $faktur,
                    'status' => 'sukses',
                    'kembalian' => number_format($kembalian, 0)
                ];
            }


            echo json_encode($data);
        }
    }

    public function hapus_cart()
    {
        if ($this->request->isAJAX()) {
            $db = $this->db->table('pembelian_temp');
            $db->emptyTable();
            $data = [
                'status' => 'sukses'
            ];

            echo json_encode($data);
        }
    }

    public function list_pembelian()
    {
        $data = [
            'title' => 'Daftar hutang Penjualan',
            'list' => $this->pembelianModel->list_pembelian()
        ];

        return view('pembelian/list', $data);
    }

    public function hutang()
    {
        $data = [
            'title' => 'Daftar Hutang Pembelian',
            'hutang' => $this->pembelianModel->hutang()
        ];

        return view('pembelian/hutang', $data);
    }

    public function listHutang($id)
    {
        $db = $this->db->table('pembelian');
        $db->select('sum(bayar) as terbayar, sum(total-diskon) as totalHarga');
        $db->where('supplier_id', $id);
        $db->where('pembayaran', 'Kredit');
        $db->where('total > bayar+diskon');
        $total =  $db->get()->getRowArray();

        $data = [
            'title' => 'List Hutang',
            'list' => $this->pembelianModel->listHutangByid($id),
            'supplier' => $this->pembelianModel->supplier($id),
            'total' => $total
        ];

        return  view('pembelian/list_hutang_by_name', $data);
    }

    public function detail_pembelian()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');
            $db = $this->db->table('pembelian');
            $db->select('*, produk_supplier.nama as supplier ,sum(bayar) as terbayar, sum(total) as totalHarga, pembelian.created_at as date, diskon');
            $db->join('faktur', 'faktur.id = pembelian.faktur_id');
            $db->join('produk_supplier', 'produk_supplier.id = pembelian.supplier_id');
            $db->join('users', 'users.id = faktur.pembuat');
            $db->where('pembelian.id', $id);
            $total =  $db->get()->getRowArray();

            $db = $this->db->table('transaksi_pembelian');
            $db->select('sum(bayar) as pay');
            $db->where('pembelian_id', $id);
            $sum =  $db->get()->getRowArray();

            $data = [
                'detail' => $this->pembelianModel->detail_pembelian($id),
                'transaksi' => $this->pembelianModel->transaksiById($id),
                'total' => $total,
                'sum' => $sum,
                'aksi' => $this->request->getVar('aksi')
            ];
            $view = [
                'view' => view('pembelian/detail_pembelian', $data)
            ];

            echo json_encode($view);
        }
    }

    public function bayar_hutang()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');
            $detail = $this->pembelianModel->hutang($id);
            $data = [
                'detail' => $detail,
            ];

            $view = [
                'view' => view('pembelian/pelunasan', $data)
            ];

            echo json_encode($view);
        }
    }

    public function save_bayar_hutang()
    {
        if ($this->request->isAJAX()) {

            $id = $this->request->getVar('pembelian');
            $terbayar = str_replace(',', '', $this->request->getVar('terbayar'));
            $diskon = str_replace(',', '', $this->request->getVar('diskon'));
            $bayar = str_replace(',', '', $this->request->getVar('bayar'));
            $sub_total_harga = str_replace(',', '', $this->request->getVar('total'));
            $total_harga = $sub_total_harga - $diskon;
            $terbayar = $terbayar + $bayar;

            if ($terbayar > $total_harga) {
                $kembalian = $terbayar - $total_harga;
            } else {
                $kembalian = 0;
            }


            $pembelian = [
                'bayar' => $terbayar,
            ];



            $t_pembelian = [
                'pembelian_id' => $id,
                'bayar' => $bayar,
                'kembalian' => $kembalian,
                'kasir' => user_id(),
                'created_at' => date('Y-m-d H:i:s')
            ];

            $this->pembelianModel->pembayaran_hutang($pembelian, $t_pembelian, $id);

            $data = [
                'data' => 'sukses'
            ];
            session()->setFlashdata('sukses', 'Pembayaran berhasil');
            echo json_encode($data);
        }
    }
    public function delete_pembayaran_hutang()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');
            $pembelian_id = $this->request->getVar('pembelian_id');
            $totalbayar = $this->request->getVar('totalBayar');
            $bayar = str_replace(',', '', $this->request->getVar('bayar'));
            $new_total_bayar = intval($totalbayar) - intval($bayar);

            $this->pembelianModel->delete_pembayaran($id, $pembelian_id, $new_total_bayar);

            session()->setFlashdata('sukses', 'Pembayaran berhasil');
            $data = [
                'data' => 'sukses'
            ];
            session()->setFlashdata('sukses', 'Pembayaran berhasil dihapus');
            echo json_encode($data);
        }
    }

    public function cetakStruk()
    {
        function buatBaris1Kolom($kolom1)
        {
            // Mengatur lebar setiap kolom (dalam satuan karakter)
            $lebar_kolom_1 = 40;

            // Melakukan wordwrap(), jadi jika karakter teks melebihi lebar kolom, ditambahkan \n 
            $kolom1 = wordwrap($kolom1, $lebar_kolom_1, "\n", true);

            // Merubah hasil wordwrap menjadi array, kolom yang memiliki 2 index array berarti memiliki 2 baris (kena wordwrap)
            $kolom1Array = explode("\n", $kolom1);

            // Mengambil jumlah baris terbanyak dari kolom-kolom untuk dijadikan titik akhir perulangan
            $jmlBarisTerbanyak = count($kolom1Array);

            // Mendeklarasikan variabel untuk menampung kolom yang sudah di edit
            $hasilBaris = array();

            // Melakukan perulangan setiap baris (yang dibentuk wordwrap), untuk menggabungkan setiap kolom menjadi 1 baris 
            for ($i = 0; $i < $jmlBarisTerbanyak; $i++) {

                // memberikan spasi di setiap cell berdasarkan lebar kolom yang ditentukan, 
                $hasilKolom1 = str_pad((isset($kolom1Array[$i]) ? $kolom1Array[$i] : ""), $lebar_kolom_1, " ");

                // Menggabungkan kolom tersebut menjadi 1 baris dan ditampung ke variabel hasil (ada 1 spasi disetiap kolom)
                $hasilBaris[] = $hasilKolom1;
            }

            // Hasil yang berupa array, disatukan kembali menjadi string dan tambahkan \n disetiap barisnya.
            return implode("\n", $hasilBaris) . "\n";
        }

        function buatBaris3Kolom($kolom1, $kolom2, $kolom3)
        {
            // Mengatur lebar setiap kolom (dalam satuan karakter)
            $lebar_kolom_1 = 13;
            $lebar_kolom_2 = 13;
            $lebar_kolom_3 = 13;

            // Melakukan wordwrap(), jadi jika karakter teks melebihi lebar kolom, ditambahkan \n 
            $kolom1 = wordwrap($kolom1, $lebar_kolom_1, "\n", true);
            $kolom2 = wordwrap($kolom2, $lebar_kolom_2, "\n", true);
            $kolom3 = wordwrap($kolom3, $lebar_kolom_3, "\n", true);

            // Merubah hasil wordwrap menjadi array, kolom yang memiliki 2 index array berarti memiliki 2 baris (kena wordwrap)
            $kolom1Array = explode("\n", $kolom1);
            $kolom2Array = explode("\n", $kolom2);
            $kolom3Array = explode("\n", $kolom3);

            // Mengambil jumlah baris terbanyak dari kolom-kolom untuk dijadikan titik akhir perulangan
            $jmlBarisTerbanyak = max(count($kolom1Array), count($kolom2Array), count($kolom3Array));

            // Mendeklarasikan variabel untuk menampung kolom yang sudah di edit
            $hasilBaris = array();

            // Melakukan perulangan setiap baris (yang dibentuk wordwrap), untuk menggabungkan setiap kolom menjadi 1 baris 
            for ($i = 0; $i < $jmlBarisTerbanyak; $i++) {

                // memberikan spasi di setiap cell berdasarkan lebar kolom yang ditentukan, 
                $hasilKolom1 = str_pad((isset($kolom1Array[$i]) ? $kolom1Array[$i] : ""), $lebar_kolom_1, " ");
                // memberikan rata kanan pada kolom 3 dan 4 karena akan kita gunakan untuk harga dan total harga
                $hasilKolom2 = str_pad((isset($kolom2Array[$i]) ? $kolom2Array[$i] : ""), $lebar_kolom_2, " ", STR_PAD_LEFT);

                $hasilKolom3 = str_pad((isset($kolom3Array[$i]) ? $kolom3Array[$i] : ""), $lebar_kolom_3, " ", STR_PAD_LEFT);

                // Menggabungkan kolom tersebut menjadi 1 baris dan ditampung ke variabel hasil (ada 1 spasi disetiap kolom)
                $hasilBaris[] = $hasilKolom1 . " " . $hasilKolom2 . " " . $hasilKolom3;
            }

            // Hasil yang berupa array, disatukan kembali menjadi string dan tambahkan \n disetiap barisnya.
            return implode("\n", $hasilBaris) . "\n";
        }
        function tablePembayaran($kolom1, $kolom2)
        {
            // Mengatur lebar setiap kolom (dalam satuan karakter)
            $lebar_kolom_1 = 20;
            $lebar_kolom_2 = 20;


            // Melakukan wordwrap(), jadi jika karakter teks melebihi lebar kolom, ditambahkan \n 
            $kolom1 = wordwrap($kolom1, $lebar_kolom_1, "\n", true);
            $kolom2 = wordwrap($kolom2, $lebar_kolom_2, "\n", true);

            // Merubah hasil wordwrap menjadi array, kolom yang memiliki 2 index array berarti memiliki 2 baris (kena wordwrap)
            $kolom1Array = explode("\n", $kolom1);
            $kolom2Array = explode("\n", $kolom2);

            // Mengambil jumlah baris terbanyak dari kolom-kolom untuk dijadikan titik akhir perulangan
            $jmlBarisTerbanyak = max(count($kolom1Array), count($kolom2Array));

            // Mendeklarasikan variabel untuk menampung kolom yang sudah di edit
            $hasilBaris = array();

            // Melakukan perulangan setiap baris (yang dibentuk wordwrap), untuk menggabungkan setiap kolom menjadi 1 baris 
            for ($i = 0; $i < $jmlBarisTerbanyak; $i++) {

                // memberikan spasi di setiap cell berdasarkan lebar kolom yang ditentukan, 
                $hasilKolom1 = str_pad((isset($kolom1Array[$i]) ? $kolom1Array[$i] : ""), $lebar_kolom_1, " ", STR_PAD_RIGHT);
                // memberikan rata kanan pada kolom 3 dan 4 karena akan kita gunakan untuk harga dan total harga
                $hasilKolom2 = str_pad((isset($kolom2Array[$i]) ? $kolom2Array[$i] : ""), $lebar_kolom_2, " ", STR_PAD_LEFT);

                // Menggabungkan kolom tersebut menjadi 1 baris dan ditampung ke variabel hasil (ada 1 spasi disetiap kolom)
                $hasilBaris[] = $hasilKolom1 . " " . $hasilKolom2;
            }

            // Hasil yang berupa array, disatukan kembali menjadi string dan tambahkan \n disetiap barisnya.
            return implode("\n", $hasilBaris) . "\n";
        }

        function tableData($kolom1, $kolom2)
        {
            // Mengatur lebar setiap kolom (dalam satuan karakter)
            $lebar_kolom_1 = 10;
            $lebar_kolom_2 = 30;


            // Melakukan wordwrap(), jadi jika karakter teks melebihi lebar kolom, ditambahkan \n 
            $kolom1 = wordwrap($kolom1, $lebar_kolom_1, "\n", true);
            $kolom2 = wordwrap($kolom2, $lebar_kolom_2, "\n", true);

            // Merubah hasil wordwrap menjadi array, kolom yang memiliki 2 index array berarti memiliki 2 baris (kena wordwrap)
            $kolom1Array = explode("\n", $kolom1);
            $kolom2Array = explode("\n", $kolom2);

            // Mengambil jumlah baris terbanyak dari kolom-kolom untuk dijadikan titik akhir perulangan
            $jmlBarisTerbanyak = max(count($kolom1Array), count($kolom2Array));

            // Mendeklarasikan variabel untuk menampung kolom yang sudah di edit
            $hasilBaris = array();

            // Melakukan perulangan setiap baris (yang dibentuk wordwrap), untuk menggabungkan setiap kolom menjadi 1 baris 
            for ($i = 0; $i < $jmlBarisTerbanyak; $i++) {

                // memberikan spasi di setiap cell berdasarkan lebar kolom yang ditentukan, 
                $hasilKolom1 = str_pad((isset($kolom1Array[$i]) ? $kolom1Array[$i] : ""), $lebar_kolom_1, " ", STR_PAD_RIGHT);
                // memberikan rata kanan pada kolom 3 dan 4 karena akan kita gunakan untuk harga dan total harga
                $hasilKolom2 = str_pad((isset($kolom2Array[$i]) ? $kolom2Array[$i] : ""), $lebar_kolom_2, " ", STR_PAD_RIGHT);

                // Menggabungkan kolom tersebut menjadi 1 baris dan ditampung ke variabel hasil (ada 1 spasi disetiap kolom)
                $hasilBaris[] = $hasilKolom1 . " " . $hasilKolom2;
            }

            // Hasil yang berupa array, disatukan kembali menjadi string dan tambahkan \n disetiap barisnya.
            return implode("\n", $hasilBaris) . "\n";
        }
        $db = $this->db->table('printer');
        $db->orderBy('id', 'asc');
        $db->limit(1);
        $s_printer =  $db->get()->getRowArray();

        $profile = CapabilityProfile::load("simple");
        $connector = new WindowsPrintConnector($s_printer['printer']);
        $printer = new Printer($connector, $profile);


        $faktur = $this->request->getVar('faktur');

        $db = $this->db->table('pembelian');
        $db->select('*,pembelian.created_at as date, produk_supplier.nama as supplier, pembelian.id as pembelianID');
        $db->join('faktur', 'faktur.id = pembelian.faktur_id', 'left');
        $db->join('produk_supplier', 'produk_supplier.id = pembelian.supplier_id', 'left');
        $db->join('users', 'users.id = faktur.pembuat', 'left');
        $db->where('faktur', $faktur);
        $pembelian = $db->get()->getRowArray();

        $printer->initialize();

        $printer->selectPrintMode(Printer::MODE_DOUBLE_HEIGHT);
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->text($s_printer['nama_toko']);
        $printer->setLineSpacing(45);
        $printer->text("\n");

        $printer->initialize();
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->text($s_printer['alamat']);
        $printer->setLineSpacing(50);
        $printer->text("\n");

        $printer->initialize();
        $printer->setLineSpacing(25);
        $printer->text(tableData("Faktur", ": $faktur"));
        $printer->text(tableData("Kasir", ": $pembelian[username]"));
        $printer->text(tableData("Supplier", ": $pembelian[supplier]"));
        $printer->text(tableData("Referensi", ": $pembelian[referensi]"));
        $printer->text(tableData("pembayaran", ": $pembelian[pembayaran]|" . date('d-m-Y H:i', strtotime($pembelian['date']))));
        $printer->text(buatBaris1Kolom("----------------------------------------"));


        $db = $this->db->table('pembelian');
        $db->select('pembelian.created_at as date, produk.nama as produk, produk_satuan.nama as unit, pembelian_detail.qty, harga, sub_total, sku');
        $db->join('faktur', 'faktur.id = pembelian.faktur_id', 'left');
        $db->join('pembelian_detail', 'pembelian_detail.pembelian_id = pembelian.id');
        $db->join('produk_harga', 'produk_harga.id = pembelian_detail.produk_harga_id', 'left');
        $db->join('produk', 'produk.id = produk_harga.produk_id', 'left');
        $db->join('produk_satuan', 'produk_satuan.id = produk_harga.satuan_id', 'left');
        $db->where('faktur', $faktur);
        $item = $db->get()->getResultArray();

        $printer->initialize();
        $printer->setFont(Printer::FONT_B);
        $printer->setLineSpacing(45);
        $totalPembayaran = 0;
        foreach ($item as $row) {
            $printer->text(buatBaris1Kolom("$row[sku]-$row[produk]"));
            $printer->text(buatBaris3Kolom("$row[qty] $row[unit]", number_format($row['harga'], 0, ",", ","), number_format($row['sub_total'], 0, ",", ",")));

            $totalPembayaran += $row['sub_total'];
        }
        $diskon = $pembelian['diskon'];
        $total_bayar = $pembelian['total'] - $pembelian['diskon'];
        $kembalian = $pembelian['bayar'] - $total_bayar;
        $kekurangan = $total_bayar - $pembelian['bayar'];
        $printer->text(buatBaris1Kolom("----------------------------------------"));
        $printer->initialize();
        $printer->setFont(Printer::FONT_B);
        $printer->setLineSpacing(30);
        $printer->text(buatBaris3Kolom("", "Sub Total :", number_format($totalPembayaran, 0, ",", ",")));
        $printer->text(buatBaris3Kolom("", "Diskon :", number_format($diskon, 0, ",", ",")));
        $printer->text(buatBaris3Kolom("", "Total :", number_format($total_bayar, 0, ",", ",")));
        $printer->text(buatBaris3Kolom("", "Bayar :", number_format($pembelian['bayar'], 0, ",", ",")));
        $printer->text(buatBaris3Kolom("", "Kembalian :", number_format($kembalian <= 0 ? 0 : $kembalian, 0, ",", ",")));
        $printer->text(buatBaris3Kolom("", "kekurangan :", number_format($kekurangan <= 0 ? 0 : $kekurangan, 0, ",", ",")));
        $printer->initialize();
        $printer->text(buatBaris1Kolom("----------------------------------------"));
        $printer->text("\n");


        $db = $this->db->table('transaksi_pembelian');
        $db->where('pembelian_id', $pembelian['pembelianID']);
        $count = $db->countAllresults();

        if ($count > 1) {

            $db = $this->db->table('transaksi_pembelian');
            $db->where('pembelian_id', $pembelian['pembelianID']);
            $pembayaran = $db->get()->getResultArray();
            $totalBayar = 0;
            foreach ($pembayaran as $row) {
                $printer->text(tablePembayaran(date('d/m/Y H:i', strtotime($row['created_at'])), number_format($row['bayar'], 0, ",", ",")));
                $totalBayar += $row['bayar'];
            }
            $printer->text(tablePembayaran('Total', number_format($totalBayar, 0, ",", ",")));
            $printer->initialize();
            $printer->text(buatBaris1Kolom("----------------------------------------"));
        }
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->text("Faktur Pembelian");
        $printer->text("\n");
        $printer->text("@BUMDes Karsa Mandiri");


        $printer->feed(4);
        $printer->cut();
        $printer->close();

        $msg = [
            'print' => 'sukses'
        ];
        echo json_encode($msg);
    }
}
