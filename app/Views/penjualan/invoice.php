<html>
<head>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        td,
        th {
            border: 1px solid #000000;
            text-align: center;
        }
    </style>
</head>

<body>
    <div style="font-size:64px; color:'#dddddd' "><i>Invoice</i></div>
    <p>
        <i>Maulana Masker</i><br>
        Balige, Sumatera Utara<br>
    </p>
    <hr>
    <hr>
    <p></p>
    <p>
    <?php $no = 1;
                        foreach ($result as $value) : ?>
        Pembeli : <?= $customer->name ?><br>

        Tanggal : <?= date('Y-m-d', strtotime($transaksi->created_at)) ?>
    </p>
    <table cellpadding="6">
        <tr>
            <th><strong>Barang</strong></th>
            <th><strong>Harga Satuan</strong></th>
            <th><strong>Jumlah</strong></th>
            <th><strong>Total Harga</strong></th>
        </tr>
        <tr>
            
            <td><?= $barang->nama_produk ?></td>
            <td><?= "Rp " . number_format($barang->price, 2, ',', '.') ?></td>
            <td><?= $transaksi->amount ?></td>

            <td><?= "Rp " . number_format($transaksi->total_harga, 2, ',', '.') ?></td>
        </tr>
    </table>
</body>
</html>