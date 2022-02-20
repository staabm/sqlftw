<?php declare(strict_types = 1);
/**
 * This file is part of the SqlFtw library (https://github.com/sqlftw)
 *
 * Copyright (c) 2017 Vlasta Neubauer (@paranoiq)
 *
 * For the full copyright and license information read the file 'license.md', distributed with this source code
 */

namespace SqlFtw\Parser\Dml;

use Dogma\StrictBehaviorMixin;
use SqlFtw\Parser\TokenList;
use SqlFtw\Parser\TokenType;
use SqlFtw\Sql\Command;
use SqlFtw\Sql\Dml\XaTransaction\XaCommitCommand;
use SqlFtw\Sql\Dml\XaTransaction\XaEndCommand;
use SqlFtw\Sql\Dml\XaTransaction\XaPrepareCommand;
use SqlFtw\Sql\Dml\XaTransaction\XaRecoverCommand;
use SqlFtw\Sql\Dml\XaTransaction\XaRollbackCommand;
use SqlFtw\Sql\Dml\XaTransaction\XaStartCommand;
use SqlFtw\Sql\Dml\XaTransaction\XaStartOption;
use SqlFtw\Sql\Dml\XaTransaction\Xid;
use SqlFtw\Sql\Keyword;

class XaTransactionCommandsParser
{
    use StrictBehaviorMixin;

    /**
     * XA {START|BEGIN} xid [JOIN|RESUME]
     *
     * XA END xid [SUSPEND [FOR MIGRATE]]
     *
     * XA PREPARE xid
     *
     * XA COMMIT xid [ONE PHASE]
     *
     * XA ROLLBACK xid
     *
     * XA RECOVER [CONVERT XID]
     */
    public function parseXa(TokenList $tokenList): Command
    {
        $tokenList->expectKeyword(Keyword::XA);
        $second = $tokenList->expect(TokenType::KEYWORD)->value;
        switch ($second) {
            case Keyword::START:
            case Keyword::BEGIN:
                $xid = $this->parseXid($tokenList);
                /** @var XaStartOption $option */
                $option = $tokenList->getKeywordEnum(XaStartOption::class);
                $tokenList->expectEnd();

                return new XaStartCommand($xid, $option);
            case Keyword::END:
                $xid = $this->parseXid($tokenList);
                $suspend = $tokenList->hasKeyword(Keyword::SUSPEND);
                $forMigrate = $suspend && $tokenList->hasKeywords(Keyword::FOR, Keyword::MIGRATE);
                $tokenList->expectEnd();

                return new XaEndCommand($xid, $suspend, $forMigrate);
            case Keyword::PREPARE:
                $xid = $this->parseXid($tokenList);
                $tokenList->expectEnd();

                return new XaPrepareCommand($xid);
            case Keyword::COMMIT:
                $xid = $this->parseXid($tokenList);
                $onePhase = $tokenList->hasKeywords(Keyword::ONE, Keyword::PHASE);
                $tokenList->expectEnd();

                return new XaCommitCommand($xid, $onePhase);
            case Keyword::ROLLBACK:
                $xid = $this->parseXid($tokenList);
                $tokenList->expectEnd();

                return new XaRollbackCommand($xid);
            case Keyword::RECOVER:
                $convertXid = $tokenList->hasKeywords(Keyword::CONVERT, Keyword::XID);
                $tokenList->expectEnd();

                return new XaRecoverCommand($convertXid);
            default:
                $tokenList->expectedAnyKeyword(
                    Keyword::START,
                    Keyword::BEGIN,
                    Keyword::END,
                    Keyword::PREPARE,
                    Keyword::COMMIT,
                    Keyword::ROLLBACK,
                    Keyword::RECOVER
                );
        }
    }

    /**
     * xid: gtrid [, bqual [, formatID ]]
     */
    private function parseXid(TokenList $tokenList): Xid
    {
        $transactionId = $tokenList->expectString();
        $branch = $format = null;
        if ($tokenList->hasComma()) {
            $branch = $tokenList->expectString();
            if ($tokenList->hasComma()) {
                /** @var int $format */
                $format = $tokenList->expectInt();
            }
        }

        return new Xid($transactionId, $branch, $format);
    }

}