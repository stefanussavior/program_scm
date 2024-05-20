<?= $this->include('template/navigation_bar'); ?>

<title>Form Data BIN</title>

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

<style>

</style>


<div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Form BIN</h1>
        </div>

        <?php if(session()->has('error')): ?>
    <div class="alert alert-danger" role="alert">
        <?= session('error') ?>
    </div>
<?php endif; ?>


    <div class="card">
        <div class="card-header">
            <b>Form BIN</b>
        </div>
        <div class="card-body">
            <form action="/submit_form_bin" method="post">
                <div>
                    <label>Nama Barang : </label>
                    <select name="nama_barang" id="nama_barang" class="form-control">
                        <option value="" selected disabled>--- CARI NAMA BARANG ---</option>
                            <?php foreach ($master_pallet as $pallet) : ?>
                                <option value="<?php echo $pallet['nama_barang'] ?>"><?php echo $pallet['nama_barang']; ?></option>
                            <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label>Kode Pallet : </label>
                    <br>
                    <input type="text" name="kode_pallet" id="kode_pallet" class="form-control" >
                </div>
                <div>
                    <label>Warehouse : </label>
                    <br>
                        <input type="text" name="warehouse" id="warehouse" class="form-control" value="WHCK2" readonly>
                </div>
                <div>
                    <label>Input Rak : </label>
                    <select name="rack" id="rack" class="form-control">
                        <option value="" selected disable>-- PILIH NOMOR RAK ---</option>
                        <?php foreach ($master_bin_location as $bin) : ?>
                            <option value="<?php echo $bin['bin_location'] ?>"><?php echo $bin['bin_location'] ?></option>
                        <?php endforeach ?>
                </div>
                </div>
            </select>
            <div>
                <label>Input Nomor Letak Rak</label>
                <br>
                <select name="bin_location" id="bin_location" class="form-control">
                    <option value="" selected disable>-- PILIH NOMOR LETAK RAK ---</option>
                    <?php for ($i = 1; $i <= 72; $i++) : ?>
                        <option value="<?php echo $i; ?>" class="form-control"><?php echo $i; ?></option>
                    <?php endfor; ?>
                </select>
            </div>
            <div>
                <input type="hidden" name="is_reserved" id="is_reserved" value="1">
            </div>
                </div>
                <br/>
                <button type="submit" class="btn btn-primary">Submit</button>
                <button type="reset" class="btn btn-danger">Cancel</button>
            </form>
            </div>
            </div>
        </div>
</div>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<?= $this->include('template/footer'); ?>

<script>
    $(document).ready(function() {
        $('#nama_barang').select2();
        $('#po_id').select2();
        $('#no_pallet').select2();
        $('#seat_number').select2();



        $('#nama_barang').on('change', function() {
            var nama_barang = $(this).val();
            $.ajax({
                url: '<?= site_url('/ajax_get_nama_barang'); ?>',
                method: 'GET',
                data: {
                    nama_barang: nama_barang
                },
                dataType: 'json',
                success: function(response) {
                    if (response && response.kode_pallet) {
                        $('#kode_pallet').val(response.kode_pallet);
                    } else {
                        $('#kode_pallet').val('');
                    }
                },
                error: function() {
                    $('#kode_pallet').val('');
                }
            });
        });


        $('#nomor_gr').on('change',function(){
            var nomor_gr = $(this).val();
            $.ajax({
                url: '<?= site_url('/ajax_get_gr_id') ?>',
                method: 'GET',
                async: true,
                data: {
                    nomor_gr: nomor_gr
                },
                dataType: 'JSON',
                success: function(response) {
    if (response.length > 0) {
        $('#tanggal_gr').val(response[0].tanggal_gr);
        $('#supplier').val(response[0].supplier);
        $('#desc_gr').val(response[0].desc_gr);
        $('#nomor_po').val(response[0].nomor_po);
        $('#tanggal_po').val(response[0].tanggal_po);
        $('#warehouse').val(response[0].warehouse);
    } else {
        $('#tanggal_gr').val('');
        }
    },
        })

        $('#nomor_po').on('change', function() {
                var nomor_po = $(this).val();
                $.ajax({
                    url: '<?= site_url('/ajax_get_nomor_po_bin') ?>',
                    method: 'GET',
                    data: {
                        nomor_po: nomor_po
                    },
                    dataType: 'JSON',
                    success: function(response) {
                        ('#tanggal_po').val(response.tanggal_po);
                    }
                });
        })
    }) 
})
</script>