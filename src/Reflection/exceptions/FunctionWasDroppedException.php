<?php declare(strict_types = 1);
/**
 * This file is part of the SqlFtw library (https://github.com/sqlftw)
 *
 * Copyright (c) 2017 Vlasta Neubauer (@paranoiq)
 *
 * For the full copyright and license information read the file 'license.md', distributed with this source code
 */

namespace SqlFtw\Reflection;

use function sprintf;

class FunctionWasDroppedException extends FunctionDoesNotExistException
{

    /** @var \SqlFtw\Reflection\FunctionReflection */
    private $reflection;

    public function __construct(FunctionReflection $reflection, ?\Throwable $previous = null)
    {
        $name = $reflection->getName()->getName();
        $schema = $reflection->getName()->getSchema();

        parent::__construct($name, $schema, $previous);

        $this->message = sprintf('Function `%s`.`%s` was dropped by previous command.', $schema, $name);
        $this->reflection = $reflection;
    }

    public function getReflection(): FunctionReflection
    {
        return $this->reflection;
    }

}