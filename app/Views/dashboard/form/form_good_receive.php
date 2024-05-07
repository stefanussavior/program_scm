<?= $this->include('template/navigation_bar'); ?>

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />


<title>Form Good Receive</title>

<!-- <style>
    *{
        box-sizing: border-box;
    }

    .row{
        display: flex;
    }

    .column {
        flex: 50%;
        padding: 10px;
        height: 300px;
    }
</style> -->

<div class="container-fluid">

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Form Good Receive</h1>
    <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
            class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
</div>

<!-- Content Row -->
<div>
    <div class="card">
        <div class="card-header">
            <b>Form Good Receive</b>
        </div>
        <div class="card-body" style="height: 50rem;">
            <form action="/submit_form_good_receive" method="POST" class="form-horizontal">
                    <div>
                        <label>Nomor PO : </label>
                        <br>
                        <select id="po_id" class="form-control" name="nomor_po">
                                <option value="" selected disabled>-- PILIH DATA PO ----</option>
                            <?php foreach ($master_po2 as $po2) : ?>
                                    <option value="<?php echo $po2['nomor_po'] ?>"><?php echo $po2['nomor_po']; ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div>
                            <label>Tanggal PO : </label>
                            <input type="text" class="form-control" name="tanggal_po" id="tanggal_po" readonly>
                        </div>
                        <div id="barang_container">
                            <!-- Dynamic nama barang, qty_po, and qty_dtg fields will be added here -->
                        </div>
                        <!-- <button type="button" id="add_field" class="btn btn-success">Add Field</button>
                        <button type="button" id="remove_field" class="btn btn-danger">Remove Field</button>                     -->
                <div>
                    <label>Nomor GR : </label>
                    <input type="text" name="nomor_gr" id="nomor_gr" class="form-control" readonly>
                </div>
                <div>
                    <label>Deskripsi GR : </label>
                    <textarea name="desc_gr" id="desc_gr" cols="6" rows="2" class="form-control"></textarea>
                </div>
                <div>
                    <label>Tanggal GR : </label>
                    <input type="date" name="tanggal_gr" id="tanggal_gr" class="form-control">
                </div>
                <div>
                    <label>Warehouse : </label>
                    <br>
                    <input type="text" name="warehouse" id="warehouse" class="form-control" value="WHCK2" readonly>
                <!-- <div>
                    <label>Supplier : </label>
                    <br>
                    <input type="text" name="supplier" id="supplier" class="form-control" readonly>
                </div> -->
                    <!-- <div>
                        <label>Nama Barang Supplier : </label>
                        <input type="text" name="nama_barang_supplier" id="nama_barang_supplier" class="form-control" readonly>
                    </div> -->
                <div>
                    <label>Estimasi Kirim : </label>
                    <input type="date" class="form-control" name="est_kirim" id="est_kirim">
                </div>
                <!-- <div>
                    <label>Qty Dtg : </label>
                    <input type="text" name="qty_dtg" id="qty_dtg" class="form-control">
                </div> -->
                <!-- <div>
                    <label>Kode Batch : </label>
                    <input type="text" class="form-control" id="kode_batch" name="kode_batch" readonly>
                </div> -->
                <div>
                    <label>Kode PRD : </label>
                    <input type="text" name="kode_prd" id="kode_prd" class="form-control" readonly>
                </div>
                <br/>
                <button type="submit" class="btn btn-primary">Submit</button>
                <button type="reset" class="btn btn-danger">Cancel</button>
            </div>
        </div>
            </form>
            <br/>
        </div>

            <?php foreach ($master_gr as $gr) : ?>
                <input type="hidden" id="last_gr_created_at" value="<?= $gr['created_at'] ?>"/>
            <?php endforeach ?>

            
            <?php foreach ($master_gr as $gr) : ?>
                <input type="hidden" id="nomor_gr" value="<?= $gr['nomor_gr'] ?>"/>
            <?php endforeach ?>

        <!-- <select name="po_id2" id="po_id2" class="form-control">

        </select>

        <div>
            <label>Nama Barang : </label>
            <input type="text" name="nama_barang" id="nama_barang2" class="form-control" readonly>
        </div>

        <div id="output">

            </div> -->
            <div>
            </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script>
    $(document).ready(function() {
        var max_fields = 10; // Maximum number of fields
        var wrapper = $("#barang_container"); // Fields wrapper
        var add_button = $("#add_field"); // Add button ID
        var x = 0; // Initial field counter

    
    // Get the value of last_gr_created_at from the hidden input field
    var lastGoodReceiveCreatedAt = $('#last_gr_created_at').val();
    // Get the value of last_nomor_gr from the input field
    var lastNomorGR = $('#nomor_gr').val();


  // Function to add fields dynamically
  $(add_button).click(function(e) {
            e.preventDefault();
            if (x < max_fields) {
                x++;
                // Append new fields
                var fieldHtml = '<div>';
                fieldHtml += '<label>Kode Barang ' + x + ' : </label>';
                fieldHtml += '<input type="text" name="kode[]" class="form-control">';
                // Add other fields similarly
                fieldHtml += '</div>';
                $(wrapper).append(fieldHtml);
            }
        });


         // Function to remove fields dynamically
        $(wrapper).on("click", "#remove_field", function(e) {
            e.preventDefault();
            $(this).parent('div').remove();
            x--;
        });



    $('#po_id').select2();
    // $('#supplier').select2();
    $('#warehouse_id').select2();
    $('#po_id2').select2();

    $('#po_id').on('change', function(){
        var nomor_po = $(this).val();
        $.ajax({
            url: '<?= site_url("/check_po_fullfiled") ?>',
            method: 'POST',
            data: { nomor_po: nomor_po },
            dataType: 'json',
            success: function(response) {
                if (response.fulfilled) {
                    // If PO has been fulfilled, show an alert and reset the select field
                    alert('Nomor PO ' + nomor_po + ' tidak bisa digunakan karena sudah fullfiled.');
        $('#po_id').val(null).trigger('change');
                }
            },
            error: function() {
                alert('Error checking PO fulfillment.');
            }
        });
        
        $.ajax({
            url: '<?= site_url("/ajax_get_po_id") ?>',
            method: 'GET',
            data: {
                nomor_po: nomor_po,
            },
            dataType: 'JSON',
            success: function (response) {
                $('#tanggal_po').val(response.record.tanggal_po);
                // Clear existing options
                $(wrapper).empty();
                // Populate nama_barang, qty_po, and qty_dtg fields with all data related to nomor_po
                $.each(response.data, function(index, row) {
                    var fieldHtml = '<div>';
                    var kodeBarangInput = '<div><label>Kode Barang ' + (index + 1) + ' : </label><input type ="text" name="kode[]" id="kode" class="form-control" value="' + row.kode + '"readonly></div>';
                    $('#barang_container').append(kodeBarangInput);
                    var PemasokInput = '<div><label>Supplier Barang ' + (index + 1) + ' : </label><input type ="text" name="supplier[]" id="supplier" class="form-control" value="' + row.pemasok + '"readonly></div>';
                    $('#barang_container').append(PemasokInput);
                    var namaBarangInput = '<div><label>Nama Barang ' + (index + 1) + ' : </label><input name="nama_barang[]" id="nama_barang" class="form-control" value="' + row.nama_barang + '"readonly></div>';
                    $('#barang_container').append(namaBarangInput);
                    var qtyPoInput = '<div><label>Qty PO ' + (index + 1) + ': </label><input type="number" name="qty_po[]" id="qty_po_' + (index + 1) + '" class="form-control" value="' + row.kuantitas + '" readonly></div>';
                    $('#barang_container').append(qtyPoInput);
                    var satuan = '<div><label>Satuan Berat ' + (index + 1) + ': </label><input name="satuan[]" id="satuan' + (index + 1) + '" class="form-control" value="' + row.satuan + '" readonly></div>';
                    $('#barang_container').append(satuan);
                    var qtyDtgInput = '<div><label>Qty DTG ' + (index + 1) + ': </label><input type="number" name="qty_dtg[]" id="qty_dtg_' + (index + 1) + '" class="form-control" onkeypress="return isNumberKey(event)"></div>';
                    $('#barang_container').append(qtyDtgInput);
                    var kodeBatch = '<div><label>Kode Batch Barang ' + (index + 1) + ': </label><input type="text" name="kode_batch[]" id="kode_batch' + (index + 1) + '" class="form-control"></div>';
                    $('#barang_container').append(kodeBatch);
                    var expDate = '<div><label>Expired Date Barang ' + (index + 1) + ': </label><input type="date" name="exp_date[]" id="exp_date' + (index + 1) + '" class="form-control"></div>';
                    $('#barang_container').append(expDate);
                    fieldHtml += '</div>';
                    $(wrapper).append(fieldHtml);


                    var qty_dtg_input = $('#qty_dtg_' + (index + 1));
                    qty_dtg_input.on('keyup', function() {
                        var qty_dtg = $(this).val();
                        var qty_po = row.kuantitas; // Convert qty_po to a number

                        // Remove existing alert if any
                        $(this).closest('div').find('.alert').remove();

                        if (qty_po === qty_dtg) {
                            // Quantity fulfilled
                            $(this).closest('div').append('<div class="alert alert-success" role="alert">Quantity Fulfilled</div>');
                        } else if (qty_po < qty_dtg) {
                            // Quantity outstanding
                            $(this).closest('div').append('<div class="alert alert-danger" role="alert">Warning! Data Quantity Datang lebih besar</div>');
                        } else {
                            $(this).closest('div').append('<div class="alert alert-warning" role="alert">Quantity OutStanding</div>');
                        }
                    });
                });
            },
            error: function() {
                alert('Error fetching data');
            }
        });
    });
});

    $('#supplier').on('change',function(){
            var pemasok = $(this).val();
            $.ajax({
                url: '<?= site_url('/ajax_get_data_supplier') ?>',
                method: 'GET',
                data: {
                    pemasok: pemasok,
                },
                dataType: 'JSON',
                success: function (response) {
                    $('#product').val('');
                    $.each(response.data, function(index, row) {
                        $('#product').val($('#product').val() + row.nama_barang + ', ');
                    });
                },
                error: function() {
                    alert('Error fetching data');
                }
            });
        });


        function showAlertAndConfirmSubmission(lastCreatedAt, lastNomorGR) {
            var confirmationMessage = "Last Good Receive created at: " + lastCreatedAt + "\nLast Nomor GR: " + lastNomorGR + "\n\nDo you want to proceed with the submission?";
            // Show the confirmation dialog
            var confirmation = confirm(confirmationMessage);
            // Return the confirmation result
            return confirmation;
        }




    $('form').submit(function(e) {
        // Prevent the default form submission
        e.preventDefault();

        // Check if any qty_dtg exceeds qty_po
        var error = false;
            $('input[name^="qty_dtg"]').each(function(index) {
                var qtyDtG = $(this).val();
                var qtyPo = $('input[name="qty_po[]"]').eq(index).val();

                if (parseInt(qtyDtG) > parseInt(qtyPo)) {
                    error = true;
                    // Display an alert indicating the error
                    alert('Error, Data Kuantitas Datang Lebih Besar Dari Data Kuantitas PO');
                    return false; // Exit the loop early
                }
            });

            if (error) {
                // If there's an error, stop further processing
                return;
            }

            // Get the value of last_gr_created_at from the hidden input field
            var lastGoodReceiveCreatedAt = $('#last_gr_created_at').val();
            // Get the value of last_nomor_gr from the input field
            var lastNomorGR = $('#nomor_gr').val();

            // Display the alert and confirm submission
            var confirmation = showAlertAndConfirmSubmission(lastGoodReceiveCreatedAt, lastNomorGR);

            // If user confirms, submit the form
            if (confirmation) {
                // Submit the form
                this.submit();
            } else {
                // If user cancels, do nothing
                return false;
            }
        });


    $.ajax({
        url: '<?= base_url('/ambil_kode_gr'); ?>',
        type: 'GET',
        success: function (hasil) {
            var code = $.parseJSON(hasil);
            $('#nomor_gr').val(code);
        }
    });
    $.ajax({
        url: '<?= base_url('/ambil_kode_batch'); ?>',
        type: 'GET',
        success: function(hasil) {
            var code = $.parseJSON(hasil);
            $('#kode_batch').val(code);
        }
    });
    $.ajax({
        url: '<?= base_url('/ambil_kode_prd'); ?>',
        type: 'GET',
        success: function(hasil) {
            var code = $.parseJSON(hasil);
            $('#kode_prd').val(code);
        }
    });

    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
    return true;
}
    </script>
    <?= $this->include('template/footer'); ?>
