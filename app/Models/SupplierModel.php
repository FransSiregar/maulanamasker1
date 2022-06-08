<?php

namespace App\Models;

use CodeIgniter\Model;

class SupplierModel extends Model
{
    // nama tabel
    protected $table = 'supplier';
    // atribut primary key
    protected $primaryKey = 'supplier_id';
    //atribut yang nympan created at dan update at 
    protected $useTimestamps = true;
    protected $allowedFields = ['name', 'address', 'email', 'phone'];
    protected $returnType = 'App\Entities\CustomerEntity';
    protected $useSoftDeletes = true;
}
