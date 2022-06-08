<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">DATA SUPPLIER</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Pengelolaan Data Suplier</li>
        </ol>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                <?= $title ?>
            </div>
            <div class="card-body">
                <!-- tambah data -->
                <form action="/supplier/create" method="POST" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <div class="mb-3 row">
                        <label for="name" class="col-sm-2 col-form-lable">Nama</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="name">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="address" class="col-sm-2 col-form-lable">Alamat</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="address">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="email" class="col-sm-2 col-form-lable">Email</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="email">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="phone" class="col-sm-2 col-form-lable">Telepon</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="phone">
                        </div>
                    </div>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button class="btn btn-primary me-md-2 " type="submit">Simpan</button>
                        <button class="btn btn-danger" type="reset">Batal</button>
                    </div>
                </form>

                </table>
            </div>
        </div>
    </div>
</main>
<?= $this->endSection() ?>