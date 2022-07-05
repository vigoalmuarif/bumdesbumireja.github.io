<?php

namespace App\Controllers;

use App\Models\ModelPedagang;
use App\Models\ModelPenjualan;
use App\Models\ModelDataProduk;
use Config\Services;
use PhpParser\Builder\Function_;
use PhpParser\Node\Expr\FuncCall;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\CapabilityProfile;
use Mike42\Escpos\Printer;
use PhpParser\Node\Expr\Print_;

class Penjualan extends BaseController
{

    public function __construct()
    {
        $this->penjualanModel = new ModelPenjualan();
    }
    public function index()
    {
        $db = \config\Database::connect();
        $user = $db->table('users');
        $user = $user->getWhere(['id' => user_id()], 1)->getRowArray();
        $data = [
            'title' => 'Form Transaksi Penjualan ATK',
            'faktur' => $this->penjualanModel->buatFaktur(),
            'validation' => \config\Services::validation(),
            'user' => $user
        ];

        return view('penjualan/index', $data);
    }

    public function detailPenjualan()
    {
        $db = $this->db->table('penjualan_temp');
        $cart = $db->countAll();
        $data = [
            'detail' => $this->penjualanModel->detail_penjualan(),
            'cart' => $cart
        ];
        $view = [
            'data' => view('penjualan/detail', $data),

        ];
        echo  json_encode($view);
    }

    public function produk()
    {
        if ($this->request->isAJAX()) {
            $keyword = [
                'keyword' => $this->request->getVar('keyword')
            ];
            $data = [
                'data' => view('penjualan/produk', $keyword),
            ];
            echo json_encode($data);
        }
    }

    public function list()
    {
        $request = Services::request();
        $keyword = $this->request->getVar('keyword');
        $m_produk = new ModelDataProduk($request);
        if ($request->getMethod(true) == 'POST') {
            $lists = $m_produk->get_datatables($keyword);
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $list) {
                $no++;
                $row = [];
                $row[] = $no;
                $row[] = $list->sku;
                $row[] = empty($list->nama_lain) ? $list->produk : $list->nama_lain;
                $row[] = strtoupper($list->satuan);
                $row[] = '<div class="text-' . (intval($list->qty / $list->isi) == 0 ? 'danger' : '') . '">' . intval($list->qty / $list->isi) . '</div>';
                $row[] = number_format($list->harga_dasar, 0, ",", ",");
                $row[] = number_format($list->harga_jual, 0, ",", ",");
                $row[] = "<button type='button' class='btn btn-primary btn-sm' onClick=\"pilihProduk('" . $list->produk_satuan .  "', '" . $list->produkID . "', '" . $list->barcode .  "', '" . $list->sku . "', '" . $list->produk . "', '" . $list->satuan_id . "', '" . intval($list->qty / $list->isi) . "', '" . $list->isi . "', '" . $list->qty . "', '" . intval($list->harga_dasar) . "', '" . intval($list->harga_jual) . "', '" . $list->satuan .  "', '" . $list->nama_lain .  "')\">Pilih</button>";
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

    public function pelanggan()
    {
        if ($this->request->isAJAX()) {

            $db = $this->db->table('customer_atk');
            $pelanggan['pelanggan'] = $db->get()->getResultArray();

            $data = [
                'view' => view('penjualan/pelanggan', $pelanggan),
            ];
            echo json_encode($data);
        }
    }

    public function save_temp()
    {
        if ($this->request->isAJAX()) {
            $produk_id = $this->request->getVar('produkId');
            $produk_satuan = $this->request->getVar('produkSatuan');
            $satuanID = $this->request->getVar('satuanID');
            $satuan = $this->request->getVar('satuan');
            $stok = $this->request->getVar('stok');
            $total_stok = $this->request->getVar('totalStok');
            $isi = $this->request->getVar('isi');
            $qty = $this->request->getVar('qty');
            $faktur = $this->request->getVar('faktur');

            $data = [
                'produk_id' => $produk_id,
                'produk_harga_id' => $produk_satuan,
                'faktur' => $faktur,
                'qty' => $qty,
            ];



            $db = $this->db->table('penjualan_temp');
            $db->where('produk_harga_id', $data['produk_harga_id']);
            $count_produk_temp = $db->countAllResults();
            // var_dump($produk_satuan);
            // die;
            $db = $this->db->table('penjualan_temp');
            $db->select('sum(penjualan_temp.qty * produk_harga.isi) as qty_cart');
            $db->join('produk_harga', 'produk_harga.id = penjualan_temp.produk_harga_id');
            $db->where('penjualan_temp.produk_id', $produk_id);
            $cek_stok = $db->get()->getRowArray();
            $i = intval($total_stok) - intval($cek_stok['qty_cart']);
            $new_stok = intval($i) / intval($isi);

            $db = $this->db->table('produk_harga');
            $db->select('produk_satuan.nama as satuan, isi');
            $db->join('produk_satuan', 'produk_satuan.id = produk_harga.satuan_id');
            $db->orderBy('isi', 'desc');
            $db->where('produk_id', $produk_id);
            $satuan_dasar = $db->get()->getResultArray();
            $get = '';
            foreach ($satuan_dasar as $row) {

                $get .= ', ' . intval($i / $row['isi']) . ' ' . $row['satuan'];
            }


            if ($stok == 0) {
                $hasil = [
                    'error' => 'Produk Tidak Tersedia!'
                ];
            } else if ($new_stok < $qty) {
                $hasil = [
                    'error' => 'Stok tidak mencukupi. <br/>' . 'Stok saat ini' . '<b>' . $get . '</b>'
                ];
            } elseif ($stok < $qty) {
                $hasil = [
                    'error' => 'Produk tidak Mencukupi!'
                ];
            } elseif ($qty == 0) {
                $hasil = [
                    'error' => 'Masukan Jumlah Produk yang dibeli!'
                ];
            } else

            if ($count_produk_temp == 0) {
                $this->penjualanModel->insert_produk_temp($data);
                $hasil = [
                    'data' => 'sukses'
                ];
            } else {

                $db = $this->db->table('penjualan_temp');
                $db->select('penjualan_temp.qty as qty_cart');
                $db->where('penjualan_temp.produk_harga_id', $produk_satuan);
                $cek_stok = $db->get()->getRowArray();
                $this->penjualanModel->update_produk_temp($data, $cek_stok['qty_cart']);

                $hasil = [
                    'data' => 'sukses'
                ];
            }
            echo json_encode($hasil);
        }
    }

    public function totalBayar()
    {
        if ($this->request->isAJAX()) {
            $faktur = $this->request->getVar('faktur');

            $builder = $this->db->table('penjualan_temp')
                ->select('SUM(sub_total) as total');
            $total = $builder->get()->getRowArray();

            $data = [
                'total' => 'Rp ' . number_format($total['total'], 0, ",", ","),
                'totalBayar' => number_format($total['total'], 0, ",", ",")
            ];

            echo json_encode($data);
        }
    }

    public function hapusItem()
    {
        if ($this->request->isAJAX()) {

            $temp_id = $this->request->getVar('temp_id');

            // cari id produk berdasarkan $produk_id


            $this->penjualanModel->hapus_item($temp_id);
            $data = [
                'data' => 'sukses'
            ];

            echo json_encode($data);
        }
    }

    public function batal_transaksi()
    {
        if ($this->request->isAJAX()) {

            $db = $this->db->table('penjualan_temp');
            $db->emptyTable();


            $data = [
                'data' => 'sukses'
            ];

            echo json_encode($data);
        }
    }

    public function pembayaran_tunai()
    {
        if ($this->request->isAJAX()) {
            $faktur = $this->request->getVar('faktur');
            $tanggal = $this->request->getVar('tanggal');
            $pelanggan = $this->request->getVar('pelanggan');
            $pembayaran = $this->request->getVar('pembayaran');

            $db = $this->db->table('penjualan_temp');
            $count_temp = $db->countAllResults();

            if ($count_temp > 0) {

                $db = \config\Database::connect();
                $builder = $db->table('penjualan_temp')
                    ->select('SUM(sub_total) as total');
                $total = $builder->get()->getRowArray();

                $d = [
                    'faktur' => $faktur,
                    'total' => $total['total'],
                    'tanggal' => $tanggal,
                    'pelanggan' => $pelanggan,
                    'pembayaran' => $pembayaran
                ];
                $data = [
                    'view' => view('penjualan/pembayaran', $d)
                ];
            } else {
                $data = [
                    'error' => 'Tidak ada data untuk disimpan'
                ];
            }



            echo json_encode($data);
        }
    }

    public function pembayaran_hutang()
    {
        if ($this->request->isAJAX()) {
            $faktur = $this->request->getVar('faktur');
            $tanggal = $this->request->getVar('tanggal');
            $pelanggan = $this->request->getVar('pelanggan');
            $pembayaran = $this->request->getVar('pembayaran');


            $db = $this->db->table('penjualan_temp');
            $count_temp = $db->countAllResults();

            if ($count_temp > 0) {

                $db = \config\Database::connect();
                $builder = $db->table('penjualan_temp')
                    ->select('SUM(sub_total) as total');
                $total = $builder->get()->getRowArray();

                if (!empty($pelanggan)) {

                    $d = [
                        'faktur' => $faktur,
                        'total' => $total['total'],
                        'tanggal' => $tanggal,
                        'pelanggan' => $pelanggan,
                        'pembayaran' => $pembayaran
                    ];
                    $data = [
                        'view' => view('penjualan/pembayaran_hutang', $d)
                    ];
                } else {
                    $data = [
                        'error' => 'Pelanggan harus diisi!'
                    ];
                }
            } else {
                $data = [
                    'error' => 'Tidak ada data untuk disimpan'
                ];
            }



            echo json_encode($data);
        }
    }

    public function simpan_pembayaran()
    {
        if ($this->request->isAJAX()) {
            $faktur = $this->request->getVar('faktur');
            $pelanggan = $this->request->getVar('pelanggan');
            $bayar = str_replace(',', '', $this->request->getVar('bayar'));
            $total = str_replace(',', '', $this->request->getVar('total'));
            $pembayaran = $this->request->getVar('pembayaran');
            $tanggal = $this->request->getVar('tanggal') . ' ' . date('H:i:s');
            $keterangan = $this->request->getVar('keterangan');
            if ($pembayaran == 'Kredit') {
                $kembali = 0;
            } else {
                $kembali = $bayar - $total;
            }

            $data = [
                'customer_id' => $pelanggan,
                'bayar' => $bayar,
                'total' => $total,
                'pembayaran' => $pembayaran,
                'kembali' => $kembali,
                'created_at' => date('Y-m-d H:i:s', strtotime($tanggal)),
                'keterangan' => $keterangan
            ];
            // var_dump($pembayaran);

            $this->penjualanModel->simpan_pembayaran($data, $faktur);

            if ($pembayaran == 'Kredit') {
                $kekurangan = intval($total) - intval($bayar);
                $data = [
                    'title' => 'Kekurangan',
                    'jumlah' => 'Rp ' . number_format($kekurangan, 0),
                    'faktur' => $faktur
                ];
            } else {
                $kembalian = intval($bayar) - intval($total);
                $data = [
                    'title' => 'Kembalian',
                    'jumlah' => 'Rp ' . number_format($kembalian, 0),
                    'faktur' => $faktur
                ];
            }
            echo json_encode($data);
        }
    }

    public function piutang()
    {
        $data = [
            'title' => 'Daftar Piutang Penjualan',
            'piutang' => $this->penjualanModel->piutang()
        ];

        return view('penjualan/piutang', $data);
    }

    public function listPiutang($id)
    {
        $db = $this->db->table('penjualan');
        $db->select('sum(bayar) as terbayar, sum(total) as totalHarga');
        $db->where('customer_id', $id);
        $db->where('pembayaran', 'Kredit');
        $db->where('total > bayar');
        $total =  $db->get()->getRowArray();

        $data = [
            'title' => 'List Piutang',
            'list' => $this->penjualanModel->listPiutangByid($id),
            'customer' => $this->penjualanModel->customer($id),
            'total' => $total
        ];

        return  view('penjualan/list_piutang_by_name', $data);
    }

    public function detail_penjualan()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');
            $db = $this->db->table('penjualan');
            $db->select('*,sum(bayar) as terbayar, sum(total) as totalHarga, penjualan.created_at as date');
            $db->join('faktur', 'faktur.id = penjualan.faktur_id');
            $db->join('customer_atk', 'customer_atk.id = penjualan.customer_id');
            $db->join('users', 'users.id = faktur.pembuat');
            $db->where('penjualan.id', $id);
            $total =  $db->get()->getRowArray();

            $db = $this->db->table('transaksi_penjualan');
            $db->select('sum(bayar) as pay');
            $db->where('penjualan_id', $id);
            $sum =  $db->get()->getRowArray();

            $data = [
                'detail' => $this->penjualanModel->det_penjualan($id),
                'transaksi' => $this->penjualanModel->transaksiById($id),
                'total' => $total,
                'sum' => $sum,
                'aksi' => $this->request->getVar('aksi')
            ];
            $view = [
                'view' => view('penjualan/detail_penjualan', $data)
            ];

            echo json_encode($view);
        }
    }
    public function bayar_piutang()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');
            $detail = $this->penjualanModel->piutang($id);
            $data = [
                'detail' => $detail,
            ];

            $view = [
                'view' => view('penjualan/pelunasan', $data)
            ];

            echo json_encode($view);
        }
    }

    public function save_bayar_piutang()
    {
        if ($this->request->isAJAX()) {

            $id = $this->request->getVar('penjualan');
            $terbayar = str_replace(',', '', $this->request->getVar('terbayar'));
            $bayar = str_replace(',', '', $this->request->getVar('bayar'));
            $total = str_replace(',', '', $this->request->getVar('total'));


            $totalbayar = $terbayar + $bayar;

            if ($totalbayar > $total) {
                $kembali = $totalbayar - $total;
            } else {
                $kembali = 0;
            }

            $penjualan = [
                'bayar' => $totalbayar,
            ];

            $t_penjualan = [
                'penjualan_id' => $id,
                'bayar' => $bayar,
                'kembalian' => $kembali,
                'kasir' => user_id(),
                'created_at' => date('Y-m-d H:i:s')
            ];

            $this->penjualanModel->pembayaran_piutang($penjualan, $t_penjualan, $id);

            $data = [
                'data' => 'sukses'
            ];
            session()->setFlashdata('sukses', 'Pembayaran berhasil');
            echo json_encode($data);
        }
    }

    public function delete_pembayaran_piutang()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');
            $penjualan_id = $this->request->getVar('penjualan_id');
            $totalbayar = $this->request->getVar('totalBayar');
            $bayar = str_replace(',', '', $this->request->getVar('bayar'));
            $new_total_bayar = intval($totalbayar) - intval($bayar);

            $this->penjualanModel->delete_pembayaran($id, $penjualan_id, $new_total_bayar);

            session()->setFlashdata('sukses', 'Pembayaran berhasil');
            $data = [
                'data' => 'sukses'
            ];
            session()->setFlashdata('sukses', 'Pembayaran berhasil dihapus');
            echo json_encode($data);
        }
    }

    public function riwayat_penjualan()
    {
        if (isset($_GET['kirim'])) {
            if (!$this->validate([
                'mulai' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Masukan tanggal mulai'
                    ],
                ],
                'sampai' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Masukan tanggal sampai'
                    ],
                ],
            ])) {
                return redirect()->to('/penjualan/riwayat_penjualan')->withInput();
            } else {
                $mulai = $this->request->getVar('alternatif1');
                $sampai = $this->request->getVar('alternatif2');
                $validation = \config\Services::validation();
                $data = [
                    'title' => 'Riwayat Penjualan',
                    'validation' => $validation,
                    'penjualan' => $this->penjualanModel->penjualan_search($mulai, $sampai),
                    'mulai' => $mulai,
                    'sampai' => $sampai

                ];
                return view('penjualan/riwayat_penjualan', $data);
            }
        } else {
            $validation = \config\Services::validation();
            $data = [
                'title' => 'Riwayat Penjualan',
                'validation' => $validation

            ];
            return view('penjualan/riwayat_penjualan', $data);
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

        $db = $this->db->table('penjualan');
        $db->select('*,penjualan.created_at as date, customer_atk.nama as customer, bayar, total, penjualan.id as penjualanID');
        $db->join('faktur', 'faktur.id = penjualan.faktur_id', 'left');
        $db->join('customer_atk', 'customer_atk.id = penjualan.customer_id', 'left');
        $db->join('users', 'users.id = faktur.pembuat', 'left');
        $db->where('faktur', $faktur);
        $penjualan = $db->get()->getRowArray();

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
        $printer->text(tableData("Pelanggan", ": $penjualan[customer]"));
        $printer->text(tableData("pembayaran", ": $penjualan[pembayaran]|" . date('d-m-Y H:i', strtotime($penjualan['date']))));
        $printer->text(buatBaris1Kolom("----------------------------------------"));


        $db = $this->db->table('penjualan');
        $db->select('penjualan.created_at as date, produk.nama as produk, produk_satuan.nama as unit, penjualan_detail.qty, harga, sub_total, sku, nama_lain');
        $db->join('faktur', 'faktur.id = penjualan.faktur_id', 'left');
        $db->join('penjualan_detail', 'penjualan_detail.penjualan_id = penjualan.id');
        $db->join('produk_harga', 'produk_harga.id = penjualan_detail.produk_harga_id', 'left');
        $db->join('produk', 'produk.id = produk_harga.produk_id', 'left');
        $db->join('produk_satuan', 'produk_satuan.id = produk_harga.satuan_id', 'left');
        $db->where('faktur', $faktur);
        $item = $db->get()->getResultArray();

        $printer->initialize();
        $printer->setFont(Printer::FONT_B);
        $printer->setLineSpacing(45);
        $totalPembayaran = 0;
        foreach ($item as $row) {
            $printer->text(buatBaris1Kolom("$row[sku]-" . (empty($row['nama_lain']) ? "$row[produk]" : "$row[nama_lain]")));
            $printer->text(buatBaris3Kolom("$row[qty] $row[unit]", number_format($row['harga'], 0, ",", ","), number_format($row['sub_total'], 0, ",", ",")));

            $totalPembayaran += $row['sub_total'];
        }
        $kembalian = $penjualan['bayar'] - $penjualan['total'];
        $kekurangan = $penjualan['total'] - $penjualan['bayar'];
        $printer->text(buatBaris1Kolom("----------------------------------------"));
        $printer->initialize();
        $printer->setFont(Printer::FONT_B);
        $printer->setLineSpacing(30);
        $printer->text(buatBaris3Kolom("", "Total :", number_format($totalPembayaran, 0, ",", ",")));
        $printer->text(buatBaris3Kolom("", "bayar :", number_format($penjualan['bayar'], 0, ",", ",")));
        $printer->text(buatBaris3Kolom("", "Kembalian :", number_format($kembalian <= 0 ? 0 : $kembalian, 0, ",", ",")));
        $printer->text(buatBaris3Kolom("", "kekurangan :", number_format($kekurangan <= 0 ? 0 : $kekurangan, 0, ",", ",")));
        $printer->initialize();
        $printer->text(buatBaris1Kolom("----------------------------------------"));
        $printer->text("\n");

        $db = $this->db->table('transaksi_penjualan');
        $db->where('penjualan_id', $penjualan['penjualanID']);
        $count = $db->countAllResults();
        if ($count > 1) {

            $db = $this->db->table('transaksi_penjualan');
            $db->where('penjualan_id', $penjualan['penjualanID']);
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
        $printer->text($s_printer['footer_1']);
        $printer->text("\n");
        $printer->text($s_printer['footer_2']);


        $printer->feed(4);
        $printer->cut();
        $printer->close();

        $msg = [
            'print' => 'sukses'
        ];
        echo json_encode($msg);
    }
}
