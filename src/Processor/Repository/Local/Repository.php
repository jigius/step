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

namespace Jigius\Step\Processor\Repository\Local;

use Jigius\Step\Processor\Repository\RepositoryInterface;
use Jigius\Step\Processor\Repository\EntityInterface;
use Jigius\Step\Processor\Repository\EntityPrinterInterface;

/**
 * The purpose of this immutable object is instantiates `Entity`
 * instances thouse are represents files into Local File System
 *
 * @package Jigius\Step\Processors\Repository\Local
 */
final class Repository implements RepositoryInterface
{
    /**
     * The base folder is used for creates absolute path to a file
     * @var string
     */
    private $baseFolder;

    /**
     * The URN of current entity
     * @var UrnInterface
     */
    private $urn;

    /**
     * The printer (creator) of entities
     * @var EntityPrinterInterface
     */
    private $printer;

    /**
     * Creates immutable object for instantiating `Entity` instances
     * thouse are represents files into Local File System
     */
    public function __construct(string $baseFolder, UrnInterface $urn, EntityPrinterInterface $printer)
    {
        $this->baseFolder = $baseFolder;
        $this->urn = $urn;
        $this->printer = $printer;
    }

    /**
     * {@inheritdoc}
     *
     */
    public function pulled(): RepositoryInterface
    {
        return new self($this->baseFolder, $this->urn->pulled(), $this->printer);
    }

    /**
     * {@inheritdoc}
     *
     */
    public function entity(): EntityInterface
    {
        return
            $this
                ->printer
                    ->with(
                        'pathfile',
                        $this->baseFolder . "/" . $this->urn->fetch()
                    )
                ->create();
    }

    /**
     * {@inheritdoc}
     *
     */
    public function urn(EntityInterface $entity): string
    {
        return
            preg_replace(
                "~" . preg_quote($this->baseFolder) . "/~",
                "",
                $entity->uri()
            );
    }
}
