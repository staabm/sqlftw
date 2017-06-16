<?php
/**
 * This file is part of the SqlFtw library (https://github.com/sqlftw)
 *
 * Copyright (c) 2017 Vlasta Neubauer (@paranoiq)
 *
 * For the full copyright and license information read the file 'license.md', distributed with this source code
 */

namespace SqlFtw\Sql\Dml\Utility;

use SqlFtw\Sql\Keyword;

class ExplainType extends \SqlFtw\Sql\SqlEnum
{

    public const EXTENDED = Keyword::EXTENDED;
    public const PARTITIONS = Keyword::PARTITIONS;
    public const FORMAT_TRADITIONAL = Keyword::FORMAT . ' = ' . Keyword::TRADITIONAL;
    public const FORMAT_JSON = Keyword::FORMAT . ' = ' . Keyword::JSON;

}