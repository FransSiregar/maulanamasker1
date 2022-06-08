<?php

namespace App\Models;

use CodeIgniter\Model;

class MajalahCategoryModel extends Model
{
    //name table
    protected $table = 'majalah_category';

    //artribut yang diunakan jadi primary key
    protected $primaryKey = 'majalah_category_id';
}
