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

namespace Jigius\Step\Processor\Repository;

/**
 * Defines common functionality all
 * `Repository` immutable instances must implement
 *
 * @package Jigius\Step\Repository
 */
interface RepositoryInterface
{
    /*
     * Updates the current `Entity` instance with new one
     *
     * @return EntityInterface Returns `Repository` instance with
     * has been updated of current `Entity` instance
     */
    public function pulled(): RepositoryInterface;

    /*
     * Gets current `Entity` instance
     *
     * @return EntityInterface Returns current `Entity` instance
     */
    public function entity(): EntityInterface;

    /*
     * Gets URN (Uniform Resource Name) of passed `Entity` instance
     *
     * @param EntityInterface $entity `Entity` instance
     * @return string Returns URN (Uniform Resource Name)
     * of current `Entity` instance
     */
    public function urn(EntityInterface $entity): string;
}
