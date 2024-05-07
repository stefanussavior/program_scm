<?php

namespace App\Controllers\Incoming\Form;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Incoming\MasterData\MasterWarehouseModel;

class FormTambahWarehouseController extends BaseController
{

    public function ViewFormTambahDataWarehouse() {
        return view('dashboard/form/form_tambah_warehouse');
    }

    public function TambahDataWarehouse()
    {
        $dataWarehouse = new MasterWarehouseModel();

        $nama_kota = $this->request->getPost('nama_kota');
        $nama_jalan = $this->request->getPost('nama_jalan');
        $kode_resto_baru = $this->request->getPost('kode_resto_baru');
        $nama_gudang_baru = $this->request->getPost('nama_gudang_baru');

            $dataWarehouse->insert([
                'nama_kota' => $nama_kota,
                'nama_jalan' => $nama_jalan,
                'kode_resto_baru' => $kode_resto_baru,
                'nama_gudang_baru' => $nama_gudang_baru
            ]);

        return redirect()->to(base_url('master_warehouse'));
    }
}
