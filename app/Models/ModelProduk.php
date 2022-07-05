<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelProduk extends Model
{


    public function Produk($id = false)
    {
        if ($id == false) {
            $db = \config\Database::connect();
            $query = $db->table('produk');
            $query->select('produk.id as produkID, produk_satuan.nama as satuan, produk.nama as produk, produk_supplier.nama as supplier, produk.supplier_id, produk_kategori.nama as kategori, sku, produk.satuan_id, harga_beli, produk_kategori.id as kategori_id, stok_awal');
            $query->join('produk_kategori', 'produk_kategori.id = produk.kategori_id', 'left');
            $query->join('produk_satuan', 'produk_satuan.id = produk.satuan_id', 'left');
            $query->join('produk_supplier', 'produk_supplier.id = produk.supplier_id', 'left');
            $query->orderBy('produk.nama', 'asc');
            return $query->get()->getResultArray();
        } else {
            $db = \config\Database::connect();
            $query = $db->table('produk');
            $query->select('produk.id as produkID, produk_satuan.nama as satuan, produk.nama as produk, produk_supplier.nama as supplier, produk_kategori.nama as kategori, sku, produk.satuan_id, harga_beli, produk_kategori.id as kategori_id, produk_supplier.id as supplier_id, produk.qty as qty_master, sku, stok_awal');
            $query->join('produk_kategori', 'produk_kategori.id = produk.kategori_id', 'left');
            $query->join('produk_satuan', 'produk_satuan.id = produk.satuan_id', 'left');
            $query->where('produk.id', $id);
            $query->join('produk_supplier', 'produk_supplier.id = produk.supplier_id', 'left');
            $query->orderBy('produk.nama', 'asc');
            return $query->get()->getRowArray();
        }
    }

    public function harga_satuan($id = false)
    {
        if ($id !== false) {
            $db = \config\Database::connect();
            $query = $db->table('produk_harga');
            $query->select('produk.id as produk_id, produk_harga.id as hargaID,produk_satuan.id as satuan_id, produk_satuan.nama as satuan, produk.nama as produk, produk_supplier.nama as supplier, produk_kategori.nama as kategori, sku, produk_harga.satuan_id,  produk_harga.isi, produk_harga.harga_jual, barcode, produk.qty as qty, harga_beli, harga_dasar, nama_lain, stok_awal');
            $query->join('produk', 'produk.id = produk_harga.produk_id');
            $query->join('produk_kategori', 'produk_kategori.id = produk.kategori_id', 'left');
            $query->join('produk_satuan', 'produk_satuan.id = produk_harga.satuan_id');
            $query->join('produk_supplier', 'produk_supplier.id = produk.supplier_id', 'left');
            $query->where('produk.id', $id);
            $query->orderBy('produk.nama', 'asc');
            return $query->get()->getResultArray();
        } else {
            $db = \config\Database::connect();
            $query = $db->table('produk_harga');
            $query->select('produk.id as produk_id, produk_harga.id as hargaID,produk_satuan.id as satuan_id, produk_satuan.nama as satuan, produk.nama as produk, produk_supplier.nama as supplier, produk_kategori.nama as kategori, sku, produk_harga.satuan_id,  produk_harga.isi, produk_harga.harga_jual, barcode, produk.qty as qty_master, harga_beli, harga_dasar, nama_lain');
            $query->join('produk', 'produk.id = produk_harga.produk_id');
            $query->join('produk_kategori', 'produk_kategori.id = produk.kategori_id', 'left');
            $query->join('produk_satuan', 'produk_satuan.id = produk_harga.satuan_id');
            $query->join('produk_supplier', 'produk_supplier.id = produk.supplier_id', 'left');
            $query->where('produk.id', $id);
            return $query->get()->getRowArray();
        }
    }
    public function getProduk($id = false)
    {
        if ($id == false) {
            $db = \config\Database::connect();
            $query = $db->table('produk_harga');
            $query->select('produk.id as produk_id, produk_satuan.nama as satuan, produk.nama as produk, produk_supplier.nama as supplier, produk_kategori.nama as kategori, sku, produk_harga.satuan_id, produk_harga.isi, produk_harga.harga_jual, barcode, produk.qty as qty, nama_lain, produk_harga.harga_dasar, stok_awal');
            $query->join('produk', 'produk.id = produk_harga.produk_id');
            $query->join('produk_kategori', 'produk_kategori.id = produk.kategori_id', 'left');
            $query->join('produk_satuan', 'produk_satuan.id = produk_harga.satuan_id');
            $query->join('produk_supplier', 'produk_supplier.id = produk.supplier_id', 'left');
            $query->orderBy('produk.nama', 'asc');
            return $query->get()->getResultArray();
        } else {
            $db = \config\Database::connect();
            $query = $db->table('produk_harga');
            $query->select('produk.id as produk_id, produk_satuan.nama as satuan, produk.nama as produk, produk_supplier.nama as supplier, produk_kategori.nama as kategori, sku, produk_harga.satuan_id, produk_harga.isi, produk_harga.harga_jual, barcode, produk.qty as qty, harga_beli, nama_lain, harga_dasar, stok_awal');
            $query->join('produk', 'produk.id = produk_harga.produk_id');
            $query->join('produk_kategori', 'produk_kategori.id = produk.kategori_id', 'left');
            $query->join('produk_satuan', 'produk_satuan.id = produk_harga.satuan_id');
            $query->join('produk_supplier', 'produk_supplier.id = produk.supplier_id', 'left');
            $query->where('produk_harga.id', $id);
            return $query->get()->getRowArray();
        }
    }

    public function tambahProduk($produk = null)
    {
        $this->db->transBegin();
        $db = \config\Database::connect();
        $builder = $db->table('produk');
        $builder->insert($produk);
        $produk_id = $this->insertID();

        if ($this->db->transStatus() === FALSE) {
            $this->db->transRollback();
            return true;
        } else {
            $this->db->transCommit();

            return $produk_id;
        }
    }

    public function save_satuan_dasar($data1, $data2, $id)
    {
        $this->db->transStart();

        $db = $this->db->table('produk');
        $db->where('id', $id);
        $db->update($data1);

        $db = $this->db->table('produk_harga');
        $db->insert($data2);

        $this->db->transComplete();
    }
    public function update_satuan_dasar($data, $produkID)
    {
        $this->db->transStart();

        $db = $this->db->table('produk');
        $db->where('id', $produkID);
        $db->update($data);

        $this->db->transComplete();
    }

    public function save_satuan_harga($data)
    {
        $this->db->transStart();

        $db = $this->db->table('produk_harga');
        $db->insert($data);

        $this->db->transComplete();
    }

    public function update_satuan_harga($data, $id)
    {
        $this->db->transStart();

        $db = $this->db->table('produk_harga');
        $db->where('id', $id);
        $db->update($data);

        $this->db->error();

        $this->db->transComplete();
    }

    public function getStok()
    {
        $db = \config\Database::connect();
        $query = $db->table('produk');
        $query->select('produk.id as produkID,  produk.nama as produk, qty, sku, produk_satuan.nama as satuan, produk_kategori.nama as kategori, qty');
        $query->join('produk_satuan', 'produk.satuan_id = produk_satuan.id', 'left');
        $query->join('produk_kategori', 'produk.kategori_id = produk_kategori.id', 'left');
        $query->orderBy('produk.nama', 'asc');
        return $query->get()->getResultArray();
    }

    public function stok($id)
    {
        $db = \config\Database::connect();
        $query = $db->table('produk_harga');
        $query->select('produk.id as produk_id, produk_harga.id as produk_harga_id, produk_satuan.nama as satuan, isi, produk.qty as qty_master');
        $query->join('produk', 'produk.id= produk_harga.produk_id');
        $query->join('produk_satuan', 'produk_satuan.id= produk_harga.satuan_id');
        $query->where('produk_id', $id);
        $query->orderBy('produk_harga.isi', 'asc');
        return $query->get()->getRowArray();
    }
    public function history_stok($id)
    {
        $db = \config\Database::connect();
        $query = $db->table('produk_stok');
        $query->select('produk.id as produk_id, produk_harga.id as produk_harga_id, produk_stok.created_at as tanggal, produk_stok.keterangan as desc, produk_stok.qty, type, produk_satuan.nama as satuan, isi, type');
        $query->join('produk_harga', 'produk_harga.id= produk_stok.produk_harga_id');
        $query->join('produk', 'produk.id= produk_harga.produk_id');
        $query->join('produk_satuan', 'produk_satuan.id= produk_harga.satuan_id');
        $query->where('produk_id', $id);
        $query->orderBy('produk_stok.created_at', 'asc');
        // $query->where('type', 'in');
        return $query->get()->getResultArray();
    }

    public function stok_in($id)
    {
        $db = \config\Database::connect();
        $query = $db->table('produk_harga');
        $query->select('sum(produk_stok.qty * isi) as stok_in, produk_satuan.nama as satuan, isi, produk.qty as qty_master, produk_stok.qty as  qty_jual');
        $query->join('produk_stok', 'produk_harga.id = produk_stok.produk_harga_id', 'left');
        $query->join('produk', 'produk.id= produk_harga.produk_id', 'left');
        $query->join('produk_satuan', 'produk_satuan.id= produk.satuan_id', 'left');
        $query->where('produk_harga.produk_id', $id);
        $query->where('produk_stok.type', 'in');
        $query->orderBy('produk_harga.isi', 'asc');
        return  $query->get()->getRowArray();
    }
    public function stok_out($id)
    {
        $db = \config\Database::connect();
        $query = $db->table('produk_stok');
        $query->select('sum((produk_stok.qty * isi)) as stok_out, produk_satuan.nama as satuan, isi, produk.qty as qty_master, produk_stok.qty as  qty_jual');
        $query->join('produk_harga', 'produk_harga.id = produk_stok.produk_harga_id', 'right');
        $query->join('produk', 'produk.id= produk_harga.produk_id', 'left');
        $query->join('produk_satuan', 'produk_satuan.id = produk.satuan_id', 'left');
        $query->where('produk_harga.produk_id', $id);
        // $query->where('produk_harga.isi >', 1);
        $query->where('produk_stok.type', 'out');
        $query->orderBy('produk_harga.isi', 'desc');
        return ($query->get()->getRowArray());
    }
    public function satuan($id)
    {
        $db = \config\Database::connect();
        $query = $db->table('produk_harga');
        $query->select('produk_satuan.nama as satuan, isi, produk_harga.satuan_id as satuanID, produk_satuan.nama as satuan, produk_harga.id as produk_harga_id');
        $query->join('produk', 'produk.id= produk_harga.produk_id', 'left');
        $query->join('produk_satuan', 'produk_satuan.id= produk_harga.satuan_id', 'left');
        $query->where('produk.id', $id);
        $query->groupBy('produk_harga.satuan_id');
        $query->orderBy('produk_harga.isi', 'asc');
        return  $query->get()->getResultArray();
    }

    public function tambahstok($stok)
    {
        $this->db->transBegin();

        $data = [
            'stok' => $stok['stok'],
            'stok_in' => $stok['stok_in']
        ];
        $db = \config\Database::connect();
        $builder = $db->table('produk');
        $builder->where('id', $stok['produk_id']);
        $builder->update($data);

        $data = [
            'qty' => $stok['jumlah'],
            'produk_id' => $stok['produk_id'],
            'keterangan' => $stok['keterangan'],
            'type' => 'in',
            'user_id' => user_id(),
            'created_at' => date('Y-m-d H:i:s')
        ];
        $db = \config\Database::connect();
        $builder = $db->table('produk_stok');
        $builder->insert($data);

        if ($this->db->transStatus() === FALSE) {
            $this->db->transRollback();

            return false;
        } else {
            $this->db->transCommit();

            return true;
        }
    }

    public function getStokOut($id)
    {
        $db = \config\Database::connect();
        $query = $db->table('produk_stok');
        $query->select('*,produk.nama as produk, produk.id as produk_id, produk_satuan.nama as satuan, produk_stok.created_at as date_in, produk_stok.keterangan as desc');
        $query->join('produk', 'produk.id= produk_stok.produk_id');
        $query->join('produk_satuan', 'produk_satuan.id = produk.satuan_id');
        $query->where('produk_id', $id);
        $query->where('type', 'out');
        $query->orderBy('produk_stok.created_at', 'desc');
        return $query->get()->getResultArray();
    }

    public function pengurangan_stok_get_produk($id)
    {

        $db = \config\Database::connect();
        $query = $db->table('produk');
        $query->select('produk.id as produkID, produk_satuan.nama as satuan, produk.nama as produk, sku, produk.satuan_id, harga_beli,produk.qty as qty_master, sku, produk_harga.id as produk_harga_id');
        $query->join('produk_satuan', 'produk_satuan.id = produk.satuan_id', 'left');
        $query->join('produk_harga', 'produk_harga.produk_id = produk.id', 'left');
        $query->where('produk.id', $id);
        $query->orderBy('produk.nama', 'asc');
        return $query->get()->getRowArray();
    }


    public function less_stok($stok)
    {
        $this->db->transBegin();

        $data = [
            'qty' => $stok['new_stok'],
        ];
        $db = \config\Database::connect();
        $builder = $db->table('produk');
        $builder->where('id', $stok['produk_id']);
        $builder->update($data);

        $data = [
            'qty' => $stok['jumlah'],
            'produk_harga_id' => $stok['produk_harga_id'],
            'type' => 'out',
            'user_id' => user_id(),
            'keterangan' => $stok['keterangan'] . ' (' . ($stok['jumlah'] * $stok['isi']) . ' ' . $stok['satuan_dasar'] . ')',
            'created_at' => date('Y-m-d H:i:s')
        ];
        $db = \config\Database::connect();
        $builder = $db->table('produk_stok');
        $builder->insert($data);

        if ($this->db->transStatus() === FALSE) {
            $this->db->transRollback();

            return true;
        } else {
            $this->db->transCommit();

            return true;
        }
    }


    public function getKategori()
    {
        $db = \config\Database::connect();
        $builder = $db->table('produk_kategori');
        $builder->orderBy('id', 'desc');
        return $builder->get()->getResultArray();
    }

    public function getCategori()
    {
        $db = \config\Database::connect();
        $builder = $db->table('produk_kategori');
        $builder->select('produk_kategori.nama as kategori, produk_kategori.id as kategoriId, count(kategori_id) as jumlah');
        $builder->join('produk', 'produk.kategori_id = produk_kategori.id', 'left');
        $builder->orderBy('produk_kategori.id', 'desc');
        $builder->groupBy('produk_kategori.id');
        return $builder->get()->getResultArray();
    }

    public function tambah_kategori($data)
    {
        $db = \config\Database::connect();
        $builder = $db->table('produk_kategori');
        $builder->insert($data);
    }
    public function kategoriById($id)
    {
        $db = \config\Database::connect();
        $builder = $db->table('produk_kategori');
        $builder->where('id', $id);
        return $builder->get()->getRowArray();
    }
    public function update_kategori($data)
    {
        $nama = [
            'nama' => $data['nama']
        ];
        $db = \config\Database::connect();
        $builder = $db->table('produk_kategori');
        $builder->where('id', $data['id']);
        $builder->update($nama);
    }
    public function hapus_kategori($id)
    {
        $db = \config\Database::connect();
        $builder = $db->table('produk_kategori');
        $builder->where('id', $id);
        $builder->delete();
    }

    public function getSatuan()
    {
        $db = \config\Database::connect();
        $builder = $db->table('produk_satuan');
        $builder->orderBy('id', 'desc');
        return $builder->get()->getResultArray();
    }

    public function tambah_satuan($data)
    {
        $db = \config\Database::connect();
        $builder = $db->table('produk_satuan');
        $builder->insert($data);
    }

    public function satuanById($id)
    {
        $db = \config\Database::connect();
        $builder = $db->table('produk_satuan');
        $builder->where('id', $id);
        return $builder->get()->getRowArray();
    }
    public function update_satuan($data)
    {
        $nama = [
            'nama' => $data['nama']
        ];
        $db = \config\Database::connect();
        $builder = $db->table('produk_satuan');
        $builder->where('id', $data['id']);
        $builder->update($nama);
    }
    public function hapus_satuan($id)
    {
        $db = \config\Database::connect();
        $builder = $db->table('produk_satuan');
        $builder->where('id', $id);
        $builder->delete();
    }
    public function getSupplier($id = false)
    {
        if ($id == false) {
            $db = \config\Database::connect();
            $builder = $db->table('produk_supplier');
            $builder->orderBy('id', 'desc');
            return $builder->get()->getResultArray();
        }
        $db = \config\Database::connect();
        $builder = $db->table('produk_supplier');
        $builder->where('id', $id);
        return $builder->get()->getRowArray();
    }

    public function tambah_supplier($data)
    {
        $db = \config\Database::connect();
        $builder = $db->table('produk_supplier');
        $builder->insert($data);
    }

    public function ubah_supplier($id, $data)
    {
        $db = \config\Database::connect();
        $builder = $db->table('produk_supplier');
        $builder->where('id', $id);
        $builder->update($data);
    }
    public function hapus_supplier($id)
    {
        $db = \config\Database::connect();
        $builder = $db->table('produk_supplier');
        $builder->where('id', $id);
        $builder->delete();
    }
}
