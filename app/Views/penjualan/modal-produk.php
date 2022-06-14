<div class="modal fade" id="modalProduk" role="dialog" aria-hidden="true" aria-labelledby="exampleModalToogleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eaxmpleModalToggleLabel">DATA PRODUK</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <!-- Tabel buku -->
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="10%">Gambar</th>
                            <th width="30%">Nama Masker</th>
                            <th width="15">Ukuran</th>
                            <th width="15%">Harga</th>
                            <th width="10%">Stok</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($dataProduk as $value) : ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td>
                                    <img src="img/<?= $value['cover']; ?>" alt="" width="100">
                                <td><?= $value['nama_produk']; ?></td>
                                <td><?= $value['name_ukuran']; ?></td>
                                <td><?= $value['price']; ?></td>
                                <td><?= $value['stock']; ?></td>
                                <td>
                                    <button onclick="add_cart('<?= $value['produk_id'] ?>', '<?= $value['nama_produk'] ?>', '<?= $value['price'] ?>', )" class="btn btn-success"><i class="fa fa-cart-plus"></i> Tambahkan</button>
                                </td>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <!-- <div class="col">
                    <button class="btn btn-primary" data-bs-target="#modalProduk" data-bs-toggle="modal">Pilih Buku</button>
                    <button class="btn btn-dark" data-bs-target="#modalCust" data-bs-toggle="modal">Cari Customer</button>
                </div> -->
                <!--  -->
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalUbah" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalToggleLabel">UBAH JUMLAH PRODUK</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mt-3">
                    <div class="col-sm-7">
                        <input type="hidden" id="rowid">
                        <input type="number" id="qty" class="form-control" placeholder="Masukkan jumlah Produk" min="1" value="1">
                    </div>
                    <div class="col-sm-5">
                        <button class="btn btn-primary" onclick="update_cart()">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function add_cart(id, name, price, discount) {
        $.ajax({
            url: "/jual",
            method: "POST",
            data: {
                id: id,
                name: name,
                qty: 1,
                price: price,
                discount: discount,
            },
            success: function(data) {
                load()
            }
        });
    }

    function update_cart() {
        var rowid = $('#rowid').val();
        var qty = $('#qty').val();

        $.ajax({
            url: "/jual/update",
            method: "POST",
            data: {
                rowid: rowid,
                qty: qty,
            },
            success: function(data) {
                load();
                $('#modalUbah').modal('hide');
            }
        });
    }
</script>

<script>
    function load() {

        $('#detail_cart').load('/jual/load');
        $('#spanTotal').load('/jual/gettotal');
    }

    $(document).ready(function() {
        load();
    });

    $(document).on('click', '.ubah_cart', function() {
        var row_id = $(this).attr("id");
        var qty = $(this).attr("qty");
        $('#rowid').val(row_id);
        $('#qty').val(qty);
        $('#modalUbah').modal('show');
    });

    $(document).on('click', '.hapus_cart', function() {
        var row_id = $(this).attr("id");
        $.ajax({
            url: "jual/" + row_id,
            method: "DELETE",
            success: function(data) {
                load();
            }
        });
    });

    function bayar() {
        var nominal = $('#nominal').val();
        var idcust = $('#id-cust').val();
        var nota = $('#nota').val();
        var address = $('#address').val();
        var phone = $('#phone').val();
        $.ajax({
            url: "/jual/bayar",
            method: "POST",
            data: {
                'nominal': nominal,
                'id-cust': idcust,
                'nota': nota,
                'address': address,
                'phone': phone,



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