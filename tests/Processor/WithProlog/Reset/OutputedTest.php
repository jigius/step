<?php
declare(strict_types=1);

namespace Jigius\Step\Tests\Processor\WithProlog\Reset;

use Jigius\Step\Processor\Plain;
use Jigius\Step\Processor\WithProlog;
use Jigius\Step\Tests\FakeChunk;
use Jigius\Step\ProcessorInterface;
use PHPUnit\Framework\TestCase;

final class OutputedTest extends TestCase
{
    public function sampleData(): array
    {
        return [
            [
                new WithProlog(
                    new Plain(),
                    "^"
                ),
                [
                    new FakeChunk("")
                ],
                ""
            ],
            [
                new WithProlog(
                    new Plain(),
                    "^",
                    true
                ),
                [
                    new FakeChunk("")
                ],
                ""
            ],
            [
                new WithProlog(
                    new Plain(),
                    "^",
                    false
                ),
                [
                    new FakeChunk("")
                ],
                "^"
            ],
            [
                new WithProlog(
                    new Plain(),
                    "^"
                ),
                [
                    new FakeChunk("a")
                ],
                "^a"
            ],
            [
                new WithProlog(
                    new Plain(),
                    "^",
                    true
                ),
                [
                    new FakeChunk("a")
                ],
                "^a"
            ],
            [
                new WithProlog(
                    new Plain(),
                    "^",
                    false
                ),
                [
                    new FakeChunk("a")
                ],
                "^a"
            ]
        ];
    }

    /**
     * @dataProvider sampleData
     */
    public function testSample(
        ProcessorInterface $obj,
        array $testedChunks,
        string $expectedText
    ): void {
        ob_start();
        $obj = $obj->reset();
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
