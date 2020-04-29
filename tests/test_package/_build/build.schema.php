<?php
/**
 * Copyright (c) 2020-present Springbok Agency BV (https://www.springbokagency.com)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE file
 * Redistributions of files must retain the above copyright notice.
 */

$mtime = microtime();
$mtime = explode(" ", $mtime);
$mtime = $mtime[1] + $mtime[0];
$tstart = $mtime;

$properties = [];
include dirname(dirname(__DIR__)) . '/properties.inc.php';
require_once dirname((dirname(dirname(__DIR__)))) . '/vendor/autoload.php';

$driver = $properties['xpdo_driver'];

$xpdo = new xPDO(
    $properties[$driver . '_string_dsn_test'],
    $properties[$driver . '_string_username'],
    $properties[$driver . '_string_password']
);

$packageBasePath = dirname(__DIR__) . '/core/components/faker-xpdo-orm-adapter/';
$xpdo->setPackage('faker-xpdo-orm-adapter', $packageBasePath);
$xpdo->setLogTarget('ECHO');
$xpdo->setLogLevel(xPDO::LOG_LEVEL_INFO);

$xpdo->getManager()->getGenerator()->parseSchema(
    $packageBasePath . 'model/schema/faker-xpdo-orm-adapter.' . $driver . '.schema.xml',
    $packageBasePath . 'model/'
);

$mtime = microtime();
$mtime = explode(" ", $mtime);
$mtime = $mtime[1] + $mtime[0];
$tend = $mtime;
$totalTime = ($tend - $tstart);
$totalTime = sprintf("%2.4f s", $totalTime);

echo "\nExecution time: {$totalTime}\n";

exit ();
