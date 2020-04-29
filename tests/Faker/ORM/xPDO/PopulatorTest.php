<?php
/**
 * Copyright (c) 2020-present Springbok Agency BV (https://www.springbokagency.com)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE file
 * Redistributions of files must retain the above copyright notice.
 */

namespace SpringbokAgency\Tests\Faker\ORM\xPDO;

use Faker\Factory;
use ParentChildrenFakerObject;
use SimpleFakerObject;
use SpringbokAgency\Faker\ORM\xPDO\Populator;
use SpringbokAgency\Tests\PHPUnit\Framework\DatabaseTestCase;

class PopulatorTest extends DatabaseTestCase
{
    protected $fixtures = [
        SimpleFakerObject::class,
        ParentChildrenFakerObject::class,
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
}