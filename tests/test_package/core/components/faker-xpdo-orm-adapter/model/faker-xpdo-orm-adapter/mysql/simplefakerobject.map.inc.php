<?php
$xpdo_meta_map['SimpleFakerObject']= array (
  'package' => 'faker-xpdo-orm-adapter',
  'version' => '1.1',
  'table' => 'simple_faker_objects',
  'extends' => 'xPDOSimpleObject',
  'tableMeta' => 
  array (
    'engine' => 'InnoDB',
  ),
  'fields' => 
  array (
    'title' => '',
  ),
  'fieldMeta' => 
  array (
    'title' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '255',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
  ),
);
