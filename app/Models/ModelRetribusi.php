<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelRetribusi extends Model
{
    protected $table      = 'periode_retribusi';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $useSoftDeletes = true;

    protected $allowedFields = ['tanggal', 'total'];

    protected $useTimestamps = false;
    // protected $createdField  = 'created_at';
    // protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function setor_retribusi()
    {
        $db = $this->db->table('pembayaran_retribusi');
        $db->select('pembayaran_retribusi.id as pembayaranId, periode_retribusi.tanggal, retribusi.nama as retribusi, retribusi.id as retribusiId, pembayaran_retribusi.bayar');
        $db->join('periode_retribusi', 'periode_retribusi.id = pembayaran_retribusi.periode_id', 'right');
        $db->join('retribusi', 'pembayaran_retribusi.retribusi_id = retribusi.id');
        $db->where('bayar <= 0');
        $db->where('pembayaran_retribusi.status = 1 ');
        return $db->get()->getResultArray();
    }

    public function get_periode($id = null)
    {
        if ($id == null) {
            $db = \config\Database::connect();
            $builder = $db->table('periode_retribusi');
            $builder->orderBy('id', 'desc');
            return $builder->get()->getResultArray();
        } else {
            $db = \config\Database::connect();
            $builder = $db->table('periode_retribusi');
            $builder->where('id', $id);
            return $builder->get()->getRowArray();
        }
    }
    public function get_periode_bulan_ini()
    {
        $db = \config\Database::connect();
        $builder = $db->table('periode_retribusi');

        $builder->where('MONTH(now())');
        return $builder->get()->getResultArray();
    }

    public function list_retribusi()
    {

        $db = $this->db->table('retribusi_group_user');
        $db->select('retribusi.nama as retribusi, retribusi.id as retribusiId, retribusi.status');
        $db->join('retribusi', 'retribusi_group_user.retribusi_id = retribusi.id', 'right');
        $db->join('pegawai', 'pegawai.id = retribusi_group_user.pegawai_id', 'left');
        $db->orderBy('retribusi.id', 'desc');
        $db->groupBy('retribusi.id');
        return $db->get()->getResultArray();
    }
    public function list_periode()
    {

        $db = $this->db->table('pembayaran_retribusi');
        $db->select('*, sum(bayar) as bayar, periode_retribusi.id as periodeId');
        $db->join('periode_retribusi', 'periode_retribusi.id = pembayaran_retribusi.periode_id', 'right');
        $db->groupBy('periode_retribusi.id');
        $db->orderBy('periode_retribusi.tanggal', 'desc');
        return $db->get()->getResultArray();
    }
    public function petugas_retribusi($retribusi = null,  $id_pegawai = null)
    {
        if ($retribusi == null && $id_pegawai == null) {
            $db = $this->db->table('retribusi_group_user');
            $db->select('*, retribusi.nama as retribusi, pegawai.nama as pegawai, pegawai_jabatan.nama as jabatan, pegawai.status as status_pegawai, pegawai.id as pegawaiId, retribusi_group_user.id as pr_id, retribusi_group_user.status as pr_status');
            $db->join('retribusi', 'retribusi.id = retribusi_group_user.retribusi_id');
            $db->join('pegawai', 'pegawai.id = retribusi_group_user.pegawai_id');
            $db->join('pegawai_jabatan', 'pegawai.jabatan_id = pegawai_jabatan.id');
            return $db->get()->getResultArray();
        } elseif ($retribusi == null && $id_pegawai != null) {
            $db = $this->db->table('retribusi_group_user');
            $db->select('*, retribusi.nama as retribusi, retribusi.id as retribusiID, pegawai.nama as pegawai, pegawai.id as pegawaiId,  pegawai_jabatan.nama as jabatan, retribusi_group_user.status as pr_status,retribusi_group_user.id as groupID, pegawai.status as in_pegawai ');
            $db->join('retribusi', 'retribusi.id = retribusi_group_user.retribusi_id');
            $db->join('pegawai', 'pegawai.id = retribusi_group_user.pegawai_id');
            $db->join('pegawai_jabatan', 'pegawai.jabatan_id = pegawai_jabatan.id');
            $db->where('retribusi_group_user.id', $id_pegawai);
            return $db->get()->getRowArray();
        } elseif ($retribusi !== null  && $id_pegawai == null) {
            $db = $this->db->table('retribusi_group_user');
            $db->select('*, retribusi.nama as retribusi, pegawai.nama as pegawai, pegawai.id as pegawaiId');
            $db->join('retribusi', 'retribusi.id = retribusi_group_user.retribusi_id');
            $db->join('pegawai', 'pegawai.id = retribusi_group_user.pegawai_id');
            $db->where('retribusi_group_user.retribusi_id', $retribusi);
            $db->where('pegawai.status', 1);
            return $db->get()->getResultArray();
        }
    }


    public function save_tagihan_retribusi($data)
    {
        $this->db->transStart();

        $db = $this->db->table('periode_retribusi');
        $db->insert($data);
        $id = $this->insertId();

        $db = $this->db->table('retribusi');
        $db->where('retribusi.status', 1);
        $get = $db->get()->getResultArray();
        $i = [];
        foreach ($get as $retribusi) {
            $i[] = [
                'retribusi_id' => $retribusi['id'],
                'periode_id' => $id,
            ];
        }

        $db = $this->db->table('pembayaran_retribusi');
        $db->insertBatch($i);

        $this->db->transComplete();
    }
    public function update_periode($data)
    {
        $this->db->transStart();
        $periode = [
            'tanggal' => $data['tanggal']
        ];
        $db = $this->db->table('periode_retribusi');
        $db->where('id', $data['id']);
        $db->update($periode);

        $this->db->transComplete();
    }
    public function delete_periode($id)
    {
        $this->db->transStart();

        $db = $this->db->table('pembayaran_retribusi');
        $db->where('periode_id', $id);
        $db->delete();

        $db = $this->db->table('periode_retribusi');
        $db->where('id', $id);
        $db->delete();

        $this->db->transComplete();
    }

    public function detail_periode($id)
    {
        $db = $this->db->table('pembayaran_retribusi');
        $db->select('*, pembayaran_retribusi.id as pembayaranRetribusiId, pembayaran_retribusi.status as status_pembayaran, retribusi.nama as retribusi, retribusi.id as retribusiId, pegawai.nama as pegawai');
        $db->join('periode_retribusi', 'periode_retribusi.id = pembayaran_retribusi.periode_id');
        $db->join('retribusi', 'retribusi.id = pembayaran_retribusi.retribusi_id');
        $db->join('retribusi_group_user', 'retribusi_group_user.retribusi_id = retribusi.id', 'left');
        $db->join('pegawai', 'pegawai.id = retribusi_group_user.pegawai_id', 'left');
        $db->where('pembayaran_retribusi.periode_id', $id);
        $db->groupBy('retribusi.id');
        return $db->get()->getResultArray();
    }
    public function pembayaran_by_id($id)
    {
        $db = $this->db->table('pembayaran_retribusi');
        $db->select('*, pembayaran_retribusi.id as pembayaranRetribusiId, pembayaran_retribusi.status as status_pegawai, retribusi.nama as retribusi, pembayaran_retribusi.petugas_id as pegawaiId, pembayaran_retribusi.keterangan as desc');
        $db->join('periode_retribusi', 'periode_retribusi.id = pembayaran_retribusi.periode_id');
        $db->join('retribusi', 'retribusi.id = pembayaran_retribusi.retribusi_id');
        $db->join('retribusi_group_user', 'retribusi_group_user.retribusi_id = retribusi.id', 'left');
        $db->join('pegawai', 'pegawai.id = retribusi_group_user.pegawai_id', 'left');
        $db->where('pembayaran_retribusi.id', $id);
        return $db->get()->getRowArray();
    }

    function update_pembayaran($data)
    {
        if ($data['status'] == 0) {
            $pembayaran = [
                'petugas_id' => null,
                'bayar' => 0,
                'status' => 0,
                'keterangan' => $data['keterangan'],
                'user_id' => user_id(),
                'created_at' => date('Y-m-d H:i:s'),
            ];

            $db = $this->db->table('pembayaran_retribusi');
            $db->where('id', $data['id']);
            $db->update($pembayaran);
        } else {
            $pembayaran = [
                'petugas_id' => $data['pegawai_id'],
                'bayar' => $data['bayar'],
                'status' => 1,
                'keterangan' => $data['keterangan'],
                'user_id' => user_id(),
                'created_at' => date('Y-m-d H:i:s'),
            ];
            $db = $this->db->table('pembayaran_retribusi');
            $db->where('id', $data['id']);
            $db->update($pembayaran);
        }
    }
}
