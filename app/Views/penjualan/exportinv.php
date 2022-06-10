<html>

<head>
    <!-- CSS -->
    <style>
        .title {
            text-align: center;
            font-family: Arial, Helvetica, sans-serif;
        }

        .left {
            text-align: left;
        }

        .right {
            text-align: right;
        }

        .border-table {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
            text-align: center;
            font-size: 12px;
        }

        .border-table th {
            border: 1px solid #000;
            background-color: #e1e3e9;
            font-weight: bold;
        }

        .border-table td {
            border: 1px solid #000;
        }
    </style>
</head>

<body>
    <main>
        <div class="title">
            <h1>Nota Penjualan</h1>
        </div>
        <div>
            <!-- Laporan Start -->
            <table class="border-table">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th width="15%">Nota</th>
                        <th width="15%">Tanggal Transaksi</th>
                        <th width="20%">Nama Produk</th>
                        <th width="10%">Jumlah Produk</th>
                        <th width="15%">Harga</th>
                        <th width="20%">Total Harga</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($result as $value) : ?>
                        <tr>
                            <td width="5%"><?= $no++ ?></td>
                            <td width="15%"><?= $value['sale_id'] ?></td>
                            <td width="15%"><?= date("d/m/y H:i:s", strtotime($value['created_at'])) ?></td>
                            <td width="20%" class="left"><?= $value['nama_produk'] ?></td>
                            <td width="10%"><?= $value['amount'] ?></td>
                            <td width="15%" class="right"><?= number_to_currency($value['price'], 'IDR', 'id_ID', 2) ?></td>
                            <td width="20%" class="right"><?= number_to_currency(($value['price'] * $value['amount']), 'IDR', 'id_ID', 2) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <!-- Laporan End -->
        </div>
    </main>
</body>

</html>