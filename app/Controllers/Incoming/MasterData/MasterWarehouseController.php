<?php

namespace App\Controllers\Incoming\MasterData;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Incoming\MasterData\MasterWarehouseModel;

class MasterWarehouseController extends BaseController
{
    public function ListDataWarehouse() {
        return view('dashboard/master_data/master_warehouse');
    }

    public function CariDataMasterWarehouse() {
        $dataWarehouse = new MasterWarehouseModel();
        $data = $dataWarehouse->findAll();
        echo json_encode(["data" => $data]);
    }
    
}


