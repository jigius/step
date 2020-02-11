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

namespace Jigius\Step\Processor\Repository\Local\Urn;

use Jigius\Step\Processor\Repository\Local\UrnInterface;

/**
 * The purpose of this immutable object is fetches Urn values as string
 * in serial way with using of a specified template
 *
 * @package Jigius\Step\Processors\Repository\Local\Urn
 */
final class SerialUrn implements UrnInterface
{
    /**
     * The current num into specified sequence
     * @var int
     */
    private $n;

    /**
     * A template for creating of URN value
     *
     * The template can contain placeholders `{%NUM%}` thouse are will
     * be replaced with num of current num into specified sequence
     *
     * @var tpl
     */
    private $tpl;

    /**
     * The start num of the specified nums sequence
     * @var int
     */
    private $start;

    /**
     * Create immutable object with specified values for the template
     * and the start num of the specified nums sequence
     *
     * @param string $tpl The template. It can contain placeholders `{%NUM%}`
     * thouse are will be replaced with num of current num into specified sequence
     * @param int $start The start num of the specified nums sequence
     */
    public function __construct(string $tpl, int $start = 0)
    {
        $this->tpl = $tpl;
        $this->start = $start;
    }

    /**
     * {@inheritdoc}
     *
     */
    public function pulled(): UrnInterface
    {
        $obj = new self($this->tpl, $this->start);
        $obj->n = $this->n === null? $this->start: $this->n + 1;
        return $obj;
    }

    /**
     * {@inheritdoc}
     *
     */
    public function fetch(): string
    {
        if ($this->n === null) {
            return $this->pulled()->fetch();
        }
        return
            preg_replace(
                "~" . preg_quote("{%NUM%}") . "~",
                $this->n,
                $this->tpl
            );
    }
}
