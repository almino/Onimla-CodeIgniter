<?php

namespace Onimla\CodeIgniter\SemanticUI;

use Onimla\SemanticUI\Message;
use Onimla\SemanticUI\Form\Field;
use Onimla\HTML\Input;
use Onimla\SemanticUI\Icon\WarningSign as Icon;

class ValidationError extends Message {

    public function __construct($field = FALSE) {
        if ($field instanceof Field OR $field instanceof Input) {
            $field = $field->name();
        }

        $error = trim(form_error($field, ' ', ' '));
        
        $pre = strpos($error, '<q>');
        $pos = strpos($error, '</q>');

        parent::__construct($pre);

        # Atributos ================================================================== #
        $this->error();
        $this->container->getClass('visible');

        # Árvore ===================================================================== #
        $this->icon(new Icon);
    }

}
