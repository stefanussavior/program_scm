<?= $this->include('template/navigation_bar'); ?>

<title>Master Count Total PO</title>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">

<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><b>Master Count Total PO</h1>
    </div>

    <table class="display" id="master-data" style="width:100%;">
        <thead class="thead-dark">
            <tr>
                <th>Nomor PO</th>
                <th>Kode</th>
                <th>Nama Barang</th>
                <th>Total Data PO</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Data PO</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editForm">
                <div class="modal-body">
                    <input type="hidden" name="id" id="editId">
                    <div class="form-group">
                        <label for="qty_terproses">Qty Terproses:</label>
                        <input type="text" class="form-control" id="qty_dtg" name="qty_dtg">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
<script>
$(document).ready(function() {
    var nomor = 0;
    var table = $('#master-data').DataTable({
        "ajax": "<?= site_url('/ajax_master_detail_count_po'); ?>",
        "columns": [
            { "data": "nomor_po" },
            {"data" : "kode"},
            {"data" : "nama_barang"},
            { "data" : "kuantitas_count"},
        ]
    });

    // Rest of your code remains unchanged
});

</script>

<?= $this->include('template/footer'); ?>
