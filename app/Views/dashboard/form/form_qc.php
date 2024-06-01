<?= $this->include('template/navigation_bar'); ?>

<title>Form Quality Control</title>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<style>
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
</style>

<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Quality Control</h1>
    </div>
    <div class="card">
        <div class="card-header">
            <b>Quality Control</b>
        </div>
        <div class="card-body" style="height:58rem;">
            <form id="submit_form_qc" method="post">
        <div class="row">
            <div class="column">
                <div>
                    <label>Nomor PO : </label>
                    <select id="po_id" class="form-control" name="nomor_po">
                                <option value="" selected disabled>-- PILIH DATA PO ----</option>
                                <?php foreach ($master_po2 as $po2): ?>
                                    <option value="<?php echo $po2['nomor_po'] ?>"><?php echo $po2['nomor_po']; ?></option>
                                <?php endforeach ?>
                            </select>
                </div>
                <br>
                <div id="qc_form_container"></div>
            <!-- <div>
                <label>Product : </label>
                <input type="text" name="product" id="product" class="form-control" readonly>
            </div>
            <div>
                <label>Lots : </label>
                <input type="text" name="lots" id="lots" class="form-control">
            </div>
            <div>
                <label>Produsen : </label>
                <input type="text" name="produsen" id="produsen" class="form-control">
            </div>
            <div>
                <label>COO : </label>
                <br/>
                <div class="form-check form-check-inline">
                    <input class="form-check-label" type="radio" name="coo" id="coo" value="ada">
                    <label class="form-check-label" for="coo">Ada</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-label" type="radio" name="coo" id="coo" value="tidak_ada">
                    <label class="form-check-label" for="coo">Tidak Ada</label>
                </div>
            </div>
            <div>
            <label>COA : </label>
                <br/>
                <div class="form-check form-check-inline">
                    <input class="form-check-label" type="radio" name="coa" id="coa" value="ada">
                    <label class="form-check-label" for="coa">Ada</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-label" type="radio" name="coa" id="coa" value="tidak_ada">
                    <label class="form-check-label" for="coa">Tidak Ada</label>
                </div>
            </div>
            <div>
            <label>Sertifikat Halal : </label>
                <br/>
                <div class="form-check form-check-inline">
                    <input class="form-check-label" type="radio" name="sertifikat_halal" id="sertifikat_halal" value="ada">
                    <label class="form-check-label" for="sertifikat_halal">Ada</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-label" type="radio" name="sertifikat_halal" id="sertifikat_halal" value="tidak_ada">
                    <label class="form-check-label" for="sertifikat_halal">Tidak Ada</label>
                </div>
            </div>
            <div>
                <label>UOM Sampling : </label>
                <input type="text" name="uom" id="uom" class="form-control">
            </div>
            <div>
                <label>Qty Sampling : </label>
                <input type="text" name="qty_sampling" id="qty_sampling" class="form-control">
            </div>
            <div>
                <label>Qty Reject : </label>
                <input type="text" name="qty_reject" id="qty_reject" class="form-control">
            </div>
            <div>
                <label>Qty GR : </label>
                <input type="text" name="qty_gr" id="qty_gr" class="form-control">
            </div>
            <div>
                <label>Package : </label>
                <input type="text" name="package" id="package" class="form-control">
            </div>
</div>
<div class="column">
            <div>
                <label>Visual Organoleptik : </label>
                <input type="text" name="visual_organoleptik" id="visual_organoleptik" class="form-control">
            </div>
            <div>
                <label>Vehicle Desc : </label>
                <textarea name="vehicle_desc" id="vehicle_desc" cols="10" rows="7" class="form-control"></textarea>
            </div>
            <div>
                <label>QC Desc : </label>
                <input type="text" name="qc_desc" id="qc_desc" class="form-control">
            </div>
            <div>
                <label>Lots RM : </label>
                <input type="text" name="lots_rm" id="lots_rm" class="form-control">
            </div>
            <div>
                <label>Perform : </label>
                <input type="text" name="perform" id="perform" class="form-control">
            </div>
            <div>
                <label>QC Reject Desc : </label>
                <textarea name="qc_reject_desc" id="qc_reject_desc" cols="10" rows="8" class="form-control"></textarea>
            </div>
            <div>
                <label>Status : </label>
                <select name="status" id="status" class="form-control">
                <option value="" selected disable>--- Pilih Status ----</option>
                    <option value="reject">Reject</option>
                    <option value="hold">Hold</option>
                    <option value="release">Release</option>
                </select>
            </div> -->
            <br/>
            <button type="submit" class="btn btn-primary">Submit</button>
            <button type="reset" class="btn btn-danger">Cancel</button>
            </div>
        </div>
        </form>
    </div>
</div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {

        $('#po_id').select2();

        $('#po_id').on('change', function(){
            var nomor_po = $(this).val();
            $.ajax({
                url: '<?= site_url('/ajax_get_data_gr_nomor_po') ?>',
                method: 'GET',
                data: { 
                    nomor_po : nomor_po
                },
                dataType: 'JSON',
                success: function(response) {
                    $('#qc_form_container').empty(); 

                    $.each(response.record, function (index, row) {

                        var fieldHtml = '<h2>Form Barang QC ke-'+(index + 1)+' : </h2><div class="row">';

                        // var headerBarang = '<h2>Form QC Barang ke : ' + (index + 1) + '</h2><br/>';
                        // fieldHtml += headerBarang;
                        
                        var namaBarangInput = '<div class="col-sm-6"><label>Nama Barang ' + (index + 1) + ' : </label><input type="text" name="nama_barang[]" id="nama_barang[]_' + (index + 1) + '" class="form-control" value="' + row.nama_barang + '" readonly></div>';
                        fieldHtml += namaBarangInput;

                        // var productInput = '<div class="col-sm-6"><label>Product ' + (index + 1) + ' : </label><input name="product[]" id="product_' + (index + 1) + '" class="form-control"></div>';
                        // fieldHtml += productInput;

                        var qtyPO = '<div class="col-sm-6"><label> Qty PO ' + (index + 1) + ' : </label><input type="text" name="qty_po[]" id="qty_po[]_' + (index + 1) + '" class="form-control" value="' + row.qty_po +'" readonly></div>';
                        fieldHtml += qtyPO;

                        var uomSamplingInput = '<div class="col-sm-6"><label> UOM Sampling  ' + (index + 1) + ' : </label><input type="text" name="uom[]" id="uom[]_' + (index + 1) + '" class="form-control" value="' + row.satuan +'" readonly></div>';
                        fieldHtml += uomSamplingInput;

                        var tanggalQC = '<div class="col-sm-6"><label> Tanggal QC  ' + (index + 1) + ' : </label><input type="date" name="tanggal_qc[]" id="tanggal_qc"' + (index + 1) + '" class="form-control tanggal_qc"></div>';
                        fieldHtml += tanggalQC;

                        var lots = '<div class="col-sm-6"><label>Lots ' + (index + 1) + ' : </label><input name="lots[]" id="lots[]_' + (index + 1) + '" class="form-control"></div><br/>';
                        fieldHtml += lots;

                        var produsen = '<div class="col-sm-6"><label>Produsen ' + (index + 1) + ' : </label><input name="produsen[]" id="produsen[]_' + (index + 1) + '" class="form-control"></div><br/>';
                        fieldHtml += produsen;

                        var COO = '<br/><div class="col-sm-6"><label> COO ' + (index + 1) + ' : </label><br/><select name="coo[]" class="form-control"><option value="" selected disabled>-- PILIH COO ---</option><option value="ada"> Ada </option><option value="tidak ada"> Tidak Ada </option></select></div>';
                        fieldHtml += COO;

                        var COA = '<br/><div class="col-sm-6"><label> COA ' + (index + 1) + ' : </label><br/><select name="coa[]" class="form-control"><option value="" selected disabled>-- PILIH COA ---</option><option value="ada"> Ada </option><option value="tidak ada"> Tidak Ada </option></select></div><br/>';
                        fieldHtml += COA;

                        var sertifikatHalal = '<br/><div class="col-sm-6"><label> Sertifikat Halal ' + (index + 1) + ' : </label><select name="sertifikat_halal[]" class="form-control"><br/><option value="" selected disabled>-- PILIH SERTIFIKAT HALAL ---</option><option value="ada"> Ada </option><option value="tidak ada"> Tidak Ada </option></select></div>';
                        fieldHtml += sertifikatHalal;


                        var qtySamplingInput = '<div class="col-sm-6"><label> Qty Sampling  ' + (index + 1) + ' : </label><input type="number" name="qty_sampling[]" id="qty_sampling[]_' + (index + 1) + '" class="form-control" onkeypress="return isNumberKey(event)"></div>';
                        fieldHtml += qtySamplingInput;

                        var qtyRejectInput = '<div class="col-sm-6"><label> Qty Reject Input ' + (index + 1) + ' : </label><input type="number" name="qty_reject[]" id="qty_reject[]_' + (index + 1) + '" class="form-control" onkeypress="return isNumberKey(event)"></div>';
                        fieldHtml += qtyRejectInput;

                        var packageInput = '<div class="col-sm-6"><label> Package Input ' + (index + 1) + ' : </label><input name="package[]" id="package[]_' + (index + 1) + '" class="form-control"></div>';
                        fieldHtml += packageInput;

                        var visualInput = '<div class="col-sm-6"><label> Visual Organoleptik ' + (index + 1) + ' : </label><input name="visual_organoleptik[]" id="visual_organoleptik[]_' + (index + 1) + '" class="form-control"></div>';
                        fieldHtml += visualInput;

                        var qcDescInput = '<div class="col-sm-6"><label> QC Desc ' + (index + 1) + ' : </label><input name="qc_dc[]" id="qc_dc[]_' + (index + 1) + '" class="form-control"></div>';
                        fieldHtml += qcDescInput;

                        var lotsRMInput = '<div class="col-sm-6"><label> Lots RM ' + (index + 1) + ' : </label><input name="lots_rm[]" id="lots_rm[]_' + (index + 1) + '" class="form-control"></div>';
                        fieldHtml += lotsRMInput;

                        var performInput = '<div class="col-sm-6"><label> Perform Input ' + (index + 1) + ' : </label><input name="perform[]" id="perfom[]_' + (index + 1) + '" class="form-control"></div>';
                        fieldHtml += performInput;

                        var qcRejectDescInput = '<div class="col-sm-6"><label> QC Reject Desc ' + (index + 1) + ' : </label><input name="qc_reject_desc[]" id="qc_reject_desc[]_' + (index + 1) + '" class="form-control"></div>';
                        fieldHtml += qcRejectDescInput;

                        var statusInput = '<div class="col-sm-6"><label> Status ' + (index + 1) + ' : </label><select name="status[]" id="status[]" class="form-control"><option value="" selected disabled>-- PILIH STATUS ---</option><option value="hold">Hold</option><option value="reject">Reject</option><option value="release">Release</option></select></div>';
                        fieldHtml += statusInput;

                        fieldHtml += '</div><br/>';
                        $('#qc_form_container').append(fieldHtml);
                    });
                    setMinDateForExpDateFields();
                },
                error: function(xhr, status, error) {
                    console.error('Error: ' + error);
                }

            });
        });


function setMinDateForExpDateFields() {
    var today = new Date().toISOString().split('T')[0];
    $('#tanggal_qc').each(function () {
        var currentValue = $(this).val();
        if (currentValue < today) {
            $(this).val(today);
        }
        $(this).attr('min', today);
    });
}



        $('#submit_form_qc').on('submit', function(event) {
            event.preventDefault();

            Swal.fire({
                title: 'Konfirmasi Form QC',
                text: 'Apakah anda yakin akan data yang sudah diisi?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, saya yakin'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '<?= site_url('/submit_form_qc'); ?>',
                        method: 'POST',
                        data: $(this).serialize(),
                        success: function(response) {

                            Swal.fire(
                                'Submitted!',
                                'Your form has been submitted.',
                                'success'
                            );

                            setTimeout(function() {
                                Swal.fire(
                                    'Success!',
                                    'Data Berhasil Terkirim',
                                    'success'
                                );
                            }, 2000);

                            location.reload('<?= site_url('/master_data_qc') ?>');
                        },
                        error: function(xhr, status, error) {
                            Swal.fire(
                                'Error!',
                                'There was an error submitting your form. Please try again.',
                                'error'
                            );
                        }
                    });
                }
            });
        });
    });


    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
    }

    </script>
    
    <?= $this->include('template/footer'); ?>