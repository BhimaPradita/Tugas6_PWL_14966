<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProductCategorySeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name'        => 'Elektronik',
                'description' => 'Barang-barang elektronik seperti TV, HP, Laptop.',
            ],
            [
                'name'        => 'Pakaian',
                'description' => 'Semua jenis pakaian pria dan wanita.',
            ],
            [
                'name'        => 'Makanan',
                'description' => 'Produk makanan kemasan dan segar.',
            ],
        ];

        // Simple Queries
        $this->db->table('product_category')->insertBatch($data);
    }
}
