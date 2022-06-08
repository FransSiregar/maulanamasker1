    <?= $this->extend('layout/template') ?>
    <?= $this->section('content') ?>

    <main>
        <div class="container-fluid px-4">
            <!-- Judul Besar -->
            <h1 class="mt-4">Data Customer</h1>
            <ol class="breadcrumb mb-4">
                <!-- judul Bawahnya -->
                <li class="breadcrumb-item active">Pengelolaan Data Customer</li>
            </ol>

            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    <title> <?= $title; //nama halaman
                            ?> </title>
                </div>

                <div class="card-body">
                    <!-- Isi Detail -->
                    <div class="card mb-3">
                        <div class="row g-0">

                            <div class="col-md-8">

                                <p class="card-text">Nama : <?= $result['name'] ?></p>
                                <p class="card-text">Nomor : <?= $result['no_customer'] ?></p>
                                <p class="card-text">Jenis Kelamin : <?= $result['gender'] ?></p>
                                <p class="card-text">Alamat : <?= $result['address'] ?></p>
                                <p class="card-text">Email : <?= $result['email'] ?></p>
                                <p class="card-text">Phone : <?= $result['phone'] ?></p>


                                <div class="d-grid gap-2 d-md-block">
                                    <a class="btn btn-dark" type="button" href="/customer">Kembali</a>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- End Isi Detail -->
                </div>
            </div>
        </div>
    </main>

    <?= $this->endSection() ?>