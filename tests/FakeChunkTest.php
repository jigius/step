<?php
declare(strict_types=1);

namespace Jigius\Step\Tests;

use PHPUnit\Framework\TestCase;

final class FakeChunkTest extends TestCase
{
    public function sampleData(): array
    {
        return [
            ["Foo", true],
            ["bar", false],
            ["", true],
            ["", false]
        ];
    }

    /**
     * @dataProvider sampleData
     */
    public function testCreationWithVariousParams(string $text, bool $counted): void
    {
        $chunk = new FakeChunk($text, $counted);
        ob_start();
        $chunk->output();
        $this->assertEquals(
            $text,
            ob_get_clean()
        );
        $this->assertEquals(
            $counted,
            $chunk->counted()
        );
    }

    public function testCreationWithDefaultParam(): void
    {
        $this->assertEquals(
            (new FakeChunk(""))->counted(),
            true
        );
    }
}
