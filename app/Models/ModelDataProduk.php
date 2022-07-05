<?php

namespace App\Models;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class ModelDataProduk extends Model
{

    protected $table = "produk_harga";
    protected $column_order = array(null, 'produkID', 'produk_satuan', 'produk', 'satuan_id', 'satuan', 'harga_jual', 'qty', 'isi', 'barcode', 'sku', 'harga_dasar', null);
    protected $column_search = array('produk.nama', 'produk_satuan.nama', 'produk_harga.barcode', 'produk.sku', 'produk_harga.nama_lain');
    protected $order = array('produk.nama' => 'asc');
    protected $request;
    protected $db;
    protected $dt;

    function __construct(RequestInterface $request)
    {
        parent::__construct();
        $this->db = db_connect();
        $this->request = $request;
    }

    private function _get_datatables_query($keyword)
    {
        if (strlen($keyword) == 0) {
            $this->dt = $this->db->table($this->table)
                ->select('produk.id as produkID, produk_harga.id as produk_satuan, produk_harga.id as hargaID, produk_harga.harga_jual, produk_harga.satuan_id, produk_satuan.nama as satuan, produk.nama as produk, sku, barcode, harga_jual, produk.qty, isi, produk_harga.harga_dasar, nama_lain')
                ->join('produk_satuan', 'produk_satuan.id = produk_harga.satuan_id')
                ->join('produk', 'produk_harga.produk_id = produk.id');
        } else {
            $this->dt = $this->db->table($this->table)
                ->select('produk.id as produkID, produk_harga.id as produk_satuan, produk_harga.id as hargaID, produk_harga.harga_jual, produk_harga.satuan_id, produk_satuan.nama as satuan, produk.nama as produk, sku, barcode, harga_jual, produk.qty, isi, produk_harga.harga_dasar, nama_lain')
                ->join('produk_satuan', 'produk_satuan.id = produk_harga.satuan_id')
                ->join('produk', 'produk_harga.produk_id = produk.id')
                ->like('produk.nama', $keyword)
                ->orLike('produk.sku', $keyword);
        }


        $i = 0;
        foreach ($this->column_search as $item) {
            if ($this->request->getPost('search')['value']) {
                if ($i === 0) {
                    $this->dt->groupStart();
                    $this->dt->like($item, $this->request->getPost('search')['value']);
                } else {
                    $this->dt->orLike($item, $this->request->getPost('search')['value']);
                }
                if (count($this->column_search) - 1 == $i)
                    $this->dt->groupEnd();
            }
            $i++;
        }

        if ($this->request->getPost('order')) {
            $this->dt->orderBy($this->column_order[$this->request->getPost('order')['0']['column']], $this->request->getPost('order')['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->dt->orderBy(key($order), $order[key($order)]);
        }
    }

    function get_datatables($keyword)
    {


        $this->_get_datatables_query($keyword);
        if ($this->request->getPost('length') != -1)
            $this->dt->limit($this->request->getPost('length'), $this->request->getPost('start'));
        $query = $this->dt->get();
        return $query->getResult();
    }

    function count_filtered($keyword)
    {
        $this->_get_datatables_query($keyword);
        return $this->dt->countAllResults();
    }

    public function count_all($keyword)
    {
        if (strlen($keyword) == 0) {
            $tbl_storage = $this->db->table($this->table)
                ->select('produk.id as produkID, produk_harga.id as produk_satuan, produk_harga.id as hargaID, produk_harga.harga_jual, produk_harga.satuan_id, produk_satuan.nama as satuan, produk.nama as produk, sku, barcode, harga_jual, produk.qty, isi, produk_harga.harga_dasar, nama_lain')
                ->join('produk_satuan', 'produk_satuan.id = produk_harga.satuan_id')
                ->join('produk', 'produk_harga.produk_id = produk.id');
        } else {
            $this->dt = $this->db->table($this->table)
                ->select('produk.id as produkID, produk_harga.id as produk_satuan, produk_harga.id as hargaID, produk_harga.harga_jual, produk_harga.satuan_id, produk_satuan.nama as satuan, produk.nama as produk, sku, barcode, harga_jual, produk.qty, isi, produk_harga.harga_dasar, nama_lain')
                ->join('produk_satuan', 'produk_satuan.id = produk_harga.satuan_id')
                ->join('produk', 'produk_harga.produk_id = produk.id')
                ->like('produk.nama', $keyword)
                ->orLike('produk.sku', $keyword);
        }

        return $tbl_storage->countAllResults();
    }
}
