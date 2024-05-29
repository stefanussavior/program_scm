<?php

namespace App\Controllers\Incoming\MasterData;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Incoming\MasterData\MasterQCModel;

class MasterQCController extends BaseController
{
    public function index()
    {
        return view('dashboard/master_data/master_qc');
    }

    public function GetDataQC() {
        $dataQC = new MasterQCModel();
        $data = $dataQC->findAll();
        return $this->response->setJSON(['data'=>$data]);
    }
}
