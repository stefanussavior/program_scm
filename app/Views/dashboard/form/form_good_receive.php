<?= $this->include('template/navigation_bar'); ?>



<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<title>Good Receive</title>

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
        <h1 class="h3 mb-0 text-gray-800">Good Receive</h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
    </div>

    <!-- Content Row -->
    <div>
        <div class="card">
            <div class="card-header">
                <b>Form Good Receive</b>
            </div>
            <div class="card-body" >
                <form action="/submit_form_good_receive" method="POST" class="form-horizontal">
                    <div class="row">
                        <div class="col-md-12 mb-2">
                            <label>Nomor PO : </label>
                            <br>
                            <select id="po_id" class="form-control" name="nomor_po">
                                <option value="" selected disabled>-- PILIH DATA PO ----</option>
                                <?php foreach ($master_po2 as $po2): ?>
                                    <option value="<?php echo $po2['nomor_po'] ?>"><?php echo $po2['nomor_po']; ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label>Tanggal PO : </label>
                            <input type="text" class="form-control" name="tanggal_po" id="tanggal_po" readonly>
                        </div>
                    </div>
                            <div class=" mb-2">
                                <label>Nomor GR : </label>
                                <input type="text" name="nomor_gr" id="nomor_gr" class="form-control" readonly>
                            </div>

                            <div id="barang_container"></div>
                            <div class="mb-2">
                                <button id="add_field" type="button" class="btn btn-success">Add Item</button>
                            </div>
                            
                            <div class="mt-2 mb-2">
                                <label>Deskripsi GR : </label>
                                <textarea name="desc_gr" id="desc_gr" cols="6" rows="2" class="form-control"></textarea>
                            </div>
                            <div class="mt-2 mb-2">
                                <label>Tanggal GR : </label>
                                <input type="date" name="tanggal_gr" id="tanggal_gr" class="form-control">
                            </div>
                            <div class="mt-2 mb-2">
                                <label>Warehouse : </label>
                                <br>
                                <input type="text" name="warehouse" id="warehouse" class="form-control" value="WHCK2" readonly>

                                <div class="mt-2 mb-2">
                                    <label>Estimasi Kirim : </label>
                                    <input type="date" class="form-control" name="est_kirim" id="est_kirim">
                                </div>
    
                                <div class="mt-2 mb-2">
                                    <label>Kode PRD : </label>
                                    <input type="text" name="kode_prd" id="kode_prd" class="form-control" readonly>
                                </div>
                                <br />
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <button type="reset" class="btn btn-danger">Cancel</button>
                            </div>
                        
                        </div>
                    </div>
            </div>
            </form>
            <br />
        </div>

        <?php foreach ($master_gr as $gr): ?>
            <input type="hidden" id="last_gr_created_at" value="<?= $gr['created_at'] ?>" />
        <?php endforeach ?>


        <?php foreach ($master_gr as $gr): ?>
            <input type="hidden" id="nomor_gr" value="<?= $gr['nomor_gr'] ?>" />
        <?php endforeach ?>
        </div>
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script>
   $(document).ready(function () {
    var max_fields = 10;
    var wrapper = $("#barang_container"); 
    var x = 0;
    var add_button = $('#add_field');

    var today = new Date().toISOString().split('T')[0];
        $('#tanggal_gr').attr('min', today);
        $('#est_kirim').attr('min', today);

        $('#po_id').on('change', function () {
        var nomor_po = $(this).val(); 
        if (nomor_po) {
            checkPOStatus(nomor_po); 
        }
    });

    function checkPOStatus(nomor_po) {
        
    $.ajax({
        url: '/check_po_fullfiled', // Update the URL as needed
        method: 'POST',
        data: { nomor_po: nomor_po },
        dataType: 'json',
        success: function (response) {
            // Check the status returned from the server
            switch (response.status) {
                case 'outstanding':
                    alert(response.message);
                    $('input[name^="qty_dtg"]').val(0).prop('readonly', true); // Clear the value and make it readonly
                    $('input[name^="kode_batch"]').val(0).prop('readonly', true); // Clear the value and make it readonly
                    $('input[name^="qty_gr_outstd"]').val(0).prop('readonly', true);
                    // $('#barang_container').empty();
                    $.ajax({
                        url: '/fetch_qty_dtg', // Update the URL as needed
                        method: 'POST',
                        data: { nomor_po: nomor_po },
                        dataType: 'json',
                        success: function (qtyDtGResponse) {
                            // Populate qty_dtg field with fetched data
                            // $('input[name^="qty_dtg"]').val(qtyDtGResponse.qty_dtg);
                        },
                        error: function () {
                            alert('Error fetching qty_dtg data.');
                        }
                    });
                    break;
                case 'fulfilled':
                    alert(response.message); // Display an alert for fulfilled PO
                    add_button.hide();
                    $('input[name^="qty_dtg"]').prop('readonly', false); // Ensure it is editable if needed
                    break;
                case 'not_fulfilled':
                    alert(response.message); // Display an alert for not fulfilled PO
                    $('input[name^="qty_dtg"]').prop('readonly', false); // Ensure it is editable if needed
                    $('#add_field').hide();
                    break;
                default:
                     add_button.hide(); // Hide the button
                    alert('Error occurred while checking PO status.'); // Display an error alert
                    break;
            }
        },
        error: function () {
            alert('Error occurred while checking PO status.'); // Display an error alert
        }
    });
}



function setMinDateForExpDateFields() {
    var today = new Date().toISOString().split('T')[0];
    $('.exp_date').each(function () {
        var currentValue = $(this).val();
        if (currentValue < today) {
            $(this).val(today);
        }
        $(this).attr('min', today);
    });
}

    $(document).on("change", ".kode_append", function () {
            var kodeBarang = $(this).val();
            var supplierInput = $(this).closest('.row').find('input[name="supplier[]"]');
            var namaBarangInput = $(this).closest('.row').find('input[name="nama_barang[]"]');
            var qtyPOInput = $(this).closest('.row').find('input[name="qty_po[]"]');
            // var kodeBatchInput = $(this).closest('.row').find('input[name="kode_batch[]"]');
            // var qtyOutstandingInpiut = $(this).closest('.row').find('input[name="qty_gr_outstd[]"]'); 
            var qtyDTGInput = $(this).closest('.row').find('input[name="qty_dtg[]"]');
            // var expInput = $(this).closest('.row').find('input[name="exp_date[]"]');
            var satuanInput = $(this).closest('.row').find('input[name="satuan[]"]');

            $.ajax({
                url: '<?= site_url("/fetch_barang_details") ?>',
                method: 'POST',
                data: { kode: kodeBarang },
                dataType: 'json',
                success: function (response) {
                    if (response?.data !== undefined && response.data !== "") {
                        supplierInput.val(response.data.supplier ?? "");
                        namaBarangInput.val(response.data.nama_barang ?? "");
                        qtyPOInput.val(response.data.qty_po ?? "");
                        // kodeBatchInput.val(response.data.kode_batch ?? "");
                        // qtyOutstandingInpiut.val(response.data.qty_gr_outstd ?? "");
                        qtyDTGInput.val(response.data.qty_dtg ?? "");
                        // expInput.val(response.data.exp_date ?? "");
                        satuanInput.val(response.data.satuan ?? "");
                    } else {
                        alert(response.message);
                    }
                },
                error: function () {
                    alert('Error fetching Barang details');
                }
            });
        });

        $('#po_id').select2();
        $('#kode_append').select2();
        // $('#supplier').select2();
        $('#warehouse_id').select2();
        $('#po_id2').select2();

        $('#po_id').on('change', function () {
        var nomor_po = $(this).val();
        $.ajax({
            url: '<?= site_url("/ajax_get_po_id") ?>',
            method: 'GET',
            data: { nomor_po: nomor_po },
            dataType: 'json',
            success: function (response) {
                // Clear existing options
                $(wrapper).empty();
                // Populate fields with data related to nomor_po
                $.each(response.data, function (index, row) {
                    
                    var fieldHtml = '<div class="row">';
                    var kodeBarangInput = '<div class="col-sm-6"><label>Kode Barang ' + (index + 1) + ' : </label><input type="text" name="kode[]" id="kode" class="form-control" value="' + row.kode + '" readonly></div>';
                    fieldHtml += kodeBarangInput;
                    // Add other fields similarly
                    fieldHtml += '</div>';
                    $(wrapper).append(fieldHtml);
                });
            },
            error: function () {
                alert('Error fetching data');
            }
        });

        var lastGrCreatedAt = $('#last_gr_created_at').val();
        var nomorGr = $('#nomor_gr').val();

        if (lastGrCreatedAt && nomorGr) {
            var formattedDate = lastGrCreatedAt.split(' ')[0];
        }

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
                    if (response.record.status == 'outstanding') {
                        return;
                    }
                    $.each(response.data, function (index, row) {
                        
                        var fieldHtml = '<br><h3>Form Data Barang Good Receive ke-' + (index + 1) +'</h3><div class="row">';
                        var nomorQCInput = '<div class="col-sm-6"><label>Nomor QC barang ' + (index + 1) + ' : </label><input type="text" name="nomor_qc[]" id="nomor_qc" class="form-control" value="' + row.nomor_qc + '"readonly></div>';
                        fieldHtml += nomorQCInput;
                        
                        var kodeBarangInput = '<div class="col-sm-6"><label>Kode Barang ' + (index + 1) + ' : </label><input type="text" name="kode[]" id="kode_' + (index + 1) + '" class="form-control" value="' + row.kode + '" readonly></div>';
                        fieldHtml += kodeBarangInput;

                        var PemasokInput = '<div class="col-sm-6"><label>Supplier Barang ' + (index + 1) + ' : </label><input type="text" name="supplier[]" id="supplier_' + (index + 1) + '" class="form-control" value="' + row.supplier + '" readonly></div>';
                        fieldHtml += PemasokInput;
                        
                        fieldHtml += '</div>';
                        $('#barang_container').append(fieldHtml);

                        fieldHtml = '<div class="row">';
                        var namaBarangInput = '<div class="col-sm-6"><label>Nama Barang ' + (index + 1) + ' : </label><input name="nama_barang[]" id="nama_barang_' + (index + 1) + '" class="form-control" value="' + row.nama_barang + '" readonly></div>';
                        fieldHtml += namaBarangInput;
                        var qtyPoInput = '<div class="col-sm-6"><label>Qty PO ' + (index + 1) + ': </label><input type="number" name="qty_po[]" id="qty_po_' + (index + 1) + '" class="form-control" value="' + row.qty_po + '" readonly></div>';
                        fieldHtml += qtyPoInput;
                        fieldHtml += '</div>';
                        $('#barang_container').append(fieldHtml);

                        fieldHtml = '<div class="row">';
                        var satuan = '<div class="col-sm-6"><label>Satuan Berat ' + (index + 1) + ': </label><input name="satuan[]" id="satuan_' + (index + 1) + '" class="form-control" value="' + row.satuan + '" readonly></div>';
                        fieldHtml += satuan;
                        var qtyDtgInput = '<div class="col-sm-6"><label>Qty DTG ' + (index + 1) + ': </label><input type="number" name="qty_dtg[]" id="qty_dtg_' + (index + 1) + '" class="form-control" onkeypress="return isNumberKey(event)"></div>';
                        fieldHtml += qtyDtgInput;
                        fieldHtml += '</div>';
                        $('#barang_container').append(fieldHtml);

                        fieldHtml = '<div class="row">';
                        var kodeBatch = '<div class="col-sm-6"><label>Kode Batch Barang ' + (index + 1) + ': </label><input type="text" name="kode_batch[]" id="kode_batch_' + (index + 1) + '" class="form-control"></div>';
                        fieldHtml += kodeBatch;
                        var expDate = '<div class="col-sm-6"><label>Expired Date Barang ' + (index + 1) + ': </label><input type="date" name="exp_date[]" id="exp_date_' + (index + 1) + '" class="form-control exp_date"></div>';
                        fieldHtml += expDate;

                        var qtyOutstanding = '<div class="col-sm-6"><label>Qty Outstanding ' + (index + 1) + ': </label><input type="number" name="qty_gr_outstd[]" id="qty_gr_outstd_' + (index + 1) + '" class="form-control" readonly></div>';
                        fieldHtml += qtyOutstanding;

                        fieldHtml += '</div>';

                        $('#barang_container').append(fieldHtml);
                        setMinDateForExpDateFields();


                        var qty_dtg_input = $('#qty_dtg_' + (index + 1));
                        qty_dtg_input.on('keyup', function () {
                            var qty_dtg = $(this).val();
                            var qty_po = parseInt(row.kuantitas); 

                            // // Remove existing alert if any
                            // $(this).closest('div').find('.alert').remove();

                            // if (qty_dtg === qty_po) {
                            //     // Quantity fulfilled
                            //     $(this).closest('div').append('<div class="alert alert-success" role="alert">Quantity Fulfilled</div>');
                            // } else if (qty_dtg > qty_po) {
                            //     // Quantity outstanding
                            //     $(this).closest('div').append('<div class="alert alert-danger" role="alert">Warning! Data Quantity Datang lebih besar</div>');
                            // } else {
                            //     $(this).closest('div').append('<div class="alert alert-warning" role="alert">Quantity OutStanding</div>');
                            // }
                        });
                    });
                },
                error: function () {
                    alert('Error fetching data');
                }
            });
        });
    });

    $('#supplier').on('change', function () {
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
                $.each(response.data, function (index, row) {
                    $('#product').val($('#product').val() + row.nama_barang + ', ');
                });
            },
            error: function () {
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


    function updateQtyOutstanding(index) {
        var qtyDtG = $('#qty_dtg_' + index).val();
    var qtyPo = $('#qty_po_' + index).val();

    // Calculate Qty Outstanding
    var qtyOutstanding = parseInt(qtyPo) - parseInt(qtyDtG);

    // Update the Qty Outstanding field
    $('#qty_gr_outstd_' + index).val(qtyOutstanding);

    // Handle the case when qty_dtg is equal to qty_po
    if (parseInt(qtyDtG) === parseInt(qtyPo)) {
        // Quantity fulfilled
        $('#qty_dtg_' + index).closest('div').find('.alert').remove();
        $('#qty_dtg_' + index).closest('div').append('<div class="alert alert-success" role="alert">Quantity Fulfilled</div>');
    } else if (parseInt(qtyDtG) >= parseInt(qtyPo)) {
        $('#qty_dtg_' + index).closest('div').find('.alert').remove();
        $('#qty_dtg_' + index).closest('div').append('<div class="alert alert-danger" role="alert">Warning, Qty Datang lebih besar daripada Qty PO</div>');
    } else {
        $('#qty_dtg_' + index).closest('div').find('.alert').remove();
        $('#qty_dtg_' + index).closest('div').append('<div class="alert alert-warning" role="alert">Quantity Outstanding</div>');
    }
}

    $('body').on('input', 'input[name^="qty_dtg"]', function () {
        var index = $(this).attr('id').split('_').pop();
        updateQtyOutstanding(index);
    });


    $('form').submit(function (e) {
        e.preventDefault();
        var error = false;
        $('input[name^="qty_dtg"]').each(function (index) {
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
            return;
        }

        var lastGoodReceiveCreatedAt = $('#last_gr_created_at').val();
        var lastNomorGR = $('#nomor_gr').val();

        var confirmation = showAlertAndConfirmSubmission(lastGoodReceiveCreatedAt, lastNomorGR);
        if (confirmation) {
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
        success: function (hasil) {
            var code = $.parseJSON(hasil);
            $('#kode_batch').val(code);
        }
    });
    $.ajax({
        url: '<?= base_url('/ambil_kode_prd'); ?>',
        type: 'GET',
        success: function (hasil) {
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