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
 * `EntityInterface` immutable instances must implement
 *
 * @package Jigius\Step\Repository
 */
interface EntityInterface
{
    /*
     * Opens `Entity` instance and returns it
     *
     * @return EntityInterface Returns opened `Entity` instance
     */
    public function opened(): EntityInterface;

    /*
     * Closes `Entity` instance and returns it
     *
     * @return EntityInterface Returns closed `Entity` instance
     */
    public function closed(): EntityInterface;

    /*
     * Writes data to `Entity` instance and returns it
     *
     * @param mixed $data The data for writing
     * @return EntityInterface Returns `Entity` instance the data has been writting into
     */
    public function written(&$data): EntityInterface;

    /*
     * Gets Universal Resource Identificator of the entity
     *
     * @return string Returns Universal Resource Identificator of the entity
     */
    public function uri(): string;

    /*
     * Checks if entity is ready for data writting
     *
     * @return bool
     */
    public function ready(): bool;
}
