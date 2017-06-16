<?php
/**
 * This file is part of the SqlFtw library (https://github.com/sqlftw)
 *
 * Copyright (c) 2017 Vlasta Neubauer (@paranoiq)
 *
 * For the full copyright and license information read the file 'license.md', distributed with this source code
 */

namespace SqlFtw\Sql\Dml\Select;

use Dogma\Check;
use SqlFtw\Sql\Dml\OrderByExpression;
use SqlFtw\Sql\Dml\TableReference;
use SqlFtw\Sql\Expression\ExpressionNode;
use SqlFtw\SqlFormatter\SqlFormatter;

class SelectCommand implements \SqlFtw\Sql\Command
{
    use \Dogma\StrictBehaviorMixin;

    /** @var \SqlFtw\Sql\Dml\Select\SelectExpression[] */
    private $columns;

    /** @var \SqlFtw\Sql\Dml\TableReference[] */
    private $from;

    /** @var \SqlFtw\Sql\Expression\ExpressionNode|null */
    private $where;

    /** @var \SqlFtw\Sql\Dml\Select\GroupByExpression[]|null */
    private $groupBy;

    /** @var \SqlFtw\Sql\Expression\ExpressionNode|null */
    private $having;

    /** @var \SqlFtw\Sql\Dml\OrderByExpression[]|null */
    private $orderBy;

    /** @var int|null */
    private $limit;

    /** @var int|null */
    private $offset;

    /** @var \SqlFtw\Sql\Dml\Select\SelectDistinctOption|null */
    private $distinct;

    /** @var bool[] */
    private $options;

    /** @var \SqlFtw\Sql\Dml\Select\SelectInto|null */
    private $into;

    /** @var \SqlFtw\Sql\Dml\Select\SelectLocking|null */
    private $locking;

    /** @var bool */
    private $withRollup;

    /**
     * @param \SqlFtw\Sql\Dml\Select\SelectExpression[] $columns
     * @param \SqlFtw\Sql\Dml\TableReference[] $from
     * @param \SqlFtw\Sql\Expression\ExpressionNode|null $where
     * @param \SqlFtw\Sql\Dml\Select\GroupByExpression[]|null $groupBy
     * @param \SqlFtw\Sql\Expression\ExpressionNode|null $having
     * @param \SqlFtw\Sql\Dml\OrderByExpression[]|null $orderBy
     * @param int|null $limit
     * @param int|null $offset
     * @param \SqlFtw\Sql\Dml\Select\SelectDistinctOption|null $distinct
     * @param bool[] $options
     * @param \SqlFtw\Sql\Dml\Select\SelectInto|null $into
     * @param \SqlFtw\Sql\Dml\Select\SelectLocking|null $locking
     * @param bool $withRollup
     */
    public function __construct(
        array $columns,
        array $from,
        ?ExpressionNode $where = null,
        ?array $groupBy = null,
        ?ExpressionNode $having = null,
        ?array $orderBy = null,
        ?int $limit = null,
        ?int $offset = null,
        ?SelectDistinctOption $distinct = null,
        array $options = [],
        ?SelectInto $into = null,
        ?SelectLocking $locking = null,
        bool $withRollup = false
    ) {
        Check::itemsOfType($columns, SelectExpression::class);
        Check::itemsOfType($from, TableReference::class);
        if ($groupBy !== null) {
            Check::itemsOfType($groupBy, GroupByExpression::class);
        } elseif ($withRollup === true) {
            throw new \SqlFtw\Sql\InvalidDefinitionException('WITH ROLLUP can be used only with GROUP BY.');
        }
        if ($orderBy !== null) {
            Check::itemsOfType($orderBy, OrderByExpression::class);
        }
        foreach ($options as $option => $value) {
            SelectOption::get($option);
        }

        $this->columns = $columns;
        $this->from = $from;
        $this->where = $where;
        $this->groupBy = $groupBy;
        $this->having = $having;
        $this->orderBy = $orderBy;
        $this->limit = $limit;
        $this->offset = $offset;
        $this->distinct = $distinct;
        $this->options = $options;
        $this->into = $into;
        $this->locking = $locking;
        $this->withRollup = $withRollup;
    }

    /**
     * @return \SqlFtw\Sql\Dml\Select\SelectExpression[]
     */
    public function getColumns(): array
    {
        return $this->columns;
    }

    /**
     * @return \SqlFtw\Sql\Dml\TableReference[]
     */
    public function getFrom(): array
    {
        return $this->from;
    }

    public function getWhere(): ?ExpressionNode
    {
        return $this->where;
    }

    /**
     * @return \SqlFtw\Sql\Dml\Select\GroupByExpression[]|null
     */
    public function getGroupBy(): ?array
    {
        return $this->groupBy;
    }

    public function withRollup(): bool
    {
        return $this->withRollup;
    }

    public function getHaving(): ?ExpressionNode
    {
        return $this->having;
    }

    /**
     * @return \SqlFtw\Sql\Dml\OrderByExpression[]|null
     */
    public function getOrderBy(): ?array
    {
        return $this->orderBy;
    }

    public function getLimit(): ?int
    {
        return $this->limit;
    }

    public function getOffset(): ?int
    {
        return $this->offset;
    }

    public function getDistinct(): ?SelectDistinctOption
    {
        return $this->distinct;
    }

    /**
     * @return bool[]
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    public function getInto(): ?SelectInto
    {
        return $this->into;
    }

    public function getLocking(): ?SelectLocking
    {
        return $this->locking;
    }

    public function serialize(SqlFormatter $formatter): string
    {
        $result = 'SELECT';
        if ($this->distinct !== null) {
            $result .= ' ' . $this->distinct->serialize($formatter);
        }
        foreach ($this->options as $option => $value) {
            if ($value) {
                $result .= ' ' . $option;
            }
        }

        $result .= ' ' . $formatter->formatSerializablesList($this->columns);
        $result .= ' FROM ' . $formatter->formatSerializablesList($this->from);

        if ($this->where !== null) {
            $result .= ' WHERE ' . $this->where->serialize($formatter);
        }
        if ($this->groupBy !== null) {
            $result .= ' GROUP BY ' . $formatter->formatSerializablesList($this->groupBy);
        }
        if ($this->having !== null) {
            $result .= ' HAVING ' . $this->having->serialize($formatter);
        }
        if ($this->orderBy !== null) {
            $result .= ' ORDER BY ' . $formatter->formatSerializablesList($this->orderBy);
        }
        if ($this->limit !== null) {
            $result .= ' LIMIT ' . $this->limit;
            if ($this->offset !== null) {
                $result .= ' OFFSET ' . $this->offset;
            }
        }
        if ($this->into !== null) {
            $result .= ' ' . $this->into->serialize($formatter);
        }
        if ($this->locking !== null) {
            $result .= ' ' . $this->locking->serialize($formatter);
        }

        return $result;
    }

}