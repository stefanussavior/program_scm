<?= $this->include('template/navigation_bar'); ?>

<title>Master Data QC</title>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">

<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><b>Master Data Quality Control</b></h1>
    </div>

    <table class="display" id="master-data" style="width:100%;">
        <thead class="thead-dark">
            <tr>
                <th>No</th>
                <th>Product</th>
                <th>Lots</th>
                <th>COO</th>
                <th>COA</th>
                <th>Qty Sampling</th>
                <th>Qty Reject</th>
                <th>Qty GR</th>
                <th>Status QC</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>


    <!-- Add a modal for editing -->
<!-- <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit PO Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            </div>
        </div>
    </div>
</div> -->

</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
<script>
  $(document).ready(function(){
    var editModal = $('#editModal');
    var editForm = $('#editForm');

    var table = $('#master-data').DataTable({
        "ajax": "<?= site_url('/ajax_get_data_qc'); ?>",
        "columns": [
            { "data": "id" },
            { "data": "product" },
            { "data": "lots" },
            { "data": "coo"},
            { "data": "coa" },
            {"data" : "qty_sampling"},
            { "data": "qty_reject" },
            { "data": "qty_gr" },
            {
                "data": "status"
            }, 
        ]
    });

    // Handle edit button click
    $('#master-data tbody').on('click', '.btn-edit', function() {
        var data = table.row($(this).closest('tr')).data();
        $('#editId').val(data.id);
        $('#editNomorPO').val(data.nomor_po);
        $('#editQtyPO').val(data.qty_po);
        editModal.modal('show');
    });

    editForm.submit(function(e) {
        e.preventDefault();
        var qty_po = parseInt($('#editQtyPO').val());
        var qty_dtg = parseInt($('#editQtyPO').val());
        
        if (qty_dtg > qty_po) {
            alert('Qty Terproses cannot be greater than Qty PO');
            return; // Prevent form submission
        }
        
        var formData = $(this).serialize();
        $.ajax({
            type: "POST",
            url: "<?= site_url('/update_qty_po'); ?>", // Change the URL to your controller method
            data: formData,
            success: function(response) {
                // Reload DataTable after successful update
                table.ajax.reload();
                editModal.modal('hide');
            }
        });
    });
});

</script>

<?= $this->include('template/footer'); ?>
