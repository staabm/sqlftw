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

class UserPrivilegeResourceType extends \SqlFtw\Sql\SqlEnum
{

    public const TABLE = Keyword::TABLE;
    public const FUNCTION = Keyword::FUNCTION;
    public const PROCEDURE = Keyword::PROCEDURE;

}