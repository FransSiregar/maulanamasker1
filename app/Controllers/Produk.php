<?php

namespace App\Controllers;

use \App\Models\ProdukModel;
use \App\Models\UkuranModel;
use \App\Models\WarnaModel;

class Produk extends BaseController
{
    private $produkModel, $catModel, $warModel;
    public function __construct()
    {
        $this->produkModel = new ProdukModel();
        $this->catModel = new UkuranModel();
        $this->warModel = new WarnaModel();
    }

    public function index()
    {
        $dataProduk = $this->produkModel->getProduk();
        $data =
            [
                'title' => 'Data Produk',
                'result' => $dataProduk
            ];
        return view('produk/index', $data);
    }

    public function detail($slug)
    {
        $dataProduk = $this->produkModel->getProduk($slug);
        $data = [
            'title' => 'Data Produk',
            'result' => $dataProduk
        ];
        return view('produk/detail', $data);
    }

    public function create()
    {
        session();
        $data = [
            'title' => 'Tambah Produk',
            'category' => $this->catModel->findAll(),
            'warna' => $this->warModel->findAll(),
            'validation' => \config\Services::validation()
        ];
        return view('produk/create', $data);
    }
    public function save()
    {
        // validasi input
        if (!$this->validate([
            'nama_produk' => [
                'rules' => 'required|is_unique[produk.nama_produk]',
                'label' => 'title',
                'errors' => [
                    'required' => '{field} harus diisi',
                    'is_unique' =>  '{field} hanya sudah ada'
                ]
            ],
            'price' => 'required|numeric',
            'stock' => 'required|integer'

        ])) {
            return redirect()->to('/produk/create')->withInput();
        }
        //mengambil file cover
        $file_cover = $this->request->getFile('cover');
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
        $slug = url_title($this->request->getVar('nama_produk'), '-', true);
        $this->produkModel->save([
            'nama_produk' => $this->request->getVar('nama_produk'),
            'price' => $this->request->getVar('price'),
            'warna_id' => $this->request->getVar('warna_id'),
            'ukuran_id' => $this->request->getVar('ukuran_id'),
            'stock' => $this->request->getVar('stock'),
            'slug' => $slug,
            'cover' => $nama_file
        ]);
        session()->setFlashdata("msg", "Data berhasil ditambahkan");
        return redirect()->to('/produk');
    }

    public function edit($slug)
    {
        $dataProduk = $this->produkModel->getProduk($slug);
        //jika data bukunya kosong
        if (empty($dataProduk)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Judul Produk $slug tidak ditemukan");
        }

        $data = [
            'title' => 'Ubah Produk',
            'category' => $this->catModel->findAll(),
            'warna' => $this->warModel->findAll(),
            'validation' => \Config\Services::validation(),
            'result' => $dataProduk
        ];

        return view('produk/edit', $data);
    }

    public function update($id)
    {
        // // cek judul 
        $dataOld = $this->produkModel->getProduk($this->request->getVar('slug'));
        if ($dataOld['nama_produk'] == $this->request->getVar('nama_produk')) {
            $rule_title = 'required';
        } else {
            $rule_title = 'required|is_unique[produk.nama_produk]';
        }
        // dd($rule_judul);
        //Validasi Data
        if (!$this->validate([
            'nama_produk' => [
                'rules' => $rule_title,
                'errors' => [
                    'required' => '{field} harus diisi',
                    'is_unique' => '{field} hanya sudah ada'
                ]
            ],
            'price' => 'required|numeric',
            'cover' => [
                'rules' => 'max_size[cover,1024]|is_image[cover]|mime_in[cover,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'Gambar tidak boleh lebih dari dari 1MB',
                    'is_image' => 'Yang anda pilih bukan gambar',
                    'mime_in' => 'Yang anda pilih bukan gambar',
                ]
            ],

        ])) {
            return redirect()->to('/produk/edit/' . $this->request->getVar('slug'))->withInput();
        }

        $nama_file_lama = $this->request->getVar('coverlama');
        //mengambil file sampul
        $file_cover = $this->request->getFile('cover');
        // cek gambar apakah masih pake gambar lama 
        if ($file_cover->getError() == 4) {
            $nama_file = $nama_file_lama;
        } else {
            // generate nama file 
            $nama_file = $file_cover->getRandomName();
            // pindahkan file ke folder img di public
            $file_cover->move('img', $nama_file);

            // jika sampulnya default 
            if ($nama_file_lama != $this->defaultImage) {
                //hapus gambar
                unlink('img/' . $nama_file_lama);
            }
        }

        //Membuat string menjadi huruf kecil semua dan spacinya diganti -
        $slug = url_title($this->request->getVar('nama_produk'), '-', true);
        // dd($id);
        $this->produkModel->save([
            'produk_id' => $id,
            'nama_produk' => $this->request->getVar('nama_produk'),
            'price' => $this->request->getVar('price'),

            'warna_id' => $this->request->getVar('warna_id'),
            'ukuran_id' => $this->request->getVar('ukuran_id'),
            'slug' => $slug,
            'cover' => $nama_file
        ]);

        session()->setFlashdata("msg", "Data berhasil diubah!");

        return redirect()->to('/produk');
    }

    public function delete($id)
    {
        //cari gambar by id
        $dataProduk = $this->produkModel->find($id);
        $this->produkModel->delete($id);
        // jika sampulnya default
        if ($dataProduk['cover']   != $this->defaultImage) {
            // hapus gambar
            unlink('img/' . $dataProduk['cover']);
        }
        session()->setFlashdata("msg", "Data berhasil dihapus!");
        return redirect()->to('/produk');
    }
}
