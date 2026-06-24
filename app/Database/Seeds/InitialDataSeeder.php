<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;
use CodeIgniter\Shield\Entities\User;

class InitialDataSeeder extends Seeder
{
    public function run()
    {
        $this->seedUser();
        $now = Time::now('Asia/Jakarta', 'en_US')->toDateTimeString();

        $this->db->table('customers')->insert([
            'company_name'   => 'PT. SENTOSA',
            'address'        => 'Jl. Bypass Cirebon',
            'contact_person' => 'Robert',
            'created_at'     => $now,
            'updated_at'     => $now,
        ]);

        $customerId = $this->db->insertID();

        $products = [
            [
                'product_code' => 'PR01',
                'product_name' => 'Ban Luar',
                'unit'         => 'Pcs',
                'price'        => 2300000,
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
            [
                'product_code' => 'PR02',
                'product_name' => 'Baut Ukuran 18',
                'unit'         => 'Dus',
                'price'        => 110000,
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
            [
                'product_code' => 'PR03',
                'product_name' => 'Oli Mesin',
                'unit'         => 'Liter',
                'price'        => 125000,
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
        ];
        $this->db->table('products')->insertBatch($products);

        $this->db->table('transactions')->insert([
            'invoice_number' => '034/TD/XI/2024',
            'invoice_date'   => '2024-06-25',
            'customer_id'    => $customerId,
            'pic_name'       => 'Ilham',
            'grand_total'    => 25925000,
            'created_at'     => $now,
            'updated_at'     => $now,
        ]);

        $transactionId = $this->db->insertID();


        $transactionDetails = [
            [
                'transaction_id' => $transactionId,
                'product_id'     => 1, 
                'qty'            => 10,
                'price'          => 2300000,
                'subtotal'       => 23000000,
            ],
            [
                'transaction_id' => $transactionId,
                'product_id'     => 2, 
                'qty'            => 5,
                'price'          => 110000,
                'subtotal'       => 550000,
            ],
            [
                'transaction_id' => $transactionId,
                'product_id'     => 3, 
                'qty'            => 19,
                'price'          => 125000,
                'subtotal'       => 2375000,
            ],
        ];
        $this->db->table('transaction_details')->insertBatch($transactionDetails);
    }

    private function seedUser(){
        $users = auth()->getProvider();
        $user = new User([
            'username' => 'admin_super',
            'email'    => 'admin@domain.com',
            'password' => 'admin123',
        ]);
        $users->save($user);
        $user = $users->findById($users->getInsertID());

        if ($user) {
            $user->addGroup('superadmin');
        }
    }
}