<?php
declare(strict_types=1);

namespace Jigius\Step\Tests\Processor\Plain;

use Jigius\Step\Processor\Plain as TPlain;
use Jigius\Step\Tests\FakeChunk;
use PHPUnit\Framework\TestCase;

final class CutTest extends TestCase
{
    public function sampleData(): array
    {
        return [
            [
                [
                    new FakeChunk("")
                ],
                ""
            ],
            [
                [
                    new FakeChunk("a")
                ],
                "a"
            ],
            [
                [
                    new FakeChunk("a"),
                    new FakeChunk("b"),
                    new FakeChunk(""),
                    new FakeChunk("c")
                ],
                "abc"
            ]
        ];
    }

    /**
     * @dataProvider sampleData
     */
    public function testOutputed(array $testedChunks, string $expectedText): void
    {
        $obj = (new TPlain())->reset();
        ob_start();
        foreach ($testedChunks as $chunk) {
            $obj = $obj->outputed($chunk);
        }
        $this->assertEquals(
            $expectedText,
            ob_get_clean()
        );
    }

    public function testCut(): void
    {
        $obj = (new TPlain())->reset();
        ob_start();
        $obj = $obj->reset();
        $this->assertEquals("", ob_get_clean());
    }
}
