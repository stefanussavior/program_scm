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
            <h1 class="h3 mb-0 text-gray-800">Form Quality Control</h1>
    </div>
    <div class="card">
        <div class="card-header">
            <b>Form Quality Control</b>
        </div>
        <div class="card-body" style="height:58rem;">
            <form action="/submit_form_qc" method="post">
        <div class="row">
            <div class="column">
                <div>
                    <label>Supplier : </label>
                    <select name="supplier" id="supplier" class="form-control">
                        <option value="" select disable>--- Pilih Data Warehouse ----</option>
                        <?php foreach ($master_supplier as $supplier) : ?>
                            <option value="<?php echo $supplier['id'] ?>"><?php echo $supplier['pemasok']; ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
            <div>
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
            </div>
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
<script>
    $(document).ready(function(){
        $('#supplier').select2();
        $('#supplier').on('change',function(){
            var id = $(this).val();
            $.ajax({
                url: '<?= base_url('/get_data_ajax_supplier') ?>',
                method: 'GET',
                data: {
                    id: id,
                },
                dataType: 'JSON',
                success: function (response) {
                    $('#product').val(response.record.nama_barang);
                },
                error: function() {
                    alert('Error fetching data');
                }
            });
        });
    });

    </script>
    
    <?= $this->include('template/footer'); ?>