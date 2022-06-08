<?php

namespace App\Controllers;

class Tugas extends BaseController
{
    // ada di ubah
    public function index()
    {
        $data = [
            'title' => 'Tugas'
        ]; //tambahan di modul 6 dam disini juga tempat ganti nama dan cari 'title'
        return view('TugasMinggu3', $data);
    }
    // sampai sini

}
