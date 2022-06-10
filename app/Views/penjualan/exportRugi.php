<html>

<head>
    <!-- Berisi CSS -->
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
    <Main>
        <div class="title">
            <h1>LAPORAN LABA RUGI</h1>
        </div>
        <div>
            <!-- Isi Laporan -->
            <table class="border-table">
                <thead>
                    <tr>
                        <th width="20%">Harga Produk Jual</th>
                        <th width="40%">Harga Produk Beli</th>
                        <th width="40%">Total Laba Rugi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($result as $value) : ?>
                        <tr>

                            <td width="20%"><?= number_to_currency($value['total_sale'] / 2, 'IDR', 'id_ID') ?></td>
                            <td width="40%"><?= number_to_currency($value['total_buy'] / 2, 'IDR', 'id_ID') ?></td>
                            <td width="40%"><?= number_to_currency($value['total_sale'] - $value['total_buy'], 'IDR', 'id_ID', 1) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <!-- End Of Isi Laporan -->
        </div>
    </Main>
</body>

</html>