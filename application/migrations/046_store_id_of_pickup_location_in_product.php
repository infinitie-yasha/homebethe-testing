<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Store_id_of_pickup_location_in_product extends CI_Migration
{

    public function up()
    {
        // Step 1: Add a new pickup_location_id column
        $fields = array(
            'pickup_location_id' => array(
                'type' => 'INT',
                'null' => TRUE,
                'after' => 'deliverable_cities'
            ),
        );
        $this->dbforge->add_column('products', $fields);

        // Step 2: Update the pickup_location_id column based on the current pickup location name
        $this->db->query("
            UPDATE products p
            JOIN pickup_locations pl ON p.pickup_location = pl.pickup_location
            SET p.pickup_location_id = pl.id
        ");

        // Step 3: Drop the old pickup_location column
        $this->dbforge->drop_column('products', 'pickup_location');

        // Step 4: Rename pickup_location_id column to pickup (optional)
        $fields = array(
            'pickup_location_id' => array(
                'name' => 'pickup_location',
                'type' => 'INT',
            ),
        );
        $this->dbforge->modify_column('products', $fields);
    }

    public function down()
    {
        // Rollback: Add the old pickup_location column back
        $fields = array(
            'pickup_location' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => TRUE,
            ),
        );
        $this->dbforge->add_column('products', $fields);

        // Revert the brand_id column back to brand name
        $this->db->query("
            UPDATE products p
            JOIN pickup_locations pl ON p.pickup_location_id = pl.id
            SET p.pickup_location = pl.pickup_location
        ");

        // Remove the pickup_location_id column
        $this->dbforge->drop_column('products', 'pickup_location_id');
    }
}
