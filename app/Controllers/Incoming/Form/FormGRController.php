<?php

namespace App\Controllers\Incoming\Form;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Incoming\MasterData\MasterPOModel;
use App\Models\Incoming\MasterData\MasterSupplierModel;
use App\Models\Incoming\MasterData\MasterWarehouseModel;
use App\Models\Incoming\MasterData\MasterGRModel;


class FormGRController extends BaseController
{
    public function FormGoodReceive(){
        $dataPO = new MasterPOModel();
        $dataWarehouse =  new MasterWarehouseModel();
        $dataSupplier = new MasterSupplierModel();
        $dataGR = new MasterGRModel();
        $data['master_po'] = $dataPO->get()->getResultArray();
        $data['master_warehouse'] = $dataWarehouse->findAll();
        $data['master_supplier'] = $dataSupplier->GetSingleDataSupplier();
        $data['master_po2'] = $dataPO->GetSingleDataNomorPO();
        $data['master_gr'] =  $dataGR->findAll();
        return view('dashboard/form/form_good_receive',$data);
    }

    public function AjaxDataPOByID() {
        $nomor_po = $this->request->getGet('nomor_po');
        $kode = $this->request->getGet('kode');
        $POModel = new MasterPOModel();
        $data['record'] = $POModel->GetDataByPO($nomor_po);
        $data['data'] = $POModel->GetBarangByPO($nomor_po,$kode);
        return $this->response->setJSON($data);
    }

    public function InputDataGoodReceive()
    {
        $GoodReceive = new MasterGRModel();


        date_default_timezone_set('Asia/Jakarta');
    

        $kode_barang_array = $this->request->getPost('kode');
        $nomor_po = $this->request->getPost('nomor_po');
        $tanggal_po = $this->request->getVar('tanggal_po');
        $supplier_array = $this->request->getPost('supplier');
        $est_kirim = $this->request->getPost('est_kirim');
        $nomor_gr = $this->request->getPost('nomor_gr');
        $desc_gr = $this->request->getPost('desc_gr');
        $tanggal_gr = $this->request->getPost('tanggal_gr');
        $warehouse = $this->request->getPost('warehouse');
        $kode_batch_array = $this->request->getPost('kode_batch');
        $kode_prd = $this->request->getPost('kode_prd');
        $exp_date_array = $this->request->getPost('exp_date');
        $qty_po_array = $this->request->getPost('qty_po');
        $nama_barang_array = $this->request->getPost('nama_barang');
        $qty_dtg_array = $this->request->getPost('qty_dtg');
        $satuan_berat_array = $this->request->getPost('satuan');
        $qty_gr_outstd_array = $this->request->getPost('qty_gr_outstd');

    $lastGoodReceive = $GoodReceive->orderBy('created_at', 'desc')->first();
    $lastGoodReceiveCreatedAt = $lastGoodReceive ? $lastGoodReceive['created_at'] : null;

    
        $poModel = new MasterPOModel();
        $poData = $poModel->where('nomor_po',$nomor_po)->first();
        
        if ($poData) {
            $po_id = $poData['id'];

        foreach ($qty_dtg_array as $key => $qty_dtg) {

            if (isset($qty_po_array[$key]) && isset($nama_barang_array[$key]) && isset($kode_batch_array[$key]) && isset($exp_date_array[$key]) &&
                isset($satuan_berat_array[$key]) && isset($kode_barang_array[$key]) && isset($supplier_array[$key]) && isset($qty_gr_outstd_array[$key])
                ) {

                $qty_po = $qty_po_array[$key];
                $nama_barang = $nama_barang_array[$key];
                $kode_batch = $kode_batch_array[$key];
                $exp_date = $exp_date_array[$key];
                $satuan_berat = $satuan_berat_array[$key];
                $kode_barang = $kode_barang_array[$key];
                $supplier_barang = $supplier_array[$key];
                $qty_gr_outstd = $qty_gr_outstd_array[$key];
            } else {
                log_message('error', 'Missing key at index ' . $key);
                return redirect()->back()->withInput()->with('error', 'Missing data at index ' . $key);
            }
    

            if ($qty_dtg == $qty_po) {
                $status_gr = 'fulfilled';
            } elseif ($qty_dtg > $qty_po) { 
                return redirect()->to(base_url('/form_good_receive'))->with('error', 'Quantity ordered cannot be less than quantity received.');
            } else  {
                $status_gr = 'outstanding';
            }
    

            $GoodReceive->insert([
                'po_id' => $po_id,
                'nomor_po' => $nomor_po,
                'tanggal_po' => $tanggal_po,
                'kode' => $kode_barang,
                'nama_barang' => $nama_barang,
                'nomor_gr' => $nomor_gr,
                'desc_gr' => $desc_gr,
                'tanggal_gr' => $tanggal_gr,
                'warehouse' => $warehouse,
                'supplier' => $supplier_barang,
                'est_kirim' => $est_kirim,
                'qty_po' => $qty_po,
                'qty_dtg' => $qty_dtg,
                'batch' => $this->request->getPost('batch'),
                'kode_batch' => $kode_batch,
                'kode_prd' => $kode_prd,
                'exp_date' => $exp_date,
                'satuan' => $satuan_berat,
                'qty_gr_outstd' => $qty_gr_outstd,
                'status_gr' => $status_gr,
                'created_at' => date('Y-m-d H:i:s')
                 // Set status_gr based on the conditions
            ]);
        }
        return redirect()->to(base_url('master_data_po'));
    } else {
        return redirect()->back()->withInput()->with('error', 'Failed to insert data into table_gr.');
    }
}

    public function GetDataSupplierAjax() {
        $pemasok = $this->request->getGet('pemasok');
        $Supplier = new MasterSupplierModel();
        $data['data'] = $Supplier->GetDataPemasok($pemasok);
        return $this->response->setJSON($data);
    }

    public function BuatKodeGR() {
        $modelGR = new MasterGRModel();
        $data = $modelGR->KodeOtomatisGR();
        return json_encode($data);
    }
    
    public function BuatKodeBatch() {
        $modelGR = new MasterGRModel();
        $data = $modelGR->KodeOtomatisKodeBatch();
        return json_encode($data);
    }

    public function BuatKodePRD() {
        $modelGR = new MasterGRModel();
        $data = $modelGR->KodeOtomatisPRD();
        return json_encode($data);
    }

    public function checkPOFulfilled() {
        $nomor_po = $this->request->getPost('nomor_po');
        $modelGR = new MasterGRModel();
        $status = $modelGR->isPOFullFiled($nomor_po);
        $totalQtyPerBarang = $modelGR->GettotalQtyDtgPerBarang();
        
        // Convert the array $totalQtyPerBarang to a string
        $totalQtyString = '';
        foreach ($totalQtyPerBarang as $qty) {
            $totalQtyString .= "Kode: {$qty['kode']}, Nama Barang: {$qty['nama_barang']}, Qty: {$qty['qty_total']},  | ";
        }
        
        switch ($status) {
            case 'outstanding':
                $message = 'Nomor PO ' . $nomor_po . ' masih outstanding. saat ini Total Qty yang belum terproses dari masing-masing barang : ' . $totalQtyString . '\nKlik Tambah Form GR untuk menambahkan data barang baru';
                break;
            case 'fulfilled':
                $message = 'Nomor PO ' . $nomor_po . ' sudah selesai diproses.';
                break;
            case 'not_fulfilled':
                $message = 'Nomor PO ' . $nomor_po . ' belum diproses.';
                break;
            default:
                $message = 'Error occurred while checking PO status.';
                break;
        }
        
        $response = array('status' => $status, 'message' => $message);
        echo json_encode($response);
    }

    public function fetchKodeBarang()
    {
        $nomor_po = $this->request->getPost('nomor_po');
        $dataPO = new MasterPOModel();
        $kode_barang_data = $dataPO->getKodeBarangByNomorPO($nomor_po);
        return $this->response->setJSON($kode_barang_data);
    }

    public function fetchBarangDetail(){
        $kode_barang = $this->request->getPost('kode');
        $dataPO = new MasterGRModel();
        $data = $dataPO->getBarangDetailNomorPO($kode_barang);
        return $this->response->setJSON(['data' => $data]);
    }

    public function fetchQtyDtg() {
        $nomor_po = $this->request->getPost('nomor_po');
        $modelGR = new MasterGRModel();
        $data = $modelGR->getDataQtyDtg($nomor_po);
    
        if (!empty($data)) {
            $response = [
                'status' => 'success',
                'qty_dtg' => $data[0]->qty_dtg // Adjust according to your actual data structure
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'No data found for the given PO number.'
            ];
        }
    
        return $this->response->setJSON($response);
    }
    
}
