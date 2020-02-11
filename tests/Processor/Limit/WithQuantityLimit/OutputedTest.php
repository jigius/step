<?php
declare(strict_types=1);

namespace Jigius\Step\Tests\Processor\Limit\WithQuantityLimit;

use Jigius\Step\Processor\Plain;
use Jigius\Step\Processor\Limit\WithQuantityLimit as TWithQuantityLimit;
use Jigius\Step\Tests\FakeChunk;
use Jigius\Step\ProcessorInterface;
use PHPUnit\Framework\TestCase;
use LengthException;

final class OutputedTest extends TestCase
{
    public function sampleData(): array
    {
        return [
            [
                new TWithQuantityLimit(
                    new Plain(),
                    1
                ),
                [
                    new FakeChunk(""),
                ],
                [
                    new FakeChunk("")
                ],
                false
            ],
            [
                new TWithQuantityLimit(
                    new Plain(),
                    1
                ),
                [
                    new FakeChunk("a")
                ],
                [
                    new FakeChunk("b", false),
                    new FakeChunk("")
                ],
                false
            ],
            [
                new TWithQuantityLimit(
                    new Plain(),
                    1
                ),
                [
                    new FakeChunk("")
                ],
                [
                    new FakeChunk("a"),
                    new FakeChunk("")
                ],
                false
            ],
            [
                new TWithQuantityLimit(
                    new Plain(),
                    1
                ),
                [
                    new FakeChunk("")
                ],
                [
                    new FakeChunk("a"),
                    new FakeChunk("b")
                ],
                true
            ],
            [
                new TWithQuantityLimit(
                    new Plain(),
                    1
                ),
                [
                    new FakeChunk("a")
                ],
                [
                    new FakeChunk("b")
                ],
                true
            ]
        ];
    }

    /**
     * @dataProvider sampleData
     */
    public function testOutputed(
        ProcessorInterface $obj,
        array $preparedChunks,
        array $testedChunks,
        bool $expectedException
    ): void {
        ob_start();
        foreach ($preparedChunks as $chunk) {
            $obj = $obj->outputed($chunk);
        }
        $catchedEx = false;
        try {
            foreach ($testedChunks as $chunk) {
                $obj = $obj->outputed($chunk);
            }
        } catch (LengthException $ex) {
            $catchedEx = true;
        }
        ob_end_clean();
        $this->assertEquals($expectedException, $catchedEx);
    }

    /**
     * @dataProvider sampleData
     */
    public function testReset(
        ProcessorInterface $obj,
        array $preparedChunks,
        array $testedChunks,
        bool $expectedException
    ): void {
        ob_start();
        foreach ($preparedChunks as $chunk) {
            $obj = $obj->outputed($chunk);
        }
        ob_clean();
        $obj = $obj->reset();
        $this->assertEquals("", ob_get_clean());
    }
}
