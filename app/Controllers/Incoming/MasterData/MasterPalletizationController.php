<?php

namespace App\Controllers\Incoming\MasterData;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Incoming\MasterData\MasterPaletizationModel;

class MasterPalletizationController extends BaseController
{
    public function MasterPalletView()
    {
        return view('/dashboard/master_data/master_palletization');
    }

    public function ListDataPallet() {
        $dataMasterPallet = new MasterPaletizationModel();
        $data = $dataMasterPallet->findAll();
        echo json_encode(["data" => $data]);
    }
}
