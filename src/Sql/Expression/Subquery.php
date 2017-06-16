<?php
/**
 * This file is part of the SqlFtw library (https://github.com/sqlftw)
 *
 * Copyright (c) 2017 Vlasta Neubauer (@paranoiq)
 *
 * For the full copyright and license information read the file 'license.md', distributed with this source code
 */

namespace SqlFtw\Sql\Expression;

use SqlFtw\Sql\Dml\Select\SelectCommand;
use SqlFtw\Sql\NodeType;
use SqlFtw\SqlFormatter\SqlFormatter;

class Subquery implements \SqlFtw\Sql\Expression\ExpressionNode
{
    use \Dogma\StrictBehaviorMixin;

    /** @var \SqlFtw\Sql\Dml\Select\SelectCommand */
    private $subquery;

    public function __construct(SelectCommand $subquery)
    {
        $this->subquery = $subquery;
    }

    public function getType(): NodeType
    {
        return NodeType::get(NodeType::SUBQUERY);
    }

    public function getSubquery(): SelectCommand
    {
        return $this->subquery;
    }

    public function serialize(SqlFormatter $formatter): string
    {
        return $this->subquery->serialize($formatter);
    }

}