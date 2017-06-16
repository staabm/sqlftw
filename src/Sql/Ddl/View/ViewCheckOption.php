<?php
/**
 * This file is part of the SqlFtw library (https://github.com/sqlftw)
 *
 * Copyright (c) 2017 Vlasta Neubauer (@paranoiq)
 *
 * For the full copyright and license information read the file 'license.md', distributed with this source code
 */

namespace SqlFtw\Sql\Ddl\View;

use SqlFtw\Sql\Keyword;

class ViewCheckOption extends \SqlFtw\Sql\SqlEnum
{

    public const CHECK_OPTION = Keyword::CHECK . ' ' . Keyword::OPTION;
    public const CASCADED_CHECK_OPTION = Keyword::CASCADED . ' ' . Keyword::CHECK . ' ' . Keyword::OPTION;
    public const LOCAL_CHECK_OPTION = Keyword::LOCAL . ' ' . Keyword::CHECK . ' ' . Keyword::OPTION;

}