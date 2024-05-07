<?= $this->include('template/navigation_bar'); ?>

<title>Edit Data PO</title>


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

<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="/css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="icon" type="image/png" sizes="96x96" href="/favicon/favicon-32x32.png">

    <title>Edit Data PO</title>

    <div>
    <div class="card">
        <div class="card-header">
            <b>Edit Data PO</b>
        </div>
        <div class="card-body" style="height: 50rem;">
            <form action="<?= site_url('/edit_data_po'); ?>" method="POST" class="form-horizontal">
            <div class="row">
                <div class="column">
                    <input type="hidden" name="id" value="<?php echo $master_po['id']; ?>">
                    <div>
                        <label>Pemasok : </label>
                        <input type="text" name="pemasok" id="pemasok" class="form-control" value="<?php echo $master_po['pemasok'];?>" readonly>
                    </div>
                    <div>
                        <label>Nomor PO : </label>
                        <input type="text" name="nomor_po" id="nomor_po" class="form-control" value="<?php echo $master_po['nomor_po'] ?>" readonly>
                    </div>
                    <div>
                        <label>Nama Barang : </label>
                        <input type="text" name="nama_barang" id="nama_barang" class="form-control" value="<?php echo $master_po['nama_barang'] ?>" readonly>
                    </div>
                    <div>
                        <label>Kuantitas : </label>
                        <input type="text" name="kuantitas" id="kuantitas" class="form-control" value="<?php echo $master_po['kuantitas'];?>">
                    </div>
                    <br>
                <button type="submit" class="btn btn-primary">Submit</button>
                <button type="reset" class="btn btn-danger">Cancel</button>
            </div>
        </div>
            </form>
            <br/>
        </div>

        
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
  <!-- Bootstrap core JavaScript-->
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="/js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="/vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="/js/demo/chart-area-demo.js"></script>
    <script src="/js/demo/chart-pie-demo.js"></script>

        <?= $this->include('template/footer'); ?>