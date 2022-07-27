<?php declare(strict_types = 1);
/**
 * This file is part of the SqlFtw library (https://github.com/sqlftw)
 *
 * Copyright (c) 2017 Vlasta Neubauer (@paranoiq)
 *
 * For the full copyright and license information read the file 'license.md', distributed with this source code
 */

namespace SqlFtw\Sql\Dal\Show;

use SqlFtw\Formatter\Formatter;
use SqlFtw\Sql\Expression\ObjectIdentifier;
use SqlFtw\Sql\Statement;

class ShowProcedureCodeCommand extends Statement implements ShowCommand
{

    /** @var ObjectIdentifier */
    private $name;

    public function __construct(ObjectIdentifier $name)
    {
        $this->name = $name;
    }

    public function getName(): ObjectIdentifier
    {
        return $this->name;
    }

    public function serialize(Formatter $formatter): string
    {
        return 'SHOW PROCEDURE CODE ' . $this->name->serialize($formatter);
    }

}
