<?php

namespace Onimla\HTML\Attribute;

require_once implode(DIRECTORY_SEPARATOR, array(
            substr(__DIR__, 0, strpos(__DIR__, 'Onimla') + 11),
            'Attribute.class.php',
        ));

/**
 * Class attribute for an HTML element.
 *
 * @author AlminoMelo at gmail.com
 */
class Klass extends \Onimla\HTML\Attribute {

    protected $value = array();

    public function __construct($class = FALSE) {
        parent::__construct('class');
        $this->setOutput('safe');
        if (func_num_args() > 0) {
            call_user_func_array(array($this, 'addValue'), func_get_args());
        }
    }

    public function __toString() {
        if (strlen($this->getValue(TRUE)) < 1) {
            return '';
        }

        return parent::__toString();
    }

    public function selector() {
        $value = $this->getValue();
        if (strlen($value) < 1) {
            return '';
        }

        #return '.' . implode('.', preg_split('/\s/', $value, -1, PREG_SPLIT_NO_EMPTY));
        return '.' . implode('.', explode(' ', $value));
    }

    public function getValue($output = TRUE) {
        $values = array_filter(array_unique($this->value), 'strlen');

        if ($output === TRUE) {
            return implode(' ', array_map(array(__CLASS__, 'safeValue'), $values));
        }

        return parent::getValue($output);
    }

    public function setValue($value) {
        if (is_array($value)) {
            $this->value = $value;
        } else {
            $this->value = array($value);
        }
    }

    public function addValue($value) {
        $this->value = array_merge($this->value, \Onimla\HTML\Node::arrayFlatten(func_get_args()));
        return $this;
    }

    public function addClass($value) {
        return call_user_func_array(array($this, 'addValue'), func_get_args());
    }

    public function removeClass($class) {
        foreach (\Onimla\HTML\Node::arrayFlatten(func_get_args()) as $class) {
            $key = array_search($class, $this->value);
            if ($key !== FALSE) {
                unset($this->value[$key]);
            }
        }
        
        return $this;
    }

    public static function safeValue($value) {
        return preg_replace('/[^_a-zA-Z0-9\-]/', '', $value);
    }

}
