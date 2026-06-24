<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TransactionDetails extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'             => ['type' => 'BIGINT', 'constraint' => 20, 'unsigned' => true, 'auto_increment' => true],
            'transaction_id' => ['type' => 'BIGINT', 'constraint' => 20, 'unsigned' => true],
            'product_id'     => ['type' => 'BIGINT', 'constraint' => 20, 'unsigned' => true],
            'qty'            => ['type' => 'INT', 'constraint' => 11],
            'price'          => ['type' => 'DECIMAL', 'constraint' => '15,2'],
            'subtotal'       => ['type' => 'DECIMAL', 'constraint' => '15,2'],
            'created_at'     => ['type' => 'DATETIME', 'null' => true],
            'updated_at'     => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'     => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('transaction_id', 'transactions', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('product_id', 'products', 'id', 'RESTRICT', 'RESTRICT');
        $this->forge->createTable('transaction_details');
    }

    public function down()
    {
        $this->forge->dropTable('transaction_details', true);
    }
}
