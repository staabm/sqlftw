<?php
/**
 * This file is part of the SqlFtw library (https://github.com/sqlftw)
 *
 * Copyright (c) 2017 Vlasta Neubauer (@paranoiq)
 *
 * For the full copyright and license information read the file 'license.md', distributed with this source code
 */

namespace SqlFtw\Sql\Expression;

use SqlFtw\Sql\NodeType;
use SqlFtw\SqlFormatter\SqlFormatter;

class ListExpression implements \SqlFtw\Sql\Expression\ExpressionNode
{
    use \Dogma\StrictBehaviorMixin;

    /** @var \SqlFtw\Sql\Expression\ExpressionNode[] */
    private $items;

    /**
     * @param \SqlFtw\Sql\Expression\ExpressionNode[] $items
     */
    public function __construct(array $items)
    {
        $this->items = $items;
    }

    public function getType(): NodeType
    {
        return NodeType::get(NodeType::LIST);
    }

    /**
     * @return \SqlFtw\Sql\Expression\ExpressionNode[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    public function serialize(SqlFormatter $formatter): string
    {
        return $formatter->formatSerializablesList($this->items);
    }

}