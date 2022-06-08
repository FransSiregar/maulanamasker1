<?php

namespace App\Models;

use CodeIgniter\Model;

class WarnaModel extends Model
{
    //nama tabel 
    protected $table = 'warna';

    //atribut yg digunakan menjadi primary key
    protected $primaryKey = 'warna_id';
}
