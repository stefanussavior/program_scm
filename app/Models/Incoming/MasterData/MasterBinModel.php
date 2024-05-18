<?php

namespace App\Models\Incoming\MasterData;

use CodeIgniter\Model;

class MasterBinModel extends Model
{
    protected $table            = 'table_bin';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'pallet_id',
        'kode_pallet',
        'warehouse',
        'rack',
        'bin_location',
        'is_reserved'
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


    public function GetDetailDataSeat($binLocation) {
        return $this->db->table('table_bin')
            ->select('table_paletization.nomor_gr, table_paletization.total_qty, 
            table_paletization.nama_barang, table_paletization.satuan_berat, table_bin.kode_pallet, 
            table_bin.rack, table_bin.bin_location, table_bin.is_reserved, SUM(table_paletization.qty_dtg) AS total_qty,
            table_gr.satuan,table_gr.exp_date
            ')
            ->join('table_paletization', 'table_bin.pallet_id = table_paletization.id', 'inner')
            ->join('table_gr','table_paletization.gr_id = table_gr.id', 'inner') 
            ->where('bin_location',$binLocation)
            ->get()
            ->getResult();
    }
    

    public function isRackBinLocationExists($rack, $binLocation)
    {
        // Query to check if rack and bin_location already exist
        $query = $this->where('rack', $rack)
                      ->where('bin_location', $binLocation)
                      ->countAllResults();

        // If count is greater than 0, it means the rack and bin_location already exist
        return ($query > 0);
    }
}
