<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_pan_upload_to_seller_data extends CI_Migration
{

    //051_add_pan_upload_to_seller_data

    public function up()
    {
        $fields = [
            'pan_upload' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => TRUE,
                'after' => 'pan_number'
            ]
        ];

        $this->dbforge->add_column('seller_data', $fields);
    }

    public function down()
    {
        $this->dbforge->drop_column('seller_data', 'pan_upload');
    }
}
