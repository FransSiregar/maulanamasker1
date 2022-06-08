<?php

namespace App\Models;

use CodeIgniter\Model;

class BuyDetailModel extends Model
{

    protected $table = 'detail_pembelian';


    protected $allowedFields = [
        'pembelian_id', 'produk_id', 'amount',
        'price', 'discount', 'total_price'
    ];
}
