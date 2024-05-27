<?= $this->include('template/navigation_bar'); ?>

<title>Form Data BIN</title>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Form BIN</h1>
    </div>

    <?php if (session()->has('error')): ?>
        <div class="alert alert-danger" role="alert">
            <?= session('error') ?>
        </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-header">
            <b>Form BIN</b>
        </div>
        <div class="card-body">
            <form id="tambahFormAppend" method="post" action="<?= site_url('/submit_form_bin') ?>">
                <div>
                    <label>Nama Barang: </label>
                    <select name="nama_barang" id="nama_barang" class="form-control">
                        <option value="" selected disabled>--- CARI NAMA BARANG ---</option>
                        <?php foreach ($master_pallet as $pallet): ?>
                            <option value="<?= $pallet['nama_barang'] ?>"><?= $pallet['nama_barang'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div id="form_append_bin"></div>
                <div>
                    <label>Warehouse: </label>
                    <br>
                    <input type="text" name="warehouse" id="warehouse" class="form-control" value="WHCK2" readonly>
                </div>
                <div>
                    <input type="hidden" name="is_reserved" id="is_reserved" value="1">
                </div>
                <br>
                <button type="submit" id="submitForm" class="btn btn-primary">Submit</button>
                <button type="reset" class="btn btn-danger">Cancel</button>
                <br/>
            </form>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<?= $this->include('template/footer'); ?>

<script>
    $(document).ready(function() {
        $('#nama_barang').select2();
        
        $('#nama_barang').on('change', function() {
            var nama_barang = $(this).val();
            $.ajax({
                url: '<?= site_url('/ajax_get_nama_barang'); ?>',
                method: 'GET',
                data: { nama_barang: nama_barang },
                dataType: 'json',
                success: function(response) {
                    $('#form_append_bin').empty();
                    if (response) {
                        $.each(response, function(index, row) {
                            var fieldHtml = '<div class="row">';
                            var kodePallet = '<div class="col-sm-4 mb-4"><label>Kode Pallet ' + (index + 1) + ': </label><input type="text" name="kode_pallet[]" class="form-control" value="' + row.kode_pallet + '" readonly></div>';
                            fieldHtml += kodePallet;

                            var inputRack = '<div class="col-md-3"><label>Input Rack ' + (index + 1) + ': </label><select name="rack[]" class="form-control"><option value="" selected disabled>---Pilih Nomor Rack ----</option>';
                            for (var i = 1; i <= 13; i++) {
                                inputRack += '<option value="R' + i + '">R' + i + '</option>';
                            }
                            inputRack += '</select></div>';
                            fieldHtml += inputRack;

                            var nomorLetakRack = '<div class="col-md-3"><label>Input Nomor Letak Rack ' + (index + 1) + ':</label><select name="bin_location[]" class="form-control"><option value="" selected disabled>--- Pilih Nomor BIN ----</option>';
                            for (var i = 1; i <= 73; i++) {
                                nomorLetakRack += '<option value="' + i + '">' + i + '</option>';
                            }
                            nomorLetakRack += '</select></div>';
                            fieldHtml += nomorLetakRack;
                            
                            fieldHtml += "</div>";
                            $('#form_append_bin').append(fieldHtml);
                        });
                    }
                }
            });
        });
        $('#tambahFormAppend').on('submit', function(event) {
        event.preventDefault();

        var kodePallet = $('.kode-pallet').val();
        $.ajax({
            url: '<?= site_url('/check_kode_pallet_exists'); ?>',
            method: 'POST',
            data: { kode_pallet: kodePallet },
            dataType: 'json',
            success: function(response) {
                if (response.exists) {
                    alert('Maaf, kode pallet tersebut sudah ada di dalam database');
                } else {
                    $('#tambahFormAppend')[0].submit();
                }
            }
        });
    });
});
</script>
