<?php

namespace Zilf\Helpers;

use ArrayAccess;

class Arr
{
    /**
     * Converts an object or an array of objects into an array.
     *
     * @param object|array|string $object     the object to be converted into an array
     * @param array               $properties a mapping from object class names to the properties that need to put into the resulting arrays.
     *                                        The properties specified for each class is an array of the following format: ```php [
     *                                        'app\models\Post' => [ 'id', 'title', // the key name in array result => property name
     *                                        'createTime' => 'created_at', // the key name in array result => anonymous function 'length' =>
     *                                        function ($post) { return strlen($post->content); }, ], ] ``` The result of
     *                                        `ArrayHelper::toArray($post, $properties)` could be like the following: ```php [ 'id' => 123,
     *                                        'title' => 'test', 'createTime' => '2013-01-01 12:00AM', 'length' => 301, ] ```
     *
     * @param  boolean             $recursive  whether to recursively converts properties which are objects into arrays.
     * @return array the array representation of the object
     */
    public static function toArray($object, $properties = [], $recursive = true)
    {
        if (is_array($object)) {
            if ($recursive) {
                foreach ($object as $key => $value) {
                    if (is_array($value) || is_object($value)) {
                        $object[$key] = static::toArray($value, $properties, true);
                    }
                }
            }

            return $object;
        } elseif (is_object($object)) {
            if (!empty($properties)) {
                $className = get_class($object);
                if (!empty($properties[$className])) {
                    $result = [];
                    foreach ($properties[$className] as $key => $name) {
                        if (is_int($key)) {
                            $result[$name] = $object->$name;
                        } else {
                            $result[$key] = static::getValue($object, $name);
                        }
                    }

                    return $recursive ? static::toArray($result, $properties) : $result;
                }
            }
            if ($object instanceof Arrayable) {
                $result = $object->toArray([], [], $recursive);
            } else {
                $result = [];
                foreach ($object as $key => $value) {
                    $result[$key] = $value;
                }
            }

            return $recursive ? static::toArray($result, $properties) : $result;
        } else {
            return [$object];
        }
    }

    /**
     * Merges two or more arrays into one recursively.
     * If each array has an element with the same string key value, the latter
     * will overwrite the former (different from array_merge_recursive).
     * Recursive merging will be conducted if both arrays have an element of array
     * type and are having the same key.
     * For integer-keyed elements, the elements from the latter array will
     * be appended to the former array.
     * You can use [[UnsetArrayValue]] object to unset value from previous array or
     * [[ReplaceArrayValue]] to force replace former value instead of recursive merging.
     *
     * @param  array $a array to be merged to
     * @param  array $b array to be merged from. You can specify additional
     *                  arrays via third argument, fourth argument etc.
     * @return array the merged array (the original arrays are not changed.)
     */
    public static function merge($a, $b)
    {
        $args = func_get_args();
        $res = array_shift($args);
        while (!empty($args)) {
            $next = array_shift($args);
            foreach ($next as $k => $v) {
                if (is_int($k)) {
                    if (isset($res[$k])) {
                        $res[] = $v;
                    } else {
                        $res[$k] = $v;
                    }
                } elseif (is_array($v) && isset($res[$k]) && is_array($res[$k])) {
                    $res[$k] = self::merge($res[$k], $v);
                } else {
                    $res[$k] = $v;
                }
            }
        }

        return $res;
    }

    /**
     * Retrieves the value of an array element or object property with the given key or property name.
     * If the key does not exist in the array or object, the default value will be returned instead.
     *
     * The key may be specified in a dot format to retrieve the value of a sub-array or the property
     * of an embedded object. In particular, if the key is `x.y.z`, then the returned value would
     * be `$array['x']['y']['z']` or `$array->x->y->z` (if `$array` is an object). If `$array['x']`
     * or `$array->x` is neither an array nor an object, the default value will be returned.
     * Note that if the array already has an element `x.y.z`, then its value will be returned
     * instead of going through the sub-arrays. So it is better to be done specifying an array of key names
     * like `['x', 'y', 'z']`.
     *
     * Below are some usage examples,
     *
     * ```php
     * // working with array
     * $username = \Zilf\Helpers\ArrayHelper::getValue($_POST, 'username');
     * // working with object
     * $username = \Zilf\Helpers\ArrayHelper::getValue($user, 'username');
     * // working with anonymous function
     * $fullName = \Zilf\Helpers\ArrayHelper::getValue($user, function ($user, $defaultValue) {
     *     return $user->firstName . ' ' . $user->lastName;
     * });
     * // using dot format to retrieve the property of embedded object
     * $street = \Zilf\Helpers\ArrayHelper::getValue($users, 'address.street');
     * // using an array of keys to retrieve the value
     * $value = \Zilf\Helpers\ArrayHelper::getValue($versions, ['1.0', 'date']);
     * ```
     *
     * @param  array|object          $array   array or object to extract value from
     * @param  string|\Closure|array $key     key name of the array element, an array of keys or property name of the object,
     *                                        or an anonymous function returning the value. The anonymous function signature
     *                                        should be: `function($array, $defaultValue)`. The possibility to pass an array
     *                                        of keys is available since version 2.0.4.
     * @param  mixed                 $default the default value to be returned if the specified array key does not exist. Not used when
     *                                        getting value from an object.
     * @return mixed the value of the element if found, default value otherwise
     * @throws InvalidParamException if $array is neither an array nor an object.
     */
    public static function getValue($array, $key, $default = null)
    {
        if ($key instanceof \Closure) {
            return $key($array, $default);
        }

        if (is_array($key)) {
            $lastKey = array_pop($key);
            foreach ($key as $keyPart) {
                $array = static::getValue($array, $keyPart);
            }
            $key = $lastKey;
        }

        if (is_array($array) && (isset($array[$key]) || array_key_exists($key, $array))) {
            return $array[$key];
        }

        if (($pos = strrpos($key, '.')) !== false) {
            $array = static::getValue($array, substr($key, 0, $pos), $default);
            $key = substr($key, $pos + 1);
        }

        if (is_object($array)) {
            // this is expected to fail if the property does not exist, or __get() is not implemented
            // it is not reliably possible to check whether a property is accessable beforehand
            return $array->$key;
        } elseif (is_array($array)) {
            return (isset($array[$key]) || array_key_exists($key, $array)) ? $array[$key] : $default;
        } else {
            return $default;
        }
    }

    /**
     * Removes an item from an array and returns the value. If the key does not exist in the array, the default value
     * will be returned instead.
     *
     * Usage examples,
     *
     * ```php
     * // $array = ['type' => 'A', 'options' => [1, 2]];
     * // working with array
     * $type = \Zilf\Helpers\ArrayHelper::remove($array, 'type');
     * // $array content
     * // $array = ['options' => [1, 2]];
     * ```
     *
     * @param  array  $array   the array to extract value from
     * @param  string $key     key name of the array element
     * @param  mixed  $default the default value to be returned if the specified key does not exist
     * @return mixed|null the value of the element if found, default value otherwise
     */
    public static function remove(&$array, $key, $default = null)
    {
        if (is_array($array) && (isset($array[$key]) || array_key_exists($key, $array))) {
            $value = $array[$key];
            unset($array[$key]);

            return $value;
        }

        return $default;
    }

    /**
     * Indexes and/or groups the array according to a specified key.
     * The input should be either multidimensional array or an array of objects.
     *
     * The $key can be either a key name of the sub-array, a property name of object, or an anonymous
     * function that must return the value that will be used as a key.
     *
     * $groups is an array of keys, that will be used to group the input array into one or more sub-arrays based
     * on keys specified.
     *
     * If the `$key` is specified as `null` or a value of an element corresponding to the key is `null` in addition
     * to `$groups` not specified then the element is discarded.
     *
     * For example:
     *
     * ```php
     * $array = [
     *     ['id' => '123', 'data' => 'abc', 'device' => 'laptop'],
     *     ['id' => '345', 'data' => 'def', 'device' => 'tablet'],
     *     ['id' => '345', 'data' => 'hgi', 'device' => 'smartphone'],
     * ];
     * $result = ArrayHelper::index($array, 'id');
     * ```
     *
     * The result will be an associative array, where the key is the value of `id` attribute
     *
     * ```php
     * [
     *     '123' => ['id' => '123', 'data' => 'abc', 'device' => 'laptop'],
     *     '345' => ['id' => '345', 'data' => 'hgi', 'device' => 'smartphone']
     *     // The second element of an original array is overwritten by the last element because of the same id
     * ]
     * ```
     *
     * An anonymous function can be used in the grouping array as well.
     *
     * ```php
     * $result = ArrayHelper::index($array, function ($element) {
     *     return $element['id'];
     * });
     * ```
     *
     * Passing `id` as a third argument will group `$array` by `id`:
     *
     * ```php
     * $result = ArrayHelper::index($array, null, 'id');
     * ```
     *
     * The result will be a multidimensional array grouped by `id` on the first level, by `device` on the second level
     * and indexed by `data` on the third level:
     *
     * ```php
     * [
     *     '123' => [
     *         ['id' => '123', 'data' => 'abc', 'device' => 'laptop']
     *     ],
     *     '345' => [ // all elements with this index are present in the result array
     *         ['id' => '345', 'data' => 'def', 'device' => 'tablet'],
     *         ['id' => '345', 'data' => 'hgi', 'device' => 'smartphone'],
     *     ]
     * ]
     * ```
     *
     * The anonymous function can be used in the array of grouping keys as well:
     *
     * ```php
     * $result = ArrayHelper::index($array, 'data', [function ($element) {
     *     return $element['id'];
     * }, 'device']);
     * ```
     *
     * The result will be a multidimensional array grouped by `id` on the first level, by the `device` on the second one
     * and indexed by the `data` on the third level:
     *
     * ```php
     * [
     *     '123' => [
     *         'laptop' => [
     *             'abc' => ['id' => '123', 'data' => 'abc', 'device' => 'laptop']
     *         ]
     *     ],
     *     '345' => [
     *         'tablet' => [
     *             'def' => ['id' => '345', 'data' => 'def', 'device' => 'tablet']
     *         ],
     *         'smartphone' => [
     *             'hgi' => ['id' => '345', 'data' => 'hgi', 'device' => 'smartphone']
     *         ]
     *     ]
     * ]
     * ```
     *
     * @param  array                           $array  the array that needs to be indexed or grouped
     * @param  string|\Closure|null            $key    the column name or anonymous function which result will be used to index the array
     * @param  string|string[]|\Closure[]|null $groups the array of keys, that will be used to group the input array
     *                                                 by one or more keys. If the $key attribute or its value for the particular element is null and $groups is not
     *                                                 defined, the array element will be discarded. Otherwise, if $groups is specified, array element will be added
     *                                                 to the result array without any key. This parameter is available since version 2.0.8.
     * @return array the indexed and/or grouped array
     */
    public static function index($array, $key, $groups = [])
    {
        $result = [];
        $groups = (array)$groups;

        foreach ($array as $element) {
            $lastArray = &$result;

            foreach ($groups as $group) {
                $value = static::getValue($element, $group);
                if (!array_key_exists($value, $lastArray)) {
                    $lastArray[$value] = [];
                }
                $lastArray = &$lastArray[$value];
            }

            if ($key === null) {
                if (!empty($groups)) {
                    $lastArray[] = $element;
                }
            } else {
                $value = static::getValue($element, $key);
                if ($value !== null) {
                    if (is_float($value)) {
                        $value = (string)$value;
                    }
                    $lastArray[$value] = $element;
                }
            }
            unset($lastArray);
        }

        return $result;
    }

    /**
     * Returns the values of a specified column in an array.
     * The input array should be multidimensional or an array of objects.
     *
     * For example,
     *
     * ```php
     * $array = [
     *     ['id' => '123', 'data' => 'abc'],
     *     ['id' => '345', 'data' => 'def'],
     * ];
     * $result = ArrayHelper::getColumn($array, 'id');
     * // the result is: ['123', '345']
     *
     * // using anonymous function
     * $result = ArrayHelper::getColumn($array, function ($element) {
     *     return $element['id'];
     * });
     * ```
     *
     * @param  array           $array
     * @param  string|\Closure $name
     * @param  boolean         $keepKeys whether to maintain the array keys. If false, the resulting array
     *                                   will be re-indexed with integers.
     * @return array the list of column values
     */
    public static function getColumn($array, $name, $keepKeys = true)
    {
        $result = [];
        if ($keepKeys) {
            foreach ($array as $k => $element) {
                $result[$k] = static::getValue($element, $name);
            }
        } else {
            foreach ($array as $element) {
                $result[] = static::getValue($element, $name);
            }
        }

        return $result;
    }

    /**
     * Builds a map (key-value pairs) from a multidimensional array or an array of objects.
     * The `$from` and `$to` parameters specify the key names or property names to set up the map.
     * Optionally, one can further group the map according to a grouping field `$group`.
     *
     * For example,
     *
     * ```php
     * $array = [
     *     ['id' => '123', 'name' => 'aaa', 'class' => 'x'],
     *     ['id' => '124', 'name' => 'bbb', 'class' => 'x'],
     *     ['id' => '345', 'name' => 'ccc', 'class' => 'y'],
     * ];
     *
     * $result = ArrayHelper::map($array, 'id', 'name');
     * // the result is:
     * // [
     * //     '123' => 'aaa',
     * //     '124' => 'bbb',
     * //     '345' => 'ccc',
     * // ]
     *
     * $result = ArrayHelper::map($array, 'id', 'name', 'class');
     * // the result is:
     * // [
     * //     'x' => [
     * //         '123' => 'aaa',
     * //         '124' => 'bbb',
     * //     ],
     * //     'y' => [
     * //         '345' => 'ccc',
     * //     ],
     * // ]
     * ```
     *
     * @param  array           $array
     * @param  string|\Closure $from
     * @param  string|\Closure $to
     * @param  string|\Closure $group
     * @return array
     */
    public static function map($array, $from, $to, $group = null)
    {
        $result = [];
        foreach ($array as $element) {
            $key = static::getValue($element, $from);
            $value = static::getValue($element, $to);
            if ($group !== null) {
                $result[static::getValue($element, $group)][$key] = $value;
            } else {
                $result[$key] = $value;
            }
        }

        return $result;
    }

    /**
     * Checks if the given array contains the specified key.
     * This method enhances the `array_key_exists()` function by supporting case-insensitive
     * key comparison.
     *
     * @param  string  $key           the key to check
     * @param  array   $array         the array with keys to check
     * @param  boolean $caseSensitive whether the key comparison should be case-sensitive
     * @return boolean whether the array contains the specified key
     */
    public static function keyExists($key, $array, $caseSensitive = true)
    {
        if ($caseSensitive) {
            // Function `isset` checks key faster but skips `null`, `array_key_exists` handles this case
            // http://php.net/manual/en/function.array-key-exists.php#107786
            return isset($array[$key]) || array_key_exists($key, $array);
        } else {
            foreach (array_keys($array) as $k) {
                if (strcasecmp($key, $k) === 0) {
                    return true;
                }
            }

            return false;
        }
    }

    /**
     * Sorts an array of objects or arrays (with the same structure) by one or several keys.
     *
     * @param  array                 $array     the array to be sorted. The array will be modified after calling this method.
     * @param  string|\Closure|array $key       the key(s) to be sorted by. This refers to a key name of the sub-array
     *                                          elements, a property name of the objects, or an anonymous function
     *                                          returning the values for comparison purpose. The anonymous function
     *                                          signature should be: `function($item)`. To sort by multiple keys,
     *                                          provide an array of keys here.
     * @param  integer|array         $direction the sorting direction. It can be either `SORT_ASC` or `SORT_DESC`.
     *                                          When sorting by multiple keys with different sorting directions,
     *                                          use an array of sorting directions.
     * @param  integer|array         $sortFlag  the PHP sort flag. Valid values include
     *                                          `SORT_REGULAR`, `SORT_NUMERIC`,
     *                                          `SORT_STRING`, `SORT_LOCALE_STRING`,
     *                                          `SORT_NATURAL` and `SORT_FLAG_CASE`.
     *                                          Please refer to [PHP
     *                                          manual](http://php.net/manual/en/function.sort.php)
     *                                          for more details. When sorting by
     *                                          multiple keys with different sort
     *                                          flags, use an array of sort flags.
     * @throws InvalidParamException if the $direction or $sortFlag parameters do not have
     * correct number of elements as that of $key.
     */
    public static function multisort(&$array, $key, $direction = SORT_ASC, $sortFlag = SORT_REGULAR)
    {
        $keys = is_array($key) ? $key : [$key];
        if (empty($keys) || empty($array)) {
            return;
        }
        $n = count($keys);
        if (is_scalar($direction)) {
            $direction = array_fill(0, $n, $direction);
        } elseif (count($direction) !== $n) {
            throw new InvalidParamException('The length of $direction parameter must be the same as that of $keys.');
        }
        if (is_scalar($sortFlag)) {
            $sortFlag = array_fill(0, $n, $sortFlag);
        } elseif (count($sortFlag) !== $n) {
            throw new InvalidParamException('The length of $sortFlag parameter must be the same as that of $keys.');
        }
        $args = [];
        foreach ($keys as $i => $key) {
            $flag = $sortFlag[$i];
            $args[] = static::getColumn($array, $key);
            $args[] = $direction[$i];
            $args[] = $flag;
        }

        // This fix is used for cases when main sorting specified by columns has equal values
        // Without it it will lead to Fatal Error: Nesting level too deep - recursive dependency?
        $args[] = range(1, count($array));
        $args[] = SORT_ASC;
        $args[] = SORT_NUMERIC;

        $args[] = &$array;
        call_user_func_array('array_multisort', $args);
    }

    /**
     * Encodes special characters in an array of strings into HTML entities.
     * Only array values will be encoded by default.
     * If a value is an array, this method will also encode it recursively.
     * Only string values will be encoded.
     *
     * @param  array   $data       data to be encoded
     * @param  boolean $valuesOnly whether to encode array values only. If false,
     *                             both the array keys and array values will be encoded.
     * @param  string  $charset    the charset that the data is using. If not set,
     *                             [[\yii\base\Application::charset]] will be
     *                             used.
     * @return array the encoded data
     * @see    http://www.php.net/manual/en/function.htmlspecialchars.php
     */
    public static function htmlEncode($data, $valuesOnly = true, $charset = 'UTF-8')
    {
        $d = [];
        foreach ($data as $key => $value) {
            if (!$valuesOnly && is_string($key)) {
                $key = htmlspecialchars($key, ENT_QUOTES | ENT_SUBSTITUTE, $charset);
            }
            if (is_string($value)) {
                $d[$key] = htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, $charset);
            } elseif (is_array($value)) {
                $d[$key] = static::htmlEncode($value, $valuesOnly, $charset);
            } else {
                $d[$key] = $value;
            }
        }

        return $d;
    }

    /**
     * Decodes HTML entities into the corresponding characters in an array of strings.
     * Only array values will be decoded by default.
     * If a value is an array, this method will also decode it recursively.
     * Only string values will be decoded.
     *
     * @param  array   $data       data to be decoded
     * @param  boolean $valuesOnly whether to decode array values only. If false,
     *                             both the array keys and array values will be decoded.
     * @return array the decoded data
     * @see    http://www.php.net/manual/en/function.htmlspecialchars-decode.php
     */
    public static function htmlDecode($data, $valuesOnly = true)
    {
        $d = [];
        foreach ($data as $key => $value) {
            if (!$valuesOnly && is_string($key)) {
                $key = htmlspecialchars_decode($key, ENT_QUOTES);
            }
            if (is_string($value)) {
                $d[$key] = htmlspecialchars_decode($value, ENT_QUOTES);
            } elseif (is_array($value)) {
                $d[$key] = static::htmlDecode($value);
            } else {
                $d[$key] = $value;
            }
        }

        return $d;
    }

    /**
     * Returns a value indicating whether the given array is an associative array.
     *
     * An array is associative if all its keys are strings. If `$allStrings` is false,
     * then an array will be treated as associative if at least one of its keys is a string.
     *
     * Note that an empty array will NOT be considered associative.
     *
     * @param  array   $array      the array being checked
     * @param  boolean $allStrings whether the array keys must be all strings in order for
     *                             the array to be treated as associative.
     * @return boolean whether the array is associative
     */
    public static function isAssociative($array, $allStrings = true)
    {
        if (!is_array($array) || empty($array)) {
            return false;
        }

        if ($allStrings) {
            foreach ($array as $key => $value) {
                if (!is_string($key)) {
                    return false;
                }
            }
            return true;
        } else {
            foreach ($array as $key => $value) {
                if (is_string($key)) {
                    return true;
                }
            }
            return false;
        }
    }

    /**
     * Returns a value indicating whether the given array is an indexed array.
     *
     * An array is indexed if all its keys are integers. If `$consecutive` is true,
     * then the array keys must be a consecutive sequence starting from 0.
     *
     * Note that an empty array will be considered indexed.
     *
     * @param  array   $array       the array being checked
     * @param  boolean $consecutive whether the array keys must be a consecutive sequence
     *                              in order for the array to be treated as indexed.
     * @return boolean whether the array is associative
     */
    public static function isIndexed($array, $consecutive = false)
    {
        if (!is_array($array)) {
            return false;
        }

        if (empty($array)) {
            return true;
        }

        if ($consecutive) {
            return array_keys($array) === range(0, count($array) - 1);
        } else {
            foreach ($array as $key => $value) {
                if (!is_int($key)) {
                    return false;
                }
            }
            return true;
        }
    }

    /**
     * Check whether an array or [[\Traversable]] contains an element.
     *
     * This method does the same as the PHP function [in_array()](http://php.net/manual/en/function.in-array.php)
     * but additionally works for objects that implement the [[\Traversable]] interface.
     *
     * @param  mixed              $needle   The value to look for.
     * @param  array|\Traversable $haystack The set of values to search.
     * @param  boolean            $strict   Whether to enable strict (`===`) comparison.
     * @return boolean `true` if `$needle` was found in `$haystack`, `false` otherwise.
     * @throws InvalidParamException if `$haystack` is neither traversable nor an array.
     * @see    http://php.net/manual/en/function.in-array.php
     * @since  2.0.7
     */
    public static function isIn($needle, $haystack, $strict = false)
    {
        if ($haystack instanceof \Traversable) {
            foreach ($haystack as $value) {
                if ($needle == $value && (!$strict || $needle === $value)) {
                    return true;
                }
            }
        } elseif (is_array($haystack)) {
            return in_array($needle, $haystack, $strict);
        } else {
            throw new InvalidParamException('Argument $haystack must be an array or implement Traversable');
        }

        return false;
    }

    /**
     * Checks whether a variable is an array or [[\Traversable]].
     *
     * This method does the same as the PHP function [is_array()](http://php.net/manual/en/function.is-array.php)
     * but additionally works on objects that implement the [[\Traversable]] interface.
     *
     * @param  mixed $var The variable being evaluated.
     * @return boolean whether $var is array-like
     * @see    http://php.net/manual/en/function.is_array.php
     * @since  2.0.8
     */
    public static function isTraversable($var)
    {
        return is_array($var) || $var instanceof \Traversable;
    }

    /**
     * Checks whether an array or [[\Traversable]] is a subset of another array or [[\Traversable]].
     *
     * This method will return `true`, if all elements of `$needles` are contained in
     * `$haystack`. If at least one element is missing, `false` will be returned.
     *
     * @param  array|\Traversable $needles  The values that must **all** be in `$haystack`.
     * @param  array|\Traversable $haystack The set of value to search.
     * @param  boolean            $strict   Whether to enable strict (`===`) comparison.
     * @throws InvalidParamException if `$haystack` or `$needles` is neither traversable nor an array.
     * @return boolean `true` if `$needles` is a subset of `$haystack`, `false` otherwise.
     * @since  2.0.7
     */
    public static function isSubset($needles, $haystack, $strict = false)
    {
        if (is_array($needles) || $needles instanceof \Traversable) {
            foreach ($needles as $needle) {
                if (!static::isIn($needle, $haystack, $strict)) {
                    return false;
                }
            }
            return true;
        } else {
            throw new InvalidParamException('Argument $needles must be an array or implement Traversable');
        }
    }

    /**
     * Filters array according to rules specified.
     *
     * For example:
     *
     * ```php
     * $array = [
     *     'A' => [1, 2],
     *     'B' => [
     *         'C' => 1,
     *         'D' => 2,
     *     ],
     *     'E' => 1,
     * ];
     *
     * $result = \Zilf\Helpers\ArrayHelper::filter($array, ['A']);
     * // $result will be:
     * // [
     * //     'A' => [1, 2],
     * // ]
     *
     * $result = \Zilf\Helpers\ArrayHelper::filter($array, ['A', 'B.C']);
     * // $result will be:
     * // [
     * //     'A' => [1, 2],
     * //     'B' => ['C' => 1],
     * // ]
     *
     * $result = \Zilf\Helpers\ArrayHelper::filter($array, ['B', '!B.C']);
     * // $result will be:
     * // [
     * //     'B' => ['D' => 2],
     * // ]
     * ```
     *
     * @param  array $array   Source array
     * @param  array $filters Rules that define array keys which should be left or removed from results.
     *                        Each rule is:
     *                        - `var` - `$array['var']` will be left in result.
     *                        - `var.key` = only `$array['var']['key'] will be left in result.
     *                        - `!var.key` = `$array['var']['key'] will be removed from result.
     * @return array Filtered array
     * @since  2.0.9
     */
    public static function filter($array, $filters)
    {
        $result = [];
        $forbiddenVars = [];

        foreach ($filters as $var) {
            $keys = explode('.', $var);
            $globalKey = $keys[0];
            $localKey = isset($keys[1]) ? $keys[1] : null;

            if ($globalKey[0] === '!') {
                $forbiddenVars[] = [
                    substr($globalKey, 1),
                    $localKey,
                ];
                continue;
            }

            if (empty($array[$globalKey])) {
                continue;
            }
            if ($localKey === null) {
                $result[$globalKey] = $array[$globalKey];
                continue;
            }
            if (!isset($array[$globalKey][$localKey])) {
                continue;
            }
            if (!array_key_exists($globalKey, $result)) {
                $result[$globalKey] = [];
            }
            $result[$globalKey][$localKey] = $array[$globalKey][$localKey];
        }

        foreach ($forbiddenVars as $var) {
            list($globalKey, $localKey) = $var;
            if (array_key_exists($globalKey, $result)) {
                unset($result[$globalKey][$localKey]);
            }
        }

        return $result;
    }

    ////////////////////////////////////////////////////////////////////////////////

    /**
     * Determine whether the given value is array accessible.
     *
     * @param  mixed $value
     * @return bool
     */
    public static function accessible($value)
    {
        return is_array($value) || $value instanceof ArrayAccess;
    }

    /**
     * Add an element to an array using "dot" notation if it doesn't exist.
     *
     * @param  array  $array
     * @param  string $key
     * @param  mixed  $value
     * @return array
     */
    public static function add($array, $key, $value)
    {
        if (is_null(static::get($array, $key))) {
            static::set($array, $key, $value);
        }

        return $array;
    }

    /**
     * Collapse an array of arrays into a single array.
     *
     * @param  array $array
     * @return array
     */
    public static function collapse($array)
    {
        $results = [];

        foreach ($array as $values) {
            if ($values instanceof Collection) {
                $values = $values->all();
            } elseif (!is_array($values)) {
                continue;
            }

            $results = array_merge($results, $values);
        }

        return $results;
    }

    /**
     * Divide an array into two arrays. One with keys and the other with values.
     *
     * @param  array $array
     * @return array
     */
    public static function divide($array)
    {
        return [array_keys($array), array_values($array)];
    }

    /**
     * Flatten a multi-dimensional associative array with dots.
     *
     * @param  array  $array
     * @param  string $prepend
     * @return array
     */
    public static function dot($array, $prepend = '')
    {
        $results = [];

        foreach ($array as $key => $value) {
            if (is_array($value) && !empty($value)) {
                $results = array_merge($results, static::dot($value, $prepend . $key . '.'));
            } else {
                $results[$prepend . $key] = $value;
            }
        }

        return $results;
    }

    /**
     * Get all of the given array except for a specified array of items.
     *
     * @param  array        $array
     * @param  array|string $keys
     * @return array
     */
    public static function except($array, $keys)
    {
        static::forget($array, $keys);

        return $array;
    }

    /**
     * Determine if the given key exists in the provided array.
     *
     * @param  \ArrayAccess|array $array
     * @param  string|int         $key
     * @return bool
     */
    public static function exists($array, $key)
    {
        if ($array instanceof ArrayAccess) {
            return $array->offsetExists($key);
        }

        return array_key_exists($key, $array);
    }

    /**
     * Return the first element in an array passing a given truth test.
     *
     * @param  array         $array
     * @param  callable|null $callback
     * @param  mixed         $default
     * @return mixed
     */
    public static function first($array, callable $callback = null, $default = null)
    {
        if (is_null($callback)) {
            if (empty($array)) {
                return value($default);
            }

            foreach ($array as $item) {
                return $item;
            }
        }

        foreach ($array as $key => $value) {
            if (call_user_func($callback, $value, $key)) {
                return $value;
            }
        }

        return value($default);
    }

    /**
     * Return the last element in an array passing a given truth test.
     *
     * @param  array         $array
     * @param  callable|null $callback
     * @param  mixed         $default
     * @return mixed
     */
    public static function last($array, callable $callback = null, $default = null)
    {
        if (is_null($callback)) {
            return empty($array) ? value($default) : end($array);
        }

        return static::first(array_reverse($array, true), $callback, $default);
    }

    /**
     * Flatten a multi-dimensional array into a single level.
     *
     * @param  array $array
     * @param  int   $depth
     * @return array
     */
    public static function flatten($array, $depth = INF)
    {
        return array_reduce(
            $array, function ($result, $item) use ($depth) {
                $item = $item instanceof Collection ? $item->all() : $item;

                if (!is_array($item)) {
                    return array_merge($result, [$item]);
                } elseif ($depth === 1) {
                    return array_merge($result, array_values($item));
                } else {
                    return array_merge($result, static::flatten($item, $depth - 1));
                }
            }, []
        );
    }

    /**
     * Remove one or many array items from a given array using "dot" notation.
     *
     * @param  array        $array
     * @param  array|string $keys
     * @return void
     */
    public static function forget(&$array, $keys)
    {
        $original = &$array;

        $keys = (array)$keys;

        if (count($keys) === 0) {
            return;
        }

        foreach ($keys as $key) {
            // if the exact key exists in the top-level, remove it
            if (static::exists($array, $key)) {
                unset($array[$key]);

                continue;
            }

            $parts = explode('.', $key);

            // clean up before each pass
            $array = &$original;

            while (count($parts) > 1) {
                $part = array_shift($parts);

                if (isset($array[$part]) && is_array($array[$part])) {
                    $array = &$array[$part];
                } else {
                    continue 2;
                }
            }

            unset($array[array_shift($parts)]);
        }
    }

    /**
     * Get an item from an array using "dot" notation.
     *
     * @param  \ArrayAccess|array $array
     * @param  string             $key
     * @param  mixed              $default
     * @return mixed
     */
    public static function get($array, $key, $default = null)
    {
        if (!static::accessible($array)) {
            return value($default);
        }

        if (is_null($key)) {
            return $array;
        }

        if (static::exists($array, $key)) {
            return $array[$key];
        }

        foreach (explode('.', $key) as $segment) {
            if (static::accessible($array) && static::exists($array, $segment)) {
                $array = $array[$segment];
            } else {
                return value($default);
            }
        }

        return $array;
    }

    /**
     * Check if an item or items exist in an array using "dot" notation.
     *
     * @param  \ArrayAccess|array $array
     * @param  string|array       $keys
     * @return bool
     */
    public static function has($array, $keys)
    {
        if (is_null($keys)) {
            return false;
        }

        $keys = (array)$keys;

        if (!$array) {
            return false;
        }

        if ($keys === []) {
            return false;
        }

        foreach ($keys as $key) {
            $subKeyArray = $array;

            if (static::exists($array, $key)) {
                continue;
            }

            foreach (explode('.', $key) as $segment) {
                if (static::accessible($subKeyArray) && static::exists($subKeyArray, $segment)) {
                    $subKeyArray = $subKeyArray[$segment];
                } else {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * Determines if an array is associative.
     *
     * An array is "associative" if it doesn't have sequential numerical keys beginning with zero.
     *
     * @param  array $array
     * @return bool
     */
    public static function isAssoc(array $array)
    {
        $keys = array_keys($array);

        return array_keys($keys) !== $keys;
    }

    /**
     * Get a subset of the items from the given array.
     *
     * @param  array        $array
     * @param  array|string $keys
     * @return array
     */
    public static function only($array, $keys)
    {
        return array_intersect_key($array, array_flip((array)$keys));
    }

    /**
     * Pluck an array of values from an array.
     *
     * @param  array             $array
     * @param  string|array      $value
     * @param  string|array|null $key
     * @return array
     */
    public static function pluck($array, $value, $key = null)
    {
        $results = [];

        list($value, $key) = static::explodePluckParameters($value, $key);

        foreach ($array as $item) {
            $itemValue = data_get($item, $value);

            // If the key is "null", we will just append the value to the array and keep
            // looping. Otherwise we will key the array using the value of the key we
            // received from the developer. Then we'll return the final array form.
            if (is_null($key)) {
                $results[] = $itemValue;
            } else {
                $itemKey = data_get($item, $key);

                $results[$itemKey] = $itemValue;
            }
        }

        return $results;
    }

    /**
     * Explode the "value" and "key" arguments passed to "pluck".
     *
     * @param  string|array      $value
     * @param  string|array|null $key
     * @return array
     */
    protected static function explodePluckParameters($value, $key)
    {
        $value = is_string($value) ? explode('.', $value) : $value;

        $key = is_null($key) || is_array($key) ? $key : explode('.', $key);

        return [$value, $key];
    }

    /**
     * Push an item onto the beginning of an array.
     *
     * @param  array $array
     * @param  mixed $value
     * @param  mixed $key
     * @return array
     */
    public static function prepend($array, $value, $key = null)
    {
        if (is_null($key)) {
            array_unshift($array, $value);
        } else {
            $array = [$key => $value] + $array;
        }

        return $array;
    }

    /**
     * Get a value from the array, and remove it.
     *
     * @param  array  $array
     * @param  string $key
     * @param  mixed  $default
     * @return mixed
     */
    public static function pull(&$array, $key, $default = null)
    {
        $value = static::get($array, $key, $default);

        static::forget($array, $key);

        return $value;
    }

    /**
     * Set an array item to a given value using "dot" notation.
     *
     * If no key is given to the method, the entire array will be replaced.
     *
     * @param  array  $array
     * @param  string $key
     * @param  mixed  $value
     * @return array
     */
    public static function set(&$array, $key, $value)
    {
        if (is_null($key)) {
            return $array = $value;
        }

        $keys = explode('.', $key);

        while (count($keys) > 1) {
            $key = array_shift($keys);

            // If the key doesn't exist at this depth, we will just create an empty array
            // to hold the next value, allowing us to create the arrays to hold final
            // values at the correct depth. Then we'll keep digging into the array.
            if (!isset($array[$key]) || !is_array($array[$key])) {
                $array[$key] = [];
            }

            $array = &$array[$key];
        }

        $array[array_shift($keys)] = $value;

        return $array;
    }

    /**
     * Shuffle the given array and return the result.
     *
     * @param  array $array
     * @return array
     */
    public static function shuffle($array)
    {
        shuffle($array);

        return $array;
    }

    /**
     * Sort the array using the given callback or "dot" notation.
     *
     * @param  array           $array
     * @param  callable|string $callback
     * @return array
     */
    public static function sort($array, $callback)
    {
        return Collection::make($array)->sortBy($callback)->all();
    }

    /**
     * Recursively sort an array by keys and values.
     *
     * @param  array $array
     * @return array
     */
    public static function sortRecursive($array)
    {
        foreach ($array as &$value) {
            if (is_array($value)) {
                $value = static::sortRecursive($value);
            }
        }

        if (static::isAssoc($array)) {
            ksort($array);
        } else {
            sort($array);
        }

        return $array;
    }

    /**
     * Filter the array using the given callback.
     *
     * @param  array    $array
     * @param  callable $callback
     * @return array
     */
    public static function where($array, callable $callback)
    {
        return array_filter($array, $callback, ARRAY_FILTER_USE_BOTH);
    }

    /**
     * If the given value is not an array, wrap it in one.
     *
     * @param  mixed $value
     * @return array
     */
    public static function wrap($value)
    {
        return !is_array($value) ? [$value] : $value;
    }
}
