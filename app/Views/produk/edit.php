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
                <form action="/produk/edit/<?= $result['produk_id'] ?>" method="POST" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <input type="hidden" name="slug" value="<?= $result['slug']; ?>">

                    <div class="mb-3 row">
                        <label for="nama_produk" class="col-sm-2 col-form-label">Nama Produk</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control <?= $validation->hasError('nama_produk') ? 'is-invalid' : '' ?> " id="nama_produk" name="nama_produk" value="<?= old('nama_produk', $result['nama_produk']) ?>">
                            <div id="validationServer03Feedback" class="invalid-feedback">
                                <?= $validation->getError('nama_produk') ?>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="price" class="col-sm-2 col-form-label">Harga</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control <?= $validation->hasError('price') ? 'is-invalid' : '' ?>" id="price" name="price" value="<?= old('price', $result['price']) ?>">
                            <div id="validationServer03Feedback" class="invalid-feedback">
                                <?= $validation->getError('price') ?>
                            </div>
                        </div>
                    </div>
                    <div class=" mb-3 row">
                        <label for="warna_id" class="col-sm-2 col-form-label">warna</label>
                        <div class="col-sm-3">
                            <select type="text" class="form-control" id="warna_id" name="warna_id">
                                <?php foreach ($warna as $value) : ?>
                                    <option value="<?= $value['warna_id'] ?>" <?= $value['warna_id'] == $result['warna_id'] ? 'selected' : '' ?>>
                                        <?= $value['name_warna'] ?></option>
                                <?php endforeach; ?>
                            </select>
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
                    </div>

                </form>
            </div>
        </div>
    </div>
</main>
<?= $this->endSection() ?>