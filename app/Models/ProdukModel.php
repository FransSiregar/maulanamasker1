<?php

namespace App\Models;

use CodeIgniter\Model;

use function PHPUnit\Framework\returnSelf;

class ProdukModel extends Model
{
    // nama tabel 
    protected $table = 'produk';

    // atribut yang di pake jadi primarykey
    protected $primaryKey = 'produk_id';

    // atribut untk menyimpan created at dan updated at
    protected $useTimestamps = true;

    //tambahan di modul 6 hal 44
    protected $allowedFields = [
        'nama_produk', 'slug', 'price', 'stock', 'cover', 'ukuran_id', 'warna_id'
    ];


    public function getProduk($slug = false)
    {
        $query = $this->table('produk')
            ->join('ukuran', 'ukuran_id')->join('warna', 'warna_id')
            ->where('deleted_at is null');

        if ($slug == false)
            return $query->get()->getResultArray();
        return $query->where(['slug' => $slug])->first();
    }
    protected $useSoftDeletes = true;
}
