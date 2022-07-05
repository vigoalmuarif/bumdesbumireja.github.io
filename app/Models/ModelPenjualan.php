<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelPenjualan extends Model
{
    protected $table      = 'penjualan';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $useSoftDeletes = true;

    protected $allowedFields = [];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;


    public function dashboard()
    {
    }

    public function buatFaktur()
    {


        $sql = "SELECT MAX(MID(faktur, 9, 4)) AS faktur
        FROM faktur
        
        WHERE MID(faktur, 3, 6) = DATE_FORMAT(CURDATE(), '%d%m%y') AND jenis = 'Penjualan'";
        $query = $this->db->query($sql);

        //cek dulu apakah ada sudah ada kode di tabel.    
        if ($query->getNumRows() > 0) {
            //cek kode jika telah tersedia    
            $data = $query->getRow();
            $kode = intval($data->faktur) + 1;
        } else {
            $kode = 1;  //cek jika kode belum terdapat pada table
        }
        $tgl = date('dmy');
        $batas = str_pad($kode, 4, "0", STR_PAD_LEFT);
        $kodetampil = "PJ" . $tgl . $batas;  //format kode
        return $kodetampil;
    }


    public function detail_penjualan()
    {
        $db = \config\Database::connect();
        $builder = $db->table('penjualan_temp');
        $builder->select('penjualan_temp.id as temp_id, produk.nama as produk, sku, penjualan_temp.qty as jumlah, penjualan_temp.harga_jual as harga, penjualan_temp.sub_total, produk_satuan.nama as satuan, nama_lain');
        $builder->join('produk_harga', 'produk_harga.id = penjualan_temp.produk_harga_id', 'left');
        $builder->join('produk', 'produk.id = penjualan_temp.produk_id', 'left');
        $builder->join('produk_satuan', 'produk_satuan.id = produk_harga.satuan_id', 'left');
        // $builder->join('produk_harga', 'produk.id = produk_harga.produk_id', 'left');
        // $builder->join('faktur', 'faktur.id = penjualan_temp.faktur_id');
        // $builder->where('faktur.pembuat', user_id());
        $builder->orderBy('penjualan_temp.id', 'desc');
        return $builder->get();
    }
    public function insert_produk_temp($data)
    {
        $db = $this->db->table('produk_harga');
        $db->select('produk_harga.id as produk_harga_id, produk_harga.satuan_id as satuanID, produk_harga.harga_dasar, produk_harga.harga_jual, produk_id');
        $db->join('produk', 'produk.id = produk_harga.produk_id');
        $db->where('produk_harga.id', $data['produk_harga_id']);
        $produk = $db->get()->getRowArray();
        $sub_total = intval($produk['harga_jual'] * $data['qty']);

        $this->db->transStart();

        $db = $this->db->table('penjualan_temp'); // insert ke table penjualan_temp
        $db->insert([
            'produk_id' => $produk['produk_id'],
            'produk_harga_id' => $produk['produk_harga_id'],
            'harga_beli' => $produk['harga_dasar'],
            'harga_jual' => $produk['harga_jual'],
            'qty' => $data['qty'],
            'sub_total' => $sub_total,
        ]);

        $this->db->transComplete();

        if ($this->db->transStatus() === FALSE) {
            $this->db->transRollback();
        } else {
            $this->db->transCommit();
        }
    }

    public function update_produk_temp($data, $qty_temp)
    {
        $db = $this->db->table('produk_harga');
        $db->select('*, produk_harga.id as produk_harga');
        $db->join('produk', 'produk.id = produk_harga.produk_id');
        $db->where('produk_harga.id', $data['produk_harga_id']);
        $produk = $db->get()->getRowArray();
        $new_qty = intval($qty_temp + $data['qty']);
        $sub_total = intval($produk['harga_jual'] * $new_qty);

        $this->db->transStart();

        $db = $this->db->table('penjualan_temp');
        $db->where('produk_harga_id', $produk['produk_harga']); //faktur ambil dari yang sudah ada
        $db->update([
            'qty' => $new_qty,
            'sub_total' => $sub_total
        ]);

        $this->db->transComplete();

        if ($this->db->transStatus() === FALSE) {
            $this->db->transRollback();
        } else {
            $this->db->transCommit();
        }
    }


    public function hapus_item($data)
    {
        $this->db->transStart();

        $db = $this->db->table('penjualan_temp');
        $db->where('id', $data);
        $db->delete();

        $this->db->transComplete();

        if ($this->db->transStatus() === FALSE) {
            $this->db->transRollback();
            return false;
        } else {
            $this->db->transCommit();
            return true;
        }
    }



    public function simpan_pembayaran($data, $faktur)
    {
        $this->db->transStart();

        $db = $this->db->table('faktur');
        $db->insert([
            'faktur' => $faktur,
            'jenis' => 'Penjualan',
            'pembuat' => user_id(),
        ]);
        $faktur_id = $this->insertID();

        $db = $this->db->table('penjualan');
        $db->insert([
            'faktur_id' => $faktur_id,
            'customer_id' => $data['customer_id'],
            'bayar' => $data['bayar'],
            'total' => $data['total'],
            'pembayaran' => $data['pembayaran'],
            'created_at' => $data['created_at'],
            'keterangan' => $data['keterangan'],
        ]);
        $id = $this->insertID();

        $db = $this->db->table('transaksi_penjualan');
        $db->insert([
            'penjualan_id' => $id,
            'bayar' => $data['bayar'],
            'kembalian' => $data['kembali'],
            'kasir' => user_id(),
            'created_at' => $data['created_at']
        ]);



        $db = $this->db->table('penjualan_temp');
        $db->select('penjualan_temp.produk_id, penjualan_temp.produk_harga_id, penjualan_temp.harga_beli, penjualan_temp.harga_jual, penjualan_temp.qty as qty_jual, sub_total, produk_harga.isi, produk.qty as master_qty, produk_satuan.nama as satuan');
        $db->join('produk_harga', 'produk_harga.id = penjualan_temp.produk_harga_id');
        $db->join('produk', 'produk.id = penjualan_temp.produk_id');
        $db->join('produk_satuan', 'produk.satuan_id = produk_satuan.id');
        $db->orderBy('penjualan_temp.id', 'desc');
        $temp = $db->get()->getResultArray();
        // var_dump($temp);
        // die;

        $table_penjualan_detail = [];
        $table_produk_stok = [];


        foreach ($temp as $row) {
            $table_penjualan_detail[] = [
                'penjualan_id' => $id,
                'produk_harga_id' => $row['produk_harga_id'],
                'harga_beli' => $row['harga_beli'],
                'harga' => $row['harga_jual'],
                'qty' => $row['qty_jual'],
                'sub_total' => $row['sub_total'],
            ];
            $table_produk_stok[] = [
                'produk_harga_id' => $row['produk_harga_id'],
                'qty' => $row['qty_jual'],
                'type' => 'out',
                'keterangan' => 'Penjualan/' . $faktur . ' (' . ($row['qty_jual'] * $row['isi']) . ' ' . $row['satuan'] . ')',
                'user_id' => user_id(),
                'created_at' => date('Y-m-d H:i:s'),
            ];
        }
        $db = $this->db->table('penjualan_detail');
        $db->insertBatch($table_penjualan_detail);

        $db = $this->db->table('produk_stok');
        $db->insertBatch($table_produk_stok);

        $db = $this->db->table('penjualan_temp');
        $db->select('sum(penjualan_temp.qty * produk_harga.isi) as qty_cart, penjualan_temp.produk_id, produk.qty as master_qty');
        $db->join('produk_harga', 'produk_harga.id = penjualan_temp.produk_harga_id', 'left');
        $db->join('produk', 'produk.id = penjualan_temp.produk_id', 'left');
        $db->groupBy('penjualan_temp.produk_id');
        $temp = $db->get()->getResultArray();

        foreach ($temp as $row) {
            $table_produk[] = [
                'id' => $row['produk_id'],
                'qty' => $row['master_qty'] - ($row['qty_cart'])
            ];
        }

        $db = $this->db->table('produk');
        $db->updateBatch($table_produk, 'id');

        $db = $this->db->table('penjualan_temp');
        $db->emptyTable();


        $this->db->transComplete();
    }

    public function piutang($id = null)
    {
        $db = $this->db->table('penjualan');
        if ($id == null) {
            $db = $this->db->table('penjualan');
            $db->select('customer_id, penjualan.id as penjualan_id,customer_atk.nama as customer, sum(penjualan.bayar) as terbayar, sum(total) as totalHarga');
            $db->join('customer_atk', 'customer_atk.id = penjualan.customer_id', 'left');
            $db->where('total > bayar');
            $db->groupBy('penjualan.customer_id');
            return  $db->get()->getResultArray();
        } else {
            $db->select('*,customer_atk.nama as customer, produk.nama as produk');
            $db->join('penjualan_detail', 'penjualan_detail.penjualan_id = penjualan.id');
            $db->join('faktur', 'faktur.id = penjualan.faktur_id');
            $db->join('customer_atk', 'customer_atk.id = penjualan.customer_id');
            $db->join('produk_harga', 'produk_harga.id = penjualan_detail.produk_harga_id');
            $db->join('produk', 'produk.id = produk_harga.produk_id');
            $db->where('penjualan.id', $id);
            return $db->get()->getRowArray();
        }
    }

    public function det_penjualan($id)
    {
        $db = $this->db->table('penjualan');
        $db->select('*, produk.nama as produk, penjualan_detail.qty as qty_jual');
        $db->join('penjualan_detail', 'penjualan_detail.penjualan_id = penjualan.id');
        $db->join('faktur', 'faktur.id = penjualan.faktur_id');
        $db->join('customer_atk', 'customer_atk.id = penjualan.customer_id');
        $db->join('produk_harga', 'produk_harga.id = penjualan_detail.produk_harga_id');
        $db->join('produk', 'produk.id = produk_harga.produk_id');
        $db->where('penjualan.id', $id);
        return $db->get()->getResultArray();
    }
    public function transaksiById($id)
    {
        $db = $this->db->table('transaksi_penjualan');
        $db->select('*, transaksi_penjualan.id as transaksiID,  transaksi_penjualan.created_at as date, transaksi_penjualan.bayar as pay');
        $db->join('penjualan', 'penjualan.id = transaksi_penjualan.penjualan_id', 'left');
        $db->join('users', 'users.id = transaksi_penjualan.kasir', 'left');
        $db->where('penjualan.id', $id);
        return $db->get()->getResultArray();
    }

    public function listPiutangByid($customerID)
    {
        $db = $this->db->table('penjualan');
        $db->select('*, penjualan.created_at as date, penjualan.id as penjualanID');
        $db->join('faktur', 'faktur.id = penjualan.faktur_id');
        $db->where('customer_id', $customerID);
        $db->where('total > bayar');
        return $db->get()->getResultArray();
    }
    public function customer($customerID)
    {
        $db = $this->db->table('customer_atk');
        $db->where('id', $customerID);
        $db->where('id', $customerID);
        return $db->get()->getRowArray();
    }

    public function pembayaran_piutang($penjualan, $t_penjualan, $id)
    {
        $this->db->transStart();

        $db = $this->db->table('penjualan');
        $db->where('id', $id);
        $db->update($penjualan);

        $db = $this->db->table('transaksi_penjualan');
        $db->insert($t_penjualan);

        $this->db->transComplete();
    }
    public function delete_pembayaran($id, $penjualan_id, $new_total_bayar)
    {
        $this->db->transStart();
        $db = $this->db->table('transaksi_penjualan');
        $db->where('id', $id);
        $db->delete();

        $data = [
            'bayar' => $new_total_bayar
        ];
        $db = $this->db->table('penjualan');
        $db->where('id', $penjualan_id);
        $db->update($data);

        $this->db->transComplete();
    }
    public function penjualan_search($mulai, $sampai)
    {
        $db = $this->db->table('penjualan');
        $db->select('*, penjualan.id as penjualan_id, customer_atk.nama as customer, penjualan.created_at as date');
        $db->join('faktur', 'faktur.id = penjualan.faktur_id');
        $db->join('customer_atk', 'customer_atk.id = penjualan.customer_id', 'left');
        // $db->where("penjualan.created_at BETWEEN 'date('Y-m-d', strtotime($mulai))' and 'date('Y-m-d', strtotime($sampai))'");
        $db->where('DATE(penjualan.created_at) >=', date('Y-m-d', strtotime($mulai)));
        $db->where('DATE(penjualan.created_at) <=', date('Y-m-d', strtotime($sampai)));
        $db->orderBy('penjualan.id', 'desc');
        return $db->get()->getResultArray();
    }
    public function penjualan_today()
    {
        $db = $this->db->table('penjualan');
        $db->select('*, penjualan.id as penjualan_id, customer_atk.nama as customer, penjualan.created_at as date');
        $db->join('faktur', 'faktur.id = penjualan.faktur_id');
        $db->join('customer_atk', 'customer_atk.id = penjualan.customer_id', 'left');
        $db->where('day(penjualan.created_at)', date('d'));
        $db->orderBy('penjualan.id', 'desc');
        return $db->get()->getResultArray();
    }

    public function diagramPenjualan()
    {
        $db = $this->db->table('penjualan');
        $db->select('penjualan.created_at as date, sum(penjualan_detail.sub_total) as total');
        $db->join('penjualan_detail', 'penjualan_detail.penjualan_id = penjualan.id');
        // $db->where('year(penjualan.created_at) <=', date('Y'),);
        // $db->where('month(penjualan.created_at) >=', date('m', strtotime('-5 months')));
        $db->where('year(penjualan.created_at)', date('Y'));
        $db->groupBy('month(penjualan.created_at)');
        return $db->get()->getResultArray();
    }
}
