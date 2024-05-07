<?php

namespace App\Controllers\Incoming\MasterData;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Incoming\MasterData\MasterGRModel;

class MasterGRController extends BaseController
{
    public function MasterGR() {
        return view('dashboard/master_data/master_gr');
    }

    public function CariDataMasterGR(){
        $dataMasterGR = new MasterGRModel();
        $data = $dataMasterGR->findAll();
        echo json_encode(["data" => $data]);
    }
}
