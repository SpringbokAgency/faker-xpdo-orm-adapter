<?php
namespace SpringbokAgency\Tests\TestPackage\Faker\Model\mysql;

use xPDO\xPDO;

class ParentChildrenFakerObject extends \SpringbokAgency\Tests\TestPackage\Faker\Model\ParentChildrenFakerObject
{

    public static $metaMap = array (
        'package' => 'SpringbokAgency\\Tests\\TestPackage\\Faker\\Model',
        'version' => '3.0',
        'table' => 'parent_children_faker_objects',
        'extends' => 'SpringbokAgency\\Tests\\TestPackage\\Faker\\Model\\SimpleFakerObject',
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

}
