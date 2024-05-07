<?= $this->include('template/navigation_bar'); ?>

<title>Master Barang</title>

<div class="container-fluid">
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Hasil Pencarian Master Data Barang</h1>
    <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#exampleModal"><i
    class="fas fa-search fa-sm text-white-50"></i> Cari Data Barang</a> -->
  </div>
  

    <div style="float: right">
    <?php if (isset($pager)) : ?>
        <?= $pager->links() ?>
    <?php endif; ?>

    </div>
  
  <table class="table table-striped">
    <thead class="thead-dark">
      <tr>
        <th>No</th>
        <th>Produk ID</th>
        <th>Kode Produk</th>
        <th>Nama Produk</th>
        <th>Produk UOM 1</th>
        <th>Produk UOM 2</th>
        </tr>
    </thead>
    <tbody>
        <?php if (isset($master_barang)) : ?>
        <?php foreach ($master_barang as $item) : ?>
            <tr>
                <td><?php echo $item['id']; ?></td>
                <td><?php echo $item['prod_id']; ?></td>
                <td><?php echo $item['prod_code']; ?></td>
                <td><?php echo $item['prod_name']; ?></td>
                <td><?php echo $item['prod_uom1']; ?></td>
                <td><?php echo $item['prod_uom2']; ?></td>
            </tr>
            <?php endforeach; ?>
            <?php endif; ?>
    </tbody>
</table>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<?= $this->include('template/footer') ?>