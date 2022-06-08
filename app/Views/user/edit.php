<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">DATA PRODUK</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Pengelolaan Data Produk</li>
        </ol>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                <?= $title ?>
            </div>
            <div class="card-body">
                <!-- form tambah buku -->
                <form action="/user/edit/<?= $result['firstname'] ?>" method="POST" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <input type="hidden" name="slug" value="<?= $result['slug']; ?>">

                    <div class="mb-3 row">
                        <label for="nama_produk" class="col-sm-2 col-form-label">Nama Depan</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control <?= $validation->hasError('firstname') ? 'is-invalid' : '' ?> " id="firstname" name="firstname" value="<?= old('firstname', $result['firstname']) ?>">
                            <div id="validationServer03Feedback" class="invalid-feedback">
                                <?= $validation->getError('firstname') ?>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="nama_produk" class="col-sm-2 col-form-label">Nama Belakang</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control <?= $validation->hasError('lastname') ? 'is-invalid' : '' ?> " id="lastname" name="lastname" value="<?= old('lastname', $result['lastname']) ?>">
                            <div id="validationServer03Feedback" class="invalid-feedback">
                                <?= $validation->getError('lastname') ?>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="price" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control <?= $validation->hasError('email') ? 'is-invalid' : '' ?>" id="email" name="email" value="<?= old('email') ?>">
                            <div id="validationServer03Feedback" class="invalid-feedback">
                                <?= $validation->getError('email') ?>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="price" class="col-sm-2 col-form-label">Username</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control <?= $validation->hasError('username') ? 'is-invalid' : '' ?>" id="username" name="username" value="<?= old('username') ?>">
                            <div id="validationServer03Feedback" class="invalid-feedback">
                                <?= $validation->getError('username') ?>
                            </div>
                        </div>
                    </div>

                    <div class=" mb-3 row">
                        <label for="ukuran_id" class="col-sm-2 col-form-label">Ukuran</label>
                        <div class="col-sm-3">
                            <select type="text" class="form-control" id="ukuran_id" name="ukuran_id">
                                <?php foreach ($category as $value) : ?>
                                    <option value="<?= $value['ukuran_id'] ?>" <?= $value['ukuran_id'] == $result['ukuran_id'] ? 'selected' : '' ?>>
                                        <?= $value['name_ukuran'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3 row">
                            <label for="cover" class="col-sm-2 col-form-label">Kover</label>
                            <div class="col-sm-5">
                                <input type="hidden" name="coverlama" value="<?= $result['cover'] ?>">
                                <input type="file" class="form-control <?= $validation->hasError('cover') ? 'is-invalid' : '' ?>" id="cover" name="cover" onchange="previewImage() ?>">
                                <div id="validationServer03Feedback" class="invalid-feedback">
                                    <?= $validation->getError('cover') ?>
                                </div>
                                <div class="col-sm-6 mt-2">
                                    <img src="/img/<?= $result['cover'] == "" ? "default.jpeg" : $result['cover'] ?>" alt="" class="img-thumbnail img-preview">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button class="btn btn-primary me-md-2 " type="submit">Perbarui</button>
                        <button class="btn btn-danger" type="reset">Batal</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</main>
<?= $this->endSection() ?>