<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTablesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'capacity' => [
                'type'       => 'INT',
                'constraint' => 5,
            ],
            'qr_code' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('tables');
    }

    public function down()
    {
        $this->forge->dropTable('tables');
    }
}
