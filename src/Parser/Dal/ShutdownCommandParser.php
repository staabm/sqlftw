<?php
/**
 * This file is part of the SqlFtw library (https://github.com/sqlftw)
 *
 * Copyright (c) 2017 Vlasta Neubauer (@paranoiq)
 *
 * For the full copyright and license information read the file 'license.md', distributed with this source code
 */

namespace SqlFtw\Parser\Dal;

use SqlFtw\Sql\Dal\Shutdown\ShutdownCommand;
use SqlFtw\Sql\Keyword;
use SqlFtw\Parser\TokenList;

class ShutdownCommandParser
{
    use \Dogma\StrictBehaviorMixin;

    /**
     * SHUTDOWN
     */
    public function parseShutdown(TokenList $tokenList): ShutdownCommand
    {
        $tokenList->consumeKeyword(Keyword::SHUTDOWN);

        return new ShutdownCommand();
    }

}