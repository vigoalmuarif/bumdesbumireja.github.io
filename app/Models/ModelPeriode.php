<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelPeriode extends Model
{

    public function get()
    {
        $db = \config\Database::connect();
        $query = $db->table('periode');
        $query->select('*');
        $query->join('pembayaran_bulanan', 'pembayaran_bulanan.periode_id = periode.id', 'left');
        $query->groupBy('periode.id');
        $query->selectSum('bayar');
        $query->orderBy('periode', 'desc');
        return $query->get()->getResultArray();
    }


    public function insertPeriodeBulanan($data, $hasil)
    {
        $this->db->transBegin();

        $periode = [
            'periode' => $data['periode'],
            'tarif' => $data['tarif'],
            'jenis' => $data['jenis']
        ];

        $db = \config\Database::connect();
        $query = $db->table('periode');
        $query->insert($periode);
        $id = $this->insertID();

        foreach ($hasil as $sewa) {
            $i[] = [
                'sewa_id' => $sewa['id'],
                'periode_id' => $id,
                'status' => 0
            ];
        }

        $db = \config\Database::connect();
        $query = $db->table('pembayaran_bulanan');
        $query->insertBatch($i);

        $db = \config\Database::connect();
        $query = $db->table('pembayaran_bulanan');
        $query->where('periode_id', $id);
        $count = $query->countAllResults('bayar');

        $data = [

            'total' => $data['tarif'] * $count
        ];
        $db = \config\Database::connect();
        $query = $db->table('periode');
        $query->where('id', $id);
        $query->update($data);

        if ($this->db->transStatus() === FALSE) {
            $this->db->transRollback();

            return false;
        } else {
            $this->db->transCommit();

            return true;
        }
    }


    public function cariSewaByPeriode($date, $jenis)
    {
        $db = \config\Database::connect();
        $query = $db->table('sewa');
        $query->select('*');
        $query->join('property', 'sewa.property_id = property.property_id');
        $query->where('sewa.tanggal_batas >', date('Y-m-d'));
        $query->where('tanggal_sewa <', date('Y-m-d', strtotime('+1 month', strtotime($date))));

        $query->wherein('property.jenis_property', $jenis);
        return $query->get()->getResultArray();
    }


    public function getTagihanBulanan($id)
    {
        $db = \config\Database::connect();
        $query = $db->table('pembayaran_bulanan');
        $query->select('*, pembayaran_bulanan.status as bulanan_status, pembayaran_bulanan.id as tagihanBulanan_id');
        $query->join('periode', 'periode.id = pembayaran_bulanan.periode_id');
        $query->join('sewa', 'sewa.id = pembayaran_bulanan.sewa_id');
        $query->join('pedagang', 'pedagang.id = sewa.pedagang_id');
        $query->join('property', 'property.property_id = sewa.property_id');
        $query->where('periode_id', $id);
        return $query->get();
    }
    public function getTagihanBulananById($id)
    {
        $db = \config\Database::connect();
        $query = $db->table('pembayaran_bulanan');
        $query->select('*, pembayaran_bulanan.status as bulanan_status, pembayaran_bulanan.id as tagihanBulanan_id');
        $query->join('periode', 'periode.id = pembayaran_bulanan.periode_id');
        $query->join('sewa', 'sewa.id = pembayaran_bulanan.sewa_id');
        $query->join('pedagang', 'pedagang.id = sewa.pedagang_id');
        $query->join('property', 'property.property_id = sewa.property_id');
        $query->where('pembayaran_bulanan.id', $id);
        return $query->get()->getRowArray();
    }

    public function periodeRetribusi()
    {
        $db = \config\Database::connect();
        $builder = $db->table('pembayaran_retribusi');
        $builder->select('*');
        $builder->join('retribusi', 'retribusi.id = pembayaran_retribusi.retribusi_id');
        $builder->join('periode_retribusi', 'periode_retribusi.id = pembayaran_retribusi.periode_id');
        $builder->groupBy('periode_retribusi.tanggal');
        return $builder->get()->getResultArray();
    }

    public function insertPeriodeRetribusi($data)
    {
        $db = \config\Database::connect();
        $builder = $db->table('periode_retribusi');
        $builder->insert($data);
    }
    public function insertRetribusi($data)
    {
        $db = \config\Database::connect();
        $builder = $db->table('pembayaran_retribusi');
        $builder->insertBatch($data);
    }

    public function getRetribusi($id)
    {
        $db = \config\Database::connect();
        $builder = $db->table('pembayaran_retribusi');
        $builder->select('*, petugas.nama as nama_petugas, retribusi.nama as nama_retribusi');
        $builder->join('retribusi', 'retribusi.id = pembayaran_retribusi.retribusi_id');
        $builder->join('periode_retribusi', 'periode_retribusi.id = pembayaran_retribusi.periode_id');
        $builder->join('petugas', 'petugas.id = pembayaran_retribusi.petugas_id', 'left');
        $builder->where('periode_retribusi.id', $id);
        return $builder->get();
    }
    public function getRetribusiByName($id)
    {
        $db = \config\Database::connect();
        $query = $db->table('pembayaran_retribusi');
        $query->select('*, petugas.nama as nama_petugas, retribusi.nama as nama_retribusi');
        $query->join('retribusi', 'retribusi.id = pembayaran_retribusi.retribusi_id');
        $query->join('periode_retribusi', 'periode_retribusi.id = pembayaran_retribusi.periode_id');
        $query->join('petugas', 'petugas.id = pembayaran_retribusi.petugas_id', 'left');
        $query->where('periode_retribusi.id', $id);
        return $query->get();
    }
}
