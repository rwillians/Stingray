<?php
/*
 * This file is part of the Stingray package.
 *
 * (c) Matthew Ratzke <matthew.003@me.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Rwillians\Stingray\Exception;


/**
 * ArrayNodeNotFoundException
 * Error thrown when unable to find an array key
 * @author Matthew Ratzke <matthew.003@me.com>
 */
class ArrayNodeNotFoundException extends \InvalidArgumentException
{
    /**
     * Constructor.
     * @param string $node Failed array node
     * @param string $string Dot delimited string used to search array
     */
    public function __construct($node, $string)
    {
        parent::__construct(sprintf('The array node "%s" was not found while using "%s" to search', $node, $string));
    }
}
