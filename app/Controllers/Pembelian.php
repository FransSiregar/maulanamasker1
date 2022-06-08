<?php

namespace App\Controllers;


use \App\Models\ProdukModel;
use \App\Models\SupplierModel;
use \App\Models\BuyModel;
use \App\Models\BuyDetailModel;
use TCPDF;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Pembelian extends BaseController
{
    private $produk, $cart, $sup, $buy, $buyDetail;
    public function __construct()
    {
        $this->produk = new ProdukModel();
        $this->sup = new SupplierModel();
        $this->buy = new BuyModel();
        $this->buyDetail = new BuyDetailModel();
        $this->cart = \Config\Services::cart();
    }
    public function index()
    {
        $dataProduk = $this->produk->getProduk();
        $dataSup = $this->sup->findAll();
        $data = [
            'title' => 'Pembelian',
            'dataProduk' => $dataProduk,
            'dataSup' => $dataSup,

        ];
        return view('pembelian/list', $data);
    }


    public function showCart()
    {
        //Untuk menampilkan cart
        $output = '';
        $no = 1;
        foreach ($this->cart->contents() as $items) {
            $diskon = ($items['options']['discount'] / 100) * $items['subtotal'];
            $output .= '
            <tr>
            <td>' . $no++ . '</td>
            <td>' . $items['name'] . '</td>
            <td>' . $items['qty'] . '</td>
            <td>' . number_to_currency($items['price'], 'IDR', 'id_ID') . '</td>
            
            <td>' . number_to_currency(($items['subtotal'] - $diskon), 'IDR', 'id_ID', 2) . '</td>
            <td>
            <button id="' . $items['rowid'] . '" qty="' . $items['qty'] . '"
            class="ubah_cart btn btn-warning btn-xs" title="Ubah Jumlah"><i class="fa 
            fa-edit"></i></button>

            <button type="button" id="' . $items['rowid'] . '"class="hapus_cart btn btn-danger btn-xs"><i class="fa fa-trash" title="Hapus"></i></button>
            </td>
            </tr>
            ';
        }

        if (!$this->cart->contents()) {
            $output = '<tr><td colspan="7" align="center"> tidak ada transaksi! </td></tr>';
        }
        return $output;
    }



    public function loadCart()
    {
        echo $this->showCart();
    }



    public function addCart()
    {
        $this->cart->insert(array(
            'id'         => $this->request->getVar('id'),
            'qty'        => $this->request->getVar('qty'),
            'price'      => $this->request->getVar('price'),
            'name'       => $this->request->getVar('name'),
            'options'    => array('discount' => $this->request->getVar('discount'))
        ));

        echo $this->showCart();
    }

    public function getTotal()
    {
        $totalBayar = 0;
        foreach ($this->cart->contents() as $items) {
            $diskon = ($items['options']['discount'] / 100) * $items['subtotal'];
            $totalBayar += $items['subtotal'] - $diskon;
        }
        echo number_to_currency($totalBayar, 'IDR', 'id_ID', 2);
    }

    public function updateCart()
    {
        $this->cart->update(array(
            'rowid'     => $this->request->getVar('rowid'),
            'qty'       => $this->request->getVar('qty')
        ));
        echo $this->showCart();
    }

    public function deleteCart($rowid)
    {
        $this->cart->remove($rowid);
        echo $this->showCart();
    }

    public function pembayaran()
    {
        // Mengecek ada transaksi yang dilakukan
        if (!$this->cart->contents()) {
            //Transaksi kosong
            $response =
                [
                    'status' => false,
                    'msg' => "Tidak ada transaksi! ",
                ];
            echo json_encode($response);
        } else {
            //Ada transaksi
            $totalBayar = 0;
            foreach ($this->cart->contents() as $items) {
                $diskon = ($items['options']['discount'] / 100) * $items['subtotal'];
                $totalBayar += $items['subtotal'] - $diskon;
            }

            $nominal = $this->request->getVar('nominal');
            $id = "B" . time();

            // Pengecekan nominal 
            if ($nominal < $totalBayar) {
                $response =
                    [
                        'status' => false,
                        'msg' => "Uang Tidak Mencukupi!",
                    ];
                echo json_encode($response);
            } else {
                //jika stock habis
                $produk = $this->produk->where(['produk_id' => $items['id']])->first(); //pemanggilan stock i guess
                if ($produk['stock'] <= 0) //logika stock jika stock habis
                {
                    $response =
                        [
                            'status' => false,
                            'msg' => "Stok Habis!",
                        ];
                    echo json_encode($response);
                } else {
                    // jika Nominal memenuhi akan menyimpan data di tabel buy dan buy_detail
                    $this->buy->save([
                        'pembelian_id' => $id,
                        'user_id' => user()->id,
                        'supplier_id' => $this->request->getVar('id-sup')

                    ]);

                    foreach ($this->cart->contents() as $items) {
                        $this->buyDetail->save([
                            'pembelian_id' => $id,
                            'produk_id' => $items['id'],
                            'amount'  => $items['qty'],
                            'price'   => $items['price'],
                            'discount' => $diskon,
                            'total_price' => $items['subtotal'] - $diskon,
                        ]);
                        //Mengurangi jumlah stock di tabel produk
                        // Get Produk berdasarkan ID Produk
                        $produk = $this->produk->where(['produk_id' => $items['id']])->first();
                        $this->produk->save([
                            'produk_id' => $items['id'],
                            'stock' => $produk['stock'] + $items['qty'],
                        ]);
                    }

                    $this->cart->destroy();
                    $kembalian = $nominal - $totalBayar;

                    $response =
                        [
                            'status' => true,
                            'msg' => "Payment Success",
                            'data' =>
                            [
                                'kembalian' => number_to_currency($kembalian, 'IDR', 'id_ID', 2)
                            ]
                        ];
                    echo json_encode($response);
                }
            }
        }
    }
    public function report()
    {
        $report = $this->buy->getReport();
        $data = [
            'title' => 'Laporan Pembelian',
            'result' => $report,
        ];
        return view('pembelian/report', $data);
    }
    public function exportPDF()
    {
        $report = $this->buy->getReport();
        $data = [
            'title' => 'Laporan Pembelian',
            'result' => $report,
        ];
        $html = view('pembelian/exportPDF', $data);

        $pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->AddPage();
        $pdf->writeHTML($html);
        $this->response->setContentType('application/pdf');
        $pdf->Output('laporan-pembelian.pdf', 'I');
    }

    public function exportExcel()
    {
        $report = $this->buy->getReport();

        $spreadsheet = new Spreadsheet();
        // tulis header/nama kolom
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'No')
            ->setCellValue('B1', 'Nota')
            ->setCellValue('C1', 'Tgl Transaksi')
            ->setCellValue('D1', 'User')
            ->setCellValue('E1', 'Supplier')
            ->setCellValue('F1', 'Total');

        // tulis data mobil ke cell
        $rows = 2;
        $no = 1;
        foreach ($report as $value) {
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $rows, $no++)
                ->setCellValue('B' . $rows, $value['pembelian_id'])
                ->setCellValue('C' . $rows, $value['tgl_transaksi'])
                ->setCellValue('D' . $rows, $value['firstname'] . ' ' . $value['lastname'])
                ->setCellValue('E' . $rows, $value['name_sup'])
                ->setCellValue('F' . $rows, $value['total']);
            $rows++;
        }
        // tulis dalam format .xlsx
        $writer = new Xlsx($spreadsheet);
        $fileName = 'Laporan-Pembelian';

        // Redirect hasil generate xlsx ke web client
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . $fileName . '.xlsx');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }
}
