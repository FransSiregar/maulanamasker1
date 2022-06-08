<?php

namespace App\Controllers;

use \app\Models\UserModel;

class Users extends BaseController
{
    private $userModel;
    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $dataUser = $this->userModel->findAll();
        $data = [
            'title' => 'Pengelolaan User',
            'result' => $dataUser
        ];

        return view('user/index', $data);
    }

    public function create()
    {;
        $data = [
            'title' => 'Tambah User'
        ];

        return view('user/create', $data);
    }

    public function save()
    {
        $id = url_title($this->request->getVar('id'), '-', true);
        $this->userModel->save([
            'id' => $id,
            'firstname' => $this->request->getVar('firstname'),
            'lastname' => $this->request->getVar('lastname'),
            'email' => $this->request->getVar('email'),
            'username' => $this->request->getVar('username'),
        ]);
        session()->setFlashdata("msg", "Data Berhasil ditambahkan!");
        return redirect()->to('/users');
    }

    public function delete($id)
    {
        $this->userModel->delete($id);
        session()->setFlashdata("msg", "Data berhasil dihapus!");
        return redirect()->to('/users');
    }



    public function edit($firstname)
    {
        $dataUser = $this->userModel->getUsers($firstname);
        //jika data bukunya kosong
        if (empty($dataUser)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Nama User tidak ditemukan");
        }

        $data = [
            'title' => 'Ubah User',
            'validation' => \Config\Services::validation(),
            'result' => $dataUser
        ];

        return view('user/edit', $data);
    }

    public function update($id)
    {

        if (!$this->validate([
            'firstname' => [
                'rules' => 'required|is_unique[users.firstname]',
                'errors' => [
                    'required' => '{field} harus diisi',
                    'is_unique' => '{field} data sudah ada'
                ]
            ],
            'lastname' => 'required',
            'email' => 'required',

        ])) {
            return redirect()->to('/users/edit/' . $this->request->getVar('id'))->withInput();
        }
        session()->setFlashdata("msg", "Data berhasil diubah!");

        return redirect()->to('/users');

        $this->userModel->save([
            'id' => $id,
            'firstname' => $this->request->getVar('firstname'),
            'lastname' => $this->request->getVar('lastname'),
            'email' => $this->request->getVar('email'),
            'username' => $this->request->getVar('username'),
        ]);

        session()->setFlashdata("msg", "Data berhasil diubah!");

        return redirect()->to('/users');
    }
}
