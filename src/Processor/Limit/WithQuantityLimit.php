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
 * This immutable object counts the quantity of chunks has outputed
 * and throws \LengthException when it's reached specified value
 *
 * @package Jigius\Step\Processor\Limit
 */
final class WithQuantityLimit implements ProcessorInterface
{
    /**
     * Original `Processor` instance
     * @var ProcessorInterface
     */
    private $orig;

    /**
     * The max quantity
     * @var int
     */
    private $max;

    /**
     * The current printed out quantity
     * @var int
     */
    private $cur;

    /**
     * Creates immutable object that counts the quantity of chunks has outputed
     * and throws \LengthException when it's reached specified `max` param
     *
     * @param ProcessorInterface $orig Original instance
     * @param int $max The max quantity
     */
    public function __construct(ProcessorInterface $p, int $max)
    {
        $this->orig = $p;
        $this->max = $max;
        $this->cur = 0;
    }

    /**
     * {@inheritdoc}
     * @throws \LengthException when the quantity of chunks
     * has outputed has reached specified `max` param
     */
    public function outputed(ChunkInterface $c): ProcessorInterface
    {
        ob_start();
        $obj = new self($this->orig->outputed($c), $this->max);
        $length = ob_get_length();
        ob_end_flush();
        $obj->cur = $this->cur;
        if ($c->counted() && $length > 0 && ++$obj->cur > $this->max) {
            throw new LengthException("the quantity of chunks has reached its limit=`{$this->max}`");
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
