<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Transaksi</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Transaksi Pembelian</li>
        </ol>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                <?= $title ?>
            </div>
            <div class="card-body">
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <label class="col-form-label">Tanggal : </label>
                            <input type="text" value="<?= date('d/m/Y') ?> " disabled>
                        </div>
                        <div class="col-auto">
                            <label class="col-form-label">Nama Supplier : </label>
                            <input type="text" id="nama-sup" disabled>
                            <input type="hidden" id="id-sup" disabled>
                        </div>
                        <div class="col">
                            <label class="col-form-label">User : </label>
                            <input type="text" value="<?= user()->username ?> " disabled>
                        </div>

                        <div class="col">
                            <button class="btn btn-primary" data-bs-target="#modalProduk" data-bs-toggle="modal">Pilih Produk </button>
                            <button class="btn btn-primary" data-bs-target="#modalSup" data-bs-toggle="modal">Pilih Supplier </button>

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
                            <th>Option</th>
                        </tr>
                    </thead>
                    <tbody id="detail_cart">
                    </tbody>
                </table>

                <div class="container">
                    <div class="row">
                        <div class="col-8">
                            <label class="col-from-label">Total Pembayaran </label>
                            <h1><span id="spanTotal">0</span></h1>
                        </div>
                        <div class="col-4">
                            <div class="mb-3 row">
                                <label class="col-from-label">Nominal</label>
                                <div class="col-8">
                                    <input type="text" class="form-control" id="nominal" autocomplete="off">
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-from-label">Kembalian</label>
                                <div class="col-8">
                                    <input type="text" class="form-control" id="kembalian" disabled>
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
<?= $this->include('pembelian/modal-produk') ?>
<?= $this->include('pembelian/modal-supplier') ?>

<script>
    function load() {
        $('#detail_cart').load('/beli/load');
        $('#spanTotal').load('/beli/gettotal');
    }
    $(document).ready(function() {
        load();
    });
</script>
<?= $this->endSection() ?>