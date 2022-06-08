<?php

namespace App\Models;

use CodeIgniter\Model;

class UkuranModel extends Model
{
    //nama tabel 
    protected $table = 'ukuran';

    //atribut yg digunakan menjadi primary key
    protected $primaryKey = 'ukuran_id';
}
