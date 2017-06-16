<?php
/**
 * This file is part of the SqlFtw library (https://github.com/sqlftw)
 *
 * Copyright (c) 2017 Vlasta Neubauer (@paranoiq)
 *
 * For the full copyright and license information read the file 'license.md', distributed with this source code
 */

namespace SqlFtw\Sql\Dml\XaTransaction;

use SqlFtw\SqlFormatter\SqlFormatter;

class XaRecoverCommand implements \SqlFtw\Sql\Command
{
    use \Dogma\StrictBehaviorMixin;

    /** @var bool */
    private $convertXid;

    public function __construct(bool $convertXid = false)
    {
        $this->convertXid = $convertXid;
    }

    public function convertXid(): bool
    {
        return $this->convertXid;
    }

    public function serialize(SqlFormatter $formatter): string
    {
        return 'XA RECOVER' . ($this->convertXid ? ' CONVERT XID' : '');
    }

}