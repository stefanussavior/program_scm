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



    public function getPODetails()
    {
        // Get the ID of the PO from the AJAX request
        $poId = $this->request->getVar('id');

        // Fetch PO details from the model
        $model = new MasterGRModel();
        $po = $model->find($poId);

        // Check if the PO exists
        if ($po === null) {
            // Return error response if PO is not found
            return $this->failNotFound('PO not found.');
        }

        // Return the PO details as JSON
        return $this->respond(['data' => $po]);
    }

    public function editPO()
    {
        $id = $this->request->getPost('id');
        $qty_po = $this->request->getPost('qty_po');
        $qty_dtg = $this->request->getPost('qty_dtg');

    // Check if the PO is now fulfilled
    if ($qty_dtg == $qty_po) {
        $status_gr = 'fullfiled';
    } elseif ($qty_dtg < $qty_po) {
        $status_gr = 'outstanding';
    } elseif ($qty_dtg > $qty_po) {
        $status_gr = null;
    }

    // Update the PO details and status_gr in the database
    $modelPO = new MasterGRModel();
    $modelPO->update($id, [
        'qty_po' => $qty_po,
        'status_gr' => $status_gr
    ]);

    return $this->response->setJSON(['success' => true]);
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
}
    
