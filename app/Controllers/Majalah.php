<?php

namespace App\Controllers;

use \App\Models\MajalahModel;
use \App\Models\MajalahCategoryModel;

class Majalah extends BaseController
{
	private $majalahModel, $catModel;
	public function __construct()
	{
		$this->majalahModel = new MajalahModel();
		$this->catModel = new MajalahCategoryModel();
	}

	public function index()
	{
		$dataMajalah = $this->majalahModel->getMajalah();
		$dataMajalah = $this->majalahModel->findAll();
		$data =
			[
				'title' => '',
				'result' => $dataMajalah
			];
		return view('majalah/index', $data);
	}

	public function detail($slug)
	{
		$dataMajalah = $this->majalahModel->getMajalah($slug);
		$data =
			[
				'title' => 'Detail Majalah',
				'result' => $dataMajalah
			];
		return view('majalah/detail', $data);
	}

	public function create()
	{
		session();
		$data =
			[
				'title' => 'Tambah Majalah',
				'category' => $this->catModel->findAll(),
				'validation' => \Config\Services::validation()
			];
		return view('majalah/create', $data);
	}

	public function save()
	{
		// print_r($_POST);die(); 
		//validasi input

		if (!$this->validate([
			'judul' => [
				'rules' => 'required|is_unique[majalah.judul]',
				'errors' => [
					'required' => '{field} harus diisi',
					'is_unique' => '{field} hanya sudah ada'
				]
			],
			'penerbit' => 'required',
			'tahun' => 'required|integer',
			'harga' => 'required|numeric',
			'diskon' => 'permit_empty|decimal',
			'stok' => 'required|integer',
			'sampul' =>
			[
				'rules' => 'max_size[sampul,1024]|is_image[sampul]|mime_in[sampul,image/jpg,image/jpeg,image/png]',
				'errors' =>
				[
					'max_size' => 'Gambar tidak boleh lebih dari 1MB!',
					'is_image' => 'Yang anda pilih bukan gambar!',
					'mime_in' => 'Yang anda pilih bukan gambar',
				]
			],
		])) {
			return redirect()->to('/majalah/create')->withInput();
		}

		//Mengambil File Sampul
		$fileSampul = $this->request->getFile('sampul');
		if ($fileSampul->getError() == 4) {
			$namaFile = $this->defaultImage;
		} else {
			//Generate Nama FIle
			$namaFile = $fileSampul->getRandomName();
			//Pindahkan file ke folder img di public
			$fileSampul->move('img', $namaFile);
		}


		$slug = url_title($this->request->getVar('judul'), '-', true);
		$this->majalahModel->save([
			'judul' => $this->request->getVar('judul'),
			'penerbit' => $this->request->getVar('penerbit'),
			'tahun' => $this->request->getVar('tahun'),
			'harga' => $this->request->getVar('harga'),
			'diskon' => $this->request->getVar('diskon'),
			'stok' => $this->request->getVar('stok'),
			'majalah_category_id' => $this->request->getVar('id_kategori'),
			'slug' => $slug,
			'cover' => $namaFile
		]);
		session()->setFlashdata("msg", "Data Berhasil ditambahkan!");
		return redirect()->to('/majalah');
	}

	public function edit($slug)
	{
		$dataMajalah = $this->majalahModel->getMajalah($slug);
		//jika bukunya kosong
		if (empty($dataMajalah)) {
			throw new \CodeIgniter\Exceptions\PageNotFoundException("Judul Buku $slug tidak ditemukan");
		}

		$data =
			[
				'title' => 'Ubah Buku',
				'category' => $this->catModel->findAll(),
				'validation' => \Config\Services::validation(),
				'result' => $dataMajalah
			];

		return view('majalah/edit', $data);
	}

	public function update($id)
	{
		// cek judul 
		// $dataOld = $this->majalahModel->getMajalah($this->request->getVar('slug'));
		// if ($dataOld['judul'] == $this->request->getVar('judul')) {
		// $rule_judul = 'required';
		// } else {
		// $rule_judul = 'required|is_unique[majalah.judul]';
		// }
		// dd($rule_judul);
		//Validasi Data
		if (!$this->validate([
			'judul' => [
				'rules' => 'required|is_unique[majalah.judul]',
				'errors' => [
					'required' => '{field} harus diisi',
					'is_unique' => '{field} hanya sudah ada'
				]
			],
			'penerbit' => 'required',
			'tahun' => 'required|integer',
			'harga' => 'required|numeric',
			'diskon' => 'permit_empty|decimal',
			'stok' => 'required|integer',
			'sampul' =>
			[
				'rules' => 'max_size[sampul,1024]|is_image[sampul]|mime_in[sampul,image/jpg,image/jpeg,image/png]',
				'errors' =>
				[
					'max_size' => 'Gambar tidak boleh lebih dari 1MB!',
					'is_image' => 'Yang anda pilih bukan gambar!',
					'mime_in' => 'Yang anda pilih bukan gambar',
				]
			],
		])) {
			return redirect()->to('/majalah/edit/' . $this->request->getVar('slug'))->withInput();
		}

		$namaFileLama = $this->request->getVar('sampullama');
		//Mengambil File Sampul
		$fileSampul = $this->request->getFile('sampul');
		//Cek Gambar, apakah masih gambar lama
		if ($fileSampul->getError() == 4) {
			$namaFile = $namaFileLama;
		} else {
			//Generate Nama File
			$namaFile = $fileSampul->getRandomName();
			//Pindahkan File Ke Folder img di Public
			$fileSampul->move('img', $namaFile);
		}


		//Membuat string menjadi huruf kecil semua dan spacinya diganti -
		$slug = url_title($this->request->getVar('judul'), '-', true);
		// dd($id);
		$this->majalahModel->save([
			'majalah_id' => $id,
			'judul' => $this->request->getVar('judul'),
			'penerbit' => $this->request->getVar('penerbit'),
			'tahun' => $this->request->getVar('tahun'),
			'harga' => $this->request->getVar('harga'),
			'diskon' => $this->request->getVar('diskon'),
			'stok' => $this->request->getVar('stok'),
			'majalah_category_id' => $this->request->getVar('id_kategori'),
			'slug' => $slug,
			'cover' => $namaFile
		]);

		session()->setFlashdata("msg", "Data berhasil diubah!");

		return redirect()->to('/majalah');
	}

	public function delete($id)
	{

		// $dataBook = $this->bookModel->find($id);
		$this->majalahModel->delete($id);
		session()->setFlashdata("msg", "Data berhasil dihapus!");
		return redirect()->to('/majalah');
	}
}
