<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelCustomerAtk extends Model
{
    protected $table      = 'customer_atk';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $useSoftDeletes = false;

    protected $allowedFields = [];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function get_customer()
    {

        $db = $this->db->table('customer_atk');
        $db->orderBy('nama', 'dsc');
        return $db->get()->getResultArray();
    }
}
