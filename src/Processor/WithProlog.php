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
 * Decorator
 *
 * This immutable object printing additonal data at the begining of printing
 * data into standard output, produced by original one
 *
 * @package Jigius\Step\Processor
 */
final class WithProlog implements ProcessorInterface
{
    /**
     * Original `Processor` instance
     * @var ProcessorInterface
     */
    private $orig;

    /**
     * Additional data
     * @var string
     */
    private $text;

    /**
     * The flag says if additional data is printed or not in case
     * when no printed data from original instance is exists
     * @var bool
     */
    private $emptyIsSupressed;

    /**
     * The flag says if additional data has been already printed or not
     * @var bool
     */
    private $finished;

    /**
     * Creates immutable object printing additonal data at the begining of
     * printing data into standard output, produced by original one
     *
     * @param ProcessorInterface $orig Original instance
     * @param string $text Additional data
     * @param bool $emptyIsSupressed The flag says if additional data is
     * printed or not in case when no printed data from original instance is exists
     */
    public function __construct(ProcessorInterface $p, string $text, bool $emptyIsSupressed = true)
    {
        $this->orig = $p;
        $this->text = $text;
        $this->emptyIsSupressed = $emptyIsSupressed;
        $this->finished = false;
    }

    /**
     * {@inheritdoc}
     */
    public function outputed(ChunkInterface $c): ProcessorInterface
    {
        ob_start();
        $obj = new self($this->orig->outputed($c), $this->text, $this->emptyIsSupressed);
        $obj->finished = $this->finished;
        $output = ob_get_clean();
        if (!$this->finished && (!empty($output) || !$this->emptyIsSupressed)) {
            echo $this->text;
            $obj->finished = true;
        }
        echo $output;
        return $obj;
    }

    /**
     * {@inheritdoc}
     */
    public function reset(): ProcessorInterface
    {
        ob_start();
        $obj = new self($this->orig->reset(), $this->text, $this->emptyIsSupressed);
        $output = ob_get_clean();
        if (!$this->finished && (!empty($output) || !$this->emptyIsSupressed)) {
            echo $this->text;
        }
        echo $output;
        return $obj;
    }
}
