<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_payment_gateway_to_seller_data extends CI_Migration
{

    //052_add_payment_gateway_to_seller_data

    public function up()
    {
        $fields = [
            'withdrawal_payment_gateway' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => TRUE,
                'default' => null,
            ]
        ];

        $this->dbforge->add_column('seller_data', $fields);
    }

    public function down()
    {
        $this->dbforge->drop_column('seller_data', 'withdrawal_payment_gateway');
    }
}
