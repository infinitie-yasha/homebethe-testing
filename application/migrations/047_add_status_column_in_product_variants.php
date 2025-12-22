<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_status_column_in_product_variants extends CI_Migration
{
    public function up()
    {
        // Define new column
        $fields = [
            'active_status' => [
                'type' => 'ENUM("active","archived")',
                'default' => 'active',
                'null' => FALSE,
                'after' => 'attribute_value_ids' // adjust if needed
            ]
        ];

        // Add the column
        $this->dbforge->add_column('product_variants', $fields);

        // echo "✅ Added 'active_status' column to product_variants table.\n";
    }

    public function down()
    {
        // Rollback migration (remove the column)
        $this->dbforge->drop_column('product_variants', 'active_status');

        // echo "❌ Removed 'active_status' column from product_variants table.\n";
    }
}
