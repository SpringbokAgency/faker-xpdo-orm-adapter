<?php
/**
 * Copyright (c) 2020-present Springbok Agency BV (https://www.springbokagency.com)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE file
 * Redistributions of files must retain the above copyright notice.
 */

namespace SpringbokAgency\Tests\Faker\ORM\xPDO;

use CustomColumnFormatterFakerObject;
use Faker\Factory;
use Faker\Generator;
use ParentChildrenFakerObject;
use SimpleFakerObject;
use SpringbokAgency\Faker\ORM\xPDO\Populator;
use SpringbokAgency\Tests\PHPUnit\Framework\DatabaseTestCase;

class PopulatorTest extends DatabaseTestCase
{
    protected $fixtures = [
        SimpleFakerObject::class,
        ParentChildrenFakerObject::class,
        CustomColumnFormatterFakerObject::class,
    ];

    /**
     * @dataProvider addEntityDataProvider
     */
    public function testAddEntityAndExecute($className, $amount, $expected)
    {
        $generator = Factory::create();

        $populator = new Populator($generator, self::$xpdo);

        $populator->addEntity($className, $amount);
        $populatedEntities = $populator->execute();
        $this->arrayHasKey($className);
        $this->assertCount($expected, $populatedEntities[$className]);
    }

    public function addEntityDataProvider()
    {
        return [
            [SimpleFakerObject::class, 5, 5],
            [ParentChildrenFakerObject::class, 10, 10],
        ];
    }

    /**
     * @depends      testAddEntityAndExecute
     * @dataProvider customColumnFormattersProvider
     */
    public function testAddEntityAndExecuteWithCustomColumnFormatters($className, $formatters)
    {
        $generator = Factory::create();
        $generator->seed(1234);

        $customFormatters = [];
        $expected = [];
        foreach ($formatters as $column => $formatter) {
            if ($formatter === null) {
                $customFormatters[$column] = null;

                $classFields = self::$xpdo->getFields($className);
                if (!array_key_exists($column, $classFields)) {
                    continue;
                }

                $expected[$column] = $classFields[$column];

                continue;
            }

            $customFormatters[$column] = $formatter($generator);
            $expected[$column] = $formatter($generator)();
        }

        $populator = new Populator($generator, self::$xpdo);

        $populator->addEntity($className, 1, $customFormatters);
        $populatedEntities = $populator->execute();

        $primarKeyField = self::$xpdo->getPK($className);
        foreach ($populatedEntities[$className] as $primaryKey) {
            $entity = self::$xpdo->getObject(
                $className,
                array_merge(
                    [
                        $primarKeyField => $primaryKey,
                    ],
                    $expected
                )
            );

            $this->assertNotNull($entity);
        }
    }

    public function customColumnFormattersProvider()
    {
        return [
            [
                CustomColumnFormatterFakerObject::class,
                [
                    'class_key' => function (Generator $generator) {
                        return function () use ($generator) {
                            return CustomColumnFormatterFakerObject::class;
                        };
                    },
                    'do_not_populate' => null,
                ],
            ],
        ];
    }
}