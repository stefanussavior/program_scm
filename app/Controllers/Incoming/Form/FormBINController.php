<?php

namespace App\Controllers\Incoming\Form;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Incoming\MasterData\MasterPOModel;
use App\Models\Incoming\MasterData\MasterGRModel;
use App\Models\Incoming\MasterData\MasterWarehouseModel;
use App\Models\Incoming\MasterData\MasterSupplierModel;
use App\Models\Incoming\MasterData\MasterBinModel;
use App\Models\Incoming\MasterData\MasterBinViewModel;
use App\Models\Incoming\MasterData\MasterPaletizationModel;
use App\Models\Incoming\MasterData\MasterBINLocationModel;

class FormBINController extends BaseController
{
    public function FormBIN() {
        $dataPO = new MasterPOModel();
        $dataGR = new MasterGRModel();
        $dataSupplier = new MasterSupplierModel();
        $dataWarehouse = new MasterWarehouseModel();
        $dataBIN = new MasterBinModel();
        $dataPallet = new MasterPaletizationModel();
        $dataBINLocation = new MasterBINLocationModel();
        $data['master_gr'] = $dataGR->GetDataGRBIN();
        $data['master_po'] = $dataPO->GetSingleDataNomorPO();
        $data['master_warehouse'] = $dataWarehouse->findAll();
        $data['master_supplier'] = $dataSupplier->findAll();
        $data['master_bin'] = $dataBIN->findAll();
        $data['master_pallet'] = $dataPallet->GetSingleNoGR();
        $data['master_bin_location'] = $dataBINLocation->findAll();
        return view('dashboard/form/form_bin', $data);
    }

    public function InsertDataBIN(){
        $masterDataBIN = new MasterBinModel();        
        $kode_pallet = $this->request->getPost('kode_pallet');
        $warehouse = $this->request->getPost('warehouse');
        $rack = $this->request->getPost('rack');
        $bin_location = $this->request->getPost('bin_location');
        $is_reversed = $this->request->getPost('is_reserved');
    
        // Check if rack and bin_location already exist
        $binModel = new MasterBinModel();
        if ($binModel->isRackBinLocationExists($rack, $bin_location)) {
            return redirect()->to(base_url('form_bin'))->with('error', 'Rack dan lokasi bin sudah digunakan. coba untuk cari lokasi yang lain');
        }
    
        $palletModel = new MasterPaletizationModel();
        $palletData = $palletModel->where('kode_pallet',$kode_pallet)->first();
    
        if ($palletData) {
            $pallet_id = $palletData['id'];
        } else {
            return redirect()->to(base_url('form_bin'))->with('error', 'No pallet data found for the provided code.');
        }
    
        $masterDataBIN->insert([
            'pallet_id' => $pallet_id,
            'kode_pallet' => $kode_pallet,
            'warehouse' => $warehouse,
            'rack' => $rack,
            'bin_location' => $bin_location,
            'is_reserved' => $is_reversed
        ]);
        return redirect()->to(base_url('form_bin'));   
    }
    


public function DisplayBINStatus() {
    $binModel = new MasterBinModel();
    $binLocationModel = new MasterBINLocationModel();
    $data['master_bin_location'] = $binLocationModel->findAll();
    // $binStatus = [];
    // foreach ($binLocations as $location) {
    //     $binStatus[$location['bin_location']] = true;
    // }
    // $data['seatStatus'] = $binStatus;
    return view('/dashboard/bin_view/display_bin', $data);
}


    public function AjaxGetNomorGR(){
        $nomor_gr = $this->request->getGet('nomor_gr');
        $GRModel = new MasterGRModel();
        $data['record'] = $GRModel->GetDataByModelGR($nomor_gr);
        $data['data'] = $GRModel->GetBarangModelGR($nomor_gr);
        return $this->response->setJSON($data);
    }


    public function GroupBySeatGroup() {
        $group = $this->request->getPost('group'); // Get the selected group
        $seatModel = new MasterBinModel();
        $isReserved = [];
        // Fetch seats based on the selected group
        $seats = $seatModel->where('rack', $group)->findAll();
    
        foreach ($seats as $seat) {
            $isReserved[$seat['bin_location']] = $seat['is_reserved'] ? 1 : 0;
        }
     
    
        // Return the seats as JSON
        return $this->response->setJSON($isReserved);
    }

    public function GetSeatData() {
        // Retrieve all GET parameters
        $binLocation = $this->request->getGet('bin_location'); 
        $SeatData = new MasterBinModel();
        $namaBarang = new MasterPaletizationModel();
        $data = $SeatData->GetDetailDataSeat($binLocation);
        $data['record'] = $namaBarang->GetDetailBarangPallet($binLocation); 
        return $this->response->setJSON($data);
    }

    public function AjaxDataGRByID() {
        $nomor_gr = $this->request->getGet('nomor_gr');
        $dataGR = new MasterGRModel();
        $data = $dataGR->GetDataByGr($nomor_gr);
        return $this->response->setJSON($data);
    }

    public function AjaxDataPOByIDBIN() {
        $nomor_po = $this->request->getGet('nomor_po');
        $dataPO = new MasterPOModel();
        $data = $dataPO->GetDataPOIDBIN($nomor_po);
        return $this->response->setJSON($data);
    }

    public function CheckBin(){
        $modelBIN = new MasterBinModel();
        $rack = $this->request->getPost('rack');
        $binLocation = $this->request->getPost('bin_location');

        // Check availability in your model or perform database query
        $available = $modelBIN->checkAvailability($rack, $binLocation);

        // Send JSON response
        return $this->response->setJSON(['available' => $available]);
    }
}
