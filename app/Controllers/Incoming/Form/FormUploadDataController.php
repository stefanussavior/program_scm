<?php

namespace App\Controllers\Incoming\Form;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Incoming\MasterData\MasterPOModel;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class FormUploadDataController extends BaseController
{

    public function FormUploadFileToExcel() {
        return view('dashboard/form/upload_data');
    }

    public function UploadDataExcelToDatabase() {
        set_time_limit(300);

         // Handle file upload
         $file = $this->request->getFile('excel_file');
    
         // Get the temporary file path
         $filePath = $file->getTempName();
         
         // Load Excel file
         $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
         $spreadsheet = $reader->load($filePath);
         $sheet = $spreadsheet->getActiveSheet();

         $dataPO = new MasterPOModel();
 
         // Get the highest row and column counts
         $highestRow = $sheet->getHighestRow();
         $highestColumn = $sheet->getHighestColumn();
 
         // Loop through each row of the worksheet
    for ($row = 2; $row <= $highestRow; $row++) {
            
            $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
            $supplier = $rowData[0][0];
            $nomor_po = $rowData[0][1];
            $tanggal_po = null;
            if ($rowData[0][2] !== null) {
                $tanggal_po = Date::excelToDateTimeObject($rowData[0][2])->format('Y-m-d');
            }
            $keterangan_po = $rowData[0][3];
            $tanggal_pengiriman = null;
            if ($rowData[0][4] !== null) {
            $tanggal_pengiriman = Date::excelToDateTimeObject($rowData[0][4])->format('Y-m-d');
            }
            $kode = $rowData[0][5];
            $nama_barang = $rowData[0][6];
            $catatan = $rowData[0][7];
            $satuan = $rowData[0][8];
            $qty_po = $rowData[0][9];
            $qty_terproses = $rowData[0][10];
            $qty_belum_terp = $rowData[0][11];

 
             // Insert data into database (replace 'your_table' with your actual table name)
             $data = [
                 'supplier' => $supplier,
                 'nomor_po' => $nomor_po,
                 'tanggal_po' => $tanggal_po,
                 'keterangan_po' => $keterangan_po,
                 'tanggal_pengiriman' => $tanggal_pengiriman,
                 'kode' => $kode,
                 'nama_barang' => $nama_barang,
                 'catatan' => $catatan,
                 'satuan' => $satuan,
                 'qty_po' => $qty_po,
                 'qty_terproses' => $qty_terproses,
                 'qty_belum_terp' => $qty_belum_terp
             ];
           $dataPO->insert($data);
         }
 
         // Redirect to a success page
         return redirect()->to(site_url('/master_upload_po'));
     }
}
