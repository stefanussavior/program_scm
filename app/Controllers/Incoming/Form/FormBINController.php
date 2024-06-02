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
        $data['master_pallet'] = $dataPallet->GetSingleData();
        $data['master_bin_location'] = $dataBINLocation->findAll();
        return view('dashboard/form/form_bin', $data);
    }

    public function InsertDataBIN() {
        $nama_barang = $this->request->getPost('nama_barang');
        $kode_pallet = $this->request->getPost('kode_pallet');
        $warehouse = $this->request->getPost('warehouse');
        $rack = $this->request->getPost('rack');
        $bin_location = $this->request->getPost('bin_location');
        $is_reserved = $this->request->getPost('is_reserved');
    
        // Validate that the data is arrays
        if (!is_array($kode_pallet) || !is_array($rack) || !is_array($bin_location)) {
            return redirect()->to(base_url('/form_bin'))->with('error', 'Data Invalid.');
        }
    
        $binModel = new MasterBinModel();
        $palletModel = new MasterPaletizationModel();
    
        foreach ($kode_pallet as $index => $pallet) {
            if ($binModel->isRackBinLocationExists($rack[$index], $bin_location[$index])) {
                return redirect()->to(base_url('/form_bin'))->with('error', 'Rack dan BIN Sudah digunakan. silahkan untuk mencari tempat yang lain');
            }
    
            $palletData = $palletModel->where('kode_pallet', $pallet)->first();
    
            if (!$palletData) {
                return redirect()->to(base_url('/form_bin'))->with('error', 'Maaf, Tidak ada kode pallet');
            }
    
            $pallet_id = $palletData['id'];
    
            $binModel->insert([
                'pallet_id' => $pallet_id,
                'nama_barang' => $nama_barang,
                'kode_pallet' => $pallet,
                'warehouse' => $warehouse,
                'rack' => $rack[$index],
                'bin_location' => $bin_location[$index],
                'is_reserved' => $is_reserved
            ]);
        }
    
        return redirect()->to(base_url('/display_data_bin_view'));
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

    public function showData() {
        $kode_pallet = $this->request->getVar('kode_pallet');
        $nama_barang = $this->request->getVar('nama_barang');
        $total_qty_barang = $this->request->getVar('total_qty_barang');
        $satuan = $this->request->getVar('satuan');
        $exp_date = $this->request->getVar('exp_date');
        $lokasi_rack = $this->request->getVar('lokasi_rack');
        $bin_location = $this->request->getVar('bin_location');
        
        // Pass these to the view
        return view('show_data', compact('kode_pallet', 'nama_barang', 'total_qty_barang', 'satuan', 'exp_date', 'lokasi_rack', 'bin_location'));
    }
    
    public function GetNamaBarang() {
        $nama_barang = $this->request->getGet('nama_barang');
        $dataBIN = new MasterPaletizationModel();
        $data = $dataBIN->GetNamaBarangModel($nama_barang);
        return $this->response->setJSON($data);
    }

    public function GetShowData(){
        $kode_pallet = $this->request->getGet('kode_pallet');
        $nama_barang = $this->request->getGet('nama_barang');
        $total_qty_barang = $this->request->getGet('total_qty_barang');
        $satuan = $this->request->getGet('satuan');
        $exp_date = $this->request->getGet('exp_date');
        $lokasi_rack = $this->request->getGet('lokasi_rack');
        $bin_location = $this->request->getGet('bin_location');

        
        $binModel = new MasterBinModel(); 
        $binData = $binModel->getBinData($bin_location); // Implement this method in your model

        // Prepare JSON response
        $response = [
            'kode_pallet' => $kode_pallet,
            'nama_barang' => $nama_barang,
            'total_qty_barang' => $total_qty_barang,
            'satuan' => $satuan,
            'exp_date' => $exp_date,
            'lokasi_rack' => $lokasi_rack,
            'bin_location' => $bin_location
        ];

        // // Return JSON response
        // return $this->response->setJSON($response);
        return view('/dashboard/bin_view/qrcode_data', $response);
    }

    public function CheckKodePalletExists() {
        $kode_pallet = $this->request->getPost('kode_pallet');
        $dataBIN = new MasterBinModel();
        $exists = $dataBIN->checkKodePalletExists($kode_pallet);

        return $this->response->setJSON(['exists' => !empty($exists)]);
    }
}
