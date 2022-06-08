<div class="modal fade" id="modalSup" role="dialog" aria-hidden="true" aria-labelledby="exampleModalToogleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eaxmpleModalToggleLabel">DATA PRODUK</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <!-- Tabel buku -->
                <table id="datatablesSimple3">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="20%">Nama</th>
                            <th width="15">Email</th>
                            <th width="15%">Telp</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($dataSup as $value) : ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $value->name ?></td>
                                <td><?= $value->email ?></td>
                                <td><?= $value->phone ?></td>
                                <td>
                                    <button onclick="selectSupplier('<?= $value->supplier_id ?>','<?= $value->name ?>')" class="btn btn-success"><i class="fa fa-plus"></i> Pilih</button>
                                </td>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <!-- < <div class="col">
                    <button class="btn btn-primary" data-bs-target="#modalProduk" data-bs-toggle="modal">Pilih Buku</button>
                    <button class="btn btn-dark" data-bs-target="#modalCust" data-bs-toggle="modal">Cari Customer</button>
            </div> -->

                <!--  -->
            </div>
            <div class="modal-footer">`
                <button class="btn btn-primary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
    function selectSupplier(id, name) {
        $('#id-sup').val(id);
        $('#nama-sup').val(name);
        $('#modalSup').modal('hide');
    }
</script>