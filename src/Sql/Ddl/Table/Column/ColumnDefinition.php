<?php
/**
 * This file is part of the SqlFtw library (https://github.com/sqlftw)
 *
 * Copyright (c) 2017 Vlasta Neubauer (@paranoiq)
 *
 * For the full copyright and license information read the file 'license.md', distributed with this source code
 */

namespace SqlFtw\Sql\Ddl\Table\Column;

use SqlFtw\Sql\Ddl\Table\Constraint\ReferenceDefinition;
use SqlFtw\Sql\Ddl\Table\Index\IndexType;
use SqlFtw\Sql\Ddl\DataType;
use SqlFtw\Sql\Expression\ExpressionNode;
use SqlFtw\SqlFormatter\SqlFormatter;

class ColumnDefinition implements \SqlFtw\Sql\Ddl\Table\TableItem
{
    use \Dogma\StrictBehaviorMixin;

    public const AUTOINCREMENT = true;
    public const NO_AUTOINCREMENT = false;

    public const NULLABLE = true;
    public const NOT_NULLABLE = false;

    public const FIRST = false;

    /** @var string */
    private $name;

    /** @var \SqlFtw\Sql\Ddl\DataType|null */
    private $type;

    /** @var bool */
    private $nullable;

    /** @var string|int|float|null */
    private $defaultValue;

    /** @var bool */
    private $autoincrement;

    /** @var \SqlFtw\Sql\Ddl\Table\Column\GeneratedColumnType|null */
    private $generatedColumnType;

    /** @var \SqlFtw\Sql\Expression\ExpressionNode */
    private $expression;

    /** @var string|null */
    private $comment;

    /** @var \SqlFtw\Sql\Ddl\Table\Index\IndexType|null */
    private $index;

    /** @var \SqlFtw\Sql\Ddl\Table\Column\ColumnFormat|null */
    private $columnFormat;

    /** @var \SqlFtw\Sql\Ddl\Table\Constraint\ReferenceDefinition|null */
    private $reference;

    /**
     * @param string $name
     * @param \SqlFtw\Sql\Ddl\DataType $type
     * @param string|int|float|null $defaultValue
     * @param bool|null $nullable
     * @param bool $autoincrement
     * @param string|null $comment
     * @param \SqlFtw\Sql\Ddl\Table\Index\IndexType $index
     * @param \SqlFtw\Sql\Ddl\Table\Column\ColumnFormat|null $columnFormat
     * @param \SqlFtw\Sql\Ddl\Table\Constraint\ReferenceDefinition $reference
     */
    public function __construct(
        string $name,
        DataType $type,
        $defaultValue = null,
        ?bool $nullable = null,
        bool $autoincrement = false,
        ?string $comment = null,
        ?IndexType $index = null,
        ?ColumnFormat $columnFormat = null,
        ?ReferenceDefinition $reference = null
    )
    {
        $this->name = $name;
        $this->type = $type;
        $this->defaultValue = $defaultValue;
        $this->nullable = $nullable;
        $this->autoincrement = $autoincrement;
        $this->comment = $comment;
        $this->index = $index;
        $this->columnFormat = $columnFormat;
        $this->reference = $reference;
    }

    /**
     * @param string $name
     * @param \SqlFtw\Sql\Ddl\DataType $type
     * @param string $expression
     * @param \SqlFtw\Sql\Ddl\Table\Column\GeneratedColumnType $generatedColumnType
     * @param bool $nullable
     * @param string|null $comment
     * @param \SqlFtw\Sql\Ddl\Table\Index\IndexType $index
     * @return \SqlFtw\Sql\Ddl\Table\Column\ColumnDefinition
     */
    public static function createGenerated(
        string $name,
        DataType $type,
        ExpressionNode $expression,
        ?GeneratedColumnType $generatedColumnType,
        ?bool $nullable = null,
        ?string $comment = null,
        ?IndexType $index = null
    ): self
    {
        $instance = new self($name, $type, null, $nullable, false, $comment, $index);

        $instance->generatedColumnType = $generatedColumnType;
        $instance->expression = $expression;

        return $instance;
    }

    /**
     * @param string|int|float|null $defaultValue
     * @return \SqlFtw\Sql\Ddl\Table\Column\ColumnDefinition
     */
    public function duplicateWithDefaultValue($defaultValue): self
    {
        $self = clone($this);
        $self->defaultValue = $defaultValue;

        return $self;
    }

    public function duplicateWithNewName(string $newName): self
    {
        $self = clone($this);
        $self->name = $newName;

        return $self;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getType(): ?DataType
    {
        return $this->type;
    }

    public function getNullable(): ?bool
    {
        return $this->nullable;
    }

    public function hasAutoincrement(): bool
    {
        return $this->autoincrement;
    }

    /**
     * @return mixed|null
     */
    public function getDefaultValue()
    {
        return $this->defaultValue;
    }

    public function isGenerated(): bool
    {
        return $this->expression !== null;
    }

    public function getGeneratedColumnType(): ?GeneratedColumnType
    {
        return $this->generatedColumnType;
    }

    public function getExpression(): ?ExpressionNode
    {
        return $this->expression;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function getIndex(): ?IndexType
    {
        return $this->index;
    }

    public function getColumnFormat(): ?ColumnFormat
    {
        return $this->columnFormat;
    }

    public function getReference(): ?ReferenceDefinition
    {
        return $this->reference;
    }

    public function serialize(SqlFormatter $formatter): string
    {
        $result = $formatter->formatName($this->name);

        $result .= ' ' . $this->type->serialize($formatter);

        if ($this->expression !== null) {
            $result .= ' GENERATED ALWAYS AS ' . $this->expression->serialize($formatter);
            if ($this->generatedColumnType !== null) {
                $result .= ' ' . $this->generatedColumnType->serialize($formatter);
            }
            if ($this->index === IndexType::get(IndexType::UNIQUE)) {
                $result .= ' UNIQUE KEY';
            }
            if ($this->comment !== null) {
                $result .= ' COMMENT ' . $formatter->formatString($this->comment);
            }
            if ($this->nullable !== null) {
                $result .= $this->nullable ? ' NULL' : ' NOT NULL';
            }
            if ($this->index === IndexType::get(IndexType::PRIMARY)) {
                $result .= ' PRIMARY KEY';
            } elseif ($this->index === IndexType::get(IndexType::INDEX)) {
                $result .= ' KEY';
            }
        } else {
            if ($this->nullable !== null) {
                $result .= $this->nullable ? ' NULL' : ' NOT NULL';
            }
            if ($this->defaultValue !== null) {
                $result .= ' DEFAULT ' . $formatter->formatValue($this->defaultValue);
            }
            if ($this->autoincrement) {
                $result .= ' AUTO_INCREMENT';
            }
            if ($this->index !== null) {
                $result .= ' ' . $this->index->serialize($formatter);
            }
            if ($this->comment !== null) {
                $result .= ' COMMENT ' . $formatter->formatString($this->comment);
            }
            if ($this->columnFormat !== null) {
                $result .= ' COLUMN FORMAT ' . $this->columnFormat->serialize($formatter);
            }
            if ($this->reference !== null) {
                $result .= ' REFERENCES ' . $this->reference->serialize($formatter);
            }
        }

        return $result;
    }

}