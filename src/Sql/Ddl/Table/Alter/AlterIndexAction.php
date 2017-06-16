<?php
/**
 * This file is part of the SqlFtw library (https://github.com/sqlftw)
 *
 * Copyright (c) 2017 Vlasta Neubauer (@paranoiq)
 *
 * For the full copyright and license information read the file 'license.md', distributed with this source code
 */

namespace SqlFtw\Sql\Ddl\Table\Alter;

use SqlFtw\SqlFormatter\SqlFormatter;

class AlterIndexAction implements \SqlFtw\Sql\Ddl\Table\Alter\AlterTableAction
{
    use \Dogma\StrictBehaviorMixin;

    /** @var string */
    private $name;

    /** @var bool */
    private $visible;

    public function __construct(string $name, bool $visible)
    {
        $this->name = $name;
        $this->visible = $visible;
    }

    public function getType(): AlterTableActionType
    {
        return AlterTableActionType::get(AlterTableActionType::ALTER_INDEX);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function visible(): bool
    {
        return $this->visible;
    }

    public function serialize(SqlFormatter $formatter): string
    {
        return 'ALTER INDEX ' . $formatter->formatName($this->name) . ($this->visible ? ' VISIBLE' : ' INVISIBLE');
    }

}