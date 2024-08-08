<?php declare(strict_types = 1);

namespace SqlFtw\Parser;

use SqlFtw\Platform\Platform;

class ParserConfig
{

    private int $clientSideExtensions;

    private bool $tokenizeComments;

    private bool $tokenizeWhitespace;

    private bool $provideTokenLists;

    public function __construct(
        int $clientSideExtensions = 0,
        bool $tokenizeComments = true,
        bool $tokenizeWhitespace = false,
        bool $provideTokenLists = false
    ) {
        $this->clientSideExtensions = $clientSideExtensions;
        $this->tokenizeComments = $tokenizeComments;
        $this->tokenizeWhitespace = $tokenizeWhitespace;
        $this->provideTokenLists = $provideTokenLists;
    }

    public function getClientSideExtensions(): int
    {
        return $this->clientSideExtensions;
    }

    public function tokenizeComments(): bool
    {
        return $this->tokenizeComments;
    }

    public function tokenizeWhitespace(): bool
    {
        return $this->tokenizeWhitespace;
    }

    public function provideTokenLists(): bool
    {
        return $this->provideTokenLists;
    }

}