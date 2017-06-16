<?php
/**
 * This file is part of the SqlFtw library (https://github.com/sqlftw)
 *
 * Copyright (c) 2017 Vlasta Neubauer (@paranoiq)
 *
 * For the full copyright and license information read the file 'license.md', distributed with this source code
 */

namespace SqlFtw\Sql\Dal\User;

use SqlFtw\SqlFormatter\SqlFormatter;

class UserResourceOption implements \SqlFtw\Sql\SqlSerializable
{
    use \Dogma\StrictBehaviorMixin;

    /** @var \SqlFtw\Sql\Dal\User\UserResourceOptionType */
    private $type;

    /** @var int */
    private $value;

    public function __construct(UserResourceOptionType $type, int $value)
    {
        $this->type = $type;
        $this->value = $value;
    }

    public function getType(): UserResourceOptionType
    {
        return $this->type;
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function serialize(SqlFormatter $formatter): string
    {
        return $this->type->serialize($formatter) . ' ' . $this->value;
    }

}