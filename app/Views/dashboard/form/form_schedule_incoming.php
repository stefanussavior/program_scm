<?= $this->include('template/navigation_bar'); ?>

    <title>Form Schedule Incoming</title>

<div class="container-fluid">

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Form Schedule Incoming</h1>
    <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
            class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
</div>

<!-- Content Row -->
<div>
        <!-- CONTAINER -->
<div class="card">
<div class="card-header">
<b>Form Schedule Incoming</b>    
</div>

<div class="card-body">
<form method="post" action="/submit_form_schedule_incoming">
    <div>
        <label>Nomor PO : </label>
        <select id="nomor_po" class="form-control" placeholder="Cari Nomor PO">
            <option value="">Cari Nomor PO</option>
        </select>
    </div>
<div>
    <label>Nama Barang : </label>
        <input type="text" id="nama_barang" name="nama_barang" class="form-control" readonly>
</div>
<div>
    <label>Form Item : </label>
    <input type="text" name="form_item" class="form-control" placeholder="Masukkan Nama Item">
</div>
<div>
    <label>Form Qty : </label>
    <input type="text" name="form_qty" class="form-control" placeholder="Masukkan Qty barang">
</div>
<div>
    <label>Form Satuan Barang : </label>
    <input type="text" name="form_satuan_barang" class="form-control" placeholder="Masukkan Satuan barang">
</div>
<div>
    <label>Form Gudang Pengirim : </label>
    <input type="text" name="form_gudang_pengirim" class="form-control" placeholder="Masukkan Satuan barang">
</div>
<div>
    <label>Form ETA : </label>
    <input type="date" name="form_eta" class="form-control">
</div>
</br>
<button type="submit" class="btn btn-primary">Submit</button>
<button type="reset" class="btn btn-danger">Cancel</button>
</form>
</div>
</div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script type="text/javascript">
       $(document).ready(function() {
            $.ajax({
            url: "<?php echo base_url('/get_data_po'); ?>",
            type: "GET",
            dataType: "json",
            success: function(data) {
                $.each(data, function(key, value) {
                    $('#nomor_po').append('<option value="' + value.id  +'">' + value.nomor_po + '</option>');
                    // $('#supplier').append(''+value.nama_pemasok);
                });
            }
    });
    $('#nomor_po').select2(); 
        });
</script>


<?= $this->include('template/footer'); ?>