<?= $this->include('template/navigation_bar'); ?>

<div class="container-fluid">
  <title>Master Data Warehouse</title>

  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">

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

  <!-- Bootstrap 4 modal markup -->
  <div class="modal fade" id="duplicateAlertModal" tabindex="-1" role="dialog" aria-labelledby="duplicateAlertModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="duplicateAlertModalLabel">Duplicate Kode Resto Baru Found</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p id="duplicateAlertMessage"></p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>

  <script>
    function checkDuplicateKodeResto() {
      var table = $('#master-data').DataTable();
      var rows = table.rows().data();
      var kodeRestoValues = {};

      rows.each(function(index, row) {
        var kodeResto = row.kode_resto_baru;

        if (kodeRestoValues.hasOwnProperty(kodeResto)) {
          var existingIndex = kodeRestoValues[kodeResto];

          // Show Bootstrap modal with duplicate alert message
          $('#duplicateAlertMessage').text(`Duplicate value '${row}' found in row ${existingIndex + 1} and row ${index + 1}.`);
          $('#duplicateAlertModal').modal('show');
          return false; // Exit the loop after finding the first duplicate
        } else {
          kodeRestoValues[kodeResto] = index;
        }
      });
    }

    $(document).ready(function() {
      $('#master-data').DataTable({
        "ajax": "<?= site_url('/ajax_get_master_warehouse'); ?>",
        "columns": [
          { "data": "id" },
          { "data": "nama_kota" },
          { "data": "nama_jalan" },
          { "data": "kode_resto_baru" },
          { "data": "nama_gudang_baru" },
        ],
        "initComplete": function(settings, json) {
          checkDuplicateKodeResto();
        }
      });
    });
  </script>

  <?= $this->include('template/footer'); ?>
