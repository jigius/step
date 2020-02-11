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

namespace Jigius\Step\Processor\Repository\Local\Entity;

use Jigius\Step\Processor\Repository\EntityInterface;
use DomainException;
use RuntimeException;

/**
 * The purpose of this immutable object is
 * represents a text file into Local File System
 *
 * @package Jigius\Step\Processors\Repository\Local\Entity
 */
final class TextFileEntity implements EntityInterface
{
    /**
     * The full path to a file
     * @var string
     */
    private $pathfile;

    /**
     * The mode of opened file
     * @var string
     */
    private $mode;

    /**
     * The file descriptor of opened file
     * @var resource
     */
    private $fd;

    /**
     * Creates immutable object that represents
     * a text file into Local File System
     *
     * @param string $pathfile The full path to a file
     * @param string $mode The mode of opened file
     */
    public function __construct(string $pathfile, string $mode = "wb")
    {
        $this->pathfile = $pathfile;
        $this->mode = $mode;
    }

    /**
     * {@inheritdoc}
     *
     */
    public function opened(): EntityInterface
    {
        if ($this->fd !== null) {
            throw new DomainException("already opened");
        }
        $obj = $this->blueprinted();
        if (($obj->fd = fopen($this->pathfile, $this->mode)) === false) {
            throw new RuntimeException("ioerror occured");
        }
        return $obj;
    }

    /**
     * {@inheritdoc}
     *
     */
    public function closed(): EntityInterface
    {
        if ($this->fd === null) {
            throw new DomainException("already closed");
        }
        fclose($this->fd);
        $obj = $this->blueprinted();
        $obj->fd = null;
        return $obj;
    }

    /**
     * {@inheritdoc}
     *
     */
    public function written(&$data): EntityInterface
    {
        if (!is_string($data)) {
            throw new DomainException("input data is invalid");
        }
        if ($this->fd === null) {
            throw new DomainException("isn't opened yet");
        }
        $length = fwrite($this->fd, $data);
        if ($length === false || $length !== strlen($data)) {
            throw new RuntimeException("ioerror occured");
        }
        return $this;
    }

    /**
     * {@inheritdoc}
     *
     */
    public function uri(): string
    {
        return $this->pathfile;
    }

    /**
     * {@inheritdoc}
     *
     */
    public function ready(): bool
    {
        return $this->fd !== null;
    }

    /**
     * Bluprints the current instance of object
     *
     * @return TextFile Returns bluprinted instance of object
     */
    private function blueprinted(): self
    {
        $obj = new self($this->pathfile, $this->mode);
        $obj->fd = $this->fd;
        return $obj;
    }
}
