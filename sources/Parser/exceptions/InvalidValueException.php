<?php declare(strict_types = 1);
/**
 * This file is part of the SqlFtw library (https://github.com/sqlftw)
 *
 * Copyright (c) 2017 Vlasta Neubauer (@paranoiq)
 *
 * For the full copyright and license information read the file 'license.md', distributed with this source code
 */

namespace SqlFtw\Parser;

use Throwable;

class InvalidValueException extends ParserException
{

    /** @var string */
    public $expectedType;

    public function __construct(string $expectedType, TokenList $tokenList, ?Throwable $previous = null)
    {
        $value = $tokenList->getLast();

        parent::__construct("Invalid value $value->original for type $expectedType.", $tokenList, $previous);

        $this->expectedType = $expectedType;
    }

}
