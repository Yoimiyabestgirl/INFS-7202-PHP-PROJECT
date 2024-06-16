<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateOrderItemsTable extends Migration
{
    public function up()
    {
        $fields = [
            'order_item_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ],
            'order_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
            ],
            'dish_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
            ],
            'quantity' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'default' => 1
            ],
            'price' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'null' => TRUE,
            ]
        ];

        $this->forge->addField($fields);
        $this->forge->addKey('order_item_id', TRUE);

        // Foreign keys should be added as follows
        $this->forge->addForeignKey('order_id', 'orders', 'order_id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('dish_id', 'dishes', 'id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('order_items');
    }

    public function down()
    {
        // Drop the table if it exists
        $this->forge->dropTable('order_items', TRUE);
    }
}
