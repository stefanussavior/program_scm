<?= $this->include('template/navigation_bar'); ?>


<title>Master Supplier</title>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">

<div class="container-fluid">

<!-- Page Heading -->
<div class="container-fluid">
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Master Data Supplier</h1>
    <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#exampleModal"><i
    class="fas fa-search fa-sm text-white-50"></i> Cari Data Supplier</a> -->
  </div>
    
    <div>
    <table class="display" id="master-data" style="width:100%;">
        <thead class="thead-dark">
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Pemasok</th>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
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
      "ajax": "<?= site_url('/ajax_get_master_supplier'); ?>",
      "columns" : [
        {"data" : "id"},
        {"data": "kode_pemasok"},
        {"data": "pemasok"},
        {"data": "kode_barang"},
        {"data": "nama_barang"},
      ]
    });
  });
</script>
    


<?= $this->include('template/footer'); ?>