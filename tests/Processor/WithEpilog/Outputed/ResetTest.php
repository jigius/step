<?php
declare(strict_types=1);

namespace Jigius\Step\Tests\Processor\WithEpilog\Outputed;

use Jigius\Step\Processor\Plain;
use Jigius\Step\Processor\WithEpilog;
use Jigius\Step\Tests\FakeChunk;
use Jigius\Step\ProcessorInterface;
use PHPUnit\Framework\TestCase;

final class ResetTest extends TestCase
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
                "^"
            ],
            [
                new WithEpilog(
                    new Plain(),
                    "^"
                ),
                [
                    new FakeChunk("a")
                ],
                "^"
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
                "^"
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
                "^"
            ]
        ];
    }

    /**
     * @dataProvider sampleData
     */
    public function testSample(
        ProcessorInterface $obj,
        array $preparedChunks,
        string $expectedText
    ): void {
        ob_start();
        foreach ($preparedChunks as $chunk) {
            $obj = $obj->outputed($chunk);
        }
        ob_clean();
        $obj = $obj->reset();
        $this->assertEquals(
            $expectedText,
            ob_get_clean()
        );
    }
}
