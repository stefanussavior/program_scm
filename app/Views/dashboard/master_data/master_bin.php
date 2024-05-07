<?= $this->include('template/navigation_bar'); ?>


<title>Master BIN</title>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">

<div class="container-fluid">

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><b>Master Bin</b></h1>
    <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
            class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
</div>
    


<table class="display" id="master-data" style="width:100%;">
    <thead>
        <tr>
            <b>
                <th scope="col">No</th>
                <th scope="col">Lokasi</th>
                <th scope="col">Nomor Rak</th>
                <th scope="col">Nomor Pallet</th>
            </b>
        </tr>
    </thead>
    <tbody></tbody>
</table>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>

<script>
   $(document).ready(function() {
    $('#master-data').DataTable({
      "ajax": "<?= site_url('/ajax_get_master_bin'); ?>",
      "columns" : [
        {"data" : "id"},
        {"data": "kode_pallet"},
        {"data": "rack"},
        {"data": "bin_location"},
      ]
    });
  });
</script>
    

<?= $this->include('template/footer'); ?>