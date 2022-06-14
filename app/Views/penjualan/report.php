<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">LAPORAN PENJUALAN</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Laporan Penjualan</li>
        </ol>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                <?= $title ?>
            </div>
            <div class="card-body">
                <!-- Isi Report -->
                <a target="_blank" class="btn btn-primary mb-3" type="button" href="/jual/exportpdf">Export PDF</a>
                <a class="btn btn-dark mb-3" type="button" href="/jual/exportexcel">Export Excel</a>
                <a class="btn btn-success mb-3" type="button" href="/jual/labarugi">Laba dan Rugi</a>
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nota</th>
                            <th>Tanggal Transaksi</th>
                            <th>User</th>
                            <th>Customer</th>
                            <th>Alamat</th>
                            <th>Telepon</th>
                            <th>Total</th>
                            <th>Aksi</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($result as $value) : ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $value['sale_id'] ?></td>
                                <td><?= date("d/m/Y H:i:s", strtotime($value['tgl_transaksi'])) ?></td>
                                <td><?= $value['firstname'] ?> <?= $value['lastname'] ?></td>
                                <td><?= $value['name_cust'] ?></td>
                                <td><?= $value['address'] ?></td>
                                <td><?= $value['phone'] ?></td>
                                <td><?= number_to_currency(
                                        $value['total'],
                                        'IDR',
                                        'id_ID',
                                        2
                                    ) ?>

                                </td>
                                <td><a target="_blank" class="btn btn-danger" href="/jual/exportinv/<?= $value['sale_id'] ?>" role="button">Cetak</a></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <!-- -->
            </div>
        </div>
    </div>
</main>
<?= $this->endSection() ?>