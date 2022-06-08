<?php

namespace App\Models;

use CodeIgniter\Model;

class CustomerModel extends Model
{
    // nama tabel
    protected $table = 'customer';
    // atribut primary key
    protected $primaryKey = 'customer_id';
    //atribut yang nympan created at dan update at 
    protected $useTimestamps = true;
    protected $allowedFields = ['name', 'address', 'email', 'phone'];
    protected $returnType = 'App\Entities\CustomerEntity';
    protected $useSoftDeletes = true;
}
