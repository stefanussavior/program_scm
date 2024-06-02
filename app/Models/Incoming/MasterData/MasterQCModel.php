<?php

namespace App\Models\Incoming\MasterData;

use CodeIgniter\Model;

class MasterQCModel extends Model
{
    protected $table            = 'table_qc';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'po_id',
        'nomor_po',
        'nomor_qc',
        'nama_barang',
        'qty_po',
        'lots',
        'produsen',
        'coo',
        'coa',
        'sertifikat_halal',
        'uom',
        'qty_sampling',
        'qty_reject',
        'package',
        'visual_organoleptik',
        'qc_desc',
        'lots_rm',
        'perform',
        'qc_reject_desc',
        'status',
        'created_at'
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

    public function KodeOtomatisQC($startFromOne = false)
{
    // Get the current date in YYYYMMDD format
    $currentDate = date('Ymd');

    // Initialize the new QC code number
    $kd = '';
    $counter = 0;

    // Query to find the maximum nomor_qc for the current date
    $builder = $this->db->table($this->table);
    $builder->selectMax('nomor_qc', 'nomor_qcMax');
    $builder->like('nomor_qc', 'QC' . $currentDate, 'after'); // Only consider entries with the current date
    $query = $builder->get()->getRow();

    if ($query && !empty($query->nomor_qcMax)) {
        // Extract the numeric part of the maximum QC code for the current date
        $ambilKode = substr($query->nomor_qcMax, -3);
        // Increment the numeric part
        $counter = (intval($ambilKode)) + 1;
    } else {
        // If there are no entries for the current date, start with 001 or 1 based on $startFromOne
        $counter = $startFromOne ? 1 : 001;
    }

    // Format the new QC code number with leading zeros
    $kd = 'QC' . $currentDate . sprintf('%03s', $counter);

    return $kd;
}

public function updateNomorQC($nomor_qc_values, $primaryKeys)
{
    $builder = $this->db->table($this->table);
    for ($i = 0; $i < count($nomor_qc_values); $i++) {
        $builder->where($primaryKeys[$i])->set('nomor_qc', $nomor_qc_values[$i])->update();
    }
}
}
