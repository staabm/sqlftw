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

class ShowCreateFunctionCommand extends Statement implements ShowCommand
{

    /** @var ObjectIdentifier */
    private $function;

    public function __construct(ObjectIdentifier $function)
    {
        $this->function = $function;
    }

    public function getFunction(): ObjectIdentifier
    {
        return $this->function;
    }

    public function serialize(Formatter $formatter): string
    {
        return 'SHOW CREATE FUNCTION ' . $this->function->serialize($formatter);
    }

}
