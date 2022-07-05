<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelProperty extends Model
{
    protected $table      = 'property';
    protected $primaryKey = 'property_id';

    protected $useAutoIncrement = true;

    protected $useSoftDeletes = FALSE;

    protected $allowedFields = ['kode_property', 'alamat', 'jenis_property', 'luas_tanah', 'luas_bangunan', 'fasilitas', 'harga', 'keterangan', 'gambar', 'status', 'jangka'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function getAll($id = null)
    {
        if ($id == 'semua') {
            return   $this->orderBy('status', 'DESC')->findAll();
        } elseif ($id == 'kios') {
            return $this->where('jenis_property', $id)->orderBy('status', 'DESC')->findAll();
        } elseif ($id == 'los') {
            return $this->where('jenis_property', $id)->orderBy('status', 'DESC')->findAll();
        } else {
            return $this->where('property_id', $id)->first();
        }
    }
    public function getKios($id = false)
    {
        if ($id == false) {
            return   $this->orderBy('property_id', 'DESC')->where('jenis_property', 'Kios')->findAll();
        } else {
            return $this->where('property_id', $id)->first();
        }
    }
    public function getLapak($id = false)
    {
        if ($id == false) {
            return   $this->orderBy('property_id', 'DESC')->where('jenis_property', 'Los')->findAll();
        } else {
            return $this->where('property_id', $id)->first();
        }
    }
    public function tersedia($id = false)
    {
        if ($id == false) {
            return   $this->orderBy('property_id', 'DESC')->where('status', '1')->findAll();
        } else {
            return $this->where('property_id', $id)->first();
        }
    }
    public function ubahStatus($id, $status)
    {


        $this->update($id, $status);
    }

    public function cekstatus()
    {
        return $this
            ->where('tanggal_sewa ' >= date(strtotime('Y-m-d')))
            ->findAll();
    }
}
