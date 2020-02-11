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

namespace Jigius\Step\Processor\Repository\Local\Urn;

use Jigius\Step\Processor\Repository\Local\UrnInterface;

/**
 * The purpose of this immutable object is define
 * static string value of URN
 *
 * @package Jigius\Step\Processors\Repository\Local\Urn
 */
final class StaticUrn implements UrnInterface
{
    /**
     * Specified URNs
     * @var string
     */
    private $urn;

    /**
     * Creates immutable object with specified static value of URN
     *
     * @param string $urn The URN
     */
    public function __construct(string $urn)
    {
        $this->urn = $urn;
    }

    /**
     * {@inheritdoc}
     *
     */
    public function pulled(): UrnInterface
    {
        return $this;
    }

    /**
     * {@inheritdoc}
     *
     */
    public function fetch(): string
    {
        return $this->urn;
    }
}
