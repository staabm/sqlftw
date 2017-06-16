<?php
/**
 * This file is part of the SqlFtw library (https://github.com/sqlftw)
 *
 * Copyright (c) 2017 Vlasta Neubauer (@paranoiq)
 *
 * For the full copyright and license information read the file 'license.md', distributed with this source code
 */

namespace SqlFtw\Sql\Dml\Insert;

use Dogma\Arr;
use SqlFtw\Sql\Expression\ExpressionNode;
use SqlFtw\Sql\Names\TableName;
use SqlFtw\SqlFormatter\SqlFormatter;

class InsertValuesCommand extends \SqlFtw\Sql\Dml\Insert\InsertOrReplaceCommand implements \SqlFtw\Sql\Dml\Insert\InsertCommand
{
    use \Dogma\StrictBehaviorMixin;

    /** @var \SqlFtw\Sql\Expression\ExpressionNode[][] */
    private $rows;

    /** @var \SqlFtw\Sql\Dml\Insert\OnDuplicateKeyActions|null */
    private $onDuplicateKeyActions;

    /**
     * @param \SqlFtw\Sql\Names\TableName $table
     * @param \SqlFtw\Sql\Expression\ExpressionNode[][] $rows
     * @param string[]|null $columns
     * @param string[]|null $partitions
     * @param \SqlFtw\Sql\Dml\Insert\InsertPriority|null $priority
     * @param bool $ignore
     * @param \SqlFtw\Sql\Dml\Insert\OnDuplicateKeyActions|null $onDuplicateKeyActions
     */
    public function __construct(
        TableName $table,
        array $rows,
        ?array $columns,
        ?array $partitions,
        ?InsertPriority $priority = null,
        bool $ignore = false,
        ?OnDuplicateKeyActions $onDuplicateKeyActions = null
    ) {
        parent::__construct($table, $columns, $partitions, $priority, $ignore);

        $this->rows = $rows;
        $this->onDuplicateKeyActions = $onDuplicateKeyActions;
    }

    /**
     * @return \SqlFtw\Sql\Expression\ExpressionNode[]|\SqlFtw\Sql\Expression\ExpressionNode[][]
     */
    public function getRows(): array
    {
        return $this->rows;
    }

    public function getOnDuplicateKeyAction(): ?OnDuplicateKeyActions
    {
        return $this->onDuplicateKeyActions;
    }

    public function serialize(SqlFormatter $formatter): string
    {
        $result = 'INSERT' . $this->serializeBody($formatter);

        $result .= implode(', ', Arr::map($this->rows, function (array $values) use ($formatter): string {
            return '(' . implode(', ', Arr::map($values, function (ExpressionNode $value) use ($formatter): string {
                return $value->serialize($formatter);
            })) . ')';
        }));

        if ($this->onDuplicateKeyActions !== null) {
            $result .= ' ' . $this->onDuplicateKeyActions->serialize($formatter);
        }

        return $result;
    }

}