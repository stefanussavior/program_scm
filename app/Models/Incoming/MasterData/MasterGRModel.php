<?php

namespace App\Models\Incoming\MasterData;

use CodeIgniter\Model;

class MasterGRModel extends Model
{
    protected $table            = 'table_gr';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'po_id',
        'nomor_po',
        'kode',
        'tanggal_po',
        'nama_barang',
        'tanggal_gr',
        'nomor_gr',
        'warehouse',
        'supplier',
        'status_gr',
        'qty_po',
        'qty_dtg',
        'kode_prd',
        'kode_batch',
        'exp_date',
        'satuan',
        'seat_number',
        'seat_group',
        'is_reserved',
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


    function KodeOtomatisGR() {
        $builder = $this->table('table_gr');
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
        return 'GR'.$kd;
    }

    function KodeOtomatisKodeBatch() {
        $builder = $this->table('table_gr');
        $builder->selectMax('kode_batch','kode_batchMax');
        $query = $builder->get()->getResult();
        $kd = '';
        if ($query > 0) {
            foreach ($query as $key) {
                $ambilKode = substr($key->kode_batchMax, -4);
                $counter = (intval($ambilKode) + 1);
                $kd = sprintf('%04s',$counter);
            }
        } else {
            $kd = '0001';
        }
        return 'KBH'.$kd;
    }

    function KodeOtomatisPRD() {
        $builder = $this->table('table_gr');
        $builder->selectMax('kode_prd','kode_prdMax');
        $query = $builder->get()->getResult();
        $kd = '';

        if ($query > 0) {
            foreach ($query as $key) {
                $ambilKode = substr($key->kode_prdMax, -4);
                $counter = (intval($ambilKode) + 1);
                $kd = sprintf('%04s', $counter);
            }
        } else {
            $kd = '0001';
        }
        return 'PRD'.$kd;
    }

    public function GetDataByGr($nomor_gr) {
        return $this->where('nomor_gr', $nomor_gr)->groupBy('nomor_gr')->findAll();
    }

    public function GroupingDataGR(){
        return $this->select('*')->groupBy('nomor_gr')->findAll();
    }

    public function GetDataByModelGR($nomor_gr) {
        return $this->select('*')->where('nomor_gr',$nomor_gr)->first();
    }
    
    public function GetBarangModelGR($nomor_gr) {
        return $this->select('*')->where('nomor_gr', $nomor_gr)->findAll();
    }

    public function GetDataGRBIN() {
        return $this->select('*')->groupBy('nomor_gr')->findAll();
    }

    public function GetDataAJAXGR($nomor_gr) {
        return $this->select('*')->where('nomor_gr',$nomor_gr)->findAll();
    }

    public function GetBarangAjaxGRID($nomor_gr) {
        return $this->where('nomor_gr',$nomor_gr)->findAll();
    }

    public function GetDataMasterGR($tanggal_awal, $tanggal_akhir) {
        $this->where('tanggal_gr >=', $tanggal_awal);
        if ($tanggal_akhir !== null) {
            $this->where('tanggal_gr <=', $tanggal_akhir);
        } else {
            $this->where('tanggal_gr IS NOT NULL');
        }
        return $this->findAll();
    }

    public function updateMasterPO($id, $qty_terproses)
    {
        // Update record in the database
        $data = [
            'qty_terproses' => $qty_terproses
        ];

        // Update operation
        $this->set($data)->where('id', $id)->update();
        
        // Check if any row is affected
        return $this->affectedRows() > 0;
    }

    public function isPOFullFiled($nomor_po) {
        return $this->where('nomor_po', $nomor_po)
                    ->where('status_gr', 'fulfilled')
                    ->countAllResults() > 0;
    }
    


    public function getQuantity($poId)
    {
        // Fetch quantity data based on PO ID
        $query = $this->db->table($this->table)
            ->select('qty_po')
            ->where('po_id', $poId)
            ->get();
        $row = $query->getRow();
        return $row ? $row->qty_po : null;
    }

    public function updateQuantity($poId, $newQty)
    {
        // Update quantity data for the PO
        $this->db->table($this->table)
            ->where('po_id', $poId)
            ->set('qty_po', $newQty)
            ->update();
    }
}
