<?php

namespace App\Controllers\Incoming\MasterData;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Incoming\MasterData\MasterBarangModel;

class MasterBarangController extends BaseController
{


    public function MasterBarangView() {
        return view('dashboard/master_data/master_barang');
    }

    public function ListDataBarang()
    {
        $dataMasterBarang = new MasterBarangModel();
        $data = $dataMasterBarang->findAll();
        echo json_encode(["data" => $data]);
    }
}
