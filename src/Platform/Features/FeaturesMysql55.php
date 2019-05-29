<?php declare(strict_types = 1);
/**
 * This file is part of the SqlFtw library (https://github.com/sqlftw)
 *
 * Copyright (c) 2017 Vlasta Neubauer (@paranoiq)
 *
 * For the full copyright and license information read the file 'license.md', distributed with this source code
 */

namespace SqlFtw\Platform\Features;

use SqlFtw\Sql\Ddl\BaseType;
use SqlFtw\Sql\Expression\BuiltInFunction;
use SqlFtw\Sql\Expression\Operator;
use SqlFtw\Sql\Keyword;

class FeaturesMysql55 extends PlatformFeatures
{

    public const RESERVED_WORDS = [
        Keyword::ACCESSIBLE,
        Keyword::ADD,
        Keyword::ALL,
        Keyword::ALTER,
        Keyword::ANALYZE,
        Keyword::AND,
        Keyword::AS,
        Keyword::ASC,
        Keyword::ASENSITIVE,
        Keyword::BEFORE,
        Keyword::BETWEEN,
        Keyword::BIGINT,
        Keyword::BINARY,
        Keyword::BLOB,
        Keyword::BOTH,
        Keyword::BY,
        Keyword::CALL,
        Keyword::CASCADE,
        Keyword::CASE,
        Keyword::COLLATE,
        Keyword::COLUMN,
        Keyword::CONDITION,
        Keyword::CONSTRAINT,
        Keyword::CONTINUE,
        Keyword::CONVERT,
        Keyword::CREATE,
        Keyword::CROSS,
        Keyword::CURRENT_DATE,
        Keyword::CURRENT_TIME,
        Keyword::CURRENT_TIMESTAMP,
        Keyword::CURRENT_USER,
        Keyword::CURSOR,
        Keyword::DATABASE,
        Keyword::DATABASES,
        Keyword::DAY_HOUR,
        Keyword::DAY_MICROSECOND,
        Keyword::DAY_MINUTE,
        Keyword::DAY_SECOND,
        Keyword::DEC,
        Keyword::DECIMAL,
        Keyword::DECLARE,
        Keyword::DEFAULT,
        Keyword::DELAYED,
        Keyword::DELETE,
        Keyword::DESC,
        Keyword::DESCRIBE,
        Keyword::DETERMINISTIC,
        Keyword::DISTINCT,
        Keyword::DISTINCTROW,
        Keyword::DIV,
        Keyword::DOUBLE,
        Keyword::DROP,
        Keyword::DUAL,
        Keyword::EACH,
        Keyword::ELSE,
        Keyword::ELSEIF,
        Keyword::ENCLOSED,
        Keyword::ESCAPED,
        Keyword::EXISTS,
        Keyword::EXIT,
        Keyword::EXPLAIN,
        Keyword::FALSE,
        Keyword::FETCH,
        Keyword::FLOAT,
        Keyword::FLOAT4,
        Keyword::FLOAT8,
        Keyword::FOR,
        Keyword::FORCE,
        Keyword::FOREIGN,
        Keyword::FROM,
        Keyword::FULLTEXT,
        Keyword::GRANT,
        Keyword::GROUP,
        Keyword::HAVING,
        Keyword::HIGH_PRIORITY,
        Keyword::HOUR_MICROSECOND,
        Keyword::HOUR_MINUTE,
        Keyword::HOUR_SECOND,
        Keyword::CHANGE,
        Keyword::CHAR,
        Keyword::CHARACTER,
        Keyword::CHECK,
        Keyword::IF,
        Keyword::IGNORE,
        Keyword::IN,
        Keyword::INDEX,
        Keyword::INFILE,
        Keyword::INNER,
        Keyword::INOUT,
        Keyword::INSENSITIVE,
        Keyword::INSERT,
        Keyword::INT,
        Keyword::INT1,
        Keyword::INT2,
        Keyword::INT3,
        Keyword::INT4,
        Keyword::INT8,
        Keyword::INTEGER,
        Keyword::INTERVAL,
        Keyword::INTO,
        Keyword::IS,
        Keyword::ITERATE,
        Keyword::JOIN,
        Keyword::KEY,
        Keyword::KEYS,
        Keyword::KILL,
        Keyword::LEADING,
        Keyword::LEAVE,
        Keyword::LEFT,
        Keyword::LIKE,
        Keyword::LIMIT,
        Keyword::LINEAR,
        Keyword::LINES,
        Keyword::LOAD,
        Keyword::LOCALTIME,
        Keyword::LOCALTIMESTAMP,
        Keyword::LOCK,
        Keyword::LONG,
        Keyword::LONGBLOB,
        Keyword::LONGTEXT,
        Keyword::LOOP,
        Keyword::LOW_PRIORITY,
        Keyword::MASTER_SSL_VERIFY_SERVER_CERT,
        Keyword::MATCH,
        Keyword::MAXVALUE,
        Keyword::MEDIUMBLOB,
        Keyword::MEDIUMINT,
        Keyword::MEDIUMTEXT,
        Keyword::MIDDLEINT,
        Keyword::MINUTE_MICROSECOND,
        Keyword::MINUTE_SECOND,
        Keyword::MOD,
        Keyword::MODIFIES,
        Keyword::NATURAL,
        Keyword::NO_WRITE_TO_BINLOG,
        Keyword::NOT,
        Keyword::NULL,
        Keyword::NUMERIC,
        Keyword::ON,
        Keyword::OPTIMIZE,
        Keyword::OPTION,
        Keyword::OPTIONALLY,
        Keyword::OR,
        Keyword::ORDER,
        Keyword::OUT,
        Keyword::OUTER,
        Keyword::OUTFILE,
        Keyword::PRECISION,
        Keyword::PRIMARY,
        Keyword::PROCEDURE,
        Keyword::PURGE,
        Keyword::RANGE,
        Keyword::READ,
        Keyword::READ_WRITE,
        Keyword::READS,
        Keyword::REAL,
        Keyword::REFERENCES,
        Keyword::REGEXP,
        Keyword::RELEASE,
        Keyword::RENAME,
        Keyword::REPEAT,
        Keyword::REPLACE,
        Keyword::REQUIRE,
        Keyword::RESIGNAL,
        Keyword::RESTRICT,
        Keyword::RETURN,
        Keyword::REVOKE,
        Keyword::RIGHT,
        Keyword::RLIKE,
        Keyword::SECOND_MICROSECOND,
        Keyword::SELECT,
        Keyword::SENSITIVE,
        Keyword::SEPARATOR,
        Keyword::SET,
        Keyword::SHOW,
        Keyword::SCHEMA,
        Keyword::SCHEMAS,
        Keyword::SIGNAL,
        Keyword::SMALLINT,
        Keyword::SPATIAL,
        Keyword::SPECIFIC,
        Keyword::SQL,
        Keyword::SQL_BIG_RESULT,
        Keyword::SQL_CALC_FOUND_ROWS,
        Keyword::SQL_SMALL_RESULT,
        Keyword::SQLEXCEPTION,
        Keyword::SQLSTATE,
        Keyword::SQLWARNING,
        Keyword::SSL,
        Keyword::STARTING,
        Keyword::STRAIGHT_JOIN,
        Keyword::TABLE,
        Keyword::TERMINATED,
        Keyword::THEN,
        Keyword::TINYBLOB,
        Keyword::TINYINT,
        Keyword::TINYTEXT,
        Keyword::TO,
        Keyword::TRAILING,
        Keyword::TRIGGER,
        Keyword::TRUE,
        Keyword::UNDO,
        Keyword::UNION,
        Keyword::UNIQUE,
        Keyword::UNLOCK,
        Keyword::UNSIGNED,
        Keyword::UPDATE,
        Keyword::USAGE,
        Keyword::USE,
        Keyword::USING,
        Keyword::UTC_DATE,
        Keyword::UTC_TIME,
        Keyword::UTC_TIMESTAMP,
        Keyword::VALUES,
        Keyword::VARBINARY,
        Keyword::VARCHAR,
        Keyword::VARCHARACTER,
        Keyword::VARYING,
        Keyword::WHEN,
        Keyword::WHERE,
        Keyword::WHILE,
        Keyword::WITH,
        Keyword::WRITE,
        Keyword::XOR,
        Keyword::YEAR_MONTH,
        Keyword::ZEROFILL,
    ];

    public const NON_RESERVED_WORDS = [
        Keyword::ACTION,
        Keyword::AFTER,
        Keyword::AGAINST,
        Keyword::AGGREGATE,
        Keyword::ALGORITHM,
        Keyword::ANY,
        Keyword::ASCII,
        Keyword::AT,
        Keyword::AUTHORS,
        Keyword::AUTO_INCREMENT,
        Keyword::AUTOEXTEND_SIZE,
        Keyword::AVG,
        Keyword::AVG_ROW_LENGTH,
        Keyword::BACKUP,
        Keyword::BEGIN,
        Keyword::BINLOG,
        Keyword::BIT,
        Keyword::BLOCK,
        Keyword::BOOL,
        Keyword::BOOLEAN,
        Keyword::BTREE,
        Keyword::BYTE,
        Keyword::CACHE,
        Keyword::CASCADED,
        Keyword::CATALOG_NAME,
        Keyword::CIPHER,
        Keyword::CLASS_ORIGIN,
        Keyword::CLIENT,
        Keyword::CLOSE,
        Keyword::COALESCE,
        Keyword::CODE,
        Keyword::COLLATION,
        Keyword::COLUMN_NAME,
        Keyword::COLUMNS,
        Keyword::COMMENT,
        Keyword::COMMIT,
        Keyword::COMMITTED,
        Keyword::COMPACT,
        Keyword::COMPLETION,
        Keyword::COMPRESSED,
        Keyword::CONCURRENT,
        Keyword::CONNECTION,
        Keyword::CONSISTENT,
        Keyword::CONSTRAINT_CATALOG,
        Keyword::CONSTRAINT_NAME,
        Keyword::CONSTRAINT_SCHEMA,
        Keyword::CONTAINS,
        Keyword::CONTEXT,
        Keyword::CONTRIBUTORS,
        Keyword::CPU,
        Keyword::CUBE,
        Keyword::CURSOR_NAME,
        Keyword::DATA,
        Keyword::DATAFILE,
        Keyword::DATE,
        Keyword::DATETIME,
        Keyword::DAY,
        Keyword::DEALLOCATE,
        Keyword::DEFINER,
        Keyword::DELAY_KEY_WRITE,
        Keyword::DES_KEY_FILE,
        Keyword::DIRECTORY,
        Keyword::DISABLE,
        Keyword::DISCARD,
        Keyword::DISK,
        Keyword::DO,
        Keyword::DUMPFILE,
        Keyword::DUPLICATE,
        Keyword::DYNAMIC,
        Keyword::ENABLE,
        Keyword::END,
        Keyword::ENDS,
        Keyword::ENGINE,
        Keyword::ENGINES,
        Keyword::ENUM,
        Keyword::ERROR,
        Keyword::ERRORS,
        Keyword::ESCAPE,
        Keyword::EVENT,
        Keyword::EVENTS,
        Keyword::EVERY,
        Keyword::EXECUTE,
        Keyword::EXPANSION,
        Keyword::EXTENDED,
        Keyword::EXTENT_SIZE,
        Keyword::FAST,
        Keyword::FAULTS,
        Keyword::FIELDS,
        Keyword::FILE,
        Keyword::FIRST,
        Keyword::FIXED,
        Keyword::FLUSH,
        Keyword::FOUND,
        Keyword::FRAC_SECOND,
        Keyword::FULL,
        Keyword::FUNCTION,
        Keyword::GENERAL,
        Keyword::GEOMETRY,
        Keyword::GEOMETRYCOLLECTION,
        Keyword::GET_FORMAT,
        Keyword::GLOBAL,
        Keyword::GRANTS,
        Keyword::HANDLER,
        Keyword::HASH,
        Keyword::HELP,
        Keyword::HOST,
        Keyword::HOSTS,
        Keyword::HOUR,
        Keyword::CHAIN,
        Keyword::CHANGED,
        Keyword::CHARSET,
        Keyword::CHECKSUM,
        Keyword::IDENTIFIED,
        Keyword::IGNORE_SERVER_IDS,
        Keyword::IMPORT,
        Keyword::INDEXES,
        Keyword::INITIAL_SIZE,
        Keyword::INNOBASE,
        Keyword::INNODB,
        Keyword::INSERT_METHOD,
        Keyword::INSTALL,
        Keyword::INVOKER,
        Keyword::IO,
        Keyword::IO_THREAD,
        Keyword::IPC,
        Keyword::ISOLATION,
        Keyword::ISSUER,
        Keyword::KEY_BLOCK_SIZE,
        Keyword::LANGUAGE,
        Keyword::LAST,
        Keyword::LEAVES,
        Keyword::LESS,
        Keyword::LEVEL,
        Keyword::LINESTRING,
        Keyword::LIST,
        Keyword::LOCAL,
        Keyword::LOCKS,
        Keyword::LOGFILE,
        Keyword::LOGS,
        Keyword::MASTER,
        Keyword::MASTER_CONNECT_RETRY,
        Keyword::MASTER_HEARTBEAT_PERIOD,
        Keyword::MASTER_HOST,
        Keyword::MASTER_LOG_FILE,
        Keyword::MASTER_LOG_POS,
        Keyword::MASTER_PASSWORD,
        Keyword::MASTER_PORT,
        Keyword::MASTER_SERVER_ID,
        Keyword::MASTER_SSL,
        Keyword::MASTER_SSL_CA,
        Keyword::MASTER_SSL_CAPATH,
        Keyword::MASTER_SSL_CERT,
        Keyword::MASTER_SSL_CIPHER,
        Keyword::MASTER_SSL_KEY,
        Keyword::MASTER_USER,
        Keyword::MAX_CONNECTIONS_PER_HOUR,
        Keyword::MAX_QUERIES_PER_HOUR,
        Keyword::MAX_ROWS,
        Keyword::MAX_SIZE,
        Keyword::MAX_UPDATES_PER_HOUR,
        Keyword::MAX_USER_CONNECTIONS,
        Keyword::MEDIUM,
        Keyword::MEMORY,
        Keyword::MERGE,
        Keyword::MESSAGE_TEXT,
        Keyword::MICROSECOND,
        Keyword::MIGRATE,
        Keyword::MIN_ROWS,
        Keyword::MINUTE,
        Keyword::MODE,
        Keyword::MODIFY,
        Keyword::MONTH,
        Keyword::MULTILINESTRING,
        Keyword::MULTIPOINT,
        Keyword::MULTIPOLYGON,
        Keyword::MUTEX,
        Keyword::MYSQL_ERRNO,
        Keyword::NAME,
        Keyword::NAMES,
        Keyword::NATIONAL,
        Keyword::NDB,
        Keyword::NDBCLUSTER,
        Keyword::NEW,
        Keyword::NEXT,
        Keyword::NCHAR,
        Keyword::NO,
        Keyword::NO_WAIT,
        Keyword::NODEGROUP,
        Keyword::NONE,
        Keyword::NVARCHAR,
        Keyword::OFFSET,
        Keyword::OLD_PASSWORD,
        Keyword::ONE,
        Keyword::ONE_SHOT,
        Keyword::OPEN,
        Keyword::OPTIONS,
        Keyword::OWNER,
        Keyword::PACK_KEYS,
        Keyword::PAGE,
        Keyword::PARSER,
        Keyword::PARTIAL,
        Keyword::PARTITION,
        Keyword::PARTITIONING,
        Keyword::PARTITIONS,
        Keyword::PASSWORD,
        Keyword::PHASE,
        Keyword::PLUGIN,
        Keyword::PLUGINS,
        Keyword::POINT,
        Keyword::POLYGON,
        Keyword::PORT,
        Keyword::PREPARE,
        Keyword::PRESERVE,
        Keyword::PREV,
        Keyword::PRIVILEGES,
        Keyword::PROCESSLIST,
        Keyword::PROFILE,
        Keyword::PROFILES,
        Keyword::PROXY,
        Keyword::QUARTER,
        Keyword::QUERY,
        Keyword::QUICK,
        Keyword::READ_ONLY,
        Keyword::REBUILD,
        Keyword::RECOVER,
        Keyword::REDO_BUFFER_SIZE,
        Keyword::REDOFILE,
        Keyword::REDUNDANT,
        Keyword::RELAY_LOG_FILE,
        Keyword::RELAY_LOG_POS,
        Keyword::RELAY_THREAD,
        Keyword::RELAY,
        Keyword::RELAYLOG,
        Keyword::RELOAD,
        Keyword::REMOVE,
        Keyword::REORGANIZE,
        Keyword::REPAIR,
        Keyword::REPEATABLE,
        Keyword::REPLICATION,
        Keyword::RESET,
        Keyword::RESTART, // undocumented
        Keyword::RESTORE,
        Keyword::RESUME,
        Keyword::RETURNS,
        Keyword::ROLLBACK,
        Keyword::ROLLUP,
        Keyword::ROUTINE,
        Keyword::ROW,
        Keyword::ROW_FORMAT,
        Keyword::ROWS,
        Keyword::RTREE,
        Keyword::SAVEPOINT,
        Keyword::SECOND,
        Keyword::SECURITY,
        Keyword::SERIAL,
        Keyword::SERIALIZABLE,
        Keyword::SERVER,
        Keyword::SESSION,
        Keyword::SHARE,
        Keyword::SHUTDOWN,
        Keyword::SCHEDULE,
        Keyword::SCHEMA_NAME,
        Keyword::SIGNED,
        Keyword::SIMPLE,
        Keyword::SLAVE,
        Keyword::SLOW,
        Keyword::SNAPSHOT,
        Keyword::SOCKET,
        Keyword::SOME,
        Keyword::SONAME,
        Keyword::SOUNDS,
        Keyword::SOURCE,
        Keyword::SQL_BUFFER_RESULT,
        Keyword::SQL_CACHE,
        Keyword::SQL_NO_CACHE,
        Keyword::SQL_THREAD,
        Keyword::SQL_TSI_DAY,
        Keyword::SQL_TSI_FRAC_SECOND,
        Keyword::SQL_TSI_HOUR,
        Keyword::SQL_TSI_MINUTE,
        Keyword::SQL_TSI_MONTH,
        Keyword::SQL_TSI_QUARTER,
        Keyword::SQL_TSI_SECOND,
        Keyword::SQL_TSI_WEEK,
        Keyword::SQL_TSI_YEAR,
        Keyword::START,
        Keyword::STARTS,
        Keyword::STATUS,
        Keyword::STOP,
        Keyword::STORAGE,
        Keyword::STRING,
        Keyword::SUBCLASS_ORIGIN,
        Keyword::SUBJECT,
        Keyword::SUBPARTITION,
        Keyword::SUBPARTITIONS,
        Keyword::SUPER,
        Keyword::SUSPEND,
        Keyword::SWAPS,
        Keyword::SWITCHES,
        Keyword::TABLE_CHECKSUM,
        Keyword::TABLE_NAME,
        Keyword::TABLES,
        Keyword::TABLESPACE,
        Keyword::TEMPORARY,
        Keyword::TEMPTABLE,
        Keyword::TEXT,
        Keyword::THAN,
        Keyword::TIME,
        Keyword::TIMESTAMP,
        Keyword::TIMESTAMPADD,
        Keyword::TIMESTAMPDIFF,
        Keyword::TRANSACTION,
        Keyword::TRIGGERS,
        Keyword::TRUNCATE,
        Keyword::TYPE,
        Keyword::TYPES,
        Keyword::UNCOMMITTED,
        Keyword::UNDEFINED,
        Keyword::UNDO_BUFFER_SIZE,
        Keyword::UNDOFILE,
        Keyword::UNICODE,
        Keyword::UNINSTALL,
        Keyword::UNKNOWN,
        Keyword::UNTIL,
        Keyword::UPGRADE,
        Keyword::USE_FRM,
        Keyword::USER,
        Keyword::USER_RESOURCES,
        Keyword::VALUE,
        Keyword::VARIABLES,
        Keyword::VIEW,
        Keyword::WAIT,
        Keyword::WARNINGS,
        Keyword::WEEK,
        Keyword::WORK,
        Keyword::WRAPPER,
        Keyword::X509,
        Keyword::XA,
        Keyword::XML,
        Keyword::YEAR,
    ];

    public const OPERATOR_KEYWORDS = [
        Keyword::AND,
        Keyword::OR,
        Keyword::XOR,
        Keyword::NOT,
        Keyword::IN,
        Keyword::IS,
        Keyword::LIKE,
        Keyword::RLIKE,
        Keyword::REGEXP,
        Keyword::SOUNDS,
        Keyword::BETWEEN,
        Keyword::DIV,
        Keyword::MOD,
        Keyword::INTERVAL,
        Keyword::BINARY,
        Keyword::COLLATE,
        Keyword::CASE,
        Keyword::WHEN,
        Keyword::THAN,
        Keyword::ELSE,
    ];

    public const OPERATORS = [
        Operator::ALL,
        Operator::AMPERSANDS,
        Operator::AND,
        Operator::ANY,
        Operator::ASSIGN,
        Operator::BETWEEN,
        Operator::BINARY,
        Operator::BIT_AND,
        Operator::BIT_INVERT,
        Operator::BIT_OR,
        Operator::BIT_XOR,
        Operator::CASE,
        Operator::DIV,
        Operator::DIVIDE,
        Operator::ELSE,
        Operator::END,
        Operator::EQUAL,
        Operator::ESCAPE,
        Operator::EXCLAMATION,
        Operator::EXISTS,
        Operator::GREATER,
        Operator::GREATER_OR_EQUAL,
        Operator::IN,
        Operator::IS,
        Operator::LEFT_SHIFT,
        Operator::LESS,
        Operator::LESS_OR_EQUAL,
        Operator::LESS_OR_GREATER,
        Operator::LIKE,
        Operator::MINUS,
        Operator::MOD,
        Operator::MODULO,
        Operator::MULTIPLY,
        Operator::NON_EQUAL,
        Operator::NOT,
        Operator::OR,
        Operator::PIPES,
        Operator::PLUS,
        Operator::REGEXP,
        Operator::RIGHT_SHIFT,
        Operator::RLIKE,
        Operator::SAFE_EQUAL,
        Operator::SOME,
        Operator::SOUNDS,
        Operator::THEN,
        Operator::WHEN,
        Operator::XOR,
    ];

    public const TYPES = [
        // bitwise
        BaseType::BIT,

        // integers
        BaseType::TINYINT,
        BaseType::SMALLINT,
        BaseType::MEDIUMINT,
        BaseType::INT,
        BaseType::BIGINT,

        // floats
        BaseType::REAL,
        BaseType::FLOAT,
        BaseType::DOUBLE,

        // decimal
        BaseType::DECIMAL,

        // time
        BaseType::YEAR,
        BaseType::DATE,
        BaseType::DATETIME,
        BaseType::TIME,
        BaseType::TIMESTAMP,

        // texts
        BaseType::CHAR,
        BaseType::VARCHAR,
        BaseType::TINYTEXT,
        BaseType::TEXT,
        BaseType::MEDIUMTEXT,
        BaseType::LONGTEXT,

        // binary
        BaseType::BINARY,
        BaseType::VARBINARY,
        BaseType::TINYBLOB,
        BaseType::BLOB,
        BaseType::MEDIUMBLOB,
        BaseType::LONGBLOB,

        // sets
        BaseType::ENUM,
        BaseType::SET,

        // json
        BaseType::JSON,

        // geometry
        BaseType::GEOMETRY,
        BaseType::POINT,
        BaseType::LINESTRING,
        BaseType::POLYGON,
        BaseType::GEOMETRYCOLLECTION,
        BaseType::MULTIPOINT,
        BaseType::MULTILINESTRING,
        BaseType::MULTIPOLYGON,
    ];

    public const TYPE_ALIASES = [
        BaseType::BOOL => BaseType::TINYINT,
        BaseType::BOOLEAN => BaseType::TINYINT,
        BaseType::MIDDLEINT => BaseType::MEDIUMINT,
        BaseType::INTEGER => BaseType::INT,
        BaseType::INT1 => BaseType::TINYINT,
        BaseType::INT2 => BaseType::SMALLINT,
        BaseType::INT3 => BaseType::MEDIUMINT,
        BaseType::INT4 => BaseType::INT,
        BaseType::INT8 => BaseType::BIGINT,
        BaseType::FLOAT4 => BaseType::FLOAT,
        BaseType::FLOAT8 => BaseType::DOUBLE,
        BaseType::DEC => BaseType::DECIMAL,
        BaseType::NUMERIC => BaseType::DECIMAL,
        BaseType::FIXED => BaseType::DECIMAL,
        BaseType::CHARACTER => BaseType::CHAR,
        BaseType::NCHAR => BaseType::CHAR,
        BaseType::NATIONAL_CHAR => BaseType::CHAR,
        BaseType::CHARACTER_VARYING => BaseType::VARCHAR,
        BaseType::NVARCHAR => BaseType::VARCHAR,
        BaseType::NATIONAL_VARCHAR => BaseType::VARCHAR,
        BaseType::LONG => BaseType::MEDIUMTEXT,
        BaseType::LONG_VARCHAR => BaseType::MEDIUMTEXT,
        BaseType::CHAR_BYTE => BaseType::BINARY,
        BaseType::LONG_VARBINARY => BaseType::MEDIUMBLOB,
    ];

    public const BUILT_IN_FUNCTIONS = [
        BuiltInFunction::ABS,
        BuiltInFunction::ACOS,
        BuiltInFunction::ADDDATE,
        BuiltInFunction::ADDTIME,
        BuiltInFunction::AES_DECRYPT,
        BuiltInFunction::AES_ENCRYPT,
        BuiltInFunction::ANY_VALUE,
        BuiltInFunction::ASCII,
        BuiltInFunction::ASIN,
        BuiltInFunction::ASYMMETRIC_DECRYPT,
        BuiltInFunction::ASYMMETRIC_DERIVE,
        BuiltInFunction::ASYMMETRIC_ENCRYPT,
        BuiltInFunction::ASYMMETRIC_SIGN,
        BuiltInFunction::ASYMMETRIC_VERIFY,
        BuiltInFunction::ATAN,
        BuiltInFunction::ATAN2,
        BuiltInFunction::AVG,
        BuiltInFunction::BENCHMARK,
        BuiltInFunction::BIN,
        BuiltInFunction::BIN_TO_UUID,
        BuiltInFunction::BIT_AND,
        BuiltInFunction::BIT_COUNT,
        BuiltInFunction::BIT_LENGTH,
        BuiltInFunction::BIT_OR,
        BuiltInFunction::BIT_XOR,
        BuiltInFunction::CAST,
        BuiltInFunction::CEIL,
        BuiltInFunction::CEILING,
        BuiltInFunction::CHAR,
        BuiltInFunction::CHAR_LENGTH,
        BuiltInFunction::CHARACTER_LENGTH,
        BuiltInFunction::CHARSET,
        BuiltInFunction::COALESCE,
        BuiltInFunction::COERCIBILITY,
        BuiltInFunction::COLLATION,
        BuiltInFunction::COMPRESS,
        BuiltInFunction::CONCAT,
        BuiltInFunction::CONCAT_WS,
        BuiltInFunction::CONNECTION_ID,
        BuiltInFunction::CONV,
        BuiltInFunction::CONVERT,
        BuiltInFunction::CONVERT_TZ,
        BuiltInFunction::COS,
        BuiltInFunction::COT,
        BuiltInFunction::COUNT,
        BuiltInFunction::COUNT_DISTINCT,
        BuiltInFunction::CRC32,
        BuiltInFunction::CREATE_ASYMMETRIC_PRIV_KEY,
        BuiltInFunction::CREATE_ASYMMETRIC_PUB_KEY,
        BuiltInFunction::CREATE_DH_PARAMETERS,
        BuiltInFunction::CREATE_DIGEST,
        BuiltInFunction::CURDATE,
        BuiltInFunction::CURRENT_DATE,
        BuiltInFunction::CURRENT_ROLE,
        BuiltInFunction::CURRENT_TIME,
        BuiltInFunction::CURRENT_TIMESTAMP,
        BuiltInFunction::CURRENT_USER,
        BuiltInFunction::CURTIME,
        BuiltInFunction::DATABASE,
        BuiltInFunction::DATE,
        BuiltInFunction::DATE_ADD,
        BuiltInFunction::DATE_FORMAT,
        BuiltInFunction::DATE_SUB,
        BuiltInFunction::DATEDIFF,
        BuiltInFunction::DAY,
        BuiltInFunction::DAYNAME,
        BuiltInFunction::DAYOFMONTH,
        BuiltInFunction::DAYOFWEEK,
        BuiltInFunction::DAYOFYEAR,
        BuiltInFunction::DECODE,
        BuiltInFunction::DEFAULT,
        BuiltInFunction::DEGREES,
        BuiltInFunction::DES_DECRYPT,
        BuiltInFunction::DES_ENCRYPT,
        BuiltInFunction::ELT,
        BuiltInFunction::ENCODE,
        BuiltInFunction::ENCRYPT,
        BuiltInFunction::EXP,
        BuiltInFunction::EXPORT_SET,
        BuiltInFunction::EXTRACT,
        BuiltInFunction::ExtractValue,
        BuiltInFunction::FIELD,
        BuiltInFunction::FIND_IN_SET,
        BuiltInFunction::FLOOR,
        BuiltInFunction::FORMAT,
        BuiltInFunction::FOUND_ROWS,
        BuiltInFunction::FROM_BASE64,
        BuiltInFunction::FROM_DAYS,
        BuiltInFunction::FROM_UNIXTIME,
        BuiltInFunction::GeometryCollection,
        BuiltInFunction::GET_FORMAT,
        BuiltInFunction::GET_LOCK,
        BuiltInFunction::GREATEST,
        BuiltInFunction::GROUP_CONCAT,
        BuiltInFunction::GROUPING,
        BuiltInFunction::GTID_SUBSET,
        BuiltInFunction::GTID_SUBTRACT,
        BuiltInFunction::HEX,
        BuiltInFunction::HOUR,
        BuiltInFunction::IF,
        BuiltInFunction::IFNULL,
        BuiltInFunction::INET6_ATON,
        BuiltInFunction::INET6_NTOA,
        BuiltInFunction::INET_ATON,
        BuiltInFunction::INET_NTOA,
        BuiltInFunction::INSERT,
        BuiltInFunction::INSTR,
        BuiltInFunction::INTERVAL,
        BuiltInFunction::IS_FREE_LOCK,
        BuiltInFunction::IS_IPV4,
        BuiltInFunction::IS_IPV4_COMPAT,
        BuiltInFunction::IS_IPV4_MAPPED,
        BuiltInFunction::IS_IPV6,
        BuiltInFunction::IS_USED_LOCK,
        BuiltInFunction::IS_UUID,
        BuiltInFunction::ISNULL,
        BuiltInFunction::LAST_DAY,
        BuiltInFunction::LAST_INSERT_ID,
        BuiltInFunction::LCASE,
        BuiltInFunction::LEAST,
        BuiltInFunction::LEFT,
        BuiltInFunction::LENGTH,
        BuiltInFunction::LineString,
        BuiltInFunction::LN,
        BuiltInFunction::LOAD_FILE,
        BuiltInFunction::LOCALTIME,
        BuiltInFunction::LOCALTIMESTAMP,
        BuiltInFunction::LOCATE,
        BuiltInFunction::LOG,
        BuiltInFunction::LOG10,
        BuiltInFunction::LOG2,
        BuiltInFunction::LOWER,
        BuiltInFunction::LPAD,
        BuiltInFunction::LTRIM,
        BuiltInFunction::MAKE_SET,
        BuiltInFunction::MAKEDATE,
        BuiltInFunction::MAKETIME,
        BuiltInFunction::MASTER_POS_WAIT,
        BuiltInFunction::MAX,
        BuiltInFunction::MBRContains,
        BuiltInFunction::MBRCoveredBy,
        BuiltInFunction::MBRCovers,
        BuiltInFunction::MBRDisjoint,
        BuiltInFunction::MBREquals,
        BuiltInFunction::MBRIntersects,
        BuiltInFunction::MBROverlaps,
        BuiltInFunction::MBRTouches,
        BuiltInFunction::MBRWithin,
        BuiltInFunction::MD5,
        BuiltInFunction::MICROSECOND,
        BuiltInFunction::MID,
        BuiltInFunction::MIN,
        BuiltInFunction::MINUTE,
        BuiltInFunction::MOD,
        BuiltInFunction::MONTH,
        BuiltInFunction::MONTHNAME,
        BuiltInFunction::MultiLineString,
        BuiltInFunction::MultiPoint,
        BuiltInFunction::MultiPolygon,
        BuiltInFunction::NAME_CONST,
        BuiltInFunction::NOW,
        BuiltInFunction::NULLIF,
        BuiltInFunction::OCT,
        BuiltInFunction::OCTET_LENGTH,
        BuiltInFunction::ORD,
        BuiltInFunction::PASSWORD,
        BuiltInFunction::PERIOD_ADD,
        BuiltInFunction::PERIOD_DIFF,
        BuiltInFunction::PI,
        BuiltInFunction::Point,
        BuiltInFunction::Polygon,
        BuiltInFunction::POSITION,
        BuiltInFunction::POW,
        BuiltInFunction::POWER,
        BuiltInFunction::QUARTER,
        BuiltInFunction::QUOTE,
        BuiltInFunction::RADIANS,
        BuiltInFunction::RAND,
        BuiltInFunction::RANDOM_BYTES,
        BuiltInFunction::RELEASE_ALL_LOCKS,
        BuiltInFunction::RELEASE_LOCK,
        BuiltInFunction::REPEAT,
        BuiltInFunction::REPLACE,
        BuiltInFunction::REVERSE,
        BuiltInFunction::RIGHT,
        BuiltInFunction::ROLES_GRAPHML,
        BuiltInFunction::ROUND,
        BuiltInFunction::ROW_COUNT,
        BuiltInFunction::RPAD,
        BuiltInFunction::RTRIM,
        BuiltInFunction::SCHEMA,
        BuiltInFunction::SEC_TO_TIME,
        BuiltInFunction::SECOND,
        BuiltInFunction::SESSION_USER,
        BuiltInFunction::SHA,
        BuiltInFunction::SHA1,
        BuiltInFunction::SHA2,
        BuiltInFunction::SIGN,
        BuiltInFunction::SIN,
        BuiltInFunction::SLEEP,
        BuiltInFunction::SOUNDEX,
        BuiltInFunction::SPACE,
        BuiltInFunction::SQRT,
        BuiltInFunction::ST_Area,
        BuiltInFunction::ST_AsBinary,
        BuiltInFunction::ST_AsGeoJSON,
        BuiltInFunction::ST_AsText,
        BuiltInFunction::ST_AsWKT,
        BuiltInFunction::ST_Buffer,
        BuiltInFunction::ST_Buffer_Strategy,
        BuiltInFunction::ST_Centroid,
        BuiltInFunction::ST_Contains,
        BuiltInFunction::ST_ConvexHull,
        BuiltInFunction::ST_Crosses,
        BuiltInFunction::ST_Difference,
        BuiltInFunction::ST_Dimension,
        BuiltInFunction::ST_Disjoint,
        BuiltInFunction::ST_Distance,
        BuiltInFunction::ST_Distance_Sphere,
        BuiltInFunction::ST_EndPoint,
        BuiltInFunction::ST_Envelope,
        BuiltInFunction::ST_Equals,
        BuiltInFunction::ST_ExteriorRing,
        BuiltInFunction::ST_GeoHash,
        BuiltInFunction::ST_GeomCollFromText,
        BuiltInFunction::ST_GeomCollFromTxt,
        BuiltInFunction::ST_GeomCollFromWKB,
        BuiltInFunction::ST_GeometryCollectionFromText,
        BuiltInFunction::ST_GeometryCollectionFromWKB,
        BuiltInFunction::ST_GeometryFromText,
        BuiltInFunction::ST_GeometryFromWKB,
        BuiltInFunction::ST_GeometryN,
        BuiltInFunction::ST_GeometryType,
        BuiltInFunction::ST_GeomFromGeoJSON,
        BuiltInFunction::ST_GeomFromText,
        BuiltInFunction::ST_GeomFromWKB,
        BuiltInFunction::ST_InteriorRingN,
        BuiltInFunction::ST_Intersection,
        BuiltInFunction::ST_Intersects,
        BuiltInFunction::ST_IsClosed,
        BuiltInFunction::ST_IsEmpty,
        BuiltInFunction::ST_IsSimple,
        BuiltInFunction::ST_IsValid,
        BuiltInFunction::ST_LatFromGeoHash,
        BuiltInFunction::ST_Length,
        BuiltInFunction::ST_LineFromText,
        BuiltInFunction::ST_LineFromWKB,
        BuiltInFunction::ST_LineStringFromText,
        BuiltInFunction::ST_LineStringFromWKB,
        BuiltInFunction::ST_LongFromGeoHash,
        BuiltInFunction::ST_MakeEnvelope,
        BuiltInFunction::ST_MLineFromText,
        BuiltInFunction::ST_MLineFromWKB,
        BuiltInFunction::ST_MPointFromText,
        BuiltInFunction::ST_MPointFromWKB,
        BuiltInFunction::ST_MPolyFromText,
        BuiltInFunction::ST_MPolyFromWKB,
        BuiltInFunction::ST_MultiLineStringFromText,
        BuiltInFunction::ST_MultiLineStringFromWKB,
        BuiltInFunction::ST_MultiPointFromText,
        BuiltInFunction::ST_MultiPointFromWKB,
        BuiltInFunction::ST_MultiPolygonFromText,
        BuiltInFunction::ST_MultiPolygonFromWKB,
        BuiltInFunction::ST_NumGeometries,
        BuiltInFunction::ST_NumInteriorRing,
        BuiltInFunction::ST_NumInteriorRings,
        BuiltInFunction::ST_NumPoints,
        BuiltInFunction::ST_Overlaps,
        BuiltInFunction::ST_PointFromGeoHash,
        BuiltInFunction::ST_PointFromText,
        BuiltInFunction::ST_PointFromWKB,
        BuiltInFunction::ST_PointN,
        BuiltInFunction::ST_PolyFromText,
        BuiltInFunction::ST_PolyFromWKB,
        BuiltInFunction::ST_PolygonFromText,
        BuiltInFunction::ST_PolygonFromWKB,
        BuiltInFunction::ST_Simplify,
        BuiltInFunction::ST_SRID,
        BuiltInFunction::ST_StartPoint,
        BuiltInFunction::ST_SwapXY,
        BuiltInFunction::ST_SymDifference,
        BuiltInFunction::ST_Touches,
        BuiltInFunction::ST_Union,
        BuiltInFunction::ST_Validate,
        BuiltInFunction::ST_Within,
        BuiltInFunction::ST_X,
        BuiltInFunction::ST_Y,
        BuiltInFunction::STD,
        BuiltInFunction::STDDEV,
        BuiltInFunction::STDDEV_POP,
        BuiltInFunction::STDDEV_SAMP,
        BuiltInFunction::STR_TO_DATE,
        BuiltInFunction::STRCMP,
        BuiltInFunction::SUBDATE,
        BuiltInFunction::SUBSTR,
        BuiltInFunction::SUBSTRING,
        BuiltInFunction::SUBSTRING_INDEX,
        BuiltInFunction::SUBTIME,
        BuiltInFunction::SUM,
        BuiltInFunction::SYSDATE,
        BuiltInFunction::SYSTEM_USER,
        BuiltInFunction::TAN,
        BuiltInFunction::TIME,
        BuiltInFunction::TIME_FORMAT,
        BuiltInFunction::TIME_TO_SEC,
        BuiltInFunction::TIMEDIFF,
        BuiltInFunction::TIMESTAMP,
        BuiltInFunction::TIMESTAMPADD,
        BuiltInFunction::TIMESTAMPDIFF,
        BuiltInFunction::TO_BASE64,
        BuiltInFunction::TO_DAYS,
        BuiltInFunction::TO_SECONDS,
        BuiltInFunction::TRIM,
        BuiltInFunction::TRUNCATE,
        BuiltInFunction::UCASE,
        BuiltInFunction::UNCOMPRESS,
        BuiltInFunction::UNCOMPRESSED_LENGTH,
        BuiltInFunction::UNHEX,
        BuiltInFunction::UNIX_TIMESTAMP,
        BuiltInFunction::UpdateXML,
        BuiltInFunction::UPPER,
        BuiltInFunction::USER,
        BuiltInFunction::UTC_DATE,
        BuiltInFunction::UTC_TIME,
        BuiltInFunction::UTC_TIMESTAMP,
        BuiltInFunction::UUID,
        BuiltInFunction::UUID_SHORT,
        BuiltInFunction::UUID_TO_BIN,
        BuiltInFunction::VALIDATE_PASSWORD_STRENGTH,
        BuiltInFunction::VALUES,
        BuiltInFunction::VAR_POP,
        BuiltInFunction::VAR_SAMP,
        BuiltInFunction::VARIANCE,
        BuiltInFunction::VERSION,
        BuiltInFunction::WAIT_FOR_EXECUTED_GTID_SET,
        BuiltInFunction::WAIT_UNTIL_SQL_THREAD_AFTER_GTIDS,
        BuiltInFunction::WEEK,
        BuiltInFunction::WEEKDAY,
        BuiltInFunction::WEEKOFYEAR,
        BuiltInFunction::WEIGHT_STRING,
        BuiltInFunction::YEAR,
        BuiltInFunction::YEARWEEK,

        // deprecated, removed in 8.0
        BuiltInFunction::Area,
        BuiltInFunction::AsBinary,
        BuiltInFunction::AsText,
        BuiltInFunction::AsWKB,
        BuiltInFunction::AsWKT,
        BuiltInFunction::Buffer,
        BuiltInFunction::Centroid,
        BuiltInFunction::Contains,
        BuiltInFunction::ConvexHull,
        BuiltInFunction::Crosses,
        BuiltInFunction::Dimension,
        BuiltInFunction::Disjoint,
        BuiltInFunction::Distance,
        BuiltInFunction::EndPoint,
        BuiltInFunction::Envelope,
        BuiltInFunction::Equals,
        BuiltInFunction::ExteriorRing,
        BuiltInFunction::GeomCollFromText,
        BuiltInFunction::GeomCollFromWKB,
        BuiltInFunction::GeometryCollectionFromText,
        BuiltInFunction::GeometryCollectionFromWKB,
        BuiltInFunction::GeometryFromText,
        BuiltInFunction::GeometryFromWKB,
        BuiltInFunction::GeometryN,
        BuiltInFunction::GeometryType,
        BuiltInFunction::GeomFromText,
        BuiltInFunction::GeomFromWKB,
        BuiltInFunction::GLength,
        BuiltInFunction::InteriorRingN,
        BuiltInFunction::Intersects,
        BuiltInFunction::IsClosed,
        BuiltInFunction::IsEmpty,
        BuiltInFunction::IsSimple,
        BuiltInFunction::LineFromText,
        BuiltInFunction::LineFromWKB,
        BuiltInFunction::LineStringFromText,
        BuiltInFunction::LineStringFromWKB,
        BuiltInFunction::MLineFromText,
        BuiltInFunction::MLineFromWKB,
        BuiltInFunction::MPointFromText,
        BuiltInFunction::MPointFromWKB,
        BuiltInFunction::MPolyFromText,
        BuiltInFunction::MPolyFromWKB,
        BuiltInFunction::MultiLineStringFromText,
        BuiltInFunction::MultiLineStringFromWKB,
        BuiltInFunction::MultiPointFromText,
        BuiltInFunction::MultiPointFromWKB,
        BuiltInFunction::MultiPolygonFromText,
        BuiltInFunction::MultiPolygonFromWKB,
        BuiltInFunction::NumGeometries,
        BuiltInFunction::NumInteriorRings,
        BuiltInFunction::NumPoints,
        BuiltInFunction::Overlaps,
        BuiltInFunction::PointFromText,
        BuiltInFunction::PointFromWKB,
        BuiltInFunction::PointN,
        BuiltInFunction::PolyFromText,
        BuiltInFunction::PolyFromWKB,
        BuiltInFunction::PolygonFromText,
        BuiltInFunction::PolygonFromWKB,
        BuiltInFunction::SRID,
        BuiltInFunction::StartPoint,
        BuiltInFunction::Touches,
        BuiltInFunction::Within,
        BuiltInFunction::X,
        BuiltInFunction::Y,
    ];

    /**
     * @return string[]
     */
    public function getReservedWords(): array
    {
        return self::RESERVED_WORDS;
    }

    /**
     * @return string[]
     */
    public function getNonReservedWords(): array
    {
        return self::NON_RESERVED_WORDS;
    }

    /**
     * @return string[]
     */
    public function getOperatorKeywords(): array
    {
        return self::OPERATOR_KEYWORDS;
    }

    /**
     * @return string[]
     */
    public function getOperators(): array
    {
        return self::OPERATORS;
    }

    /**
     * @return string[]
     */
    public function getTypes(): array
    {
        return self::TYPES;
    }

    /**
     * @return string[]
     */
    public function getTypeAliases(): array
    {
        return self::TYPE_ALIASES;
    }

    /**
     * @return string[]
     */
    public function getBuiltInFunctions(): array
    {
        return self::BUILT_IN_FUNCTIONS;
    }

    /**
     * @return string[]
     */
    public function getSystemVariables(): array
    {
        // todo
        return [];
    }

}
