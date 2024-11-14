<?php
$CI = get_instance();
$CI->load->database();
$CI->load->dbforge();

//update data in settings table
$settings_datas['description'] = '2.15';
$CI->db->where('type', 'version');
$CI->db->update('settings', $settings_datas);


$column_name = 'price_range';
$table_name = 'listing';

if (!$CI->db->field_exists($column_name, $table_name)) {
    $fields = array(
        $column_name => array(
            'type' => 'VARCHAR',
            'constraint' => '100',
            'null' => TRUE,
            'default' => 'no'
        ),
    );

    $CI->dbforge->add_column($table_name, $fields);
}

$column_name = 'opened_minutes';
if (!$CI->db->field_exists($column_name, $table_name)) {
    $fields = array(
        $column_name => array(
            'type' => 'VARCHAR',
            'constraint' => '100',
            'null' => TRUE,
            'default' => 'no'
        ),
    );

    $CI->dbforge->add_column($table_name, $fields);
}

$column_name = 'closed_minutes';
if (!$CI->db->field_exists($column_name, $table_name)) {
    $fields = array(
        $column_name => array(
            'type' => 'VARCHAR',
            'constraint' => '100',
            'null' => TRUE,
            'default' => 'no'
        ),
    );

    $CI->dbforge->add_column($table_name, $fields);
}
