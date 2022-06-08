<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<main>
    <div class="container-fluid px-4">
        <!-- Judul Besar -->
        <h1 class="mt-4">DATA MAJALAH</h1>
        <ol class="breadcrumb mb-4">
            <!-- judul Bawahnya -->
            <li class="breadcrumb-item active">Pengelolaan Data Majalah</li>
        </ol>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                <?= $title; //nama halaman 
                ?>
            </div>
            <div class="card-body">
                <!-- Form Tambah Buku -->
                <form action="/majalah/edit/<?= $result['majalah_id'] ?>" enctype="multipart/form-data" method="POST">
                    <?= csrf_field() ?>
                    <input type="hidden" name="slug" value="<?= $result['slug']; ?>">
                    <?= csrf_field(); ?>
                    <div class="mb-3 row">
                        <label for="judul" class="col-sm-2 col-form-label">Judul</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control <?= $validation->hasError('judul') ? 'is-invalid' : '' ?>" id="judul" name="judul" value="<?= old('judul', $result['judul']) ?>">
                            <div id="validationonServer03Feedback" class="invalid-feedback">
                                <?= $validation->getError('judul'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="author" class="col-sm-2 col-form-label">Author</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control <?= $validation->hasError('penerbit') ? 'is-invalid' : '' ?>" id="penerbit" name="penerbit" value="<?= old('penerbit', $result['penerbit']); ?>">
                            <div id="validationonServer03Feedback" class="invalid-feedback">
                                <?= $validation->getError('penerbit'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="tahun" class="col-sm-2 col-form-label">Tahun Terbit</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control <?= $validation->hasError('tahun') ? 'is-invalid' : '' ?>" id="tahun" name="tahun" value="<?= old('penerbit', $result['tahun']); ?>">
                            <div id="validationonServer03Feedback" class="invalid-feedback">
                                <?= $validation->getError('tahun'); ?>
                            </div>
                        </div>
                        <label for="stok" class="col-sm-2 col-form-label">Stok</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control <?= $validation->hasError('stok') ? 'is-invalid' : '' ?>" id="stok" name="stok" value="<?= old('stok', $result['stok']); ?>">
                            <div id="validationonServer03Feedback" class="invalid-feedback">
                                <?= $validation->getError('stok'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="harga" class="col-sm-2 col-form-label">Harga</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control <?= $validation->hasError('harga') ? 'is-invalid' : '' ?>" id="harga" name="harga" value="<?= old('harga', $result['harga']); ?>">
                            <div id="validationonServer03Feedback" class="invalid-feedback">
                                <?= $validation->getError('harga'); ?>
                            </div>
                        </div>
                        <label for="diskon" class="col-sm-2 col-form-label">Diskon</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control <?= $validation->hasError('diskon') ? 'is-invalid' : '' ?>" id="diskon" name="diskon" value="<?= old('diskon', $result['diskon']) ?>">
                            <div id="validationonServer03Feedback" class="invalid-feedback">
                                <?= $validation->getError('diskon'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="sampul" class="col-sm-2 col-form-label">Sampul</label>
                        <div class="col-sm-5">
                            <input type="hidden" name="sampullama" value="<?= $result['cover'] ?>">
                            <input type="file" class="form-control <?= $validation->hasError('sampul') ? 'is-invalid' : '' ?>" id="sampul" onchange="previewImage()" name="sampul">
                            <div id="validationServer03Feedback" class="invalid-feedback"><?= $validation->getError('sampul') ?>
                            </div>
                            <div class="col-sm-6 mt-2">
                                <img src="/img/<?= $result['cover'] == "" ? "default.jpg" : $result['cover'] ?>" alt="" class="img-thumbnail img-preview">
                            </div>
                        </div>
                        <label for="id_kategori" class="col-sm-2 col-form-label">Kategori</label>
                        <div class="col-sm-3">
                            <select type="text" class="form-control" name="id_kategori" id="id_kategori">
                                <?php foreach ($category as $value) : ?>
                                    <option value="<?= $value['majalah_category_id'] ?>" <?= $value['majalah_category_id'] == $result['majalah_category_id'] ? 'selected' : '' ?>>
                                        <?= $value['name_category']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button class="btn btn-primary me-md-2" type="submit">Perbarui</button>
                        <button class="btn btn-danger" type="reset">Batal</button>
                    </div>
                </form>
                <!-- -->

            </div>
        </div>
    </div>
</main>

<?= $this->endSection() ?>