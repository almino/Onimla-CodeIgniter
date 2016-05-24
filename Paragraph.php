<?php

namespace Onimla\HTML;

<<<<<<< HEAD
=======
require_once 'Element.class.php';

>>>>>>> 90aad9634985523ab678ee76f555d4bc433df7ca
class Paragraph extends Element {

    public function __construct($text = FALSE, $class = FALSE) {
        parent::__construct('p');
        $this->addClass($class);
        $this->text($text);
        $this->selfClose(FALSE);
    }

}
