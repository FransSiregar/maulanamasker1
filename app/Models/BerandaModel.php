<?php

namespace App\Models;

use CodeIgniter\Model;

class BerandaModel extends Model
{
    public function reportTransaksi($tahun)
    {
        return $this->db->table('sale_detail as sd')
            ->select('MONTH(s.created_at) month, SUM(sd.total_price) total')
            ->join('sale s', 'sale_id')
            ->where('YEAR(s.created_at)', $tahun)
            ->orderBy('MONTH(s.created_at)')
            ->get()->getResultArray();
    }

    public function reportPembelian($tahun)
    {
        return $this->db->table('detail_pembelian as se')
            ->select('MONTH(e.created_at) month, SUM(se.total_price) total')
            ->join('pembelian e', 'pembelian_id')
            ->where('YEAR(e.created_at)', $tahun)
            ->orderBy('MONTH(e.created_at)')
            ->get()->getResultArray();
    }

    public function reportCustomer($tahun)
    {
        return $this->db->table('customer')
            ->select('MONTH(created_at) month, COUNT(*) total')
            ->where('YEAR(created_at)', $tahun)
            ->groupBy('MONTH(created_at)')
            ->orderBy('MONTH(created_at)')
            ->get()->getResultArray();
    }

    public function reportSupplier($tahun)
    {
        return $this->db->table('supplier')
            ->select('MONTH(created_at) month, COUNT(*) total')
            ->where('YEAR(created_at)', $tahun)
            ->groupBy('MONTH(created_at)')
            ->orderBy('MONTH(created_at)')
            ->get()->getResultArray();
    }
}
