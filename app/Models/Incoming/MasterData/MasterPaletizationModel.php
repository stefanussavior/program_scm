<?php

namespace App\Models\Incoming\MasterData;

use CodeIgniter\Model;

class MasterPaletizationModel extends Model
{
    protected $table            = 'table_paletization';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'gr_id',
        'kode_pallet',
        'nomor_gr',
        'nama_barang',
        'qty_po',
        'qty_dtg',
        'kode_prd',
        'total_qty',
        'max_qty',
        'num_paletization',
        'satuan_berat',
        // 'seat_number',
        // 'seat_group',
        // 'is_reserved'
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

   
    public function KodeOtomatisPallet() {
        $builder = $this->table('table_paletization');
        $builder->selectMax('nomor_gr','nomor_grMax');
        $query = $builder->get()->getResult();
        $kd = '';
        if ($query > 0) {
            foreach ($query as $key) {
                $ambilKode = substr($key->nomor_grMax, -4);
                $counter = (intval($ambilKode)) + 1;
                $kd = sprintf('%04s', $counter);
            }
        } else {
            $kd = '0001';
        }
        return 'PLT'.$kd;
    }

    function getSingleDataNomorGR($nomor_gr){
        return $this->select('*')->where('nomor_gr', $nomor_gr)->findAll();
    }

    public function GetDetailDataSeat($dataSeat){
        if (!empty($dataSeat['seatNumber'])) { // Check for 'seatNumber' key
            // Assuming 'seat_group' is also needed for filtering
            $seatGroup = !empty($dataSeat['seatGroup']) ? $dataSeat['seatGroup'] : null;
            // Assuming 'seatNumber' is the primary key in your database
            return $this->where('seat_number', $dataSeat['seatNumber'])
                        ->where('seat_group', $seatGroup)
                        ->first();
        } else {
            return null; // Handle the case where 'seatNumber' is not provided
        }
    }

    public function GetSingleNoGR(){
        return $this->select('*')->groupBy('kode_pallet')->findAll();
    }

    public function GetDetailBarangPallet($binLocation){
        return $this->select('nama_barang')->first();
    }
    
}
