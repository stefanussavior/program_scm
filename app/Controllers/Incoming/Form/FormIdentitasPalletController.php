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


    public function InputIdentitasPallet()
    {
        $dataPallet = new MasterPaletizationModel();

        $nomor_gr = $this->request->getPost('nomor_gr');
        $nama_barang_array = $this->request->getPost('nama_barang');
        $qty_dtg_array = $this->request->getPost('qty_dtg');
        $total_qty = $this->request->getPost('total_qty');
        $max_qty = $this->request->getPost('max_qty');
        $num_paletization = $this->request->getPost('num_paletization');
        $satuan_berat_array = $this->request->getPost('satuan_berat');
        $nilai_konversi_array = $this->request->getPost('nilai_konversi');
        $kode_pallet = $this->request->getPost('kode_pallet');
        $status = $this->request->getPost('status');

        $modelGR = new MasterGRModel();
        $GRdata = $modelGR->where('nomor_gr', $nomor_gr)->first();

        if ($GRdata) {
            $gr_id = $GRdata['id'];
            $nilai_konversi_count = 0;
            $nilai_konversi_array_count = count($nilai_konversi_array);

            foreach ($nama_barang_array as $key => $nama_barang) {
                $qty_dtg = $qty_dtg_array[$key];
                $satuan_berat = $satuan_berat_array[$key];
                $kode_pallet_array_for_item = $this->request->getPost('kode_pallet' . $key);

                if (is_array($kode_pallet_array_for_item) && !empty($kode_pallet_array_for_item)) {
                    foreach ($kode_pallet_array_for_item as $index => $kode_pallet) {
                        if ($nilai_konversi_count < $nilai_konversi_array_count) {
                            $nilai_konversi = $nilai_konversi_array[$nilai_konversi_count];
                        } else {
                            $nilai_konversi = 0;
                        }

                        // Log data to debug
                        log_message('debug', 'Inserting data: ' . json_encode([
                            'gr_id' => $gr_id,
                            'kode_pallet' => $kode_pallet,
                            'nomor_gr' => $nomor_gr,
                            'nama_barang' => $nama_barang,
                            'qty_dtg' => $qty_dtg / count($kode_pallet_array_for_item),
                            'total_qty' => $total_qty,
                            'max_qty' => $max_qty,
                            'num_paletization' => $num_paletization,
                            'satuan_berat' => $satuan_berat,
                            'nilai_konversi' => $nilai_konversi,
                            'status' => $status
                        ]));

                        $dataPallet->insert([
                            'gr_id' => $gr_id,
                            'kode_pallet' => $kode_pallet,
                            'nomor_gr' => $nomor_gr,
                            'nama_barang' => $nama_barang,
                            'qty_dtg' => $qty_dtg / count($kode_pallet_array_for_item),
                            'total_qty' => $total_qty,
                            'max_qty' => $max_qty,
                            'num_paletization' => $num_paletization,
                            'satuan_berat' => $satuan_berat,
                            'nilai_konversi' => $nilai_konversi,
                            'status' => $status
                        ]);

                        $nilai_konversi_count++;
                        
                    }
                } else {
                    $kode_pallet = $kode_pallet_array_for_item;
                    if ($nilai_konversi_count < $nilai_konversi_array_count) {
                        $nilai_konversi = $nilai_konversi_array[$nilai_konversi_count];
                    } else {
                        $nilai_konversi = 0;
                    }

                    // Log data to debug
                    log_message('debug', 'Inserting data: ' . json_encode([
                        'gr_id' => $gr_id,
                        'kode_pallet' => json_encode([$kode_pallet]),
                        'nomor_gr' => $nomor_gr,
                        'nama_barang' => $nama_barang,
                        'qty_dtg' => $qty_dtg,
                        'total_qty' => $total_qty,
                        'max_qty' => $max_qty,
                        'num_paletization' => $num_paletization,
                        'satuan_berat' => $satuan_berat,
                        'nilai_konversi' => $nilai_konversi,
                    ]));

                    $dataPallet->insert([
                        'gr_id' => $gr_id,
                        'kode_pallet' => json_encode([$kode_pallet]), // Store as JSON array with one element
                        'nomor_gr' => $nomor_gr,
                        'nama_barang' => $nama_barang,
                        'qty_dtg' => $qty_dtg,
                        'total_qty' => $total_qty,
                        'max_qty' => $max_qty,
                        'num_paletization' => $num_paletization,
                        'satuan_berat' => $satuan_berat,
                        'nilai_konversi' => $nilai_konversi,
                        'status' => $status
                    ]);

                    $nilai_konversi_count++;

                    
                }
            }
        }

        return redirect()->to(base_url('master_palletization'));
    }


    function generateUniqueKodePallet() {
        $isUnique = false;
        $kodePallet = '';
    
        while (!$isUnique) {
            $kodePallet = 'PALLET-' + generateUniqueCode();
            $existing = (new MasterPaletizationModel())->where('kode_pallet', $kodePallet)->first();
            if (empty($existing)) {
                $isUnique = true;
            }
        }
    
        return $kodePallet;
    }
    

// public function InputIdentitasPallet() {

//     $dataPallet = new MasterPaletizationModel();

//     $nomor_gr = $this->request->getPost('nomor_gr');
//     $nama_barang_array = $this->request->getPost('nama_barang');
//     $qty_dtg_array = $this->request->getPost('qty_dtg');
//     $total_qty = $this->request->getPost('total_qty');
//     $max_qty = $this->request->getPost('max_qty');
//     $num_paletization = $this->request->getPost('num_paletization');
//     $satuan_berat_array = $this->request->getPost('satuan_berat');
//     $nilai_konversi_array = $this->request->getPost('nilai_konversi');

//     $modelGR = new MasterGRModel();
//     $GRdata = $modelGR->where('nomor_gr', $nomor_gr)->first();


//     if ($GRdata) {
//         $gr_id = $GRdata['id'];
//         $kode_pallet_count = 0;
//         $nilai_konversi_count = 0;

//         foreach ($nama_barang_array as $key => $nama_barang) {
//             $qty_dtg = $qty_dtg_array[$key];
//             $satuan_berat = $satuan_berat_array[$key];

//             $kode_pallet_array_for_item = $this->request->getPost('kode_pallet_' . $key);
//             $nilai_konversi_array_for_item = null;

//             if (is_array($kode_pallet_array_for_item) && !empty($kode_pallet_array_for_item)) {
//                 $nilai_konversi_array_for_item = array_slice($nilai_konversi_array, $nilai_konversi_count, count($kode_pallet_array_for_item));

//                 if (count($kode_pallet_array_for_item) === count($nilai_konversi_array_for_item)) {
//                     foreach ($kode_pallet_array_for_item as $index => $kode_pallet) {
//                         $nilai_konversi = $nilai_konversi_array_for_item[$index];

//                         // Log data to debug
//                         log_message('debug', 'Inserting data: ' . json_encode([
//                             'gr_id' => $gr_id,
//                             'kode_pallet' => json_encode($kode_pallet_array_for_item), 
//                             'nomor_gr' => $nomor_gr,
//                             'nama_barang' => $nama_barang,
//                             'qty_dtg' => $qty_dtg / count($kode_pallet_array_for_item),
//                             'total_qty' => $total_qty,
//                             'max_qty' => $max_qty,
//                             'num_paletization' => $num_paletization,
//                             'satuan_berat' => $satuan_berat,
//                             'nilai_konversi' => $nilai_konversi,
//                         ]));

//                         $dataPallet->insert([
//                             'gr_id' => $gr_id,
//                             'kode_pallet' => json_encode($kode_pallet_array_for_item), // Store as JSON
//                             'nomor_gr' => $nomor_gr,
//                             'nama_barang' => $nama_barang,
//                             'qty_dtg' => $qty_dtg / count($kode_pallet_array_for_item),
//                             'total_qty' => $total_qty,
//                             'max_qty' => $max_qty,
//                             'num_paletization' => $num_paletization,
//                             'satuan_berat' => $satuan_berat,
//                             'nilai_konversi' => $nilai_konversi,
//                         ]);
//                     }
//                 } else {
//                     // Handle the case when the lengths of $kode_pallet_array_for_item and $nilai_konversi_array_for_item are different
//                     log_message('error', 'Mismatch in lengths of $kode_pallet_array_for_item and $nilai_konversi_array_for_item for item: ' . $nama_barang);
//                 }

//                 $nilai_konversi_count += count($kode_pallet_array_for_item);
//             } else {
//                 // Handle the case when $kode_pallet_array_for_item is not an array or is an empty array
//                 $kode_pallet = $kode_pallet_array_for_item;
//                 $nilai_konversi = $nilai_konversi_array[$nilai_konversi_count];


//                 $dataPallet->insert([
//                     'gr_id' => $gr_id,
//                     'kode_pallet' => json_encode([$kode_pallet]), // Store as JSON array with one element
//                     'nomor_gr' => $nomor_gr,
//                     'nama_barang' => $nama_barang,
//                     'qty_dtg' => $qty_dtg,
//                     'total_qty' => $total_qty,
//                     'max_qty' => $max_qty,
//                     'num_paletization' => $num_paletization,
//                     'satuan_berat' => $satuan_berat,
//                     'nilai_konversi' => $nilai_konversi,
//                 ]);

//                 $nilai_konversi_count++;
//             }
//         }
//     }

//     return redirect()->to(base_url('master_palletization'));
// }

    

    public function AjaxDataGRByID() {
        $nomor_gr = $this->request->getGet('nomor_gr');
        $GRmodel = new MasterGRModel();
        $data['record'] = $GRmodel->GetDataByGr($nomor_gr);
        return $this->response->setJSON($data);
    }

    public function AjaxGetNomorGR() {
        $nomor_gr = $this->request->getGet('nomor_gr');
        $GRmodel = new MasterGRModel();
        $data['record'] = $GRmodel->GetDataByGr($nomor_gr);
        $data['data'] = $GRmodel->GetBarangAjaxGRID($nomor_gr);
        return $this->response->setJSON($data);
    }

    public function checkNomorGRExists() {
    $nomor_gr = $this->request->getPost('nomor_gr');
    $GRmodel = new MasterGRModel();
    $exists = $GRmodel->where('nomor_gr', $nomor_gr)->first();
    return $this->response->setJSON(['exists' => !empty($exists)]);
}
}