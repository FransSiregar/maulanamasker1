<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class SupplierEntity extends Entity
{
    protected $datamap = [
        "nama" => 'name',
        "alamat" => 'address',
        "email" => 'email',
        "telp" => 'phone',
    ];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [];
}
