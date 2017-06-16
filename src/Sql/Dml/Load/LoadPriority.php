<?php
/**
 * This file is part of the SqlFtw library (https://github.com/sqlftw)
 *
 * Copyright (c) 2017 Vlasta Neubauer (@paranoiq)
 *
 * For the full copyright and license information read the file 'license.md', distributed with this source code
 */

namespace SqlFtw\Sql\Dml\Load;

use SqlFtw\Sql\Keyword;

class LoadPriority extends \SqlFtw\Sql\SqlEnum
{

    public const LOW_PRIORITY = Keyword::LOW_PRIORITY;
    public const CONCURRENT = Keyword::CONCURRENT;

}