<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Products extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'           => ['type' => 'BIGINT', 'constraint' => 20, 'unsigned' => true, 'auto_increment' => true],
            'product_code' => ['type' => 'VARCHAR', 'constraint' => 20, 'unique' => true],
            'product_name' => ['type' => 'VARCHAR', 'constraint' => 150],
            'unit'         => ['type' => 'VARCHAR', 'constraint' => 50],
            'price'        => ['type' => 'DECIMAL', 'constraint' => '15,2'],
            'created_at'   => ['type' => 'DATETIME', 'null' => true],
            'updated_at'   => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'     => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('products');
    }

    public function down()
    {
        $this->forge->dropTable('products', true);
    }
}
