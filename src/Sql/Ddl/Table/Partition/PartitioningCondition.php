<?php
/**
 * This file is part of the SqlFtw library (https://github.com/sqlftw)
 *
 * Copyright (c) 2017 Vlasta Neubauer (@paranoiq)
 *
 * For the full copyright and license information read the file 'license.md', distributed with this source code
 */

namespace SqlFtw\Sql\Ddl\Table\Partition;

use SqlFtw\Sql\Expression\ExpressionNode;
use SqlFtw\SqlFormatter\SqlFormatter;

class PartitioningCondition implements \SqlFtw\Sql\SqlSerializable
{
    use \Dogma\StrictBehaviorMixin;

    /** @var \SqlFtw\Sql\Ddl\Table\Partition\PartitioningConditionType */
    private $type;

    /** @var \SqlFtw\Sql\Expression\ExpressionNode|null */
    private $expression;

    /** @var string[]|null */
    private $columns;

    /** @var int|null */
    private $algorithm;

    /**
     * @param \SqlFtw\Sql\Ddl\Table\Partition\PartitioningConditionType $type
     * @param \SqlFtw\Sql\Expression\ExpressionNode|null $expression
     * @param string[]|null $columns
     * @param int|null $algorithm
     */
    public function __construct(
        PartitioningConditionType $type,
        ?ExpressionNode $expression,
        ?array $columns = null,
        ?int $algorithm = null
    ) {
        $this->type = $type;
        $this->expression = $expression;
        $this->columns = $columns;
        $this->algorithm = $algorithm;
    }

    public function getType(): PartitioningConditionType
    {
        return $this->type;
    }

    public function getExpression(): ?ExpressionNode
    {
        return $this->expression;
    }

    /**
     * @return string[]|null
     */
    public function getColumns(): ?array
    {
        return $this->columns;
    }

    public function getAlgorithm(): ?int
    {
        return $this->algorithm;
    }

    public function serialize(SqlFormatter $formatter): string
    {
        $result = $this->type->serialize($formatter);
        if ($this->expression !== null) {
            $result .= '(' . $this->expression->serialize($formatter) . ')';
        }
        if ($this->algorithm !== null) {
            $result .= ' ALGORITHM = ' . $this->algorithm . ' ';
        }
        if ($this->columns !== null) {
            if ($this->type->equals(PartitioningConditionType::RANGE) || $this->type->equals(PartitioningConditionType::LIST)) {
                $result .= ' COLUMNS';
            }
            $result .= '(' . $formatter->formatNamesList($this->columns) . ')';
        }

        return $result;
    }

}