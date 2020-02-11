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

namespace Jigius\Step\Processor\Redirect;

use Jigius\Step\ChunkInterface;

/**
 * Defines common functionality all `ChunkPrinter` immutable
 * instances must implement
 *
 * @package Jigius\Step\Processor\Repository
 */
interface ChunkPrinterInterface
{
    /**
     * Collects retrieved data for later using
     *
     * @param string $key The key of data
     * @param string $val The value of data
     * @return ChunkPrinterInterface Returns `ChunkPrinter` instance with
     * respects to retrieved data
     */
    public function with(string $key, string $val): ChunkPrinterInterface;

    /**
     * Creates (prints out) `Chunk` instance with respects of retrieved data
     *
     * @return ChunkInterface Returns `Chunk` instance
     */
    public function create(): ChunkInterface;
}
