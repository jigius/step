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
 * Class decorator
 *
 * Prints additonal data at the end of printing
 * data into standard output, produced by decorated instance
 *
 * @package Jigius\Step\Processor
 */
final class WithEpilog implements ProcessorInterface
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
     * The flag says if printed data from
     * original instance is exists or not
     * @var bool
     */
    private $emptied;

    /**
     * Creates immutable object printing additonal data at the end of
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
        $this->emptied = true;
    }

    /**
     * {@inheritdoc}
     */
    public function outputed(ChunkInterface $c): ProcessorInterface
    {
        ob_start();
        $obj = new self($this->orig->outputed($c), $this->text, $this->emptyIsSupressed);
        $obj->emptied = $this->emptied;
        if (ob_get_length() > 0) {
            $obj->emptied = false;
        }
        ob_end_flush();
        return $obj;
    }

    /**
     * {@inheritdoc}
     */
    public function reset(): ProcessorInterface
    {
        $obj = new self($this->orig->reset(), $this->text, $this->emptyIsSupressed);
        if (!$this->emptied || !$this->emptyIsSupressed) {
            echo $this->text;
        }
        return $obj;
    }
}
