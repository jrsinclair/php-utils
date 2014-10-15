<?php
/**
 * Utility Functions.
 *
 * Includes handy array functions that I wish existed, and other things.
 *
 * @author James Sinclair <jrsinclair@gmail.com>
 */


/**
 * Get First PCRE match.
 *
 * Returns the first parenthesis match from a
 * perl-compatible-regular-expression.
 *
 * @param string $pattern The pattern to search for (must contain one set of
 *                        parentheses).
 * @param string $str     The string to search for a match.
 *
 * @return string Returns the first match, or false if there is no match.
 */
function pregFirst($pattern, $str)
{
    $num = preg_match($pattern, $str, $matches);
    if (($num !== 0) && ($num !== FALSE) && (count($matches) > 1)) {
        return $matches[1];
    }

    return FALSE;

}//end pregFirst()


/**
 * Array Pluck.
 * 
 * Pluck the same key from an array of associative arrays and return an array.
 * Modified from the post by 'kelly m' at
 * http://www.php.net/manual/en/function.array-map.php#96269
 *
 * @param string $key   The key to pluck.
 * @param array  $input The input array of arrays to pluck from.
 *
 * @return array
 */
function arrayPluck($key, array $input)
{
    // If the input is not right, return an empty array.
    if ((is_array($key) === TRUE)
        || (is_array($input) === FALSE)
    ) {
        return array();
    }

    $array = array();
    foreach ($input as $v) {
        if (array_key_exists($key, $v) === TRUE) {
            $array[] = $v[$key];
        }
    }

    return $array;

}//end arrayPluck()


/**
 * Write to temp file.
 *
 * Write the given content to a temporary file and return the file path.
 *
 * @param string $content The content to write to the file.
 * @param string $suffix  An optional filename suffix.
 *
 * @return string
 */
function writeToTempFile($content, $suffix='txt')
{
    $tmpfile = tempnam('/tmp', 'squish');
    rename($tmpfile, $tmpfile.'.'.$suffix);
    $tmpfile = $tmpfile.'.'.$suffix;
    file_put_contents($tmpfile, $content);
    return $tmpfile;

}//end writeToTempFile()


/**
 * Flatten.
 *
 * Flattens an array, but preserves keys. See
 * http://stackoverflow.com/questions/1319903/how-to-flatten-a-multidimensional-array
 * for the source of the script.
 *
 * @param array $array The array to flatten.
 *
 * @return array
 */
function flatten(array $array)
{
    $return = array();
    array_walk_recursive(
        $array,
        function ($a, $b) use (&$return) {
            $return[$b] = $a;
        }
    );
    return $return;

}//end flatten()


/**
 * Case Insensitive in_array().
 *
 * Code taken from the PHP manual comments:
 * http://php.net/manual/en/function.in-array.php#89256
 *
 * @param string $needle   A string to search for.
 * @param array  $haystack The array to search.
 *
 * @return boolean
 */
function inArrayI($needle, array $haystack)
{
    return in_array(strtolower($needle), array_map('strtolower', $haystack));

}//end inArrayI()


/**
 * Case Insensitive array_search().
 *
 * Code taken from the PHP manual comments:
 * http://us2.php.net/manual/en/function.array-search.php#101869
 *
 * @param string $needle   A string to search for.
 * @param array  $haystack The array to search.
 *
 * @return mixed The key of the matched value.
 */
function arraySearchI($needle, array $haystack)
{
    return array_search(strtolower($needle), array_map('strtolower', $haystack));

}//end arraySearchI()


/**
 * Array Prefix.
 *
 * Prefix each string in the given array with a given string.
 *
 * @param string $prefix The prefix to use.
 * @param array  $arr    The array of strings to add the prefix to.
 *
 * @return array
 */
function arrayPrefix($prefix, array $arr)
{
    if (is_array($arr) === FALSE) {
        return FALSE;
    }

    $ret = array();
    foreach ($arr as $val) {
        $ret[] = $prefix.$val;
    }

    return $ret;

}//end arrayPrefix()


/**
 * Array Prefix Keys.
 *
 * @param string $prefix The prefix to use.
 * @param array  $arr    The array with keys to add the prefix to.
 *
 * @return array
 */
function arrayPrefixKeys($prefix, array $arr)
{
    $keys = arrayPrefix($prefix, array_keys($arr));
    return array_combine($keys, array_values($arr));

}//end arrayPrefixKeys()


/**
 * Filter an array by keys from another array.
 *
 * Returns an array that has the key/value pairs from $data only if the key is
 * present in $keys. Solution copied from
 * http://stackoverflow.com/questions/4240129/get-array-values-by-keys
 *
 * @param array $data The source data.
 * @param array $keys The keys to be selected.
 *
 * @return array
 */
function arrayFilterByKeys(array $data, array $keys)
{
    return array_intersect_key($data, array_flip($keys));

}//end arrayFilterByKeys()

