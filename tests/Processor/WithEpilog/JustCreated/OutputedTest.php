<?php
declare(strict_types=1);

namespace Jigius\Step\Tests\Processors\WithEpilog\JustCreated;

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
                    new FakeChunk(""),
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
                    new FakeChunk(""),
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
                    new FakeChunk(""),
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
                "a"
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
                "a"
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
                "a"
            ],
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
        foreach ($testedChunks as $chunk) {
            $obj = $obj->outputed($chunk);
        }
        $this->assertEquals(
            $expectedText,
            ob_get_clean()
        );
    }
}
