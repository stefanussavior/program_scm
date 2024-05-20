<?= $this->include('template/navigation_bar'); ?>

<title>Master Data PO</title>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">

<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><b>Master Data PO Sesudah GR</b></h1>
    </div>

    <table class="display" id="master-data" style="width:100%;">
        <thead class="thead-dark">
            <tr>
                <th>No</th>
                <th>Nomor PO</th>
                <th>Tanggal PO</th>
                <th>Nama Supplier</th>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Qty PO Barang</th>
                <th>Qty Terproses</th>
                <th>Satuan</th>
                <th>Qty Belum Terproses</th>
                <th>Status PO</th>
                <!-- <th>Action</th> -->
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
                <h5 class="modal-title" id="editModalLabel">Edit PO Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Form for editing PO details -->
                <!-- You can customize this form based on your requirements -->
                <form id="editForm">
                    <input type="hidden" id="editId" name="id">
                    <div class="form-group">
                        <label for="editNomorPO">Nomor PO : </label>
                        <input type="text" class="form-control" id="editNomorPO" name="nomor_po" readonly>
                        <label for="editQtyPO">Edit Qty PO : </label>
                        <input type="number" class="form-control" name="qty_po" id="editQtyPO">
                    </div>
                    <!-- Add other fields here -->
                    <button type="submit" class="btn btn-primary">Save changes</button>
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
        "ajax": "<?= site_url('/ajax_get_master_po'); ?>",
        "columns": [
            { "data": "id" },
            { "data": "nomor_po" },
            { "data": "tanggal_po" },
            { "data": "supplier"},
            { "data": "kode" },
            {"data" : "nama_barang"},
            { "data": "qty_po" },
            { "data": "qty_dtg" },
            {"data" : "satuan"},
            {
                "data": null,
                "render": function(data, type, row) {
                    var qtyBelumTerproses = row.qty_po - row.qty_dtg;
                    if (qtyBelumTerproses === 0) {
                        row.status_gr = 'fulfilled';
                    } else if (row.qty_po > row.qty_dtg) {
                        row.status_gr = 'outstanding';
                    } else {
                        row.status_gr = 'reject';
                    }
                    return qtyBelumTerproses;
                }
            },
            {
                "data": "status_gr"
            },
            // {
            //     "data": null,
            //     "render": function(data, type, row) {
            //         if (row.status_gr !== 'fulfilled') {
            //             return '<button class="btn btn-primary btn-edit" data-id="' + row.id + '">Edit</button>';
            //         } else {
            //             return '';
            //         }
            //     }
            // }
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
