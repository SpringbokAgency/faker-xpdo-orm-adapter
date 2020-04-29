<?php
/**
 * Copyright (c) 2020-present Springbok Agency BV (https://www.springbokagency.com)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE file
 * Redistributions of files must retain the above copyright notice.
 */

namespace SpringbokAgency\Faker\ORM\xPDO;


use Faker\Generator;
use InvalidArgumentException;
use xPDO;

class Populator
{

    protected $generator;
    protected $xpdo;

    protected $entities = [];
    protected $quantities = [];

    /**
     * Populator constructor.
     * @param $generator
     * @param $xpdo
     */
    public function __construct(Generator $generator, xPDO $xpdo = null)
    {
        $this->generator = $generator;
        $this->xpdo = $xpdo;
    }

    /**
     * Add an order for the generation of $number records for $entity.
     *
     * @param mixed $entity A xPDO classname, or a \SpringbokAgency\Faker\ORM\xPDO\EntityPopulator instance
     * @param int $number The number of entities to populate
     * @param array $customColumnFormatters
     * @param array $customModifiers
     * @return Populator
     */
    public function addEntity($entity, $number, $customColumnFormatters = [], $customModifiers = [])
    {
        if (!$entity instanceof EntityPopulator) {
            if ($this->xpdo === null) {
                throw new InvalidArgumentException('No xPDO instance passed to xPDO Populator');
            }

            $entity = new EntityPopulator($this->xpdo, $entity);
        }

        $entity->setColumnFormatters($entity->guessColumnFormatters($this->generator));
        if ($customColumnFormatters) {
            $entity->mergeColumnFormattersWith($customColumnFormatters);
        }

        $entity->setModifiers($entity->guessModifiers($this->generator));
        if ($customModifiers) {
            $entity->mergeModifiersWith($customModifiers);
        }

        $class = $entity->getClass();
        $this->entities[$class] = $entity;
        $this->quantities[$class] = $number;

        return $this;
    }

    /**
     * @return array
     */
    public function execute()
    {
        $insertedEntities = [];

        foreach ($this->quantities as $class => $number) {
            for ($i = 0; $i < $number; $i++) {
                $insertedEntities[$class][] = $this->entities[$class]->execute($class, $insertedEntities);
            }
        }

        return $insertedEntities;
    }
}