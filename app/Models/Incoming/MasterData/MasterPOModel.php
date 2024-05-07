<?php

namespace App\Models\Incoming\MasterData;

use CodeIgniter\Model;

class MasterPOModel extends Model
{
    protected $table            = 'table_po';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id',
        'pemasok',
        'nomor_po',
        'tanggal_po',
        'keterangan_po',
        'tanggal_pengiriman',
        'kode',
        'nama_barang',
        'catatan',
        'kuantitas',
        'qty_terproses',
        'qty_belum_terp',
        'satuan'
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

    public function GetSingleDataNomorPO() {
        $query = $this->db->query('SELECT DISTINCT nomor_po from table_po');
        return $query->getResultArray();
    }

    public function GetDataByPO($nomor_po) {
        return $this->select('*')->where('nomor_po',$nomor_po)->first();
    }
    
    public function GetBarangByPO($nomor_po) {
        return $this->select('nama_barang, kuantitas, kode, pemasok, satuan')->where('nomor_po', $nomor_po)->findAll();
    }
    public function updateData($id,$data) 
    {
        return $this->update($id,$data);
    }

    public function GetDataPOIDBIN($nomor_po){
        return $this->select('*')->where('nomor_po',$nomor_po)->findAll();
    }


    public function GetMultiTableData()
    {
        return $this->db->table('table_po')
        ->select('table_gr.id, table_gr.nama_barang, table_gr.nomor_po, table_gr.supplier, table_gr.qty_po, table_gr.tanggal_po, table_gr.kode, table_gr.qty_dtg, table_gr.status_gr, table_gr.satuan', false)
        ->join('table_gr', 'table_gr.po_id = table_po.id', 'inner')
        ->get()
        ->getResult();
    }
    
    public function UpdateDataMasterPO($id, $qty_dtg) {
        $data = [
            'qty_dtg' => $qty_dtg
        ];

        // Update operation
        $this->db->table('table_gr')
             ->where('id', $id)
             ->update($data);
        
        // Check if any row is affected
        return $this->affectedRows() > 0;
    }

    public function updateQuantity($id, $qty_dtg) {
        // Assuming 'your_table' is the name of your database table
        $this->db->table('your_table')
                 ->where('id', $id)
                 ->update(['qty_dtg' => $qty_dtg]);
    }
    
}
