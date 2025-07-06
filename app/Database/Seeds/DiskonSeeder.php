<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DiskonSeeder extends Seeder
{
    public function run()
    {
        $data = [];
        $startDate = strtotime('2025-06-25');
        $createdAt = '2025-06-25 06:01:35';

        for ($i = 0; $i < 10; $i++) {
            $tanggal = date('Y-m-d', strtotime("+$i days", $startDate));
            $data[] = [
                'tanggal'    => $tanggal,
                'nominal'    => 100000,
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ];
        }

        $this->db->table('diskon')->insertBatch($data);
    }
}
