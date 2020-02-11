<?php
declare(strict_types=1);

namespace Jigius\Step\Tests\Processor\Plain;

use Jigius\Step\Processor\Plain as TPlain;
use Jigius\Step\Tests\FakeChunk;
use PHPUnit\Framework\TestCase;

final class OutputedTest extends TestCase
{
    public function sampleData(): array
    {
        return [
            [
                [],
                [
                    new FakeChunk("")
                ],
                ""
            ],
            [
                [],
                [
                    new FakeChunk("a")
                ],
                "a"
            ],
            [
                [
                    new FakeChunk("a"),
                    new FakeChunk("b")
                ],
                [
                    new FakeChunk(""),
                    new FakeChunk("c")
                ],
                "c"
            ]
        ];
    }

    /**
     * @dataProvider sampleData
     */
    public function testOutputed(array $preparedChunks, array $testedChunks, string $expectedText): void
    {
        $obj = new TPlain();
        ob_start();
        foreach ($preparedChunks as $chunk) {
            $obj = $obj->outputed($chunk);
        }
        ob_clean();
        foreach ($testedChunks as $chunk) {
            $obj = $obj->outputed($chunk);
        }
        $this->assertEquals(
            $expectedText,
            ob_get_clean()
        );
    }

    public function testReset(): void
    {
        $obj = new TPlain();
        ob_start();
        $obj = $obj->reset();
        $this->assertEquals("", ob_get_clean());
    }
}
