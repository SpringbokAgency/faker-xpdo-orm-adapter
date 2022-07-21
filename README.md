# Faker xPDO ORM Adapter

A [Faker](https://github.com/FakerPHP/Faker) ORM adapter to populate [xPDO](http://xpdo.org) objects with fake data.

# Table of contents

- [Installation](#installation)
- [Usage](#usage)

## Installation

Install as development dependency using [Composer](https://getcomposer.org).

``` bash
$ composer require --dev springbokagency/faker-xpdo-orm-adapter
```

## Usage
To populate xPDO objects, create a new populator class (using a generator instance as first parameter, and a valid xPDO instance as second parameter), then list the class and number of all the objects that must be generated. To launch the actual data population, call the execute() method.

Here is an example showing how to populate 5 `modUser` and 10 `modResource` objects:

```php
<?php
$generator = \Faker\Factory::create();
$populator = new \SpringbokAgency\Faker\ORM\xPDO\Populator($generator, $xpdo);
$populator->addEntity(\MODX\Revolution\modUser::class, 5);
$populator->addEntity(\MODX\Revolution\modResource::class, 10);
$insertedPKs = $populator->execute();
```

For more info read [the Faker documentation](https://github.com/FakerPHP/Faker#populating-entities-using-an-orm-or-an-odm).
