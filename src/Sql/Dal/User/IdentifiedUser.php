<?php
/**
 * This file is part of the SqlFtw library (https://github.com/sqlftw)
 *
 * Copyright (c) 2017 Vlasta Neubauer (@paranoiq)
 *
 * For the full copyright and license information read the file 'license.md', distributed with this source code
 */

namespace SqlFtw\Sql\Dal\User;

use SqlFtw\Sql\Names\UserName;
use SqlFtw\SqlFormatter\SqlFormatter;

class IdentifiedUser implements \SqlFtw\Sql\SqlSerializable
{
    use \Dogma\StrictBehaviorMixin;

    /** @var \SqlFtw\Sql\Names\UserName */
    private $user;

    /** @var string|null */
    private $password;

    /** @var string|null */
    private $plugin;

    /** @var string|null */
    private $hash;

    public function __construct(UserName $user, ?string $password, ?string $plugin, ?string $hash)
    {
        $this->user = $user;
        $this->password = $password;
        $this->plugin = $plugin;
        $this->hash = $hash;
    }

    public function getUser(): UserName
    {
        return $this->user;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function getPlugin(): ?string
    {
        return $this->plugin;
    }

    public function getHash(): ?string
    {
        return $this->hash;
    }

    public function serialize(SqlFormatter $formatter): string
    {
        $result = $this->user->serialize($formatter);
        if ($this->plugin !== null || $this->password !== null) {
            $result .= ' IDENTIFIED';
            if ($this->plugin !== null) {
                $result .= ' WITH ' . $formatter->formatString($this->plugin);
            }
            if ($this->password !== null) {
                $result .= ' BY ' . $formatter->formatString($this->password);
            } elseif ($this->hash !== null) {
                $result .= ' AS ' . $formatter->formatString($this->hash);
            }
        } elseif ($this->hash !== null) {
            $result .= ' IDENTIFIED BY PASSWORD ' . $formatter->formatString($this->hash);
        }

        return $result;
    }

}