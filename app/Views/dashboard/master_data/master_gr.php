<?= $this->include('template/navigation_bar'); ?>

<title>Master Data GR</title>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">

<div class="container-fluid">
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Master Data Good Receive</h1>
  </div>
  

  <table class="display" id="master-data" style="width:100%;">
    <thead class="thead-dark">
      <tr>
        <th>No</th>
        <th>Nomor PO</th>
        <th>Tanggal PO</th>
        <th>Nomor GR</th>
        <th>Kode Barang</th>
        <th>Nama Supplier</th>
        <th>Nama Barang</th>
        <th>Tanggal GR</th>
        <th>Estimasi Kirim</th>
        <th>Qty PO</th>
        <th>Qty Datang</th>
        <th>Qty Belum Terproses</th>
        <th>Satuan Berat</th>
        <th>Kode Batch</th>
        <th>Kode PRD </th>
        <th>Expired Date</th>
        <th>Status GR</th>
        </tr>
    </thead>
    <tbody></tbody>
</table>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>

<script>
  $(document).ready(function() {
    $('#master-data').DataTable({
      "ajax": "<?= site_url('/ajax_get_master_gr'); ?>",
      "columns" : [
        {"data" : "id"},
        {"data" : "nomor_po"},
        {"data" : "tanggal_po"},
        {"data": "nomor_gr"},
        {"data" : "kode"},
        {"data" : "supplier"},
        {"data": "nama_barang"},
        {"data": "tanggal_gr"},
        {"data": "est_kirim"},
        {"data": "qty_po"},
        {"data": "qty_dtg"},
        {"data" :  "qty_gr_outstd"},
        {"data": "satuan"},
        {"data": "kode_batch"},
        {"data": "kode_prd"},
        {"data": "exp_date"},
        {"data": "status_gr"}
      ]
    });
  });
</script>

<?= $this->include('template/footer'); ?>