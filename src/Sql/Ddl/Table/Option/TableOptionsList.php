<?php
/**
 * This file is part of the SqlFtw library (https://github.com/sqlftw)
 *
 * Copyright (c) 2017 Vlasta Neubauer (@paranoiq)
 *
 * For the full copyright and license information read the file 'license.md', distributed with this source code
 */

namespace SqlFtw\Sql\Ddl\Table\Option;

use Dogma\Arr;
use Dogma\Check;
use SqlFtw\Sql\Charset;
use SqlFtw\Sql\Keyword;
use SqlFtw\Sql\SqlSerializable;
use SqlFtw\SqlFormatter\SqlFormatter;

class TableOptionsList
{
    use \Dogma\StrictBehaviorMixin;

    /** @var mixed[] */
    private $options = [];

    /**
     * @param mixed[] $options (string $name => mixed $value)
     */
    public function __construct(array $options)
    {
        $types = TableOption::getTypes();

        foreach ($options as $option => $value) {
            if (is_int($option)) {
                switch (true) {
                    case $value instanceof StorageEngine:
                        $this->options[TableOption::ENGINE] = $value;
                        break;
                    case $value instanceof Charset:
                        $this->options[TableOption::CHARACTER_SET] = $value;
                        break;
                    case $value instanceof TableCompression:
                        $this->options[TableOption::COMPRESSION] = $value;
                        break;
                    case $value instanceof TableInsertMethod:
                        $this->options[TableOption::INSERT_METHOD] = $value;
                        break;
                    case $value instanceof TableRowFormat:
                        $this->options[TableRowFormat::class] = $value;
                        break;
                }
            } else {
                TableOption::get($option);
                Check::type($value, $types[$option]);

                $this->options[$option] = $value;
            }
        }
    }

    /**
     * @return mixed[]
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * @param string $option
     * @return mixed|null $option
     */
    public function get(string $option)
    {
        TableOption::get($option);

        return $this->options[$option] ?? null;
    }

    /**
     * @param string $option
     * @param mixed|null $value
     */
    public function set(string $option, $value): void
    {
        TableOption::get($option);
        Check::type($value, TableOption::getTypes()[$option]);

        $this->options[$option] = $value;
    }

    /**
     * @param string $option
     * @param mixed $value
     */
    public function setDefault(string $option, $value): void
    {
        TableOption::get($option);
        if (empty($this->options[$option])) {
            Check::type($value, TableOption::getTypes()[$option]);
            $this->options[$option] = $value;
        }
    }

    public function serialize(SqlFormatter $formatter, string $itemSeparator, string $valueSeparator): string
    {
        return implode($itemSeparator, Arr::filter(Arr::mapPairs(
            $this->options,
            function (string $option, $value) use ($formatter, $valueSeparator): ?string {
                if ($value === null) {
                    return null;
                } elseif ($value instanceof SqlSerializable) {
                    if ($option === Keyword::UNION) {
                        return $option . $valueSeparator . '(' . $value->serialize($formatter) . ')';
                    } else {
                        return $option . $valueSeparator . $value->serialize($formatter);
                    }
                } else {
                    return $option . $valueSeparator . $formatter->formatValue($value);
                }
            }
        )));
    }

}