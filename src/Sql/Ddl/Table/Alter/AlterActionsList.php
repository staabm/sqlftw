<?php
/**
 * This file is part of the SqlFtw library (https://github.com/sqlftw)
 *
 * Copyright (c) 2017 Vlasta Neubauer (@paranoiq)
 *
 * For the full copyright and license information read the file 'license.md', distributed with this source code
 */

namespace SqlFtw\Sql\Ddl\Table\Alter;

use Dogma\Check;
use SqlFtw\SqlFormatter\SqlFormatter;

class AlterActionsList implements \SqlFtw\Sql\SqlSerializable
{
    use \Dogma\StrictBehaviorMixin;

    /** @var \SqlFtw\Sql\Ddl\Table\Alter\AlterTableAction[] */
    private $actions;

    public function __construct(array $actions)
    {
        Check::itemsOfType($actions, AlterTableAction::class);

        $this->actions = $actions;
    }

    /**
     * @return \SqlFtw\Sql\Ddl\Table\Alter\AlterTableAction[]
     */
    public function getActions(): array
    {
        return $this->actions;
    }

    public function serialize(SqlFormatter $formatter): string
    {
        return $formatter->formatSerializablesList($this->actions, ",\n");
    }

}