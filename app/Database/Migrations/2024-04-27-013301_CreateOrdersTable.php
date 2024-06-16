<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateOrdersTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'order_id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'table_id' => [
                'type'       => 'INT',
                'constraint' => 5,
                'unsigned'   => true,
            ],
            'dish_id' => [
                'type'       => 'INT',
                'constraint' => 5,
                'unsigned'   => true,
            ],
            'quantity' => [
                'type'       => 'INT',
                'constraint' => 5
            ],
            'total_price' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
            ]
        ]);
        $this->forge->addKey('order_id', true);
        $this->forge->addForeignKey('table_id', 'tables', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('dish_id', 'dishes', 'id', 'CASCADE', 'CASCADE'); // Corrected foreign key reference
        $this->forge->createTable('orders');
    }

    public function down()
    {
        $this->forge->dropTable('orders');
    }
}
