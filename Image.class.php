<?php

namespace Onimla\HTML;

require_once 'Element.class.php';

class Image extends Element {

    function __construct($src, $alt = FALSE) {
        parent::__construct('img');
        $this->src($src);
        $this->alt($alt);
    }

    function src($value = FALSE) {
        return $this->attr('src', $value);
    }

    function alt($value = FALSE) {
        return $this->attr('alt', $value);
    }

}
