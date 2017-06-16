<?php
/**
 * This file is part of the SqlFtw library (https://github.com/paranoiq/dogma)
 *
 * Copyright (c) 2017 Vlasta Neubauer (@paranoiq)
 *
 * For the full copyright and license information read the file 'license.md', distributed with this source code
 */

namespace SqlFtw\Sql\Ddl\Trigger;

use SqlFtw\Sql\Keyword;

class TriggerEvent extends \SqlFtw\Sql\SqlEnum
{

    public const BEFORE_INSERT = Keyword::BEFORE . ' ' . Keyword::INSERT;
    public const AFTER_INSERT = Keyword::AFTER . ' ' . Keyword::INSERT;
    public const BEFORE_UPDATE = Keyword::BEFORE . ' ' . Keyword::UPDATE;
    public const AFTER_UPDATE = Keyword::AFTER . ' ' . Keyword::UPDATE;
    public const BEFORE_DELETE = Keyword::BEFORE . ' ' . Keyword::DELETE;
    public const AFTER_DELETE = Keyword::AFTER . ' ' . Keyword::DELETE;

}