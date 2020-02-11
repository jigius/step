<?php
declare(strict_types=1);

namespace Jigius\Step\Tests\Processor\WithProlog\Outputed;

use Jigius\Step\Processor\Plain;
use Jigius\Step\Processor\WithProlog;
use Jigius\Step\Tests\FakeChunk;
use Jigius\Step\ProcessorInterface;
use PHPUnit\Framework\TestCase;

final class ResetTest extends TestCase
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
                ""
            ],
            [
                new WithProlog(
                    new Plain(),
                    "^"
                ),
                [
                    new FakeChunk("a")
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
                    new FakeChunk("a")
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
                    new FakeChunk("a")
                ],
                ""
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
