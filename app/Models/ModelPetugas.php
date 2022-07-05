<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelPetugas extends Model
{
    protected $table      = 'pegawai';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $useSoftDeletes = false;

    protected $allowedFields = ['nik', 'nama', 'alamat', 'jenis_kelamin', 'tempat_lahir', 'tanggal_lahir', 'no_hp', 'status', 'jabatan_id', 'created_at', 'updated_at'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function get($id = null)
    {
        if ($id == null) {
            $db = \config\Database::connect();
            $builder = $db->table('pegawai');
            $builder->select('*,pegawai.id as pegawaiID, pegawai.nama as petugas, pegawai_jabatan.nama as jabatan');
            $builder->join('pegawai_jabatan', 'pegawai_jabatan.id = pegawai.jabatan_id');
            $builder->orderBy('pegawai.id', 'desc');
            return $builder->get()->getResultArray();
        } else {
            $builder = $this->db->table('pegawai');
            $builder->select('*, pegawai_jabatan.id as jabatanID, pegawai.id as pegawaiID, pegawai.nama as pegawai, pegawai_jabatan.nama as jabatan');
            $builder->join('pegawai_jabatan', 'pegawai_jabatan.id = pegawai.jabatan_id');
            $builder->where('pegawai.id', $id);
            return $builder->get()->getRowArray();
        }
    }

    public function getJabatan($id = null)
    {
        if ($id == null) {

            $db = \config\Database::connect();
            $builder = $db->table('pegawai_jabatan');
            return $builder->get()->getResultArray();
        } else {
            $db = \config\Database::connect();
            $builder = $db->table('pegawai_jabatan');
            $builder->where('id', $id);
            return $builder->get()->getRowArray();
        }
    }

    public function editJabatan($id, $data)
    {
        $db = $this->db->table('pegawai_jabatan');
        $db->where('id', $id);
        $db->update($data);
    }

    public function getPetugasByRetribusi($id)
    {
        return $this->find($id);
    }
}
