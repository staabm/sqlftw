<?php
/**
 * This file is part of the SqlFtw library (https://github.com/sqlftw)
 *
 * Copyright (c) 2017 Vlasta Neubauer (@paranoiq)
 *
 * For the full copyright and license information read the file 'license.md', distributed with this source code
 */

namespace SqlFtw\Sql\Dal\User;

use SqlFtw\Sql\Keyword;

class UserResourceOptionType extends \SqlFtw\Sql\SqlEnum
{

    public const MAX_QUERIES_PER_HOUR = Keyword::MAX_QUERIES_PER_HOUR;
    public const MAX_UPDATES_PER_HOUR = Keyword::MAX_UPDATES_PER_HOUR;
    public const MAX_CONNECTIONS_PER_HOUR = Keyword::MAX_CONNECTIONS_PER_HOUR;
    public const MAX_USER_CONNECTIONS = Keyword::MAX_USER_CONNECTIONS;

}