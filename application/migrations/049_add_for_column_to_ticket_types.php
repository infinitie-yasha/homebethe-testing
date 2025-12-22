

<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_add_for_column_to_ticket_types extends CI_Migration
{

    // //049_add_for_column_to_ticket_types.php
    public function up()
    {
        // Add new column approval_status
        $fields = array(
            'for' => array(
                'type'       => 'ENUM("seller","customer")',
                'null'       => TRUE,
                'default'    =>  null,
                'after'      => 'title' // add after existing status column
            ),

        );

        $this->dbforge->add_column('ticket_types', $fields);
    }

    public function down()
    {
        // Remove column
        $this->dbforge->drop_column('ticket_types', 'for');
    }
}
