<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Data Customer</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Data Customer</li>
        </ol>

        <!-- Start Flash Data -->

        <?php if (session()->getFlashdata('msg')) : ?>
            <div class="alert alert-success" role="alert">
                <?= session()->getFlashdata('msg') ?>
            </div>
        <?php endif ?>
        <!-- End Flash Data -->

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                <?= $title ?>
            </div>
            <div class="card-body">

                <a class="btn btn-success mb-3" type="button" href="/customer/create">Tambah Customer</a>
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>Email</th>
                            <th>Telp</th>
                            <th>Option</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($result as $value) : ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $value->name ?></td>
                                <td><?= $value->address ?></td>
                                <td><?= $value->email ?></td>
                                <td><?= $value->phone ?></td>
                                <td>
                                    <a class="btn btn-primary" href="/customer/edit/<?= $value->customer_id ?>" role="button">Ubah </a>

                                    <form action="/customer/<?= $value->customer_id ?>" method="post" class="d-inline">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" class="btn btn-danger" role="button" onclick="return confirm('Apakah anda yakin?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
<?= $this->endSection() ?>