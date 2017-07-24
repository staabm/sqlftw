<?php
/**
 * This file is part of the SqlFtw library (https://github.com/sqlftw)
 *
 * Copyright (c) 2017 Vlasta Neubauer (@paranoiq)
 *
 * For the full copyright and license information read the file 'license.md', distributed with this source code
 */

namespace SqlFtw\Sql\Dml\TableReference;

use SqlFtw\SqlFormatter\SqlFormatter;

class EscapedTableReference implements \SqlFtw\Sql\Dml\TableReference\TableReferenceNode
{
    use \Dogma\StrictBehaviorMixin;

    /** @var \SqlFtw\Sql\Dml\TableReference\TableReferenceNode */
    private $node;

    public function __construct(TableReferenceNode $node)
    {
        $this->node = $node;
    }

    public function getType(): TableReferenceNodeType
    {
        return TableReferenceNodeType::get(TableReferenceNodeType::ESCAPED);
    }

    public function getNode(): TableReferenceNode
    {
        return $this->node;
    }

    public function serialize(SqlFormatter $formatter): string
    {
        return '{ OJ ' . $this->node->serialize($formatter) . ' }';
    }

}