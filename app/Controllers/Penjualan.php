<?php

namespace App\Controllers;


use \App\Models\ProdukModel;
use \App\Models\CustomerModel;
use \App\Models\SaleModel;
use \App\Models\SaleDetailModel;
use TCPDF;
use \App\config\Services;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Penjualan extends BaseController
{
    private $produk, $cart, $cust, $sale, $saleDetail;
    public function __construct()
    {
        $this->produk = new ProdukModel();
        $this->cust = new CustomerModel();
        $this->sale = new SaleModel();
        $this->saleDetail = new SaleDetailModel();
        $this->cart = \Config\Services::cart();
    }
    public function index()
    {
        $dataProduk = $this->produk->getProduk();
        $dataCust = $this->cust->findAll();

        $data = [
            'title' => 'Penjualan',
            'dataProduk' => $dataProduk,
            'dataCust' => $dataCust,
            // 'validation' => \config\Services::validation()

        ];
        return view('penjualan/list', $data);
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
            $id = $this->request->getVar('nota');
            // mengambil file cover
            $file_cover = $this->request->getFile('image');
            if (
                $file_cover->getError() == 4
            ) { // ARTINYA TIDAK ADA FILE YANG DI UPLOAD
                $nama_file = $this->defaultImage;
            } else {
                //generate nama file
                $nama_file = $file_cover->getRandomName();
                //pindahkan file ke folder public
                $file_cover->move(
                    'img',
                    $nama_file
                );
            }
            // Pengecekan nominal 
            // if ($nominal < $totalBayar) {
            //     $response =
            //         [
            //             'status' => false,
            //             'msg' => "Uang Tidak Mencukupi!",
            //         ];
            //     echo json_encode($response);
            // } else {
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
                // jika Nominal memenuhi akan menyimpan data di tabel sale dan sale_detail
                $this->sale->save([
                    'sale_id' => $id,
                    'user_id' => user()->id,
                    'customer_id' => $this->request->getVar('id-cust'),
                    'address' => $this->request->getvar('address'),
                    'phone' => $this->request->getVar('phone'),
                    'image' => $this->request->getvar('image')
                ]);

                foreach ($this->cart->contents() as $items) {
                    $this->saleDetail->save([
                        'sale_id' => $id,
                        'produk_id' => $items['id'],
                        'amount'  => $items['qty'],
                        'price'   => $items['price'],
                        'total_price' => $items['subtotal'],
                    ]);
                    //Mengurangi jumlah stock di tabel produk
                    // Get Produk berdasarkan ID Produk
                    $produk = $this->produk->where(['produk_id' => $items['id']])->first();
                    $this->produk->save([
                        'produk_id' => $items['id'],
                        'stock' => $produk['stock'] - $items['qty'],
                    ]);
                }

                $this->cart->destroy();
                $totalBayar;

                $response =
                    [
                        'status' => true,
                        'msg' => "Process Payment",
                    ];
                echo json_encode($response);
            }
            // }
        }
    }


    public function rugiTerus()
    {
        $rugi = $this->sale->getRugi();
        $data =
            [
                'title' => 'Laporan Laba Rugi',
                'result' => $rugi,
            ];
        $html = view('penjualan/exportRugi', $data);

        $pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->AddPage();
        $pdf->writeHTML($html);
        $this->response->setContentType('application/pdf');
        $pdf->Output('laporan-LabaRugi.pdf', 'I');
    }


    public function report()
    {
        $report = $this->sale->getReport();
        $data = [
            'title' => 'Laporan Penjualan',
            'result' => $report,
        ];
        return view('penjualan/report', $data);
    }

    // public function invoice()
    // {
    //     $sale_id = $this->request->uri->getSegment(3);

    //     $saleModel = new \App\Models\SaleModel();
    //     $penjualan = $saleModel->find($sale_id);

    //     $customerModel = new \App\Models\CustomerModel();
    //     $customer = $customerModel->find($penjualan->customer_id);

    //     $produkModel = new \App\Models\ProdukModel();
    //     $produk = $produkModel->find($penjualan->id_barang);

    //     $html = view('penjualan/invoice', [
    //         'penjualan' => $penjualan,
    //         'customer' => $customer,
    //         'produk' => $produk,
    //     ]);

    //     $pdf = new TCPDF('L', PDF_UNIT, 'A5', true, 'UTF-8', false);

    //     $pdf->SetCreator(PDF_CREATOR);
    //     $pdf->SetAuthor('WETAP');
    //     $pdf->SetTitle('Invoice');
    //     $pdf->SetSubject('Invoice');

    //     $pdf->setPrintHeader(false);
    //     $pdf->setPrintFooter(false);

    //     $pdf->addPage();

    //     // output the HTML content
    //     $pdf->writeHTML($html, true, false, true, false, '');
    //     //line ini penting
    //     //$this->response->setContentType('application/pdf');
    //     //Close and output PDF document
    //     $pdf->Output('laporan-penjualan.pdf', 'I');


    //     return redirect()->to(site_url('penjualan/list'));
    // }
    public function exportInvoice($invid)
    {
        $invoice = $this->sale->getInv($invid);
        $data = [
            'title' => 'Invoice Penjualan',
            'result' => $invoice,
        ];
        $html = view('penjualan/exportInv', $data);

        $pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->addPage();
        $pdf->writeHTML($html);
        $this->response->setContentType('application/pdf');
        $pdf->Output('invoice-penjualan.pdf', 'I');
    }

    public function exportPDF()
    {
        $report = $this->sale->getReport();
        $data = [
            'title' => 'Laporan Penjualan',
            'result' => $report,
        ];
        $html = view('penjualan/exportPDF', $data);

        $pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->AddPage();
        $pdf->writeHTML($html);
        $this->response->setContentType('application/pdf');
        $pdf->Output('laporan-penjualan.pdf', 'I');
    }

    public function exportExcel()
    {
        $report = $this->sale->getReport();

        $spreadsheet = new Spreadsheet();
        // tulis header/nama kolom
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'No')
            ->setCellValue('B1', 'Nota')
            ->setCellValue('C1', 'Tgl Transaksi')
            ->setCellValue('D1', 'User')
            ->setCellValue('E1', 'Customer')
            ->setCellValue('F1', 'Total');

        // tulis data mobil ke cell
        $rows = 2;
        $no = 1;
        foreach ($report as $value) {
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $rows, $no++)
                ->setCellValue('B' . $rows, $value['sale_id'])
                ->setCellValue('C' . $rows, $value['tgl_transaksi'])
                ->setCellValue('D' . $rows, $value['firstname'] . ' ' . $value['lastname'])
                ->setCellValue('E' . $rows, $value['name_cust'])
                ->setCellValue('F' . $rows, $value['total']);
            $rows++;
        }
        // tulis dalam format .xlsx
        $writer = new Xlsx($spreadsheet);
        $fileName = 'Laporan-Penjualan';

        // Redirect hasil generate xlsx ke web client
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . $fileName . '.xlsx');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    public function confirm()
    {
        $report = $this->sale->getReport();
        $data = [
            'title' => 'Laporan Penjualan',
            'result' => $report,
        ];
        return view('penjualan/confirm');
    }
}
