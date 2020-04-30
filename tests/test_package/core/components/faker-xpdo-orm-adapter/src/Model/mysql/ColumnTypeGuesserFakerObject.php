<?php
namespace SpringbokAgency\Tests\TestPackage\Faker\Model\mysql;

use xPDO\xPDO;

class ColumnTypeGuesserFakerObject extends \SpringbokAgency\Tests\TestPackage\Faker\Model\ColumnTypeGuesserFakerObject
{

    public static $metaMap = array (
        'package' => 'SpringbokAgency\\Tests\\TestPackage\\Faker\\Model',
        'version' => '3.0',
        'extends' => 'xPDO\\Om\\xPDOSimpleObject',
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

}
