<?php
/**
 * This file is part of the SqlFtw library (https://github.com/sqlftw)
 *
 * Copyright (c) 2017 Vlasta Neubauer (@paranoiq)
 *
 * For the full copyright and license information read the file 'license.md', distributed with this source code
 */

namespace SqlFtw\Sql\Ddl\Compound;

use SqlFtw\Sql\Ddl\DataType;
use SqlFtw\SqlFormatter\SqlFormatter;

class DeclareStatement implements \SqlFtw\Sql\Statement
{
    use \Dogma\StrictBehaviorMixin;

    /** @var string[] */
    private $names;

    /** @var \SqlFtw\Sql\Ddl\DataType */
    private $type;

    /** @var string|int|float|bool|null */
    private $default;

    public function __construct(array $names, DataType $type, $default = null)
    {
        $this->names = $names;
        $this->type = $type;
        $this->default = $default;
    }

    /**
     * @return string[]
     */
    public function getNames(): array
    {
        return $this->names;
    }

    public function getType(): DataType
    {
        return $this->type;
    }

    /**
     * @return string|int|float|bool|null
     */
    public function getDefault()
    {
        return $this->default;
    }

    public function serialize(SqlFormatter $formatter): string
    {
        $result = 'DECLARE ' . $formatter->formatNamesList($this->names) . ' ' . $this->type->serialize($formatter);
        if ($this->default !== null) {
            $result .= ' DEFAULT ' . $formatter->formatValue($this->default);
        }

        return $result;
    }

}