<?= $this->include('template/navigation_bar'); ?>


<title>Master Supplier</title>

<div class="container-fluid">

<!-- Page Heading -->
<div class="container-fluid">
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Master Data Supplier</h1>
    <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#exampleModal"><i
    class="fas fa-search fa-sm text-white-50"></i> Cari Data Supplier</a>
  </div>
  

   <!-- modal -->
   <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Cari Data Supplier</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="<?= base_url('/cari_data_po') ?>" method="post">
                        <div>
                            <label>Nama Pemasok: </label>
                            <input type="text" name="pemasok" id="pemasok" class="form-control">
                        </div>
                        <div>
                            <label>Nama Barang : </label>
                            <input type="text" name="nama_barang" id="nama_barang" class="form-control">
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                </form>
            </div>
        </div>
    </div>
        
    <div style="float: right">
    <?= $pager->links('master_supplier', 'bootstrap_pagination'); ?>
</div>


    <div>
    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Pemasok</th>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($master_supplier as $key => $value) : ?>
                <tr>
                <td><?php echo $value['id']; ?></td>
                <td><?php echo $value['kode_pemasok']; ?></td>
                <td><?php echo $value['pemasok']; ?></td>
                <td><?php echo $value['kode_barang']; ?></td>
                <td><?php echo $value['nama_barang']; ?></td>
            </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    


<?= $this->include('template/footer'); ?>