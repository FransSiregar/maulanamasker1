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
                        <div class="col">
                            <label class="col-form-label">User : </label>
                            <input type="text" value="<?= user()->username ?> " disabled>
                        </div>
                        <div class="col-auto">
                            <label class="col-form-label">Nomor Nota : </label>
                            <input type="text" id="nota" value="<?= "J" . time() ?> " disabled>
                        </div>
                        <div class="col-auto">
                            <label class="col-form-label">Customer : </label>
                            <input type="text" id="nama-cust" disabled>
                            <input type="hidden" id="id-cust" disabled>
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