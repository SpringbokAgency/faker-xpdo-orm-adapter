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
use Faker\Guesser\Name;
use RuntimeException;
use xPDO\Om\xPDOObject;
use xPDO\xPDO;

class EntityPopulator
{
    /**
     * @var string
     */
    protected $class;
    /**
     * @var array
     */
    protected $columnFormatters = [];
    /**
     * @var array
     */
    protected $modifiers = [];

    /**
     * @var xPDO
     */
    private $xpdo;

    /**
     * EntityPopulator constructor.
     * @param xPDO $xpdo
     * @param $class
     */
    public function __construct(xPDO $xpdo, $class)
    {
        $this->xpdo = $xpdo;
        $this->class = $class;
    }

    /**
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * @param $columnFormatters
     */
    public function mergeColumnFormattersWith($columnFormatters)
    {
        $this->columnFormatters = array_merge($this->columnFormatters, $columnFormatters);
    }

    /**
     * @param Generator $generator
     * @return array
     */
    public function guessColumnFormatters(Generator $generator)
    {
        $formatters = [];
        $class = $this->class;
        $schema = $this->xpdo->getFieldMeta($class);
        $aggregates = $this->xpdo->getAggregates($class);
        $pk = $this->xpdo->getPK($class);
        $isFieldForeignKey = function ($field) use ($aggregates) {
            foreach ($aggregates as $aggregateClass => $aggregateSchema) {
                if ($field === $aggregateSchema['local']) {
                    return true;
                }
            }
            return false;
        };

        $nameGuesser = new Name($generator);
        $columnTypeGuesser = new ColumnTypeGuesser($generator);

        foreach ($schema as $field => $column) {
            if ($field === $pk || $field === $isFieldForeignKey($field)) {
                continue;
            }

            $size = isset($column['precision']) ? (int)$column['precision'] : null;
            if ($formatter = $nameGuesser->guessFormat($field, $size)) {
                $formatters[$field] = $formatter;
                continue;
            }

            if ($formatter = $columnTypeGuesser->guessFormat($column)) {
                $formatters[$field] = $formatter;
                continue;
            }
        }

        return $formatters;
    }

    /**
     * @param $modifiers
     */
    public function mergeModifiersWith($modifiers)
    {
        $this->modifiers = array_merge($this->modifiers, $modifiers);
    }

    /**
     * @param Generator $generator
     * @return array
     */
    public function guessModifiers(Generator $generator)
    {
        $modifiers = [];
        $class = $this->class;
        $schemaAggregates = $this->xpdo->getAggregates($class);

        foreach ($schemaAggregates as $field => $schema) {
            $modifiers[$field] = function (xPDOObject $xpdoObject, $insertedEntities) use ($schema, $generator) {
                $foreignClass = $schema['class'];
                $foreignField = $schema['local'];

                if (!empty($insertedEntities[$foreignClass])) {
                    $foreignKeys = $insertedEntities[$foreignClass];
                } else {
                    $foreignKeys = $this->xpdo->getCollection($foreignClass);
                }

                if (!empty($foreignKeys)) {
                    /** @var xPDOObject $foreignKey */
                    $foreignKey = $foreignKeys[array_rand($foreignKeys)];
                    $xpdoObject->set($foreignField, is_object($foreignKey) ? $foreignKey->getPrimaryKey() : $foreignKey);
                }
            };
        }


        return $modifiers;
    }

    /**
     * @param $class
     * @param $insertedEntities
     * @return array
     */
    public function execute($class, $insertedEntities)
    {
        /** @var xPDOObject $entity */
        $entity = $this->xpdo->newObject($class);

        foreach ($this->getColumnFormatters() as $column => $format) {
            if ($format === null) {
                continue;
            }

            $entity->set($column, is_callable($format) ? $format($insertedEntities, $entity) : $format);
        }

        foreach ($this->getModifiers() as $modifier) {
            $modifier($entity, $insertedEntities);
        }

        if (!$entity->save()) {
            throw new RuntimeException("Failed saving $class record");
        }

        return $entity->getPrimaryKey();
    }

    /**
     * @return array
     */
    public function getColumnFormatters()
    {
        return $this->columnFormatters;
    }

    /**
     * @param array $columnFormatters
     */
    public function setColumnFormatters(array $columnFormatters)
    {
        $this->columnFormatters = $columnFormatters;
    }

    /**
     * @return array
     */
    public function getModifiers()
    {
        return $this->modifiers;
    }

    /**
     * @param array $modifiers
     */
    public function setModifiers(array $modifiers)
    {
        $this->modifiers = $modifiers;
    }
}
