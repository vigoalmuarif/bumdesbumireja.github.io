<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelPembelian extends Model
{
    public function buatFaktur()
    {
        // $db = \config\Database::connect();
        // $query = $db->table('penjualan');
        // $query->select('MAX(MID(invoice, 8, 4)) as faktur');
        // $query->where('mid(invoice)', date('dmy'));
        // $query->orderby('invoice', 'DESC');
        //cek dulu apakah ada sudah ada kode di tabel.    

        $sql = "SELECT MAX(MID(faktur, 9, 4)) AS faktur
        FROM faktur
        
        WHERE MID(faktur, 3, 6) = DATE_FORMAT(CURDATE(), '%d%m%y') AND jenis = 'Pembelian'";
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
        $kodetampil = "PB" . $tgl . $batas;  //format kode
        return $kodetampil;
    }

    public function save_temp($data)
    {
        $this->db->transStart();
        $db = $this->db->table('pembelian_temp');
        $db->insert($data);
        $this->db->transComplete();
    }
    public function update_temp($data)
    {

        $this->db->transStart();
        $db = $this->db->table('pembelian_temp');
        $db->where('produk_id', $data['produk_id']);
        $db->update([
            'produk_harga_id' => $data['produk_harga_id'],
            'harga_beli' => $data['harga_beli'],
            'qty' => $data['qty'],
            'sub_total' => $data['sub_total'],
            'keterangan' => $data['keterangan'],
        ]);
        $this->db->transComplete();
    }

    public function total_bayar()
    {
        $db = $this->db->table('pembelian_temp');
        $db->selectSum('sub_total');
        return  $db->get()->getRowArray();
    }

    public function hapus_item($id)
    {
        $db = $this->db->table('pembelian_temp');
        $db->where('id', $id);
        $db->delete();
    }
    public function get_supplier()
    {
        $db = $this->db->table('produk_supplier');
        $db->orderBy('nama', 'asc');
        $supplier =  $db->get();
        return $supplier->getResultArray();
    }

    public function save_pembayaran($data, $faktur)
    {
        $invoice = [
            'faktur' => $faktur,
            'jenis' => 'Pembelian',
            'pembuat' => user_id()
        ];


        $this->db->transStart();

        // insert faktur
        $db = $this->db->table('faktur');
        $db->insert($invoice);
        $id_faktur = $this->db->insertID();

        // insert pembelian
        $db = $this->db->table('pembelian');
        $db->insert([
            'faktur_id' => $id_faktur,
            'total' => $data['total'],
            'diskon' => $data['diskon'],
            'bayar' => $data['bayar'],
            'supplier_id' => $data['supplier_id'],
            'referensi' => $data['referensi'],
            'keterangan' => $data['keterangan'],
            'bukti' => $data['bukti'],
            'pembayaran' => $data['pembayaran'],
            'created_at' => $data['created_at'],
        ]);
        $id_pembelian = $this->db->insertID();

        $sub_total = $data['total'];
        $diskon = $data['diskon'];
        $total_harga = $sub_total - $diskon;
        $bayar = $data['bayar'];
        if ($bayar > $total_harga) {
            $kembalian = $bayar - $total_harga;
        } else {
            $kembalian = 0;
        }


        $db = $this->db->table('transaksi_pembelian');
        $db->insert([
            'pembelian_id' => $id_pembelian,
            'bayar' => $data['bayar'],
            'kembalian' => $kembalian,
            'kasir' => user_id(),
            'created_at' => date('Y-m-d H:i:s')
        ]);

        $db = $this->db->table('pembelian_temp');
        $db->select('produk.id as produkID, pembelian_temp.produk_harga_id as hargaID, produk.qty as qty_master, produk_harga.isi, pembelian_temp.qty as qty_beli, pembelian_temp.harga_beli, sub_total, pembelian_temp.keterangan, produk_satuan.nama as satuan_dasar');
        $db->join('produk', 'pembelian_temp.produk_id = produk.id', 'left');
        $db->join('produk_harga', 'produk_harga.id = pembelian_temp.produk_harga_id', 'left');
        $db->join('produk_satuan', 'produk_satuan.id = produk.satuan_id', 'left');
        $temp = $db->get()->getResultArray();



        $table_pembelian_temp = [];
        $table_produk_stok = [];

        foreach ($temp as $row) {
            $table_pembelian_temp[] = [
                'pembelian_id' => $id_pembelian,
                'produk_harga_id' => $row['hargaID'],
                'harga' => $row['harga_beli'],
                'qty' => $row['qty_beli'],
                'sub_total' => $row['sub_total'],
                'keterangan' => $row['keterangan'],
            ];
            $table_produk_stok[] = [
                'produk_harga_id' => $row['hargaID'],
                'qty' => $row['qty_beli'],
                'type' => 'in',
                'keterangan' => 'Pembelian/' . $faktur . ' (' . $row['isi'] * $row['qty_beli'] . ' ' . $row['satuan_dasar'] . ')',
                'user_id' => user_id(),
                'created_at' => date('Y-m-d H:i:s'),
            ];

            $table_produk[] = [
                'id' => $row['produkID'],
                'qty' => intval(($row['qty_beli'] * $row['isi']) + $row['qty_master']),
                'supplier_id' => $data['supplier_id']
            ];
        }
        $db = $this->db->table('pembelian_detail');
        $db->insertBatch($table_pembelian_temp);

        $db = $this->db->table('produk_stok');
        $db->insertBatch($table_produk_stok);

        $db = $this->db->table('produk');
        $db->updateBatch($table_produk, 'id');

        $db = $this->db->table('pembelian_temp');
        $db->emptyTable();


        $this->db->transComplete();
    }

    public function save_produk($data)
    {
        $this->db->transStart();

        $db = $this->db->table('produk');
        $db->insert([
            'barcode' => $data['barcode'],
            'sku' => $data['sku'],
            'kategori_id' => $data['kategori'],
            'nama' => $data['nama'],
            'satuan_id' => $data['satuan'],
            'harga_beli' => $data['harga_beli'],
            'harga_jual' => $data['harga_jual'],
            'created_at' => date('Y-m-d H:i:s'),
        ]);
        $id = $this->db->insertID();

        $db = $this->db->table('pembelian_temp');
        $db->insert([
            'produk_id' => $id,
            'harga_beli' => $data['harga_beli'],
            'harga_jual' => $data['harga_jual'],
            'qty' => $data['qty'],
            'sub_total' => $data['total'],
        ]);


        $this->db->transComplete();
    }

    public function list_produk($id)
    {
        $db = $this->db->table('pembelian');
        $db->select('*, produk.nama as produk, produk_satuan.nama as satuan, pembelian_detail.harga as harga_beli, produk_supplier.nama as supplier');
        $db->join('pembelian_detail', 'pembelian_detail.pembelian_id = pembelian.id');
        $db->join('produk', 'pembelian_detail.produk_id = produk.id');
        $db->join('produk_satuan', 'produk.satuan_id = produk_satuan.id');
        $db->join('produk_supplier', 'produk_supplier.id = pembelian.supplier_id', 'left');
        $db->where('pembelian_id', $id);
        return $db->get()->getResultArray();
    }

    public function list_pembelian($id = null)
    {
        $db = $this->db->table('pembelian');
        if ($id == null) {
            $db->select('*, pembelian.id as pembelian_id, produk_supplier.nama as supplier, pembelian.created_at as date');
            $db->join('faktur', 'faktur.id = pembelian.faktur_id');
            $db->join('produk_supplier', 'produk_supplier.id = pembelian.supplier_id', 'left');
            $db->orderBy('pembelian.id', 'desc');
            return $db->get()->getResultArray();
        } else {
            $db->select('*, pembelian.id as pembelian_id, produk_supplier.nama as supplier, pembelian.keterangan as desc');
            $db->join('pembelian_detail', 'pembelian_detail.pembelian_id = pembelian.id');
            $db->join('faktur', 'faktur.id = pembelian.faktur_id');
            $db->join('produk_supplier', 'produk_supplier.id = pembelian.supplier_id', 'left');
            $db->where('pembelian_id', $id);
            return $db->get()->getRowArray();
        }
    }

    public function hutang($id = null)
    {
        $db = $this->db->table('pembelian');
        if ($id == null) {
            $db->select('pembelian.id as pembelian_id, produk_supplier.nama as supplier, sum(pembelian.bayar) as terbayar, sum(total - diskon) as totalHarga, sum((total - diskon) - bayar) as kekurangan, referensi, supplier_id');
            $db->join('produk_supplier', 'produk_supplier.id = pembelian.supplier_id', 'left');
            $db->where('(total-diskon) > bayar');
            $db->groupBy('pembelian.supplier_id');
            return  $db->get()->getResultArray();
        } else {
            $db->select('*,produk_supplier.nama as supplier');
            $db->join('pembelian_detail', 'pembelian_detail.pembelian_id = pembelian.id');
            $db->join('faktur', 'faktur.id = pembelian.faktur_id');
            $db->join('produk_supplier', 'produk_supplier.id = pembelian.supplier_id');
            $db->join('produk_harga', 'produk_harga.id = pembelian_detail.produk_harga_id');
            $db->join('produk', 'produk.id = produk_harga.produk_id');
            $db->where('pembelian.id', $id);
            return $db->get()->getRowArray();
        }
    }

    public function listHutangByid($supplierID)
    {
        $db = $this->db->table('pembelian');
        $db->select('*, pembelian.created_at as date, pembelian.id as pembelianID');
        $db->join('faktur', 'faktur.id = pembelian.faktur_id');
        $db->where('supplier_id', $supplierID);
        $db->where('total > bayar+diskon');
        return $db->get()->getResultArray();
    }
    public function supplier($supplierID)
    {
        $db = $this->db->table('produk_supplier');
        $db->select('nama as supplier');
        $db->where('id', $supplierID);
        return $db->get()->getRowArray();
    }

    public function detail_pembelian($id)
    {
        $db = $this->db->table('pembelian');
        $db->select('*, produk.nama as produk, pembelian_detail.qty as qty_beli');
        $db->join('pembelian_detail', 'pembelian_detail.pembelian_id = pembelian.id');
        $db->join('faktur', 'faktur.id = pembelian.faktur_id');
        $db->join('produk_supplier', 'produk_supplier.id = pembelian.supplier_id');
        $db->join('produk_harga', 'produk_harga.id = pembelian_detail.produk_harga_id');
        $db->join('produk', 'produk.id = produk_harga.produk_id');
        $db->where('pembelian.id', $id);
        return $db->get()->getResultArray();
    }

    public function transaksiById($id)
    {
        $db = $this->db->table('transaksi_pembelian');
        $db->select('*,transaksi_pembelian.id as transaksiID, transaksi_pembelian.created_at as date, transaksi_pembelian.bayar as pay');
        $db->join('pembelian', 'pembelian.id = transaksi_pembelian.pembelian_id', 'left');
        $db->join('users', 'users.id = transaksi_pembelian.kasir', 'left');
        $db->where('pembelian.id', $id);
        return $db->get()->getResultArray();
    }

    public function pembayaran_hutang($pembelian, $t_pembelian, $id)
    {
        $this->db->transStart();

        $db = $this->db->table('pembelian');
        $db->where('id', $id);
        $db->update($pembelian);

        $db = $this->db->table('transaksi_pembelian');
        $db->insert($t_pembelian);

        $this->db->transComplete();
    }

    public function delete_pembayaran($id, $pembelian_id, $new_total_bayar)
    {
        $this->db->transStart();
        $db = $this->db->table('transaksi_pembelian');
        $db->where('id', $id);
        $db->delete();

        $data = [
            'bayar' => $new_total_bayar
        ];
        $db = $this->db->table('pembelian');
        $db->where('id', $pembelian_id);
        $db->update($data);

        $this->db->transComplete();
    }
}
