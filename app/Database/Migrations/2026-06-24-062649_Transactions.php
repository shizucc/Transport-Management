<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Transactions extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'             => ['type' => 'BIGINT', 'constraint' => 20, 'unsigned' => true, 'auto_increment' => true],
            'invoice_number' => ['type' => 'VARCHAR', 'constraint' => 50, 'unique' => true],
            'invoice_date'   => ['type' => 'DATE'],
            'customer_id'    => ['type' => 'BIGINT', 'constraint' => 20, 'unsigned' => true],
            'pic_name'       => ['type' => 'VARCHAR', 'constraint' => 100],
            'grand_total'    => ['type' => 'DECIMAL', 'constraint' => '15,2', 'default' => 0.00],
            'created_at'     => ['type' => 'DATETIME', 'null' => true],
            'updated_at'     => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'     => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('customer_id', 'customers', 'id', 'RESTRICT', 'RESTRICT');
        $this->forge->createTable('transactions');
    }

    public function down()
    {
        $this->forge->dropTable('transactions', true);
    }
}
