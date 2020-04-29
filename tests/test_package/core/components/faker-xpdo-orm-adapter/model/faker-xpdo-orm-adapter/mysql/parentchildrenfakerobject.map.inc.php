<?php
$xpdo_meta_map['ParentChildrenFakerObject']= array (
  'package' => 'faker-xpdo-orm-adapter',
  'version' => '1.1',
  'table' => 'parent_children_faker_objects',
  'extends' => 'SimpleFakerObject',
  'tableMeta' => 
  array (
    'engine' => 'InnoDB',
  ),
  'fields' => 
  array (
    'parent' => NULL,
  ),
  'fieldMeta' => 
  array (
    'parent' => 
    array (
      'dbtype' => 'int',
      'precision' => '11',
      'phptype' => 'integer',
    ),
  ),
  'composites' => 
  array (
    'Children' => 
    array (
      'class' => 'ParentChildrenFakerObject',
      'local' => 'id',
      'foreign' => 'parent',
      'cardinality' => 'many',
      'owner' => 'local',
    ),
  ),
  'aggregates' => 
  array (
    'Parent' => 
    array (
      'class' => 'ParentChildrenFakerObject',
      'local' => 'parent',
      'foreign' => 'id',
      'cardinality' => 'one',
      'owner' => 'foreign',
    ),
  ),
);
