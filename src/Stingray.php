<?php
/*
 * This file is part of the Stingray package.
 *
 * (c) Matthew Ratzke <matthew.003@me.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Rwillians\Stingray;

use Rwillians\Stingray\Exception\ArrayNodeNotFoundException;


/**
 * Stingray.
 * Get or Set array node using dot notation.
 * @author Matthew Ratzke <matthew.003@me.com>
 */
class Stingray
{
    /**
     * Get's an array node using dot notation.
     * @param array &$data Multidimensional array being searched
     * @param string $path Dot notation string path to be searched within the multidimensional array.
     * @return array Node
     */
    public static function get(&$data, $path)
    {
        return static::iterateNodeGet($data, $path);
    }

    /**
     * Set's an array node value using dot notation.
     * @param array &$data Array being searched
     * @param string $string String used to search array
     * @param mixed $value Value to set array node
     * @param bool $silent If array node is missing it will be create
     */
    public static function set(&$data, $string, $value, $silent = false)
    {
        static::iterateNodeSet($data, $string, $value, $silent);
    }

    /**
     * Iterate through array using dot notation.
     * @param array &$data Array being searched.
     * @param string $string String used to search array.
     * @return array $node Array Node.
     * @throws \Rwillians\Stingray\Exception\ArrayNodeNotFoundException When tried to access an invalid path.
     */
    protected static function iterateNodeGet(&$data, $string)
    {
        $paths = explode('.', $string);
        $node =& $data;

        foreach ($paths as $path) {
            if (array_key_exists($path, $node)) {
                $node =& $node[$path];
            } else {
                throw new ArrayNodeNotFoundException($path, $string);
            }
        }

        return $node;
    }

    /**
     * Iterate through array using dot notation.
     * @param array &$data Array being searched.
     * @param string $string String used to search array.
     * @param bool $silent If array node is missing it will be create.
     * @param mixed $value The value the node should be set to.
     * @return void
     * @throws \Rwillians\Stingray\Exception\ArrayNodeNotFoundException When $silence if false and tried to access an invalid path.
     */
    protected static function iterateNodeSet(&$data, $string, $value, $silent = false)
    {
        $paths = explode('.', $string);
        $pathCount = count($paths);
        $currentIteration = 0;
        $node =& $data;

        foreach ($paths as $path) {
            if (array_key_exists($path, $node)) {
                $node =& $node[$path];
                $currentIteration++;
            } elseif ($silent == false) {
                throw new ArrayNodeNotFoundException($path, $string);
            } elseif ($currentIteration < $pathCount) {
                $node[$path] = array();
                $node =& $node[$path];
                $currentIteration++;
            }
        }

        $node = $value;
    }
}