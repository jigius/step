<?php
declare(strict_types=1);

namespace Jigius\Step\Tests\Processor\WithEpilog\Reset;

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
                ""
            ],
            [
                new WithEpilog(
                    new Plain(),
                    "^",
                    true
                ),
                ""
            ],
            [
                new WithEpilog(
                    new Plain(),
                    "^",
                    false
                ),
                "^"
            ]
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
        ob_clean();
        $obj = $obj->reset();
        $this->assertEquals(
            $expectedText,
            ob_get_clean()
        );
    }
}
