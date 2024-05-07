<?= $this->include('template/navigation_bar'); ?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
	<script src="https://code.jquery.com/jquery-3.4.1.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<title>Form Tambah Data Warehouse</title>

<div class="container-fluid">

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"> Form Tambah Data Warehouse </h1>
    <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
        <i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
</div>

<!-- Content Row -->
<div>
    <div class="card">
        <div class="card-header">
        </div>
        <div class="card-body" style="height: 50rem;">
            <form action="/submit_form_tambah_data_warehouse" method="POST" class="form-horizontal">

                    <div>
                        <label>Nama Kota : </label>
                            <input type="text" name="nama_kota" id="nama_kota" class="form-control">
                        <br>
                    </div>
                    <div>
                        <label>Nama Jalan : </label>
                        <input type="text" name="nama_jalan" id="nama_jalan" class="form-control">
                    </div>
                    <div>
                        <label>Kode Resto Baru : </label>
                        <input type="text" name="kode_resto_baru" id="kode_resto_baru" class="form-control">
                    </div>
                    <div>
                        <label>Nama Gudang Baru :</label>
                        <input type="text" name="nama_gudang_baru" id="nama_gudang_baru" class="form-control">
                    </div>
                    <br>
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="reset" class="btn btn-danger">Cancel</button>
                </div>
            </div>
            </div>
        </div>
            </form>
            <br/>
        </div>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


<?= $this->include('template/footer'); ?>