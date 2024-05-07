<?= $this->include('template/navigation_bar'); ?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
	<script src="https://code.jquery.com/jquery-3.4.1.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<title>Form Status Insepski</title>

<div class="container-fluid">

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Form Status Inspeksi</h1>
    <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
            class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
</div>

<!-- Content Row -->
<div>
    <div class="card">
        <div class="card-header">
        <b>Form Status Inspeksi</b>
    </div>
    <div class="card-body">
    <form method="POST" action="/submit_form_status_inspeksi" enctype="multipart/form-data">
    <div>
        <label>Nama Produk : </label>
        <!-- <input type="text" name="nama_produk" class="form-control" placeholder="Masukkan Nama Produk"> -->
        <select id="dropdown" name="nama_produk" class="form-control">
            <option value="">Select an Item</option>
        </select>
    </div>
    <!-- <div>
        <label>Supplier : </label>
        <input type="text" name="supplier" id="supplier" class="form-control" placeholder="Masukkan Supplier">
    </div> -->
    <div>
        <label>Receive Date : </label>
        <input type="date" name="receive_date" class="form-control">
    </div>
    <div>
        <label>Expired Date : </label>
        <input type="date" name="expired_date" class="form-control">
    </div>
    <div>
        <label>Jumlah : </label>
        <input type="text" name="jumlah" class="form-control" placeholder="Masukkan Jumlah">
    </div>
    <div>
        <label>Tanggal Inspeksi : </label>
        <input type="date" name="tanggal_inspeksi" class="form-control" placeholder="Masukkan Jam">
    </div>
    <div>
        <label>Upload Foto Status Inspeksi : </label>
        <input type="file" name="upload_foto_status_inspeksi" class="form-control">
    </div>
    <div>
    <label>Status : </label>
        <select name="status" class="form-control" aria-label="Default select example">
        <option value="release">Release</option>
        <option value="hold">Hold</option>
        <option value="reject">Reject</option>
    </select>
<br/>
    <button class="btn btn-primary" type="submit">Submit</button>
    <button class="btn btn-danger" type="reset">Cancel</button>
</form>
</div>
</div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


<script type="text/javascript">
       $(document).ready(function() {
            $.ajax({
            url: "<?php echo base_url('/get_data_supplier'); ?>",
            type: "GET",
            dataType: "json",
            success: function(data) {
                $.each(data, function(key, value) {
                    $('#dropdown').append('<option value="' + value.nama_barang + '-' + value.pemasok +'">' + value.kode + '-' + value.nama_barang + '-' + value.pemasok + '</option>');
                    // $('#supplier').append(''+value.nama_pemasok);
                });
            }
    });
    $('#dropdown').select2(); 
        });
</script>

<?= $this->include('template/footer'); ?>