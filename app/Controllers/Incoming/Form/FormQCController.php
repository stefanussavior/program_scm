<?php

namespace App\Controllers\Incoming\Form;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Incoming\MasterData\MasterPOModel;
use App\Models\Incoming\MasterData\MasterSupplierModel;
use App\Models\Incoming\MasterData\MasterWarehouseModel;
use App\Models\Incoming\MasterData\MasterGRModel;
use App\Models\Incoming\MasterData\MasterQCModel;

class FormQCController extends BaseController
{
    public function index()
    {
        $dataPO = new MasterPOModel();
        $dataWarehouse =  new MasterWarehouseModel();
        $dataSupplier = new MasterSupplierModel();
        $dataGR = new MasterGRModel();
        $data['master_po'] = $dataPO->get()->getResultArray();
        $data['master_warehouse'] = $dataWarehouse->findAll();
        $data['master_supplier'] = $dataSupplier->GetSingleDataSupplier();
        $data['master_po2'] = $dataPO->GetSingleDataNomorPO();
        $data['master_gr'] =  $dataGR->findAll();
        return view('/dashboard/form/form_qc', $data);
    }

    public function AjaxGetDataGRNomorPO(){
        $nomor_po = $this->request->getGet('nomor_po');
        $POModel = new MasterPOModel();
        $data['data'] = $POModel->GetDataQCByPO($nomor_po);
        $data['record'] = $POModel->GetBarangQCByPO($nomor_po);
        return $this->response->setJSON($data);
    }

    public function SubmitFormQC() {

        $QCModel = new MasterQCModel();

        date_default_timezone_set('Asia/Jakarta');

        $nomor_po = $this->request->getPost('nomor_po');
        $nama_barang_array = $this->request->getPost('nama_barang');
        $nomor_qc_array = $this->request->getPost('nomor_qc');
        $qty_po_array = $this->request->getPost('qty_po');
        $lots_array = $this->request->getPost('lots');
        $produsen_array = $this->request->getPost('produsen');
        $coo_array = $this->request->getPost('coo');
        $coa_array = $this->request->getPost('coa');
        $sertifikat_halal_array = $this->request->getPost('sertifikat_halal');
        $uom_sampling_array = $this->request->getPost('uom');
        $qty_sampling_array = $this->request->getPost('qty_sampling');
        $qty_reject_array =  $this->request->getPost('qty_reject');
        $package_array = $this->request->getPost('package');
        $visual_organoleptik_array = $this->request->getPost('visual_organoleptik');
        $qc_desc_array = $this->request->getPost('qc_desc');
        $lots_rm_array = $this->request->getPost('lots_rm');
        $perform_array = $this->request->getPost('perform');
        $qc_reject_desc_array = $this->request->getPost('qc_reject_desc');
        $status_array = $this->request->getPost('status');
        

        $lastQualityControl = $QCModel->orderBy('created_at', 'desc')->first();
        $lastQualityControlCreatedAt = $lastQualityControl ? $lastQualityControl['created_at'] : null;

        $POModel = new MasterPOModel();
        $POData = $POModel->where('nomor_po', $nomor_po)->first();

        if ($POData) {
            $po_id = $POData['id'];

        foreach ($nama_barang_array as $key => $nama_barang) {
            $nama_barang = $nama_barang_array[$key];
            $nomor_qc = $nomor_qc_array[$key];
            $qty_po = $qty_po_array[$key];
            $lots = $lots_array[$key];
            $produsen = $produsen_array[$key];
            $coo = $coo_array[$key];
            $coa = $coa_array[$key];
            $sertifikat_halal = $sertifikat_halal_array[$key];
            $uom_sampling = $uom_sampling_array[$key];
            $qty_sampling = $qty_sampling_array[$key];
            $qty_reject = $qty_reject_array[$key];
            $package = $package_array[$key];
            $visual_organoleptik = $visual_organoleptik_array[$key];
            $qc_desc = $qc_desc_array[$key];
            $lots_rm = $lots_rm_array[$key];
            $perform = $perform_array[$key];
            $qc_reject_desc = $qc_reject_desc_array[$key];
            $status = $status_array[$key];

            $QCModel->insert([
                'po_id' => $po_id,
                'nomor_po' => $nomor_po,
                'nomor_qc' => $nomor_qc,
                'nama_barang' => $nama_barang,
                'qty_po' => $qty_po,
                'lots' => $lots,
                'produsen' => $produsen,
                'coo' => $coo,
                'coa' => $coa,
                'sertifikat_halal' => $sertifikat_halal,
                'uom' => $uom_sampling,
                'qty_sampling' => $qty_sampling,
                'qty_reject' => $qty_reject,
                'package' => $package,
                'visual_organoleptik' => $visual_organoleptik,
                'qc_desc' => $qc_desc,
                'lots_rm' => $lots_rm,
                'perform' => $perform,
                'qc_reject_desc' => $qc_reject_desc,
                'status' => $status,
                'created_at' => date('Y-m-d H:i:s')
            ]);
            return redirect()->to(base_url('/master_data_qc'));
            }
        } else {
            log_message('error', 'Missing key at index ' . $key);
            return redirect()->back()->withInput()->with('error', 'Missing data at index ' . $key);
        }
    }   

    public function EditDataQC() {
        $qc_id = $this->request->getPost('id');
        $data = [
            'nama_barang' => $this->request->getPost('product'),
            'status' => $this->request->getPost('status')
        ];
        $dataQC = new MasterQCModel();
        $dataQC->update($qc_id,$data);
        
        return $this->response->setJSON(['status' => 'success', 'message' => 'Data Berhasil Terupdate']);
    }   

    public function BuatKodeQC()
    {
        $modelQC = new MasterQCModel();
        $data = [];
        $startFromOne = !isset($_POST['nama_barang']);
        $count = isset($_POST['nama_barang']) ? count($_POST['nama_barang']) : 1;
        for ($i = 0; $i < $count; $i++) {
            $data[] = $modelQC->KodeOtomatisQC($startFromOne);
            $startFromOne = false; // After the first iteration, always increment
        }
        return json_encode($data);
    }
}
