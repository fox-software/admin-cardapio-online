<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreatePedidosTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'auto_increment' => true
            ],
            'sistema_id' => [
                'type' => 'INT',
            ],
            'usuario_id' => [
                'type' => 'INT',
            ],
            'endereco_id' => [
                'type' => 'INT',
            ],
            'cartao_id' => [
                'type' => 'INT',
            ],
            'codigo' => [
                'type' => 'TEXT',
            ],
            'total' => [
                'type' => 'FLOAT',
            ],
            'frete' => [
                'type' => 'FLOAT',
            ],
            'troco' => [
                'type' => 'FLOAT',
            ],
            'comprovante' => [
                'type' => 'TEXT',
            ],
            'observacao' => [
                'type' => 'TEXT',
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ["A", "I"],
                "comment" => "A: ATIVO | I: INATIVO",
                "default" => "A",
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'default' => new RawSql('CURRENT_TIMESTAMP')
            ],
            'updated_at' => [
                'type' => 'TIMESTAMP',
                'default' => new RawSql('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP')
            ]
        ]);

        $this->forge->addKey('id', true);

        $this->forge->addForeignKey('sistema_id', 'sistemas', 'id');
        $this->forge->addForeignKey('usuario_id', 'usuarios', 'id');
        $this->forge->addForeignKey('endereco_id', 'enderecos', 'id');
        $this->forge->addForeignKey('cartao_id', 'cartoes', 'id');

        $this->forge->createTable('pedidos');
    }

    public function down()
    {
        $this->forge->dropTable('pedidos', true);
    }
}
