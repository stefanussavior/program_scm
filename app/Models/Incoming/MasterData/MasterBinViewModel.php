<?php

namespace App\Models\Incoming\MasterData;

use CodeIgniter\Model;

class MasterBinViewModel extends Model
{
    protected $table            = 'table_bin';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'kode_pallet',
        'nama_barang',
        'qty_po',
        'qty_dtg',
        'kode_prd',
        'total_qty',
        'max_qty',
        'num_paletization',
        'satuan_berat',
        'seat_number',
        'seat_group',
        'is_reserved',
    ];

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

    public function GetDetailDataSeat($dataSeat){
        if (!empty($dataSeat['seat_number']) && !empty($dataSeat['seat_group'])) {
            return $this->select('*')->where(['seat_number' => $dataSeat['seat_number'], 'seat_group' => $dataSeat['seat_group']])->first();
        } else {
            // Handle the case where $dataSeat is null or doesn't contain the expected keys
            return null; // Or you can return an empty array or handle it based on your requirement
        }
    }
}
