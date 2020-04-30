<?php
namespace SpringbokAgency\Tests\TestPackage\Faker\Model\mysql;

use xPDO\xPDO;

class SimpleFakerObject extends \SpringbokAgency\Tests\TestPackage\Faker\Model\SimpleFakerObject
{

    public static $metaMap = array (
        'package' => 'SpringbokAgency\\Tests\\TestPackage\\Faker\\Model',
        'version' => '3.0',
        'table' => 'simple_faker_objects',
        'extends' => 'xPDO\\Om\\xPDOSimpleObject',
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

}
