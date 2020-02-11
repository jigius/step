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

namespace Jigius\Step\Processor\Repository\Local;

/**
 * Defines common functionality all `Urn` immutable instances must implement
 *
 * @package Jigius\Step\Processor\Repository\Local
 */
interface UrnInterface
{
    /*
     * Creates new `Urn` instance with has been updated
     * of it's state that is derived from current one
     *
     * @return UrnInterface Returns new `Urn`
     */
    public function pulled(): UrnInterface;

    /*
     * Gets current URN (Uniform Resource Name)
     *
     * @return string Returns current URN (Uniform Resource Name)
     */
    public function fetch(): string;
}
