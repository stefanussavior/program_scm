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
        'supplier',
        'nomor_po',
        'tanggal_po',
        'keterangan_po',
        'tanggal_pengiriman',
        'kode',
        'nama_barang',
        'catatan',
        'qty_po',
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
    
    public function GetBarangByPO($nomor_po,$kode) {
        $hasStatusGr = $this->db->table('table_gr')
                            ->select('status_gr')
                            ->where('nomor_po', $nomor_po)
                            ->where('kode',$kode)
                            ->where('status_gr IS NOT NULL', null, false)
                            ->countAllResults();

    if ($hasStatusGr > 0) {

        return $this->db->table('table_po') 
            ->select('table_gr.id, table_gr.nama_barang, table_gr.nomor_po, table_gr.supplier, SUM(table_gr.qty_po) AS qty_po, table_gr.tanggal_po, table_gr.kode, SUM(table_gr.qty_dtg) AS qty_dtg, table_gr.status_gr, table_gr.satuan', false)
            ->where('table_gr.nomor_po', $nomor_po)
            ->where('kode',$kode)
            ->join('table_gr', 'table_gr.po_id = table_po.id', 'inner')
            ->groupBy('table_gr.kode')
            ->get()
            ->getResult();
    } else {
        return $this->db->table('table_po')
        ->select('table_po.nomor_po, table_po.nama_barang, table_po.qty_po, table_po.kode, table_po.supplier, table_po.satuan, table_gr.status_gr')
        ->where('table_po.nomor_po', $nomor_po)
        ->join('table_gr', 'table_gr.po_id = table_po.id', 'left')
        ->get()
        ->getResult();
    }    

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
        ->select('table_gr.id, table_gr.nama_barang, table_gr.nomor_po, table_gr.supplier, SUM(table_gr.qty_po) AS qty_po, table_gr.tanggal_po, table_gr.kode, SUM(table_gr.qty_dtg) AS qty_dtg, table_gr.status_gr, table_gr.satuan', false)
        ->join('table_gr', 'table_gr.po_id = table_po.id', 'inner')
        ->groupBy('table_gr.kode')
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
        
        return $this->affectedRows() > 0;
    }

    public function updateQuantity($kode, $qty_po) {
        $this->db->table('table_gr')
            ->where('kode', $kode)
            ->set('qty_po', 'qty_po + ' . $qty_po, false) 
            ->update();
        return $this->db->affectedRows() > 0;
    }
    

    public function GetCountDetailPO() {
        return $this->db->table('table_po')
            ->select('id, nomor_po, SUM(kuantitas) AS kuantitas_count, kode, nama_barang')
            ->groupBy('kode')
            ->get()
            ->getResult();
    }
    
    public function getKodeBarangPO($nomor_po) {
        $query =  $this->select('kode')->where('nomor_po',$nomor_po)->get();

        if ($query->getNumRows() > 0) {
            return $query->getRow()->kode;
        } else {
            return '';
        }
    }

    public function getKodeBarangByNomorPO($nomor_po) {
        return $this->where('nomor_po',$nomor_po)->findAll();
    }

    public function getBarangDetailNomorPO($kode_barang) {
        return $this->where('kode',$kode_barang)->first();
    }

    public function GetDataPONoGR(){
        return $this->db->table('table_po')
        ->select('table_po.*, table_gr.status_gr as status_po', false)
        ->join('table_gr', 'table_gr.po_id = table_po.id', 'inner')
        ->get()
        ->getResult();
    }

    public function GetDataQCByPO($nomor_po) {
        return $this->select('*')->where('nomor_po',$nomor_po)->first();
    }

    public function GetBarangQCByPO($nomor_po) {
        return $this->db->table('table_po')
        ->select('nomor_po,kode,supplier,nama_barang, satuan, qty_po')
        ->where('nomor_po',$nomor_po)
        ->groupBy('kode')
        ->get()
        ->getResult();
    }
}
