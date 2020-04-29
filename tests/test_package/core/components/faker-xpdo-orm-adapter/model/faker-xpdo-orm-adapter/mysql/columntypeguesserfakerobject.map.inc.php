<?php
$xpdo_meta_map['ColumnTypeGuesserFakerObject']= array (
  'package' => 'faker-xpdo-orm-adapter',
  'version' => '1.1',
  'extends' => 'xPDOSimpleObject',
  'tableMeta' => 
  array (
    'engine' => 'InnoDB',
  ),
  'fields' => 
  array (
    'timestamp' => NULL,
    'datetime' => NULL,
    'date' => NULL,
    'boolean' => NULL,
    'integer' => NULL,
    'array' => NULL,
    'string' => NULL,
    'object' => 'not_sure',
  ),
  'fieldMeta' => 
  array (
    'timestamp' => 
    array (
      'dbtype' => 'timestamp',
      'phptype' => 'timestamp',
      'null' => true,
    ),
    'datetime' => 
    array (
      'dbtype' => 'datetime',
      'phptype' => 'datetime',
      'null' => true,
    ),
    'date' => 
    array (
      'dbtype' => 'date',
      'phptype' => 'date',
      'null' => true,
    ),
    'boolean' => 
    array (
      'dbtype' => 'tinyint',
      'precision' => '1',
      'phptype' => 'boolean',
      'null' => true,
    ),
    'integer' => 
    array (
      'dbtype' => 'int',
      'precision' => '11',
      'phptype' => 'boolean',
      'null' => true,
    ),
    'array' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'array',
      'null' => true,
    ),
    'string' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '255',
      'phptype' => 'string',
      'null' => true,
    ),
    'object' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'object',
      'null' => false,
      'default' => 'not_sure',
    ),
  ),
);
