<?php
/**
 * Copyright (c) 2020-present Springbok Agency BV (https://www.springbokagency.com)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE file
 * Redistributions of files must retain the above copyright notice.
 */

namespace SpringbokAgency\Tests\PHPUnit\Framework;


use PHPUnit\Framework\TestCase;
use xPDO;

abstract class DatabaseTestCase extends TestCase
{

    /**
     * @var xPDO
     */
    protected static $xpdo = null;

    protected $fixtures = [];

    public static function setUpBeforeClass()
    {
        $properties = [];
        include (dirname(dirname(__DIR__))) . '/properties.inc.php';

        $driver = $properties['xpdo_driver'];

        $xpdo = new xPDO(
            $properties[$driver . '_string_dsn_test'],
            $properties[$driver . '_string_username'],
            $properties[$driver . '_string_password']
        );

        $xpdo->getManager()->createSourceContainer();
        $xpdo->setPackage(
            'faker-xpdo-orm-adapter',
            dirname(dirname(__DIR__)) . '/test_package/core/components/faker-xpdo-orm-adapter/model/'
        );

        self::$xpdo = $xpdo;
    }

    public static function tearDownAfterClass()
    {
        self::$xpdo->getManager()->removeSourceContainer();
        self::$xpdo = null;
    }

    protected function setUp()
    {
        parent::setUp();

        foreach ($this->fixtures as $fixture) {
            self::$xpdo->getManager()->createObjectContainer($fixture);
        }
    }

    protected function tearDown()
    {
        foreach ($this->fixtures as $fixture) {
            self::$xpdo->getManager()->removeObjectContainer($fixture);
        }

        parent::tearDown();
    }

}