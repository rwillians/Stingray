<?php

namespace Rwillians\Stingray;

use ArrayAccess;


/**
 * Class Stingray.
 * Get or Set array node using dot notation.
 *
 * @author Matthew Ratzke <matthew.003@me.com>
 * @author Rafael Willians <me@rwillians.com>
 */
class Stingray
{
    /**
     * Get's the value from an array using dot notation.
     *
     * @param array  &$data Multidimensional array being searched
     * @param string $path Dot notation string path to be searched within the multidimensional array.
     *
     * @return mixed Returns null in the the requested path couldn't be found.
     */
    public static function get(&$data, $path)
    {
        $paths = explode('.', $path);
        $node  = &$data;
        $isArrayLike = self::isArrayLike($data);

        foreach ($paths as $nextPath) {
            if (!$isArrayLike || !array_key_exists($nextPath, $node)) {
                return null;
            }

            $node = &$node[$nextPath];
            $isArrayLike = self::isArrayLike($node);
        }

        return $node;
    }

    /**
     * Check value is array like
     * This can be an array or object witch implements ArrayAccess interface
     *
     * @param $data
     * @return bool
     */
    public static function isArrayLike($data){
        return (is_array($data) || $data instanceof ArrayAccess );
    }

    /**
     * Set's a value to an array node using dot notation.
     *
     * @param array  &$data Array being searched.
     * @param string $path Path used to search array.
     * @param mixed  $value Value to set array node.
     *
     * @return bool
     */
    public static function set(&$data, $path, $value)
    {
        $paths            = explode('.', $path);
        $pathCount        = count($paths);
        $currentIteration = 0;
        $node             = &$data;

        foreach ($paths as $nextPath) {
            if (array_key_exists($nextPath, $node)) {
                $node = &$node[$nextPath];
                $currentIteration++;
            } elseif ($currentIteration < $pathCount) {
                $node[$nextPath] = [];
                $node            = &$node[$nextPath];
                $currentIteration++;
            }
        }

        $node = $value;
    }
}