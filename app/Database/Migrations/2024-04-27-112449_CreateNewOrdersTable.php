<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateNewOrdersTable extends Migration
{
    public function up()
    {
        // Delete old orders tables
        $this->forge->dropTable('orders', true);

        // Creat new orders table
        $this->forge->addField([
            'order_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'table_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'dish_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'total_price' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ]
        ]);
        
        $this->forge->addKey('order_id', true);
        $this->forge->addForeignKey('table_id', 'tables', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('dish_id', 'dishes', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('orders');
    }

    public function down()
    {
        $this->forge->dropTable('orders', true);
    }
}
