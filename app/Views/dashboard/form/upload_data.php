<?= $this->include('template/navigation_bar'); ?>

<title>Upload Data Excel To Database</title>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

<div class="container-fluid">

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Form Upload Data PO</h1>
    <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
            class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
</div>

<!-- Content Row -->
<div>

<!-- Form Upload Data -->
    <div class="card">
        <!-- <div class="card-header">
            <b>Form Upload Data PO</b>
        </div> -->
        <div class="card-body">
        <div class="container mt-3">
		<?php if (session()->getFlashdata('error')): ?>
<div class="alert alert-warning">
    <?= session()->getFlashdata('error') ?>
</div>
<?php endif; ?>
        <form id="uploadForm" action="<?= site_url('/upload_data_excel_to_database') ?>" method="post" enctype="multipart/form-data">
            <input type="file" name="excel_file" class="form-control">
            <br/>
            <button type="button" id="uploadButton" class="btn btn-primary">Import</button>
            <button type="reset" class="btn btn-danger">Cancel</button>
        </form>
        </div> 
    </div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
$(document).ready(function(){
    $('#uploadButton').click(function(){
        if(confirm("Apakah yakin untuk upload file excel? jika ada nomor po yang kososng maka sistem akan menolak secara langsung")) {
            $('#uploadForm').submit();
        }
    });
});
</script>

<?= $this->include('template/footer'); ?>
