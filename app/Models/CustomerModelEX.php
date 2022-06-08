<?php

namespace App\Models;

use CodeIgniter\Model;

class CustomerModel extends Model
{
    // nama tabel 
    protected $table = 'customer';
    // atribut yang di pake jadi primarykey
    protected $primaryKey = 'customer_id';
    // atribut untk menyimpan created at dan updated at
    protected $useTimestamps = true;
    //tambahan di modul 6 hal 44
    protected $allowedFields = [
        'name', 'no_customer', 'gender', 'address', 'email', 'phone'
    ];

    public function getCustomer($no_customer = false)
    {
        $query = $this->table('customer');

        return $query->get()->getResultArray();
        return $query->WHERE(['no_customer' => $no_customer])->first();
    }
}
