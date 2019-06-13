<?php declare(strict_types = 1);
/**
 * This file is part of the SqlFtw library (https://github.com/sqlftw)
 *
 * Copyright (c) 2017 Vlasta Neubauer (@paranoiq)
 *
 * For the full copyright and license information read the file 'license.md', distributed with this source code
 */

namespace SqlFtw\Sql\Dal\User;

use Dogma\StrictBehaviorMixin;
use SqlFtw\Formatter\Formatter;
use SqlFtw\Sql\UserName;

class GrantCommand implements UserCommand
{
    use StrictBehaviorMixin;

    /** @var \SqlFtw\Sql\Dal\User\UserPrivilege[] */
    private $privileges;

    /** @var \SqlFtw\Sql\Dal\User\UserPrivilegeResource */
    private $resource;

    /** @var \SqlFtw\Sql\Dal\User\IdentifiedUser[] */
    private $users;

    /** @var \SqlFtw\Sql\UserName|null */
    private $asUser;

    /** @var \SqlFtw\Sql\Dal\User\RolesSpecification|null */
    private $withRole;

    /** @var \SqlFtw\Sql\Dal\User\UserTlsOption[]|null */
    private $tlsOptions;

    /** @var \SqlFtw\Sql\Dal\User\UserResourceOption[]|null */
    private $resourceOptions;

    /** @var bool */
    private $withGrantOption;

    /**
     * @param \SqlFtw\Sql\Dal\User\UserPrivilege[] $privileges
     * @param \SqlFtw\Sql\Dal\User\UserPrivilegeResource $resource
     * @param \SqlFtw\Sql\Dal\User\IdentifiedUser[] $users
     * @param \SqlFtw\Sql\UserName|null $asUser
     * @param \SqlFtw\Sql\Dal\User\RolesSpecification|null $withRole
     * @param \SqlFtw\Sql\Dal\User\UserTlsOption[]|null $tlsOptions
     * @param \SqlFtw\Sql\Dal\User\UserResourceOption[]|null $resourceOptions
     * @param bool $withGrantOption
     */
    public function __construct(
        array $privileges,
        UserPrivilegeResource $resource,
        array $users,
        ?UserName $asUser = null,
        ?RolesSpecification $withRole = null,
        ?array $tlsOptions = null,
        ?array $resourceOptions = null,
        bool $withGrantOption = false
    ) {
        $this->privileges = $privileges;
        $this->resource = $resource;
        $this->users = $users;
        $this->asUser = $asUser;
        $this->withRole = $withRole;
        $this->tlsOptions = $tlsOptions;
        $this->resourceOptions = $resourceOptions;
        $this->withGrantOption = $withGrantOption;
    }

    /**
     * @return \SqlFtw\Sql\Dal\User\UserPrivilege[]
     */
    public function getPrivileges(): array
    {
        return $this->privileges;
    }

    public function getResource(): UserPrivilegeResource
    {
        return $this->resource;
    }

    /**
     * @return \SqlFtw\Sql\Dal\User\IdentifiedUser[]
     */
    public function getUsers(): array
    {
        return $this->users;
    }

    public function getAsUser(): ?UserName
    {
        return $this->asUser;
    }

    public function getWithRole(): ?RolesSpecification
    {
        return $this->withRole;
    }

    /**
     * @return \SqlFtw\Sql\Dal\User\UserTlsOption[]|null
     */
    public function getTlsOptions(): ?array
    {
        return $this->tlsOptions;
    }

    /**
     * @return \SqlFtw\Sql\Dal\User\UserResourceOption[]|null
     */
    public function getResourceOptions(): ?array
    {
        return $this->resourceOptions;
    }

    public function withGrantOption(): bool
    {
        return $this->withGrantOption;
    }

    public function serialize(Formatter $formatter): string
    {
        $result = 'GRANT ' . $formatter->formatSerializablesList($this->privileges)
            . ' ON ' . $this->resource->serialize($formatter)
            . ' TO ' . $formatter->formatSerializablesList($this->users);

        if ($this->tlsOptions !== null) {
            $result .= ' REQUIRE';
            if ($this->tlsOptions === []) {
                $result .= ' NONE';
            } else {
                $result .= $formatter->formatSerializablesList($this->tlsOptions);
            }
        }
        if ($this->withGrantOption) {
            $result .= ' WITH GRANT OPTION';
        }
        if ($this->resourceOptions !== null) {
            $result .= ' WITH ' . $formatter->formatSerializablesList($this->resourceOptions);
        }
        if ($this->asUser !== null) {
            $result .= ' AS ' . $this->asUser->serialize($formatter);
            if ($this->withRole !== null) {
                $result .= ' WITH ROLE ' . $this->withRole->serialize($formatter);
            }
        }

        return $result;
    }

}
