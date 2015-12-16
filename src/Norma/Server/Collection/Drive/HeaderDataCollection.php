<?php
namespace Norma\Server\Collection\Drive;

/**
 * HeaderDataCollection
 *
 * A DataCollection for HTTP headers
 *
 * @uses        DataCollection
 * @package     Klein\DataCollection
 */
class HeaderDataCollection extends DataCollection
{

    /**
     * Methods
     */

    /**
     * Constructor
     *
     * @override (doesn't call our parent)
     * @param array $headers The headers of this collection
     * @access public
     */
    public function __construct(array $headers = array())
    {
        foreach ($headers as $key => $value) {
            $this->set($key, $value);
        }
    }

    /**
     * Get a header
     *
     * {@inheritdoc}
     *
     * @see DataCollection::get()
     * @param  string $key         The name of the header to return
     * @param  mixed  $default_val The default value of the header if it contains no value
     * @access public
     * @return mixed
     */
    public function get($key, $default_val = null)
    {
        $key = static::normalizeName($key);

        return parent::get($key, $default_val);
    }

    /**
     * Set a header
     *
     * {@inheritdoc}
     *
     * @see DataCollection::set()
     * @param  string               $key   The name of the header to set
     * @param  mixed                $value The value of the header to set
     * @access public
     * @return HeaderDataCollection
     */
    public function set($key, $value)
    {
        $key = static::normalizeName($key);

        return parent::set($key, $value);
    }

    /**
     * Check if a header exists
     *
     * {@inheritdoc}
     *
     * @see DataCollection::exists()
     * @param  string  $key The name of the header
     * @access public
     * @return boolean
     */
    public function exists($key)
    {
        $key = static::normalizeName($key);

        return parent::exists($key);
    }

    /**
     * Remove a header
     *
     * {@inheritdoc}
     *
     * @see DataCollection::remove()
     * @param  string $key The name of the header
     * @access public
     * @return void
     */
    public function remove($key)
    {
        $key = static::normalizeName($key);

        parent::remove($key);
    }

    /**
     * Normalize a header name by formatting it in a standard way
     *
     * This is useful since PHP automatically capitalizes and underscore
     * separates the words of headers
     *
     * @link http://www.w3.org/Protocols/rfc2616/rfc2616-sec4.html#sec4.2
     * @param  string  $name           The name ("field") of the header
     * @param  boolean $make_lowercase Whether or not to lowercase the name
     * @static
     * @access public
     * @return string
     */
    public static function normalizeName($name, $make_lowercase = true)
    {
        /**
         * Lowercasing header names allows for a more uniform appearance,
         * however header names are case-insensitive by specification
         */
        if ($make_lowercase) {
            $name = strtolower($name);
        }

        // Do some formatting and return
        return str_replace(
            array(' ', '_'),
            '-',
            trim($name)
        );
    }
}
