<?php
/**
 * This file is part of the SqlFtw library (https://github.com/sqlftw)
 *
 * Copyright (c) 2017 Vlasta Neubauer (@paranoiq)
 *
 * For the full copyright and license information read the file 'license.md', distributed with this source code
 */

namespace SqlFtw\Sql\Dal\Show;

use SqlFtw\SqlFormatter\SqlFormatter;

class ShowMasterStatusCommand extends \SqlFtw\Sql\Dal\Show\ShowCommand
{

    public function serialize(SqlFormatter $formatter): string
    {
        return 'SHOW MASTER STATUS';
    }

}