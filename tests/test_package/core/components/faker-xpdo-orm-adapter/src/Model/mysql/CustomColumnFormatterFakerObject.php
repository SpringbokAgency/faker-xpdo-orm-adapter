<?php
namespace SpringbokAgency\Tests\TestPackage\Faker\Model\mysql;

use xPDO\xPDO;

class CustomColumnFormatterFakerObject extends \SpringbokAgency\Tests\TestPackage\Faker\Model\CustomColumnFormatterFakerObject
{

    public static $metaMap = array (
        'package' => 'SpringbokAgency\\Tests\\TestPackage\\Faker\\Model',
        'version' => '3.0',
        'table' => 'custom_column_formatter_faker_objects',
        'extends' => 'xPDO\\Om\\xPDOSimpleObject',
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

}
