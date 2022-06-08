<?php

namespace App\Controllers;

use \App\Models\CustomerModel;
use \App\Entities\CustomerEntity;

class Customer extends BaseController
{
    private $customerModel;

    public function __construct()
    {
        $this->customerModel = new CustomerModel();
    }

    public function index()
    {
        $dataCustomer = $this->customerModel->findAll();
        $data = [
            'title' => 'Customer',
            'result' => $dataCustomer
        ];
        return view('customer/list', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Customer'
        ];
        return view('customer/create', $data);
    }

    public function save()
    {
        $customer = new CustomerEntity();
        $data = [
            $customer->nama = $this->request->getVar('name'),
            $customer->alamat = $this->request->getVar('address'),
            $customer->email = $this->request->getVar('email'),
            $customer->telp = $this->request->getVar('phone'),
        ];
        $customer->fill($data);

        $this->customerModel->save($customer);

        session()->setFlashdata("msg", "Data berhasil ditambahkan");

        return redirect()->to('/customer');
    }

    public function edit($id)
    {
        $dataCustomer = $this->customerModel
            ->where(['customer_id' => $id])->first();
        //jika data kosong
        if (empty($dataCustomer)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Customer dengan id $id tidak ditemukan");
        }

        $data = [
            'title' => 'Ubah Customer',
            'result' => $dataCustomer
        ];

        return view('Customer/edit', $data);
    }

    public function update($id)
    {
        $customer = new CustomerEntity();

        $data = [
            "customer_id" => $id,
            "name" => $this->request->getVar('name'),
            "address" => $this->request->getVar('address'),
            "email" => $this->request->getVar('email'),
            "phone" => $this->request->getVar('phone'),
        ];
        $customer->fill($data);

        $this->customerModel->save($customer);

        session()->setFlashdata("msg", "Data berhasil diperbarui");

        return redirect()->to('/customer');
    }

    public function delete($id)
    {
        $this->customerModel->delete($id);
        session()->setFlashdata("msg", "Data berhasil dihapus!");
        return redirect()->to('/customer');
    }
}
