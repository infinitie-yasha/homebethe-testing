<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_commission_perc_to_categories extends CI_Migration
{

    //050

    public function up()
    {
        $fields = [
            'commission_perc' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => TRUE,
                'comment' => 'This is stored only to prefill percantage column when approving seller'
            ]
        ];

        $this->dbforge->add_column('categories', $fields);
    }

    public function down()
    {
        $this->dbforge->drop_column('categories', 'commission_perc');
    }
}
