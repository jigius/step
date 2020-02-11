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
 * ChunkInterface defines common functionality all `Chunk` immutable
 * instances must implement
 */
interface ChunkInterface
{
    /**
     * Prints instance's data in form of strings into standard output
     *
     * @return void
     */
    public function output(): void;

    /**
     * Checks if instance can be counted one
     *
     * @return bool
     */
    public function counted(): bool;
}
