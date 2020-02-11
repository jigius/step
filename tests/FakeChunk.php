<?php
declare(strict_types=1);

namespace Jigius\Step\Tests;

use Jigius\Step\ChunkInterface;

final class FakeChunk implements ChunkInterface
{
    /**
     * @var string
     */
    private $text;

    /**
     * @var bool
     */
    private $counted;

    public function __construct(string $text, bool $counted = true)
    {
        $this->text = $text;
        $this->counted = $counted;
    }

    public function output(): void
    {
        echo $this->text;
    }

    public function counted(): bool
    {
        return $this->counted;
    }
}
