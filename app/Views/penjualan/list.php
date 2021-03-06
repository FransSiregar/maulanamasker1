<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Transaksi</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Transaksi Penjualan</li>
        </ol>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                <?= $title ?>
            </div>
            <div class="card-body">
                <div class="container">
                    <div class="row">
                        <div class="col-md-3 ms-md-4">
                            <label class="col-form-label">Tanggal : </label>
                            <input type="text" value="<?= date('d/m/Y') ?> " disabled>
                        </div>
                        <div class="col-auto">
                            <label class="col-form-label">User : </label>
                            <input type="text" value="<?= user()->username ?> " disabled>
                        </div>
                        <div class="col-auto">
                            <label class="col-form-label">Nomor Nota : </label>
                            <input type="text" id="nota" value="<?= "J" . time() ?> " disabled>
                        </div>
                        <div class="col-auto">
                            <label class="col-form-label">Customer : </label>
                            <input type="text" id="nama-cust" value="" disabled>
                            <input type="hidden" id="id-cust" disabled>
                        </div>
                        <br>
                        <br>
                        <br>
                        <div class="col-auto">
                            <label class="col-form-label">Alamat Lengkap : </label>
                            <input name="address" id="address" required>
                        </div>
                        <div class="col-auto">
                            <label class="col-form-label">Telepon : </label>
                            <input name="phone" id="phone" required>
                        </div>
                        <br>
                        <br>
                        <div class="col-md-2 ms-md-auto">
                            <div>
                                <button class="btn btn-success" data-bs-target="#modalProduk" data-bs-toggle="modal">Pilih Produk </button>
                            </div>
                            <br>
                            <?php if (has_permission('admin')) : ?>
                                <div>
                                    <button class="btn btn-primary" data-bs-target="#modalCust" data-bs-toggle="modal">Pilih Customer </button>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <table class="table table-striped table-hover mt-4">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Produk</th>
                            <th>Jumlah</th>
                            <th>Harga Satuan</th>
                            <th>Subtotal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="detail_cart">
                    </tbody>
                </table>

                <div class="container">
                    <div class="row">
                        <div class="col-8">
                            <label class="col-from-label">Total Bayar </label>
                            <h1><span id="spanTotal">0</span></h1>
                        </div>
                        <div class="col-4">
                            <label for="cover" class="col-sm-2 col-form-label">Bukti Transaksi</label>
                            <div class="col-sm-12">
                                <input type="file" class="form-control" id="image" name="image" onchange="previewBukti()">
                                <div id="validationServer03Feedback" class="invalid-feedback">
                                </div>
                                <div class="col-sm-6 mt-2">
                                    <img src="/img/default.jpeg" alt="" class="img-thumbnail img-preview">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-from-label" hidden>Nominal</label>
                                <div class="col-8">
                                    <input type="text" class="form-control" id="nominal" autocomplete="off" hidden>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-from-label" hidden>Kembalian</label>
                                <div class="col-8">
                                    <input type="text" class="form-control" id="kembalian" disabled hidden>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-grid gap-3 d-md-flex justify-content-md-end">
                        <button onclick="bayar()" class="btn btn-success me-md-2" type="button">Proses Bayar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?= $this->include('penjualan/modal-produk') ?>
<?= $this->include('penjualan/modal-customer') ?>

<script>
    function load() {
        $('#detail_cart').load('/jual/load');
        $('#spanTotal').load('/jual/gettotal');
    }
    $(document).ready(function() {
        load();
    });

    function cetak() {
        var nominal = $('#nominal').val();
        var idcust = $('#id-cust').val();
        $.ajax({
            url: "/jual/bayar",
            method: "POST",
            data: {
                'nominal': nominal,
                'id-cust': idcust,


            },
            success: function(response) {
                var result = JSON.parse(response);
                swal({
                    title: result.msg,
                    icon: result.status ? "success" : "error",
                });
                load();
                $('#nominal').val("");
                $('#kembalian').val(result.data.kembalian);
            }
        });
    }
</script>
<?= $this->endSection() ?>