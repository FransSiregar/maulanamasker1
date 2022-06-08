<?php

namespace App\Models;

use CodeIgniter\Database\Query;
use CodeIgniter\Model;

class MajalahModel extends Model
{

    protected $table = 'majalah';


    protected $primaryKey = 'majalah_id';


    protected $useTimestamps = true;


    protected $allowedFields = [
        'judul', 'slug', 'penerbit', 'tahun', 'harga', 'diskon',
        'stok', 'cover', 'majalah_category_id'
    ];

    public function getMajalah($slug = false)
    {
        $query = $this->table('majalah')
            ->JOIN('majalah_category', 'majalah_category_id');
        if ($slug == false)
            return $query->get()->getResultArray();
        return $query->WHERE(['slug' => $slug])->first();
    }
}
