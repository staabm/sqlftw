<?php declare(strict_types = 1);
/**
 * This file is part of the SqlFtw library (https://github.com/sqlftw)
 *
 * Copyright (c) 2017 Vlasta Neubauer (@paranoiq)
 *
 * For the full copyright and license information read the file 'license.md', distributed with this source code
 */

namespace SqlFtw\Parser;

use Dogma\Re;
use Dogma\StrictBehaviorMixin;
use SqlFtw\Platform\PlatformSettings;
use SqlFtw\Sql\Expression\Operator;
use SqlFtw\Sql\SqlEnum;
use function array_values;
use function call_user_func;
use function count;
use function implode;
use function in_array;
use function is_bool;
use function is_int;
use function sprintf;
use function trim;

/**
 * Holds list of lexer tokens and a pointer to current token
 *
 * Method names explanation:
 * - seekFoo() - seeks token forward without consuming it
 * - hasFoo() - consume token if exists and return bool
 * - hasFoos() - consume all tokens if exist and return bool
 * - hasAnyFoo - consume one token and return bool
 * - getFoo() - consume token if exists and return it
 * - getFoos() - consume all tokens if exist and return it (serialized)
 * - getAnyFoo - consume one token if exists and return it
 * - passFoo() - consume token if exists, return nothing
 * - passFoos() - consume all tokens if they exist, return nothing
 * - passAnyFoo() - consume one token if exists, return nothing
 * - expectFoo() - consume token or throw an exception
 * - expectFoos() - consume all tokens or throw an exception
 * - expectAnyFoo() - consume one token or throw an exception
 * - expectedFoo() - always throws an exception (just formats the error message)
 */
class TokenList
{
    use StrictBehaviorMixin;

    /** @var Token[] */
    private $tokens;

    /** @var PlatformSettings */
    private $settings;

    /** @var bool */
    private $whitespace;

    /** @var int */
    private $autoSkip = 0;

    /** @var int */
    private $position = 0;

    /**
     * @param Token[] $tokens
     */
    public function __construct(array $tokens, PlatformSettings $settings, bool $whitespace = true)
    {
        $this->tokens = $tokens;
        $this->settings = $settings;
        $this->whitespace = $whitespace;
    }

    public function getSettings(): PlatformSettings
    {
        return $this->settings;
    }

    public function isFinished(): bool
    {
        return $this->position >= count($this->tokens);
    }

    public function getPosition(): int
    {
        return $this->position;
    }

    public function resetPosition(int $position = 0): self
    {
        if ($position < 0) {
            $this->position += $position;
        } else {
            $this->position = $position;
        }

        return $this;
    }

    public function addAutoSkip(TokenType $tokenType): void
    {
        $this->autoSkip |= $tokenType->getValue();
    }

    private function doAutoSkip(): void
    {
        $token = $this->tokens[$this->position] ?? null;
        while ($token !== null && ($this->autoSkip & $token->type) !== 0) {
            $this->position++;
            $token = $this->tokens[$this->position] ?? null;
        }
    }

    /**
     * @return Token[]
     */
    public function getTokens(int $position, int $count): array
    {
        $tokens = [];
        for ($n = 0; $n < $count; $n++) {
            if (isset($this->tokens[$position + $n])) {
                $tokens[] = $this->tokens[$position + $n];
            }
        }

        return $tokens;
    }

    public function serialize(): string
    {
        $result = '';
        foreach ($this->tokens as $token) {
            $result .= $token->original ?? $token->value;
            if (!$this->whitespace) {
                $result .= ' ';
            }
        }

        return trim($result);
    }

    public function onlyContainsComments(): bool
    {
        foreach ($this->tokens as $token) {
            if (($token->type & (TokenType::WHITESPACE | TokenType::COMMENT)) === 0) {
                return false;
            }
        }

        return true;
    }

    // matchers --------------------------------------------------------------------------------------------------------

    /**
     * @return never
     */
    public function expected(string $description): void
    {
        throw new ParserException($description);
    }

    /**
     * @param mixed|null $value
     */
    public function expect(int $tokenType, $value = null): Token
    {
        $this->doAutoSkip();
        $token = $this->tokens[$this->position] ?? null;
        if ($token === null || ($token->type & $tokenType) === 0) {
            throw new UnexpectedTokenException([$tokenType], $value, $token, $this);
        }
        if ($value !== null && $token->value !== $value) {
            throw new UnexpectedTokenException([$tokenType], $value, $token, $this);
        }
        $this->position++;

        return $token;
    }

    /**
     * @phpstan-impure
     */
    public function get(int $tokenType): ?Token
    {
        $this->doAutoSkip();
        $token = $this->tokens[$this->position] ?? null;
        if ($token !== null && ($token->type & $tokenType) !== 0) {
            $this->position++;

            return $token;
        } else {
            return null;
        }
    }

    /**
     * @phpstan-impure
     */
    public function has(int $tokenType): bool
    {
        return (bool) $this->get($tokenType);
    }

    public function expectAny(int ...$tokenTypes): Token
    {
        $this->doAutoSkip();
        $token = $this->tokens[$this->position] ?? null;
        if ($token !== null) {
            foreach ($tokenTypes as $tokenType) {
                if (($token->type & $tokenType) !== 0) {
                    $this->position++;

                    return $token;
                }
            }
        }

        throw new UnexpectedTokenException($tokenTypes, null, $token, $this);
    }

    /**
     * @phpstan-impure
     */
    public function hasComma(): bool
    {
        $this->doAutoSkip();
        $token = $this->tokens[$this->position] ?? null;
        if ($token !== null && ($token->type & TokenType::COMMA) !== 0) {
            $this->position++;

            return true;
        } else {
            return false;
        }
    }

    public function expectName(?string $name = null): string
    {
        return $this->expect(TokenType::NAME, $name)->original; // @phpstan-ignore-line non-null
    }

    public function getName(?string $name = null): ?string
    {
        $position = $this->position;
        try {
            return $this->expectName($name);
        } catch (UnexpectedTokenException $e) {
            $this->position = $position;

            return null;
        }
    }

    public function expectNonKeywordName(?string $name = null): string
    {
        $token = $this->expect(TokenType::NAME, $name);
        if (($token->type & TokenType::KEYWORD) !== 0) {
            throw new UnexpectedTokenException([TokenType::NAME], null, $token, $this);
        }

        return $token->original; // @phpstan-ignore-line non-null
    }

    public function getNonKeywordName(?string $name = null): ?string
    {
        $position = $this->position;
        try {
            return $this->expectNonKeywordName($name);
        } catch (UnexpectedTokenException $e) {
            $this->position = $position;

            return null;
        }
    }

    public function expectString(): string
    {
        /** @var string $value */
        $value = $this->expect(TokenType::STRING)->value;

        return $value;
    }

    public function getString(): ?string
    {
        $token = $this->get(TokenType::STRING);

        /** @var string|null $value */
        $value = $token !== null ? $token->value : null;

        return $value;
    }

    public function expectNameOrString(): string
    {
        $token = $this->expectAny(TokenType::NAME, TokenType::STRING);
        /** @var string $value */
        $value = ($token->type & TokenType::STRING) !== 0
            ? $token->value
            : $token->original ?? $token->value; // NAME|KEYWORD is automatically uppercased

        return $value;
    }

    public function hasNameOrKeyword(string $name): bool
    {
        return $this->hasKeyword($name) || (bool) $this->getName($name);
    }

    /**
     * @return int|float|string
     */
    public function expectNumber()
    {
        /** @var int|float|string $value */
        $value = $this->expect(TokenType::NUMBER)->value;

        return $value;
    }

    /**
     * @return int|float|string|null
     */
    public function getNumber()
    {
        $token = $this->get(TokenType::NUMBER);

        /** @var string|null $value */
        $value = $token !== null ? $token->value : null;

        return $value;
    }

    public function expectInt(): int
    {
        $number = $this->get(TokenType::NUMBER);
        if ($number !== null) {
            if (is_int($number->value)) {
                return $number->value;
            } else {
                throw new UnexpectedTokenException([TokenType::NUMBER], 'integer', $number, $this);
            }
        }
        $number = $this->getString();
        if ($number !== null && Re::match($number, '/^[0-9]+$/') !== null) {
            return (int) $number;
        }
        // always fails
        $this->expect(TokenType::NUMBER);
        exit;
    }

    public function getInt(): ?int
    {
        $position = $this->position;
        try {
            return $this->expectInt();
        } catch (UnexpectedTokenException $e) {
            $this->position = $position;

            return null;
        }
    }

    public function expectBool(): bool
    {
        // TRUE, FALSE, ON, OFF, 1, 0, Y, N, T, F
        $value = $this->expect(TokenType::VALUE)->value;
        if (is_bool($value)) {
            return $value;
        }
        if ($value === 1 || $value === 'Y' || $value === 'T') {
            return true;
        } elseif ($value === 0 || $value === 'N' || $value === 'F') {
            return false;
        }

        throw new ParserException(sprintf('Boolean-like value expected. "%s" found.', $value));
    }

    public function expectOperator(string $operator): string
    {
        /** @var string $value */
        $value = $this->expect(TokenType::OPERATOR, $operator)->value;

        return $value;
    }

    /**
     * @phpstan-impure
     */
    public function hasOperator(string $operator): bool
    {
        $position = $this->position;

        $token = $this->get(TokenType::OPERATOR);
        if ($token === null) {
            return false;
        } elseif ($token->value === $operator) {
            return true;
        } else {
            $this->position = $position;

            return false;
        }
    }

    /**
     * @phpstan-impure
     */
    public function passEqual(): void
    {
        $position = $this->position;

        $token = $this->get(TokenType::OPERATOR);
        if ($token === null || $token->value !== Operator::EQUAL) {
            $this->position = $position;
        }
    }

    /**
     * @phpstan-impure
     */
    public function passParens(): void
    {
        $position = $this->position;

        $token1 = $this->get(TokenType::LEFT_PARENTHESIS);
        $token2 = $this->get(TokenType::RIGHT_PARENTHESIS);
        if ($token1 === null || $token2 === null) {
            $this->position = $position;
        }
    }

    public function expectAnyOperator(string ...$operators): string
    {
        $operator = $this->expect(TokenType::OPERATOR);
        if (!in_array($operator->value, $operators, true)) {
            throw new UnexpectedTokenException([TokenType::OPERATOR], $operators, $operator, $this);
        }

        return $operator->value;
    }

    public function getAnyOperator(string ...$operators): ?string
    {
        $position = $this->position;
        try {
            return $this->expectAnyOperator(...$operators);
        } catch (UnexpectedTokenException $e) {
            $this->position = $position;

            return null;
        }
    }

    /**
     * @return never
     * @throws UnexpectedTokenException
     */
    public function expectedAnyKeyword(string ...$keywords): void
    {
        $this->position--;
        $token = $this->get(TokenType::KEYWORD);

        throw new UnexpectedTokenException([TokenType::KEYWORD], $keywords, $token, $this);
    }

    public function expectKeyword(string $keyword): string
    {
        $this->doAutoSkip();
        $token = $this->tokens[$this->position] ?? null;
        if ($token === null || ($token->type & TokenType::KEYWORD) === 0) {
            throw new UnexpectedTokenException([TokenType::KEYWORD], $keyword, $token, $this);
        }
        if ($token->value !== $keyword) {
            throw new UnexpectedTokenException([TokenType::KEYWORD], $keyword, $token, $this);
        }
        $this->position++;

        return $token->value;
    }

    public function passKeyword(string $keyword): void
    {
        try {
            $this->expectKeyword($keyword);
        } catch (UnexpectedTokenException $e) {
            return;
        }
    }

    public function hasKeyword(string $keyword): bool
    {
        try {
            $this->expectKeyword($keyword);

            return true;
        } catch (UnexpectedTokenException $e) {
            return false;
        }
    }

    public function expectKeywords(string ...$keywords): string
    {
        foreach ($keywords as $keyword) {
            $this->expectKeyword($keyword);
        }

        return implode(' ', $keywords);
    }

    public function hasKeywords(string ...$keywords): bool
    {
        $position = $this->position;
        try {
            $this->expectKeywords(...$keywords);

            return true;
        } catch (UnexpectedTokenException $e) {
            $this->position = $position;

            return false;
        }
    }

    public function expectAnyKeyword(string ...$keywords): string
    {
        $keyword = $this->expect(TokenType::KEYWORD)->value;
        if (!in_array($keyword, $keywords, true)) {
            $this->expectedAnyKeyword(...$keywords);
        }

        return $keyword;
    }

    public function getAnyKeyword(string ...$keywords): ?string
    {
        $position = $this->position;
        try {
            return $this->expectAnyKeyword(...$keywords);
        } catch (UnexpectedTokenException $e) {
            $this->position = $position;

            return null;
        }
    }

    public function hasAnyKeyword(string ...$keywords): bool
    {
        $position = $this->position;
        try {
            $this->expectAnyKeyword(...$keywords);

            return true;
        } catch (UnexpectedTokenException $e) {
            $this->position = $position;

            return false;
        }
    }

    /**
     * @template T of SqlEnum
     * @param class-string<T> $className
     * @return T
     */
    public function expectKeywordEnum(string $className): SqlEnum
    {
        return call_user_func([$className, 'get'], $this->expectAnyKeyword(...array_values(call_user_func([$className, 'getAllowedValues']))));
    }

    /**
     * @template T of SqlEnum
     * @param class-string<T> $className
     * @return T
     */
    public function expectNameOrStringEnum(string $className): SqlEnum
    {
        $values = call_user_func([$className, 'getAllowedValues']);
        $value = $this->expectNameOrString();

        if (in_array($value, $values, true)) {
            return call_user_func([$className, 'get'], $value);
        }

        throw new UnexpectedTokenException([TokenType::NAME], $values, $this->tokens[$this->position], $this);
    }

    /**
     * @template T of SqlEnum
     * @param class-string<T> $className
     * @return T|null
     */
    public function getKeywordEnum(string $className): ?SqlEnum
    {
        $token = $this->getAnyKeyword(...array_values(call_user_func([$className, 'getAllowedValues'])));
        if ($token === null) {
            return null;
        } else {
            return call_user_func([$className, 'get'], $token);
        }
    }

    public function seek(int $type, int $maxOffset): ?Token
    {
        $position = $this->position;
        for ($n = 0; $n < $maxOffset; $n++) {
            $this->doAutoSkip();
            $token = $this->tokens[$this->position] ?? null;
            if ($token === null) {
                break;
            }
            $this->position++;
            if (($token->type & $type) !== 0) {
                $this->position = $position;

                return $token;
            }
        }
        $this->position = $position;

        return null;
    }

    public function seekKeyword(string $keyword, int $maxOffset): bool
    {
        $position = $this->position;
        for ($n = 0; $n < $maxOffset; $n++) {
            $this->doAutoSkip();
            $token = $this->tokens[$this->position] ?? null;
            if ($token === null) {
                break;
            }
            $this->position++;
            if (($token->type & TokenType::KEYWORD) !== 0 && $token->value === $keyword) {
                $this->position = $position;

                return true;
            }
        }
        $this->position = $position;

        return false;
    }

    /**
     * @return array{string, string|null} ($name, $schema)
     */
    public function expectQualifiedName(): array
    {
        $first = $this->expectName();
        if ($this->has(TokenType::DOT)) {
            // a reserved keyword may follow after "." unescaped as we know it is a name context
            $secondToken = $this->get(TokenType::KEYWORD);
            if ($secondToken !== null) {
                /** @var string $second */
                $second = $secondToken->value;
            } else {
                $second = $this->expectName();
            }

            return [$second, $first];
        }

        return [$first, null];
    }

    /**
     * @return array{string, string|null}|null ($name, $schema)
     */
    public function getQualifiedName(): ?array
    {
        try {
            return $this->expectQualifiedName();
        } catch (ParserException $e) {
            return null;
        }
    }

    /**
     * @return array{string, string|null} ($name, $host)
     */
    public function expectUserName(): array
    {
        $name = $this->expectNameOrString();
        $symbol = $this->expect(TokenType::SYMBOL);
        if ($symbol->value !== '@') {
            $this->expected('@');
        }
        $host = $this->expectNameOrString();

        return [$name, $host];
    }

    public function expectEnd(): void
    {
        $this->doAutoSkip();
        if ($this->position < count($this->tokens)) {
            throw new UnexpectedTokenException([TokenType::END], null, $this->tokens[$this->position], $this);
        }
    }

}
