<?php
/**
 * This file is part of the SqlFtw library (https://github.com/sqlftw)
 *
 * Copyright (c) 2017 Vlasta Neubauer (@paranoiq)
 *
 * For the full copyright and license information read the file 'license.md', distributed with this source code
 */

namespace SqlFtw\Parser;

use SqlFtw\Platform\Settings;
use SqlFtw\Sql\Command;
use SqlFtw\Sql\Keyword;
use SqlFtw\Parser\Lexer\Lexer;

class Parser
{
    use \Dogma\StrictBehaviorMixin;

    /** @var \SqlFtw\Parser\Lexer\Lexer */
    private $lexer;

    /** @var \SqlFtw\Parser\ParserFactory */
    private $factory;

    /** @var \SqlFtw\Platform\Settings */
    private $settings;

    public function __construct(Lexer $lexer, Settings $settings)
    {
        $this->lexer = $lexer;
        $this->settings = $settings;
        $this->factory = new ParserFactory($settings);
    }

    /**
     * @param string $sql
     * @return \SqlFtw\Sql\Command[]
     */
    public function parse(string $sql): array
    {
        $tokens = $this->lexer->tokenize($sql, $this->settings);
        $tokenLists = $this->slice($tokens);

        $commands = [];
        foreach ($tokenLists as $tokenList) {
            $commands[] = $this->parseCommand($tokenList);
            $tokenList->expectEnd();
        }

        return $commands;
    }

    /**
     * @param \SqlFtw\Parser\Token[] $tokens
     * @return \SqlFtw\Parser\TokenList[]
     */
    private function slice(array $tokens): array
    {
        $lists = [];
        $n = 0;
        foreach ($tokens as $token) {
            if ($token->type & TokenType::DELIMITER) {
                $lists[$n] = new TokenList($lists[$n]);
                $n++;
            } else {
                $lists[$n][] = $token;
            }
        }
        return $lists;
    }

    public function parseCommand(TokenList $tokenList): Command
    {
        $start = $tokenList->getPosition();
        $tokenList->addAutoSkip(TokenType::get(TokenType::WHITESPACE));
        $tokenList->addAutoSkip(TokenType::get(TokenType::COMMENT));

        $first = $tokenList->consume(TokenType::KEYWORD);
        switch ($first->value) {
            case Keyword::ALTER:
                $second = $tokenList->consume(TokenType::KEYWORD);
                switch ($second->value) {
                    case Keyword::DATABASE:
                    case Keyword::SCHEMA:
                        // ALTER {DATABASE|SCHEMA}
                        return $this->factory->getDatabaseCommandsParser()->parseAlterDatabase($tokenList->resetPosition($start));
                    case Keyword::FUNCTION:
                        // ALTER FUNCTION
                        return $this->factory->getRoutineCommandsParser()->parseAlterFunction($tokenList->resetPosition($start));
                    case Keyword::INSTANCE:
                        // ALTER INSTANCE
                        return $this->factory->getInstanceCommandParser()->parseAlterInstance($tokenList->resetPosition($start));
                    case Keyword::LOGFILE:
                        // ALTER LOGFILE GROUP
                        return $this->factory->getLogfileGroupCommandsParser()->parseAlterLogfileGroup($tokenList->resetPosition($start));
                    case Keyword::SERVER:
                        // ALTER SERVER
                        return $this->factory->getServerCommandsParser()->parseAlterServer($tokenList->resetPosition($start));
                    case Keyword::TABLE:
                        // ALTER TABLE
                        return $this->factory->getTableCommandsParser()->parseAlterTable($tokenList->resetPosition($start));
                    case Keyword::TABLESPACE:
                        // ALTER TABLESPACE
                        return $this->factory->getTablespaceCommandsParser()->parseAlterTablespace($tokenList->resetPosition($start));
                    case Keyword::USER:
                        // ALTER USER
                        return $this->factory->getUserCommandsParser()->parseAlterUser($tokenList->resetPosition($start));
                }
                if ($tokenList->seekKeyword(Keyword::EVENT, 5)) {
                    // ALTER [DEFINER = { user | CURRENT_USER }] EVENT
                    return $this->factory->getEventCommandsParser()->parseAlterEvent($tokenList->resetPosition($start));
                } elseif ($tokenList->seekKeyword(Keyword::VIEW, 15)) {
                    // ALTER [ALGORITHM = {UNDEFINED | MERGE | TEMPTABLE}] [DEFINER = { user | CURRENT_USER }] [SQL SECURITY { DEFINER | INVOKER }] VIEW
                    return $this->factory->getViewCommandsParser()->parseAlterView($tokenList->resetPosition($start));
                }
                $tokenList->expectedAnyKeyword(
                    Keyword::DATABASE, Keyword::SCHEMA, Keyword::FUNCTION, Keyword::INSTANCE, Keyword::LOGFILE,
                    Keyword::SERVER, Keyword::TABLE, Keyword::TABLESPACE, Keyword::USER, Keyword::EVENT, Keyword::VIEW
                );
                exit;
            case Keyword::ANALYZE:
                // ANALYZE
                return $this->factory->getTableMaintenanceCommandsParser()->parseAnalyzeTable($tokenList->resetPosition($start));
            case Keyword::BEGIN:
                // BEGIN
                return $this->factory->getTransactionCommandsParser()->parseStartTransaction($tokenList->resetPosition($start));
            case Keyword::BINLOG:
                // BINLOG
                return $this->factory->getBinlogCommandParser()->parseBinlog($tokenList->resetPosition($start));
            case Keyword::CACHE:
                // CACHE INDEX
                return $this->factory->getCacheCommandsParser()->parseCacheIndex($tokenList->resetPosition($start));
            case Keyword::CALL:
                // CALL
                return $this->factory->getCallCommandParser()->parseCall($tokenList->resetPosition($start));
            case Keyword::CHANGE:
                $second = $tokenList->consume(TokenType::KEYWORD);
                if ($second->value === Keyword::MASTER) {
                    // CHANGE MASTER TO
                    return $this->factory->getReplicationCommandsParser()->parseChangeMasterTo($tokenList->resetPosition($start));
                } elseif ($second->value === Keyword::REPLICATION) {
                    // CHANGE REPLICATION FILTER
                    return $this->factory->getReplicationCommandsParser()->parseChangeReplicationFilter($tokenList->resetPosition($start));
                }
                $tokenList->expectedAnyKeyword(Keyword::MASTER, Keyword::REPLICATION);
                exit;
            case Keyword::CHECK:
                // CHECK TABLE
                return $this->factory->getTableMaintenanceCommandsParser()->parseCheckTable($tokenList->resetPosition($start));
            case Keyword::CHECKSUM:
                // CHECKSUM TABLE
                return $this->factory->getTableMaintenanceCommandsParser()->parseChecksumTable($tokenList->resetPosition($start));
            case Keyword::COMMIT:
                // COMMIT
                return $this->factory->getTransactionCommandsParser()->parseCommit($tokenList->resetPosition($start));
            case Keyword::CREATE:
                $second = $tokenList->consume(TokenType::KEYWORD);
                switch ($second->value) {
                    case Keyword::DATABASE:
                    case Keyword::SCHEMA:
                        // CREATE {DATABASE | SCHEMA}
                        return $this->factory->getDatabaseCommandsParser()->parseCreateDatabase($tokenList->resetPosition($start));
                    case Keyword::LOGFILE:
                        // CREATE LOGFILE GROUP
                        return $this->factory->getLogfileGroupCommandsParser()->parseCreateLogfileGroup($tokenList->resetPosition($start));
                    case Keyword::ROLE:
                        // CREATE ROLE
                        return $this->factory->getUserCommandsParser()->parseCreateRole($tokenList->resetPosition($start));
                    case Keyword::SERVER:
                        // CREATE SERVER
                        return $this->factory->getServerCommandsParser()->parseCreateServer($tokenList->resetPosition($start));
                    case Keyword::TABLESPACE:
                        // CREATE TABLESPACE
                        return $this->factory->getTablespaceCommandsParser()->parseCreateTablespace($tokenList->resetPosition($start));
                    case Keyword::USER:
                        // CREATE USER
                        return $this->factory->getUserCommandsParser()->parseCreateUser($tokenList->resetPosition($start));
                }
                if ($tokenList->seekKeyword(Keyword::EVENT, 5)) {
                    // CREATE [DEFINER = { user | CURRENT_USER }] EVENT
                    return $this->factory->getEventCommandsParser()->parseCreateEvent($tokenList->resetPosition($start));
                } elseif ($tokenList->seekKeyword(Keyword::SONAME, 8)) {
                    // CREATE [AGGREGATE] FUNCTION function_name RETURNS {STRING|INTEGER|REAL|DECIMAL} SONAME
                    return $this->factory->getCreateFunctionCommandParser()->parseCreateFunction($tokenList->resetPosition($start));
                } elseif ($tokenList->seekKeyword(Keyword::FUNCTION, 5)) {
                    // CREATE [DEFINER = { user | CURRENT_USER }] FUNCTION
                    return $this->factory->getRoutineCommandsParser()->parseCreateFunction($tokenList->resetPosition($start));
                } elseif ($tokenList->seekKeyword(Keyword::INDEX, 2)) {
                    // CREATE [UNIQUE|FULLTEXT|SPATIAL] INDEX
                    return $this->factory->getIndexCommandsParser()->parseCreateIndex($tokenList->resetPosition($start));
                } elseif ($tokenList->seekKeyword(Keyword::PROCEDURE, 5)) {
                    // CREATE [DEFINER = { user | CURRENT_USER }] PROCEDURE
                    return $this->factory->getRoutineCommandsParser()->parseCreateProcedure($tokenList->resetPosition($start));
                } elseif ($tokenList->seekKeyword(Keyword::TABLE, 2)) {
                    // CREATE [TEMPORARY] TABLE
                    return $this->factory->getTableCommandsParser()->parseCreateTable($tokenList->resetPosition($start));
                } elseif ($tokenList->seekKeyword(Keyword::TRIGGER, 5)) {
                    // CREATE [DEFINER = { user | CURRENT_USER }] TRIGGER
                    return $this->factory->getTriggerCommandsParser($this)->parseCreateTrigger($tokenList->resetPosition($start));
                } elseif ($tokenList->seekKeyword(Keyword::VIEW, 15)) {
                    // CREATE [OR REPLACE] [ALGORITHM = {UNDEFINED | MERGE | TEMPTABLE}] [DEFINER = { user | CURRENT_USER }] [SQL SECURITY { DEFINER | INVOKER }] VIEW
                    return $this->factory->getViewCommandsParser()->parseCreateView($tokenList->resetPosition($start));
                }
                $tokenList->expectedAnyKeyword(
                    Keyword::DATABASE, Keyword::SCHEMA, Keyword::LOGFILE, Keyword::ROLE, Keyword::SERVER,
                    Keyword::TABLESPACE, Keyword::TABLE, Keyword::USER, Keyword::EVENT, Keyword::FUNCTION,
                    Keyword::INDEX, Keyword::PROCEDURE, Keyword::TABLE, Keyword::TRIGGER, Keyword::VIEW
                );
                exit;
            case Keyword::DEALLOCATE:
                // {DEALLOCATE | DROP} PREPARE
                return $this->factory->getPreparedCommandsParser()->parseDeallocatePrepare($tokenList->resetPosition($start));
            case Keyword::DELETE:
                // DELETE
                return $this->factory->getDeleteCommandParser()->parseDelete($tokenList->resetPosition($start));
            case Keyword::DELIMITER:
                // DELIMITER
                return $this->factory->getDelimiterCommandParser()->parseDelimiter($tokenList->resetPosition($start));
            case Keyword::DESC:
                // DESC
                return $this->factory->getExplainCommandParser()->parseExplain($tokenList->resetPosition($start));
            case Keyword::DESCRIBE:
                // DESCRIBE
                return $this->factory->getExplainCommandParser()->parseExplain($tokenList->resetPosition($start));
            case Keyword::DO:
                // DO
                return $this->factory->getDoCommandParser()->parseDo($tokenList->resetPosition($start));
            case Keyword::DROP:
                $second = $tokenList->consume(TokenType::KEYWORD);
                switch ($second->value) {
                    case Keyword::DATABASE:
                    case Keyword::SCHEMA:
                        // DROP {DATABASE | SCHEMA}
                        return $this->factory->getDatabaseCommandsParser()->parseDropDatabase($tokenList->resetPosition($start));
                    case Keyword::EVENT:
                        // DROP EVENT
                        return $this->factory->getEventCommandsParser()->parseDropEvent($tokenList->resetPosition($start));
                    case Keyword::FUNCTION:
                        // DROP {PROCEDURE | FUNCTION}
                        return $this->factory->getRoutineCommandsParser()->parseDropFunction($tokenList->resetPosition($start));
                    case Keyword::INDEX:
                        // DROP INDEX
                        return $this->factory->getIndexCommandsParser()->parseDropIndex($tokenList->resetPosition($start));
                    case Keyword::LOGFILE:
                        // DROP LOGFILE GROUP
                        return $this->factory->getLogfileGroupCommandsParser()->parseDropLogfileGroup($tokenList->resetPosition($start));
                    case Keyword::PREPARE:
                        // {DEALLOCATE | DROP} PREPARE
                        return $this->factory->getPreparedCommandsParser()->parseDeallocatePrepare($tokenList->resetPosition($start));
                    case Keyword::PROCEDURE:
                        // DROP {PROCEDURE | FUNCTION}
                        return $this->factory->getRoutineCommandsParser()->parseDropProcedure($tokenList->resetPosition($start));
                    case Keyword::ROLE:
                        // DROP ROLE
                        return $this->factory->getUserCommandsParser()->parseDropRole($tokenList->resetPosition($start));
                    case Keyword::SERVER:
                        // DROP SERVER
                        return $this->factory->getServerCommandsParser()->parseDropServer($tokenList->resetPosition($start));
                    case Keyword::TABLE:
                    case Keyword::TEMPORARY:
                        // DROP [TEMPORARY] TABLE
                        return $this->factory->getTableCommandsParser()->parseDropTable($tokenList->resetPosition($start));
                    case Keyword::TABLESPACE:
                        // DROP TABLESPACE
                        return $this->factory->getTablespaceCommandsParser()->parseDropTablespace($tokenList->resetPosition($start));
                    case Keyword::TRIGGER:
                        // DROP TRIGGER
                        return $this->factory->getTriggerCommandsParser($this)->parseDropTrigger($tokenList->resetPosition($start));
                    case Keyword::USER:
                        // DROP USER
                        return $this->factory->getUserCommandsParser()->parseDropUser($tokenList->resetPosition($start));
                    case Keyword::VIEW:
                        // DROP VIEW
                        return $this->factory->getViewCommandsParser()->parseDropView($tokenList->resetPosition($start));
                }
                $tokenList->expectedAnyKeyword(
                    Keyword::DATABASE, Keyword::SCHEMA, Keyword::EVENT, Keyword::FUNCTION, Keyword::INDEX,
                    Keyword::LOGFILE, Keyword::PREPARE, Keyword::PROCEDURE, Keyword::ROLE, Keyword::SERVER,
                    Keyword::TABLESPACE, Keyword::TRIGGER, Keyword::USER, Keyword::VIEW
                );
                exit;
            case Keyword::EXECUTE:
                // EXECUTE
                return $this->factory->getPreparedCommandsParser()->parseExecute($tokenList->resetPosition($start));
            case Keyword::EXPLAIN:
                // EXPLAIN
                return $this->factory->getExplainCommandParser()->parseExplain($tokenList->resetPosition($start));
            case Keyword::FLUSH:
                $second = $tokenList->consume(TokenType::KEYWORD);
                if ($second->value === Keyword::TABLES) {
                    // FLUSH TABLES
                    return $this->factory->getFlushCommandParser()->parseFlushTables($tokenList->resetPosition($start));
                }
                // FLUSH
                return $this->factory->getFlushCommandParser()->parseFlush($tokenList->resetPosition($start));
            case Keyword::GRANT:
                // GRANT
                return $this->factory->getUserCommandsParser()->parseGrant($tokenList->resetPosition($start));
            case Keyword::HANDLER:
                // HANDLER
                if ($tokenList->seekKeyword(Keyword::OPEN, 10)) {
                    return $this->factory->getHandlerCommandParser()->parseHandlerOpen($tokenList->resetPosition($start));
                } elseif ($tokenList->seekKeyword(Keyword::READ, 10)) {
                    return $this->factory->getHandlerCommandParser()->parseHandlerRead($tokenList->resetPosition($start));
                } elseif ($tokenList->seekKeyword(Keyword::CLOSE, 10)) {
                    return $this->factory->getHandlerCommandParser()->parseHandlerClose($tokenList->resetPosition($start));
                }
                $tokenList->expectedAnyKeyword(Keyword::OPEN, Keyword::READ, Keyword::CLOSE);
                exit;
            case Keyword::HELP:
                // HELP
                return $this->factory->getHelpCommandParser()->parseHelp($tokenList->resetPosition($start));
            case Keyword::INSERT:
                // INSERT
                return $this->factory->getInsertCommandParser()->parseInsert($tokenList->resetPosition($start));
            case Keyword::INSTALL:
                $second = $tokenList->consume(TokenType::KEYWORD);
                if ($second === Keyword::COMPONENT) {
                    // INSTALL COMPONENT
                    return $this->factory->getComponentCommandsParser()->parseInstallComponent($tokenList->resetPosition($start));
                } elseif ($second === Keyword::PLUGIN) {
                    // INSTALL PLUGIN
                    return $this->factory->getPluginCommandsParser()->parseInstallPlugin($tokenList->resetPosition($start));
                }
                $tokenList->expectedAnyKeyword(Keyword::COMPONENT, Keyword::PLUGIN);
                exit;
            case Keyword::KILL:
                // KILL
                return $this->factory->getKillCommandParser()->parseKill($tokenList->resetPosition($start));
            case Keyword::LOCK:
                // LOCK TABLES
                return $this->factory->getTransactionCommandsParser()->parseLockTables($tokenList->resetPosition($start));
            case Keyword::LOAD:
                $second = $tokenList->consume(TokenType::KEYWORD);
                if ($second === Keyword::DATA) {
                    // LOAD DATA
                    return $this->factory->getLoadCommandsParser()->parseLoadData($tokenList->resetPosition($start));
                } elseif ($second === Keyword::INDEX) {
                    // LOAD INDEX INTO CACHE
                    return $this->factory->getCacheCommandsParser()->parseLoadIndexIntoCache($tokenList->resetPosition($start));
                } elseif ($second === Keyword::XML) {
                    // LOAD XML
                    return $this->factory->getLoadCommandsParser()->parseLoadXml($tokenList->resetPosition($start));
                }
                $tokenList->expectedAnyKeyword(Keyword::DATA, Keyword::INDEX, Keyword::XML);
                exit;
            case Keyword::OPTIMIZE:
                // OPTIMIZE
                return $this->factory->getTableMaintenanceCommandsParser()->parseOptimizeTable($tokenList->resetPosition($start));
            case Keyword::PREPARE:
                // PREPARE
                return $this->factory->getPreparedCommandsParser()->parsePrepare($tokenList->resetPosition($start));
            case Keyword::PURGE:
                // PURGE { BINARY | MASTER } LOGS
                return $this->factory->getReplicationCommandsParser()->parsePurgeBinaryLogs($tokenList->resetPosition($start));
            case Keyword::RELEASE:
                // RELEASE SAVEPOINT
                return $this->factory->getTransactionCommandsParser()->parseReleaseSavepoint($tokenList->resetPosition($start));
            case Keyword::RENAME:
                $second = $tokenList->consume(TokenType::KEYWORD);
                if ($second->value === Keyword::TABLE) {
                    // RENAME TABLE
                    return $this->factory->getTableCommandsParser()->parseRenameTable($tokenList->resetPosition($start));
                } elseif ($second->value === Keyword::USER) {
                    // RENAME USER
                    return $this->factory->getUserCommandsParser()->parseRenameUser($tokenList->resetPosition($start));
                }
                $tokenList->expectedAnyKeyword(Keyword::TABLE, Keyword::USER);
                exit;
            case Keyword::REPAIR:
                // REPAIR
                return $this->factory->getTableMaintenanceCommandsParser()->parseRepairTable($tokenList->resetPosition($start));
            case Keyword::REPLACE:
                // REPLACE
                return $this->factory->getInsertCommandParser()->parseReplace($tokenList->resetPosition($start));
            case Keyword::RESET:
                if ($tokenList->seekKeyword(Keyword::PERSIST, 2)) {
                    // RESET PERSIST
                    return $this->factory->getResetPersistCommandParser()->parseResetPersist($tokenList->resetPosition($start));
                } elseif ($tokenList->seek(TokenType::COMMA, 8) || $tokenList->seekKeyword(Keyword::QUERY, 8)) {
                    // RESET MASTER, SLAVE, QUERY CACHE
                    return $this->factory->getResetCommandParser()->parseReset($tokenList->resetPosition($start));
                } elseif ($tokenList->seekKeyword(Keyword::MASTER, 2)) {
                    // RESET MASTER
                    return $this->factory->getReplicationCommandsParser()->parseResetMaster($tokenList->resetPosition($start));
                } elseif ($tokenList->seekKeyword(Keyword::SLAVE, 2)) {
                    // RESET SLAVE
                    return $this->factory->getReplicationCommandsParser()->parseResetSlave($tokenList->resetPosition($start));
                }
                $tokenList->expectedAnyKeyword(Keyword::PERSIST, Keyword::MASTER, Keyword::SLAVE, Keyword::QUERY);
                exit;
            case Keyword::REVOKE:
                // REVOKE
                return $this->factory->getUserCommandsParser()->parseRevoke($tokenList->resetPosition($start));
            case Keyword::ROLLBACK:
                // ROLLBACK
                return $this->factory->getTransactionCommandsParser()->parseRollback($tokenList->resetPosition($start));
            case Keyword::SAVEPOINT:
                // SAVEPOINT
                return $this->factory->getTransactionCommandsParser()->parseSavepoint($tokenList->resetPosition($start));
            case Keyword::SELECT:
                // SELECT
                return $this->factory->getSelectCommandParser()->parseSelect($tokenList->resetPosition($start));
            case Keyword::SET:
                $second = $tokenList->consume(TokenType::KEYWORD);
                switch ($second->value) {
                    case Keyword::CHARACTER:
                    case Keyword::CHARSET:
                        // SET {CHARACTER SET | CHARSET}
                        return $this->factory->getCharsetCommandsParser()->parseSetCharacterSet($tokenList->resetPosition($start));
                    case Keyword::DEFAULT:
                        // SET DEFAULT ROLE
                        return $this->factory->getUserCommandsParser()->parseSetDefaultRole($tokenList->resetPosition($start));
                    case Keyword::NAMES:
                        // SET NAMES
                        return $this->factory->getCharsetCommandsParser()->parseSetNames($tokenList->resetPosition($start));
                    case Keyword::PASSWORD:
                        // SET PASSWORD
                        return $this->factory->getUserCommandsParser()->parseSetPassword($tokenList->resetPosition($start));
                    case Keyword::ROLE:
                        // SET ROLE
                        return $this->factory->getUserCommandsParser()->parseSetRole($tokenList->resetPosition($start));
                }
                if ($tokenList->seekKeyword(Keyword::TRANSACTION, 2)) {
                    // SET [GLOBAL | SESSION] TRANSACTION
                    return $this->factory->getTransactionCommandsParser()->parseSetTransaction($tokenList->resetPosition($start));
                }
                // SET
                return $this->factory->getSetCommandParser()->parseSet($tokenList->resetPosition($start));
            case Keyword::SHOW:
                // SHOW
                return $this->factory->getShowCommandsParser()->parseShow($tokenList->resetPosition($start));
            case Keyword::SHUTDOWN:
                // SHUTDOWN
                return $this->factory->getShutdownCommandParser()->parseShutdown($tokenList->resetPosition($start));
            case Keyword::START:
                $second = $tokenList->consume(TokenType::KEYWORD);
                if ($second === Keyword::GROUP_REPLICATION) {
                    // START GROUP_REPLICATION
                    return $this->factory->getReplicationCommandsParser()->parseStartGroupReplication($tokenList->resetPosition($start));
                } elseif ($second->value === Keyword::SLAVE) {
                    // START SLAVE
                    return $this->factory->getReplicationCommandsParser()->parseStartSlave($tokenList->resetPosition($start));
                } elseif ($second->value === Keyword::TRANSACTION) {
                    // START TRANSACTION
                    return $this->factory->getTransactionCommandsParser()->parseStartTransaction($tokenList->resetPosition($start));
                }
                $tokenList->expectedAnyKeyword(Keyword::GROUP_REPLICATION, Keyword::SLAVE, Keyword::TRANSACTION);
                exit;
            case Keyword::STOP:
                $second = $tokenList->consume(TokenType::KEYWORD);
                if ($second->value === Keyword::GROUP_REPLICATION) {
                    // STOP GROUP_REPLICATION
                    return $this->factory->getReplicationCommandsParser()->parseStopGroupReplication($tokenList->resetPosition($start));
                } elseif ($second->value === Keyword::SLAVE) {
                    // STOP SLAVE
                    return $this->factory->getReplicationCommandsParser()->parseStopSlave($tokenList->resetPosition($start));
                }
                $tokenList->expectedAnyKeyword(Keyword::GROUP_REPLICATION, Keyword::SLAVE);
                exit;
            case Keyword::TRUNCATE:
                // TRUNCATE [TABLE]
                return $this->factory->getTableCommandsParser()->parseTruncateTable($tokenList->resetPosition($start));
            case Keyword::UNINSTALL:
                $second = $tokenList->consume(TokenType::KEYWORD);
                if ($second->value === Keyword::COMPONENT) {
                    // UNINSTALL COMPONENT
                    return $this->factory->getComponentCommandsParser()->parseUninstallComponent($tokenList->resetPosition($start));
                } elseif ($second->value === Keyword::PLUGIN) {
                    // UNINSTALL PLUGIN
                    return $this->factory->getPluginCommandsParser()->parseUninstallPlugin($tokenList->resetPosition($start));
                }
                $tokenList->expectedAnyKeyword(Keyword::COMPONENT, Keyword::PLUGIN);
                exit;
            case Keyword::UNLOCK:
                // UNLOCK TABLES
                return $this->factory->getTransactionCommandsParser()->parseUnlockTables($tokenList->resetPosition($start));
            case Keyword::UPDATE:
                // UPDATE
                return $this->factory->getUpdateCommandParser()->parseUpdate($tokenList->resetPosition($start));
            case Keyword::USE:
                // USE
                return $this->factory->getUseCommandParser()->parseUse($tokenList->resetPosition($start));
            case Keyword::WITH:
                // WITH
                return $this->factory->getWithParser()->parseWith($tokenList->resetPosition($start));
            case Keyword::XA:
                // XA {START|BEGIN}
                // XA END
                // XA PREPARE
                // XA COMMIT
                // XA ROLLBACK
                // XA RECOVER
                return $this->factory->getXaTransactionCommandsParser()->parseXa($tokenList->resetPosition($start));
            default:
                $tokenList->expectedAnyKeyword(
                    Keyword::ALTER, Keyword::ANALYZE, Keyword::BEGIN, Keyword::BINLOG, Keyword::CACHE,
                    Keyword::CALL, Keyword::CHANGE, Keyword::CHECK, Keyword::CHECKSUM, Keyword::COMMIT, Keyword::CREATE,
                    Keyword::DEALLOCATE, Keyword::DELETE, Keyword::DELIMITER, Keyword::DESC, Keyword::DESCRIBE,
                    Keyword::DO, Keyword::DROP, Keyword::EXECUTE, Keyword::EXPLAIN, Keyword::FLUSH, Keyword::GRANT,
                    Keyword::HANDLER, Keyword::HELP, Keyword::INSERT, Keyword::INSTALL, Keyword::KILL, Keyword::LOCK,
                    Keyword::LOAD, Keyword::OPTIMIZE, Keyword::PREPARE, Keyword::PURGE, Keyword::RELEASE, Keyword::RENAME,
                    Keyword::REPAIR, Keyword::RELEASE, Keyword::RESET, Keyword::REVOKE, Keyword::ROLLBACK, Keyword::SAVEPOINT,
                    Keyword::SELECT, Keyword::SET, Keyword::SHOW, Keyword::SHUTDOWN, Keyword::START, Keyword::STOP,
                    Keyword::TRUNCATE, Keyword::UNINSTALL, Keyword::UNLOCK, Keyword::UPDATE, Keyword::USE, Keyword::WITH, Keyword::XA
                );
                exit;
        }
    }

}