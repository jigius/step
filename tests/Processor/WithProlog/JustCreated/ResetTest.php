<?php
declare(strict_types=1);

namespace Jigius\Step\Tests\Processor\WithProlog\JustCreated;

use Jigius\Step\Processor\Plain;
use Jigius\Step\Processor\WithProlog;
use Jigius\Step\Tests\FakeChunk;
use Jigius\Step\ProcessorInterface;
use PHPUnit\Framework\TestCase;

final class CutTest extends TestCase
{
    public function sampleData(): array
    {
        return [
            [
                new WithProlog(
                    new Plain(),
                    "^"
                ),
                ""
            ],
            [
                new WithProlog(
                    new Plain(),
                    "^",
                    true
                ),
                ""
            ],
            [
                new WithProlog(
                    new Plain(),
                    "^",
                    false
                ),
                "^"
            ],
        ];
    }

    /**
     * @dataProvider sampleData
     */
    public function testSample(
        ProcessorInterface $obj,
        string $expectedText
    ): void {
        ob_start();
        $obj = $obj->reset();
        $this->assertEquals(
            $expectedText,
            ob_get_clean()
        );
    }
}
