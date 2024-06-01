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
                <th>Nomor QC</th>
                <th>Product</th>
                <th>Qty PO</th>
                <th>Lots</th>
                <th>COO</th>
                <th>COA</th>
                <th>Qty Sampling</th>
                <th>Qty Reject</th>
                <th>Desc QC</th>
                <th>Sertifikat Halal</th>
                <th>Visual Organoleptik</th>
                <th>Status QC</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>


    <!-- Add a modal for editing -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit QC Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editForm">
                        <input type="hidden" id="editId">
                        <div class="form-group">
                            <label for="editProduct">Product</label>
                            <input type="text" class="form-control" id="editProduct" >
                        </div>
                        <div class="form-group">
                            <label for="editQtyPO">Qty PO</label>
                            <input type="text" class="form-control" id="editQtyPO" readonly>
                        </div>
                        <div class="form-group">
                            <label for="statusQC">Status QC</label>
                            <select name="status" id="editStatus" class="form-control">
                                <option value="" selected disabled>-- PILIH STATUS QC ---</option>
                                <option value="reject">Reject</option>
                                <option value="release">Release</option>
                            </select>
                        </div>
                        <!-- Add other form fields as needed -->
                        <button type="button" class="btn btn-primary" id="saveEdit">Save changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
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
            { "data": "nama_barang" },
            { "data" : "nomor_qc"},
            { "data": "qty_po" },
            { "data": "lots" },
            { "data": "coo"},
            { "data": "coa" },
            { "data" : "qty_sampling"},
            { "data": "qty_reject" },
            { "data" : "qc_desc"},
            { "data" : "sertifikat_halal"},
            { "data" : "visual_organoleptik"},
            {
                "data": "status"
            },
            {
                "data": null,
                "defaultContent": "<button class='btn btn-primary btn-edit'>Edit</button>"
            } 
        ]
    });

    $('#master-data tbody').on('click', 'button.btn-edit', function () {
        var data = table.row($(this).parents('tr')).data();
        $('#editId').val(data.id);
        $('#editProduct').val(data.nama_barang);
        $('#editQtyPO').val(data.qty_po);
        $('#editStatus').val(data.status);
        // Populate other form fields as needed
        editModal.modal('show');
    });

    $('#saveEdit').on('click', function() {
        var formData = {
            id: $('#editId').val(),
            product: $('#editProduct').val(),
            qty_po: $('#editQtyPO').val(),
            status: $('#editStatus').val()
            // Add other form fields as needed
        };

        $.ajax({
            url: '<?= site_url('/edit_qc_data'); ?>',
            type: 'POST',
            data: formData,
            success: function(response) {
                table.ajax.reload();
                editModal.modal('hide');
            }
        });
    });
    
});

</script>

<?= $this->include('template/footer'); ?>
