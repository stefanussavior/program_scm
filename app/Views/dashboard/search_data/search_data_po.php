<?= $this->include('template/navigation_bar'); ?>

<title>Master Data PO</title>

<div class="container-fluid">

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Hasil Data</h1>
    <a href="/dashboard" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
            class="fas fa-sign-out-alt fa-sm text-white-50"></i> Kembali </a>
</div>
</div>



<?php if (!empty($result)) : ?> 
<table class="table table-bordered table-striped">
    <thead class="thead-dark">
        <tr>
            <th>No</th>
            <th>Supplier</th>
            <th>Nomor PO</th>
            <th>Tanggal PO</th>
            <th>Estimasi Kirim</th>
            <th>Nama Barang</th>
            <th>Kuantitas</th>
            <th>Kuantitas Terproses</th>
            <th>Kuantitas Belum Terproses</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        foreach ($results as $result) : ?>
            <tr>
                <td><?php echo $value['po_id']; ?></td>
                <td><?php echo $value['tanggal_po']; ?></td>
                <td><?php echo $value['pemasok']; ?></td>
                <td><?php echo $value['nomor_po']; ?></td>
                <td><?php echo $value['tanggal_pengiriman']; ?></td>
                <td><?php echo $value['nama_barang']; ?> </td>
                <td><?php echo $value['kuantitas']; ?></td>
                <td><?php echo $value['kts_terproses']; ?></td>
                <td><?php echo $value['kts_belum_terp']; ?></td>
            </tr>
            <?php endforeach ?>
    </tbody>
</table>
    <div style="float: right">
<?= $pager->links('master_po', 'bootstrap_pagination'); ?>
</div>
</div>

<?php else: ?>
    <h1>Data yang di cari tidak ditemukan</h1>
<?php endif; ?>

<?= $this->include('template/footer'); ?>