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

namespace Jigius\Step\Processor\Repository\Local\Printer;

use Jigius\Step\Processor\Repository\EntityPrinterInterface;
use Jigius\Step\Processor\Repository\EntityInterface;
use Jigius\Step\Processor\Repository\Local;
use DomainException;

/**
 * Printer class used for creates `TextFile` instances
 *
 * @package Jigius\Step\Processor\Repository\Local\Printer
 */
final class TextFilePrinter implements EntityPrinterInterface
{
    /**
     * The mode of opened file
     * @var string
     */
    private $mode;

    /**
     * The full path to a file
     * @var string
     */
    private $pathfile;

    /**
     * Creates immutable instance of Printer class used
     * for creating `TextFile` instances
     *
     * @param string $mode The default mode of opened file
     */
    public function __construct(string $mode = "wb")
    {
        $this->mode = $mode;
    }

    /**
     * {@inheritdoc}
     *
     */
    public function with(string $key, string $val): EntityPrinterInterface
    {
        $obj = $this->blueprinted();
        if ($key == "pathfile") {
            $obj->pathfile = $val;
        } elseif ($key == "mode") {
            $obj->mode = $val;
        }
        return $obj;
    }

    /**
     * {@inheritdoc}
     *
     * @throws \DomainException if the gotten data is invalid
     */
    public function create(): EntityInterface
    {
        if ($this->pathfile === null) {
            throw new DomainException("input data is invalid");
        }
        return new Local\Entity\TextFileEntity($this->pathfile, $this->mode);
    }

    /**
     * Bluprints the current instance of object
     *
     * @return GzipedTextPrinter returns bluprinted instance of object
     */
    private function blueprinted(): self
    {
        $obj = new self();
        $obj->pathfile = $this->pathfile;
        $obj->mode = $this->mode;
        return $obj;
    }
}
