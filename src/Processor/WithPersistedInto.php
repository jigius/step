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
 * This immutable object catches all been printing data
 * from original one and persistence it
 *
 * @package Jigius\Step\Processor
 */
final class WithPersistedInto implements ProcessorInterface
{
    /**
     * Original `Processor` instance
     * @var ProcessorInterface
     */
    private $orig;

    /**
     * @var RepositoryInterface
     */
    private $repo;

    /**
     * @var Repository\EntityInterface
     */
    private $entity;

    /**
     * The flag says if opens/creates file in case
     * when no printed data from original instance is exists
     * @var bool
     */
    private $emptyIsSupressed;

     /**
     * Creates immutable object catches all been
     * printing data from original one and persistence it
     *
     * @param ProcessorInterface $orig Original `Processor` instance
     * @param RepositoryInterface $repo `Repository` instance
     * @param bool $emptyIsSupressed The flag says if additional data is
     * printed or not in case when no printed data from original instance is exists
     */
    public function __construct(
        ProcessorInterface $p,
        Repository\RepositoryInterface $repo,
        bool $emptyIsSupressed = true
    ) {
        $this->orig = $p;
        $this->repo = $repo;
        $this->emptyIsSupressed = $emptyIsSupressed;
    }

    /**
     * {@inheritdoc}
     *
     * Catches all been printing data from original one and persistence it
     */
    public function outputed(ChunkInterface $c): ProcessorInterface
    {
        ob_start();
        $orig = $this->orig->outputed($c);
        $output = ob_get_clean();
        $entity = $this->entity;
        $repo = $this->repo;
        if (!$this->emptyIsSupressed || !empty($output)) {
            if ($entity === null || !$entity->ready()) {
                $repo = $repo->pulled();
                $entity = $repo->entity()->opened();
            }
            $entity = $entity->written($output);
        }
        $obj = new self($orig, $repo, $this->emptyIsSupressed);
        $obj->entity = $entity;
        return $obj;
    }

    /**
     * {@inheritdoc}
     *
     * Catches all been printing data from original one and persistence it
     */
    public function reset(): ProcessorInterface
    {
        ob_start();
        $orig = $this->orig->reset();
        $output = ob_get_clean();
        $entity = $this->entity;
        $repo = $this->repo;
        if (!$this->emptyIsSupressed || !empty($output)) {
            if ($entity === null || !$entity->ready()) {
                $repo = $repo->pulled();
                $entity = $repo->entity()->opened();
            }
            $entity = $entity->written($output)->closed();
            echo $repo->urn($entity);
        }
        $obj = new self($orig, $repo, $this->emptyIsSupressed);
        $obj->entity = $entity;
        return $obj;
    }
}
