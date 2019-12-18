<?php

/*
 * This file is part of Hashids.
 *
 * (c) Ivan Akimov <ivan@barreleye.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zilf\Security\Hashids;

/**
 * This is the math class.
 *
 * @author Vincent Klaiber <hello@vinkla.com>
 */
class Math
{
    /**
     * Add two arbitrary-length integers.
     *
     * @param string $a
     * @param string $b
     *
     * @return string
     */
    public static function add($a, $b)
    {
        if (function_exists('gmp_add')) {
            return gmp_add($a, $b);
        }

        return bcadd($a, $b, 0);
    }

    /**
     * Multiply two arbitrary-length integers.
     *
     * @param string $a
     * @param string $b
     *
     * @return string
     */
    public static function multiply($a, $b)
    {
        if (function_exists('gmp_mul')) {
            return gmp_mul($a, $b);
        }

        return bcmul($a, $b, 0);
    }

    /**
     * Divide two arbitrary-length integers.
     *
     * @param string $a
     * @param string $b
     *
     * @return string
     */
    public static function divide($a, $b)
    {
        if (function_exists('gmp_div_q')) {
            return gmp_div_q($a, $b);
        }

        return bcdiv($a, $b, 0);
    }

    /**
     * Compute arbitrary-length integer modulo.
     *
     * @param string $n
     * @param string $d
     *
     * @return string
     */
    public static function mod($n, $d)
    {
        if (function_exists('gmp_mod')) {
            return gmp_mod($n, $d);
        }

        return bcmod($n, $d);
    }

    /**
     * Compares two arbitrary-length integers.
     *
     * @param string $a
     * @param string $b
     *
     * @return bool
     */
    public static function greaterThan($a, $b)
    {
        if (function_exists('gmp_cmp')) {
            return gmp_cmp($a, $b) > 0;
        }

        return bccomp($a, $b, 0) > 0;
    }

    /**
     * Converts arbitrary-length integer to PHP integer.
     *
     * @param string $a
     *
     * @return int
     */
    public static function intval($a)
    {
        if (function_exists('gmp_intval')) {
            return gmp_intval($a);
        }

        return intval($a);
    }

    /**
     * Converts arbitrary-length integer to PHP string.
     *
     * @param string $a
     *
     * @return string
     */
    public static function strval($a)
    {
        if (function_exists('gmp_strval')) {
            return gmp_strval($a);
        }

        return $a;
    }

    /**
     * Converts PHP integer to arbitrary-length integer.
     *
     * @param int $a
     *
     * @return string
     */
    public static function get($a)
    {
        if (function_exists('gmp_init')) {
            return gmp_init($a);
        }

        return $a;
    }
}
