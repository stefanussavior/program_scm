<?php

namespace App\Models\Incoming\MasterData;

use CodeIgniter\Model;

class MasterSupplierModel extends Model
{
    protected $table            = 'master_supplier';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];


    public function GetSingleDataSupplier() {
        $query = $this->db->query('SELECT * from master_supplier GROUP BY kode_pemasok');
        return $query->getResultArray();
    }

    function GetDataPemasok($pemasok) {
        return $this->select('nama_barang')->where('pemasok', $pemasok)->findAll();
    }

    public function searchDataSupplier($pemasok, $nama_barang) {
        return $this->like('pemasok', $pemasok)
                    ->like('nama_barang', $nama_barang);
    }
}
