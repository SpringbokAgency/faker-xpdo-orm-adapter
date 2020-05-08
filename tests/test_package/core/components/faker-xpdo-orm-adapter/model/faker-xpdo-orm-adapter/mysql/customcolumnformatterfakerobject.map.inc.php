<?php
$xpdo_meta_map['CustomColumnFormatterFakerObject']= array (
  'package' => 'faker-xpdo-orm-adapter',
  'version' => '1.1',
  'table' => 'custom_column_formatter_faker_objects',
  'extends' => 'xPDOSimpleObject',
  'tableMeta' => 
  array (
    'engine' => 'InnoDB',
  ),
  'fields' => 
  array (
    'class_key' => NULL,
    'do_not_populate' => 'not populated with fake data',
  ),
  'fieldMeta' => 
  array (
    'class_key' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '255',
      'phptype' => 'string',
      'null' => true,
    ),
    'do_not_populate' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'string',
      'null' => false,
      'default' => 'not populated with fake data',
    ),
  ),
);
