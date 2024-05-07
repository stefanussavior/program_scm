<?php

namespace App\Controllers\Incoming\MasterData;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Incoming\MasterData\MasterSupplierModel;

class MasterSupplierController extends BaseController
{
    public function MasterDataSupplier() {
        // $masterSupplier =  new MasterSupplierModel();
        // $data['master_supplier'] = $masterSupplier->paginate(10, 'master_supplier');
        // $data['pager'] = $masterSupplier->pager;
        return view('dashboard/master_data/master_supplier');
    }

    public function CariDataMasterSupplier(){
        $dataMasterSupplier = new MasterSupplierModel();
        $data = $dataMasterSupplier->findAll();
        echo json_encode(["data" => $data]);
    }


    // public function CariDataMasterSupplier()
    // {
    //     $pemasok = $this->request->getPost('pemasok');
    //     $nama_barang = $this->request->getPost('nama_barang');
    //     $dataMasterSupplier = new MasterSupplierModel();
    //     // Get the current page from the URL query string, default to 1
    //     $currentPage = $this->request->getVar('page') ? $this->request->getVar('page') : 1;
    
    //     // Set the number of records per page
    //     $perPage = 10;
    
    //     // Get your filtered data using your model method
    //     $masterSupplierQuery = $dataMasterSupplier->searchDataSupplier($pemasok, $nama_barang);
    
    //     // Debugging: Output generated SQL query
    //     echo $dataMasterSupplier->getLastQuery();
    
    //     // Paginate the result set
    //     $master_supplier = $masterSupplierQuery->paginate($perPage);
    
    //     // Check if the search result is empty
    //     if (empty($master_supplier)) {
    //         // Handle empty result
    //         echo "No results found.";
    //         // or return a view with a message indicating no results found
    //     } else {
    //         // Get the pager from the query result
    //         $pager = $dataMasterSupplier->pager;
    
    //         return view('dashboard/search_data/search_data_supplier', compact('master_supplier', 'pager'));
    //     }
    // }
    
    
    
}
