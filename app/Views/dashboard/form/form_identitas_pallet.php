<?= $this->include('template/navigation_bar'); ?>

<title>Form Paletization</title>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

<style>
</style>

<div class="container-fluid">


<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Form Paletization</h1>
    <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
            class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
</div>

<!-- Content Row -->
<div>
    <div class="card">
        <div class="card-header">
        <b>Form Paletization</b>
    </div>
    <div class="card-body">
        <form action="/submit_form_identitas_pallet" method="post">
                    <div>
                        <label>kode Palletization : </label>
                        <input type="text" name="kode_pallet" id="kode_pallet" class="form-control" readonly>
                    </div>
                    <div>
                        <label>Nomor GR : </label>
                        <select name="nomor_gr" id="nomor_gr" class="form-control">
                            <option value="" selected disable>--- Cek Nomor GR ----</option>
                            <?php foreach($master_gr as $gr) : ?>
                                <option value="<?php echo $gr['nomor_gr'] ?>"><?php echo $gr['nomor_gr']; ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                        <div id="barang_container">

                        </div>
                        
                        <div id="additional_forms_container">

</div>
                        <div>
                            <label>Total Qty Datang : </label>
                            <input type="text" name="total_qty" id="total_qty" class="form-control" readonly>
                        </div>
                        <div>
                            <label>Input Maximum Isi Pallet : </label>
                            <input type="text" name="max_qty" id="max_qty" class="form-control">
                        </div>
                        <div>
                            <label>Hitung Jumlah Pallet : </label>
                            <input type="text" name="num_paletization" id="num_paletization" class="form-control" readonly>
                        </div>
                       

                    <!-- <label>Input Nomor Ruang : </label>
                    <select name="seat_group" id="seat_group" class="form-control">
                        <option value="" selected disable>-- PILIH NOMOR RAK ---</option>
                        <option value="group-a" class="btn-ruangan">R-01</button>
                        <option value="group-b" class="btn-ruangan">R-02</button>
                        <option value="group-c" class="btn-ruangan">R-03</button>
                        <option value="group-d" class="btn-ruangan">R-04</button>
                        <option value="group-e" class="btn-ruangan">R-05</button>
                        <option value="group-f" class="btn-ruangan">R-06</button>
                        <option value="group-g" class="btn-ruangan">R-07</button>
                        <option value="group-h" class="btn-ruangan">R-08</button>
                        <option value="group-i" class="btn-ruangan">R-09</button>
                        <option value="group-j" class="btn-ruangan">R-10</button>
                        <option value="group-k" class="btn-ruangan">R-11</button>
                        <option value="group-l" class="btn-ruangan">R-12</button>
                        <option value="group-m" class="btn-ruangan">R-13</button>
                    </div>
                </div>
            </select>
            <div>
                <label>Input Nomor Letak Rak</label>
                <select name="seat_number" id="seat_number" class="form-control">
                    <option value="" selected disable>-- PILIH NOMOR LETAK RAK ---</option>
                    <option value="01" class="form-control">1</option>
                        <option value="2" class="form-control">2</option>
                        <option value="3" class="form-control">3</option>
                        <option value="4" class="form-control">4</option>
                        <option value="5" class="form-control">5</option>
                        <option value="6" class="form-control">6</option>
                        <option value="7" class="form-control">7</option>
                        <option value="8" class="form-control">8</option>
                        <option value="9" class="form-control">9</option>
                        <option value="10" class="form-control">10</option>
                        <option value="11" class="form-control">1</option>
                        <option value="12" class="form-control">12</option>
                        <option value="13" class="form-control">13</option>
                </select>
            </div>
            <div>
                <input type="hidden" name="is_reserved" id="is_reserved" value="1">
            </div> -->
                    </br>
                <button class="btn btn-primary" type="submit">Submit</button>
                <button class="btn btn-danger" type="reset">Cancel</button>
            </div>
        </form>
    </div>
</div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script>
    var ajaxKodePallets = []; 
    $(document).ready(function() {

        
    $('#supplier').select2();
    $('#nomor_gr').select2();

    $('#nomor_gr').on('change', function() {
        var nomor_gr = $(this).val();
        $.ajax({
            url: '<?= site_url('/ajax_get_nomor_gr')?>',
            method: 'GET',
            data: {
                nomor_gr: nomor_gr,
            },
            dataType: 'JSON',
            success: function(response) {
                $('#barang_container').empty();
                var totalQty = 0;

                $.each(response.data, function(index, row) {
                    var namaBarangField = '<div><label>Nama Barang ' + (index + 1) + ' : </label><input name="nama_barang[]" class="form-control" value="' + row.nama_barang + '" readonly></div>';
                    var qtyDatang  = '<div><label>Jumlah Qty Barang ' + (index + 1) + ' : </label><input name="qty_dtg[]"  class="form-control qty" value="' + row.qty_dtg + '" readonly></div>';
                    var satuanBerat  = '<div><label>Satuan Berat Barang ' + (index + 1) + ' : </label><input name="satuan_berat[]"  class="form-control qty" value="' + row.satuan_berat + '" readonly></div>';

                    $('#barang_container').append(namaBarangField);
                    $('#barang_container').append(qtyDatang);
                    $('#barang_container').append(satuanBerat);
                    totalQty += parseInt(row.qty_dtg);
                });

                $('#total_qty').val(totalQty);
                calculatePalletizations();
            }
        });
    });

    $('#max_qty').on('input', function() {
        calculatePalletizations();
    });

    $('#barang_container').on('input', '.qty', function() {
        calculateTotalQty();
    });

    function calculateTotalQty() {
        var totalQty = 0;
        $('.qty').each(function() {
            totalQty += parseInt($(this).val() || 0);
        });
        $('#total_qty').val(totalQty);
        calculatePalletizations();
    }

    function calculatePalletizations() {
        var totalQty = parseInt($('#total_qty').val());
        var maxQtyPerPallet = parseInt($('#max_qty').val());
        var numPalletizations = Math.ceil(totalQty / maxQtyPerPallet);
        $('#num_paletization').val(numPalletizations);
        addAdditionalForms(numPalletizations);
    }

    $('#num_paletization').on('input', function() {
        calculatePalletizations();
    });

    function generateNextKodePalletization() {
    var existingKodePallets = $('#kode_pallet').map(function() {
        return $(this).val();
    }).get();

    // If no existing Kode Palletizations found, start with PLT0001
    if (existingKodePallets.length === 0) {
        return 'PLT0001';
    }

    // Find the highest number from existing Kode Palletizations
    var maxNumber = Math.max.apply(null, existingKodePallets.map(function(kodePallet) {
        return parseInt(kodePallet.substring(3)); // Extract the number part
    }));

    // Increment the maximum number and format the next Kode Palletization
    var nextNumber = maxNumber + 1;
    var nextKodePalletization = 'PLT' + ('0000' + nextNumber).slice(-4);

    return nextKodePalletization;
}



    $('#num_paletization').on('input', function() {
        var jumlahPallet = parseInt($(this).val() || 0);
        addAdditionalForms(jumlahPallet);
    });

    // Function to add additional forms based on jumlah_pallet value
    // function addAdditionalForms(jumlahPallet) {
    //     $('#additional_forms_container').empty(); // Clear existing forms
        
    //     for (var i = 1; i <= jumlahPallet; i++) {
    //         var kodePalletization = generateNextKodePalletization(); // Generate next Kode Palletization
    //         var formHtml = '<div class="additional-form">' +
    //             '<label>Kode Palletization:</label>' +
    //             '<input type="text" name="kode_pallet[]" class="form-control kode-palletization" value="' + kodePalletization + '" readonly>' +
    //             // Add other form fields as needed
    //             '</div>';
    //         $('#additional_forms_container').append(formHtml);
    //     }
    // }

    // // Trigger form generation initially
    // addAdditionalForms(parseInt($('#num_paletization').val() || 0));
    


    $.ajax({
        url: '<?= base_url('/ambil_kode_pallet'); ?>',
        type: 'GET',
        success: function(hasil) {
            var code = $.parseJSON(hasil);
            $('#kode_pallet').val(code);
        }
    });
});

</script>
<?= $this->include('template/footer'); ?>