<?= $this->include('template/navigation_bar'); ?>

<div class="container-fluid">

<title>Master Data Warehouse</title>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">

<!-- Page Heading -->
<div class="container-fluid">
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Master Data Warehouse</h1>
  </div>


    <div>
    <table class="display" id="master-data" style="width:100%;">
        <thead class="thead-dark">
            <tr>
                <th>No</th>
                <th>Nama Kota</th>
                <th>Nama Jalan</th>
                <th>Kode Resto Baru</th>
                <th>Nama Gudang Baru</th>
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
      "ajax": "<?= site_url('/ajax_get_master_warehouse'); ?>",
      "columns" : [
        {"data" : "id"},
        {"data": "nama_kota"},
        {"data": "nama_jalan"},
        {"data": "kode_resto_baru"},
        {"data": "nama_gudang_baru"},
      ]
    });
  });
</script>

<?= $this->include('template/footer'); ?>