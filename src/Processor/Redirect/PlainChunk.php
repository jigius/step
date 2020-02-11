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
 * Represents class for wrapping some text into `Chunk` instance
 * with respects of gotten data.
 *
 * Is used by `WithRedirected` processor instance.
 *
 * @package Jigius\Step\Processor\Redirect
 */
final class PlainChunk implements ChunkInterface
{
    /**
     * The outputed content
     * @var string
     */
    private $text;

    /**
     * Creates an plain `Chunk` instance for
     * wrapping some text into `Chunk` instance
     */
    public function __construct(string $text)
    {
        $this->text = $text;
    }

    /**
     * {@inheritdoc}
     */
    public function output(): void
    {
        echo $this->text;
    }

    /**
     * {@inheritdoc}
     */
    public function counted(): bool
    {
        return true;
    }
}
