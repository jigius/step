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
use RuntimeException;
use LengthException;
use Exception;

/**
 * Decorator
 *
 * This immutable object catches specified (via
 * classname) exceptions and resets the decorated one
 *
 * @package Jigius\Step\Processor
 */
final class WithResetOnException implements ProcessorInterface
{
    /**
     * Original `Processor` instance
     * @var ProcessorInterface
     */
    private $orig;

    /**
     * The classname of exception is looked for
     * @var string
     */
    private $ecn;

    /**
     * Says if the instance is `in progress` status
     * @var bool
     */
    private $inProgress;

    /**
     * Creates an `Processor` instance wich decorates original one
     *
     * @param ProcessorInterface $orig Original instance
     * @param string $classname The classname of exception is looked for
     */
    public function __construct(ProcessorInterface $p, string $classname = LengthException::class)
    {
        $this->orig = $p;
        $this->ecn = $classname;
        $this->inProgress = false;
    }

    /**
     * {@inheritdoc}
     *
     * Catches specified (via classname) exceptions and resets original one.
     *
     * @param ChunkInterface $c The outputed chunk
     * @return ProcessorInterface
     * @throws \RuntimeException If there were two sequential tries to reset without any success
     */
    public function outputed(ChunkInterface $c): ProcessorInterface
    {
        ob_start();
        try {
            $obj = new self($this->orig->outputed($c));
        } catch (Exception $ex) {
            if ($ex instanceof $this->ecn) {
                if ($this->inProgress) {
                    ob_end_clean();
                    throw new RuntimeException("there were two sequential tries to reset without any success");
                }
                ob_clean();
                $obj = $this->reset();
                $obj->inProgress = true;
                $obj = $obj->outputed($c);
            } else {
                throw $ex;
            }
        }
        ob_end_flush();
        return $obj;
    }

    /**
     * {@inheritdoc}
     */
    public function reset(): ProcessorInterface
    {
        return new self($this->orig->reset());
    }
}
