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
 * Prevents decorated instance from printing data into standard output
 *
 * @package Jigius\Step\Processor
 */
final class WithSupressed implements ProcessorInterface
{
    /**
     * Original `Processor` instance
     * @var ProcessorInterface
     */
    private $orig;

    /**
     * Creates immutable instance wich decorates original one
     *
     * @param ProcessorInterface $orig Original instance
     */
    public function __construct(ProcessorInterface $orig)
    {
        $this->orig = $orig;
    }

    /**
     * {@inheritdoc}
     *
     * Prevents original instance from printing data into standard output
     *
     * @param ChunkInterface $c The outputed chunk
     * @return ProcessorInterface
     */
    public function outputed(ChunkInterface $c): ProcessorInterface
    {
        ob_start();
        $orig = $this->orig->outputed($c);
        ob_end_clean();
        return new self($orig);
    }

    /**
     * {@inheritdoc}
     *
     * Prevents original instance from printing data into standard output
     *
     * @return ProcessorInterface
     */
    public function reset(): ProcessorInterface
    {
        ob_start();
        $orig = $this->orig->reset();
        ob_end_clean();
        return new self($orig);
    }
}
