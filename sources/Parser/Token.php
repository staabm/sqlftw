<?php declare(strict_types = 1);
/**
 * This file is part of the SqlFtw library (https://github.com/sqlftw)
 *
 * Copyright (c) 2017 Vlasta Neubauer (@paranoiq)
 *
 * For the full copyright and license information read the file 'license.md', distributed with this source code
 */

namespace SqlFtw\Parser;

use Dogma\StrictBehaviorMixin;

final class Token
{
    use StrictBehaviorMixin;

    /** @var int */
    public $type;

    /** @var int */
    public $position;

    /** @var string|int|float|bool|LexerException|null */
    public $value;

    /** @var string|null */
    public $original;

    /** @var string|null */
    public $condition;

    /**
     * @param string|int|float|bool|LexerException|null $value
     */
    public function __construct(
        int $type,
        int $position,
        $value = null,
        ?string $original = null,
        ?string $condition = null
    ) {
        $this->type = $type;
        $this->position = $position;
        $this->value = $value;
        $this->original = $original;
        $this->condition = $condition;
    }

}
