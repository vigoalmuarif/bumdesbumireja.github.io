<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelPedagang extends Model
{
    protected $table      = 'pedagang';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $useSoftDeletes = false;

    protected $allowedFields = ['nama', 'nik', 'jenis_kelamin', 'tempat_lahir', 'tanggal_lahir', 'alamat', 'no_hp', 'jenis_usaha', 'status'];

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
            return $this->orderBy('id', 'desc')->findAll();
        } else {
            return $this->where('id', $id)->first();
        }

        // if ($id == null) {
        //     return $this->findAll();
        // } else {
        //     return $this->where('customer_id', $id)->first();
        // }
    }
}
