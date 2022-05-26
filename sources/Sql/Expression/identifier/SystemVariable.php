<?php declare(strict_types = 1);
/**
 * This file is part of the SqlFtw library (https://github.com/sqlftw)
 *
 * Copyright (c) 2017 Vlasta Neubauer (@paranoiq)
 *
 * For the full copyright and license information read the file 'license.md', distributed with this source code
 */

namespace SqlFtw\Sql\Expression;

use Dogma\StrictBehaviorMixin;
use SqlFtw\Formatter\Formatter;
use SqlFtw\Sql\InvalidDefinitionException;
use SqlFtw\Sql\MysqlVariable;

class SystemVariable implements Identifier
{
    use StrictBehaviorMixin;

    /** @var string */
    private $name;

    /** @var Scope|null */
    private $scope;

    public function __construct(string $name, ?Scope $scope = null)
    {
        if (!MysqlVariable::isValid($name)) {
            throw new InvalidDefinitionException("Invalid system variable name '$name'.");
        }

        $this->name = $name;
        $this->scope = $scope;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getScope(): ?Scope
    {
        return $this->scope;
    }

    public function getFullName(): string
    {
        return ($this->scope !== null ? '@@' . $this->scope->getValue() . '.' : '@@') . $this->name;
    }

    public function serialize(Formatter $formatter): string
    {
        return ($this->scope !== null ? '@@' . $this->scope->getValue() . '.' : '@@') . $this->name;
    }

}