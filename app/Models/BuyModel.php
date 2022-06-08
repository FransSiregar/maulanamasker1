<?php

namespace App\Models;

use CodeIgniter\Model;

class BuyModel extends Model
{

    protected $table = 'pembelian';

    protected $useTimestamps = true;

    protected $allowedFields = ['pembelian_id', 'user_id', 'supplier_id'];

    public function getReport()
    {
        // return $this->db->table('sale_detail as sd')
        // ->select('s.sale_id, s.created_at tgl_transaksi, us.id user_id, us.firstname, 
        // us.lastname, , us.username, c.customer_id, c.name_cust, c.no_customer,
        // SUM(sd.total_price) total')
        // ->join('sale s', 'sale_id')
        // ->join('users us', 'us.id = s.user_id')
        // ->join('customer c', 'customer_id', 'left')
        // ->groupBy('s.sale_id')
        // ->get()->getResultArray();

        return $this->db->query("SELECT s.pembelian_id, s.created_at tgl_transaksi, us.id 
        user_id, us.firstname, us.lastname, us.username, c.supplier_id, c.name name_sup, 
        c.supplier_id, SUM(sd.total_price) total FROM detail_pembelian sd
        JOIN pembelian s ON s.pembelian_id = sd.pembelian_id
        JOIN users us ON us.id = s.user_id
        LEFT JOIN supplier c ON c.supplier_id = s.supplier_id
        GROUP BY s.pembelian_id")->getResultArray();
    }
}
