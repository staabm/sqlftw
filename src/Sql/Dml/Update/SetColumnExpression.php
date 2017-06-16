<?php
/**
 * This file is part of the SqlFtw library (https://github.com/sqlftw)
 *
 * Copyright (c) 2017 Vlasta Neubauer (@paranoiq)
 *
 * For the full copyright and license information read the file 'license.md', distributed with this source code
 */

namespace SqlFtw\Sql\Dml\Update;

use SqlFtw\Sql\Expression\ExpressionNode;
use SqlFtw\Sql\Names\ColumnName;
use SqlFtw\SqlFormatter\SqlFormatter;

class SetColumnExpression implements \SqlFtw\Sql\SqlSerializable
{
    use \Dogma\StrictBehaviorMixin;

    /** @var \SqlFtw\Sql\Names\ColumnName */
    private $column;

    /** @var \SqlFtw\Sql\Expression\ExpressionNode|null */
    private $value;

    /** @var bool */
    private $default;

    public function __construct(ColumnName $column, ?ExpressionNode $value = null, bool $default = false)
    {
        if (($value === null && $default === false) || ($value !== null && $default === true)) {
            throw new \SqlFtw\Sql\InvalidDefinitionException('Either a value expression or default must be set, but not both at once.');
        }
        $this->column = $column;
        $this->value = $value;
        $this->default = $default;
    }

    public function getColumn(): ColumnName
    {
        return $this->column;
    }

    public function getValue(): ?ExpressionNode
    {
        return $this->value;
    }

    public function getDefault(): bool
    {
        return $this->default;
    }

    public function serialize(SqlFormatter $formatter): string
    {
        $result = $this->column->serialize($formatter);
        if ($this->value !== null) {
            $result .= ' = ' . $this->value->serialize($formatter);
        } else {
            $result .= ' = DEFAULT';
        }

        return $result;
    }


}