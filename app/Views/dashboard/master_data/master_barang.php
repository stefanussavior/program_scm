<?= $this->include('template/navigation_bar'); ?>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">


<title>Master Barang</title>


<div class="container-fluid">
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Master Data Barang</h1>
    <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#exampleModal"><i
    class="fas fa-search fa-sm text-white-50"></i> Cari Data Barang</a> -->
  </div>
  
  <!-- modal
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Cari Data Master Barang</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="/cari_data_master_gr" method="post">
            <div>
              <label>Nama Barang : </label>
              <input type="text" name="prod_name" id="prod_name" class="form-control">
            </div>
          </div>
          <div class="modal-footer">
            <button type="reset" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
        </form>
      </div>
    </div>
  </div> -->

  <div class="container-fluid">

 
  
  
  <table class="display" id="master-data" style="width:100%;">
    <thead>
      <tr>
        <th>No</th>
        <th>Produk ID</th>
        <th>Kode Produk</th>
        <th>Nama Produk</th>
        <th>Produk UOM 1</th>
        <th>Produk UOM 2</th>
        </tr>
    </thead>

    <tbody></tbody>

    </div>
    </dv>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
<script>
  $(document).ready(function() {
    $('#master-data').DataTable({
      "ajax": "<?= site_url('/ajax_get_master_barang'); ?>",
      "columns" : [
        {"data" : "id"},
        {"data": "prod_id"},
        {"data": "prod_code"},
        {"data": "prod_name"},
        {"data": "prod_uom1"},
        {"data": "prod_uom2"},
      ]
    });
  });
</script>

<?= $this->include('template/footer') ?>