<?php
/**
 * This file is part of the jigius/step library
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @copyright Copyright (c) Jigius <jigius@gmail.com>
 * @link https://github.com/jigius/step GitHub
 */

namespace Jigius\Step\Processor;

use Jigius\Step\ChunkInterface;
use Jigius\Step\ProcessorInterface;

/**
 * Class decorator
 *
 * Catches all printing data (text) from decorated instance
 * and redirects its into alternative one
 *
 * @package Jigius\Step\Processor
 */
final class WithRedirected implements ProcessorInterface
{
    /**
     * Original `Processor` instance
     * @var ProcessorInterface
     */
    private $orig;

    /**
     * Alternative `Processor` instance
     * @var ProcessorInterface
     */
    private $alter;

    /**
     * The printer (creator) of new `Chunk` instances
     * @var Redirect\ChunkPrinterInterface
     */
    private $printer;

    /**
     * Creates immutable object for catching all printed data (text)
     * from original instance and redirects into alternative one
     *
     * @param ProcessorInterface $orig Original `Processor` instance
     * @param ProcessorInterface $alter Alternative `Processor` instance
     * @param string $printer `ChunkPrinter` instance
     */
    public function __construct(
        ProcessorInterface $orig,
        ProcessorInterface $alter,
        Redirect\ChunkPrinterInterface $printer
    ) {
        $this->orig = $orig;
        $this->alter = $alter;
        $this->printer = $printer;
    }

    /**
     * {@inheritdoc}
     *
     * Catches all printing data from original instance and
     * redirects into alternative one
     *
     * @param ChunkInterface $c The outputed chunk
     * @return ProcessorInterface
     */
    public function outputed(ChunkInterface $c): ProcessorInterface
    {
        ob_start();
        $orig = $this->orig->outputed($c);
        $output = ob_get_clean();
        return new self(
            $orig,
            $this->alter->outputed(
                $this
                    ->printer
                    ->with(
                        "text",
                        $output
                    )
                    ->create()
            ),
            $this->printer
        );
        return $obj;
    }

    /**
     * {@inheritdoc}
     *
     * Catches all printing data from original instance and
     * redirects into alternative one
     */
    public function reset(): ProcessorInterface
    {
        ob_start();
        $orig = $this->orig->reset();
        $output = ob_get_clean();
        return new self(
            $orig,
            $this
                ->alter
                ->outputed(
                    $this->printer->with(
                        "text",
                        $output
                    )
                    ->create()
                )
                ->reset(),
            $this->printer
        );
        return $obj;
    }
}
