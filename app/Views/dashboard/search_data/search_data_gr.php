<?= $this->include('template/navigation_bar'); ?>

<title>Master Data GR</title>

<div class="container-fluid">
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Master Data Good Receive</h1>
    <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#exampleModal"><i
    class="fas fa-search fa-sm text-white-50"></i> Cari Data GR</a>
  </div>
  
  <!-- modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Cari Data Master GR</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="/cari_data_gr" method="post">
            <div>
              <label>Tanggal Awal : </label>
              <input type="date" name="tanggal_awal" id="tanggal_awal" class="form-control">
            </div>
            <div>
              <label>Tanggal Akhir : </label>
              <input type="date" name="tanggal_akhir" id="tanggal_akhir" class="form-control">
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
      <?= $pager->links('master_gr', 'bootstrap_pagination'); ?>
    </div>
  
  <table class="table table-striped">
    <thead class="thead-dark">
      <tr>
        <th>No</th>
        <th>Nomor GR</th>
        <th>Nama Barang</th>
        <th>Tanggal GR</th>
        <th>Estimasi Kirim</th>
        <th>Qty PO</th>
        <th>Qty Datang</th>
        <th>Satuan Berat</th>
        <th>Kode Batch</th>
        <th>Kode PRD </th>
        <th>Expired Date</th>
        <th>Status GR</th>
          <!-- <th>Action</th> -->
        </tr>
    </thead>
    <tbody>
        <?php 
        foreach ($master_gr as $key => $value) : ?>
            <tr>
                <td><?php echo $value['id']; ?></td>
                <td><?php echo $value['nomor_gr']; ?></td>
                <td><?php echo $value['nama_barang']; ?></td>
                <td><?php echo $value['tanggal_gr']; ?></td>
                <td><?php echo $value['est_kirim']; ?></td>
                <td><?php echo $value['qty_po']; ?></td>
                <td><?php echo $value['qty_dtg']; ?></td>
                <td><?php echo $value['satuan_berat']; ?></td>
                <td><?php echo $value['kode_batch']; ?></td>
                <td><?php echo $value['kode_prd']; ?></td>
                <td><?php echo $value['exp_date']; ?></td>
                <td><?php echo $value['status_gr'] ?></td>
                <!-- <td><a href="<?php echo base_url('/report_gr/'.$value['id']); ?>">Cetak Data</td> -->
            </tr>
            <?php endforeach ?>
    </tbody>
</table>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<?= $this->include('template/footer'); ?>