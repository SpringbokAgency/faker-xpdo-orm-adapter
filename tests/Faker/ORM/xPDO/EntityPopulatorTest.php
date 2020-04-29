<?php
/**
 * Copyright (c) 2020-present Springbok Agency BV (https://www.springbokagency.com)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE file
 * Redistributions of files must retain the above copyright notice.
 */

namespace SpringbokAgency\Tests\Faker\ORM\xPDO;

use Closure;
use Faker\Factory;
use Faker\Generator;
use ParentChildrenFakerObject;
use RuntimeException;
use SimpleFakerObject;
use SpringbokAgency\Faker\ORM\xPDO\EntityPopulator;
use SpringbokAgency\Tests\PHPUnit\Framework\DatabaseTestCase;

class EntityPopulatorTest extends DatabaseTestCase
{
    protected $fixtures = [
        SimpleFakerObject::class,
        ParentChildrenFakerObject::class,
    ];

    public function testGuessColumnFormatters()
    {
        $generator = new Generator();
        $entityPopulator = new EntityPopulator(self::$xpdo, SimpleFakerObject::class);

        $guessedColumnFormatters = $entityPopulator->guessColumnFormatters($generator);

        $this->assertNotEmpty($guessedColumnFormatters);
        foreach ($guessedColumnFormatters as $guessedColumnFormatter) {
            $this->assertInstanceOf(Closure::class, $guessedColumnFormatter);
        }
    }

    public function testGuessModifiers()
    {
        $generator = new Generator();
        $entityPopulator = new EntityPopulator(self::$xpdo, ParentChildrenFakerObject::class);

        $guessedModifiers = $entityPopulator->guessModifiers($generator);
        $this->assertNotEmpty($guessedModifiers);

        $expectedGuessedModifiers = array_keys(self::$xpdo->map[ParentChildrenFakerObject::class]['aggregates']);
        $actualGuessedModifiers = array_keys($guessedModifiers);
        $this->assertSame(
            array_diff($expectedGuessedModifiers, $actualGuessedModifiers),
            array_diff($actualGuessedModifiers, $expectedGuessedModifiers)
        );
    }

    public function testExecute()
    {
        $generator = Factory::create();

        $entityPopulator = new EntityPopulator(self::$xpdo, SimpleFakerObject::class);

        $entityPopulator->setColumnFormatters($entityPopulator->guessColumnFormatters($generator));

        $primaryKeyForEntity = $entityPopulator->execute(SimpleFakerObject::class, []);
        $this->assertNotNull($primaryKeyForEntity);
    }

    public function testExecuteFailed()
    {
        self::$xpdo->getManager()->removeObjectContainer(SimpleFakerObject::class);

        $class = SimpleFakerObject::class;

        $entityPopulator = new EntityPopulator(self::$xpdo, $class);

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage("Failed saving $class record");
        $entityPopulator->execute(SimpleFakerObject::class, []);
    }
}