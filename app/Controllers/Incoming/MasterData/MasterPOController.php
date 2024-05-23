<?php

namespace App\Controllers\Incoming\MasterData;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\API\ResponseTrait;
use App\Models\Incoming\MasterData\MasterPOModel;
use App\Models\Incoming\MasterData\MasterGRModel;

class MasterPOController extends BaseController
{

    use ResponseTrait;

    public function MasterDataPO() {
        return view('dashboard/master_data/master_po');
    }

    public function MasterUploadDataPO(){
        return view('dashboard/master_data/master_po_not_gr');
    }
    
    public function ListDataPO(){
        $dataPO = new MasterPOModel();
        $data = $dataPO->GetMultiTableData();
        echo json_encode(["data" => $data]);
    }

    public function GetAllDataUploadPO(){
        $dataAllUploadPO = new MasterPOModel();
        $data = $dataAllUploadPO->findAll();
        echo json_encode(["data" => $data]);
    }

    public function GetAllDataUploadPONoGR(){
        $dataAllUploadPO = new MasterPOModel();
        $data = $dataAllUploadPO->findAll();
        // $data = $dataAllUploadPO->GetDataPONoGR();
        echo json_encode(["data" => $data]);
    }



    public function getPODetails()
    {
        $poId = $this->request->getVar('id');
        $model = new MasterGRModel();
        $po = $model->find($poId);

        if ($po === null) {
            return $this->failNotFound('PO not found.');
        }
        return $this->respond(['data' => $po]);
    }

    // public function editPO()
    // {
    //     $id = $this->request->getPost('id');
    //     $qty_po = $this->request->getPost('qty_po');
    //     $qty_dtg = $this->request->getPost('qty_dtg');
    
    //     // Check if the PO is now fulfilled
    //     if ($qty_dtg == $qty_po) {
    //         $status_gr = 'fulfilled';
    //     } elseif ($qty_dtg < $qty_po) {
    //         $status_gr = 'outstanding';
    //     } elseif ($qty_dtg > $qty_po) {
    //         $status_gr = "error";
    //     }
    
    //     // Update the PO details and status_gr in the database
    //     $modelPO = new MasterGRModel();
    //     $updated = $modelPO->update($id, [
    //         'qty_po' => $qty_po,
    //         'status_gr' => $status_gr
    //     ]);
    
    //     if ($updated) {
    //         // Retrieve the updated PO details from the database
    //         $updatedPO = $modelPO->find($id);
    
    //         // Prepare the updated PO data for JSON response
    //         $response = [
    //             'success' => true,
    //             'data' => $updatedPO // Include the updated PO details
    //         ];
    
    //         return $this->response->setJSON($response);
    //     } else {
    //         // Error handling if update fails
    //         $response = [
    //             'success' => false,
    //             'error' => 'Failed to update PO'
    //         ];
    
    //         return $this->response->setJSON($response)->setStatusCode(500);
    //     }
    // }

    public function UpdateQtyPO() {
        $id = $this->request->getPost('id');
        $qty_po = $this->request->getPost('qty_po');    
    }
    
    public function UpdateDataMasterPO() {
        $id = $this->request->getPost('id');
        $qty_dtg = $this->request->getPost('qty_dtg');
    
        // Validation: Check if ID and quantity are provided
        if (!$id || !$qty_dtg) {
            echo json_encode(['success' => false, 'message' => 'ID and quantity are required']);
            return;
        }
    
        // Load your model
        $model = new MasterPOModel(); // Replace YourModel with your actual model name
    
        // Update data in the database
        try {
            // Assuming your model has a method to update the quantity based on ID
            $model->updateQuantity($id, $qty_dtg);
    
            echo json_encode(['success' => true, 'message' => 'Data updated successfully']);
        } catch (\Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Failed to update data: ' . $e->getMessage()]);
        }
    }


    public function MasterPOCountDetail() {
        return view('dashboard/master_data/master_total_po');
    }

    public function tablePODetails() {
        $dataPODetails = new MasterPOModel();
        $data =  $dataPODetails->GetCountDetailPO();
        echo json_encode(['data' => $data]);
    }



    public function updateQuantity() {
        $id = $this->request->getPost('id');
        $qty_po = $this->request->getPost('qty_po');
   
        // Validation: Check if ID and quantity are provided
        if (!$id || !$qty_po) {
            echo json_encode(['success' => false, 'message' => 'ID and quantity are required']);
            return;
        }
        // Validasi: Periksa apakah ID dan quantity disediakan
    if ($id === null || $qty_po === null) {
        echo json_encode(['status' => 'error', 'message' => 'ID and quantity are required']);
        return;
    }
   
        // Load your model
        $model = new MasterPOModel(); // Ganti YourModel dengan nama model yang sesuai
   
        // Update data in the database
        try {
            // Asumsikan model Anda memiliki metode untuk memperbarui kuantitas berdasarkan ID
            $model->updateQuantity($id, $qty_po);
           
            // Mengirimkan respons JSON
            echo json_encode(['status' => 'success', 'message' => 'Data updated successfully']);
        } catch (\Exception $e) {
            // Menangani kesalahan jika gagal memperbarui data
            echo json_encode(['success' => false, 'message' => 'Failed to update data: ' . $e->getMessage()]);
        }
    }
}
    
