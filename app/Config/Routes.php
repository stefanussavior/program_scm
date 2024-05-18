<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\Incoming\AuthorizationController;
use App\Controllers\Home;
use App\Controllers\Incoming\MasterData\MasterBinController;
use App\Controllers\Incoming\MasterData\MasterSupplierController;
use App\Controllers\Incoming\MasterData\MasterGRController;
use App\Controllers\Incoming\MasterData\MasterPOController;
use App\Controllers\Incoming\MasterData\MasterWarehouseController;
use App\Controllers\Incoming\MasterData\MasterBarangController;
use App\Controllers\Incoming\MasterData\MasterPalletizationController;


use App\Controllers\Incoming\Form\FormUploadDataController;
use App\Controllers\Incoming\Form\FormGRController;
use App\Controllers\Incoming\Form\FormIdentitasPalletController;
use App\Controllers\Incoming\Form\FormBINController;
use App\Controllers\Incoming\Form\FormTambahWarehouseController;
use App\Controllers\Incoming\Form\FormPaletizationController;


/**
 * @var RouteCollection $routes
 */

//routes login and logout
$routes->get('/', [Home::class,'index']);
$routes->post('/submit_login', [AuthorizationController::class,'Login']);
$routes->get('/logout', [AuthorizationController::class,'Logout']);

//dashboard
$routes->get('/dashboard', [AuthorizationController::class,'dashboard'], ['filter'=>'auth']);

//master data
$routes->get('/master_bin', [MasterBinController::class,'MasterBin']);
$routes->get('/master_supplier', [MasterSupplierController::class, 'MasterDataSupplier']);
$routes->get('/master_data_po', [MasterPOController::class, 'MasterDataPO']);
$routes->get('/master_gr',[MasterGRController::class, 'MasterGR']);
$routes->get('/master_warehouse', [MasterWarehouseController::class,'ListDataWarehouse']);
$routes->get('/master_barang', [MasterBarangController::class,'MasterBarangView']);
$routes->get('/master_palletization', [MasterPalletizationController::class,'MasterPalletView']);
$routes->get('/master_upload_po',[MasterPOController::class,'MasterUploadDataPO']);

$routes->get('/master_detail_count_po', [MasterPOController::class,'MasterPOCountDetail']);



//form get routes
$routes->get('/form_schedule_incoming',[ScmController::class,'FormScheduleIncoming']);
$routes->get('/form_good_receive',[FormGRController::class,'FormGoodReceive']);
$routes->get('/form_identitas_pallet',[FormIdentitasPalletController::class,'FormIdentitasPallet']);
$routes->get('/form_status_inspeksi',[ScmController::class,'FormStatusInspeksi']);
$routes->get('/form_upload_data',[FormUploadDataController::class,'FormUploadFileToExcel']);
$routes->get('/form_bin', [FormBINController::class,'FormBIN']);
$routes->get('/form_qc', [ScmController::class,'FormQC']);
$routes->get('/form_input_location_bin', [ScmController::class,'FormLocationBIN']);
$routes->get('/form_tambah_data_warehouse', [FormTambahWarehouseController::class, 'ViewFormTambahDataWarehouse']);
$routes->get('/display_data_bin_view', [FormBINController::class,'DisplayBINStatus']);



//submit form routes
$routes->POST('/upload_data_excel_to_database', [FormUploadDataController::class,'UploadDataExcelToDatabase']);
$routes->POST('/submit_form_schedule_incoming', [ScmController::class, 'InputDataScheduleIncoming']);
$routes->POST('/submit_form_good_receive', [FormGRController::class, 'InputDataGoodReceive']);
$routes->POST('/submit_form_identitas_pallet', [FormIdentitasPalletController::class, 'InputIdentitasPallet']);
$routes->POST('/submit_form_status_inspeksi', [ScmController::class, 'InputStatusInspeksi']);
$routes->POST('/submit_form_qc', [ScmController::class,'InsertDataQC']);
$routes->POST('/submit_form_bin', [FormBINController::class, 'InsertDataBIN']);
$routes->POST('/submit_form_location_bin', [ScmController::class,'reverseSeat']);
$routes->POST('/submit_form_tambah_data_warehouse', [FormTambahWarehouseController::class,'TambahDataWarehouse']);



//kumpulan data AJAX
$routes->get('/ajax_get_po_id', [FormGRController::class,'AjaxDataPOByID']);
$routes->get('/ajax_get_gr_id', [FormBINController::class,'AjaxDataGRByID']);
$routes->get('/ajax_get_data_supplier',[FormGRController::class,'GetDataSupplierAjax']);
$routes->get('/ajax_get_nomor_gr', [FormIdentitasPalletController::class,'AjaxGetNomorGR']);
$routes->post('/group_bin_data', [FormBINController::class,'GroupBySeatGroup']);
$routes->GET('/ajax_get_seat_data', [FormBINController::class,'GetSeatData']);
$routes->get('/ajax_get_nomor_po_bin', [FormBINController::class,'AjaxDataPOByIDBIN']);
$routes->get('/ajax_get_upload_data_po',[MasterPOController::class, 'GetAllDataUploadPO']);
$routes->get('/ajax_get_upload_data_po_no_gr', [MasterPOController::class, 'GetAllDataUploadPONoGR']);

$routes->post('/ajax_update_data_master_po', [MasterPOController::class,'UpdateDataMasterPO']);

//Ajax get master data
$routes->get('/ajax_get_master_barang', [MasterBarangController::class , 'ListDataBarang']);
$routes->get('/ajax_get_master_bin', [MasterBinController::class,'ListDataBIN']);
$routes->get('/ajax_get_master_gr',[MasterGRController::class,'CariDataMasterGR']);
$routes->get('/ajax_get_master_po', [MasterPOController::class,'ListDataPO']);
$routes->get('/ajax_get_master_supplier', [MasterSupplierController::class,'CariDataMasterSupplier']);
$routes->get('/ajax_get_master_warehouse', [MasterWarehouseController::class, 'CariDataMasterWarehouse']);
$routes->get('/ajax_get_data_pallet',[MasterPalletizationController::class,'ListDataPallet']);


$routes->get('/ajax_master_detail_count_po', [MasterPOController::class,'tablePODetails']);

$routes->post('/fetch_kode_barang', [FormGRController::class,'fetchKodeBarang']);
$routes->post('/fetch_barang_details', [FormGRController::class, 'fetchBarangDetail']);

$routes->post('/fetch_qty_dtg', [FormGRController::class,'fetchQtyDtg']);


//kode otomatis
$routes->get('/ambil_kode_gr', [FormGRController::class,'BuatKodeGR']);
$routes->get('/ambil_kode_batch', [FormGRController::class,'BuatKodeBatch']);
$routes->get('/ambil_kode_prd', [FormGRController::class,'BuatKodePRD']);
$routes->get('/ambil_kode_pallet',[FormIdentitasPalletController::class,'BuatKodePallet']);



//check bin 
$routes->post('/check_bin_availability', [FormBINController::class,'CheckBin']);

//check PO are fullfilled
$routes->post('/check_po_fullfiled', [FormGRController::class,'checkPOFulfilled']);

//update data PO status
$routes->get('/ajax_get_po_details', [MasterPOController::class,'getPODetails']);
$routes->post('/ajax_edit_po', [MasterPOController::class,'editPO']);


//update status GR on status PO
$routes->post('/update_status_gr', [MasterPOController::class,'updateStatusGR']);

$routes->post('/update_qty_po', [MasterPOController::class,'UpdateQuantity']);

$routes->get('/check_kode_pallet_empty', [MasterPalletizationController::class,'checkKodePalletEmpty']);
