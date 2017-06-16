<?php
/**
 * This file is part of the SqlFtw library (https://github.com/sqlftw)
 *
 * Copyright (c) 2017 Vlasta Neubauer (@paranoiq)
 *
 * For the full copyright and license information read the file 'license.md', distributed with this source code
 */

namespace SqlFtw\Sql\Ddl\Compound;

use Dogma\Arr;
use Dogma\Check;
use Dogma\Type;
use SqlFtw\SqlFormatter\SqlFormatter;

class SignalStatement implements \SqlFtw\Sql\Statement
{
    use \Dogma\StrictBehaviorMixin;

    /** @var int|string */
    private $condition;

    /** @var int[]|string[]|null */
    private $items;

    public function __construct($condition, ?array $items)
    {
        Check::types($condition, [Type::INT, Type::STRING]);
        foreach ($items as $key => $value) {
            ConditionInformationItem::get($key);
        }
        $this->condition = $condition;
        $this->items = $items;
    }

    /**
     * @return int|string
     */
    public function getCondition()
    {
        return $this->condition;
    }

    /**
     * @return int[]|string[]|null
     */
    public function getItems(): ?array
    {
        return $this->items;
    }

    public function serialize(SqlFormatter $formatter): string
    {
        $result = 'SIGNAL';
        if ($this->condition !== null) {
            $result .= ' ' . (strlen($this->condition) > 4 ? 'SQLSTATE ' : '') . $formatter->formatString($this->condition);
        }
        if ($this->items !== null) {
            $result .= ' SET ' . implode(', ', Arr::mapPairs($this->items, function ($item, $value) use ($formatter): string {
                return $item . ' = ' . $formatter->formatValue($value);
            }));
        }

        return $result;
    }

}