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

namespace Jigius\Step;

/**
 * ProcessorInterface defines common functionality all `Processor` immutable
 * instances must implement
 */
interface ProcessorInterface
{
    /**
     * Outputs `Chunk` instance
     *
     * @param ChunkInterface $c `Chunk` instance
     * @return ProcessorInterface
     */
    public function outputed(ChunkInterface $c): ProcessorInterface;

    /**
     * Creates a new instance with same arguments
     *
     * @return ProcessorInterface
     */
    public function reset(): ProcessorInterface;
}
