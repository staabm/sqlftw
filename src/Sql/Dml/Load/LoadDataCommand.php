<?php
/**
 * This file is part of the SqlFtw library (https://github.com/sqlftw)
 *
 * Copyright (c) 2017 Vlasta Neubauer (@paranoiq)
 *
 * For the full copyright and license information read the file 'license.md', distributed with this source code
 */

namespace SqlFtw\Sql\Dml\Load;

use SqlFtw\Sql\Charset;
use SqlFtw\Sql\Dml\DuplicateOption;
use SqlFtw\Sql\Names\TableName;
use SqlFtw\SqlFormatter\SqlFormatter;

class LoadDataCommand extends \SqlFtw\Sql\Dml\Load\LoadCommand
{
    use \Dogma\StrictBehaviorMixin;

    /** @var \SqlFtw\Sql\Dml\Load\FileFormat|null */
    private $format;

    public function __construct(
        string $file,
        TableName $table,
        ?FileFormat $format,
        ?Charset $charset = null,
        ?array $fields = null,
        ?array $setters = null,
        ?int $ignoreRows = null,
        ?LoadPriority $priority = null,
        bool $local = false,
        ?DuplicateOption $duplicateOption = null,
        ?array $partitions = null
    ) {
        parent::__construct($file, $table, $charset, $fields, $setters, $ignoreRows, $priority, $local, $duplicateOption, $partitions);

        $this->format = $format;
    }

    public function getFormat(): ?FileFormat
    {
        return $this->format;
    }

    protected function getWhat(): string
    {
        return 'DATA';
    }

    protected function serializeFormat(SqlFormatter $formatter): string
    {
        return $this->format->serialize($formatter);
    }

}