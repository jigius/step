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

namespace Jigius\Step\Processor\Limit;

use Jigius\Step\ChunkInterface;
use Jigius\Step\ProcessorInterface;
use LengthException;

/**
 * Class decorator
 *
 * This immutable object counts the length of chunks' content has
 * outputed and throws \LengthException when it's reached specified
 * value of `max` param
 *
 * @package Jigius\Step\Processor\Limit
 */
final class WithLengthLimit implements ProcessorInterface
{
    /**
     * Original `Processor` instance
     * @var ProcessorInterface
     */
    private $orig;

    /**
     * The max length
     * @var int
     */
    private $max;

    /**
     * The current printed out length of chunks' content
     * @var int
     */
    private $cur;

     /**
     * Creates immutable object that counts the length of chunks' content has
     * outputed and throws \LengthException when it's reached specified `max` param
     *
     * @param ProcessorInterface $orig Original instance
     * @param int $max The max length
     */
    public function __construct(ProcessorInterface $p, int $max)
    {
        $this->orig = $p;
        $this->max = $max;
        $this->cur = 0;
    }

    /**
     * {@inheritdoc}
     * @throws LengthException when the length of chunks' content
     * has outputed has reached specified `max` param
     */
    public function outputed(ChunkInterface $c): ProcessorInterface
    {
        ob_start();
        $obj = new self($this->orig->outputed($c), $this->max);
        $length = ob_get_length();
        ob_end_flush();
        $obj->cur = $this->cur + $length;
        if ($obj->cur >= $this->max) {
            throw new LengthException("the length(in bytes) of chunks has reached its limit=`{$this->max}`");
        }
        return $obj;
    }

    /**
     * {@inheritdoc}
     */
    public function reset(): ProcessorInterface
    {
        return new self($this->orig->reset(), $this->max);
    }
}
