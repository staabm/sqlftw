<?php declare(strict_types = 1);
/**
 * This file is part of the SqlFtw library (https://github.com/sqlftw)
 *
 * Copyright (c) 2017 Vlasta Neubauer (@paranoiq)
 *
 * For the full copyright and license information read the file 'license.md', distributed with this source code
 */

namespace SqlFtw\Sql\Ddl\Tablespace;

use SqlFtw\Sql\Ddl\Table\Option\StorageEngine;
use SqlFtw\Sql\Expression\BaseType;
use SqlFtw\Sql\InvalidDefinitionException;
use SqlFtw\Sql\Keyword;
use SqlFtw\Sql\SqlEnum;
use SqlFtw\Util\TypeChecker;
use function in_array;

class TablespaceOption extends SqlEnum
{

    public const ENGINE = Keyword::ENGINE;
    public const ENCRYPTION = Keyword::ENCRYPTION;
    public const COMMENT = Keyword::COMMENT;
    public const ADD_DATAFILE = Keyword::ADD . ' ' . Keyword::DATAFILE;
    public const DROP_DATAFILE = Keyword::DROP . ' ' . Keyword::DATAFILE;
    public const USE_LOGFILE_GROUP = Keyword::USE . ' ' . Keyword::LOGFILE . ' ' . Keyword::GROUP;
    public const NODEGROUP = Keyword::NODEGROUP;
    public const RENAME_TO = Keyword::RENAME . ' ' . Keyword::TO;
    public const INITIAL_SIZE = Keyword::INITIAL_SIZE;
    public const FILE_BLOCK_SIZE = Keyword::FILE_BLOCK_SIZE;
    public const EXTENT_SIZE = Keyword::EXTENT_SIZE;
    public const AUTOEXTEND_SIZE = Keyword::AUTOEXTEND_SIZE;
    public const MAX_SIZE = Keyword::MAX_SIZE;
    public const SET = Keyword::SET;
    public const WAIT = Keyword::WAIT;

    /** @var mixed[] */
    private static $values = [
        self::ENGINE => [StorageEngine::INNODB, StorageEngine::NDB],
        self::ENCRYPTION => BaseType::BOOL,
        self::COMMENT => BaseType::CHAR,
        self::ADD_DATAFILE => BaseType::CHAR,
        self::DROP_DATAFILE => BaseType::CHAR,
        self::USE_LOGFILE_GROUP => BaseType::CHAR,
        self::NODEGROUP => BaseType::UNSIGNED,
        self::RENAME_TO => BaseType::CHAR,
        self::INITIAL_SIZE => BaseType::UNSIGNED,
        self::FILE_BLOCK_SIZE => BaseType::UNSIGNED,
        self::EXTENT_SIZE => BaseType::UNSIGNED,
        self::AUTOEXTEND_SIZE => BaseType::UNSIGNED,
        self::MAX_SIZE => BaseType::UNSIGNED,
        self::SET => [Keyword::ACTIVE, Keyword::INACTIVE],
        self::WAIT => BaseType::BOOL,
    ];

    /** @var string[][] */
    private static $usage = [
        Keyword::CREATE => [
            self::ADD_DATAFILE,
            self::FILE_BLOCK_SIZE,
            self::ENCRYPTION,
            self::USE_LOGFILE_GROUP,
            self::EXTENT_SIZE,
            self::INITIAL_SIZE,
            self::AUTOEXTEND_SIZE,
            self::MAX_SIZE,
            self::NODEGROUP,
            self::WAIT,
            self::COMMENT,
            self::ENGINE,
        ],
        Keyword::ALTER => [
            self::ADD_DATAFILE,
            self::DROP_DATAFILE,
            self::INITIAL_SIZE,
            self::WAIT,
            self::RENAME_TO,
            self::SET,
            self::ENCRYPTION,
            self::ENGINE,
        ],
    ];

    /**
     * @return string[]
     */
    public static function getUsage(string $case): array
    {
        return self::$usage[$case];
    }

    /**
     * @param mixed[] $values
     */
    public static function validate(string $for, array &$values): void
    {
        foreach ($values as $key => $value) {
            if (!in_array($key, self::$usage[$for], true)) {
                throw new InvalidDefinitionException("Option $key cannot be used in $for TABLESPACE command.");
            }
            $allowedValues = self::$values[$key];
            if ($allowedValues === BaseType::UNSIGNED) {
                TypeChecker::check($value, BaseType::UNSIGNED);
            } elseif ($allowedValues === BaseType::CHAR) {
                TypeChecker::check($value, BaseType::CHAR);
            } elseif ($allowedValues === BaseType::BOOL) {
                TypeChecker::check($value, BaseType::BOOL);
            } else {
                if (!in_array($value, $allowedValues, true)) {
                    throw new InvalidDefinitionException("Invalid values \"$value\" for option $key.");
                }
            }
            $values[$key] = $value;
        }
    }

}
