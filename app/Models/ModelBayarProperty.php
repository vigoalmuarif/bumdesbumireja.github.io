<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelBayarProperty extends Model
{
    protected $table      = 'property_payment';
    protected $primaryKey = 'payment_id';

    protected $useAutoIncrement = true;

    protected $useSoftDeletes = true;

    protected $allowedFields = ['sewa_id', 'user_id', 'pembayaran_id', 'bayar', 'keterangan'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}
