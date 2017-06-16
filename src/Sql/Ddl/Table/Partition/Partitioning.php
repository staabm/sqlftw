<?php
/**
 * This file is part of the SqlFtw library (https://github.com/sqlftw)
 *
 * Copyright (c) 2017 Vlasta Neubauer (@paranoiq)
 *
 * For the full copyright and license information read the file 'license.md', distributed with this source code
 */

namespace SqlFtw\Sql\Ddl\Table\Partition;

use Dogma\Check;
use SqlFtw\SqlFormatter\SqlFormatter;

class Partitioning implements \SqlFtw\Sql\SqlSerializable
{
    use \Dogma\StrictBehaviorMixin;

    /** @var \SqlFtw\Sql\Ddl\Table\Partition\PartitioningCondition */
    private $condition;

    /** @var \SqlFtw\Sql\Ddl\Table\Partition\PartitionDefinition[]|null */
    private $partitions;

    /** @var int|null */
    private $partitionsNumber;

    /** @var \SqlFtw\Sql\Ddl\Table\Partition\PartitioningCondition|null */
    private $subpartitionsCondition;

    /** @var int|null */
    private $subpartitionsNumber;

    /**
     * @param \SqlFtw\Sql\Ddl\Table\Partition\PartitioningCondition $condition
     * @param \SqlFtw\Sql\Ddl\Table\Partition\PartitionDefinition[]|null $partitions
     * @param int|null $partitionsNumber
     * @param \SqlFtw\Sql\Ddl\Table\Partition\PartitioningCondition|null $subpartitionsCondition
     * @param int|null $subpartitionsNumber
     */
    public function __construct(
        PartitioningCondition $condition,
        ?array $partitions,
        ?int $partitionsNumber = null,
        ?PartitioningCondition $subpartitionsCondition = null,
        ?int $subpartitionsNumber = null
    ) {
        if ($partitions !== null) {
            Check::itemsOfType($partitions, PartitionDefinition::class);
        }
        $this->condition = $condition;
        $this->partitions = $partitions;
        $this->partitionsNumber = $partitionsNumber;
        $this->subpartitionsCondition = $subpartitionsCondition;
        $this->subpartitionsNumber = $subpartitionsNumber;
    }

    public function getCondition(): PartitioningCondition
    {
        return $this->condition;
    }

    /**
     * @return \SqlFtw\Sql\Ddl\Table\Partition\PartitionDefinition[]|null
     */
    public function getPartitions(): ?array
    {
        return $this->partitions;
    }

    public function getPartitionsNumber(): ?int
    {
        return $this->partitionsNumber;
    }

    public function getSubpartitionsCondition(): ?PartitioningCondition
    {
        return $this->subpartitionsCondition;
    }

    public function getSubpartitionsNumber(): ?int
    {
        return $this->subpartitionsNumber;
    }

    public function serialize(SqlFormatter $formatter): string
    {
        $result = 'PARTITION BY ' . $this->condition->serialize($formatter);
        if ($this->partitionsNumber !== null) {
            $result .= ' PARTITIONS ' . $this->partitionsNumber;
        }
        if ($this->subpartitionsCondition !== null) {
            $result .= ' SUBPARTITION BY ' . $this->subpartitionsCondition->serialize($formatter);
            if ($this->subpartitionsNumber !== null) {
                $result .= ' SUBPARTITIONS ' . $this->subpartitionsNumber;
            }
        }
        if ($this->partitions !== null) {
            $result .= '(' . $formatter->formatSerializablesList($this->partitions) . ')';
        }

        return $result;
    }

}