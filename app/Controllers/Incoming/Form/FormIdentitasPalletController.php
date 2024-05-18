<?php

namespace App\Controllers\Incoming\Form;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Incoming\MasterData\MasterSupplierModel;
use App\Models\Incoming\MasterData\MasterGRModel;
use App\Models\Incoming\MasterData\MasterPaletizationModel;

class FormIdentitasPalletController extends BaseController
{
    public function FormIdentitasPallet() {
        $dataSupplier = new MasterSupplierModel();
        $dataGR = new MasterGRModel();
        $data['master_supplier'] = $dataSupplier->findAll();
        $data['master_gr'] = $dataGR->GroupingDataGR();
        return view('dashboard/form/form_identitas_pallet',$data);
    }

    public function BuatKodePallet() {
        $modelGR = new MasterPaletizationModel();
        $data = $modelGR->KodeOtomatisPallet();
        return json_encode($data);
    }



    public function InputIdentitasPallet() {
        $dataPallet = new MasterPaletizationModel();

        // $kode_pallet = $this->request->getPost('kode_pallet');
        $nomor_gr = $this->request->getPost('nomor_gr');
        $nama_barang_array = $this->request->getPost('nama_barang');
        $qty_dtg_array = $this->request->getPost('qty_dtg');
        $total_qty = $this->request->getPost('total_qty');
        $max_qty = $this->request->getPost('max_qty');
        $num_paletization = $this->request->getPost('num_paletization');
        $satuan_berat_array = $this->request->getPost('satuan_berat');
        $kode_pallet_array = $this->request->getPost('kode_pallet');
        // $seat_number = $this->request->getPost('seat_number');
        // $seat_group = $this->request->getPost('seat_group');
        // $is_reserved = $this->request->getPost('is_reserved');

        $modelGR = new MasterGRModel();
        $GRdata = $modelGR->where('nomor_gr',$nomor_gr)->first();

        if ($GRdata) {
            $gr_id = $GRdata['id'];
        foreach ($nama_barang_array as $key => $nama_barang) {
            $qty_dtg = $qty_dtg_array[$key];
            $satuan_berat = $satuan_berat_array[$key];
            $kode_pallet = $kode_pallet_array[$key];

            $dataPallet->insert([
                'gr_id' => $gr_id, 
                'kode_pallet' => $kode_pallet,
                'nomor_gr' => $nomor_gr,
                'nama_barang' => $nama_barang,
                'qty_dtg' => $qty_dtg,
                'total_qty' => $total_qty,
                'max_qty' => $max_qty,
                'num_paletization' => $num_paletization,
                'satuan_berat' => $satuan_berat,
                // 'seat_number' => $seat_number,
                // 'seat_group' => $seat_group,
                // 'is_reserved' => $is_reserved
            ]);
        }
    }
        return redirect()->to(base_url('master_palletization'));
    }

    public function AjaxDataGRByID() {
        $nomor_gr = $this->request->getGet('nomor_gr');
        $GRmodel = new MasterGRModel();
        $data['record'] = $GRmodel->GetDataByGr($nomor_gr);
        return $this->response->setJSON($data);
    }

    public function AjaxGetNomorGR(){
        $nomor_gr = $this->request->getGet('nomor_gr');
        $GRmodel = new MasterGRModel();
        $data['record'] = $GRmodel->GetDataByGr($nomor_gr);
        $data['data'] = $GRmodel->GetBarangAjaxGRID($nomor_gr);
        return $this->response->setJSON($data);
    }
    
}
