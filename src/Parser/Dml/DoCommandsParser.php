<?php
/**
 * This file is part of the SqlFtw library (https://github.com/sqlftw)
 *
 * Copyright (c) 2017 Vlasta Neubauer (@paranoiq)
 *
 * For the full copyright and license information read the file 'license.md', distributed with this source code
 */

namespace SqlFtw\Parser\Dml;

use SqlFtw\Sql\Dml\DoCommand\DoCommand;
use SqlFtw\Sql\Keyword;
use SqlFtw\Parser\ExpressionParser;
use SqlFtw\Parser\TokenList;
use SqlFtw\Parser\TokenType;

class DoCommandsParser
{
    use \Dogma\StrictBehaviorMixin;

    /** @var \SqlFtw\Parser\ExpressionParser */
    private $expressionParser;

    public function __construct(ExpressionParser $expressionParser)
    {
        $this->expressionParser = $expressionParser;
    }

    /**
     * DO expr [, expr] ...
     */
    public function parseDo(TokenList $tokenList): DoCommand
    {
        $tokenList->consumeKeyword(Keyword::DO);

        $expressions = [];
        do {
            $expressions[] = $this->expressionParser->parseExpression($tokenList);
        } while ($tokenList->mayConsumeComma());

        return new DoCommand($expressions);
    }

}