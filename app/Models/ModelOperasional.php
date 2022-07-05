<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelOperasional extends Model
{

    public function add_pemasukan($data)
    {
        $db = $this->db->table('arus_uang');
        $db->insert($data);
    }
    public function update_arus_uang($id, $data)
    {
        $db = $this->db->table('arus_uang');
        $db->where('id', $id);
        $db->update($data);
    }

    public function pengeluaran($id = null)
    {
        if ($id == 'semua') {
            $db = $this->db->table('arus_uang');
            $db->where('jenis = "out"');
            $db->orderBy('id', 'desc');
            return $db->get()->getResultArray();
        } else {
            $db = $this->db->table('arus_uang');
            $db->where('jenis = "out"');
            $db->where('unit', $id);
            $db->orderBy('id', 'desc');
            return $db->get()->getResultArray();
        }
    }
    public function pemasukan($id = null)
    {
        if ($id == 'semua') {
            $db = $this->db->table('arus_uang');
            $db->where('jenis = "in"');
            $db->orderBy('id', 'desc');
            return $db->get()->getResultArray();
        } else {
            $db = $this->db->table('arus_uang');
            $db->where('jenis = "in"');
            $db->where('unit', $id);
            $db->orderBy('id', 'desc');
            return $db->get()->getResultArray();
        }
    }

    public function sirkulasi($data)
    {
        $db = $this->db->table('sirkulasi');
        $db->insert($data);
    }

    public function total_penjualan()
    {
        $db = $this->db->table('penjualan');
        $db->selectSum('bayar');
        return $db->get()->getRowArray();
    }
    public function total_penjualan_kredit()
    {
        $db = $this->db->table('penjualan');
        $db->select('sum(total) as harga_total, sum(bayar) as total_bayar');
        $db->where('pembayaran = "Kredit"');
        $db->where('total > bayar');
        return $db->get()->getRowArray();
    }
    public function total_sewa()
    {
        $db = $this->db->table('sewa');
        $db->selectSum('total_bayar');
        return $db->get()->getRowArray();
    }
    public function total_tagihan_bulanan()
    {
        $db = $this->db->table('pembayaran_bulanan');
        $db->select('sum(total_bayar) as total_setor');
        return $db->get()->getRowArray();
    }
    public function total_setoran_retribusi()
    {
        $db = $this->db->table('pembayaran_retribusi');
        $db->select('sum(bayar) as total_setor');
        return $db->get()->getRowArray();
    }
}
