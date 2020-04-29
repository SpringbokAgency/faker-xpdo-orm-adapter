<?php
/**
 * Copyright (c) 2020-present Springbok Agency BV (https://www.springbokagency.com)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE file
 * Redistributions of files must retain the above copyright notice.
 */

namespace SpringbokAgency\Faker\ORM\xPDO;


use Closure;
use Faker\Generator;

class ColumnTypeGuesser
{
    protected $generator;

    /**
     * ColumnTypeGuesser constructor.
     * @param Generator $generator
     */
    public function __construct(Generator $generator)
    {
        $this->generator = $generator;
    }

    /**
     * @param array $column
     * @return Closure|null
     */
    public function guessFormat(array $column)
    {
        $generator = $this->generator;

        $phptype = $column['phptype'];

        switch ($phptype) {
            case 'timestamp':
            {
                return function () use ($generator) {
                    return $generator->unixTime();
                };
            }
            case 'datetime':
            {
                return function () use ($generator) {
                    return $generator->date() . ' ' . $generator->time();
                };
            }
            case 'date':
            {
                return function () use ($generator) {
                    return $generator->datetime();
                };
            }
            case 'boolean':
            {
                return function () use ($generator) {
                    return $generator->boolean();
                };
            }
            case 'integer':
            {
                return function () use ($generator) {
                    return $generator->randomNumber();
                };
            }
            case 'array':
            {
                return function () use ($generator) {
                    return $generator->randomElements();
                };
            }
            case 'string':
            {
                return function () use ($generator) {
                    return $generator->text();
                };
            }
        }

        return null;
    }
}