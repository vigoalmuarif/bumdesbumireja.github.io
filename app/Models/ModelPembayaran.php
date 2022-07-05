<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelPembayaran extends Model
{
    public function sewa($id)
    {

        $db = \config\Database::connect();
        $query = $db->table('pembayaran_sewa');
        $query->select('*, pembayaran_sewa.created_at as waktuBayar')
            ->join('users', 'users.id = pembayaran_sewa.user_id')
            ->join('sewa', 'sewa.id = pembayaran_sewa.sewa_id')
            ->orderBy('pembayaran_sewa.id', 'Desc')
            ->where('pembayaran_sewa.sewa_id', $id);
        return $query->get()->getResultArray();
    }

    public function savePembayaranSewa($data)
    {

        $this->db->transBegin();
        $tambah = [
            'sewa_id' => $data['sewa_id'],
            'user_id' => $data['user_id'],
            'metode' => $data['metode'],
            'bayar' => $data['bayar'],
            'keterangan' => $data['keterangan'],
            'created_at' => $data['created_at'],
        ];
        $db = \config\Database::connect();
        $query = $db->table('pembayaran_sewa');
        $query->insert($tambah);

        $db = \config\Database::connect();
        $query = $db->table('pedagang');
        $query->set('tanggungan', $data['tanggungan']);
        $query->where('id', $data['pedagang']);
        $query->update();

        if ($this->db->transStatus() === FALSE) {
            $this->db->transRollback();

            return false;
        } else {
            $this->db->transCommit();

            return true;
        }
    }

    public function tagihanBulanan($id, $data)
    {
        $db = \config\Database::connect();
        $query = $db->table('pembayaran_bulanan');
        $query->where('id', $id);
        $query->update($data);
    }
}
