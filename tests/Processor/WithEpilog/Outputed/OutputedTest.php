<?php
declare(strict_types=1);

namespace Jigius\Step\Tests\Processor\WithEpilog\Outputed;

use Jigius\Step\Processor\Plain;
use Jigius\Step\Processor\WithEpilog;
use Jigius\Step\Tests\FakeChunk;
use Jigius\Step\ProcessorInterface;
use PHPUnit\Framework\TestCase;

final class OutputedTest extends TestCase
{
    public function sampleData(): array
    {
        return [
            [
                new WithEpilog(
                    new Plain(),
                    "^"
                ),
                [
                    new FakeChunk("")
                ],
                [
                    new FakeChunk("")
                ],
                ""
            ],
            [
                new WithEpilog(
                    new Plain(),
                    "^",
                    true
                ),
                [
                    new FakeChunk("")
                ],
                [
                    new FakeChunk("")
                ],
                ""
            ],
            [
                new WithEpilog(
                    new Plain(),
                    "^",
                    false
                ),
                [
                    new FakeChunk("")
                ],
                [
                    new FakeChunk("")
                ],
                ""
            ],
            [
                new WithEpilog(
                    new Plain(),
                    "^"
                ),
                [
                    new FakeChunk("a")
                ],
                [
                    new FakeChunk("")
                ],
                ""
            ],
            [
                new WithEpilog(
                    new Plain(),
                    "^",
                    true
                ),
                [
                    new FakeChunk("a")
                ],
                [
                    new FakeChunk("")
                ],
                ""
            ],
            [
                new WithEpilog(
                    new Plain(),
                    "^",
                    false
                ),
                [
                    new FakeChunk("a")
                ],
                [
                    new FakeChunk("")
                ],
                ""
            ],
            [
                new WithEpilog(
                    new Plain(),
                    "^"
                ),
                [
                    new FakeChunk("a")
                ],
                [
                    new FakeChunk("b")
                ],
                "b"
            ],
            [
                new WithEpilog(
                    new Plain(),
                    "^",
                    true
                ),
                [
                    new FakeChunk("a")
                ],
                [
                    new FakeChunk("b")
                ],
                "b"
            ],
            [
                new WithEpilog(
                    new Plain(),
                    "^",
                    false
                ),
                [
                    new FakeChunk("a")
                ],
                [
                    new FakeChunk("b")
                ],
                "b"
            ]
        ];
    }

    /**
     * @dataProvider sampleData
     */
    public function testSample(
        ProcessorInterface $obj,
        array $preparedChunks,
        array $testedChunks,
        string $expectedText
    ): void {
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
}
