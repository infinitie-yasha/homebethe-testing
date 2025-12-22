<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_add_approval_status_to_products extends CI_Migration
{

    // 048_add_approval_status_to_products ticket_types
    public function up()
    {
        // Add new column approval_status
        $fields = array(
            'approval_status' => array(
                'type'       => 'ENUM("pending","approved","rejected")',
                'null'       => TRUE,
                'default'    => 'pending',
                'after'      => 'status' // add after existing status column
            ),
            'rejection_reason' => array(
                'type' => 'VARCHAR',
                'constraint' => 2500,
                'null'       => TRUE,
                'default'    => NULL,
                'after'      => 'approval_status' // add after existing status column
            )
        );

        $this->dbforge->add_column('products', $fields);
    }

    public function down()
    {
        // Remove column
        $this->dbforge->drop_column('products', 'approval_status');
        $this->dbforge->drop_column('products', 'rejection_reason');
    }
}
