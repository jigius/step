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
 * Represents plain processor class.
 *
 * @package Jigius\Step\Processor
 */
final class Plain implements ProcessorInterface
{
    /**
     * Creates an plain `Processor`
     */
    public function __construct()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function outputed(ChunkInterface $c): ProcessorInterface
    {
        $c->output();
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function reset(): ProcessorInterface
    {
        return $this;
    }
}
