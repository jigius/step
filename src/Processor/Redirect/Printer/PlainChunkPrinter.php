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

declare(strict_types=1);

namespace Jigius\Step\Processor\Redirect\Printer;

use Jigius\Step\ChunkInterface;
use Jigius\Step\Processor\Redirect;
use DomainException;

/**
 * Represents printer class to "printing" `PlainChunk` instances.
 *
 * Immutable instances of this class "prints" `PlainChunk` instances with
 * respects of data is gotten
 *
 * @package Jigius\Step\Redirect
 */
final class PlainChunkPrinter implements Redirect\ChunkPrinterInterface
{
    /**
     * The gotten text
     * @var string
     */
    private $text;

    /**
     * Creates immutable printer instance to "printing" `PlainChunk` instances
     * with respects of data is gotten
     */
    public function __construct()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function with(string $key, string $val): Redirect\ChunkPrinterInterface
    {
        $obj = $this->blueprinted();
        if ($key == "text") {
            $obj->text = $val;
        }
        return $obj;
    }

    /**
     * {@inheritdoc}
     *
     * @throws \DomainException If the gotten data is invalid
     */
    public function create(): ChunkInterface
    {
        if ($this->text === null) {
            throw new DomainException("input data is invalid");
        }
        return new Redirect\PlainChunk($this->text);
    }

    /**
     * Bluprints the current instance of object
     *
     * @return PlainChunkPrinter Returns bluprinted instance of object
     */
    private function blueprinted(): self
    {
        $obj = new self();
        $obj->text = $this->text;
        return $obj;
    }
}
