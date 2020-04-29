<?php
/**
 * Copyright (c) 2020-present Springbok Agency BV (https://www.springbokagency.com)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE file
 * Redistributions of files must retain the above copyright notice.
 */

namespace SpringbokAgency\Tests\Faker\ORM\xPDO;


use DateTime;
use DateTimeImmutable;
use Faker\Factory;
use PHPUnit\Framework\TestCase;
use SpringbokAgency\Faker\ORM\xPDO\ColumnTypeGuesser;

class ColumnTypeGuesserTest extends TestCase
{

    public function testGuessFormatDate()
    {
        $generator = Factory::create();
        $columnTypeGuesser = new ColumnTypeGuesser($generator);

        $guessedColumnFormat = $columnTypeGuesser->guessFormat(
            [
                'dbtype' => 'timestamp',
                'phptype' => 'timestamp',
                'null' => true,
            ]
        );

        $this->assertInternalType('int', $guessedColumnFormat());

        $guessedColumnFormat = $columnTypeGuesser->guessFormat(
            [
                'dbtype' => 'datetime',
                'phptype' => 'datetime',
                'null' => true,
            ]
        );

        $this->assertInternalType("string", $guessedColumnFormat());
        $dateTimeFormat = 'Y-m-d H:i:s';
        $dateTimeString = $guessedColumnFormat();
        $expectedDateTime = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $dateTimeString);
        $this->assertEquals($expectedDateTime->format($dateTimeFormat), $dateTimeString);

        $guessedColumnFormat = $columnTypeGuesser->guessFormat(
            [
                'dbtype' => 'date',
                'phptype' => 'date',
                'null' => true,
            ]
        );

        $this->assertInstanceOf(DateTime::class, $guessedColumnFormat());
    }

    public function testGuessFormatBoolean()
    {
        $generator = Factory::create();
        $columnTypeGuesser = new ColumnTypeGuesser($generator);
        $guessedColumnFormat = $columnTypeGuesser->guessFormat(
            [
                'dbtype' => 'tinyint',
                'precision' => '1',
                'phptype' => 'boolean',
                'null' => false,
            ]
        );

        $this->assertInternalType("boolean", $guessedColumnFormat());
    }

    public function testGuessFormatInteger()
    {
        $generator = Factory::create();
        $columnTypeGuesser = new ColumnTypeGuesser($generator);
        $guessedColumnFormat = $columnTypeGuesser->guessFormat(
            [
                'dbtype' => 'int',
                'precision' => '11',
                'phptype' => 'integer',
                'null' => false,
                'default' => 0,
            ]
        );

        $this->assertInternalType("int", $guessedColumnFormat());
    }

    public function testGuessFormatArray()
    {
        $generator = Factory::create();
        $columnTypeGuesser = new ColumnTypeGuesser($generator);
        $guessedColumnFormat = $columnTypeGuesser->guessFormat(
            [
                'dbtype' => 'text',
                'phptype' => 'array',
                'null' => false,
            ]
        );

        $this->assertInternalType("array", $guessedColumnFormat());
        $this->assertNotEmpty($guessedColumnFormat);
    }

    public function testGuessFormatString()
    {
        $generator = Factory::create();
        $columnTypeGuesser = new ColumnTypeGuesser($generator);
        $guessedColumnFormat = $columnTypeGuesser->guessFormat(
            [
                'dbtype' => 'varchar',
                'precision' => '255',
                'phptype' => 'string',
                'null' => false,
            ]
        );

        $this->assertInternalType("string", $guessedColumnFormat());
    }

    public function testGuessNotSureWhatToUse()
    {
        $generator = Factory::create();
        $columnTypeGuesser = new ColumnTypeGuesser($generator);
        $guessedColumnFormat = $columnTypeGuesser->guessFormat(
            [
                'dbtype' => 'text',
                'phptype' => 'object',
                'null' => false,
            ]
        );

        $this->assertNull($guessedColumnFormat);
    }
}