<?php

namespace App\Controllers\Incoming\MasterData;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Incoming\MasterData\MasterBinModel;

class MasterBinController extends BaseController
{
    public function MasterBin() {
        return view('dashboard/master_data/master_bin');
    }

    public function ListDataBIN() {
        $dataMasterBIN = new MasterBinModel();
        $data = $dataMasterBIN->findAll();
        echo json_encode(["data" => $data]);
    }

    
}
