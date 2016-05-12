<?php

namespace Onimla\HTML;

require_once 'Element.class.php';

class Anchor extends Element {

    public function __construct($text, $title = FALSE) {
        parent::__construct('a');
        $this->text();
        $this->title($title);
        $this->selfClose(FALSE);
    }

    public function href($url = FALSE) {
        return $this->attr('href', $url);
    }

}
